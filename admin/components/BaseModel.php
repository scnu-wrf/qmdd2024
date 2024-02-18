<?php

class BaseModel extends CActiveRecord {

    public $select_id='';
    public $select_code='';
    public $select_title='';
    public $select_item1='';
    public $select_item2='';
    public $select_item3='';
    public $html_tmp0='',$html_tmp1='',$html_tmp2='';
    public $data_check=1;
    protected function afterSave() {
        parent::afterSave();
    }
    public  function className() {
        return (__CLASS__);
    }
    
   public  function noCheck($ch=0) {
       set_session('noCheck',$ch);
    }
  public  function getNoCheck() {
     return get_session('noCheck');
    }

public function extend($values){
    foreach($values as $var=>$value){
    if(!isset($this->{$var}))
     $this->{$var} = $value;
    }
  }
 protected function abeforeSave() {
      parent::beforeSave();
      if(!($this->getTableName()=="table_update")){
       //  if(!$this->getIsNewRecord()) $this->update_log($tname);
       update_log($this);
      } 
      return true;
  }

   protected function getTableName() {
      $tname= str_replace('{','',$this->tableName());
      return str_replace('}','',$tname);
    }

    protected function afterDelete() {
        parent::afterDelete();
    }

    protected function safeField() {
       $dm=$this->attributeLabels();
       $s1='';$b1='';
       foreach($dm as $k=>$v)
       { $s1.=$b1.$k;$b1=',';}
       return $s1;
    }

    /** * 属性标签 */
    public function getAttributeSet() {
        $attributes=$this->attributeSets();
        $arr = array();
        foreach ($attributes as $k => $v) {
           $d=explode(':',$v.':');
           $arr[$k] =$d[0];
        }
        return $arr; 
    }
    /**  * 属性标签 */
    public function noEmptyAttribute() {
        $attributes=$this->attributeSets();
        $s1='';$b1="";
        $rs=array();
        $data_check=0;//$this->getNoCheck();
        if(isset($_POST["submitType"])){
           $data_check=(indexOf($_POST["submitType"],"_Nocheck")>=0) ? 1 : 0;
        }
        if ($data_check==0){
          foreach ($attributes as $k => $v) {
             $d=explode(':',$v.':');
             if((indexof($v,':k')>=0 || indexof($v,':K')>=0)) // && (indexof($v,':len')<0) ) 
               {$s1.=$b1.$k;$b1=',';}
             if(indexof($v,':len')>=0){
               $rs[]=$this->lenSet($k,$d);
             }
          }
        }
        $rs[]=array($s1, 'required', 'message' => '{attribute} 不能为空');
        return $rs; 
    }

    /** * 属性标签 */
    public function lenSet($k,$dsrt) {
        $n1=1;$n2=20;
        foreach ($dsrt as $v) {
           if(indexof($v,'len')>=0){
             $s1=str_replace('len','',$v);
             $s1=str_replace('(','',$s1);
             $s1=str_replace(')','',$s1);
             $ds=explode(',',$s1.','.$s1);
             $n1= $ds[0];$n2= $ds[1];
           }
        }
      //  return  array($k, 'length', 'min'=>11, 'tooShort'=>'密码至少为6位');
        return array($k,'length', 'min'=>$n1,'max'=>$n2);
    }



    /** * 属性标签 */
    public function saveAttribute() {
        return array($this->safeField(),'safe');
    }

  /**   * 属性标签 */
    public function attributeRule() {
        $rs=$this->noEmptyAttribute();
        $rs[]=$this->saveAttribute();
        return $rs;
    }

    public function del_daohao($pstr,$dchar=',')
    {
       $pstr=str_replace(' ','', $pstr);
       return str_replace($dchar.$dchar,$dchar,$pstr);
     }

         //自动图片加上路径
    protected function afterFind(){
      parent::afterFind();
      $this->toAddPath();
      $this->changeJsonData(1);
   //   $this->changeHtml(1);
    }


//保存图片时候 删除图片前面的路径
    protected function beforeSave(){
      parent::beforeSave();
       if(!($this->getTableName()=="test_err")) $this-> movePath();
       $this->setDefalut();
      return true;
    }
  
