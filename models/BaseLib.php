<?php
class BaseLib  extends BaseModel {
  public $show_line='';
  public $td_style='';
  public $show_form='';
  public function tableName() {
      return '{{base_code}}';
  }
  /**  * 模型验证规则 */
  public function rules() {
      return array( );
  }
 
  /** * Returns the static model of the specified AR class. */
  public static function model($className = __CLASS__) {
      return parent::model($className);
  }

  public function picInput($form,$model,$attributes,$pic='jpg',$inputer=1,$div="<div>") {
   return  $this->upload($form,$model,$attributes,$pic,$inputer,$div);     
  }

  //输出200状态
    public function JsonSuccess($data=array(),$ecode='200'){
        $rs = array('data'=>$data,'time'=>time(),'code'=>$ecode,'request'=>$_REQUEST);
        echo CJSON::encode($rs);
    }

    //输出500状态
    public function JsonFail($data='访问失败'){
        if(!is_array($data)) { $data=array($data);}
        $this->JsonSuccess($data,'500');
    }
   

 public static function emptyArray($n=10) {
      $rs=array();
      for($i=0;$i<$n;$i++) $rs[]='';
      return $rs;
    }

  public static function sameStr($str1,$n=10) {
    $rs='';$b1='';
    for($i=1;$i<=$n;$i++) {
      $rs.=$b1.$str1.$i;
      $b1=',';
    }
    return $rs; 
  }

 public  function  getRandStr($length=5){
   //字符组合
   $str = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
   $len = strlen($str)-1;
   $randstr = '';
   for ($i=0;$i<$length;$i++) {
    $num=mt_rand(0,$len);
    $randstr .= $str[$num];
   }
   return $randstr;
 }

    //扩充 记录对象转换成数组
  public function oneToArray($tmp,$afieldstr) {
    $arr=array(); $afields=array();$rec=array();
    $afieldstmp=explode(',',$afieldstr);
    if($tmp) //$rec=$tmp->attributes;
    foreach($afieldstmp as $v1){
        $a=explode(':',$v1);
        $r=$a[0]; $s1='';
        $r0=$r;
        if(isset($a[1]))
        if(!empty($a[1])) $r= $a[1];//有别名
        if(isset($tmp->{$r0}))
        { $s1= $tmp->{$r0};//表的值
        }
        if(isset($a[2])) $s1= $a[2];//默认值
        $arr[$r]=$s1;
    }
    return $arr;
  }

public  function listArray($stra) {
 $rs=array();
  foreach ($stra as $v){
    $rs[$v]=$v;
  }
  return $rs;
}

public  function tableLine($msg) {
   return '<table><tr class="table-title"><td>'.$msg.'</td></tr><table>';
  }

public  function getHtmlOptions() {
  $s1='<span class="check">{input}{label}</span>';
  return array('separator' => '', 'class' => 'input-check','template' => $s1);
}

public  function fieldSet($form,$v,&$i,$rtmp) {
  $ln=$this->ln();
  $s1=$ln.'<fieldset>';
  $s1.=$ln.'<legend>'.$v->f_name.'</legend>'.$ln.'<div>'.$ln;
  $s1.='<table><tr class="table-title">'.$ln;
  $s1.='<td>'.$ln;
  //,array( 'left' => '居左' , 'right' => '居右' ));
  $stra=$this->listArray($v->f_items); 
  $htmlOptions = $this->getHtmlOptions();
  $i++;
  $s1.= $form->radioButtonList($rtmp, 'f_checka['.$i.']',$stra ,$htmlOptions ).$ln;
  $s1.="</td>".$ln."</tr>".$ln."</table>".$ln;
  $s1.='</div>'.$ln;
  $s1.='</fieldset>'.$ln;
  return $s1;
}

public  function tableSet($form,$tmp,$tname,$rtmp,&$i) {
  $ln=$this->ln();
  $s1=$ln.'<fieldset>'.$ln.'<legend>'.$tname.'</legend>'.$ln.'<div>';
  $s1.=$ln.'<table>';
  foreach ($tmp as $v){
    $s1.=$ln.'<tr class="table-title">';
    $s1.=$ln.'<td >'.$v->f_name.'<span class="required">*</span></td><td>';
    //,array( 'left' => '居左' , 'right' => '居右' ));
    $stra=$this->listArray($v->f_items); 
    $htmlOptions = $this->getHtmlOptions();
    $i++;
    $s1.= $form->radioButtonList($rtmp, 'f_checkb['.$i.']',$$stra ,$htmlOptions).$ln;
    $s0=$form->error($rtmp, $v->f_name, $htmlOptions = array());
    $s1.=$s0."</td>".$ln."</tr>".$ln;
   }
  $s1.=$ln.'</table></div>';
  $s1.=$ln.'</fieldset>';
  return $s1;
 }

 public  function ln() {  return chr(13).chr(10);}

