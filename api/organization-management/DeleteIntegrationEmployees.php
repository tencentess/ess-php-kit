<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DeleteIntegrationEmployeesRequest;

// DeleteIntegrationEmployees 移除员工
//
// 官网文档：https://cloud.tencent.com/document/product/1323/81116
//
// 移除员工
function DeleteIntegrationEmployees($operatorUserId, $employees) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DeleteIntegrationEmployeesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 待移除员工的信息，userId和openId二选一，必填一个
    $req->setEmployees($employees);

    $resp = $client->DeleteIntegrationEmployees($req);
    return $resp;
}