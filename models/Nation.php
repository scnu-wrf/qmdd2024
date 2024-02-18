<?php

class Nation extends BaseModel {

    public function tableName() {
        return '{{t_nation}}';
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
        'id' => 'ID',
        'code' => '编号:k',
        'nation' => '民族:k',
        'country' => '国家简称:k',
        );
    }

  //public function picLabels() {return 'subpic';}
  //public  function pathLabels(){ return '';}
   /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
  public function keySelect(){
        return array('1','code','code:country');
   }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    public function getCode($country) {
        return $this->findAll("country='".$country."'");
    }

    public function getTypeCode() {
        return $this->getCode('CHN');
    }

}