  protected function setDefalut(){
     if(isset($this->createTime))
     if(empty($this->createTime))  $this->createTime=get_date();
     $this->relationsTo();
  }

  
    /** 默认值设置
        public function setDefaultValue() {
      $s1='club_logo_pic:clublist,id_card_face,contact_id_card_face';
      $s1.='id_card_back,certificates,contact_id_card_face,';
      $pathpic=$s1.'apply_id_card,club_list_pic,bank_pic,taxpayer_pic';
      $s1='Basecod,state:id,state_name:f_name;';
      $s1.='userlist,apply_club_gfid:gf_id,apply_gfaccount:GF_ACCOUNT';
      $relations=$s1.'&apply_name:ZSXM&apply_club_gfaccount:apply_gfaccount';
      $rs=array(
      'sess'=>'reasons_adminid:admin_id,reasons_adminname:gfnick',//保持登录信息
      'date'=>'about_me_time,uDate',//保存修改
      'def_sess'=>'',//保持第一次操作信息
      'def_date'=>'apply_time',//保存地一次修改信息
      'pcipath'=>$pathpic,//属性名:模型名称，模型空取上一个模型
      'relations'=>$relations//关联取值
      );
      return $rs;
    } 

     从sese从 SESSION获取 ，date取日期，
    def_sess 变量空获取，def_date当前日期 空才获取*/
    protected function setDefaultValueing(){
      //返回数据为数组从sese获取 ，date取日期def_sess 变量空获取，def_date当前日期 空才获取*/
      $this->getSetDefaultStr('sses','setFromSession',1);
      $this->getSetDefaultStr('date','setFromDate',1);
      $this->getSetDefaultStr('def_sses','setFromSession',0);
      $this->getSetDefaultStr('def_sses','setFromDate',0);
      if(!($this->getTableName()=="test_err")) $this-> movePath();
      $this->saveFunction($ds,'relations','relationsTo');
  }

  protected function getSetDefaultStr($pname,$funName,$ty=0){
      //返回数据为数组从sese获取 ，date取日期def_sess 变量空获取，def_date当前日期 空才获取*/
      $rs=$this->getSetDefault($pname);
      if(!empty($rs)){
         $this->{$funName}($rs,$ty);
      };
  }
  

  protected function getSetDefault($pname){
      //返回数据为数组从sese获取 ，date取日期def_sess 变量空获取，def_date当前日期 空才获取*/
      $ds=$this->getFuntion('setDefaultValue');
      $rs='';
      if(!empty($ds)){
        if(isset($ds[$pname])) $rs=$ds[$pname];
      }
      return $rs;
  }
  
  protected function saveFunction($ds,$aName,$funName) {
    $para='';
    if(isset($ds[$aName])) $para=$ds[$aName];
    if(!empty($para)) $this->{$funName}($para);
  } 

  //根据关联获得值 'timetype,timeid:id,timetype:f_name';
  // timetype 外键模型；id外健；f_name外键值
  //  $s1='goodsreport,f_rid:id,f_timeid:timeid&f_timetype:timetype';
  //    $s1.='&f_shopid:r_shopid&f_shopname:r_shopname&f_typeid:r_typeid';
  //    $s1.='&f_type:r_type;';
  protected function  relationsTo(){
      $ds=$this->getFuntion('getrelations',';');
      foreach($ds as $v){ //加上路径名称
         if(!empty($v)){ $this->recTorelations($v);}
      }
  }
//    $s1.='&f_shopid:r_shopid&f_shopname:r_shopname&f_typeid:r_typeid';
  //    $s1.='&f_type:r_type;';
  protected function  recTorelations($v0){
      $ds2=explode(',',$v0);//$ds2[0]是模型,$ds2[1],关键子，$ds2[2]是值
      $d1=explode(':',$ds2[1].':'.$ds2[1]);//关键字段值比较
      $w1=$d1[1].'="'.$this->{$d1[0]}.'"';
      $tmp=$ds2[0]::model()->find($w1);
      $ds=explode('&',$ds2[2]);
      foreach($ds as $v){ //加上路径名称
        if(!empty($v)){
          $d2=explode(':',$v.':'.$v);
          $this->{$d2[0]}=$tmp->{$d2[1]};
        }
      }
  }

//保存的图片取消根路径 op=?,0 删除，1 添加
  protected function changeHtml($op){
      $ds=$this->getFuntion('htmlLabels');
      foreach($ds as $v1){ //加上路径名称
         if(isset($this->{$v1})){
             $s2=$this->{$v1};
             if($op==1){
               $s2=html_entity_decode($s2);//转换成数组
             }
             $this->{$v1}=$s2;
         }
      }
      return true;
  }

