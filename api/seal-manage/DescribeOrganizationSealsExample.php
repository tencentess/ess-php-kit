<?php
require_once(__DIR__ . '/./DescribeOrganizationSeals.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 查询企业电子印章调用样例
try {
    $limit = 10;

    $resp = DescribeOrganizationSeals(Config::operatorUserId, $limit);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
