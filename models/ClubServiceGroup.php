<?php

class ClubServiceGroup extends BaseModel {

	public $not_null = '123';
	public $group_member = '';
    public function tableName() {
        return '{{gf_club_customer_service_group}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('group_name', 'required', 'message' => '{attribute} 不能为空'),
			array('problem_type', 'required', 'message' => '{attribute} 不能为空'),
            array('id,group_name,problem_type,club_id', 'safe'),
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
			'group_name' => '组名称',
			'problem_type' => '业务类型',
			'club_id' => '单位id',
			'group_member' => '组成员',
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
            $members=ClubServiceGroup::model()->findBySql('select GROUP_CONCAT(u.ZSXM) as group_member from userlist u,qmdd_administrators q,gf_club_customer_service_group_member m,gf_club_customer_service_group g where find_in_set(g.id,m.group_id) and m.admin_id=q.id and q.admin_gfid=u.GF_ID and g.id=' . $this->id);
            $this->group_member = $members['group_member'];
        }
        return true;
    }
	
	protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}
