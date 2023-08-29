<?php
require_once(__DIR__ . '/./CreateFlowSignReview.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 提交企业签署流程审批结果
try {

    $flowId = '********************************';

    $reviewType = '********************************';

    $reviewMessage = '********************************';


    $resp = CreateFlowSignReview(Config::operatorUserId, $flowId, $reviewType, $reviewMessage);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
