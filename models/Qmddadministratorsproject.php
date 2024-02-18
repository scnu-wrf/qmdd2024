<?php

class Qmddadministratorsproject extends BaseModel {

    public function tableName() {
        return '{{qmdd_administrators_project}}';//全民动动后台管理员授权项目
    }
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'qmdd_administrators' => array(self::BELONGS_TO, 'qmdd_administrators', 'id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'qmdd_admin_id' => '管理者ID',
            'project_id' => '项目',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
   public function getProjectIds($id) {
        $tmp=$this->findAll('qmdd_admin_id='.$id);
        return getIds($tmp,'project_id');
    }
}
