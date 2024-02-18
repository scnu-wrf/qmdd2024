<?php

class GfCreditHistory extends BaseModel {
	
	public $beans_num = '';
	
    public function tableName() {
        return '{{gf_credit_history}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            //array('gf_id', 'required', 'message' => '{attribute} 不能为空'),
            array('object,gf_id,item_code,got_credit_reson,service_source,order_num,add_or_reduce,credit,add_time,admin_id,admin_account,state,reasons_for_failure,exchange_time', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'clubname' => array(self::BELONGS_TO, 'ClubList', 'gf_id'),
            'gfuser' => array(self::BELONGS_TO, 'userlist', 'gf_id'),
            'clubName' => array(self::BELONGS_TO, 'ClubList', 'get_id'),
            'gfUser' => array(self::BELONGS_TO, 'userlist', 'get_id'),
            'ordernum' => array(self::BELONGS_TO, 'MallSalesOrderInfo', ['order_num'=>'order_num']),
            'gfCredit' => array(self::BELONGS_TO, 'GfCredit', 'item_code'),
            'beansHistory' => array(self::BELONGS_TO, 'BeansHistory', ['id'=>'gf_credit_id']),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'gf_id' => '积分获得者',
            'account' => '获得积分者GF会员账号/单位账号',
            'nickname' => '获得积分者单位名称/GF会员昵称',
            'get_id' => '消费者账号',
            'item_code' => '消费项目',
            'got_credit_reson' => '消费项目',
            'service_source' => '服务关联信息',
            'credit' => '转换积分',
            'add_or_reduce' => '加或减分',
			'add_time' => '消费日期',
			'exchange_time' => '确认时间',
			'beans_num' => '体育豆数量',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
		if ($this->isNewRecord) {
			
			$this->add_time = date('Y-m-d h:i:s');
			$this->admin_id = Yii::app()->session['admin_id'];
			
        }
		

        return true;
    }

}
