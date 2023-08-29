<?php
require_once(__DIR__ . '/./CreateFlowByFiles.php');

use TencentCloud\Ess\V20201111\Models\ApproverInfo;
use TencentCloud\Ess\V20201111\Models\Component;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// 通过上传后的pdf资源编号来创建待签署的合同流程调用样例
try {
    $fileId = "********************************";


    $flowName = '我的第一份文件合同';

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

    $resp = CreateFlowByFileId(Config::operatorUserId, $flowName, $approvers, $fileId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}

// 构建需要发起方填写的控件，在发起时直接给控件进行赋值
function BuildComponents() {

    $component = new Component();

    $component->setComponentPosY(472.78125);

    $component->setComponentPosX(146.15625);

    $component->setComponentWidth(112);

    $component->setComponentHeight(40);

    $component->setFileIndex(0);

    $component->setComponentType("TEXT");

    $component->setComponentValue("content");

    $component->setComponentPage(1);

    $components = [];
    array_push($components, $component);

}
