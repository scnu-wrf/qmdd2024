<?php

class testSerType extends BaseModel {
    public function tableName() {
        return '{{test_serType}}';
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
            'remark' =>'备注',
            'code' =>'场地服务唯一编码',
            'name' =>'场地服务名称',
       );
    }

    protected function afterFind(){
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    public function keySelect(){
        return array('1=1','id','name');
    }

    // public function getrelations() {
    //   $s1='ClubList,comName:club_name,comCode:club_code';
    //   return $s1;
    // }

    // public function picLabels() {
    //     return 'pic';
    // }

    // public function pathLabels(){ 
    //     return 'uploads/image/';
    // }

}
