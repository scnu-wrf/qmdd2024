<?php

class testVenue extends BaseModel {
    public function tableName() {
        return '{{test_venue}}';
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
            'code' =>'场地编号',
            'name' =>'场地名称',
            'proCode' =>'开设项目编号',
            'project' =>'开设项目',
            'serType' =>'开设服务',
            'capacity' =>'容纳人数',
            'group' =>'场地类型',
            'audState' =>'审核状态',
            'reviewCom' =>'审核意见'
       );
    }

    public function getrelations() {
      $s1='testStadium,staName:name,staCode:code&comName&comCode;';
      $s1.='ProjectList,project:project_name,proCode:CODE';
      return $s1;
    }

    protected function afterFind(){
        parent::afterFind();
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    public function keySelect(){
        return array("audState='审核通过'",'id','name');
    }
 
   public function getAll($cr='1'){
        return testVenue::model()->findAll($cr);
    }

    // public function picLabels() {
    //     return 'pic';
    // }

    // public function pathLabels(){ 
    //     return 'image/tmp';
    // }

}