  //  当前界面：单位审核》基本信息》<span style="color:DodgerBlue">信息审核</span>
public function title($vt,$vt1='') {
  $vt1=(empty($vt1)) ? $vt : $vt1;
  $ds=Role::model()->optername();
  return '当前界面：'.$ds[0].'》'.$vt.'》<span style="color:DodgerBlue">'.$vt.$ds[1].'</span>';
}

//传入图片地址，id名（update用）
function show_pic($flie='',$id=''){
  $html='';
  $icon=BasePath::model()->fileIcon($flie);
  if($flie){
    $s0='<div style="max-width:80px; max-height:70px;overflow:hidden;">';
    $s1='<div style="float: left; margin-right:10px" id="upload_pic_'.$id.'">';
    $s2='<img src="'.$icon.'" style="max-height:30px; max-width:20px;">';
    $s3='<img src="'.$flie.'" style="max-height:80px; max-width:70px;">';
    $html=empty($id) ? $s0: $s1;
    $html.= '<a href='.$flie.' target="_blank" title="点击查看">';
    $html.= (!empty($icon)) ? $s2 : $s3;
    $html.='</a></div>';
  }
  return $html;
}

function showPic($flie='',$pw=70,$ph=80){
  $html='<div style="float: left; margin-right:5px" id="upload_pic_spic">';
  $html.='<img src="'.$flie.'" style="max-height:'.$ph.'80px; max-width:'.$ph.'px;">';
  return $html.'</div>';
}
public function uploadFile($model,$attribute,$pic='jpg',$inputer=1,$div="<div>") {
  $div1=(empty($div)) ? '</div>' : '';
  $s1=get_class($model).'_'.$attribute."','".$pic;
  $model->setUploadPath();
  $rs=($inputer) ? "<script>we.uploadpic('".$s1."');</script>" :'';
  return $div.$rs.$div1;
}

public function upload($form,$model,$attributes,$pic='jpg',$inputer=1,$div="<div>") {
  $ln=$this->ln();
  $d=explode(':',$attributes.':1:1:1');
  $fns=$d[0];
  //D(0)--D(4),s属性名，标签宽度，内容宽度，编辑去宽，和高度
 // $s1='<td colspan="'.$d[1].'">'. $form->labelEx($model,$fns).'</td>';

  $r=(indexof($d[1],'-')>=0) ? 1 : 0;
  $d[1]=str_replace('-','',$d[1]);
  $s1=$this->tableTd($form,$model,$fns,$d[1]);
  $r0=($d[3]=='1') ? '' : 'rowspan="'.$d[3].'"';
  $s1.='<td colspan="'.$d[2].'" '.$r0. '>';
  $s1.=$form->hiddenField($model, $fns, array('class' => 'input-text fl')); 
  $s1.=$this->show_pic($model->{$fns},get_class($model).'_'.$fns);
  if($r==0)
   $s1.=$this->uploadFile($model,$fns,$pic,$inputer,$div);
  $s1.= $form->error($model,$fns, $htmlOptions = array());
  $s1.= '</td>';
  return $s1;
}

public function tableTd($form,$model,$attribute,$clsp='') {
  $clsp0=$clsp;
  $clsp=(empty($clsp)||($clsp=='1') ) ? '' : 'colspan="'.$clsp.'"';
  $clsp.= $this->bkcolor(1);
  $rs='<td '.$clsp.'>'. $form->labelEx($model,$attribute).'</td>';
  if($clsp0=='0') $rs='';
  return $rs;
}

public function tdBkColor($sty='',$clsp='') {
  $clsp=$sty.(empty($clsp)) ? '' : 'colspan="'.$clsp.'"';
  $clsp.= $this->bkcolor(1);
  return '<td '.$clsp.'>';
}

function bkcolor($bks=0){
   $s2=setGetValue("bkcolor");
   $s1='';
   if($s2==1){
      $s1=($bks=0) ?'background:#D9EDF7' : ' style="background:#D9EDF7"';
    }
  return $s1;
}

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function getTableLine($form,$m,$str,$tr="1",$rd='') {
   return $this->trInput($form,$m,$str,$tr,$rd);     
}

public function trInput($form,$m,$str,$tr="1",$rd='',$aselect=array()) {
  $ln=$this->ln();
  $d1=explode(',',$str);
  $s0='<tr style="text-align:center;">';
  $tr0=(!empty($this->show_line)) ? $this->show_line : $s0;
  $s1=($tr=="1") ? $tr0.$ln : "";
  foreach($d1 as $v1){
     $s1.=$this->getTdData($form,$m,$v1);
    }
   return  $s1 .(($tr=="1") ? '</tr>' : "").$ln;     
}
/*
$form 表达，$m模型，$str输入的字符串长度，
$trStyle TR的样式
$tdStyle 数组 每个标签的TD 样式，一个标签包括两个
 */
public function inPutTr25($form,$m,$str,$trStyle="",$tdStyle=array()) {
  $ln=$this->ln();
  $d1=explode(',',$str);
  $tdStyle=kgetTdStyle($tdStyle,count($d1));
  $tr0=(!empty($trStyle)) ? $trStyle : '<tr style="text-align:center;">';
  $s1="";
  foreach($d1 as $v1){
    $s1.=$this->getTdData($form,$m,$v1);
  }
  return  $tr0.$ln.$s1 .'</tr>'.$ln;     
}

public function kgetTdStyle($tdStyle,$tdn) {
  $n0=$tdn-count($tdStyle);
  for($i=0;$i<$n0;$i++)
  {
    $tdStyle[]=array('','');
  }
  for($i=0;$i<$tdn;$i++)
  {
    if(empty($tdStyle[$i][0])) $tdStyle[$i][0]="";
    if(empty($tdStyle[$i][1])) $tdStyle[$i][1]="";
  }
  return  $tdStyle;     
}

//str=模型名称/下拉动作,$v1 是属性串
public function getTdData($form,$m,$v1,$tdLabel='1') {
   $s10="";
   if(!empty($v1)){
      $ds0=$this->checkInputType($v1);
      $v1=$ds0[0];//字段名:比例（&规则）
      $s2=$ds0[1];//组件名称
      $sm=$ds0[2];//数据选择的模型
      if($s2=='text')
         $s10=$this->tdInput($form,$m,$v1);
      if($s2=='label')
         $s10=$this->tdLabel($form,$m,$v1);
      if($s2=='title')
         $s10=$this->tdTitle($form,$m,$v1);
      if($s2=='pic')
         $s10=$this->upload($form,$m,$v1);
      if($s2=='spic'){
         $sm=str_replace('(','',$sm);
         $s10=$this->showPic($m->{$v1},120,100);
       }
      if($s2=='YN'||$s2=='yn')
         $s10=$this->selectYn($form,$m,$v1);
      if($s2=='WR'||$s2=='wr')
         $s10=$this->selectWr($form,$m,$v1);
      if($s2=='abc')
         $s10=$this->selectAbc($form,$m,$v1,$sm);
      if($s2=='html'|| $s2=='shtm' || $s2=='qhtm')
         $s10=$this->edit($form,$m,$v1);
      if($s2=='list'){
         $s10=$this->tdList($form,$m,$v1,$sm);
      }
      if($s2=='number'){
         $s10=$this->tdNumber($form,$m,$v1,$sm,0);
      }
      if($s2=='qsnumber'){
         $s10=$this->tdNumber($form,$m,$v1,$sm,1);
      }
       if($s2=='check'){
         $s10=$this->tdcheck($form,$m,$v1,$sm);
      }
      if($s2=='action'){
         $td=($tdLabel=='1') ? '<td>' :'';
         $ltd=($tdLabel=='1') ? '</td>' : '';
         if(indexof($sm,'/notd')>0){
           $sm=str_replace('/notd','',$sm);
           $s1=substr($s1,0, -5);
           $td='';
         }
         $d2=explode('/',$sm);//函数/提示 
         $s10=$td.$this->getSearchCmd($d2[1],$v1,$d2[0]).$ltd;
      }
      if($s2=='date') $s10=$this->tdInputDate($form,$m,$v1,0);
      if($s2=='time') $s10=$this->tdInputDate($form,$m,$v1,1);
    }
    return  $s10;
}

//str=name:1:2,其中NAME為知道，1錶示跨錶格，2是右邊 
public function tdCheck($form,$m,$field,$mactionData) {
  $ds= $this->selectAction($mactionData);
  $model=$ds[0];
  if($ds[1]=='downSelect' ||1==1){  //默认列表
     $data= $model::model()->gDatas();
  } else{
     $s1=$ds[1];
     $data= $model::model()->{$s1}($ds[2]);
  }
  return $this->checkByData($form,$m,$field,$data[0],$data[1]);
}

//str=模型名称/下拉动作
public function selectAction($str,$ac='keySelect') {
  $d2=explode('/',$str.'/'.$ac);
  return $d2;
}

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 ,$ds[1] 指定模型的方法
public function tdList($form,$m,$field,$maction) {
    $ds=$this->selectAction($maction);
    $model=$ds[0];$action=$ds[1];
    $tmp = explode('?',$field);
    $rules = isset($tmp[1])?$tmp[1]:'';
    $field=$tmp[0];
    if($action=='showMode'){
      $rs=$model::model()->{$action}($form,$m,$field);
    } else{
      $rs= $model::model()->downSelect($form,$m,$field,$action,'',$rules); 
    }
    return $rs;
}


protected function gNumber($n) { 
    $rs=array();
    for($i=0;$i<=$n;$i++){
       $rs[]=array('id'=>$i,'name'=>$i);
    }
    return $rs;
}

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function tdNumber($form,$m,$field,$num,$qs=0) {
    return BaseCode::model()->numberSelect($form,$m,$field,$num,$qs);
}


//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function tdInput($form,$m,$str,$plabel=0) {
    $ln=$this->ln();
    $s1='';
    if(!empty($str)){
      //$ad=array('class'=>'input-text','style'=>'height:25px');
      $ds=explode(':',$str.":1:1");
      $tdStyle=$this->getTdStyle($ds[0]);
      $s1.=$this->tableTd($form,$m,$ds[0],$ds[1]);
      $ad=$tdStyle['input'];
      $td1='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').' > '; 
      if($plabel==0){
        $s1.=$td1.$form->textField($m,$ds[0],$ad);
        $s1.=$form->error($m,$ds[0], $htmlOptions = array());
      } else{  //显示标签
        $s1.=$td1.$m[$ds[0]];
      }
      $s1.='</td>'.$ln;
   }
   return  $s1 ;     
}

//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function atdInput($form,$m,$str) {
    $ln=$this->ln();
    $s1='';
    if(!empty($str)){
      $ad=array('class'=>'input-text','style'=>'height:25px');
      $ds=explode(':',$str.":1:1");
      $td0='<td  style="padding:15px;" '.(($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"').' > ';
      $td1='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').' > '; 
      $s1=$form->labelEx($m,$ds[0]);
      $s1=$td0.$s1.'</td>'.$ln;
      $s1.=$td1.$form->textField($m,$ds[0],$ad);
      $s1.=$form->error($m,$ds[0], $htmlOptions = array()); 
      $s1.='</td>'.$ln;
   }
   return  $s1 ;     
}

