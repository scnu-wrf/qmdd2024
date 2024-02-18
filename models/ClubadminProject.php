<?php

class ClubadminProject extends BaseModel {

    public function tableName() {
        return '{{qmdd_administrators_project}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'qmdd_administrators' => array(self::BELONGS_TO, 'Clubadmin', 'qmdd_admin_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
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
            'qmdd_admin_id' => '管理者ID',
            'project_id' => '项目',
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
