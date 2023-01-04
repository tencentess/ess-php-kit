<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\ApproverInfo;
use TencentCloud\Ess\V20201111\Models\Component;
use TencentCloud\Ess\V20201111\Models\CreateFlowByFilesRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;

// CreateFlowByFiles 此接口（CreateFlowByFiles）用来通过上传后的pdf资源编号来创建待签署的合同流程。
//
// 官网文档：https://cloud.tencent.com/document/api/1323/70360
//
// 适用场景1：适用非制式的合同文件签署。一般开发者自己有完整的签署文件，可以通过该接口传入完整的PDF文件及流程信息生成待签署的合同流程。
//适用场景2：可通过该接口传入制式合同文件，同时在指定位置添加签署控件。可以起到接口创建临时模板的效果。如果是标准的制式文件，建议使用模板功能生成模板ID进行合同流程的生成。
//注意事项：该接口需要依赖“多文件上传”接口生成pdf资源编号（FileIds）进行使用。
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

    // 签署pdf文件的资源编号列表，通过UploadFiles接口获取
    $req->FileIds = [];
    $req->FileIds[] = $fileId;

    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    // 签署流程名称,最大长度200个字符
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
    // 这里我们设置签署方类型为企业方静默签署3，注意当类型为静默签署时，签署人会默认设置为发起方经办人。此时姓名手机号企业名等信息无需填写，且填写无效
    $serverEnt->ApproverType = 3;
    // 合同发起后是否短信通知签署方进行签署：sms--短信，none--不通知
    // 企业静默签署不会发送短信通知，此处设置无效
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
    // 本环节需要操作人的名字
    $ent->ApproverName = "李四";
    // 本环节需要操作人的手机号
    $ent->ApproverMobile = "15987654321";
    // 本环节需要企业操作人的企业名称，请注意此处的企业名称要是真实有效的，企业需要在电子签平台进行注册且签署人有加入该企业方能签署。
    // 注：如果该企业尚未注册，或者签署人尚未加入企业，合同仍然可以发起
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

    // 签署pdf文件的资源编号列表，通过UploadFiles接口获取，暂时仅支持单文件发起
    $req->FileIds = ["*************************"];

    // 签署流程的类型(如销售合同/入职合同等)，最大长度200个字符。填写后可以在控制台分类查看合同
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

    // 是否需要预览，true：预览模式，false：非预览（默认）；
    //预览链接有效期300秒；
    //
    //注：如果使用“预览模式”，出参会返回合同预览链接 PreviewUrl，不会正式发起合同，且出参不会返回签署流程编号 FlowId；如果使用“非预览”，则会正常返回签署流程编号 FlowId，不会生成合同预览链接 PreviewUrl。
    $req->NeedPreview = false;

    // 预览链接类型 默认:0-文件流, 1- H5链接 注意:此参数在NeedPreview 为true 时有效
    $req->PreviewType = 0;

    // 签署流程的签署截止时间。
    //值为unix时间戳,精确到秒,不传默认为当前时间一年后
    $req->Deadline = time() + 7 * 24 * 3600;

    // 发送类型：
    //true：无序签
    //false：有序签
    //注：默认为false（有序签）
    $req->Unordered = false;

    // 发起方企业的签署人进行签署操作是否需要企业内部审批。使用此功能需要发起方企业有参与签署。
    //若设置为true，审核结果需通过接口 CreateFlowSignReview 通知电子签，审核通过后，发起方企业签署人方可进行签署操作，否则会阻塞其签署操作。
    //
    //注：企业可以通过此功能与企业内部的审批流程进行关联，支持手动、静默签署合同。
    $req->NeedSignReview = false;

    // 用户自定义字段，回调的时候会进行透传，长度需要小于20480
    $req->UserData = "UserData";

    $resp = $client->CreateFlowByFiles($req);
    return $resp;
}

