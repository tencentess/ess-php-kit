<?php
require_once(__DIR__ . '/./GroupDescribeFlowInfo.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

/**
 * 主企业代子企业查询合同信息的使用样例
 * 注意：使用集团代发起功能，需要主企业和子企业均已加入集团，并且主企业OperatorUserId对应人员被赋予了对应操作权限
 */
try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    // 需要查询的流程ID
    $flowId = '********************************';

    $resp = GroupDescribeFlowInfo(Config::operatorUserId, $flowId, $proxyOrganizationId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}