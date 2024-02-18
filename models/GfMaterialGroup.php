<?php

class GfMaterialGroup extends BaseModel {

    public function tableName() {
        return '{{gf_material_group}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('group_name', 'required', 'message' => '{attribute} 不能为空'),
            array('group_num', 'numerical', 'integerOnly' => true),
			array('group_name,group_num,club_id,v_type', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'group_name' => '组名称',
            'group_num' => '组文件数量',
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
