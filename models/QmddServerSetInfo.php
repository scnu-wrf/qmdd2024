<?php

class QmddServerSetInfo extends BaseModel {
	public $product = '';
    public $setdata = '';

    public function tableName() {
        return '{{qmdd_server_set_info}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		   array('set_name', 'required', 'message' => '{attribute} 不能为空'),
		   array('f_typeid', 'required', 'message' => '{attribute} 不能为空'),
		   array('server_start', 'required', 'message' => '{attribute} 不能为空'),
           array('server_end', 'required', 'message' => '{attribute} 不能为空'),
           array('star_time', 'required', 'message' => '{attribute} 不能为空'),
           // array('end_time', 'required', 'message' => '{attribute} 不能为空'),
		   array('set_name,pricing_type,if_user_state,star_time,end_time,supplier_id,add_adminid,update_date,f_check,reasons_adminID,reasons_for_failure,reasons_time,product,,salesperson_profit_id,down_time,server_end,server_start,f_typeid,reasons_gfaccount', 'safe'),

        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'set_list' => array(self::HAS_MANY, 'QmddServerSetList', array('info_id' => 'id'),'condition'=>'if_del=510'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'f_check'),
			'servertype' => array(self::BELONGS_TO, 'QmddServerType', 'f_typeid'),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'supplier_id'),
			'salesperson_profit' => array(self::BELONGS_TO, 'ServerTimePrice', 'salesperson_profit_id'),
            'userstate' => array(self::BELONGS_TO, 'BaseCode', 'if_user_state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' =>'ID',
            'set_code' =>'资源编号',
            'set_name' => '服务标题',
            'f_typeid' => '服务类型',
			'f_typename' => '服务类型',
			'if_user_state' => '显示前端',
            'user_state_name' => '显示前端',
            'star_time' => '前端显示时间',
			'end_time' => '前端显示时间',
			'server_start' => '上架服务时间',
			'server_end' => '上架服务时间',
			'supplier_id' =>'发布单位',
            'add_adminid' => '添加管理员',
            'update_date' => '添加时间',
            'f_check' => '状态',
			'reasons_adminID' => '审核员',
			'reasons_for_failure' => '操作备注',
			'reasons_time' => '审核时间',
			'salesperson_profit_id' => '服务方案',
			'down_time' => '下架时间',

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

			$this->update_date = date('Y-m-d h:i:s');
			$this->add_adminid = Yii::app()->session['admin_id'];
			$this->pricing_type =353;
        }


        return true;
    }

}
