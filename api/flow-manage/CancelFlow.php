<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CancelFlowRequest;

// CancelFlow 撤销签署流程
//
// 官网文档：https://cloud.tencent.com/document/product/1323/70362
//
// 适用场景：如果某个合同流程当前至少还有一方没有签署，则可通过该接口取消该合同流程。常用于合同发错、内容填错，需要及时撤销的场景。
// 注：如果合同流程中的参与方均已签署完毕，则无法通过该接口撤销合同。
function CancelFlow($operatorUserId, $flowId, $cancelMessage) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CancelFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId(Config::operatorUserId);
    $req->setOperator($userInfo);

    // 签署流程id
    $req->setFlowId($flowId);
    // 撤销原因，最长200个字符
    $req->setCancelMessage($cancelMessage);

    $resp = $client->CancelFlow($req);
    return $resp;
}