//str=name:1:2:3,其中NAME为知道，1熟悉宽带，2是右边 
public function tdRowCol($str,$label='text') {
  $ln=$this->ln();
  $s1='';
  if(!empty($str)){
    $ds=explode(':',$str.":1:1:1");//background-color:DodgerBlue;color:DodgerBlue background-dce9f5
    $r0=($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"';
    $s1.='<td style="padding:15px;color:DodgerBlue;background: #dce9f5" '.$r0.' >';
    $s1.=$ds[0].'</td>'.$ln;
  }
  return  $s1 ;     
}

//显示标签内容说明
public function tdLabel($form,$m,$str) {
   return  $this->tdInput($form,$m,$str,1);     
}
//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function tdTitle($form,$m,$str) {
  $ln=$this->ln();
  $s1='';
  if(!empty($str)){
  //  $ad=array('class'=>'input-text','style'=>'height:25px');
    $ds=explode(':',$str.":1:1:1");//background-color:DodgerBlue;color:DodgerBlue background-dce9f5
    $r0=($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"';
    $r0.=($ds[2]=='1') ? "" :' rowspan="'.$ds[2].'"';
    $s1.='<td style="padding:15px;color:DodgerBlue;background: #dce9f5" '.$r0.' >';
    $s1.=$ds[0].'</td>'.$ln;
  }
  return  $s1 ;     
}

//str=name:1:2,其中NAME为属性名，1表示跨表格，2是右边 
public function getAd($ad,$str) {
  $d2=explode(':',$str);
  foreach($d2 as $vs){
    $vsd=explode('=',$vs); 
    $ad[$vsd[0]]=$vsd[1];     
  }
  return  $ad;     
}

//str=name:1:2,其中NAME为属性名称，1表示属性跨表格数，2是输入框表格数
// $form 界面控件
// $M 数据模型
// $str 属性串表，用,分开
// $tr 表示生成行
public function show_td($form,$m,$str,$tr="1") {
   return $this->tableInput($form,$m,$str,$tr);
}

public function saveDataHtml(&$tmp){
   $ds=get_session('edit_name');
   $r=0;
   if(is_array($ds)){
       foreach($ds as $v){
        $s1='html_tmp'.$r;$r+=1;
        $tmp->{$v}= $tmp->{$s1};
      }
   }
}

public function getHtmlName($hname){
   $s1='html_edit';
   $sn=get_session($s1);
   set_session($s1,$sn+1);
   return 'html_tmp'.$sn;
}

public function edit($form,$m,$str,$tr="1") {
  $ln=$this->ln();
  $dtr=$this->checkTr($str);
  if(indexOf($str,":")<0){ $str.=":1:1"; }
  $d=explode(':',$str.":200:50%"); //D(0)--D(4),s属性名，标签宽度，内容宽度，编辑去宽，和高度
  $fildsname=$d[0];
  $s21=$fildsname;//."_temp";
  $s22=get_class($m);
  $s31=$s22."_".$s21;
  $s32=$s22."[".$s21."]";
  
  $r=(indexof($d[1],'-')>=0) ? 1 : 0;
  $d[1]=str_replace('-','',$d[1]);

  $s1=($dtr[0]==1) ? '<tr>' : '';
  $s1.= $this->tableTd($form,$m,$fildsname,'');
  $s1.='<td colspan="'.$d[2].'"  >'.$ln;
  if($r==0){
      $s1.=$form->hiddenField($m,$fildsname, array('class' => 'input-text')).$ln; 
      $s1.='<script>'.$ln;
      $s1.="we.editor('".$s31."','".$s32."','".$d[3]."','".$d[4]."');".$ln;
      $s1.='</script>'.$ln;
      $s1.=$form->error($m,$fildsname, $htmlOptions = array()).$ln; 
  } else{
     $s1.='<p>'.html_entity_decode($m->{$fildsname}).'</p>';
  }
  $s1.='</td>'.(($dtr[1]==1) ? '</tr>' :'').$ln;
  return  $s1;     
}

public function editHtml($form,$m,$str,$tr="1") {
  return  $this->edit($form,$m,$str,$tr);     
}

public function checkTr(&$str) {
  $tr=(indexOf($str,"[")>=0) ? 1 : 0;
  $btr=(indexOf($str,"]")>=0) ? 1 : 0;
  $str=str_replace('[','',$str);
  $str=str_replace(']','',$str);
  return array($tr,$btr);     
}
public function checkKeyWord($str,$str1) {
   $s1=':'.strtolower($str1);
   $s2=strtolower($str);
   return (indexOf($s2,$s1)>=0) ? $str1 :'';     
}

public function checkWord($str,$str1) {
   $d=explode(',',$str1);
   $s2=strtolower($str);
   $rs='';
   foreach($d as $v){
    $s1=':'.strtolower($v);
    if(indexOf($s2,$s1)>=0){
      $rs=$v;
      break;
    }
   }
   return $rs;     
}

public function checkInputType($str) {
  $r='';$r1='';
  $s1='spic,pic,WR,YN,label,title,html,radio,date,time,check,list,number,qsnumber,abc,action';
  $r=$this->checkWord($str,$s1);
  if(empty($r)) $r='text';
  $b1=(($r=='check')||($r=='list')||($r=='radio')||($r=='action'));
  $b1=($b1 ||($r=='qsnumber')||($r=='number')||($r=='abc'));
  if($b1){
    $d1=explode('(',$str);
    if(count($d1)>1){
      $d2=explode(')',$d1[1]);
      $r1=$d2[0];
      $str=str_replace("(".$r1.")","",$str);
    }
  }
  $str=str_replace(':'.$r,'',$str);
  $str=str_replace(':HTML','',$str);
  return array($str,$r,$r1);//rs返回中间的内容
}


public function show_read($form,$m,$str,$tr="1") {
  $d=explode(';',$str);
  $s1='';
  foreach($d as $v){
    $s1.=$this->getTableLine($form,$m,$v,$tr,'1');
   }
   return  $s1;     
}

public function listByData($form,$m,$atts,$data,$sp,$onchange='',$noneshow='') {
   return  $this->selectFrom($form,$m,$atts,$data,$sp,$onchange,$noneshow);
}

public function selectFrom($form,$m,$atts,$data,$sp,$onchan='',$noshow='') {
   $atts0.=':1:'.$sp;
   $shownName="f_name:f_name";
   return  $this->selectByData($form,$m,$atts0,$data,$shownName,$onchan,$noshow);
}

public function selectInit($form,$m,$atts,$data,$shownName,$onchange,$noshow,&$s1,&$s01,&$s02) {
   $dtr=$this->checkTr($atts);
   $ds=explode(':',$atts.":1:1");
   $atts=$ds[0];
   $ds1=explode(':',$shownName.":".$shownName);
   $ln=$this->ln();
   $s1=($dtr[0]==1) ?'<tr>' :'';
   if($ds[1]!=='0'){ //标识只显示一列
       $s1.=$this->tdBkColor('',$ds[1]);'<td '.(($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"').'>'.$ln;
       if(!empty($noshow)) $s1.='<span id="'.$atts.'_label" style="display: none">';
       $s1.= $form->labelEx($m,$atts);
       if(!empty($noshow)) $s1.='<span class="required">*</span></span>';
       $s1.='</td>'.$ln;
    }
   if(!empty($noshow)) $s1.='<span id="'.$atts.'_content" style="display: none">';
   $s1.='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').'>'.$ln;
   $s01=Chtml::listData($data, $ds1[0], $ds1[1]);
   $s02=array('prompt'=>'请选择','style'=>'width:95%;');
}

public function selectByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow='') {
   $s1='';$s01='';$s02='';
   $dtr=$this->checkTr($atts0);
   $ds=explode(':',$atts0.":1:1");
   $this->selectInit($form,$m,$atts0,$data,$shownName,$onchange,$noneshow,$s1,$s01,$s02);
   $ln=$this->ln();
   $s1.=Select2::activeDropDownList($m,$ds[0],$s01,$s02);
   $s1.=$ln.$form->error($m,$ds[0], $htmlOptions = array());
   if(!empty($noneshow)) $s1.='</span>';
   $s1.='</td>'.(($dtr[1]==1) ? '</tr>' :'').$ln;
   return $s1;
}
 

public function radioByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow='') {
   $s1='';$s01='';$s02='';
   $dtr=$this->checkTr($atts0);
   $ds=explode(':',$atts0.":1:1"); 
   $this->selectInit($form,$m,$atts0,$data,$shownName,$onchange,$noneshow,$s1,$s01,$s02);
   $ln=$this->ln();
   $s1.=$form->radioButtonList($m,$ds[0], $s01, $htmlOptions = $this->getHtmlOptions());
   $s1.=$ln.$form->error($m,$ds[0], $htmlOptions = array());
   if(!empty($noneshow)) $s1.='</span>';
    $s1.='</td>'.(($dtr[1]==1) ? '</tr>' :'').$ln;
   return $s1;
}

public function oldcheckByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow='') {
  $s1=$form->checkBoxList($m, 'tmp_opter2['.$ri.']['.$ri1.']',$tmenu, $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>', 'onclick' => 'opterClickb()'));
  return $s1;
 }

 public function checkByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow='') {
   $s1='';$s01='';$s02='';$noneshow='';
   $dtr=$this->checkTr($atts0);
   $ds=explode(':',$atts0.":1:1"); 
   $this->selectInit($form,$m,$atts0,$data,$shownName,$onchange,$noneshow,$s1,$s01,$s02);
   $ln=$this->ln();
   $tmp=$m->{$ds[0]};
   if(!empty($tmp))
   if(!is_array($tmp)){
     $tmp=str_replace('[','',$tmp);
     $tmp=str_replace(']','',$tmp);
     $tmp=str_replace('"','',$tmp);
     $tmp=str_replace("'",'',$tmp);    
     $tmp=explode(',',$tmp.',');//把字符串轉換字符數組
     $m->{$ds[0]}=$tmp;
   }
   $s1.=$form->checkBoxList($m,$ds[0],$s01,$htmlOptions = $this->getHtmlOptions());
   $s1.=$ln.$form->error($m,$ds[0], $htmlOptions = array());
   if(!empty($noneshow)) $s1.='</span>';
    $s1.='</td>'.(($dtr[1]==1) ? '</tr>' :'').$ln;
   return $s1;
 }

public  function searchBy($title,$field,$datas,$id='id'){
    $ds=explode(":",$id.':'.$id);
    return $this->searchByData($title,$field,$datas,$ds[0],$ds[1]);
  }

  public  function searchByData($title,$field,$datas,$id='id',$name='name'){
  
    $s01=Yii::app()->request->getParam($field);
    $s01=(empty($s01)) ?'':$s01;
    $s1='<label style="margin-right:25px;">';
    $s1.='<span>'.$title.'：</span>';
    $s1.='<select name="'.$field.'" id="'.$field.'" >';
    $s1.='<option value="">请选择</option>';
  
    foreach($datas as $v2){
     $s2=$v2[$id];
     $s1.='<option value="'.$v2[$id].'"'.(($s01==$s2) ?' selected="selected"':'').'>';
     $s1.=$v2[$name].'</option>';
    }

    return $s1.'</select></label>';
  }


//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function inputSearch($title,$keywords) {
  $ln=$this->ln();
  $s1='<label style="margin-right:10px;">'.$ln;;
  $s1.='<span>'.$title.'：</span>'.$ln;
  $s1.='<input style="width:100px;height=25px;" class="input-text" name="'.$keywords.'"';
  $s1.=' value="'.Yii::app()->request->getParam($keywords).'">'.$ln;
  $s1.=' </label>'.$ln;
  return  $s1 ;     
}

//
//  S利用字符串生产相关命令
//  参数：search:查询;save:确认
//     <button class="btn btn-blue" onclick="$('#oper').val('search');" type="submit">查询</button>
 //   <button class="btn btn-blue" onclick="$('#oper').val('save');" type="submit">确认</button>
 
  public function getSubmit($str) {
      $d=explode(';',$str);
      $ln=$this->ln();$s1='';
      foreach($d as $v){
        $d1=explode(':',$v);
        $s1.='<button class="btn btn-blue" onclick="$('."'#oper').val('".$d1[0]."');".'"';
        $s1.=' type="submit">'.$d1[1].'</button>'.$ln;
      }
      return  $s1;     
    }

 
  public function creatCommand($thisp,$title,$command,$pic='') {
      $s1=$this->ln(); 
      $s1.='<a class="btn" href="'.$thisp->createUrl($command).'">';
      $s1.=(($pic=='') ?'' :'<i class="fa '.$pic.'"></i>').$title.'</a>';
      return  $s1;     
    }

  public function clickCommand($procname='',$title='',$urlname='') {
    $s1='<a  id="j-'.$title.'" class="btn"  onclick="add_proc();">';
    $s1.='<i class="fa "></i>'.$title.'</a>';
    return  $s1;        
  }

  public function batProc($procname,$title,$urlname) {
    $s1='<a style="display:none;" id="j-'.$urlname.'" class="btn" href="javascript:;" onclick="';
    $s1.="we.".$procname."(we.checkval('.check-item input:checked'), ".$urlname."Url)";
    $s1.=';"><i class="fa fa-trash-o"></i>'.$title.'</a>';
    return  $s1;     
    }
    public function batProcAc($procname,$title,$jsId,$urlname) {
        $s1='<a style="display:none;" id="j-'.$jsId.'" class="btn" href="javascript:;" onclick="';
        $s1.="we.".$procname."(we.checkval('.check-item input:checked'), ".$urlname."Url)";
        $s1.=';"><i class="fa fa-trash-o"></i>'.$title.'</a>';
        return  $s1;
    }
