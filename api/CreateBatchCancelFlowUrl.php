<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateBatchCancelFlowUrlRequest;

// 获取批量撤销签署流程链接
// 电子签企业版：指定需要批量撤回的签署流程Id，获取批量撤销链接
// 客户指定需要撤回的签署流程Id，最多100个，超过100不处理；接口调用成功返回批量撤回合同的链接，通过链接跳转到电子签小程序完成批量撤回
function CreateBatchCancelFlowUrl($operatorUserId, $flowIds) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateBatchCancelFlowUrlRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 需要执行撤回的签署流程id数组，最多100个
    $req->setFlowIds($flowIds);

    $resp = $client->CreateBatchCancelFlowUrl($req);
    return $resp;
}