<?php
require_once(__DIR__ . '/./CreateFlowApprovers.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\FillApproverInfo;

// 补充签署流程本企业签署人信息
try {

    $flowId = '********************************';

    // 补充签署人信息
    $approver = new FillApproverInfo();

    $approver->setRecipientId('********************************');

    $approver->setApproverSource('********************************');

    $approver->setCustomUserId('********************************');

    $approvers = [];
    array_push($approvers, $approver);

    $resp = CreateFlowApprovers(Config::operatorUserId, $flowId, $approvers);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
