<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\DescribeFlowTemplatesRequest;
use \TencentCloud\Ess\V20201111\Models\Filter;

// 查询模板
// 适用场景：当模板较多或模板中的控件较多时，可以通过查询模板接口更方便的获取自己主体下的模板列表，以及每个模板内的控件信息。
// 该接口常用来配合“创建电子文档”接口作为前置的接口使用。
function DescribeFlowTemplates($operatorUserId, $templateId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new DescribeFlowTemplatesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 需要查询的流程ID列表
    $filter = new Filter();
    $filter->setKey("template-id");  // 查询过滤条件的Key
    $filter->setValues(array($templateId,)); // 查询过滤条件的Value列表

    // 搜索条件，具体参考Filter结构体。本接口取值：template-id：按照【 模板唯一标识 】进行过滤
    $req->Filters = [];
    array_push($req->Filters, $filter);

    $resp = $client->DescribeFlowTemplates($req);
    return $resp;
}