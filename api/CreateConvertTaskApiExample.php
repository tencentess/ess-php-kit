<?php
require_once(__DIR__ . '/./CreateConvertTaskApi.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 创建文件转换任务调用样例
try {
    // 资源Id，由UploadFiles接口返回
    $resourceId = '********************************';
    // 资源类型，2-doc 3-docx
    $resourceType = '********************************';
    // 资源名称
    $resourceName = '********************************';

    $resp = CreateConvertTaskApi(Config::operatorUserId, $resourceId, $resourceType, $resourceName);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
