<?php

class QmddServerType extends BaseModel {
    public function tableName() {
        return '{{qmdd_server_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
                array('t_code','required','message'=>'{attribute} 不能为空'),
                array('t_name','required','message'=>'{attribute} 不能为空'),
                // array('t_eday','required','message'=>'{attribute} 不能为空'),
                // array('t_count','required','message'=>'{attribute} 不能为空'),
                // array('t_timeset','required','message'=>'{attribute} 不能为空'),
                array('id,t_code,t_name,t_eday,t_count,t_timeset,t_daymore,if_user,if_user_name,if_del,add_time', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code_if_user' => array(self::BELONGS_TO, 'BaseCode', 'if_user'),
            'base_code_if_del' => array(self::BELONGS_TO, 'BaseCode', 'if_del'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            't_code' => '编码',
            't_name' =>  '名称',
            't_eday' => '单位',
            't_count' => '数量',
            't_timeset' =>  '每天时间段数',
            't_daymore' =>  '跨多天',
            'if_user' => ' 是否使用', //是否使用，关联base_code表yes_no类型id 648=否，649是,
            'if_user_name' => '是否使用说明',
            'if_del' => '是否删除',//是否删除，关联base_code表DATA类型 509-逻辑删除 510正常,
            'add_time' =>  '添加时间',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }

 
	public function getServertype() {
		return $this->findAll('if_del=510');
    }
}
