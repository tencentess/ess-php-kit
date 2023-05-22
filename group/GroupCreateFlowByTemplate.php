<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/../api/Common.php');

use TencentCloud\Ess\V20201111\Models\CreateFlowRequest;
use TencentCloud\Ess\V20201111\Models\CreateDocumentRequest;
use TencentCloud\Ess\V20201111\Models\StartFlowRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\Agent;

// 通过模板发起合同流程
//
// 官网文档：https://cloud.tencent.com/document/api/1323/70361
// https://cloud.tencent.com/document/api/1323/70364
// https://cloud.tencent.com/document/api/1323/70357
//
// 适用场景：在标准制式的合同场景中，可通过提前预制好模板文件，每次调用模板文件的id，补充合同内容信息及签署信息生成电子合同。
function GroupCreateFlow($operatorUserId, $flowName, $approvers, $proxyOrganizationId)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    // 签署流程参与者信息
    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    // 签署流程名称,最大长度200个字符
    $req->setFlowName($flowName);

    $resp = $client->CreateFlow($req);
    return $resp;
}

function GroupCreateDocument($operatorUserId, $flowId, $templateId, $fileName, $proxyOrganizationId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateDocumentRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    // 文件名列表,单个文件名最大长度200个字符
    $req->FileNames = [];
    array_push($req->FileNames, $fileName);

    // 签署流程编号,由CreateFlow接口返回
    $req->setFlowId($flowId);

    // 用户上传的模板ID,在控制台模版管理中可以找到
    // 单个个人签署模版
    $req->setTemplateId($templateId);

    $resp = $client->CreateDocument($req);
    return $resp;
}

function GroupStartFlow($operatorUserId, $flowId, $proxyOrganizationId) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new StartFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 设置集团子企业账号
    $agent = new Agent();
    $agent->setProxyOrganizationId($proxyOrganizationId);
    $req->setAgent($agent);

    // 签署流程编号，由CreateFlow接口返回
    $req->setFlowId($flowId);

    $resp = $client->StartFlow($req);
    return $resp;
}



