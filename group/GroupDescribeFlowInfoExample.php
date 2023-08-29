<?php
require_once(__DIR__ . '/./GroupDescribeFlowInfo.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;


try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    $flowId = '********************************';

    $resp = GroupDescribeFlowInfo(Config::operatorUserId, $flowId, $proxyOrganizationId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}