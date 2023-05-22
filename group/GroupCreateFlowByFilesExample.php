<?php
require_once(__DIR__ . '/./GroupCreateFlowByFiles.php');

use TencentCloud\Ess\V20201111\Models\ApproverInfo;
use TencentCloud\Ess\V20201111\Models\Component;
use TencentCloud\Common\Exception\TencentCloudSDKException;

/**
 * 主企业代子企业使用文件发起合同的简单样例，如需更详细的参数使用说明，请参考 flowmanage/CreateFlowByFilesApi
 * 注意：使用集团代发起功能，需要主企业和子企业均已加入集团，并且主企业OperatorUserId对应人员被赋予了对应操作权限
 */
try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

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

    $resp = GroupCreateFlowByFiles(Config::operatorUserId, $flowName, $approvers, $fileId, $proxyOrganizationId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