// 標題設置
    public function titleSet($thisp,$opername) {
        $ln=$this->ln();
        $s10=$ln.'<span>';
        $spde='';
       
        if((indexof($opername,'添加')>=0)||((strpos($opername,'刪除') !== false) )){
          $s10.=$this->batProc('dele','批刪除','delete');
        }

        $d=explode(',',$opername);
        foreach($d as $v){
            $btn=(indexof($v,':btn')>=0) ? 1 : 0;
            $mclick=(indexof($v,':mc')>=0) ? 1 : 0;
            $v=str_replace(':mc','',$v);
            $v0=$v;
            $d0=explode('?',$v.'?');
            $v=$d0[0];$ps=$d0[1];
            $ps=(empty($ps)) ? '' : '?'.$ps;//檢查是否有傳遞參數
            $d1=explode(':',$v.':');
            $oper_name=$d1[0];
            $s1='';
            if($oper_name=='添加')
            {
                $s0=(empty($d1[1])) ? 'create' : $d1[1];
                $s1.= $this->creatCommand($thisp,'添加',$s0,"fa-plus");
            }
            if($mclick){
               $s0=$d1[1];
            //  if(!empty($s0)) $s1.=$this->batProc($s0,$d1[0],$s0);
             // if(indexof($v0,'批审核')>=0) $s1.=$this->batProc('dele','批刪除','delete');
            //  if(indexof($v0,'批审核')>=0) $s1.=$this->batProc('dele','批刪除','delete');
              if(empty($s1)) $s1.=$this->batProc('dele','批刪除','delete');
             // $s1=$this->batProc($d1[1],'批审核',$d1[1]);
            }
            if((indexof($v,'批审核')>=0)){
              $s1=$this->batProc($d1[1],'批审核',$d1[1]);
            }
            if((indexof($v,'批驳回')>=0)){
                $s1=$this->batProcAc('reject','批驳回',$d1[1],$d1[2]);
             
            }
            if($oper_name=='刷新') {
                $s0=(empty($d1[1])) ? 'index' : $d1[1];
                $s1.= $this->creatCommand($thisp,'刷新',$s0,"fa-refresh");
            }
            if($oper_name=='刪除'){
                $s21='';$s22='';
                if($oper_name=='批刪除') $s21='批刪除';
                if($oper_name=='刪除') $s22='刪除';
                $s1.=show_command($s21,'',$s22);
            }

            if(empty($s1)){
                $opico='edit';$title=$d1[0];
                if(empty($d1[1]) ) $d1[1]='create';
                if(isset($d1[2])&&(!empty($d1[2]) )) $opico=$d1[2];
                if(isset($d1[3])&&(!empty($d1[3]) )) $title=$d1[3];
                if(!empty($title)) $title='<label id="title_'.$d1[1].'">'.$title.'</label>';
                if($btn==1){
                  $s1.='<input class="btn" type="button"';
                  $s1.=' id="'.$d1[1].'" value="'.$d1[0].'">'.$ln;
                  $s1.=$this->dialogJs($thisp,$d1[1],$d1[0]).$ln;
                } else{
                  $s0=$thisp->createUrl($d1[1]);
                  $s1.=$ln.'<a class="btn" href="'.$s0.$ps.'"';
                  $s1.=$ln.' title="'.$d1[0].'">'.$title.'</a>';
               }
            }
            $s10.=$s1;
        }
        return (empty($opername)) ?'' :$s10.$ln.'</span>';
    }

 public function dialogJs($thisv,$btnName,$title){
  $url=$thisv->createUrl($btnName);
  $s1= <<<Eof
  <script type="text/javascript">
    $('#{$btnName}').on('click', function(){
      //  $.dialog.data('member_price_id', 0);
        $.dialog.open('{$url}',{
            id:'dingjia',lock:true,opacity:0.3,
            title:'{$title}',
            width:'50%',  height:'60%',
            close: function () {
              //  if($.dialog.data('member_price_id')>0){}
            }
        });
    });
</script>
Eof;
return $s1;
 } 
// 设置标题内容选择
  public function setRowCheck($id,$index=0) {
      $ln=$this->ln();
      $s0=CHtml::encode($id);
      $s1=$ln.'<td class="check check-item">';
      $s1.='<input class="input-check" type="checkbox" value="'.$s0.'"></td>';
      $s1.=($index) ? '<td>'.$index.'</td>' :'';
      return  $s1;
  }

// 设置查找命令管理，ID,NAMEID=>(ID,ARRAY())
  public function getCmdParas($keyNames,$vs) {
       $rs=array();
       foreach($keyNames as $v){
        if(!empty($v)){
          $rs[$v]=$vs[$v];
         }
       }
      return $rs;
  }

  function checkShow($v,$vv){
    $show=(indexof($v,':show(')>=0) ? 1 :0;
    $wshow=0;
    if($show==1){
      $d0=explode('(',$v); 
      $d1=explode(')',$d0[1]);
      $v=str_replace(':show','',$d0[0].$d1[1]);
      $d0=explode('&',$d1[0]);
      $wshow=1;
      foreach ($d0 as $k => $v1) {
        $d1=explode('=',$v1);
        $wshow= $wshow *(($vv[$d1[0]]==$d1[0]) ? 1 : 0);
       } 
    }
    $rs=($show==0) ? 0 : $wshow;
    return array($rs,$v);
  }

    //操作设置内容
  public function getBtn($str1) {
    $r0=stripos($str1,':btn');
    $lp=1;$r1=$r0+1;
    $str1.=':';
    while($lp==1){
      $s0=substr($str1,$r1,1);
      if(($s0==':')||($s0==')')){
        $lp=0;
      }
      $r1++;
    }
    $str2=substr($str1,$r0,$r1-$r0);
    $str1=str_replace($str2,'',$str1);
    $str2=str_replace(')','',$str2);
    $str2.='(click_show';//默认click_show;
    $d1=explode('(',$str2.'(');
    return array($str1,$d1[1]);     
  }

//操作设置内容'编辑:update,删除,更多:workOrderProcess/index:icoclass:title';
  //操作设置内容'编辑:update,删除,更多:workOrderProcess/index:icoclass:title';
  //审核:show(isUploadLead=1&isJudgeLead=0)
  public function setDateOPter($thisp,$id,$opname='编辑,删除',$keyvs,$vv) {
      $ln=$this->ln(); 
      $s1= $ln;
      $d=explode(',',$opname);  
  
      foreach($d as $v){
        $wshow=$this->checkShow($v,$vv);
        $v=$wshow[1];

        if($wshow[0]==0){
            $btnfun='';
            $btn= ((indexof($v,':btn')==-1)) ? 0 :1;
            if($btn==1){
               $btns=$this->getBtn($v);
               $btnfun=$btns[1];
               $v=$btns[0];
            }
            $d1=explode(':',$v.':');
         
            $t_blank=(indexof($v,':_bk')>=0) ?'target="_blank"' :'';
            $s0='';
            if( (indexof($d1[1],'(')>=0)){ //不显示
             $dd=explode('(',$d1[1]);
             $d1[1]=$dd[0];
             $s0=str_replace(')','',$dd[1]);
             $dd=explode('=',$s0);$s0='';
             if($vv[$dd[0]]==$dd[1]) $s0='noshow';
            }
            if(empty($s0)){
              if(indexof($v,'删除')>=0){
                $s1.=$ln.'<a class="btn" href="javascript:;" onclick="we.dele('."'".$id."'";
                $s1.=$ln.', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>';
              } else{
     
                $opico='edit';$title='';
                if(isset($d1[2])&&(!empty($d1[2]) )) $opico=$d1[2];
                if(isset($d1[3])&&(!empty($d1[3]) )) $title=$d1[3];
                if($btn==1){
            
                 $btnfun=(empty($btnfun)) ?'click_show' :$btnfun;
                 $s1.='<a class="btn" href="javascript:;" onclick="'.$btnfun.'(';
                 $s1.="'".$id."'".');" title="'.$title.'">'.$title.'</a>';
            
                } else{
          
                if(!empty($title)) $title='<label id="title_'.$d1[1].'">'.$title.'</label>';
                if(is_string($thisp)){
                   $s00=$thisp.'Controller';
                   if(!(indexof('/',$d1[1])>=0)){
                     $d1[1]=$thisp.'/'.$d1[1];
                   }
                   $thisp=new $s00();
                }
            $s1.=$ln.'<a class="btn" href="'.$thisp->createUrl($d1[1], $keyvs).'"';
            $s1.=$t_blank;
            $s1.=$ln.' title="'.$d1[0].'"><i class="fa fa-'.$opico.'"></i>'.$title.'</a>';
                }
              }
           }
         }
      }
          //  $s1='<td> <font style="font-weight:bold;font-size:14px;">'.$s1.'<font></td>';
      $s1='<td>'.$s1.'</td>';
      return  $s1.$this->setDeleteOP($thisp);     
    }

  //操作设置内容
  public function setDeleteOP($thisp) {
    $s1='';
    if(get_Session("setDelete")=='1'){
      $s1=$thisp->createUrl('delete', array('id'=>'ID'));
      $s1='<script> var deleteUrl ="'. $s1.'";</script>';
      set_Session("setDelete",'0');
     }
    return  $s1;     
  }

   function strToArrayData($str) {
    $r=array();
    $ds0=explode(';', $str);
    foreach($ds0 as $v0){
      $ds1=explode(',', $v0);
      $r1=array();
      foreach($ds1 as $v1){
       $ds2=explode(':', $v1);
       $r1[$ds2[0]]=$ds2[1];
      }
      $r[]=$r1;
    }
    return $r;
   }
    
  public function selectYn($form,$m,$atts,$onchange='',$noneshow=''){
     $data=$this->strToArrayData('f_id:1,f_name:是;f_id:0,f_name:否');
     return $this->radioByData($form,$m,$atts,$data,'f_id:f_name',$onchange,$noneshow);
  }
 
  public function selectWr($form,$m,$atts,$onchange='',$noneshow=''){
     $data=$this->strToArrayData('f_id:對,f_name:對;f_id:錯,f_name:錯');
     return $this->radioByData($form,$m,$atts,$data,'f_id:f_name',$onchange,$noneshow);
  }

  public function selectAbc($form,$m,$atts,$num=4){
     if(empty($num)) $num=4;
     $data=BaseCode::model()->getRadioAbc($num);
     return $this->radioByData($form,$m,$atts,$data,'name');
  }
