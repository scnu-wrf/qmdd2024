<?php

class serviceGroupMember extends BaseModel {

	public $not_null = '123';
	public $group_name = '';
    public function tableName() {
        return '{{service_group_member}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('service_no', 'required', 'message' => '{attribute} 不能为空'),
			array('phone', 'required', 'message' => '{attribute} 不能为空'),
			array('admin_id', 'required', 'message' => '{attribute} 不能为空'),
			array('admin_nick', 'required', 'message' => '{attribute} 不能为空'),
			array('service_level', 'required', 'message' => '{attribute} 不能为空'),
            array('id,admin_id,admin_nick,service_no,phone,service_level,service_level_name,club_id,customer_service_type', 'safe'),
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
		'admin_id' => '客服账号',
		'admin_nick' => '客服昵称',
		'service_no' => '客服工号',
		'phone' => '联系电话',
		'group_id' => '所属客服组id',
		'group_name' => '所属客服组',
		'service_level' => '客服角色',
		'service_level_name' => '客服角色名称',
		'state' => '账号状态',
		'state_name' => '账号状态',
		'add_date' => '创建日期',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();
        if ($this->id != null) {
            $group=serviceGroupMember::model()->findBySql('select GROUP_CONCAT(g.group_name) as group_name from service_group g,service_group_member m  where find_in_set(g.id,m.group_id) and m.id=' . $this->id);
            $this->group_name = $group['group_name'];
        }
        return true;
    }
	
	protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}
