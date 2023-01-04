<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreatePrepareFlowRequest;

// CreatePrepareFlow 创建快速发起流程
//
// 官网文档：https://cloud.tencent.com/document/product/1323/83412
//
// 适用场景：用户通过API 合同文件及签署信息，并可通过我们返回的URL在页面完成签署控件等信息的编辑与确认，快速发起合同.
// 注：该接口文件的resourceId 是通过上传文件之后获取的。
function CreatePrepareFlow($operatorUserId, $flowName, $resourceId,$approvers) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreatePrepareFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 签署流程参与者信息
    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    // 签署流程名称,最大长度200个字符
    $req->setFlowName($flowName);

    // 资源Id,通过上传uploadFiles接口获得
    $req->setResourceId($resourceId);

    $resp = $client->CreatePrepareFlow($req);
    return $resp;
}