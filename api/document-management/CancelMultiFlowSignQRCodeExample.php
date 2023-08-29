<?php
require_once(__DIR__ . '/./CancelMultiFlowSignQRCode.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 取消一码多扫二维码调用样例
try {
    $qrCodeId = '********************************';

    $resp = CancelMultiFlowSignQRCode(Config::operatorUserId, $qrCodeId);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}