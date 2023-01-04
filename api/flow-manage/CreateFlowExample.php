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


    $resp = CreateFlow(Config::operatorUserId, $flowName, $approvers);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
