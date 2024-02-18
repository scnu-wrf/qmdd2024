<?php

class testTimePolicy extends BaseModel { 
    public function tableName() {
        return '{{test_time_policy}}';
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
           'id'=>'id',
           'code' =>'编号',
           'name'=>'名称',
           'memo'=>'备注',
           'timespace'=>'时间间隔',
           'morning_start'=>'早上开始时间',
           'morning_end'=>'早上结束时间',
           'afternoon_start'=>'下午开始时间',
           'afternoon_end'=>'下午结束时间',
           'night_start'=>'晚上开始时间',
           'night_end'=>'晚上结束时间',
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
        return array('1=1', 'code', 'name');
    }

}