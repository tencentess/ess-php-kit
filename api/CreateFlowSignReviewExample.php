<?php
require_once(__DIR__ . '/./CreateFlowSignReview.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 提交企业签署流程审批结果
try {
    // 签署流程编号
    $flowId = '********************************';

    // 企业内部审核结果
    //PASS: 通过
    //REJECT: 拒绝
    $reviewType = '********************************';

    // 审核原因
    //当ReviewType 是REJECT 时此字段必填,字符串长度不超过200
    $reviewMessage = '********************************';


    $resp = CreateFlowSignReview(Config::operatorUserId, $flowId, $reviewType, $reviewMessage);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
