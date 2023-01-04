<?php
require_once(__DIR__ . '/./CreateFlowApprovers.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\FillApproverInfo;

// 补充签署流程本企业签署人信息
try {

    // 签署流程编号
    $flowId = '********************************';

    // 补充签署人信息
    $approver = new FillApproverInfo();
    // 签署人签署Id
    $approver->setRecipientId('********************************');
    // 签署人来源
    //WEWORKAPP: 企业微信
    $approver->setApproverSource('********************************');
    // 企业自定义账号Id
    //WEWORKAPP场景下指企业自有应用获取企微明文的userid
    $approver->setCustomUserId('********************************');

    $approvers = [];
    array_push($approvers, $approver);

    $resp = CreateFlowApprovers(Config::operatorUserId, $flowId, $approvers);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
