<?php
require_once(__DIR__ . '/./UploadFiles.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 上传文件调用样例
try {
    // 将文件处理为Base64编码后的文件内容
    $filePath = __DIR__ . "/../testdata/test.pdf";

    $handle = fopen($filePath, "rb");
    $contents = fread($handle, filesize ($filePath));
    fclose($handle);

    $fileBase64 = chunk_split(base64_encode($contents));

    // 文件名，最大长度不超过200字符
    $filename = 'test.pdf';

    $resp = UploadFiles(Config::operatorUserId, $fileBase64, $filename);
    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}