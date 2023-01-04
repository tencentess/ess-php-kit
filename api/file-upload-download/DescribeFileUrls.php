<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeFileUrlsRequest;

// DescribeFileUrls 查询文件下载URL
//
// 官网文档：https://cloud.tencent.com/document/product/1323/70366
//
// 适用场景：通过传参合同流程编号，下载对应的合同PDF文件流到本地。
function DescribeFileUrls($operatorUserId, $flowId)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeFileUrlsRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 文件对应的业务类型，目前支持：
    // - 模板 "TEMPLATE"
    // - 文档 "DOCUMENT"
    // - 印章 “SEAL”
    // - 流程 "FLOW"
    $req->setBusinessType("FLOW");

    // 业务编号的数组，如模板编号、文档编号、印章编号
    // 最大支持20个资源
    $req->BusinessIds = [];
    array_push($req->BusinessIds, $flowId);

    $resp = $client->DescribeFileUrls($req);
    return $resp;
}