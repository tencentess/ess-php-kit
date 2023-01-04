<?php
require_once(__DIR__ . '/./DescribeFileUrls.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 查询文件下载URL调用样例
try {
    // 业务编号的数组，如模板编号、文档编号、印章编号
    // 最大支持20个资源
    $flowId = '********************************';

    $resp = DescribeFileUrls(Config::operatorUserId, $flowId);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
