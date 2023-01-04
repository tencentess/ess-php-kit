<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateIntegrationEmployeesRequest;

// CreateIntegrationEmployees 创建员工
//
// 官网文档：https://cloud.tencent.com/document/product/1323/81117
//
// 创建员工
function CreateIntegrationEmployees($operatorUserId, $employees) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateIntegrationEmployeesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 待创建员工的信息，Mobile和DisplayName必填
    $req->setEmployees($employees);

    $resp = $client->CreateIntegrationEmployees($req);
    return $resp;
}