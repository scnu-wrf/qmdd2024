<?php

class BaseCode extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{base_code}}';
    }

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
        'f_code' => '列表编码',
        'f_name' => '列表名称',
        'f_group' => '列表组别',
        'f_type' => '列表类型英文',
        'f_type_CN' => '列表类型中文',
        'f_order' => '组内序号',
        );
    }
    protected function beforeSave() {
        return true;
    }



  public function getName($id) {
        $rs = $this->find('f_id=' . $id);
        return  str_replace(' ','',is_null($rs->F_NAME) ? "" : $rs->F_NAME);
    }


    public function getCode($fater_id) {
        return $this->findAll('fater_id=' . $fater_id);
    }
    
    public function getAttrtype() {
        return $this->findAll('f_typename="订单类型"');
    }
    
    public function getOrderType2() {
        $tmp= $this->getOrderType();
        return toIoArray($tmp,'f_id,F_NAME,fater_id');
    }
    
    public function getOrderType() {
        return $this->findAll('fater_id in(350,360,362,367)');
    }
    
    //return $this->findAll('fater_id in (8,9,189,380,495)');
    //return $this->findAll('fater_id=' . $f_id);
    public function getGrouptypestate() {
        return $this->getCode(32);
    }

    public function getClub_type2() {
        $tmp=$this->getClub_type2_all();
        return toIoArray($tmp,'f_id,F_NAME,fater_id');
    }

   public function getClub_type2_all() {
        return $this->findAll('fater_id in (8,9,189,380,495)');
    }
    //return  $this->findAll("F_TCODE='PARTNAME' and fater_id<>10 and fater_id<>0");

    public function getSex($f_id='0') {
        return $this->findAll('f_id in (205,207)');
    }  
  function get_name_set_by_code($news_id='0') 
{ return  parent::delete_by_key("f_id=".$news_id);}

 function get_combo($code)
  {
       $ws= " f_code='".$code ."' and F_COL2=1  ";//and club_type=".$club_type;
       return $this->findAll($ws);
   }

 function get_combo2($code)
  {
       return $this->get_by_code($code);
   }

       // 学员申请状态
   public function getUsertype() {///695服务者类型描图
        return $this->getCode(886);
    }
   
        // 学员申请状态

  function get_by_code($pcode){
    $s1="left(f_code,".strlen($pcode).")='".$pcode."' and left(f_value,1)<>' '";

    return $this->findAll($s1);
  }


   public function getLevel() {///695服务者类型描图
        return $this->getTcode('LEVEL');
    }
   public function getClass() {///695服务者类型描图
        return $this->getTcode('CLASS');//CLASS
    }
   public function getTerm() {///695服务者类型描图
        return $this->getTcode('TERM');
    }   
    public function getYear() {///695服务者类型描图
        return $this->getTcode('YEAR');
    }


  public function getTcode($ftcod) {
        return $this->findAll("left(f_code,".strlen($ftcod).")='".$ftcod."'");
    }  


    public function getByType($f_type,$f_order='') {
        $criteria = new CDbCriteria;
        $criteria->addCondition("f_type = :f_type");
        $criteria->params[':f_type']=$f_type;


        if(!empty($f_order)) $criteria->order='f_name ASC';

        $result=$this->model()->findAll($criteria);
        return $result;
    }
 
    public function getAllType(){
        $criteria = new CDbCriteria();
        $criteria->select = 'f_type,f_type_CN';
        //$criteria->group = 'f_type,f_type_CN';
        $result=$this->model()->findAll($criteria);
        return $result;
    }
