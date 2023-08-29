<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../api/Common.php');

use TencentCloud\Ess\V20201111\Models\DescribeOrganizationGroupOrganizationsRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;


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

 
    $req->setLimit($limit);

    $req->setOffset($offset);

    $resp = $client->DescribeOrganizationGroupOrganizations($req);

    return $resp;
}






