#!/bin/bash


cgi-fcgi -v  > /dev/null 2>&1|| yum --enablerepo=epel install fcgi -y  > /dev/null 2>&1

echo '<?php opcache_reset(); echo "ok\n";' > /tmp/php-fpm-opcache-reset.php;
SCRIPT_FILENAME=/tmp/php-fpm-opcache-reset.php \
REQUEST_METHOD=GET \
cgi-fcgi -bind -connect /var/run/wepro-addev-php-fpm.sock;
rm -f /tmp/php-fpm-opcache-reset.php;
