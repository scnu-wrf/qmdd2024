<?php

class MallProductsTypeProject extends BaseModel {

    public function tableName() {
        return '{{mall_products_type_project}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('type_id', 'required', 'message' => '{attribute} 不能为空'),
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
            array('type_id, project_id', 'numerical', 'integerOnly' => true),
            array('tn_code', 'length', 'allowEmpty'=> true),
            array('type_id,project_id', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_products_type_sname' => array(self::BELONGS_TO, 'MallProductsTypeSname', 'type_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'type_id' => '商品分类',
            'tn_code' => '分类编码',
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
