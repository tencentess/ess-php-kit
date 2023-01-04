<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeFlowInfoRequest;

// DescribeFlowInfo 查询合同详情
//
// 官网文档：https://cloud.tencent.com/document/product/1323/80032
//
// 查询合同详情
// 适用场景：可用于主动查询某个合同详情信息。
//
// tips: 如果仅需查询合同摘要，需要使用查询合同摘要接口 https://cloud.tencent.com/document/product/1323/70358
function DescribeFlowInfo($operatorUserId, $flowId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeFlowInfoRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 需要查询的流程ID列表
    $req->FlowIds = [];
    array_push($req->FlowIds, $flowId);

    $resp = $client->DescribeFlowInfo($req);
    return $resp;
}