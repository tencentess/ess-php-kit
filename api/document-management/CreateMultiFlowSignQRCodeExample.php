<?php
require_once(__DIR__ . '/./CreateMultiFlowSignQRCode.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 创建一码多扫流程签署二维码调用样例
try {

    $templateId = '********************************';

    $flowName = '扫码签流程';

    $resp = CreateMultiFlowSignQRCode(Config::operatorUserId, $templateId, $flowName);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
