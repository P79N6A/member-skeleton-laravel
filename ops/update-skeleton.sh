#!/bin/bash

set -e

if [ "$#" -lt 1 ]; then   
echo -e "Usage: `basename $0` [-n project-name] [-c clone-url] [-r remote-url] args\n";  
exit 0 


fi   
while getopts "n:c:r:v:d:h" opt
do  
    case $opt in
    n)
    PARAM_N_FLAG=1
    PARAM_N_VAL=$OPTARG
    cd $PARAM_N_VAL
    ;;  
    c)
    PARAM_C_FLAG=1
    PARAM_C_VAL=$OPTARG

    echo "clone project ..."

    git clone $PARAM_C_VAL

    ;; 
    d)
    echo "remove remote source ..."

    git remote remove upstream
    
    ;;
    v)
    PARAM_V_FLAG=1
    PARAM_V_VAL=$OPTARG

    git checkout $PARAM_V_VAL
    git merge upstream/master
    git push -u origin master

    ;;
    r)
    PARAM_R_FLAG=1
    PARAM_R_VAL=$OPTARG

    echo "add remote source ..."

    git remote add upstream $PARAM_R_VAL

    echo "fetch upstream ..."

    # git fetch upstream
    git fetch upstream master:sync/skeleton

    git checkout -b  origin/sync/skeleton sync/skeleton

    # git merge upstream/master
    git merge upstream/master --allow-unrelated-histories

    git push origin sync/skeleton

    echo "update success ..."

    ;;
    h)  
    cat <<EOF
  update sketeton
      -n  - your project name
      -c  - clone project git url
      -r  - remote upstream git url
      -d  - remove git remote source
      -v  - version of remote git 
      -h  --help  - prints help screen

EOF
    exit 0
    ;;  
    esac  
done  
