<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CancelMultiFlowSignQRCodeRequest;

// CancelMultiFlowSignQRCode 取消一码多扫二维码
//
// 官网文档：https://cloud.tencent.com/document/product/1323/75451
//
// 此接口（CancelMultiFlowSignQRCode）用于取消一码多扫二维码。该接口对传入的二维码ID，若还在有效期内，可以提前失效。
function CancelMultiFlowSignQRCode($operatorUserId, $qrCodeId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CancelMultiFlowSignQRCodeRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 二维码id
    $req->setQrCodeId($qrCodeId);

    $resp = $client->CancelMultiFlowSignQRCode($req);
    return $resp;
}