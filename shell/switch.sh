#!/bin/bash
version='v2.6'

rm -rf ./service/message
rm -rf ./service/resources/core
rm -rf ./service/resources/sales
rm -rf ./service/resources/customers
rm -rf ./service/resources/contractor
rm -rf ./service/resources/merchant
rm -rf ./service/resources/route

cp -rf ../framework/branches/$version/lib/proto/5/message ./service
cp -rf ../swoole/core/branches/$version/service/resources/core ./service/resources
cp -rf ../swoole/core/branches/$version/service/resources/sales ./service/resources
cp -rf ../swoole/customer/branches/$version/service/resources/customers ./service/resources
cp -rf ../swoole/customer/branches/$version/service/resources/contractor ./service/resources
cp -rf ../swoole/merchant/branches/$version/service/resources/merchant ./service/resources
cp -rf ../swoole/route/branches/$version/service/resources/route ./service/resources
