<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\ApproverInfo;
use TencentCloud\Ess\V20201111\Models\Component;
use TencentCloud\Ess\V20201111\Models\CreateFlowByFilesRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;

function CreateFlowByFileId($operatorUserId, $flowName, $approvers, $fileId)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowByFilesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    $req->FileIds = [];
    $req->FileIds[] = $fileId;

    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    $req->setFlowName($flowName);

    $resp = $client->CreateFlowByFiles($req);

    return $resp;
}

// CreateFlowByFilesExtended CreateFlowByFiles接口的详细参数使用样例，前面简要调用的场景不同，此版本旨在提供可选参数的填入参考。
// 如果您在实现基础场景外有进一步的功能实现需求，可以参考此处代码。
// 注意事项：此处填入参数仅为样例，请在使用时更换为实际值。
function CreateFlowByFilesExtended()
{
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowByFilesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId(Config::operatorUserId);
    $req->setOperator($userInfo);

    // 签署流程名称,最大长度200个字符
    $req->setFlowName("测试合同");

    // 构建签署方信息
    // 注意：文件发起时，签署方不能进行控件填写！！！如果有填写需求，请设置为发起方填写，或者使用模板发起！！！

    // 企业静默签署
    $serverEnt = new ApproverInfo();

    $serverEnt->ApproverType = 3;

    $serverEnt->NotifyType = "sms";
    // 这里可以设置企业方自动签章，分别可以使用坐标、表单域、关键字进行定位
    $serverEnt->SignComponents = [
        // 坐标定位，印章类型，并传入印章Id
        buildComponentNormal("SIGN_SEAL", "**************"),
        // 表单域定位，印章类型，并传入印章Id
        buildComponentKeyword("SIGN_SEAL", "**************"),
        // 关键字定位，印章类型，并传入印章Id
        buildComponentField("SIGN_SEAL", "**************")
    ];

    // 个人签署
    $person = new ApproverInfo();
    $person->ApproverType = 1;
    // 个人身份签署一般设置姓名+手机号，请确保实际签署时使用的信息和此处一致
    // 本环节需要操作人的名字
    $person->ApproverName = "张三";
    // 本环节需要操作人的手机号
    $person->ApproverMobile = "15912345678";

    // 这里可以设置用户进行手动签名，分别可以使用坐标、表单域、关键字进行定位
    $person->SignComponents = [
        // 坐标定位，手写签名类型
        buildComponentNormal("SIGN_SIGNATURE", ""),
        // 表单域定位，手写签名类型
        buildComponentField("SIGN_SIGNATURE", ""),
        // 关键字定位，手写签名类型
        buildComponentKeyword("SIGN_SIGNATURE", "")
    ];

    // 企业签署
    $ent = new ApproverInfo();
    $ent->ApproverType = 0;

    $ent->ApproverName = "李四";
    // 本环节需要操作人的手机号
    $ent->ApproverMobile = "1*********1";

    $ent->OrganizationName = "XXXXX公司";
    // 这里可以设置企业手动签章（如果需要自动请使用静默签署），分别可以使用坐标、表单域、关键字进行定位
    $ent->SignComponents = [
        // 坐标定位，印章类型
        buildComponentNormal("SIGN_SEAL", ""),
        // 表单域定位，印章类型
        buildComponentField("SIGN_SEAL", ""),
        // 关键字定位，印章类型
        buildComponentKeyword("SIGN_SEAL", "")
    ];

    $req->Approvers = [$serverEnt, $person, $ent];


    $req->FileIds = ["*************************"];


    $req->FlowType = "销售合同";

    // 经办人内容控件配置，必须在此处给控件进行赋值，合同发起时控件即被填写完成。
    // 注意：目前文件发起模式暂不支持动态表格控件
    $req->Components = [
        // 坐标定位，单行文本类型
        buildComponentNormal("TEXT", "单行文本"),
        // 表单域定位，单行文本类型
        buildComponentField("TEXT", "单行文本"),
        // 关键字定位，单行文本类型
        buildComponentKeyword("TEXT", "单行文本")
    ];

    $req->NeedPreview = false;

    $req->PreviewType = 0;

    $req->Deadline = time() + 7 * 24 * 3600;

    $req->Unordered = false;

    $req->NeedSignReview = false;

    $req->UserData = "UserData";

    $resp = $client->CreateFlowByFiles($req);
    return $resp;
}

// buildSignComponentNormal 使用坐标模式进行控件定位
function buildComponentNormal($componentType, $componentValue): Component
{

    $component = new Component();

    $component->ComponentPosX = 146.15625;
    $component->ComponentPosY = 472.78125;
    $component->ComponentWidth = 112;
    $component->ComponentHeight = 40;

    $component->FileIndex = 0;

    $component->ComponentPage = 1;

    $component->ComponentType = $componentType;

    if ($componentType != "") {
        $component->ComponentValue = $componentValue;
    }

    return $component;
}

// buildComponentKeyword 使用关键字模式进行控件定位
function buildComponentKeyword($componentType, $componentValue): Component
{

    $component = new Component();

    $component->GenerateMode = "KEYWORD";

    $component->ComponentId = "签名";

    $component->ComponentWidth = 112;
    $component->ComponentHeight = 40;
    $component->FileIndex = 0;

    $component->OffsetX = 10.5;
    $component->OffsetY = 10.5;

    $component->KeywordOrder = "Reverse";

    $component->KeywordIndexes = [1];

    $component->ComponentType = $componentType;

    if ($componentType != "") {
        $component->ComponentValue = $componentValue;
    }

    return $component;
}

// buildComponentField 使用表单域模式进行控件定位
function buildComponentField($componentType, $componentValue): Component
{

    $component = new Component();

    $component->GenerateMode = "FIELD";

    $component->ComponentName = "表单";

    $component->FileIndex = 0;

    $component->ComponentType = $componentType;

    if ($componentType != "") {
        $component->ComponentValue = $componentValue;
    }

    return $component;
}






