<?php
require_once(__DIR__ . '/./CreateDocument.php');

use TencentCloud\Common\Exception\TencentCloudSDKException;
use TencentCloud\Ess\V20201111\Models\FormField;

// 创建电子文档调用样例
try {
    $flowId = '********************************';
    $templateId = '********************************';
    $fileName = '文件名';

    $resp = CreateDocument(Config::operatorUserId, $flowId, $templateId, $fileName);

    print_r($resp);
} catch (TencentCloudSDKException $e) {
    echo $e;
}

// 设置发起人填写控件样例
function PackFormFieldsExample() {

    // 单行文本类型赋值 文本内容
    $text = new FormField();
    $text->setComponentName("单行文本1");
    $text->setComponentValue("单行文本内容");

    // 多行文本类型赋值 文本内容
    $multiLineText = new FormField();
    $text->setComponentName("多行文本1");
    $text->setComponentValue("多行文本内容");

    // 勾选框类型赋值 true/false
    $checkbox = new FormField();
    $checkbox->setComponentName("勾选框1");
    $checkbox->setComponentValue("true");

    // 选择器类型赋值 控制台选项值
    $selector = new FormField();
    $selector->setComponentName("选择器1");
    $selector->setComponentValue("选项一");

    // 附件类型赋值 UploadFiles接口上传返回的fileId
    $attachment = new FormField();
    $attachment->setComponentName("详见附件1");
    $attachment->setComponentValue("***********************");

    $formFields = [];
    array_push($formFields, $text, $multiLineText, $checkbox, $attachment, $selector);

    return $formFields;
}