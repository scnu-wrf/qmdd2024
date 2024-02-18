<?php

class testStadiumPolicy extends BaseModel { 
    public function tableName() {
        return '{{test_stadium_policy}}';
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
           'stadium_id'=>'场馆编号',
           'stadium_name'=>'场馆名称',
           'place_type'=>'场地类型',
           'up_time'=>'上线时间',
           'advance_day'=>'提前订场天数',
           'down_time'=>'下线时间',
           'line_day'=>'订场截止天数',
           'sell_time'=>'营业时间',
           'place'=>'场地',
           'policy_id'=>'价格策略编码',
           'policy_name'=>'价格策略名称',
           'start_day'=>'开始日期',
           'end_day'=>'结束日期',
       );
    }
    protected function afterFind(){
        parent::afterFind();
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        $w1="audState='审核通过' and listTime<='".$this->sell_time."'";
        $w1.=" and delistTime>='".$this->sell_time."'";
        $w1.=" and staName='".$this->stadium_name."'";
        $w1.=" and venName LIKE '%".$this->place."%'";
        $tmp = testSubsidy::model()->find($w1);
        $this->setFromArray($tmp,'subCode:code,subName:name,subPrice:price');
        return true;
    }
    /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    // public function keySelect(){
    //     return array('1=1', 'id', 'name:name');
    // }

}