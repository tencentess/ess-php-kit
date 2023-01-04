<?php
require_once(__DIR__ . '/./CreateFlowEvidenceReport.php');

// 创建并返回出证报告调用样例
try {
    $flowId = '********************************';

    $resp = CreateFlowEvidenceReport(Config::operatorUserId, $flowId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}