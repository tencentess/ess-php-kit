<?php
require_once(__DIR__ . '/./CreateSchemeUrl.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 获取小程序跳转链接调用样例
try {
    // 成功发起合同的flowid
    $flowId = '********************************';

    $resp = CreateSchemeUrl(Config::operatorUserId, $flowId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}