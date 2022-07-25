<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateFlowRequest;

// 创建签署流程
// 适用场景：在标准制式的合同场景中，可通过提前预制好模板文件，每次调用模板文件的id，补充合同内容信息及签署信息生成电子合同。
// 注：该接口是通过模板生成合同流程的前置接口，先创建一个不包含签署文件的流程。配合“创建电子文档”接口和“发起流程”接口使用。
function CreateFlow($operatorUserId, $flowName, $approvers) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 签署流程参与者信息
    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    // 签署流程名称,最大长度200个字符
    $req->setFlowName($flowName);

    $resp = $client->CreateFlow($req);
    return $resp;
}