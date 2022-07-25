<?php

// 基础配置，调用API之前必须填充的参数
class Config
{
    // 调用API的密钥对，通过腾讯云控制台获取
    const secretId = '****************';
    const secretKey = '****************';

    // operatorUserId: 经办人Id，电子签控制台获取
    const operatorUserId = '****************';

    // 企业方静默签用的印章Id，电子签控制台获取
    const serverSignSealId = "****************";

    // 模板Id，电子签控制台获取，仅在通过模板发起时使用
    const templateId = "****************";

    // API域名，现网使用 ess.tencentcloudapi.com
    const endPoint = 'ess.test.ess.tencent.cn';

    // 文件服务域名，现网使用 file.ess.tencent.cn
    const fileServiceEndPoint = 'file.test.ess.tencent.cn';

}
