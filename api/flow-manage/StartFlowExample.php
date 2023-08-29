<?php
require_once(__DIR__ . '/./StartFlow.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 此接口用于发起流程调用样例
try {

    $flowId = '********************************';

    $resp = StartFlow(Config::operatorUserId, $flowId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