// buildSignComponentNormal 使用坐标模式进行控件定位
function buildComponentNormal($componentType, $componentValue): Component
{
    // 可选参数传入请参考：https://cloud.tencent.com/document/api/1323/70369#Component
    $component = new Component();
    // 以下4项确定了控件在pdf文件内的坐标位置以及长宽信息，这里我们给出一些预设值
    // 如何确定坐标请参考： https://doc.weixin.qq.com/doc/w3_AKgAhgboACgsf9NKAVqSOKVIkQ0vQ?scode=AJEAIQdfAAoz9916DRAKgAhgboACg
    $component->ComponentPosX = 146.15625;
    $component->ComponentPosY = 472.78125;
    $component->ComponentWidth = 112;
    $component->ComponentHeight = 40;
    // 控件所属文件的序号，目前均为单文件发起，所以我们固定填入序号0
    $component->FileIndex = 0;
    // 控件所在的页面数，从1开始取值，请勿超出pdf文件的最大页数
    $component->ComponentPage = 1;
    // 控件类型，阅读传参文档时请注意控件类型的限制
    $component->ComponentType = $componentType;

    // 企业静默签署时，此处传入了印章Id那么轮到该签署人签署时，会自动进行签章操作
    // 经办人控件填写时，此处传入了控件值，在合同发起后此处会自动进行填充
    if ($componentType != "") {
        $component->ComponentValue = $componentValue;
    }

    return $component;
}

// buildComponentKeyword 使用关键字模式进行控件定位
function buildComponentKeyword($componentType, $componentValue): Component
{
    // 可选参数传入请参考：https://cloud.tencent.com/document/api/1323/70369#Component
    $component = new Component();
    // KEYWORD 关键字，使用ComponentId指定关键字
    $component->GenerateMode = "KEYWORD";

    // GenerateMode==KEYWORD时，此处赋值用于指定关键字。
    // 注：例如此处指定了关键字为"签名"，那么会全文搜索这个关键字，默认找到所有关键字出现的地方，并以该关键字的左上角为原点划出控件区域
    $component->ComponentId = "签名";

    // 控件的长宽
    // 如何确定坐标请参考： https://doc.weixin.qq.com/doc/w3_AKgAhgboACgsf9NKAVqSOKVIkQ0vQ?scode=AJEAIQdfAAoz9916DRAKgAhgboACg
    $component->ComponentWidth = 112;
    $component->ComponentHeight = 40;
    // 控件所属文件的序号，目前均为单文件发起，所以我们固定填入序号0
    $component->FileIndex = 0;

    // 指定关键字时横/纵坐标偏移量，单位pt
    // 关键字定位原点默认在关键字的左上角，如果需要偏移该位置可以使用以下参数，如果不需要可以不赋值
    $component->OffsetX = 10.5;
    $component->OffsetY = 10.5;

    // 指定关键字排序规则，Positive-正序，Reverse-倒序。传入Positive时会根据关键字在PDF文件内的顺序进行排列。在指定KeywordIndexes时，0代表在PDF内查找内容时，查找到的第一个关键字。
    // 传入Reverse时会根据关键字在PDF文件内的反序进行排列。在指定KeywordIndexes时，0代表在PDF内查找内容时，查找到的最后一个关键字。
    $component->KeywordOrder = "Reverse";

    // 关键字索引，可选参数，如果一个关键字在PDF文件中存在多个，可以通过关键字索引指定使用第几个关键字作为最后的结果，可指定多个索引。示例：[0,2]，说明使用PDF文件内第1个和第3个关键字位置。
    $component->KeywordIndexes = [1];

    // 控件类型，阅读传参文档时请注意控件类型的限制
    $component->ComponentType = $componentType;

    // 企业静默签署时，此处传入了印章Id那么轮到该签署人签署时，会自动进行签章操作
    // 经办人控件填写时，此处传入了控件值，在合同发起后此处会自动进行填充
    if ($componentType != "") {
        $component->ComponentValue = $componentValue;
    }

    return $component;
}

// buildComponentField 使用表单域模式进行控件定位
function buildComponentField($componentType, $componentValue): Component
{
    // 可选参数传入请参考：https://cloud.tencent.com/document/api/1323/70369#Component
    $component = new Component();
    // FIELD 关键字，使用ComponentId指定关键字
    $component->GenerateMode = "FIELD";

    // GenerateMode==FIELD 指定表单域名称
    $component->ComponentName = "表单";

    // 控件所属文件的序号，目前均为单文件发起，所以我们固定填入序号0
    $component->FileIndex = 0;

    // 控件类型，阅读传参文档时请注意控件类型的限制
    $component->ComponentType = $componentType;

    // 企业静默签署时，此处传入了印章Id那么轮到该签署人签署时，会自动进行签章操作
    // 经办人控件填写时，此处传入了控件值，在合同发起后此处会自动进行填充
    if ($componentType != "") {
        $component->ComponentValue = $componentValue;
    }

    return $component;
}






