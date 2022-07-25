<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateDocumentRequest;

// 创建电子文档
// 适用场景：见创建签署流程接口。注：该接口需要给对应的流程指定一个模板id，并且填充该模板中需要补充的信息。是“发起流程”接口的前置接口。
function CreateDocument($operatorUserId, $flowId, $templateId, $fliename) {
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
    array_push($req->FileNames, $fliename);

    // 签署流程编号,由CreateFlow接口返回
    $req->setFlowId($flowId);

    // 用户上传的模板ID,在控制台模版管理中可以找到
    // 单个个人签署模版
    $req->setTemplateId($templateId);

    $resp = $client->CreateDocument($req);
    return $resp;
}