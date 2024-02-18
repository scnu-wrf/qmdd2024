<?php
$AdapaySdkUrl = dirname(dirname(__FILE__)). "\admin\\extensions\adapay_sdk_php\adapay_sdk_php_v1.4.4\AdapaySdk\init.php";
$AdapayConfigPHPUrl = dirname(dirname(__FILE__)). "\admin\\extensions\adapay_sdk_php\adapay_sdk_php_v1.4.4\AdapaySdk\config.php";
$AdapayConfigJSONUrl = dirname(dirname(__FILE__)). "\admin\\extensions\adapay_sdk_php\adapay_sdk_php_v1.4.4\AdapaySdk\config\merchantConfig.json";

// 加载基础 adapay 基础类
// SDK 初始化文件加载
include_once  $AdapaySdkUrl;
// 在文件中设置 DEBUG 为 true 时， 则可以打印日志到指定的日志目录下 LOG_DIR
include_once  $AdapayConfigPHPUrl;

// 商户接入AdaPay SDK时需要设置的初始化参数，设置配置从配置文件读取
\AdaPay\AdaPay::init($AdapayConfigJSONUrl, "live");

class Adapay extends BaseModel{
    //定义app_id，在支付的第三方后台上获取
    public $APPID = "app_4fdd32c3-c8bc-4b6c-870e-2bcadadf4b73";
    //RSA 商户私钥
    public $RSA_PRIVATE_KEY = "MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBAKtM7I6z7r1bdzdolOoPd64cm3JHSDL0tDbH0XXmwLinLAEUNbp/j5cFVdSUIgMvpO1XvokqDlINSnmHV6qAlYBMCuJss1JgX/GpAmvrveD+5laEtCuSU7mwsO6cFlkfmOdmLQihKVWEUYPt7xenLBCA2ttJuCvGBGzP7o3w5Zj7AgMBAAECgYAS9VQBpSX+fKwl4eQH6tym1JFa+qBMd2r8hxfbpxqxilrjPFkyl0yNJ8Ysh+p4aiJO3D+rpDpqgqsOkS02zb1TLnvr0LEoSAEozyGkQu3rfeBls4b1tKuGj3WH205zgSQY0BSUU8vxwxhA1qh9dqzoN/ts7eYzx4z1sc6wKP7yMQJBAM6nz3LGxnhahBMXuLEFAOFjTzaE8NPAGpSNrd0O0OD26Qdmk0T5uQjcWAEsbehPy/G0g11spmirQyGcgJghdGsCQQDUM/loL7OyFjYlCJlEeAweGp+Wig8Casbz2ekh3i3Z4Tzmk4Z1gCDxV5vKE9HIJERvBTppL/YI5xG2TqQ1WxGxAkAladoz5GrgNTr+HehRHB/JrmoT68OSApCNXo0gnWMRp4IO1fJJpZBrW0EPjVSkn3XD37N8wYPrJT51IllhsYTbAkBaXevXT4Eh1M2oBbpnawwWAdZ2YEK2D8y76c+bKaezAnVR5/85qJ/exyVD8B7FMZSnBr3yL4eCEQz86w6I3khxAkEAsZ7aBc4U4pPzlU/Pp9epzijkITGQJygoKS6wurRWEhiiQ2MCBvP5ENkF6Hd8mMAvbGYShX3QmyKyEATQ6+ELaA==";

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{mall_sales_order_info}}';
    }

    //支付部分
    #发起支付
    public function Payment($OPENID, $AMT, $PRODUCT = '', $PRODUCTID = '', $DESC = '', $CHOOSESTADIUMOBJ = [],
                            $USERNAME = '', $USERPHONE = '', $USERID = '', $COACH = [] ){
        # 初始化支付类
        $payment = new \AdaPaySdk\Payment();
        // 付款金额保留两位数（这里需要注意就算是正数也需要保留两位小数）param1：付款金额，param2：保留位数
        $pay_amt = number_format($AMT, 2);
        // 付款人微信 open_id 要先通过微信获取 《付款人》 的openid
        $open_id = $OPENID;
        //自定义的订单号，规则：用户电话号码＋YmdHis时间戳＋随机数
        $order_no = $USERPHONE . date("YmdHis") . rand(100000, 999999);
        //下单时间
        $order_time = date('Y-m-d H:i:s');

        #发起之前在这里单独存储一下订单信息（如：订单号、金额、付款人openid、以及其他你需要的信息，方便后面使用）
        //未支付=0，已支付=1，已支付未使用=10，已支付已使用=11
        $this->StorePaymentStatus("0", $PRODUCTID, $PRODUCT, $CHOOSESTADIUMOBJ, $USERID, $USERNAME, $USERPHONE, $pay_amt, $order_no, $order_time, $COACH);

        # 支付设置
        $payment_params = array(
            "app_id"      => $this->APPID,//引用枚举定义的app_id
            "order_no"    => $order_no,//订单号
            "pay_channel" => "wx_lite",//支付渠道（官网文档有说明,wx_lite是微信小程序）
            "pay_amt"     => $pay_amt,//商品_付款总金额
            "goods_title" => $PRODUCT,// 商品_标题
            "goods_desc"  => $DESC,// 商品_描述
            "notify_url"  => "http://域名（或ip）/这里放你接收回调的方法路径",//通知回调地址
            "expend"      => [ //（微信）付款人open_id
                "open_id" => $open_id
            ]
        );

        # 发起支付
        $payment->create($payment_params);

        # 对支付结果进行处理（可以在这一步将成功失败信息存储起来）
        if ($payment->isError()) { // 失败
            $aData = [
                "app_id"      => $payment->result["app_id"],
                "error_code"  => $payment->result["error_code"],
                "error_msg"   => $payment->result["error_msg"],
                // "error_type"  => $payment->result["error_type"],
                "order_no"    => $payment->result["order_no"],
                "pay_amt"     => $payment->result["pay_amt"],
                "pay_channel" => $payment->result["pay_channel"],
                "status"      => $payment->result["status"],
            ];
            put_msg("Adapay支付失败");
            put_msg($aData);
            // Db::table("日志表名")->insert($aData);
            return $payment->result;
        }
        else { // 成功
            $aData = [
                "request_id"   => $payment->result["id"],
                "created_time" => $payment->result["created_time"],
                "order_no"     => $payment->result["order_no"],
                "prod_mode"    => $payment->result["prod_mode"],
                "app_id"       => $payment->result["app_id"],
                "pay_channel"  => $payment->result["pay_channel"],
                "pay_amt"      => $payment->result["pay_amt"],
                "query_url"    => $payment->result["query_url"],
                "status"       => $payment->result["status"],
                "expend"       => $payment->result["expend"]["pay_info"],
            ];
            # 成功处理_返回pay_info信息给前端
            put_msg("Adapay支付成功");
            put_msg($aData);
            // Db::table("日志表名")->insert($aData);

            # 这里很重要！！ 需要将 pay_info 返回给前端取调起微信支付
            return $payment->result["expend"]["pay_info"];
        }
    }

    //储一下订单信息
    function StorePaymentStatus($TYPE, $PRODUCTID = '',$PRODUCT = '', $CHOOSESTADIUMOBJ = [], $USERID = '',
                                       $USERNAME = '', $USERPHONE = '', $PAYAMT = '', $ORDERNO = '', $ORDERTIME = '',
                                       $COACH = []){
        if($TYPE == "0"){ //未支付
            $LIST = $this->SwitchObjValToList($CHOOSESTADIUMOBJ,'id');
            testShoppingInfo::model()->addShopping($PRODUCTID, $PRODUCT, $LIST, $USERID, $USERNAME, $USERPHONE, $PAYAMT, $ORDERNO, $ORDERTIME, $COACH,1);
        }
        else if($TYPE == "1"){ //已支付

        }
        else if($TYPE == "10"){ //已支付未使用

        }
        else if($TYPE == "11"){ //已支付已使用

        }
        else{

        }

    }
    //将场地列表的id拿出来
    function SwitchObjValToList($obj, $value){
        $array = json_decode($obj);
        $list = Array();
        foreach ($array as $item)
            array_push($list, $item->$value ? $item->$value : '');
        return $list;
    }


    #支付订单查询
    public function PaymentOrderQuery(){
        # 初始化支付类
        $payment = new \AdaPaySdk\Payment();
        #发起支付订单查询
        $payment->query(["payment_id"=> "002112019091919132010020717028587851776"]); //test

        # 对关单结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            # 加载SDK需要的文件
            var_dump($payment->result);
        }
    }


    #查询支付对象列表，通过该接口，实现对已发起的支付对象查询功能，支持使用请求订单号、支付对象id、以及按时间范围分页查询。
    public function PaymentObjectListQuery(){
        # 加载SDK需要的文件
        include_once  dirname(__FILE__). "/../admin/extensions/AdapaySdk/init.php";
        # 加载商户的配置文件
        include_once  dirname(__FILE__). "/../admin/extensions/AdapayConfig.php";
        # 初始化支付类
        $payment = new \AdaPaySdk\Payment();
        # 请求参数
        $payment_params = array(
            "app_id"=> "app_7d87c043-aae3-4357-9b2c-269349a980d6",
            "payment_id"=> "10000000000000001",
            "order_no"=> "20190919071231283468359213",
            "page_index"=> "",
            "page_size"=> "",
            "created_gte"=> "",
            "created_lte"=> ""
        );
        $payment->queryList($payment_params);
        # 对支付结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    #关闭订单
    #针对已经创建的 Payment，您可以调用关单接口进行交易的关闭。
    public function PayClose(){
        # 初始化支付类
        $payment = new \AdaPaySdk\Payment();
        $payment_params = array(
            # 设置支付对象ID
            "payment_id"=> "002112019091919132010020717028587851776",
            # 设置描述
            "reason"=> "关单描述",
            # 设置扩展域
            "expend"=> "{'key': '1233'}"
        );
        # 发起关单
        $payment->orderClose($payment_params);
        # 对关单结果进行处理
        # $payment->result 类型为数组
        if ($payment->isError()){
            //失败处理
        var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    //退款部分
    #发起退款
    #当您的业务需要发起退款时，可通过 Adapay 系统提供的创建 Refund对象 方法创建一个退款对象，发起退款请求。
    public function Refund(){
        #初始化退款对象
        $refund = new \AdaPaySdk\refund();
        $refund_params = array(
            # 原交易支付对象ID
            "payment_id"=> "002112019091919132010020717028587851776",
            # 退款订单号
            "refund_order_no"=> "20190919073834683566123",
            # 退款金额
            "refund_amt"=> "0.01",
            # 退款描述
            "reason"=> "退款描述",
            # 扩展域
            "expend"=> "",
            # 设备静态信息
            "device_info"=> ""
        );
        # 发起退款
        $refund->orderRefund($refund_params);
        # 对退款结果进行处理
        # $refund->result 类型为数组
        if ($refund->isError()){
            //失败处理
            var_dump($refund->result);
        } else {
            //成功处理
            var_dump($refund->result);
        }
    }


    #退款订单查询
    #通过 Refund对象 的 id 查询一个已创建的退款记录。
    public function RefundOrderQurey(){
        # 初始化退款对象
        $refund = new \AdaPaySdk\refund();
        # refund_id或charge_id二选一
        # 发起退款查询
        $refund->orderRefundQuery(["payment_id"=> "002112019091919132010020717028587851776"]);
        # 对退款结果进行处理
        # $refund->result 类型为数组
        if ($refund->isError()){
            //失败处理
            var_dump($refund->result);
        } else {
            //成功处理
            var_dump($refund->result);
        }
    }


    //支付撤销部分
    #创建支付撤销对象
    public function PaymentRevocation(){
    # 初始化支付类
        $payment = new \AdaPaySdk\PaymentReverse();
        $payment_params = array(
            # 支付对象ID
            "payment_id"=> "10000000000000001",
            # 商户app_id
            "app_id"=> "app_P000002052092068",
            # 撤销订单号
            "order_no"=> "R".date("YmdHis").rand(100000, 999999),
            # 撤销金额
            "reverse_amt"=> "0.01",
            # 通知地址
            "notify_url"=> "",
            # 撤销原因
            "reason"=> "订单支金额错误",
            # 扩展域
            "expand"=> "",
            # 设备信息
            "device_info"=> "",
        );
        # 发起支付撤销
        $payment->create($payment_params);
        # 对支付撤销结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    #查询支付撤销对象
    public function PaymentRevocationQuery(){
        # 初始化支付类
        $payment = new \AdaPaySdk\PaymentReverse();
        # 支付撤销设置
        $payment_params = array(
            "reverse_id"=> "1000000000001123333333"
        );
        # 发起支付撤销查询
        $payment->query($payment_params);
        # 对支付撤销结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    #查询支付撤销对象列表
    public function PaymentRevocationListQuery(){
        # 初始化支付类
        $payment = new \AdaPaySdk\PaymentReverse();
        # 支付撤销参数设置
        $payment_params = array(
            # 商户app_id
            "app_id"=> "1231123123123131231",
            # 支付对象ID
            "payment_id"=> "10023123123101",
            # 当前页码，取值范围1~300000，默认值为1
            "page_index"=> "",
            # 页面容量，取值范围1~20，默认值为10
            "page_size"=> "",
            # 查询大于等于创建时间
            "created_gte"=> "",
            # 查询小于等于创建时间
            "created_lte"=> ""
        );

        # 发起支付撤销查询
        $payment->queryList($payment_params);
        # 对支付结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    //支付确认部分
    #支付确认
    public function PayConfirm(){
        # 初始化支付类
        $payment = new \AdaPaySdk\PaymentConfirm();

        # 支付确认参数设置
        $payment_params = array(
            "payment_id"=> "123123123131231231",
            "order_no"=> date("YmdHis").rand(100000, 999999),
            "confirm_amt"=> "0.01",
            "description"=> "附件说明",
            "div_members"=> "" //分账参数列表 默认是数组List
        );

        # 发起支付确认创建
        $payment->create($payment_params);

        # 对支付确认创建结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    #查询支付确认
    public function PayConfirmQuery(){
        # 初始化支付类
        $payment = new \AdaPaySdk\PaymentConfirm();

        # 查询支付确认参数设置
        $payment_params = array(
            "payment_confirm_id"=> "100000000000012312344"
        );

        # 发起支付确认查询
        $payment->query($payment_params);

        # 对支付确认查询结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    #查询支付确认对象列表
    public function PayConfirmListQuery(){
        # 初始化支付类
        $payment = new \AdaPaySdk\PaymentConfirm();

        # 支付确认列表参数设置
        $payment_params = array(
            "app_id"=> "1231123123123131231",
            "payment_id"=> "10023123123101",
            "page_index"=> "",
            "page_size"=> "",
            "created_gte"=> "",
            "created_lte"=> ""
        );

        # 发起支付确认列表查询
        $payment->queryList($payment_params);

        # 对支付确认列表结果进行处理
        if ($payment->isError()){
            //失败处理
            var_dump($payment->result);
        } else {
            //成功处理
            var_dump($payment->result);
        }
    }


    //个人用户部分
    #创建用户
    #创建用户对象用于将商户 member_id 与 Adapay 系统做关联，
    #商户需要保证 member_id 在应用 app_id 下唯一。
    #关联完成后，可以创建结算账户用于用户分账功能，也可以更新用户对象禁用用户状态，禁用用户所有交易功能。
    public function CreateMember(){
        $member = new \AdaPaySdk\Member();
        $member_params = array(
            # app_id
            "app_id"=> "app_f8b14a77-dc24-433b-864f-98a62209d6c4",
            # 用户id
            "member_id"=> "hf_test_201999999999_1001",
            # 用户地址
            "location"=> "测试地址",
            # 用户邮箱
            "email"=> "123123@126.com",
            # 性别
            "gender"=> "MALE",
            # 用户手机号
            "tel_no"=> "18177722312",
            # 用户昵称
            "nickname"=> "test"
        );
        # 创建
        $member->create($member_params);

        # 对创建用户对象结果进行处理
        if ($member->isError()){
            //失败处理
            var_dump($member->result);
        } else {
            //成功处理
            var_dump($member->result);
        }
    }


    #查询用户
    #查询已创建的单个用户对象
    public function MemberQuery(){
        $member = new \AdaPaySdk\Member();

        # 查询用户对象
        $member->query(["app_id"=> "app_P000002052092068", "member_id"=> "hf_test_member_id_account2"]);

        # 对查询用户对象结果进行处理
        if ($member->isError()){
            //失败处理
            var_dump($member->result);
        } else {
            //成功处理
            var_dump($member->result);
        }
    }


    #更新用户
    #对创建完成用户对象更新用户基本信息，可对用户状态禁用，禁用后用户不能做其它交易。
    public function UpdateMember(){
        $member = new \AdaPaySdk\Member();

        # 更新用户对象设置
        $member_params = array(
            # app_id
            "app_id"=> "app_P000002052092068",
            # 用户id
            "member_id"=> "hf_test_member_id_account5",
            # 用户地址
            "location"=> "上海市徐汇区",
            # 用户邮箱
            "email"=> "12389919@qq.com",
            # 性别
            "gender"=> "M",
            # 用户手机号
            "tel_no"=> "app_f8b14a77-dc24-433b-864f-98a62209d6c4",
            # 是否禁用该用户
            "disabled"=> "N",
            # 用户昵称
            "nickname"=> "test",
        );
        # 更新用户对象
        $member->update($member_params);

        # 对更新用户对象结果进行处理
        if ($member->isError()){
            //失败处理
            var_dump($member->result);
        } else {
            //成功处理
            var_dump($member->result);
        }
    }


    #查询用户对象列表
    #对创建完成用户对象更新用户基本信息，可对用户状态禁用，禁用后用户不能做其它交易。
    public function MemberListQuery(){
        $member = new \AdaPaySdk\Member();
        $member_params = array(
            "app_id"=> "app_P000002052092068"
        );
        # 查询用户对象
        $member->query_list($member_params);

        # 对查询用户对象结果进行处理
        if ($member->isError()){
            //失败处理
            var_dump($member->result);
        } else {
            //成功处理
            var_dump($member->result);
        }
    }


    //企业用户部分
    #创建企业用户
    #通过本接口您可以创建企业用户，企业用户需要人工审核，审核完成后会发送异步消息通知，
    #若审核成功，则商户用户 member_id 与 Adapay 系统关联成功，
    #若审核失败，则可再次调用本接口提交正确的资料信息。
    public function CreateCropMember(){
        $member = new \AdaPaySdk\CropMember();
        $file_real_path = realpath('123.zip');
        $member_params = array(
            # app_id
            "app_id"=> "app_P000002052092068",
            # 商户用户id
            "member_id"=> "hf_test_member_id3",
            # 订单号
            "order_no"=> date("YmdHis").rand(100000, 999999),
            # 企业名称
            "name"=> "测试企业",
            # 省份
            "prov_code"=> "0031",
            # 地区
            "area_code"=> "3100",
            # 统一社会信用码
            "social_credit_code"=> "social_credit_code",
            "social_credit_code_expires"=> "20301109",
            # 经营范围
            "business_scope"=> "123123",
            # 法人姓名
            "legal_person"=> "frname",
            # 法人身份证号码
            "legal_cert_id"=> "1234567890",
            # 法人身份证有效期
            "legal_cert_id_expires"=> "20301010",
            # 法人手机号
            "legal_mp"=> "13333333333",
            # 企业地址
            "address"=> "1234567890",
            # 邮编
            "zip_code"=> "企业地址测试",
            # 企业电话
            "telphone"=> "1234567890",
            # 企业邮箱
            "email"=> "1234567890@126.com",
            # 上传附件
            "attach_file"=> new CURLFile($file_real_path),
            # 银行代码
            "bank_code"=> "1001",
            # 银行账户类型
            "bank_acct_type"=> "1",
        );
        # 创建企业用户
        $member->create($member_params);
        # 对创建企业用户结果进行处理
        if ($member->isError()){
            //失败处理
            var_dump($member->result);
        } else {
            //成功处理
            var_dump($member->result);
        }
    }


    #查询企业用户
    public function CropMemberQuery(){
        $member = new \AdaPaySdk\CropMember();

        # 查询企业用户
        $member->query(["app_id"=> "app_P000002052092068", "member_id"=> "a123456"]);

        # 对查询企业用户结果进行处理
        if ($member->isError()){
            //失败处理
            var_dump($member->result);
        } else {
            //成功处理
            var_dump($member->result);
        }
    }


    //结算账户部分
    #创建结算账户
    #商户的 member_id 与 Adapay 系统做关联后，
    #可以创建结算账户，用于用户分账功能，目前只支持绑定银行卡。
    public function CreateSettleAccount(){
        $account = new \AdaPaySdk\SettleAccount();
        $account_params = array(
            "app_id"=> "app_P000002052092068",
            "member_id"=> "hf_test_201999999999",
            "channel"=> "bank_account",
            "account_info"=> [
                "card_id" => "622202170300169222",
                "card_name" => "余益兰",
                "cert_id" => "310109200006068391",
                "cert_type" => "00",
                "tel_no" => "18888888881",
                "bank_code" => "03060000",
                "bank_name" => "建",
                "bank_acct_type" => "1",
                "prov_code" => "0031",
                "area_code" => "3100",
            ]
        );
        # 创建结算账户
        $account->create_settle($account_params);
        # 对创建结算账户结果进行处理
        if ($account->isError()){
            //失败处理
            var_dump($account->result);
        } else {
            //成功处理
            var_dump($account->result);
        }
    }


    #查询账户余额
    public function BalanceQuery(){
        # 初始化账户余额对象类
        $account = new \AdaPaySdk\SettleAccount();
        $account_params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'member_id'=> 'user_00008',
            'settle_account_id'=> '0035172521665088'
        );
        # 查询账户余额
        $account->balance($account_params);
        # 对查询账户余额结果进行处理
        if ($account->isError()){
            //失败处理
            var_dump($account->result);
        } else {
            //成功处理
            var_dump($account->result);
        }
    }


    #查询结算账户
    #查询已绑定的结算账户对象。
    public function SettleAccountQuery(){
        $account = new \AdaPaySdk\SettleAccount();
        $account_params = array(
            "app_id"=> "app_P000002052092068",
            "member_id"=> "hf_test_201999999999",
            "settle_account_id"=> "0006124815051328"
        );
        # 查询结算账户
        $account->query_settle($account_params);
        # 对查询结算账户结果进行处理
        if ($account->isError()){
            //失败处理
            var_dump($account->result);
        } else {
            //成功处理
            var_dump($account->result);
        }
    }


    #查询结算明细列表
    #使用 Adapay 系统生成的结算账户对象 id 查询已创建的结算账户对象信息。
    public function SettleDetailsListQuery(){
        # 初始化用户对象类
        $account = new \AdaPaySdk\SettleAccount();

        $account_params = array(
            "app_id"=> "app_P000002052092068",
            "member_id"=> "hf_test_member_id_account5",
            "settle_account_id"=> "0006017543466816",
            "begin_date"=> "20190705",
            "end_date"=> "20190806"
        );

        # 查询结算账户
        $account->query_settle_details($account_params);

        # 对查询结算账户结果进行处理
        if ($account->isError()){
            //失败处理
            var_dump($account->result);
        } else {
            //成功处理
            var_dump($account->result);
        }
    }


    #删除结算账户
    public function DeleteSettleAccount(){
        $account = new \AdaPaySdk\SettleAccount();

        $account_params = array(
            'app_id'=> 'app_f8b14a77-dc24-433b-864f-98a62209d6c4',
            'member_id'=> 'hf_test_member_id_account5',
            'settle_account_id'=> '0006017543466816'
        );

        # 结算账户
        $account->delete_settle($account_params);

        # 对删除结算账户结果进行处理
        if ($account->isError()){
            //失败处理
            var_dump($account->result);
        } else {
            //成功处理
            var_dump($account->result);
        }
    }


    #修改结算账户
    #修改已绑定的结算账户对象信息
    public function ModifySettleAccount(){
        $account = new \AdaPaySdk\SettleAccount();

        $account_params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'member_id'=> 'hf_test_201999999999',
            'settle_account_id'=> '0006124815051328',
            'min_amt'=> '',
            'remained_amt'=> '',
            'channel_remark'=> '123'
        );

        # 修改结算账户
        $account->modify_settle($account_params);

        # 对修改结算账户结果进行处理
        if ($account->isError()){
            //失败处理
            var_dump($account->result);
        } else {
            //成功处理
            var_dump($account->result);
        }
    }


    //钱包账户部分
    #钱包支付
    #通过该接口，实现对商户钱包支付功能，下单成功返回支付跳转地址
    public function WalletPay(){
        $account = new \AdaPaySdk\SettleAccount();

        $wallet_params = array(
            # 商户的应用 id
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            # 用户ID
            'order_no'=> "WL_". date("YmdHis").rand(100000, 999999),
            # 订单总金额（必须大于0）
            'pay_amt'=> '0.10',
            # 3 位 ISO 货币代码，小写字母
            'currency'=> 'cny',
            # 商品标题
            'goods_title'=> '12314',
            # 商品描述信息
            'goods_desc'=> '123122123',
        );
        $account->payment($wallet_params);
    }


    //取现部分
    #创建取现对象
    #通过该接口，实现对指定商户或者商户下用户的结算账户可用余额发起主动提现操作，
    #金额从账户中提到绑定的结算银行卡中。取现结果以异步通知为准。
    public function CreateDrawcash(){
        $drawcash = new \AdaPaySdk\Drawcash();
        $cash_params = array(
            'order_no'=> "CS_". date("YmdHis").rand(100000, 999999),
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'cash_type'=> 'T1',
            'cash_amt'=> '0.02',
            'member_id'=> 'user_00008',
            'notify_url'=> ''
        );
        # 账户取现
        $drawcash->create($cash_params);
        # 对账户取现结果进行处理
        if ($drawcash->isError()){
            //失败处理
            var_dump($drawcash->result);
        } else {
            //成功处理
            var_dump($drawcash->result);
        }
    }


    #取现查询
    #通过该接口，可以查询已发起的取现交易状态。
    public function DrawcashQuery(){
        # 初始化账户取现对象类
        $drawcash = new \AdaPaySdk\Drawcash();
        $cash_params = array(
            'order_no'=> "CS_20200720081844501083"
        );
        # 账户取现
        $drawcash->query($cash_params);
        # 对账户取现结果进行处理
        if ($drawcash->isError()){
            //失败处理
            var_dump($drawcash->result);
        } else {
            //成功处理
            var_dump($drawcash->result);
        }
    }


    //钱包部分
    #钱包登录
    public function WalletLogin(){
        $wallet = new \AdaPaySdk\Wallet();
        $wallet_params = array(
            # 应用ID
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            # 用户ID
            'member_id'=> 'hf_prod_member_20191013',
            # IP
            'ip'=> '192.168.1.152'
        );
        # 创建
        $wallet->login($wallet_params);
        echoExecuteResult($wallet, "钱包登录");
    }


    //账户转账部分
    #创建账户转账对象
    #创建账户转账对象仅支持同一商户下的用户与用户、用户与商户之间的转账。
    public function CreateSettleAccountTransfer(){
        # 初始化结算账户对象类
        $account_transfer = new \AdaPaySdk\SettleAccountTransfer();
        $params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'order_no'=> "TF_". date("YmdHis").rand(100000, 999999),
            'trans_amt'=> '0.10',
            'out_member_id'=> '0',
            'in_member_id' => 'user_000031'
        );
        # 创建结算账户
        $account_transfer->create($params);
        # 对创建结算账户结果进行处理
        if ($account_transfer->isError()){
            //失败处理
            var_dump($account_transfer->result);
        } else {
            //成功处理
            var_dump($account_transfer->result);
        }
    }


    #查询账户转账对象列表
    #可以基于时间范围进行查询，也可以使用原转账对象的订单号和状态进行查询
    public function SettleAccountTransferQuery(){
        # 初始化结算交易账户对象类
        $account_transfer = new \AdaPaySdk\SettleAccountTransfer();
        $params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'order_no'=> '',
            'status'=> '',
            'page_index'=> '1',
            'page_size'=> '10',
            'created_gte'=> '',
            'created_lte'=> ''
        );
        # 查询结算交易账户
        $account_transfer->queryList($params);
        # 对查询结算交易账户结果进行处理
        if ($account_transfer->isError()){
            //失败处理
            var_dump($account_transfer->result);
        } else {
            //成功处理
            var_dump($account_transfer->result);
        }
    }


    //账户冻结部分
    #创建账户冻结对象
    #通过该接口，实现对商户或者商户下用户的结算账户可用余额进行冻结操作。
    public function CreateFreezeAccount(){
        # 初始化账户冻结对象
        $fz_account = new \AdaPaySdk\FreezeAccount();

        $fz_params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'order_no'=> 'FZ_'. date("YmdHis").rand(100000, 999999),
            'trans_amt'=> '0.10',
            'member_id'=> 'member_id_test'
        );

        # 创建账户冻结对象
        $fz_account->create($fz_params);

        # 对创建账户冻结对象结果进行处理
        if ($fz_account->isError()){
            //失败处理
            var_dump($fz_account->result);
        } else {
            //成功处理
            var_dump($fz_account->result);
        }
    }


    #查询账户冻结对象列表
    #通过该接口，查询已发起的账户解冻交易，支持使用原解冻交易的请求订单号，以及时间范围查询。
    public function FreezeAccountQuery(){
        # 初始化账户冻结对象
        $fz_account = new \AdaPaySdk\FreezeAccount();

        $fz_params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'order_no'=> 'FZ_'. date("YmdHis").rand(100000, 999999),
            'status'=> 'succeeded', //succeeded-成功，failed-失败，pending-处理中
            'page_index'=> 1,
            'page_size'=> 1,
            'created_gte'=> '',
            'created_lte'=> ''
        );

        # 查询账户冻结对象
        $fz_account->queryList($fz_params);

        # 对查询账户冻结对象结果进行处理
        if ($fz_account->isError()){
            //失败处理
            var_dump($fz_account->result);
        } else {
            //成功处理
            var_dump($fz_account->result);
        }
    }


    //账户解冻部分
    #创建账户解冻对象
    #通过该接口，实现对已冻结的交易进行全额解冻操作。
    public function UnFreezeAccount(){
        # 初始化解冻账户对象类
        $un_fz_account = new \AdaPaySdk\UnFreezeAccount();

        $un_fz_params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'order_no'=> 'FZ_'. date("YmdHis").rand(100000, 999999),
            'account_freeze_id'=> '002112020111717230410174704123849117696'
        );

        # 创建解冻账户
        $un_fz_account->create($un_fz_params);

        # 对创建解冻账户结果进行处理
        if ($un_fz_account->isError()){
            //失败处理
            var_dump($un_fz_account->result);
        } else {
            //成功处理
            var_dump($un_fz_account->result);
        }
    }

    
    #查询账户解冻对象列表
    public function UnFreezeAccountListQuery(){
        # 初始化解冻账户对象类
        $un_fz_account = new \AdaPaySdk\FreezeAccount();

        $un_fz_params = array(
            'app_id'=> 'app_7d87c043-aae3-4357-9b2c-269349a980d6',
            'order_no'=> 'FZ_'. date("YmdHis").rand(100000, 999999),
            'status'=> 'succeeded', //succeeded-成功，failed-失败，pending-处理中
            'page_index'=> 1,
            'page_size'=> 1,
            'created_gte'=> '',
            'created_lte'=> ''
        );

        # 查询解冻账户
        $un_fz_account->queryList($un_fz_params);

        # 对查询解冻账户结果进行处理
        if ($un_fz_account->isError()){
            //失败处理
            var_dump($un_fz_account->result);
        } else {
            //成功处理
            var_dump($un_fz_account->result);
        }
    }

}