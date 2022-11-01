<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateFlowSignReviewRequest;

// 提交企业签署流程审批结果
// 适用场景:
// 在通过接口(CreateFlow 或者CreateFlowByFiles)创建签署流程时，若指定了参数 NeedSignReview 为true,则可以调用此接口提交企业内部签署审批结果。
// 若签署流程状态正常，且本企业存在签署方未签署，同一签署流程可以多次提交签署审批结果，签署时的最后一个“审批结果”有效。
function CreateFlowSignReview($operatorUserId, $flowId, $reviewType, $reviewMessage)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowSignReviewRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 签署流程编号
    $req->setFlowId($flowId);

    // 企业内部审核结果
    //PASS: 通过
    //REJECT: 拒绝
    $req->setReviewType($reviewType);

    // 审核原因
    //当ReviewType 是REJECT 时此字段必填,字符串长度不超过200
    $req->setReviewMessage($reviewMessage);

    $resp = $client->CreateFlowSignReview($req);
    return $resp;
}