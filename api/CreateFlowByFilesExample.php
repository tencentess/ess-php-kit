<?php
require_once(__DIR__ . '/./CreateFlowByFiles.php');

use TencentCloud\Ess\V20201111\Models\ApproverInfo;
use TencentCloud\Ess\V20201111\Models\Component;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// 通过上传后的pdf资源编号来创建待签署的合同流程调用样例
try {
    // 从UploadFiles接口获取到的fileId
    $fileId = "********************************";

    // 签署流程名称,最大长度200个字符
    $flowName = '我的第一份文件合同';

    // 签署参与者信息
    // 个人签署方
    $approver = new ApproverInfo();
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

    // 签署人对应的签署控件
    $component = new Component();
    // 参数控件Y位置，单位pt
    $component->setComponentPosY(472.78125);
    // 参数控件X位置，单位pt
    $component->setComponentPosX(146.15625);
    // 参数控件宽度，单位pt
    $component->setComponentWidth(112);
    // 参数控件高度，单位pt
    $component->setComponentHeight(40);
    // 控件所属文件的序号（取值为：0-N）
    $component->setFileIndex(0);
    // 可选类型为：
    // SIGN_SEAL - 签署印章控件
    // SIGN_DATE - 签署日期控件
    // SIGN_SIGNATURE - 手写签名控件
    $component->setComponentType("SIGN_SIGNATURE");
    // 参数控件所在页码，取值为：1-N
    $component->setComponentPage(1);

    // 本环节操作人签署控件配置，为企业静默签署时，只允许类型为SIGN_SEAL（印章）和SIGN_DATE（日期）控件，并且传入印章编号
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
    // 发起方需要填写的控件
    $component = new Component();
    // 参数控件Y位置，单位pt
    $component->setComponentPosY(472.78125);
    // 参数控件X位置，单位pt
    $component->setComponentPosX(146.15625);
    // 参数控件宽度，单位pt
    $component->setComponentWidth(112);
    // 参数控件高度，单位pt
    $component->setComponentHeight(40);
    // 控件所属文件的序号（取值为：0-N）
    $component->setFileIndex(0);
    // 可选类型为：
    // TEXT - 内容文本控件
    // MULTI_LINE_TEXT - 多行文本控件
    // CHECK_BOX - 勾选框控件
    // ATTACHMENT - 附件
    // SELECTOR - 选择器
    $component->setComponentType("TEXT");
    // 填写信息为：
    // TEXT - 文本内容
    // MULTI_LINE_TEXT - 文本内容
    // CHECK_BOX - true/false
    // ATTACHMENT - UploadFiles接口上传返回的fileId
    // SELECTOR - 文本内容
    $component->setComponentValue("content");
    // 参数控件所在页码，取值为：1-N
    $component->setComponentPage(1);

    $components = [];
    array_push($components, $component);

}
