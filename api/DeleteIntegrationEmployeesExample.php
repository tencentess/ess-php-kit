<?php
require_once(__DIR__ . '/./DeleteIntegrationEmployees.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\Staff;

// 移除员工调用样例
try {

    $employee = new Staff();
    $employee->setUserId("***********************");
    $employees = [$employee];

    $resp = DeleteIntegrationEmployees(Config::operatorUserId, $employees);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
