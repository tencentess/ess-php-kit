<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\GetTaskResultApiRequest;

// GetTaskResultApi 查询转换任务状态
//
// 官网文档：https://cloud.tencent.com/document/product/1323/78148
//
// 此接口用于查询转换任务状态
// 适用场景：将doc/docx文件转化为pdf文件
// 注：该接口是“创建文件转换任务”接口的后置接口，用于查询转换任务的执行结果
function GetTaskResultApi($operatorUserId, $taskId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new GetTaskResultApiRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 任务Id，“创建文件转换任务”接口返回
    $req->setTaskId($taskId);

    $resp = $client->GetTaskResultApi($req);
    return $resp;
}