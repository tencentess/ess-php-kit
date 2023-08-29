<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeFlowTemplatesRequest;
use \TencentCloud\Ess\V20201111\Models\Filter;

function DescribeFlowTemplates($operatorUserId, $templateId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeFlowTemplatesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    $filter = new Filter();
    $filter->setKey("template-id");  // 查询过滤条件的Key
    $filter->setValues(array($templateId,)); // 查询过滤条件的Value列表

    $req->Filters = [];
    array_push($req->Filters, $filter);

    $resp = $client->DescribeFlowTemplates($req);
    return $resp;
}
