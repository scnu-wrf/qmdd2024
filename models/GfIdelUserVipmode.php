<?php

class GfIdelUserVipmode extends BaseModel {

	public $not_null = '123';
    public function tableName() {
        return '{{gf_idel_user_vipmode}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('f_name', 'required', 'message' => '{attribute} 不能为空'),
			array('f_mode', 'required', 'message' => '{attribute} 不能为空'),
			array('f_lvevl', 'required', 'message' => '{attribute} 不能为空'),
			array('f_rule', 'required', 'message' => '{attribute} 不能为空'),
            array('id,f_name,f_mode,f_len,f_lvevl,f_rule', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'id' => 'ID',
			'f_code' => 'VIP账号格式编码',
			'f_name' => '格式名称',
			'f_mode' => '格式说明',//X任意数字大写ABC..表示数字AA表示两个相同的数字0-9表示特定数字,XXXX999,表示后三位是999，小写abc表示三位是顺序升，如XXX123,XXX234,cba表示三位是顺序降如\r\nXXX321,XXX543
			'f_len' => '编码长度',//648否，649是
			'f_lvevl' => 'vip级别',
			'f_rule' => '正则规则',
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
        return true;
    }

}
