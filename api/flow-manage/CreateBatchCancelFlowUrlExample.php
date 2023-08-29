<?php
require_once(__DIR__ . '/./CreateBatchCancelFlowUrl.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 获取批量撤销签署流程链接
try {

    $flowId1 = '********************************';
    $flowId2 = '********************************';

    $flowIds = [];
    array_push($flowIds, $flowId1);
    array_push($flowIds, $flowId2);

    $resp = CreateBatchCancelFlowUrl(Config::operatorUserId, $flowIds);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
