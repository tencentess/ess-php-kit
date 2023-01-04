<?php
require_once(__DIR__ . '/./DescribeThirdPartyAuthCode.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 通过AuthCode查询用户是否实名调用样例
try {
    $authCode = '*********************';

    $resp = DescribeThirdPartyAuthCode(Config::operatorUserId, $authCode);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
