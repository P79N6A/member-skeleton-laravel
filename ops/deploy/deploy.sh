#!/bin/sh

#############################################################
# deploy script for WePro
# author:lamper
# date: 2018-05-04
#############################################################


DEPLOY_TYPE=$1
DEV_DIST_PATH=$2
SERVICE_NAME="wepro.addev.com"
SERVICE_PORT="8084"
APP_NAME="production"
if [ "$DEPLOY_TYPE" == "test" ] || [ "$DEPLOY_TYPE" == "test_without_cov" ]; then	
	DOMAIN="test.$SERVICE_NAME"
	APP_NAME="test"

elif [ "$DEPLOY_TYPE" == "pretest" ]; then
	DOMAIN="pretest.$SERVICE_NAME"
	APP_NAME="pretest"
elif [ "$DEPLOY_TYPE" == "release" ]; then
	DOMAIN="$SERVICE_NAME"
	APP_NAME="production"
elif [ "$DEPLOY_TYPE" == "pre" ]; then
	DOMAIN="pre.$SERVICE_NAME"
	APP_NAME="preview"
else
	echo "Useage: ./deploy.sh [release|test|pretest|pre] /path/to/source"
	exit 1
fi

if [ ! $DEV_DIST_PATH ];then
	echo "Useage: ./deploy.sh [release|test|pretest|pre] /path/to/source"
	exit 1
fi

DEPLOY_PATH="/data/web/websites/$DOMAIN"

if [ ! $DEPLOY_PATH ]; then
	echo "Useage: ./deploy.sh [release|test|pretest|pre] /path/to/source"
	exit 1
fi

#setting env name
echo "Setting app env name config:'$APP_NAME' to $DEV_DIST_PATH/.app_name"
echo $APP_NAME>$DEV_DIST_PATH/.app_name



echo "Start deploy from $DEV_DIST_PATH to $DEPLOY_PATH (use:ln -s $DEV_DIST_PATH $DEPLOY_PATH)"

yum install fcgi -y >/dev/null
mkdir -p  `dirname $DEPLOY_PATH` #make parent dir if not exists

chown -R root:users $DEV_DIST_PATH
chmod -R g+w $DEV_DIST_PATH
chmod -R o+w $DEV_DIST_PATH
rm -fr $DEPLOY_PATH
ln -s $DEV_DIST_PATH $DEPLOY_PATH

#init log and appdata path
mkdir -p /data/logs/$SERVICE_NAME /data/logs/nginx/ /data/logs/web/ /data/scripts/ /data/logs/php/ /data/appdatas/nginx/nginx_temp/ /data/appdatas/nginx/temp/nginx_client;
chown -R nobody:nobody /data/logs/$SERVICE_NAME /data/logs/nginx/ /data/logs/web/ /data/appdatas/nginx/nginx_temp/ /data/appdatas/nginx/temp/nginx_client /data/logs/php/;
chown -R nobody:nobody $DEV_DIST_PATH/storage



NGINX_CONF="/data/web/conf/nginx/$DOMAIN.conf"
	
echo "
gzip on;
gzip_http_version 1.0;
gzip_min_length 1k;
gzip_buffers 32 4k;
gzip_comp_level 4;
gzip_types text/plain application/javascript application/json application/x-javascript text/css application/xml text/javascript application/x-httpd-php;
gzip_vary on;
#gzip_static on;
#gzip_proxied       any;
gzip_disable "MSIE [1-6]\.";

server {
	listen       $SERVICE_PORT default_server;	
	server_name  $DOMAIN ;
	root         $DEPLOY_PATH/public;
	index index.php index.html index.htm;

	location / {
		try_files \$uri \$uri/ /index.php?\$query_string;
	}

	location ~ \\.php$ {
		fastcgi_pass unix:/var/run/wepro-addev-php-fpm.sock;
		fastcgi_pass_request_headers on;
		fastcgi_param SCRIPT_FILENAME \$document_root\$fastcgi_script_name;
		include fastcgi_params;
	}
	location ~ /\\.ht {
		deny all;
	}
	location ~ .*\\.(sql|txt|phtml)$ {
		deny all;
	}


	location ~  ^(.*)\/\.svn|.git|_svn\/{
		try_files $uri $uri/ /index.php ;
	}

	access_log /data/logs/web/${DOMAIN}_access.log;
	error_log /data/logs/web/${DOMAIN}_error.log;
}">$NGINX_CONF

cd $DEV_DIST_PATH/../deploy/;
rsync -az phpetc/ /usr/local/php/etc/;

#docker env have init nginx and fpm
#cp -a  nginx php-fpm  /etc/init.d/;chmod +x  /etc/init.d/php-fpm /etc/init.d/nginx; 

cp -a opc_reset.sh  /data/scripts/;chmod +x /data/scripts/opc_reset.sh;

/etc/init.d/php-fpm configtest
/etc/init.d/nginx configtest

echo "php-fpm restart...."
fpm_pid=`ps ax|grep php-fpm|grep master|awk '{print $1}'`
if [ $fpm_pid>0 ]; then
    /etc/init.d/php-fpm reload
else
    /etc/init.d/php-fpm start
fi

echo "nginx restart...."
nginx_pid=`ps ax|grep nginx|grep master|awk '{print $1}'`
if [ $nginx_pid>0 ]; then
    /etc/init.d/nginx reload
else
    /etc/init.d/nginx start
fi

echo "clear laravel cache"
sh /data/scripts/opc_reset.sh

for d in /data/logs/$DOMAIN/
do
	if [ ! -d $d ];then
		mkdir -p $d
	fi
	chown -R nobody $d
done


#任务机上要重启queue进程
sip=`/sbin/ifconfig eth1 | head -n 2 | tail -n 1 | awk '{match($0,/[0-9]+\.[0-9]+\.[0-9]+\.[0-9]+/); ip = substr($0,RSTART,RLENGTH); print ip}'`
if [ "$sip" == "100.107.155.218" ];then
	echo "Restart Queue...."
	ps ax|grep php |grep artisan|grep queue|grep listen|awk '{print $1}'|xargs kill -9
	sleep 2
	cd $DEPLOY_PATH
	for queue in wepro wepro_order_callback wepro_http_req_callback
	do
		/usr/local/php/bin/php artisan queue:listen --sleep=2 --queue=$queue --tries=4 --timeout=1000 --delay=3 --memory=512&
	done
fi

echo "Success"
echo "Open http://$DOMAIN in your browser to test";
