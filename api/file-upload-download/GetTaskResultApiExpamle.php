<?php
require_once(__DIR__ . '/./GetTaskResultApi.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

// 查询转换任务状态调用样例
try {
    // 任务Id，“创建文件转换任务”接口返回
    $taskId = '***********************';

    $resp = GetTaskResultApi(Config::operatorUserId, $taskId);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}
