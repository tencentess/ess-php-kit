<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeIntegrationEmployeesRequest;

// DescribeIntegrationEmployees 查询员工信息，每次返回的数据量最大为20
//
// 官网文档：https://cloud.tencent.com/document/product/1323/81115
//
// 查询员工信息，每次返回的数据量最大为20
function DescribeIntegrationEmployees($operatorUserId, $limit, $offset, $filters) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeIntegrationEmployeesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    //查询过滤实名用户，key为Status，Values为["IsVerified"]
    $req->setFilters($filters);

    // 返回最大数量，最大为20
    $req->setLimit($limit);

    // 偏移量，默认为0，最大为20000
    $req->setOffset($offset);

    $resp = $client->DescribeIntegrationEmployees($req);
    return $resp;
}