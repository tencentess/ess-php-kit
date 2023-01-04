<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateFlowEvidenceReportRequest;

// CreateFlowEvidenceReport 创建并返回出证报告
//
// 官网文档：https://cloud.tencent.com/document/product/1323/79686
//
// 创建出证报告，返回报告 ID。
function CreateFlowEvidenceReport($operatorUserId, $flowId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowEvidenceReportRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 签署流程id
    $req->setFlowId($flowId);

    $resp = $client->CreateFlowEvidenceReport($req);
    return $resp;
}