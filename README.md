# member-skeleton-laravel

Member Skeleton [Laravel]

### route

```
Optimize route rule
```

### deploy

```
Deploy application script
```

### env | config

```
Muti env config
dev | test | pretest | preview | release 
```

### log
```
LogServiceProvider provider mutiple handle to process logs 
```

### http | gRPC client

```
HttpClient provide Get、Post、Put、Delete、Header、Trace method

gRPC client provide gRPC protocol
```

### hydrators

```
Request Data vilidate module

```

### resource

```
Data Map
```

### repositories

```
Data resources
```

### jobs

```
Queue jobs module
```

### quick start

update log path
update session  save path

```
cd web-skeleton-laravel/dev/public

php -S 0.0.0.0:30010

```

visit http://localhost:30010


### sync project 
```
git clone your-project-url
git remote add upstream http://git.tech.nanhaicorp.com.cn/dd01-member/member-skeleton-laravel.git
git fetch upstream
git merge upstream/master
git push origin master
```

or run shell script (sync):

```
member-skeleton-laravel/ops/update-skeleton.sh  -n project-name  -c clone-project-url  -r  remote-project-url  -v version

```

ex:

update and sync code from skeleton:

```
member-skeleton-laravel/ops/update-skeleton.sh \
-c http://git.tech.nanhaicorp.com.cn/luocheng/fork-test2.git -n fork-test2 \
-r http://git.tech.nanhaicorp.com.cn/dd01-member/member-skeleton-laravel.git \
-v v1.0
```

说明：
1. 先clone 业务project
2. 进入业务project 使用 /ops/update-skeleton.sh -r http://git.tech.nanhaicorp.com.cn/dd01-member/member-skeleton-laravel.git (-v 是指定同步版本)
3. 同步完了后，在项目内发起Merge Requests, 从 sync/skeleton 到开发分支 (推荐)
[ 适用PHP、Go、Python等skeleton ]


