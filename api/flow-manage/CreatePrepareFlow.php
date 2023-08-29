<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreatePrepareFlowRequest;

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

    $req->setFlowName($flowName);

    $req->setResourceId($resourceId);

    $resp = $client->CreatePrepareFlow($req);
    return $resp;
}