    //保存图片时候 删除图片前面的路径
    protected function toAddPath(){
        $ds=$this->getFuntion('picLabels');
        foreach($ds as $v1){ //加上路径名称
           if(isset($this->{$v1})){ 
            $this->{$v1}=BasePath::model()->addPath($this->{$v1});
           }
        }
    }

    //保存图片时候 删除图片前面的路径
    protected function movePath(){
        $ds=$this->getFuntion('picLabels');
        foreach($ds as $v1){ //加上路径名称
          $this->{$v1}=BasePath::model()->reMovePath($this->{$v1});
        }
    }

    //保存数组时候 
    protected function toJson($ds1){
       $d1=explode(',',$ds1);
       foreach ($d1 as $k => $s1) {
         $s0=$this->{$s1};
         if(is_array($s0)) {
           $this->{$s1}=json_encode($s0,JSON_UNESCAPED_UNICODE);
        }
       }
   }

//改变数据格式 op=?,0 JONS 字符串，1 字符转JSON添加
    protected function changeJsonData($op=0){
       $ds=$this->getFuntion('jsonLabels');
       $i=0;
       foreach($ds as $v1){ //加上路径名称
          $i=$i+1;
          $s2=$this->{$v1};
          if(isset($this->{$v1})){
               $s2=$this->{$v1};
               if($op==1){
                 $s2=$this->mb_unserializea($s2);//转换成数组
               }
              $this->{$v1}=$s2;
          }
       }
       return true;
    }
   //扩充 对象转换成数组
   public function saveHtml($fieldstr,$post) {
        if(isset($post[$fieldstr.'_temp']) ){
           $this->{$fieldstr}=$post[$fieldstr.'_temp'];
        };
    }

  public function setUploadPath() {
      $rs=$this->getFuntion('pathLabels');
      $tpath=(empty($rs)) ? 'temp' :$rs [0];
      set_Session('modelPath',$tpath);
  }

protected function getFuntion($fs,$bs=',') {
    $rs=array();
    if(method_exists($this,$fs)){
      $rs=explode($bs,$this->{$fs}());
    }
    return $rs;
  }

function mb_unserializea($str) {
  if(!is_array($str))
  if((strpos($str,"s:")>0)||empty($str)){
       $data=$str;
       $str=@unserialize($str);
       if (!$str) {
            $str =$this->mb_unserializeb($data);
       }
    }
   return $str;
}

function serializekey() {
    return '|s\:(\d+)\:"(.*?)"|';
}

function mb_unserializebk($serial_str) {
    $out = preg_replace_callback($this->serializekey(),
      function ($matches){ return "s:".strlen($matches[2]).":\"$matches[2]\"";},
      $serial_str);
    return unserialize($out);
}
 
function mb_unserializeb($serial_str) { 
    $serial_str = preg_replace_callback('/s:(\d+):"([\s\S]*?)";/', function($matches) {
        return 's:'.strlen($matches[2]).':"'.$matches[2].'";';
      }, $serial_str);
    return unserialize($serial_str);  
}

function getTableKey($tname) { 
 $tmp0=sql_findall('SHOW FULL COLUMNS FROM '.$tname);
  $key="";
  foreach($tmp0 as $v)
  {
      if($v['Key']=='PRI'){
          $key=$v['Field'];
          break;
      }
  }
  return $key;
}

//扩充 对象转换成数组
 protected function objtoArray($afieldstr) {
      $arr=array();
      $afields=array();
      $r=0;
      $val=$this->attributes;
      $afieldstmp=explode(',',$afieldstr);
      foreach($afieldstmp as $v1){
        $a=explode(':',$v1);
        $afields[$a[0]]=$a[0];
        $aval[$a[0]]='<null>';
        if(isset($a[1])) $afields[$a[0]] = $a[1];//有别名
         $arr[$a[0]]='';                 
        if(isset($a[2])) $arr[$a[0]]= $a[2];//默认值
        if(isset($val[$a[0]])) $arr[$a[0]]= $val[$a[0]];//表的值
      }
      return $arr;
  }

