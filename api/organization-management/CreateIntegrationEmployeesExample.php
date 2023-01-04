<?php
require_once(__DIR__ . '/./CreateIntegrationEmployees.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\Staff;

// 创建员工调用样例
try {

    $employee = new Staff();
    $employee->setDisplayName("***********************");
    $employee->setMobile("**********************");
    $employees = [$employee];

    $resp = CreateIntegrationEmployees(Config::operatorUserId, $employees);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
