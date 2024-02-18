<?php

class testStadium extends BaseModel {
    public $basestr='',$projectstr='';
    public function tableName() {
        return '{{test_stadium}}';
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
        'comCode' =>'一编码',
        'comName' =>'所属社区名称',
        'code' =>'场馆编号',
        'name' =>'场馆名称',
        'address' =>'场馆地址',
        'lng' =>'场馆经度',
        'lat' =>'场馆纬度',
        'project' =>'场馆开设项目',
        'phone' =>'场馆电话',
        'introduce' =>'场馆介绍',
        'base' =>'基础设施',
        'pic' =>'场馆图片',
        'sale' =>'场馆预订量',
        'audState' =>'审核状态',
        'reviewCom' =>'审核意见',
        'city' =>'场馆所在市',
        'district' =>'场馆所在区',
        'view' =>'场馆浏览量',
        'basestr' =>'基础设施',
        'projectstr' =>'开设项目',
       );
    }

    public function getrelations() {
      $s1='ClubList,comName:club_name,comCode:club_code';
      return $s1;
    }

    public function picLabels() {
        return 'pic';
    }

    // public function pathLabels(){ 
    //     return '';
    // } 

    protected function afterFind(){
        parent::afterFind();
        $this->projectstr=$this->project;
        $this->basestr=$this->base;
        $this->project =strToArray( $this->project);
        $this->base =strToArray( $this->base);
        return true;
    }

    protected function beforeSave(){
        parent::beforeSave();
        $this->project =arrayToStr( $this->project);
        $this->base =arrayToStr( $this->base);
        return true;
    }

    public function keySelect(){
        return array("audState='审核通过'",'comCode','name');
    }
  
    public function getAll(){
        return testStadium::model()->findAll();
    }


}
