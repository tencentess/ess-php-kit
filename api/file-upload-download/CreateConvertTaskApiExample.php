<?php
require_once(__DIR__ . '/./CreateConvertTaskApi.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 创建文件转换任务调用样例
try {

    $resourceId = '********************************';

    $resourceType = '********************************';

    $resourceName = '********************************';

    $resp = CreateConvertTaskApi(Config::operatorUserId, $resourceId, $resourceType, $resourceName);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
