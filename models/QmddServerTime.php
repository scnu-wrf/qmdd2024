<?php

class QmddServerTime extends BaseModel {

    public function tableName() {
        return '{{qmdd_server_time}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            // array('timename','required','message'=>'{attribute} 不能为空'),
            array('start_time','required','message'=>'{attribute} 不能为空'),
            array('end_time','required','message'=>'{attribute} 不能为空'),
            array('id,timecode,timename,uDate,username,state,state_name,start_time,end_time', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
			'base_state' => array(self::BELONGS_TO, 'BaseCode', 'state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' => 'ID',
            'timecode' => '时间分段编码',
            'timename' => '时间分段名',
            'start_time' => '开始时间',
            'end_time' => '结束时间',
            'uDate' => '添加时间',
            'username' => '操作员',
            'state' => '状态，关联base_code表STATE类型状态id：371-374',
            'state_name' => '审核状态',
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
        // $base_state=BaseCode::model()->find('f_id='.$this->state);
        // $this->state_name=$base_state->F_NAME;
        $this->uDate=date('Y-m-d H:i:s');
        $this->username=Yii::app()->session['gfnick'];
        $this->timecode = explode(":",$this->timename)[0];

        return true;
    }

}
