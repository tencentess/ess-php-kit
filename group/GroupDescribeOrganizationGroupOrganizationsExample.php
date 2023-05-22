<?php
require_once(__DIR__ . '/./GroupDescribeOrganizationGroupOrganizations.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;

/**
 * 查询集团企业列表样例
 */
try {
    $limit = 10;
    $offset = 0;

    $resp = DescribeOrganizationGroupOrganizations(Config::operatorUserId, $limit, $offset);
    print_r($resp);
}
catch(TencentCloudSDKException $e) {
    echo $e;
}