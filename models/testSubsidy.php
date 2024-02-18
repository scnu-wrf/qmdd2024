<?php

class testSubsidy extends BaseModel {
    public function tableName() {
        return '{{test_subsidy}}';
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
            'comCode' =>'社区编号',
            'comName' =>'社区名称',
            'staCode' =>'场馆编号',
            'staName' =>'场馆名称',
            'venCode' =>'场地编号',
            'venName' =>'场地名称',
            'code' =>'补贴券编号',
            'name' =>'补贴券名称',
            'price' =>'可折扣金额(元)',
            'listTime' =>'上架时间',
            'delistTime' =>'下架时间',
            'audState' =>'审核状态',
            'reviewCom' =>'审核意见'
       );
    }

    public function getrelations() {
      $s1='testVenue,venName:name,comCode&comName&staCode&staName&venCode:code';
      return $s1;
    }

    protected function afterFind(){
        parent::afterFind();
        return true;
    }

    protected function beforeSave(){
        parent::beforeSave();
        return true;
    }

    // public function keySelect(){
    //     return array("audState='审核通过'",'id','name');
    // }

    // public function picLabels() {
    //     return 'pic';
    // }

    // public function pathLabels(){ 
    //     return '';
    // } 

}