//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 <老师的是会报错的>
public function btdInputd($form,$m,$str) {
    $ln=$this->ln();
    $ad=array('class'=>'input-text click_time','style'=>'height:25px');
    $ds=explode(':',$str.":1:1");
    $td0='<td  style="padding:15px;" '.(($ds[1]=='1') ? "" :' colspan="'.$ds[1].'"').' > ';
    $td1='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').' > ';
    $s1=$form->labelEx($m,$ds[0]);
    $s1=$td0.$s1.'</td>'.$ln;
    $s1.=$td1.$form->textField($m,$ds[0],$ad);
    $s1.=$form->error($m,$ds[0], $htmlOptions = array());
    $s1.='</td>'.$ln;
    return  $s1 ;
}
 
 public function tdInputd($form,$m,$str) {
    $ln=$this->ln();
    $ad=array('class'=>'input-text click_time','style'=>'height:25px');
    $ds=explode(':',$str.":1:1");
    $s1=$this->tableTd($form,$m,$ds[0],$ds[1]);
    $td1='<td '.(($ds[2]=='1') ? "" :' colspan="'.$ds[2].'"').' > '; 
    $s1.=$td1.$form->textField($m,$ds[0],$ad);
    $s1.=$form->error($m,$ds[0], $htmlOptions = array()); 
    $s1.='</td>'.$ln;
   return  $s1 ;     
}
//str=name:1:2,其中NAME为知道，1表示跨表格，2是右边 
public function dateSearch($title,$keywords) {
  $ln=$this->ln();
  $v=Yii::app()->request->getParam($keywords);
  if(empty($v)) $v='';//$v=date('Y-m-d');
  $s1='<label style="margin-right:10px;">'.$ln;;
  $s1.='<span>'.$title.'：</span>'.$ln;
  $s1.='<input style="width:120px;height=25px;" class="input-text click_time" type="text" ';
  $s1.=' id="'.$keywords.'" name="'.$keywords.'"';
  $s1.=' value="'.$v.'">'.$ln;
  $s1.=' </label>'.$ln;
  return  $s1 ;     
}

//日期输入下拉框，js
public function script_Date($str,$m1='',$dtype=0){
 $ln=$this->ln();
 $ds=explode(':',$str.":1:1");
 $m=(empty($m1)) ?'' : get_class($m1);
 $sn=(($m=='') ? '' : $m.'_').$ds[0];
 $dts=($dtype==0) ?'' : ' HH:mm:ss';
 $s0=$ln.'<script>'.$ln;// name="ClubListGys[apply_name]" id="ClubListGys_apply_name"
 $s0.=" var $".$sn."=$('#".$sn."');".$ln;
 $s0.=" $".$sn.".on('click', function(){".$ln;
 $s0.=" WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd".$dts."'});".$ln;
 $s0.=" });".$ln;
 $s0.="</script>".$ln;
 return $s0;
}

public function tdInputDate($form,$m,$str,$dtype=0){
   $s1=$this->tdInputd($form,$m,$str);
   $s1.=$this->script_Date($str,$m,$dtype);
   return $s1;
 }

public function inputDate($title,$str){
   $s1=$this->dateSearch($title,$str);
   $s1.=$this->script_Date($str);
   return $s1;
  }
//查找输入框处理
public function boxSearch($str='关键字:keywords'){
   $ln=$this->ln();
   $this->submitCmd='';
   $ds1=explode('|',$str."|");//| 后面是附件命令
   $str=$ds1[0];
   $str=str_replace(';',',@',$str);
   $ds=explode(';',$str.";");
   $str=$ds[0];
   $s1=$ln.'<form action="'.Yii::app()->request->url.'" method="get"><p>';
   $s1.=$ln.'<input type="hidden" name="r" value="'.Yii::app()->request->getParam('r').'">';
   $d=explode(',',$str);
   foreach($d as $v){
     $pg='';
     if(indexof($v,'@')>=0){
       $pg="</p><p>";
       $v=str_replace('@','',$v);
     }
     $s1.=$pg.$this->getSearchInput($v);
   }
   $s1.=($this->submitCmd) ? "" : '<button class="btn btn-brown" style="color: #fff;
   border-color: #84563e; background-color: #84563e;" type="submit">查询</button>';
   $s1.=$this->searchOtherCmd($ds1[1]);
   return  $s1.$ln.'</p></form>';
  }
 
//onclick="submitType='."'".$bname."'".'"'

public function searchOtherCmd($str){
    $s1='';
    $d=explode(',',$str);
    if(count($d)>=1){
       $s1='<input type="hidden" name="submitType" id="submitType" value="3">';
       $s0='';$s0='&nbsp;&nbsp;<button class="btn btn-blue" type="submit" ';
       foreach($d as $v){
         $d=explode('=',$v);
         if(count($d)>1){
           $s1.=$s0.' onclick="'."$('#submitType').val('".$d[1]."')".';">'.$d[0];
           $s1.='</button>';
         }
       }
     }
  return $s1;
}

public $submitCmd='';
public function getSearchCmd($title,$idname,$fn){
  $this->submitCmd='1';$ln=$this->ln();
  $s1=$ln.'<span style="display;">';
  $s1=$ln.'<a style="display;" id="'.$idname.'" class="btn" href="javascript:;"';
  $s1.=' onclick="'.$fn.'();">'.$title.'</a></span>';
  return $s1;
}

public function getSearchInput($str) {
  $d1=explode('=',$str);
  $m=$d1[0];//标题$v1=$d1[1];//属性和表输入一样

  $ds0=$this->checkInputType($d1[1]);
  $v1=$ds0[0];$s2=$ds0[1];$s1='';
  $sm=$ds0[2];//数据选择的模型
  
  if($s2=='text')
     $s1=$this->inputSearch($m,$v1);
  if($s2=='YN')
     $s1=$this->selectYn($m,$v1);
  if($s2=='list'){
      $rules=isset($d1[2])?$d1[2]:'1=1';
      $s1=$this->searchList($m,$v1,$sm,$rules);
  }

  if($s2=='date')
     $s1=$this->inputDate($m,$v1);
   if($s2=='action')
     $s1=$this->getSearchCmd($m,$v1,$sm);
 
   return $this->ln().$s1 ;     
}

 //字段中文名称，备注//字段名//模型名//规则
public function searchList($m,$field,$maction,$rules='') {
    //字段中文名称，备注//字段名//模型名//规则
    $ds=$this->selectAction($maction,'downSearch');
    $model=$ds[0];$action=$ds[1];
    if((count($ds)>=4) && (!($ds[2]=='downSearch'))) $rules=$ds[2];
    $s1= $model::model()->downSearch($m,$field,$rules,$ds[1]);
    return $s1;
}
  //扩充 记录对象转换成数组
  public function recToArray($tmp,$afieldstr) {
    $arr=array();
 
    $afieldstmp=explode(',',$afieldstr);
    if($tmp) //$rec=$tmp->attributes;
    foreach($afieldstmp as $v1){

      $a=explode(':',$v1);
      $r=$a[0]; $s1='';
      $r0=$r; $v20=0;
      if(isset($a[2])) {
         $s1= $a[2];//默认值
         $v20=1;
      }
      if(isset($a[1])){
          $r=(empty($a[1]))  ? $r : $a[1];//有别名
      }
      if($v20==0){ 
         $s1= $tmp->{$r0};//表的值
       }      
      $arr[$r]=$s1;
    }
    return $arr;
  }

  //扩充 记录对象转换成数组
  function toArray($cooperation,$afieldstr,$def_array=array())
  {
    $arr=$def_array;
    if(is_array($cooperation))
      foreach ($cooperation as $v) {
        $arr[]=$this->recToArray($v,$afieldstr);       
      }
    return $arr;
  }

     //输出模块//
    //输出JSON数据   第一个数组用于附加res.data 第二个数组附加res.data.data
public function echoEncode($rs,$code='200',$msg='获取成功',$ecode='400',$emsg='获取失败'){
    $rs['code']=$code;
    $rs['msg']=$msg;
    $rs['time'] = time();
    echo CJSON::encode($rs);
  }

public function echoAjxCode($data,$dateItem=''){
     if (!empty($dateItem)) $data=array($dateItem=>$data,'total'=>count($data));
     $r=array('data'=>$data);
     $this->echoEncode($r);
  }


