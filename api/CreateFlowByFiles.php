<?php
require_once(__DIR__ . '/../vendor/autoload.php');
require_once(__DIR__ . '/../config.php');
require_once(__DIR__ . '/./Common.php');

use TencentCloud\Ess\V20201111\Models\CreateFlowByFilesRequest;
use TencentCloud\Ess\V20201111\Models\UserInfo;

// 此接口（CreateFlowByFiles）用来通过上传后的pdf资源编号来创建待签署的合同流程。
// 适用场景1：适用非制式的合同文件签署。一般开发者自己有完整的签署文件，可以通过该接口传入完整的PDF文件及流程信息生成待签署的合同流程。
// 适用场景2：可通过改接口传入制式合同文件，同时在指定位置添加签署控件。可以起到接口创建临时模板的效果。如果是标准的制式文件，建议使用模板功能生成模板ID进行合同流程的生成。
// 注意事项：该接口需要依赖“多文件上传”接口生成pdf资源编号（FileIds）进行使用。
function CreateFlowByFileId($operatorUserId, $flowName, $approvers, $fileId)
{
    // 构造客户端调用实例
    $client = GetClientInstance(Config::secretId, Config::secretKey, Config::endPoint);

    // 构造请求体
    $req = new CreateFlowByFilesRequest();

    // 调用方用户信息，参考通用结构
    $userInfo = new UserInfo();
    $userInfo->setUserId($operatorUserId);
    $req->setOperator($userInfo);

    // 签署pdf文件的资源编号列表，通过UploadFiles接口获取
    $req->FileIds = [];
    $req->FileIds[] = $fileId;

    $req->Approvers = [];
    array_push($req->Approvers, ...$approvers);

    // 签署流程名称,最大长度200个字符
    $req->setFlowName($flowName);

    $resp = $client->CreateFlowByFiles($req);

    return $resp;
}
