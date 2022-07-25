<?php

require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');
require_once(__DIR__ . '/./UploadFiles.php');
require_once(__DIR__ . '/./CreateFlowByFiles.php');
require_once(__DIR__ . '/./CreateSchemeUrl.php');

// 通过文件base64直接发起签署流程，返回flowid
function CreateFlowByFileDirectly($operatorUserId, $fileBase64, $flowName, $approvers)
{
    // 上传文件获取fileId
    $uploadResp = UploadFiles($operatorUserId, $fileBase64, $flowName);
    $fileId = $uploadResp->FileIds[0];

    // 创建签署流程
    $createFlowResp = CreateFlowByFileId($operatorUserId, $flowName, $approvers, $fileId);
    $flowId = $createFlowResp->FlowId;

    // 获取签署链接
    $schemeResp = CreateSchemeUrl($operatorUserId, $flowId);
    $schemeUrl = $schemeResp->SchemeUrl;

    return array(
        'FlowId' => $flowId,
        'SchemeUrl' => $schemeUrl
    );
}
