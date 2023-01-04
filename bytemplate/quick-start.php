<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../api/CreateFlowByTemplateDirectly.php');
require_once(__DIR__ . '/../api/file-upload-download/DescribeFileUrls.php');
require_once(__DIR__ . '/./bytemplate.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 如果您选择使用模板发起合同可以参考此处。通过此部分代码可以发起一份单C签署合同，帮您快速了解文件发起所必要的流程。您可以在体验后根据实际情况
// 修改参数，以满足业务场景的需求。
try {
    // Step 1
    // 定义合同名
    $flowName = '我的第一个合同';
    // 构造签署人
    // 此块代码中的$approvers仅用于快速发起一份合同样例，非正式对接用
    $personName = "****************"; // 个人签署方的姓名
    $personMobile = "****************"; // 个人签署方的手机号
    $approvers = [];
    array_push($approvers, BuildPersonFlowCreateApprover($personName, $personMobile));

    // 如果是正式接入，需使用这里注释的$approvers。请进入BuildFlowCreateApprovers函数内查看说明，构造需要的场景参数
    // $approvers = BuildFlowCreateApprovers();

    // Step 2
    // 发起合同
    $resp = CreateFlowByTemplateDirectly(Config::operatorUserId, $flowName, $approvers);

    // 返回合同Id
    print_r("您创建的合同id为：\r\n");
    print_r($resp['FlowId']);
    print_r("\r\n\r\n");
    // 返回签署的链接
    print_r("签署链接（请在手机浏览器中打开）为：\r\n");
    print_r($resp['SchemeUrl']);
    print_r("\r\n\r\n");

    // Step 3
    // 下载合同
    $fileUrlResp = DescribeFileUrls(Config::operatorUserId, $resp['FlowId']);
    // 返回合同下载链接
    print_r("请访问以下地址下载您的合同：\r\n");
    print_r($fileUrlResp->FileUrls[0]->Url);
    print_r("\r\n\r\n");


} catch (TencentCloudSDKException $e) {
    echo $e;
}