public  function noNameArray($cooperation,$afieldstr)
 {
    $arr = array();$r=0;
    $afields=explode(',',$afieldstr);
    $cn=count($afields);
    if($cn>1){
      $arr=$this->moreArray($cooperation, $afields);
    } else{
      $v1=$afields[0];
      foreach ($cooperation as $v) {
         $arr[] =$v[$v1];
      }  
    }
    return $arr;
  }

 public  function moreArray($cooperation, $afields)
 {
    $arr = array();$r=0;
    foreach ($cooperation as $v) {
      $arr0 = array();
      foreach($afields as $v1){
       $vs=$v[$v1];
       $arr0[] = (empty($vs)) ? "" : $vs;
      }
      $arr[]= $arr0;
    }
    return $arr;
  }

    //扩充 记录对象转换成数组
  //=$title=array('当前界面：系统》查询》','明细信息','添加,刷新,批删除')
  function indexTitle($thisp,$title,$backn=0) {
    $ln=$this->ln(); $c1='';
    $s1=$ln.'<div '.$c1.'><table width="100%" ><tr ><td width="50%">';
    $s1.='<font style="width:100px;font-size:24px;">';//class="box-title c"
    $s1.=$ln.$title[0].'<a class="nav-a" style="color: #84563e">'.$title[1];
    $s1.='</a></font></td>';  
    $s1.='<td width="50%" align="right">'.$this->titleSet($thisp,$title[2]);
    $s1.='</td></tr></table>';
    if($backn) $s1.=$this->backPage();
    return $s1.$ln.'</div><!--box-title end-->';
  }

  //扩充 记录对象转换成数组
  function indexSearch($pscmd='') {
      $ln=$this->ln();
      $s1='';
      if(!empty($pscmd)){
       $s1= $ln.'<div >';//class="box-search"
       $s1.=(!empty($pscmd)) ? $ln.$this->boxSearch($pscmd) :'';
       $s1.=$ln.'</div><!--box-search end-->';
       }
      return $s1;
  }

 function indexGridHead($model,$pindex,$pfields,$pwidths=''){
    $ln=$this->ln();
    $s2=$pfields;$s3='操作';
    if(indexof($s2,'=')>=0){
      $ds=explode('=',$pfields.'=');
      $s3=$ds[0];$s2=$ds[1];
   // $s0=(empty($ds[1])) ?'操作' :$ds[0];
    }
    $s1=$ln.'<tr class="table-title"><th class="check">';
    $s1.=$ln.'<input id="j-checkall" class="input-check" type="checkbox"></th>';
    $s1.=($pindex==0) ?'' : $ln.'<th style="text-align:center; width:25px;">序号</th>';
    $s1.=$ln.$model->gridHead($s2,$pwidths);//($pfields,$pwidths);
    //$s1.=$ln.'<th><font style="font-weight:bold;font-size:16px;">'.$s3.'</font></th>';
    $s1.=$ln.'<th>'.$s3.'</th>';
    return  $s1.$ln.'</tr>';
  }

   function indexGridRow($thisp,$v,$index=0,$keyNames,$coumnName,$cmdstr,$bkn){
      $dkeys=explode(',',$keyNames);
      $idname=$dkeys[0];
      $keyvs=$this->getCmdParas($dkeys,$v);
      $id=$v[$idname];
      $ln=$this->ln(); 
      $bk=($bkn==1) ? '<tr>' :' <tr style="background: #eee">';
      $s1=$bk.$this->setRowCheck($id,$index);
      $s1.=$ln.$v->gridRowUrl($coumnName,$thisp,$idname);
      $s1.=$ln.$this->setDateOPter($thisp,$id,$cmdstr,$keyvs,$v).'</tr>';
      return $s1;
  }
  
  function indexGridRows($thisp,$arclist,$index0,$idname,$coumnName,$cmdstr){
      $index = 0;$bkn=0;
      $s1='';
      foreach($arclist as $v){ 
        $bkn=1-$bkn;
        $index+=$index0;    
        $s1.=$this->indexGridRow($thisp,$v,$index,$idname,$coumnName,$cmdstr,$bkn);
      }
      return $s1;
    }

    public function indexGridRowsHtml($thisp,$arclist,$index0,$idname,$coumnName,$cmdstr){
      $index = 0;$bkn=0;
      $s1='';
      $cmdstr='编辑:update,删除';
       foreach($arclist as $v){ 
        $bkn=1-$bkn;
        $index+=$index0;    
        $s1.=$this->indexGridRowNew($thisp,$v,$index,$idname,$coumnName,$cmdstr,$bkn);
      }
      return $s1;
    }

    function indexGridRowNew($thisp,$v,$index=0,$keyNames,$coumnName,$cmdstr,$bkn){
      $dkeys=explode(',',$keyNames);
      $idname=$dkeys[0];
      $keyvs=$this->getCmdParas($dkeys,$v);
      $id=$v[$idname];
      $ln=$this->ln(); 
      $bk=($bkn==1) ? '<tr>' :' <tr style="background: #eee">';
      $s1=$bk.$this->setRowCheck($id,$index);
      $s1.=$ln.$v->gridRowUrl($coumnName,$thisp,$idname);
      $s1.=$ln.$this->setDateOPter($thisp,$id,$cmdstr,$keyvs,$v);
      return $s1.'</tr>';
  }
  
//
//     $ht='positionCode,positionName,positionType,positionWidth,positionHeight,dataFlag';
//           $index=0;//是否显示序号 0 不显示  1 显示
//           $idName='positionId';//关键字的属性名称
//           $cmd='编辑:update,删除';//操作的命令
//          $gridset=array(0$index,1$idName,2$hfiels,3$hw,4$cmd);新版本把$HW宽带说明写入$hfiels
//           echo  BaseLib::model()->indexTable($this,$data,$arclist); 
//
   function indexTable($thisp,$model,$gset,$arclist){
      $ln=$this->ln();
      $s1=$ln.'<div class="box-table">';
      $s0=$this->indexTableinput($thisp,$model,$gset,$arclist);
      return $s1.$s0.$ln.'</div><!--box-table end-->';
  }



   //简化标题 需要模型和表说明
   public function gridHeadShow($model,$coumnName){
       return $this->indexGridHead($model,0,$coumnName);
   }
    //简化标题 需要模型和表说明
  public function gridRowsShow($thisp,$arclist,$idname,$coumnName,$cmdstr){
    $index0=0;
    $s0=$this->indexGridRows($thisp,$arclist,$index0,$idname,$coumnName,$cmdstr);
    $s1='<tbody id="tbody1">'.$s0.'<tbody></table>';    
    return $s1;
   }
   //
   public function showGridData($thisp,$model,$arclist,$idname,$coumnName,$cmdstr){
      $ln=$this->ln();
      $s1=$this->indexGridHead($model,0,$coumnName);
      $s1.=$this->gridRowsShow($thisp,$arclist,$idname,$coumnName,$cmdstr);
      return '<table class="list" >'.$ln.$s1.'</table>'.$ln;
   }


  function indexTableinput($thisp,$model,$gset,$arclist){
      $ln=$this->ln();
      if(count($gset)==4){ //表示缺省$HW宽度说明 该说明存放在标签中
        $gset[]=$gset[3];$gset[3]='';
      }
      $ds=explode('=',$gset[2].'=');
      $sf=$ds[0];
      if(!empty($ds[1])){
        $sf=$ds[1];
      }
      $s1=$ln.'<table class="list" >';
      $s1.=$this->indexGridHead($model,$gset[0],$gset[2],$gset[3]);
      $s0=$this->indexGridRows($thisp,$arclist,$gset[0],$gset[1],$sf,$gset[4]);
      $s1.='<tbody id="tbody1">'.$s0.'<tbody></table>';    
      return $s1;
  }
  
   function indexEchoHtml($thisp,$data,$pages,$title,$searchCmd){
      $ln=$this->ln();
      echo $this->indexTitle($thisp,$title);
      echo $ln.'<div class="box-content">';
      echo $this->indexSearch($searchCmd);
      echo $this->indexTable($thisp,$data);
      $this->showIndexPage($thisv,$pages,'2');
      echo '</div>';
  }

  public function splitstr($title=''){
    $d1=$title;$d2='';
    if(is_array($title)){
      $d1=$title[0];
      $d2=$title[1];
    }
    return array($d1,$d2);
  }

  public function backPage($comstr=''){
    $s1=$this->strToOtherCmd($comstr);
    $noReturn=setGetValue("noReturn");
    if(!(indexof($comstr,'返回(0)')>=0))
    if(indexof($comstr,'返回')<0){
      $s1.='<span class="back"><a class="btn" href="javascript:;" onclick="we.back();">';
      $s1.='<i class="fa fa-reply"></i>返回</a></span>';
     }
     return $s1;
  }
 
    public function updateTitleBox($title){
      $s1='';
      if(!empty($title)){
          $ln=$this->ln();
          $s1=$ln.'<div class="box-title c">';
          $st1='';//Munu::model()->getTitle();
          $d1=$this->splitstr($title);
          $s1.=$ln.' <h1><i class="fa fa-table">'.$st1.'</i>';
          $s1.='<span style="color:DodgerBlue">'.$d1[0].'</span></h1>';
          $s1.=$this->backPage($d1[1]);
          $s1.=$ln.'</div>';
      }
      return $s1;
    }

    public function updateSave($comstr,$str2=''){
      $ln=$this->ln();
      $s1=$this->strToCmd($comstr);
      if(!(indexof($comstr,'取消(0)')>=0))
      if(indexof($str2,'取消')<0)
        $s1.=$ln.'<button class="btn" type="button" onclick="we.back();">取消</button>';
      return  $s1;
    }
 
   public function strToCmd($comstr){
     $afields=explode(',',$comstr);
      $cmd=array();
      if(!empty($afields))
      foreach ($afields as $v1) {
         $v2=explode(':',$v1);
        if(count($v2)>=2) $cmd[$v2[1]]=$v2[0];
      }  
      $s1=show_shenhe_box($cmd);
      return $s1;
  }
  public function strToOtherCmd($comstr){
     $afields=explode(',',$comstr);
     $s1='';
     return '';
     if(!empty($comstr)){
       $thisp=$this->show_form;
       if(!empty($afields))
        foreach ($afields as $v1) {
           $v2=explode(':',$v1.':'.$v1);
           $s1.= $this->creatCommand($thisp,$v2[0],$v2[1]);
        }
    }
      return $s1;
  }
     // $s1.= $this->creatCommand($thisp,'添加','create',"fa-plus");

   public function updateSaveBox($comstr){
      $ln=$this->ln();
      $s1='';
      if(!empty($comstr) ){
         $s1=$ln.'<div class="box-detail-submit">';
         $d1=$this->splitstr($comstr);
         $s1.=$ln.$this->updateSave($d1[0],$d1[1]);
         $s1.=$this->strToOtherCmd($d1[1]);
         $s1.=$ln.'</div>';
      }
      return $s1;
    }
 


    public function updateSaveindexBox($comstr){
      $ln=$this->ln();
      $s1=$ln.'<div class="box-detail-submit">';
      if(!empty($comstr)){
       $d1=$this->splitstr($comstr);
        $s1.=$ln.$this->updateSave($d1[0],$d1[1]);
        $s1.=$this->strToOtherCmd($d1[1]);
      }
      return $s1.$ln.'</div>';
    }

    public function saveExam($comstr){
      $ln=$this->ln();
      $s1=$ln.'<div class="box-detail-submit">';
      if(!empty($comstr)){
        $d1=$this->splitstr($comstr);
        $s1.=$ln.$this->updateSave($d1[0],$d1[1]);
        $s1.=$this->strToOtherCmd($d1[1]);
      }
      return $s1.$ln.'</div>';
    }
 

 //设置格式多列的样式 1:3=$inputCmd),获得样式
  public function checkColspan($inputCmd){
   $ds=explode('=',$inputCmd);
   if(count($ds)>1){
      $s2=$ds[1];
      $s2=str_replace(",",";+",$s2);
      $ds1=explode(';',$s2);
      $s2=':'.$ds[0];
      $s1='';
      foreach ($ds1 as $v1) {
        if(!empty($v1)){
            $d2=explode(':',$v1);
            $s1.=';'.$v1.((count($d2)>2) ? '' : $s2);
         }
      }
      $s2=substr($s1,1);//删除前面的';'
      $inputCmd=str_replace(";+",",",$s2);
    }
    return $inputCmd;
  }
 
  public function getAttributeName($attribName){
    $ds=explode('=',$attribName);
    $rs=array();
    if(count($ds)>1){
      $s2=$ds[1];
      $s2=str_replace(",",";",$s2);
      $ds1=explode(';',$s2);
      foreach ($ds1 as $v1) {
        if(!empty($v1)){
            $d2=explode(':',$v1);
            $rs[]=$d2[0];
         }
      }
    }
    return $rs;
  }
 
 //$inputCmd='1:3=F_CODE:1:1,F_NAME:1:1;F_LENAME;F_LSNAME;F_LLNAME;F_SHOW:YN';
