<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../api/CreateFlowByFileDirectly.php');
require_once(__DIR__ . '/../api/file-upload-download/DescribeFileUrls.php');

use TencentCloud\Ess\V20201111\Models\ApproverInfo;
use TencentCloud\Ess\V20201111\Models\Component;

// 构造签署人 - 以B2B2C为例, 实际请根据自己的场景构造签署方、控件
function BuildApprovers()
{
    // 个人签署方构造参数
    $personName = '********************';
    $personMobile = '********************';

    // 企业签署方构造参数
    $organizationName = '********************';
    $organizationUserName = '********************';
    $organizationUserMobile = '********************';

    $approvers = [];
    array_push($approvers,
        BuildServerSignApprover(), // 发起方企业静默签署，此处需要在config.php中设置一个持有的印章值serverSignSealId
        BuildOrganizationApprover($organizationUserName, $organizationUserMobile, $organizationName), // 另一家企业签署方
        BuildPersonApprover($personName, $personMobile) // 个人签署方
    );

    return $approvers;
}

// 打包个人签署方参与者信息
function BuildPersonApprover($name, $mobile)
{
    // 签署参与者信息
    // 个人签署方
    $approver = new ApproverInfo();
    $approver->setApproverType(1);
    $approver->setApproverName($name);
    $approver->setApproverMobile($mobile);
    $approver->setNotifyType("sms");

    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(146.15625, 472.78125, 112, 40, 0, "SIGN_SIGNATURE", 1, '');

    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包企业签署方参与者信息
function BuildOrganizationApprover($name, $mobile, $organizationName)
{
    // 签署参与者信息
    $approver = new ApproverInfo();
    $approver->setApproverType(0);
    $approver->setApproverName($name);
    $approver->setApproverMobile($mobile);
    $approver->setOrganizationName($organizationName);
    $approver->setNotifyType("none");

    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(246.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, '');

    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 打包企业静默签署方参与者信息
function BuildServerSignApprover()
{
    // 签署参与者信息
    $approver = new ApproverInfo();

    $approver->setApproverType(3);

    // 模板控件信息
    // 签署人对应的签署控件
    $component = BuildComponent(346.15625, 472.78125, 112, 40, 0, "SIGN_SEAL", 1, Config::serverSignSealId);

    $approver->SignComponents = [];
    array_push($approver->SignComponents, $component);

    return $approver;
}

// 构建（签署）控件信息
function BuildComponent($componentPosX, $componentPosY, $componentWidth, $componentHeight,
                        $fileIndex, $componentType, $componentPage, $componentValue)
{
    // 模板控件信息
    // 签署人对应的签署控件
    $component = new Component();

    $component->setComponentPosX($componentPosX);

    $component->setComponentPosY($componentPosY);

    $component->setComponentWidth($componentWidth);

    $component->setComponentHeight($componentHeight);
    // 控件所属文件的序号（取值为：0-N）
    $component->setFileIndex($fileIndex);

    $component->setComponentType($componentType);
    // 参数控件所在页码，取值为：1-N
    $component->setComponentPage($componentPage);
    // 自动签署所对应的印章Id
    $component->setComponentValue($componentValue);

    return $component;
}
