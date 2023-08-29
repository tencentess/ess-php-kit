<?php
require_once(__DIR__ . '/./CreateFlow.php');

use TencentCloud\Ess\V20201111\Models\FlowCreateApprover;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// 创建签署流程调用样例
try {
    $flowName = "我的第一份模版合同";

    // 签署流程参与者信息
    // 个人签署方
    $approver = new FlowCreateApprover();

    $approver->setApproverType(1);

    $approver->setApproverName("********************************");

    $approver->setApproverMobile("********************************");

    $approvers = [];
    array_push($approvers, $approver);


    $resp = CreateFlow(Config::operatorUserId, $flowName, $approvers);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
