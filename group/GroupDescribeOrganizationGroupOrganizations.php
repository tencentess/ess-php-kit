<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../api/Common.php');

use TencentCloud\Ess\V20201111\Models\DescribeOrganizationGroupOrganizationsRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;

// 查询集团企业列表
//
// 官网文档：https://cloud.tencent.com/document/product/1323/86114
//
// 此API接口用户查询加入集团的成员企业
function DescribeOrganizationGroupOrganizations($operatorUserId, $limit, $offset)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeOrganizationGroupOrganizationsRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $userInfo->setClientIp("8.8.8.8");
    $userInfo->setChannel("YUFU");
    $req->setOperator($userInfo);

    // 返回最大数量
    $req->setLimit($limit);
    // 查询偏移量
    $req->setOffset($offset);

    $resp = $client->DescribeOrganizationGroupOrganizations($req);

    return $resp;
}






