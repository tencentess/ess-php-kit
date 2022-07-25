<?php
require_once(__DIR__ . '/./CreateDocument.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 创建电子文档调用样例
try {
    $flowId = '********************************';
    $templateId = '********************************';
    $flieName = '文件名';

    $resp = CreateDocument(Config::operatorUserId, $flowId, $templateId, $flieName);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
