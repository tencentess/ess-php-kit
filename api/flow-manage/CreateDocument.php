<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\FormField;
use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateDocumentRequest;

function CreateDocument($operatorUserId, $flowId, $templateId, $fileName) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateDocumentRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    $req->FileNames = [];
    array_push($req->FileNames, $fileName);

    $req->setFlowId($flowId);

    $req->setTemplateId($templateId);

    $resp = $client->CreateDocument($req);
    return $resp;
}


// CreateDocumentExtended CreateDocument接口的详细参数使用样例，前面简要调用的场景不同，此版本旨在提供可选参数的填入参考。
// 如果您在实现基础场景外有进一步的功能实现需求，可以参考此处代码。
// 注意事项：此处填入参数仅为样例，请在使用时更换为实际值。
function CreateDocumentExtended() {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateDocumentRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId(Config::operatorUserId);
    $req->setOperator($userInfo);

    $req->setFlowId("**********************");

    $req->FileNames = [];
    array_push($req->FileNames, "filename");

    $req->setTemplateId("************************");

    // 这里为需要发起方填写的控件进行赋值操作，推荐使用ComponentName+ComponentValue的方式进行赋值，ComponentName即模板编辑时设置的控件名称
    $req->FormFields = [];
    $formField1 = new FormField();
    $formField1->setComponentName("单行文本");
    $formField1->setComponentValue("文本内容");
    array_push($req->FormFields, $formField1);

    $formField2 = new FormField();
    $formField2->setComponentName("勾选框");
    $formField2->setComponentValue("true");
    array_push($req->FormFields, $formField2);

    $req->setNeedPreview(true);

    $req->setPreviewType(1);

    $resp = $client->CreateDocument($req);
    return $resp;
}

