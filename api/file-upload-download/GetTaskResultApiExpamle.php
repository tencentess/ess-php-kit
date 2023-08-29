<?php
require_once(__DIR__ . '/./GetTaskResultApi.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 查询转换任务状态调用样例
try {

    $taskId = '***********************';

    $resp = GetTaskResultApi(Config::operatorUserId, $taskId);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
