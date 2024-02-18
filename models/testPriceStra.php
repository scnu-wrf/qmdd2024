<?php

class testPriceStra extends BaseModel { 
    public function tableName() {
        return '{{test_price_stra}}';
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
           'id'=>'编号',
           'comCode'=>'所属社区编码',
           'comName'=>'所属社区名称',
           'staCode'=>'所属场馆编码',
           'staName'=>'所属场馆名称',
           'code'=>'策略编码',
           'name'=>'策略名称',
           'remark'=>'备注',
           'time'=>'有效期',
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
        return array('1=1', 'id', 'name:name');
    }

}