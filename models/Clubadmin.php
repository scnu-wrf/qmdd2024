<?php

class Clubadmin extends BaseModel {
    public $project_list="";
    public $selectval="";
    
    public $password2 = '';
    public $password3 = '';
    public $password4 = '';
    public function tableName() {
        return '{{qmdd_administrators}}';
    }
       
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		'qmdd_administrators_project' => array(self::HAS_MANY, 'ClubadminProject', 'qmdd_admin_id'),
		);
    }
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
            'id' => 'ID',
            'admin_gfaccount' => '账号',
            'admin_gfnick' => '姓名',
            'club_code' => '社区编码',
            'club_name' => '社区名称',
            'admin_level' => '授权角色',
            'lang_type' => '类型',
            'user_name' => '用户',
            'admin_gfid' => '用户账号',
            'club_id' => '单位账号',
			'password' => '登录密码',
			'pay_pass'=>'支付密码',
			'project_list'=>'权限类型',
            'last_login' => '最后登录时间',
            'customer_service' => '是否客服',
			'password2' => '原密码',
			'password3' => '新密码',
			'password4' => '确认密码',
        );
    }

    public function getOne($id) {
        return $this->find('id=' . $id);
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	
	
	 protected function afterFind() {
        parent::afterFind();
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
    
    public function getTypeCode() {
        return array( 
            array('f_id' => '0','F_NAME' => '单位'),
            array('f_id' => '1','F_NAME' => '个人'),);
    }
	
}