public function getInputSetType() {
        return $this->findAll('arr_input_set_type > 0');
    }
  public function getGameState() {
        return $this->findAll('f_id in(151, 145, 146, 149)');
    }
  
  
    public function getPurpose() {
        return $this->findAll('fater_id in(829,830)');
    }
    public function getPurpose2($f_id) {
        return $this->findAll('fater_id in(829,830) AND f_id<>'.$f_id);
    }

    public function getCustomer($f_id) {
        return $this->findAll('fater_id=208 AND f_id<>'.$f_id);
    }
    public function getPaytype($f_id) {
        return $this->findAll('fater_id=452 AND f_id<>'.$f_id);
    }
    public function getCounttype($f_id) {
        return $this->findAll('fater_id=711 AND f_id<>'.$f_id);
    }
    /**
     * 传过来的值调用单个或多个
     */
    public function getReturn($f_id,$whe='') {
        return $this->findAll('f_id in('.$f_id.')'.$whe);
    }
    public function getProductType() {
        return $this->findAll('f_id in (361,351,352,353,354,355,356,357,359,364,777,1424,1700,1701,1702)');
    }
  public function getServerType() {
    return $this->findAll('f_id in (351,352,353,354,355,356,357,359,364,777,1424)');
  }
  public function getUpperType() {
    return $this->findAll('f_id in (361,364)');
  }
 
    public function getOrderType1() {
        return $this->findAll('fater_id in(350,362,367)');
    }

    public function getPayway() {
        return $this->findAll('f_id in(483,484,485)');
    }

    //return $this->findAll('fater_id in (8,9,189,380,495)');
    //return $this->findAll('fater_id=' . $f_id);
    public function getClubtype() {
        return $this->findAll('fater_id=10');
    }


    /*wankai tianjia*/
    public function getGame_format() {
        return $this->findAll('fater_id in (984,985,988)');
    }

    public function getGame_format2() {
      $cooperation= $this->getGame_format2_all();
      return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getGame_format2_all() {
        return $this->findAll('fater_id in (984)');
    }
    public function getTypeCode() {//资质人类型261、identity_
        return $this->getCode(261);
    }

  public function getPicSetType() {//图集/视频./音频251
        return $this->getCode(251);
    }

public function getProjectState() {//项目状态/115
        return $this->getCode(505);
    }
public function getApproveState() {
        return $this->getCode(452);
    }
public function getAuthState() {
        return $this->getCode(455);
    }
public function getShenheState() {
        return $this->getCode(370);
    }
public function getPicType() {//125商品图片类型
        return $this->getCode(125);
    }

//PicType:list(Basecode/getPicType)
//资格证书类型122
public function getZheShuType() {///资格证书类型122
        return $this->getCode(122);
    }

//证件扫描图138
public function getZjImg() {///138证件扫描图
        return $this->getCode(138);
    }
public function code1403(){
      return $this->keySelectSet('f_id=1403');
}

  
public function keySelectSet($w1='f_id=1'){
    return array($w1,'code','id:f_name');
}
//服务者类型383
public function getSservicType() {///388服务者类型描图
        return $this->getCode(383);
    }

   // 开关模式695
   //
   public function getShowState() {///695服务者类型描图
        return $this->getCode(695);
    }

    // 学员申请状态
   public function getStatus() {///695服务者类型描图
        return $this->getCode(336);
    }

  
    // 竞赛项目性别要求
    public function getCode_sex(){
        $cooperation=$this->getCode_sex_all();
        return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getCode_sex_all() {
        return $this->findAll('fater_id=204');
    }

    // 赛事裁判审核方式
    public function getCode_way(){
        $cooperation= $this->getCode_way_all();
        return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getCode_way_all() {
        return $this->findAll('fater_id=791');
    }

    // 赛事
    public function getCode_id2() {
        $cooperation= $this->getCode_id2_all();
        return toArray($cooperation,'f_id,F_NAME,F_TYPECODE,fater_id');
    }

     public function getCode_id() {

        return  $this->findAll('fater_id = 169');
    }

    public function temporary() {

        return  $this->findAll('fater_id = 1057');
    }


   public function getCode_id2_all() {
        return  $this->findAll('fater_id in (163,810)');
    }

    public function getQualificationType2() {
    $cooperation= $this->getQualificationType();
    return toArray($cooperation,'f_id,F_NAME,fater_id');
  }

    public function getQualificationType() {
        return $this->findAll('F_TCODE="WAITER" AND fater_id <>383');
    }

    public function getGameArrange2($pid) {
        $cooperation=$this->findAll('fater_id='.$pid);
        return toArray($cooperation,'f_id,F_NAME,fater_id');
      }

    public function getMembertype_all() {
        return  $this->findAll('fater_id in (10,383)');
    }

    public function getMembertype() {
      $cooperation=$this->findAll('fater_id in (10,383)');
      return toArray($cooperation,'f_id,F_NAME,fater_id');
    }

    public function getStateType() {
        return  $this->findAll('f_id in (371,2,373,721)');
    }

    public function getLogisticsType() {
        return  $this->findAll('f_id in (472,473,474,476)');
    }


  public function getSiteType2($f_id) {
        return $this->findAll('fater_id=1517 AND f_id<>'.$f_id);
    }




}
