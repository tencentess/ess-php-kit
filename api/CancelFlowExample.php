<?php
require_once(__DIR__ . '/./CancelFlow.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 撤销签署流程调用样例
try {
    $flowId = '********************************';
    $cancelMessage = '撤销原因';

    $resp = CancelFlow(Config::operatorUserId, $flowId, $cancelMessage);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}