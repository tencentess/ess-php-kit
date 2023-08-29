<?php
require_once(__DIR__ . '/./GroupCreateFlowByFiles.php');

use TencentCloud\Ess\V20201111\Models\ApproverInfo;
use TencentCloud\Ess\V20201111\Models\Component;
use TencentCloud\Common\Exception\TencentCloudSDKException;

try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    $fileId = "********************************";

    $flowName = '我的第一份文件合同';

    // 签署参与者信息
    // 个人签署方
    $approver = new ApproverInfo();

    $approver->setApproverType(1);

    $approver->setApproverName("********************************");

    $approver->setApproverMobile("********************************");

    // 签署人对应的签署控件
    $component = new Component();

    $component->setComponentPosY(472.78125);

    $component->setComponentPosX(146.15625);

    $component->setComponentWidth(112);

    $component->setComponentHeight(40);

    $component->setFileIndex(0);
 
    $component->setComponentType("SIGN_SIGNATURE");

    $component->setComponentPage(1);

    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    $approvers = [];
    array_push($approvers, $approver);

    $resp = GroupCreateFlowByFiles(Config::operatorUserId, $flowName, $approvers, $fileId, $proxyOrganizationId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
