<?php

class LiveMessage extends BaseModel{
	public $gift_num_amount = '';
	public $gift_price_amount = '';
	public $GF_ACCOUNT = '';
	public $GF_NAME = '';
	

    public function tableName() {
        return '{{livemessage}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('rechange_virtual_coin','required','message' => '{attribute} 不能为空'),
            array('live_msg_code,live_id,live_program_id,live_program_title,live_program_time,live_program_end_time,login_id,
                    user_type,s_gfid,s_gfaccount,s_time,m_message,m_type,client_type,live_reward_id,live_reward_code,live_reward_name,
                    live_reward_price,live_reward_gfid,live_reward_gf_name,live_reward_actor_id,live_reward_actor_name,exchange_id,
                    set_details_id,recharge_amount,rechange_virtual_coin,exchange_code,pricing_details_id,order_num,is_pay,is_pay_name,pay_time','safe'),
        );
    }

    /**
     * 模型验证规则
     */
    public function relations() {
        return array(
            'mall_pricing_details_id' => array(self::BELONGS_TO,'MallPriceSetDetails','pricing_details_id'),
            'gf_s_gfid' => array(self::BELONGS_TO,'GfUser1','s_gfid'),
            'gf_live_reward_gfid' => array(self::BELONGS_TO,'GfUser1','live_reward_gfid'),
            'video_live_id' => array(self::BELONGS_TO,'VideoLive','live_id'),
            'programs' => array(self::BELONGS_TO, 'VideoLivePrograms', 'live_program_id'),
            'gf_r_gfid' => array(self::BELONGS_TO,'GfUser1','r_gfid'),
        );
    }

    /**
     * 属性
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'live_msg_code' => '年月日_id',  // 如20190328_68',
            'live_id' => '直播名称',  // 表明哪条直播频道',
            'live_program_id' => '直播节目id',  // video_live_programs表ID,
            'live_program_title' => '节目单名称 ',
            'live_program_time' => '直播开始时间',
            'live_program_end_time' => '直播结束时间',
            'login_id' => '发送GF_ID', // 对应表gf_user_login_history的id',
            'user_type' => '操作人类型',  // 1前端（gf会员） 2后台（管理员，服务机构）',
            's_gfid' => '发送者',  // user_type==1为gf_user_1表id，user_type=2为qmdd_adminstrtors表id',
            's_gfaccount' => '打赏者',  // gfaccount', 发送者账号
            's_time' => '发送时间',
            'm_message' => '消息内容',  // 为json格式数据base64编码',
            'm_type' => '消息类型',  // 0-充值虚拟币记录，31-纯文字，32-赞赏礼物，33-用户进入直播，34-用户离开直播,35-直播结束,36-直播互动、打赏设置调整通知',
            'client_type' => '发送者终端类型',  // 1、PC 2、MAC 3、IPHONE 4、IPAD 5、APHONE  6、APAD 7、其它',
            'live_reward_id' => '直播打赏id',  // 表video_live_reward的id,is_pay=464是打赏成功的，否则为打赏失败的（可能是删除操作失败遗留数据）',
            'live_reward_code' => '打赏编码',
            'live_reward_name' => '打赏名称',
            'live_reward_price' => '打赏价格',  //（虚拟币）',
            'live_reward_gfid' => '获打赏GF会员id',
            'live_reward_gf_name' => '获打赏者',  // 获打赏GF会员名称
            'live_reward_actor_id' => '获打赏直播演员id',
            'live_reward_actor_name' => '获打赏者',  // 获打赏演员名称
            'exchange_id' => '充值id',  // 表virtual_coin_exchange_settings的id',
            'set_details_id' => 'virtual_mall_price_set_details表id',
            'recharge_amount' => '充值金额',  // 仅当m_type=0时写入，充值兑换虚拟币',
            'rechange_virtual_coin' => '充值兑换虚拟币数量',
            'exchange_code' => '充值兑换编码',
            'pricing_details_id' => '充值商品',  // 定价表ID 关联mall_pricing_details,表示手改商品规定价钱及商品代码',
            'order_num' => '充值订单号',  // mall_sales_order_info表order_num',
            'is_pay' => '支付状态',  // 463未支付  464已支付',
            'is_pay_name' => '支付状态名称',
            'pay_time' => '支付时间',

            /* details & details_child */
            'gf_account' => '用户帐号',
            'gf_name' => '用户名称',
            'gf_name1' => '打赏人',
            'cover_name' => '被赏人',
            'gf_acc' => '打赏者帐号',
            'receiv_num' => '收到礼物数量',
            'gift_tatil' => '礼物总额（币）',
            'redenv_num' => '收到红包数量',
            'redenv_tatil' => '红包总额（元）',

            'notify_type' => '通知类型',

            'gift_name' => '礼物名称',
            'gift_price' => '礼物价格',
            'gift_money' => '礼物金额（币）',
            'redenv_money' => '红包金额（元）',
            'reward_type' => '打赏类型',
            'reward_time' => '打赏时间',

            /* index_details */
            'live_code' => '直播编号',
            'live_name' => '直播名称',
            'reward_gf_name' => '被打赏者',
            'video_club_name' => '直播单位',
            'video_num' => '直播场次',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function beforeSave() {
        parent::beforeSave();
        return true;
    }
}