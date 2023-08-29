<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');
use TencentCloud\Ess\V20201111\Models\DescribeThirdPartyAuthCodeRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;

function DescribeThirdPartyAuthCode($operatorUserId, $authCode) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeThirdPartyAuthCodeRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    $req->setAuthCode($authCode);

    $resp = $client->DescribeThirdPartyAuthCode($req);
    return $resp;
}