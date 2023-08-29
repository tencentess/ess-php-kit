<?php
require_once(__DIR__ . '/./CreatePrepareFlow.php');

use TencentCloud\Ess\V20201111\Models\FlowCreateApprover;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// 创建快速发起流程调用样例
try {
    $flowName = "快速发起流程";

    // 签署流程参与者信息
    // 个人签署方
    $approver = new FlowCreateApprover();

    $approver->setApproverType(1);

    $approver->setApproverName("********************************");

    $approver->setApproverMobile("********************************");

    $approvers = [];
    array_push($approvers, $approver);

    $resourceId = "************************";

    $resp = CreatePrepareFlow(Config::operatorUserId, $flowName, $resourceId, $approvers);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
