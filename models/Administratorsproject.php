<?php

class Administratorsproject extends BaseModel {

    public function tableName() {
        return '{{qmdd_administrators_project}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
               array('mall_products_id,project_id', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'mall_products_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'mall_products_id' => '商品',
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
