<?php
require_once(__DIR__ . '/./GroupCreateFlowByTemplate.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\FlowCreateApprover;

/**
 * 主企业代子企业使用模板发起合同的简单样例，如需更详细的参数使用说明，请参考 flowmanage 目录下的 CreateFlowApi/CreateDocumentApi/StartFlowApi
 * 注意：使用集团代发起功能，需要主企业和子企业均已加入集团，并且主企业OperatorUserId对应人员被赋予了对应操作权限
 */
try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    // 子企业模板id，需要在控制台查询获取。请勿使用主企业的模板id!
    $templateId = '********************************';

    // 定义合同名
    $flowName = '**************';
    // 构造签署人
    // 此块代码中的$approvers仅用于快速发起一份合同样例
    $personName = "****************"; // 个人签署方的姓名
    $personMobile = "****************"; // 个人签署方的手机号

    // 签署参与者信息
    // 个人签署方
    $approver = new FlowCreateApprover();
    // 参与者类型：
    // 0：企业
    // 1：个人
    // 3：企业静默签署
    // 注：类型为3（企业静默签署）时，此接口会默认完成该签署方的签署。
    // 这里我们设置为1，即身份为个人
    $approver->setApproverType(1);
    // 本环节需要操作人的名字
    $approver->setApproverName($personName);
    // 本环节需要操作人的手机号
    $approver->setApproverMobile($personMobile);
    // 合同发起后是否短信通知签署方进行签署: sms--短信，none--不通知
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
