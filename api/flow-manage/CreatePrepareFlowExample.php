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
    // 参与者类型：
    // 0：企业
    // 1：个人
    // 3：企业静默签署
    // 注：类型为3（企业静默签署）时，此接口会默认完成该签署方的签署。
    $approver->setApproverType(1);
    // 本环节需要操作人的名字
    $approver->setApproverName("********************************");
    // 本环节需要操作人的手机号
    $approver->setApproverMobile("********************************");

    $approvers = [];
    array_push($approvers, $approver);

    $resourceId = "************************";

    $resp = CreatePrepareFlow(Config::operatorUserId, $flowName, $resourceId, $approvers);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
