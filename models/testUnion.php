<?php

class testUnion extends BaseModel {
    public function tableName() {
        return '{{test_union}}';
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
            'comCode' =>'所属社区唯一编码',
            'comName' =>'所属社区名称',
            'staCode' =>'所属场馆唯一编码',
            'staName' =>'所属场馆名称',
            'code' =>'俱乐部唯一编码',
            'name' =>'俱乐部名称'
       );
    }

    protected function afterFind(){
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    // public function keySelect(){
    //     return array('1=1','code','courseType:courseType');
    // }

}
