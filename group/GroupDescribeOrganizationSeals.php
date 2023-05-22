<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../api/Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeOrganizationSealsRequest;
use TencentCloud\Ess\V20201111\Models\Agent;

// 查询企业电子印章
//
// 官网文档：https://cloud.tencent.com/document/product/1323/82453
//
// 查询企业印章的列表，需要操作者具有查询印章权限
function DescribeOrganizationSeals($operatorUserId, $limit, $proxyOrganizationId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeOrganizationSealsRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    $req->setLimit($limit);

    $resp = $client->DescribeOrganizationSeals($req);
    return $resp;
}