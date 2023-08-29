<?php
require_once(__DIR__ . '/./GroupDescribeOrganizationSeals.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    $limit = 10;

    $resp = DescribeOrganizationSeals(Config::operatorUserId, $limit, $proxyOrganizationId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
