<?php
require_once(__DIR__ . '/./GroupDescribeFlowTemplates.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

try {
    // 需要代发起的子企业的企业id
    $proxyOrganizationId = "*****************";

    $templateId = '********************************';

    $resp = GroupDescribeFlowTemplates(Config::operatorUserId, $templateId, $proxyOrganizationId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