   //扩充 对象转换成数组
   protected function objAddtoArray(&$v,$afieldstr,$tmp) {
        $arr=$this->objtoArray($afieldstr);
        $afieldstmp=explode(',',$afieldstr);
        foreach($afieldstmp as $v1){
          $v[$v1]='';
        }
        if(!empty($tmp)){
          foreach($afieldstmp as $v1){
            if(isset($tmp->{$v1})){
               $v[$v1]=$tmp->{$v1};
            };
          }
        }
    }
    
   //活动对象值
   public function readValue($w1,$fieldstr,$r='') {
        $tmp=$this->find($w1);
        $r="";
        if($tmp)
        if(isset($tmp->{$fieldstr})){
          $r=$tmp->{$fieldstr};
        };
        return $r;
    }

  public  function gridHead($fs='',$wd='') {
    $s1="";
    set_Session("setDelete",'1');
    $dm=$this->getFields($fs);
    $wds=$this->tdWidth(count($dm),$wd);
    $i=0; 
    foreach($dm as $k)
    {
      $v=$k; 
      $d1=explode(":",$k.":");
      $k=$d1[0];
      $s2=$k;
      if($s2<'zzz') $s2=$this->getAttributeLabel($k);

//      $s2='<font style="font-weight:bold;font-size:16px;">'.$s2.'</font>';
      if(indexOf($v,'%')>0) $wds[$i]=$this->getTdWidth($d1); 
      $s1.='<th '.$wds[$i].' align="center" >'.$s2.'</th>';
      $i++;
    }
    return $s1; 
   } 

  public  function getTdWidth($data){
    $rs="";
    foreach($data as $k){ 
      if(indexOf($k,'%')>0){
        $rs=$this->getTdstyle($k);
        break;
       }
    }
    return $rs;
   }

  public  function getTdstyle($wd){
    return "style='text-align: center;width:".$wd.";'";;
   }

  public function tdWidth($n,$wdstr){
    $rs=BaseLib::model()->emptyArray($n);
    if(!empty($wdstr)){
      $data=explode(',',$wdstr);
      foreach($data as $v){
         $ds=explode(':',$v);
         $rs[$ds[0]]=$this->getTdstyle($ds[1]);
      }
    }
    return $rs;
  }

  public  function gridRow($fs='',$data=array(),$rows='',$thisv='') {
    $s1="";
    if(!empty($fs)){
      $dm=$this->getFields($fs);
      foreach($dm as $k)
      {   
        $d1=explode(":",$k.":");
        $k=$d1[0];
        $s1.=$this->toTdstr($this->{$k},$rows,$d1[1]);
      }
    }
    if(!empty($data)){
      foreach($data as $k=>$s2)
        { 
          $s1.=$this->toTdstr($s2);
        }
    }   
    return $s1;
   }

    public  function gridRowUrl($fs='',$thisv='',$idname='') {
    $s1="";
    if(!empty($fs)){
      $dm=$this->getFields($fs);
      foreach($dm as $k0)
      {   
        $d1=explode(":",$k0."::");
        $k=$d1[0];
        $id=$this->{$idname};
        $s1.=$this->toTdstr($this->{$k},'',$d1[1],$thisv,$id);
      }
    }   
    return $s1;
   }
/*
 $show_type=pic '图片'，YN=0显示否  1显示是
 */
 public  function toTdstr($s2,$rows='',$show_type='',$thisv='',$id='0') {
     $d1=explode("(",$show_type);
     $sc=strtoupper($d1[0]);
     if((indexof($s2,'uploads/temp')>=0) || ($show_type=='pic')){
         $s2='<img src="'.$s2.'" height="60px" width="60px">';
       }
      if($sc=='YN'){
         $s2=(empty($s2)) ?'否' : '是';
       } 
       if($sc=='URL'){
         $paction=str_replace(')','', $d1[1]);   
         $url0=$thisv->createUrl($paction, array('id'=>$id));
         $s2='<a  href="'.$url0.'">'.$s2.'</a>';
       } 
     //  $s2='<font style="font-weight:bold;font-size:14px;">'.$s2.'</font>';
       return '<td '.$rows.'>'.$s2.'</td>';
   }

  public  function getFields($r) {
    if(empty($r))  $r=$this->gridLabels();
    return explode(',',$r);
   }

  public  function getcount($w1='1'){
    $tmp=$this->findAll($w1);
    return count($tmp);
   }

