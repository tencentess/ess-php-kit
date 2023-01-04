<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\FormField;
use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateDocumentRequest;

// CreateDocument 创建电子文档
//
// 官方文档：https://cloud.tencent.com/document/api/1323/70364
//
// 适用场景：见创建签署流程接口。注：该接口需要给对应的流程指定一个模板id，并且填充该模板中需要补充的信息。是“发起流程”接口的前置接口。
function CreateDocument($operatorUserId, $flowId, $templateId, $fileName) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateDocumentRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 文件名列表,单个文件名最大长度200个字符
    $req->FileNames = [];
    array_push($req->FileNames, $fileName);

    // 签署流程编号,由CreateFlow接口返回
    $req->setFlowId($flowId);

    // 用户上传的模板ID,在控制台模版管理中可以找到
    // 单个个人签署模版
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


    // 签署流程编号,由CreateFlow接口返回
    // 注意：注意每次创建电子文档前必须先创建流程，文档和流程为一对一的绑定关系！
    $req->setFlowId("**********************");

    // 文件名列表,单个文件名最大长度200个字符。目前仅支持单文件发起，此处传入任意自定义值即可
    $req->FileNames = [];
    array_push($req->FileNames, "filename");

    // 用户上传的模板ID,在控制台模版管理中可以找到
    // 如何创建模板见官网：https://cloud.tencent.com/document/product/1323/61357
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

    // 是否需要生成预览文件 默认不生成；
    //预览链接有效期300秒；
    // 注意：此处生成的链接只能访问一次，访问过后即失效！
    $req->setNeedPreview(true);

    // 预览链接类型 默认:0-文件流, 1- H5链接 注意:此参数在NeedPreview 为true 时有效,
    $req->setPreviewType(1);

    // 客户端Token，保持接口幂等性,最大长度64个字符
    // 注意：传入相同的token会返回相同的结果，若无需要请不要进行传值！
    //$req->setClientToken("*********token*******");

    $resp = $client->CreateDocument($req);
    return $resp;
}

