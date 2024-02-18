<?php

class testPlaceType extends BaseModel { 
    public function tableName() {
        return '{{test_ventype}}';
    }
    /*** Returns the static model of the specified AR class. */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**  * 模型关联规则  */
    public function relations() {
        return array();
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
        return array(
           'id'=>'内部id',
           'code'=>'类型编码',
           'name'=>'类型名称',
           'remark'=>'备注'
       );
    }
    protected function afterFind(){
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
    /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    public function keySelect(){
        return array('1', 'id', 'name');
    }
  public function getAll(){
        return testPlaceType::model()->findAll();
    }

}