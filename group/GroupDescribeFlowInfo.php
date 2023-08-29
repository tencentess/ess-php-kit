<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../api/Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeFlowInfoRequest;
use TencentCloud\Ess\V20201111\Models\Agent;


function GroupDescribeFlowInfo($operatorUserId, $flowId, $proxyOrganizationId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeFlowInfoRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    $req->FlowIds = [];
    array_push($req->FlowIds, $flowId);

    $resp = $client->DescribeFlowInfo($req);
    return $resp;
}