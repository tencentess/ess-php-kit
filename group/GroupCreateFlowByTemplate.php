<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../api/Common.php');

use TencentCloud\Ess\V20201111\Models\CreateFlowRequest;
use TencentCloud\Ess\V20201111\Models\CreateDocumentRequest;
use TencentCloud\Ess\V20201111\Models\StartFlowRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\Agent;

function GroupCreateFlow($operatorUserId, $flowName, $approvers, $proxyOrganizationId)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    // 签署流程参与者信息
    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    $req->setFlowName($flowName);

    $resp = $client->CreateFlow($req);
    return $resp;
}

function GroupCreateDocument($operatorUserId, $flowId, $templateId, $fileName, $proxyOrganizationId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateDocumentRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    $req->FileNames = [];
    array_push($req->FileNames, $fileName);

    $req->setFlowId($flowId);

    $req->setTemplateId($templateId);

    $resp = $client->CreateDocument($req);
    return $resp;
}

function GroupStartFlow($operatorUserId, $flowId, $proxyOrganizationId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new StartFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    // 签署流程编号，由CreateFlow接口返回
    $req->setFlowId($flowId);

    $resp = $client->StartFlow($req);
    return $resp;
}



