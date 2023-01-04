<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\FlowCreateApprover;
use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateFlowRequest;

// CreateFlow 创建签署流程
//
// 官网文档：https://cloud.tencent.com/document/api/1323/70361
//
// 适用场景：在标准制式的合同场景中，可通过提前预制好模板文件，每次调用模板文件的id，补充合同内容信息及签署信息生成电子合同。
// 注：该接口是通过模板生成合同流程的前置接口，先创建一个不包含签署文件的流程。配合“创建电子文档”接口和“发起流程”接口使用。
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

    // 签署流程名称,最大长度200个字符
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

    // 签署流程名称,最大长度200个字符
    $req->setFlowName("测试合同");

    $req->Approvers = [];

    // 企业静默签署
    $serverEnt = new FlowCreateApprover();
    // 这里我们设置签署方类型为企业方静默签署3，注意当类型为静默签署时，签署人会默认设置为发起方经办人。此时姓名手机号企业名等信息无需填写，且填写无效
    $serverEnt->setApproverType(3);
    // 合同发起后是否短信通知签署方进行签署：sms--短信，none--不通知
    // 企业静默签署不会发送短信通知，此处设置无效
    // $serverEnt->setNotifyType("sms");
    array_push($req->Approvers, $serverEnt);

    // 个人签署
    $person = new FlowCreateApprover();
    $person->setApproverType(1);
    // 个人身份签署一般设置姓名+手机号，请确保实际签署时使用的信息和此处一致
    // 本环节需要操作人的名字
    $person->setApproverName("张三");
    // 本环节需要操作人的手机号
    $person->setApproverMobile("15912345678");
    // 合同发起后是否短信通知签署方进行签署：sms--短信，none--不通知
    $person->setNotifyType("sms");
    array_push($req->Approvers, $person);

    // 企业签署
    $ent = new FlowCreateApprover();
    $ent->setApproverType(0);
    // 个人身份签署一般设置姓名+手机号，请确保实际签署时使用的信息和此处一致
    // 本环节需要操作人的名字
    $ent->setApproverName("李四");
    // 本环节需要操作人的手机号
    $ent->setApproverMobile("15987654321");
    // 本环节需要企业操作人的企业名称，请注意此处的企业名称要是真实有效的，企业需要在电子签平台进行注册且签署人有加入该企业方能签署。
    // 注：如果该企业尚未注册，或者签署人尚未加入企业，合同仍然可以发起
    $ent->setOrganizationName("XXXXX公司");
    // 合同发起后是否短信通知签署方进行签署：sms--短信，none--不通知
    $ent->setNotifyType("sms");
    array_push($req->Approvers, $ent);

    $resp = $client->CreateFlow($req);
    return $resp;
}

