<?php
require_once(__DIR__ . '/./DescribeFlowBriefs.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 查询流程摘要调用样例
try {
    // 需要查询的流程ID列表
    $flowId = '********************************';

    $resp = DescribeFlowBriefs(Config::operatorUserId, $flowId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}