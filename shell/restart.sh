#!/bin/bash
rm -rf swoole.log
touch swoole.log
ps -eaf |grep "proxy" | grep -v "grep"| grep -v "polipo"| awk '{print $2}'|xargs kill -9
#svn up
php server_proxy.php start
tail -f -b100 swoole.log

