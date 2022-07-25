<?php
require_once(__DIR__ . '/../vendor/autoload.php');

use TencentCloud\Ess\V20201111\EssClient;
use TencentCloud\Common\Credential;
use TencentCloud\Common\Profile\ClientProfile;
use TencentCloud\Common\Profile\HttpProfile;

// 构造客户端调用实例
function GetClientInstance($secretId, $secretKey, $endPoint) {
    // 实例化一个证书对象，入参需要传入腾讯云账户secretId，secretKey
    $cred = new Credential($secretId, $secretKey);

    // 实例化一个http选项，可选的，没有特殊需求可以跳过
    $httpProfile = new HttpProfile();
    $httpProfile->setReqMethod("POST");  // post请求(默认为post请求)
    $httpProfile->setReqTimeout(30);    // 请求超时时间，单位为秒(默认60秒)
    $httpProfile->setEndpoint($endPoint);  // 指定接入地域域名(默认就近接入)

    // 实例化一个client选项，可选的，没有特殊需求可以跳过
    $clientProfile = new ClientProfile();
    $clientProfile->setSignMethod("TC3-HMAC-SHA256");  // 指定签名算法(默认为HmacSHA256)
    $clientProfile->setHttpProfile($httpProfile);

    $client = new EssClient($cred, "ap-guangzhou", $clientProfile);
    return $client;
}