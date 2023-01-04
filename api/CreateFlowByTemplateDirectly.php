<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/./flow-manage/CreateFlow.php');
require_once(__DIR__ . '/./flow-manage/CreateDocument.php');
require_once(__DIR__ . '/./flow-manage/StartFlow.php');
require_once(__DIR__ . '/./flow-manage/CreateSchemeUrl.php');

// 通过模板发起签署流程，并查询签署链接
function CreateFlowByTemplateDirectly($operatorUserId, $flowName, $approvers)
{
    // 创建流程
    $createFlowResp = CreateFlow(Config::operatorUserId, $flowName, $approvers);
    $flowId = $createFlowResp->FlowId;

    // 创建电子文档
    CreateDocument($operatorUserId, $flowId, Config::templateId, $flowName);

    // 等待文档异步合成
    sleep(3);

    // 开启流程
    StartFlow($operatorUserId, $flowId);

    // 获取签署链接
    $schemeResp = CreateSchemeUrl($operatorUserId, $flowId);
    $schemeUrl = $schemeResp->SchemeUrl;

    return array(
        'FlowId' => $flowId,
        'SchemeUrl' => $schemeUrl
    );
}
