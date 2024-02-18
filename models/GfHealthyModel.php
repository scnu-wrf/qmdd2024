<?php

class GfHealthyModel extends BaseModel {

    public $project_name = '';
    public $project_id = '';

    public function tableName() {
        return '{{gf_healthy_model}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('attr_name', 'required', 'message' => '{attribute} 不能为空'),
            array('attr_input_type', 'required', 'message' => '{attribute} 不能为空'), 
            // array('attr_values', 'required', 'message' => '{attribute} 不能为空'),
            //array('attr_unit', 'required', 'message' => '{attribute} 不能为空'),
            array('sort_order', 'numerical', 'integerOnly' => true),
            array('attr_name,attr_input_type,attr_values,attr_unit,sort_order', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'attr_input_type'),
            'gf_healthy_project' => array(self::HAS_MANY, 'GfHealthyProject', array('id'=>'healthy_id')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'attr_name' => '体检项目名',
            'attr_input_type' => '录入方式',  // 关联base_code表INPUT类型id：677-手工录入 678-从列表中选择 681-多行文本框 682-从列表中选择+收费 683-文件上传 720手功录入+下拉选择',
            'attr_unit' => '计量单位',
            'attr_values' => '可选值',  // 多个使用逗号“,”隔开',
            'sort_order' => '排序号',
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

    // public function getType(){
    //     // 参数一 关联Model名   参数二 关联字段 不能写表.t_id 自己默认后边是本Model的表id  前边是关联表的id
    //     return $this->hasOne(GfHealthyProject::className(),['healthy_id'=>'id']);
    // }

}
