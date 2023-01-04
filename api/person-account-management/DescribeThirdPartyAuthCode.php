<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');
use TencentCloud\Ess\V20201111\Models\DescribeThirdPartyAuthCodeRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;

// DescribeThirdPartyAuthCode 通过AuthCode查询用户是否实名
//
// 官网文档：https://cloud.tencent.com/document/product/1323/70368
function DescribeThirdPartyAuthCode($operatorUserId, $authCode) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeThirdPartyAuthCodeRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 待创建员工的信息，Mobile和DisplayName必填
    $req->setAuthCode($authCode);

    $resp = $client->DescribeThirdPartyAuthCode($req);
    return $resp;
}