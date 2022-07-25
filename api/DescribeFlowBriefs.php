<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeFlowBriefsRequest;

// 查询流程摘要
// 适用场景：可用于主动查询某个合同流程的签署状态信息。可以配合回调通知使用。
function DescribeFlowBriefs($operatorUserId, $flowId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeFlowBriefsRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 需要查询的流程ID列表
    $req->FlowIds = [];
    array_push($req->FlowIds, $flowId);

    $resp = $client->DescribeFlowBriefs($req);
    return $resp;
}