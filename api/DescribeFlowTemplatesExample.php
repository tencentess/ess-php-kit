<?php
require_once(__DIR__ . '/./DescribeFlowTemplates.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 查询模板调用样例
try {
    $templateId = '********************************';

    $resp = DescribeFlowTemplates(Config::operatorUserId, $templateId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
