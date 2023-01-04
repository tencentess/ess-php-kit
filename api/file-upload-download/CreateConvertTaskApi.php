<?php
require_once(__DIR__ . '/../../vendor/autoload.php');
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../Common.php');

use TencentCloud\Ess\V20201111\Models\UserInfo;
use TencentCloud\Ess\V20201111\Models\CreateConvertTaskApiRequest;

// CreateConvertTaskApi 创建文件转换任务
//
// 官网文档：https://cloud.tencent.com/document/product/1323/78149
//
// 此接口用于创建文件转换任务
// 适用场景：将doc/docx文件转化为pdf文件
function CreateConvertTaskApi($operatorUserId, $resourceId, $resourceType, $resourceName) {
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateConvertTaskApiRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 资源Id，由UploadFiles接口返回
    $req->setResourceId($resourceId);

    // 资源类型，2-doc 3-docx
    $req->setResourceType($resourceType);

    // 资源名称
    $req->setResourceName($resourceName);

    $resp = $client->CreateConvertTaskApi($req);
    return $resp;
}