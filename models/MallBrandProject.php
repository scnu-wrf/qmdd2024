<?php

class MallBrandProject extends BaseModel {

    public function tableName() {
        return '{{mall_brand_project}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('brand_id', 'required', 'message' => '{attribute} 不能为空'),
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
            array('brand_id, project_id', 'numerical', 'integerOnly' => true),
                //array('', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_brand_street' => array(self::BELONGS_TO, 'MallBrandStreet', 'brand_id'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'project_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'brand_id' => '品牌',
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
