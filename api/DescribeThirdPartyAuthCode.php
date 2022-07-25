<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');
use TencentCloud\Ess\V20201111\Models\DescribeThirdPartyAuthCodeRequest;
use TencentCloud\Common\Exception\TencentCloudSDKException;

// 通过AuthCode查询用户是否实名
try {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeThirdPartyAuthCodeRequest();

    // 电子签小程序跳转客户小程序时携带的授权查看码
    $req->setAuthCode("********************************");

    $resp = $client->DescribeThirdPartyAuthCode($req);

    // 输出json格式的字符串回包
    print_r($resp->toJsonString());
}
catch(TencentCloudSDKException $e) {
    echo $e;
}