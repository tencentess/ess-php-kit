<?php
require_once(__DIR__ . '/./DescribeIntegrationEmployees.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\Filter;

// 查询员工信息调用样例
try {

    $filter = new Filter();
    $filter->setKey("Status");
    $filter->setValues(["IsVerified"]);
    $filters = [];
    array_push($filters, $filter);
    
    $limit = 20;
    $offset = 0;

    $resp = DescribeIntegrationEmployees(Config::operatorUserId, $limit, $offset, $filters);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}
