<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../api/Common.php');

use TencentCloud\Ess\V20201111\Models\CreateFlowByFilesRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\Agent;

function GroupCreateFlowByFiles($operatorUserId, $flowName, $approvers, $fileId, $proxyOrganizationId)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowByFilesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    $req->FileIds = [];
    $req->FileIds[] = $fileId;

    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    $req->setFlowName($flowName);

    $resp = $client->CreateFlowByFiles($req);

    return $resp;
}