public function setTdstyle($style,$attribName){
   $rs=$this->getAttributeName($attribName);
   $td=array('label'=>'','input'=>'');
   foreach ($rs as $v) {
     $tmp=array();
     if(isset($style['all'])) $tmp=$this->getStyleSet($style['all'],$v);
     if(isset($style[$v])) $tmp=$this->getStyleSet($style[$v],$v,$tmp);
     $td[$v]=$tmp;
   }
   $this->td_style=$td;
}

//获得属性设计说明
public function getTdStyle($aName){
 $style=$this->td_style;
 $tdm=array('class'=>'input-text click_time','style'=>'height:25px');
 $labelm='style="padding:15px;"';
 $td=array('label'=>$labelm,'input'=>$tdm);
 if(is_array($style)){
   if(isset($style[$aName])) { 
     $td=$this->getStyleSet($style[$aName],$aName,$td);
    }
  }
 if(empty($td['input'])) $td['input']=$tdm;
 if(empty($td['label'])) $td['label']=$labelm;
 return $td;
}

public function getStyleSet($style,$aName,$td=array('label'=>'','input'=>'')){
   if(isset($style['label'])) $td['label']=$style['label'];
   if(isset($style['input'])) $td['input']=$style['input'];
   return $td;
}
 //
  //array('all'=>array('label'=>'','input'->''),'id'=>array('label'=>'','input'->''));
  

  public function showTableData($thisv,$model,$seachcomstr,$data,$arclist,$pages){
    $ln=$this->ln();
    echo '<div class="box-content">';
    echo $this->indexSearch($seachcomstr); 
    echo  $this->indexTable($thisv,$model,$data,$arclist); 
    $this-> showIndexPage($thisv,$pages,'1',$data);
    echo '</div>';
  }

    public function inputTableData($thisv,$model,$seachcomstr,$data,$arclist,$pages){
    $ln=$this->ln();
    echo '<div class="box-content">';
    echo $this->indexSearch($seachcomstr); 
    echo  $this->indexTable($thisv,$model,$data,$arclist); 
    $this->showIndexPage($thisv,$pages,'1',$data);
    echo '</div>';
  }


  function aset_Pagesize($thisp,$data){
  //  return '';
   $url=$thisp->createUrl("indexData");
   $s1=$this->getRowsmsg($url,$data);
   $rs="<script> jsGetDatas(15,".$s1.");</script>";
   return $rs;
}

  function set_Pagesize($thisp,$data){
  //  return '';
   $url=$thisp->createUrl("indexData");
   $s1=$this->getRowsmsg($url,$data);
   $rs="<script>
    function changPage(Psize,purl,pid,pname,pcmd){ 
    $.ajax({
        type: 'post', url: purl,
        data: { pageSize: Psize, keyid:pid,keyname:pname,keycmd: pcmd},
        dataType: 'json',
        success: function(data) {
           console.log(data);
          document.getElementById('tbody1').innerHTML =data['html'];
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
        }
    });
  }
//  changPage(15,".$s1.");
 </script>";
  return $rs;
}



//===

 public function getRowsmsg($url,$data){
    return "'".$url."','".$data[1]."','".$data[2]."','".$data[4]."'";
  }
// $coumnName='positionCode,positionName,positionType,positionWidth,positionHeight,dataFlag:YN';
 //  $hw='0:15%,1:25%,2:10%,3:10%,4:10%,5:10%,6:5%';//每列的宽度
 //  $index=0;//是否显示序号 0 不显示  1 显示
 //  $idName='positionId';//关键字的属性名称
 //  $cmd='编辑:update,删除';//操作的命令
 //  $data=array($index,$idName,$coumnName,$hw,$cmd);
 
  public function indexShow($thisv,$model,$title,$schcmd,$data,$arclist,$pages){
    $this->show_form= $thisv;
    echo  $this->indexTitle($thisv,$title);
    $this->showTableData($thisv,$model,$schcmd,$data,$arclist,$pages);
  }

//   $coumnName='positionCode,positionName,positionType,positionWidth,positionHeight,dataFlag:YN';
//   $hw='0:15%,1:25%,2:10%,3:10%,4:10%,5:10%,6:5%';//每列的宽度
//   $index=0;//是否显示序号 0 不显示  1 显示
//   $idName='positionId';//关键字的属性名称
//   $cmd='编辑:update,删除';//操作的命令
//   $data=array($index,$idName,$coumnName,$hw,$cmd);
//   $extdata=array($showdatamodel,$showdatastr); 要显示数据模型和数据
 
  public function indexData($thisv,$model,$title,$scomstr,$data,$arclist,$pages,$eData=''){
    $pn=(empty($eData)) ? 1 : 0; 
    echo $this->indexTitle($thisv,$title,$pn);
    $indexUpdate=get_session("indexUpdate");
    if($indexUpdate=='1'){
       $this->updateInput($thisv,$eData[0],$eData[1],$model,$scomstr,$data,$arclist,$pages);
     } else{
       if(!empty($eData)) $this->updateBox($thisv,$eData[0],$eData[1]);
       $this->showTableData($thisv,$model,$scomstr,$data,$arclist,$pages);
     }
  }


public function updateMoreRow( $thisv,$model,$inputCmds,$title=''){
   $s1='<table class="table-title"><tr><td>详细信息</td></tr></table>';
   return $s1;
  }

public function updateAddBottom( $title='详细信息'){
    $s0=$title.$this->clickCommand('add_proc','添加',"fa-plus");
    return '<table class="table-title"><tr><td>'.$s0.'</td></tr></table>';
  }

public function updateInput($thisv,$sm,$comstr,$model,$scomstr,$data,$arclist,$pages){
    $ln=$this->ln();
    $this->setUpdateStyle($inputCmds);
    $s1=$ln.'<div class="box">';
    echo  $s1.$this->updateTitleBox($title);
    $form= $this->widgetStart($thisv);
    echo '<div class="box-detail-bd">';
    $s0=$this->tableInput($form,$sm,$comstr);
    echo $s0.$this->updateAddBottom();
    echo $this->indexSearch($seachcomstr); 
    echo  $this->indexTableinput($thisv,$model,$data,$arclist); 
    echo $this->updateSaveBox($data[5]);
    echo $this->ln().'</div><!--box-detail end-->';
    $this->widgetEnd($thisv);
    $this->showIndexPage($thisv,$pages,'1',$data);
    echo $ln.'</div><!--box end-->';
  }


