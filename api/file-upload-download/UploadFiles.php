<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\Caller;
use TencentCloud\Ess\V20201111\Models\UploadFilesRequest;
use TencentCloud\Ess\V20201111\Models\UploadFile;

function UploadFiles($operatorUserId, $fileBase64, $filename)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::fileServiceEndPoint);

    // 构造请求体
    $req = new UploadFilesRequest();

    // 调用方用户信息，参考通用结构
    $caller = new Caller();
    $caller->setOperatorId($operatorUserId);
    $req->setCaller($caller);

    $req->setBusinessType("DOCUMENT");

    $file = new UploadFile();
    $file->setFileBody($fileBase64);
    $file->setFileName($filename);

    $req->FileInfos = [];
    array_push($req->FileInfos, $file);

    $resp = $client->UploadFiles($req);
    return $resp;
}