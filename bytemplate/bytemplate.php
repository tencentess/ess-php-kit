<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use TencentCloud\Ess\V20201111\Models\FlowCreateApprover;

// 构造签署人 - 以B2B2C为例, 实际请根据自己的场景构造签署方
function BuildFlowCreateApprovers()
{
    // 个人签署方构造参数
    $personName = '********************';
    $personMobile = '********************';

    // 企业签署方构造参数
    $organizationName = '********************';
    $organizationUserName = '********************';
    $organizationUserMobile = '********************';

    $approvers = [];
    // 此处添加的签署人类型、数量、顺序需要和模板中的配置保持一致
    array_push($approvers,
        BuildServerSignFlowCreateApprover(), // 发起方企业静默签署
        BuildOrganizationFlowCreateApprover($organizationUserName, $organizationUserMobile, $organizationName), // 另一家企业签署方
        BuildPersonFlowCreateApprover($personName, $personMobile) // 个人签署方
    );

    return $approvers;
}

// 打包个人签署方参与者信息
function BuildPersonFlowCreateApprover($name, $mobile)
{
    // 签署参与者信息
    // 个人签署方
    $approver = new FlowCreateApprover();
    // 参与者类型：
    // 0：企业
    // 1：个人
    // 3：企业静默签署
    // 注：类型为3（企业静默签署）时，此接口会默认完成该签署方的签署。
    $approver->setApproverType(1);
    // 本环节需要操作人的名字
    $approver->setApproverName($name);
    // 本环节需要操作人的手机号
    $approver->setApproverMobile($mobile);
    // sms--短信，none--不通知
    $approver->setNotifyType("sms");

    return $approver;
}

// 打包企业签署方参与者信息
function BuildOrganizationFlowCreateApprover($name, $mobile, $organizationName)
{
    // 签署参与者信息
    $approver = new FlowCreateApprover();
    // 参与者类型：
    // 0：企业
    // 1：个人
    // 3：企业静默签署
    // 注：类型为3（企业静默签署）时，此接口会默认完成该签署方的签署。
    // 企业签署方
    $approver->setApproverType(0);
    // 本环节需要操作人的名字
    $approver->setApproverName($name);
    // 本环节需要操作人的手机号
    $approver->setApproverMobile($mobile);
    // 本环节需要企业操作人的企业名称
    $approver->setOrganizationName($organizationName);
    // sms--短信，none--不通知
    $approver->setNotifyType("none");

    return $approver;
}

// 打包企业静默签署方参与者信息
function BuildServerSignFlowCreateApprover()
{
    // 签署参与者信息
    $approver = new FlowCreateApprover();
    // 参与者类型：
    // 0：企业
    // 1：个人
    // 3：企业静默签署
    // 注：类型为3（企业静默签署）时，此接口会默认完成该签署方的签署。
    // 企业静默签署方
    $approver->setApproverType(3);

    return $approver;
}
