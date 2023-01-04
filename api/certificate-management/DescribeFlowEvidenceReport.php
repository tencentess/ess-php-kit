<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeFlowEvidenceReportRequest;

// DescribeFlowEvidenceReport 查询出证报告
//
// 官网文档：https://cloud.tencent.com/document/product/1323/83441
//
// 查询出证报告，返回报告 URL。
function DescribeFlowEvidenceReport($operatorUserId, $reportId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeFlowEvidenceReportRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 出证报告编号
    $req->setReportId($reportId);

    return $client->DescribeFlowEvidenceReport($req);
}