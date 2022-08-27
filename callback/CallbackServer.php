<?php

try {
    // 此处填入CallbackUrlKey
    $key = '******************';
    $iv = substr($key, 0, 16);

    // 加密方式
    $method = 'AES-256-CBC';

    // 获取推送的body内容
    $data = file_get_contents("php://input");

    // 解密后的明文，为json格式字符串，格式见
    // https://cloud.tencent.com/document/product/1323/72309#.E5.9B.9E.E8.B0.83.E6.95.B0.E6.8D.AE.E6.9C.89.E5.93.AA.E4.BA.9B.E5.8F.82.E6.95.B0.E5.91.A2.EF.BC.9F
    $plaintext = openssl_decrypt(base64_decode($data), $method, $key, OPENSSL_RAW_DATA, $iv);

    // 对json格式字符串进行编码
    $arr = json_decode($plaintext, true);

    // 解析为对象
    $flowInfo = new FlowInfo($arr);

    // 流程id
    $flowId = $flowInfo->FlowId;

    // todo 获取参数&业务处理

    print_r("ok");

} catch (Exception $e) {
    echo $e;
}

/**
 * 回调数据对象 FlowInfo
 */
class FlowInfo
{

    /**
     * 将回调数据转化为封装对象
     */
    function __construct(array $data)
    {
        $this->Approvers = [];
        foreach ($data as $key => $val) {
            // Approvers单独处理
            if ($key == "Approvers") {
                foreach ($val as $approver) {
                    array_push($this->Approvers, new Approver($approver));
                }
            } else {
                $this->$key = $val;
            }
        }
    }

    /**
     * @var string 流程编号。
     */
    public $FlowId;

    /**
     * @var string 使用的文档 ID。
     */
    public $DocumentId;

    /**
     * @var string 回调的类型：
     * sign：签署回调
     * review：审核回调
     */
    public $CallbackType;

    /**
     * @var string 流程名称。
     */
    public $FlowName;

    /**
     * @var string 流程的类型。
     */
    public $FlowType;

    /**
     * @var string 流程的描述。
     */
    public $FlowDescription;

    /**
     * @var boolean 流程类型顺序：
     * true：为无序
     * false：为有序
     */
    public $Unordered;

    /**
     * @var integer 流程的创建时间戳。
     */
    public $CreateOn;

    /**
     * @var integer 流程的修改时间戳。
     */
    public $UpdatedOn;

    /**
     * @var integer 流程的过期时间0为永远不过期。
     */
    public $DeadLine;

    /**
     * @var integer 流程现在的状态：
     * 1：待签署
     * 2：部分签署
     * 3：已拒签
     * 4：已签署
     * 5：已过期
     * 6：已撤销
     */
    public $FlowCallbackStatus;

    /**
     * @var string 本环节需要操作人 UserId。
     */
    public $UserId;

    /**
     * @var string 签署区 ID。
     */
    public $RecipientId;

    /**
     * @var string 动作：
     * start：发起
     * sign：签署
     * reject：拒签
     * cancel：取消
     * finish：结束
     * deadline：过期
     */
    public $Operate;

    /**
     * @var string 创建的时候设置的透传字段。
     */
    public $UserData;

    /**
     * @var array 流程签约方列表。
     */
    public $Approvers;

}

/**
 * FlowInfo 参数 Approver 结构
 */
class Approver
{

    /**
     * 将回调数据转化为封装对象
     */
    function __construct(array $data)
    {
        foreach ($data as $key => $val) {
            $this->$key = $val;
        }
    }

    /**
     * @var string 本环节需要操作人 UserId。
     */
    public $UserId;

    /**
     * @var string 签署区 ID。
     */
    public $RecipientId;

    /**
     * @var integer 参与者类型：
     * 0：企业
     * 1：个人
     * 3：企业静默签署
     */
    public $ApproverType;

    /**
     * @var string 企业名字。
     */
    public $OrganizationName;

    /**
     * @var boolean 是否需要签名。
     */
    public $Required;

    /**
     * @var string 本环节需要操作人的名字。
     */
    public $ApproverName;

    /**
     * @var string 本环节需要操作人的手机号。
     */
    public $ApproverMobile;

    /**
     * @var string 签署人证件类型：
     * ID_CARD：身份证。
     * HONGKONG_AND_MACAO：港澳居民来往内地通行证。
     * HONGKONG_MACAO_AND_TAIWAN：港澳台居民居住证(格式同居民身份证)。
     */
    public $ApproverIdCardType;

    /**
     * @var string 签署人证件号码。
     */
    public $ApproverIdCardNumber;

    /**
     * @var integer 签署状态：
     * 2：待签署
     * 3：已签署
     * 4：已拒签
     * 5：已过期
     * 6：已撤销
     */
    public $ApproveCallbackStatus;

    /**
     * @var string 拒签的原因。
     */
    public $ApproveMessage;

    /**
     * @var string 签署意愿方式，WEIXINAPP：人脸识别。
     */
    public $VerifyChannel;

    /**
     * @var integer 签约的时间。
     */
    public $ApproveTime;

}

