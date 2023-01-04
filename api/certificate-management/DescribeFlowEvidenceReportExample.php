<?php
require_once(__DIR__ . '/./DescribeFlowEvidenceReport.php');

// 查询出证报告调用样例
try {
    $flowId = '********************************';

    $resp = DescribeFlowEvidenceReport(Config::operatorUserId, $flowId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}