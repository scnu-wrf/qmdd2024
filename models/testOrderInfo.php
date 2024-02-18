<?php

class testOrderInfo extends BaseModel { 
    public function tableName() {
        return '{{testOrderInfo}}';
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
           'order_code'=>'订单号',
           'order_title'=>'订单说明',
           'order_type'=>'订单类型',
           'rec_code'=>'购买者账号',
           'rec_name'=>'购买者姓名',
           'rec_phone'=>'购买者电话',
           'order_date'=>'下单时间',
           'stadium_id'=>'场馆编号',
           'stadium_name'=>'场馆名称',
           'money'=>'价格',
           'pay_type'=>'支付方式',
           'pay_code'=>'支付单号',
           'pay_time'=>'支付时间',
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
    // public function keySelect(){
    //     return array('1=1', 'id', 'name:name');
    // }

}