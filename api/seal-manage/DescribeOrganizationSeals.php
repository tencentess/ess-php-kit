<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeOrganizationSealsRequest;

// DescribeOrganizationSeals 查询企业印章的列表
//
// 官网文档：https://cloud.tencent.com/document/product/1323/82453
//
// 查询企业印章的列表，需要操作者具有查询印章权限
// 客户指定需要获取的印章数量和偏移量，数量最多100，超过100按100处理；入参InfoType控制印章是否携带授权人信息，为1则携带，为0则返回的授权人信息为空数组。接口调用成功返回印章的信息列表还有企业印章的总数。
function DescribeOrganizationSeals($operatorUserId, $limit) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeOrganizationSealsRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

   $req->setLimit($limit);

    $resp = $client->DescribeOrganizationSeals($req);
    return $resp;
}
