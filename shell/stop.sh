#!/bin/bash
ps -eaf |grep "proxy" | grep -v "grep"| grep -v "polipo"| awk '{print $2}'|xargs kill -9
