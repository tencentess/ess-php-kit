<?php
require_once(__DIR__ . '/./DescribeFileUrls.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 查询文件下载URL调用样例
try {

    $flowId = '********************************';

    $resp = DescribeFileUrls(Config::operatorUserId, $flowId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
