<?php
require_once(__DIR__ . '/./GroupDescribeOrganizationSeals.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

/**
 * 主企业代子企业查询企业印章信息样例
 * 注意：使用集团代发起功能，需要主企业和子企业均已加入集团，并且主企业OperatorUserId对应人员被赋予了对应操作权限
 */
try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    $limit = 10;

    $resp = DescribeOrganizationSeals(Config::operatorUserId, $limit, $proxyOrganizationId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