  public  function toRec($tmp,$fieldstr){
    return $this->getFrom($tmp,$fieldstr);
   }
//从TMP对象设置值
  public  function getFrom($tmp,$fieldstr){
    $this->setFromArray($tmp,$fieldstr);
   }
   /*从$tmp数组设置值 或记录
   //$fieldstr关联熟悉说明 主熟悉：子属性，主属性
   $rcol='f_goodsid:id,f_code,f_name,f_sname,f_amount=0';
   */
  public  function setFromArray($tmp,$fieldstr){
    $dm=explode(",",$fieldstr);
    foreach($dm as $v)
    {
      $d1=explode(":",$v.':'.$v);
      $vd='';
      $s0=$d1[0];$s1=$d1[1];
      if(indexOf($s0,'=')>=0){ //属性名称=常量值的
       $dd=explode("=",$s0);
       $s0=$dd[0];//属性
       $vd=$dd[1];//常量值
      }
      if(isset($this->{$s0}) ){
        if(empty($vd)&&isset($tmp[$s1]) ){
          $vd=$tmp[$s1];
          if(isset($d1[2])){ 
             if($d1[0]!==$d1[2]) $vd=$d1[2]; 
           }
        }
      }
      $this->{$s0}=$vd;
    }
 }

    protected function getFromModel($w1,$model,$fieldsstr) {
      $tmp=$model::model()->find($w1);
      if(!empty($tmp)){
        $this->setFromArray($tmp,$fieldsstr);
      }
    }

    protected function gListData($condition='1',$key) { 
      $w1=(empty($key)) ? '' : ' order by '.$key;
      return $this->findAll($condition.$w1.' limit 500');
    }

    protected function gDatas($acgetData='',$rules='') {
     
     if(method_exists($this,$acgetData) && $acgetData!='keySelect')
     { 
       $d=$this->{$acgetData}($rules);//可能返回是数据不是说明，数据是二维数组
     } else{
         $rules=str_replace('~','=',$rules);
         $rules=str_replace('&',' and ',$rules);
         if($rules=='') $d=$this->keySelect();
         else $d=$this->keySelect($rules);
     }
      return array($this->gListData($d[0],$d[1]),$d[2]);
    }

    public function downSelect($form,$m,$atts,$acgetData='',$noneshow='',$rules=''){//update
     $data=$this->gDatas($acgetData,$rules);
     return BaseLib::model()->selectByData($form,$m,$atts,$data[0],$data[1]);
    }
   
    public function downSearch($title,$filedname,$rules='',$getfunction=''){
    //index //字段中文名称，备注//字段名//规则
       $getfunction=($getfunction=='downSearch') ? '' : $getfunction; 
       $data=$this->gDatas($getfunction,$rules);
       return BaseLib::model()->searchBy($title,$filedname,$data[0],$data[1]);
    }
    public function recToArray($w1, $s1)
    {
        return toIoArray($this->findAll($w1), $s1);
    }

   //$operater 是操作人员相关信息， $datename='日期'
  public function saveOperater($operater, $datename='',$def_data){
      $this->setFromSession($operater,1);
      $this->setFromDate($datename,1);
      if(isset($def_data["sess"])) $this->setFromSession($def_data["sess"]);
      if(isset($def_data["date"])) $this->setFromDate($def_data["date"]);
  }

  public function setFromSession($operater,$check=0){
    if(!empty($operater)){
      $dm=explode(",",$operater);
      foreach($dm as $v){
        $dm1=explode(":",$v.':'.$v);
        if(empty($this->{$dm1[0]})&&($check))
          $this->{$dm1[0]} = Yii::app()->session[$dm1[1]];  
      }
     }
  }

  public function setFromDate($def_date,$check=0){
     if(!empty($def_date)){
       $dm=explode(",",$def_date);
       foreach($dm as $v){
         $dm1=explode(":",$v.':'.$v);
         if(empty($this->{$dm1[0]})&&($check))
           $this->{$dm1[0]} =  date('Y-m-d H:i:s');  
       }
      }
  }

  public function find($condition = '', $params = Array(), $checkResult = true){
      $this->putfindAll($condition);
      return parent::find($condition, $params ,$checkResult);
    }
    public function findAll($condition='',$params =  Array(), $checkResult = true){
      $this->putfindAll($condition);
      return parent::findAll($condition, $params, $checkResult);
    }
    public function putfindAll($w1)
    {
      if(isset($w1->condition)){
        $w1=$w1->condition;
      }
      put_msg($w1);
      //$w1 = debug_backtrace();
      // put_msg($w1);
    }
}
