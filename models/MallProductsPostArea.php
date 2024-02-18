<?php

class MallProductsPostArea extends BaseModel {

    public function tableName() {
        return '{{mall_products_post_area}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('post_id', 'required', 'message' => '{attribute} 不能为空'),
            array('post_id,code,post_area_code', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            //'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'mall_products_id'),
            't_region' => array(self::BELONGS_TO, 'TRegion', 'post_area_code'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'post_id' => '运费方案',
            'post_area_code' => '区域编号',
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