public function updateBox($thisv,$model,$inputCmds,$title='',$comstr=''){
    $ln=$this->ln();
    $this->setUpdateStyle($inputCmds);
    $s1=$ln.'<div class="box">';
    echo $s1.$this->updateTitleBox($title);
    $form= $this->widgetStart($thisv);
    $s1=$ln.'<div class="box-detail-bd">';
    echo $s1.$ln.'<div style="display:block;" class="box-detail-tab-item">';
    echo $this->tableInput($form,$model,$inputCmds);
    echo $this->updateSaveBox($comstr);
    echo $this->ln().'</div></div><!--box-detail-bd end-->';
    $this->widgetEnd($thisv);
    echo '</div>';
    // echo $this->getUpdatejs($thisp,$comstr)
  }

public function updateHtml($thisv,$model,$inputCmds,$title='',$comstr=''){
    $ln=$this->ln();
    $this->setUpdateStyle($inputCmds);
    $s1=$ln.'<div class="box">';
    echo $s1.$this->updateTitleBox($title);
    $form= $this->widgetStart($thisv);
    $s1=$ln.'<div class="box-detail-bd">';
    echo $s1.$ln.'<div style="display:block;" class="box-detail-tab-item">';
    echo $this->tableInput($form,$model,$keys[0]);//$inputCmds);
    echo $this->updateSaveBox($comstr);
    echo $this->ln().'</div></div><!--box-detail-bd end-->';
    $this->widgetEnd($thisv);
    echo '</div>';
    echo $this->getUpdatejs($thisv,$inputCmds);
  }

function getUpdatejs($thisp,$comstr){
   $url=$thisp->createUrl("UpdateData");
   $keys=get_session("update_key");
   $modelname=get_session("update_model");
   $id=$keys[1];
   $s1="'".$url."',".$id.",'".$keys[0]."','".$comstr."'";
   $rs="<script>
    function getUpdateData(purl,pid,pname,pcmd){ 
    $.ajax({
        type: 'post', url: purl,
        data: { keyid:pid,keyname:pname,keycmd: pcmd},
        dataType: 'json',
        success: function(data) {
          console.log(data);
          document.getElementById('table1').innerHTML =data['html'];
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
          var s0=XMLHttpRequest.responseText;
          var i = s0.indexOf('>');
          if(i !==-1){
        //  console.log(XMLHttpRequest.responseText);
          s0=s0.slice(i+1);
          var s1=JSON.parse(s0);
           document.getElementById('table1').innerHTML =s1['html'];
       //   console.log(s1); 
        }
          //  console.log(XMLHttpRequest);
        }
    });
  }
  </script>
  <script> getUpdateData(".$s1.");//  console.log('1111000a='); </script>";
  return $rs;
}
 
public function setUpdateStyle($inputCmds=''){
    if(is_array($inputCmds)){
      $inputCmd=$inputCmds;
      $inputStyle=array();
      if (is_array($inputCmds)){
        $inputCmd=$inputCmds['command'];
        $inputStyle=$inputCmds['style'];
      }
      $this->setTdstyle($inputStyle,$inputCmd);
      $inputCmd=$this->checkColspan($inputCmd);
    }
  }


  public function widgetStart($thisv){
    echo '<div class="box-detail">';
    return $thisv->beginWidget('CActiveForm', get_form_list());
  }

  public function widgetEnd($thisv){
    $thisv->endWidget();
    echo $this->ln().'</div><!--box-detail end-->';
  }


// $inputCmd='1:3=F_CODE;F_CODEXH;F_NAME;F_value';
//1：3 表示每个TD是1显示标签的宽带，3表示输入内容的宽带ROLSPA
//;表示换行,','表示一个输入框
////$this->getTableLine($form,$m,$v,$tr)
//trInput($form,$m,$str,$tr="1",$rd='',$aselect=array())
//
public function btableInput($form,$m,$str,$tr="1") {
   $ln=$this->ln();
  if(indexof($str,'=')>=0){
    $str=$this->checkColspan($str);
   }
  if(is_string($form)){
     $s00=$form.'Controller';
     $form=new $s00();
  }
  $d=explode(';',$str);//每一行
  $s1='';
  $this->show_line='';
  $vlise=0;$vlise1=0;$vlise2=0;
  foreach($d as $v){
    $b1='';$b2='';
    $n1=indexof($v,'<');
    $n2=indexof($v,'>');
    if($n1>=0){
       $vlise+=1;$vlise1=1;
       $v=str_replace('<','',$v);
    }
    if($n2>=0 ){
       $v=str_replace('>','',$v);
    }
    if($vlise1==1){
      $vlise2+=1;
      $this->show_line='<tr id="block_'.$vlise.'_'.$vlise2.'" style="display:none">';
    }

    $s1.=$ln.$this->getTableLine($form,$m,$v,$tr);
    if($n2>=0 ){
       $this->show_line='';$vlise1=0; $vlise2=0;
    }
   }
   $s1='<table id="table1" name="table1" >'.$s1.$ln.'</table>';
   return $s1;     
}

public function tableInput($form,$m,$str,$tr="1") {
   $ln=$this->ln();
   if(indexof($str,'=')>=0){
    $str=$this->checkColspan($str);
   }
  if(is_string($form)){
     $s00=$form.'Controller';
     $form=new $s00();
  }
  $d=explode(';',$str);//每一行
  $s1='';
  $this->show_line='';
  $vlise=0;$vlise1=0;$vlise2=0;
  foreach($d as $v){
    $s1.=$this->tableInputRow($form,$m,$v,$vlise,$vlise1,$vlise2,'1');
   }
   $s1='<table id="table1" name="table1" >'.$s1.$ln.'</table>';
   return $s1;     
}

public function tableInputRow($form,$m,$v,&$vlise,&$vlise1,&$vlise2,$tr='1') {
  $ln=$this->ln();
  $b1='';$b2='';$s1='';
  $n1=indexof($v,'<');
  $n2=indexof($v,'>');
  if($n1>=0){$vlise+=1;$vlise1=1; $v=str_replace('<','',$v);}
  if($n2>=0 ){ $v=str_replace('>','',$v);}
  if($vlise1==1){
    $vlise2+=1;
    $this->show_line='<tr id="block_'.$vlise.'_'.$vlise2.'" style="display:none">';
  }
  $s1.=$ln.$this->getTableLine($form,$m,$v,$tr);
  if($n2>=0 ){ $this->show_line='';$vlise1=0; $vlise2=0;}
  return $s1;     
}

   public  function tableInputBox($form,$model,$comstr){
      $ln=$this->ln();
      $s1=$ln.'<div class="box-detail-bd">';
      $s1.=$ln.'<div style="display:block;" class="box-detail-tab-item">';
      $s1.=$this->tableInput($form,$model,$comstr);
      return $s1.$this->ln().'</div></div><!--box-detail-bd end-->';
    }

  public function showIndexPage($thisv,$pages,$pno='1',$data=''){
    echo '<div class="box-page c" id="page'.$pno.'">';
    $thisv->page($pages); 
    echo '</div>'.$this->set_Pagesize($thisv,$data);
  }

 public function showInfo($thisv,$m,$stemplate){
    $form=$this->widgetbegin($thisv);   
    $s1='';
    if(!empty($m) ){
       $str=$this->recTableshow($stemplate);
       $s1=$this->tableInput($form,$m,$str,"1");
     }
    echo $s1;
    $this->widgetEnd($thisv);
    return '';
 }
  public function recTableshow($str) {
   $str=str_replace(':r:',':label:',$str);
   $str=str_replace(':R:',':label:',$str);
   $str=str_replace(':r,',':label,',$str);
   $str=str_replace(':R,',':label,',$str);
   return  $str;     
  }

  public  function dele_char($s1){
     $s1=str_replace(trim(' / '),"0",$s1);
     $s1=str_replace(trim(' \ '),"0",$s1);
     $s1=str_replace("'","0",$s1);
     $s1=str_replace('"',"0",$s1);
     $s1=str_replace('(',"0",$s1);
     $s1=str_replace(')',"0",$s1);
     $s1=str_replace(' ',"0",$s1);
     $s1=str_replace(',',"0",$s1);
     $s1=str_replace('-',"0",$s1);
     $s1=str_replace('=',"0",$s1);
     $s1=str_replace('<',"0",$s1);
     $s1=str_replace('>',"0",$s1);
     $s1=str_replace('*',"0",$s1);
     $s1=str_replace('.',"0",$s1);
     $s1=str_replace('&',"0",$s1);
     $s1=str_replace('@',"0",$s1);
     $s1=str_replace('$',"0",$s1);
     $s1=str_replace('#',"0",$s1);
     $s1=str_replace(trim(' / '),"0",$s1);
     $s1=str_replace(trim(' \ '),"0",$s1);
     $s1=str_replace('&',"0",$s1);
     return $s1;
    }

  public static function downList($datalist,$idname,$showname,$selectname,$pvalue='0') {
      $html='<select name="'.$selectname.'">';
      $html.='<option value="">请选择</option>';
      foreach($datalist as $v){
       $html.='<option value="'.$v[$idname].'"'.(($v[$idname]==$pvalue) ? ' selected >' :'>');
       $html.=$v[$showname].'</option>';
       }
       $html.='</select>';
       return $html;
    }
   
     public static function optionList($datalist,$id,$showname,$value='0') {
      $html='<option value="">请选择</option>';
      foreach($datalist as $v){
       $html.='<option value="'.$v[$id].'"'.(($v[$id]==$value) ? ' selected >' :'>');
       $html.=$v[$showname].'</option>';
       }
       return $html;
    }

    public function delchar($str,$delstr) {
    $ds1=explode(',',$delstr);
    foreach ($ds1 as $v1) {
      $str=str_replace($v1,'',$str);
    }
   return  $str;     
  }
}  
