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

    $approver->setApproverType(1);

    $approver->setApproverName($name);
号
    $approver->setApproverMobile($mobile);

    $approver->setNotifyType("sms");

    return $approver;
}

// 打包企业签署方参与者信息
function BuildOrganizationFlowCreateApprover($name, $mobile, $organizationName)
{
    // 签署参与者信息
    $approver = new FlowCreateApprover();

    $approver->setApproverType(0);

    $approver->setApproverName($name);

    $approver->setApproverMobile($mobile);

    $approver->setOrganizationName($organizationName);

    $approver->setNotifyType("none");

    return $approver;
}

// 打包企业静默签署方参与者信息
function BuildServerSignFlowCreateApprover()
{
    // 签署参与者信息
    $approver = new FlowCreateApprover();

    $approver->setApproverType(3);

    return $approver;
}
