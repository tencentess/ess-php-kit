<?php
require_once(__DIR__ . '/./GroupCreateFlowByTemplate.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\FlowCreateApprover;

try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    $templateId = '********************************';

    $flowName = '**************';
    // 构造签署人
    // 此块代码中的$approvers仅用于快速发起一份合同样例
    $personName = "****************"; // 个人签署方的姓名
    $personMobile = "****************"; // 个人签署方的手机号

    // 签署参与者信息
    // 个人签署方
    $approver = new FlowCreateApprover();

    $approver->setApproverType(1);

    $approver->setApproverName($personName);

    $approver->setApproverMobile($personMobile);

    $approver->setNotifyType("sms");

    $approvers = [];
    array_push($approvers, $approver);

    $createFlowResp = GroupCreateFlow(Config::operatorUserId, $flowName, $approvers, $proxyOrganizationId);
    $flowId = $createFlowResp->FlowId;

    print_r($createFlowResp);

    // 创建电子文档
    $createDocumentResp = GroupCreateDocument(Config::operatorUserId, $flowId, Config::templateId, $flowName, $proxyOrganizationId);

    print_r($createDocumentResp);

    // 等待文档异步合成
    sleep(3);

    // 开启流程
    $startFlowResp = GroupStartFlow(Config::operatorUserId, $flowId, $proxyOrganizationId);

    print_r($startFlowResp);

}
catch(TencentCloudSDKException $e) {
    echo $e;
}
