<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\FlowCreateApprover;
use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateFlowRequest;

function CreateFlow($operatorUserId, $flowName, $approvers)
{
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

    $req->setFlowName($flowName);

    $resp = $client->CreateFlow($req);
    return $resp;
}

// CreateFlowExtended CreateFlow接口的详细参数使用样例，前面简要调用的场景不同，此版本旨在提供可选参数的填入参考。
// 如果您在实现基础场景外有进一步的功能实现需求，可以参考此处代码。
// 注意事项：此处填入参数仅为样例，请在使用时更换为实际值。
function CreateFlowExtended()
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId(Config::operatorUserId);
    $req->setOperator($userInfo);

    $req->setFlowName("测试合同");

    $req->Approvers = [];

    // 企业静默签署
    $serverEnt = new FlowCreateApprover();
    $serverEnt->setApproverType(3);
    array_push($req->Approvers, $serverEnt);

    // 个人签署
    $person = new FlowCreateApprover();
    $person->setApproverType(1);
    $person->setApproverName("张三");
    $person->setApproverMobile("15912345678");
    $person->setNotifyType("sms");
    array_push($req->Approvers, $person);

    // 企业签署
    $ent = new FlowCreateApprover();
    $ent->setApproverType(0);
    $ent->setApproverName("李四");
    $ent->setApproverMobile("1********1");
    $ent->setOrganizationName("XXXXX公司");
    $ent->setNotifyType("sms");
    array_push($req->Approvers, $ent);

    $resp = $client->CreateFlow($req);
    return $resp;
}

