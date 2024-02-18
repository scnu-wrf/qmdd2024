<?php

class VideoLiveClub extends BaseModel {
    public function tableName() {
        return '{{video_live_club}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
		return array(
            array('club_code', 'required', 'message' => '{attribute} 不能为空'),
            //array('is_read', 'required', 'message' => '{attribute} 请先阅读《直播服务协议》'),
			array('club_id,club_code,club_name,club_type,partnership_type,partnership_name,apply_name,contact_phone,email,contact_address,apply_time,uDate,state,state_time,if_del,server_type,is_read','safe'), 
		);
		
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'clubtype' => array(self::BELONGS_TO, 'BaseCode', 'club_type'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
		);
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
			'club_id' => '单位id',
			'club_code' => '单位帐号',
			'club_name' => '服务平台名称',
			'partnership_type' => '单位类型',
			'partnership_name' => '单位类型',
			'apply_name' => '联系人',
			'contact_phone' => '联系电话',
			'email' => '电子邮箱',
			'contact_address' => '联系地址',
			'server_type' => '直播类型',
			
			'apply_time' => '申请日期',
			'uDate' => '更新时间',
			'state' => '审核状态',
			'state_name' => '状态名称',
			'state_time' => '审核日期',
			'if_del' => '是否删除',
			'is_read' => '阅读并同意',
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
			//$this->apply_time = date('Y-m-d');
        }
        
        $this->reasons_adminid = Yii::app()->session['admin_id'];
        $this->reasons_adminname = Yii::app()->session['gfnick'];
        $this->uDate = date('Y-m-d h:i:s');
		
        return true;
	}

}
