<?php
require_once(__DIR__ . '/./VerifyPdf.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 合同文件验签调用样例
try {
    $flowId = '********************************';

    $resp = VerifyPdf(Config::operatorUserId, $flowId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
