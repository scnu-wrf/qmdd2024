<?php
class baseTemplate extends BaseModel {
 
    public function tableName() {
        return  '{{base_no}}';
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**
     * 属性标签
     */
    public function attributeLabels() {
       return array('areaId' =>'id','areaName'=>'名称',  );
    }
   public function searchHtml(){
    $yii=Yii::app()->request;
   	$s1='<div>
    <form action="'.$yii->url.'" method="get">
      <input type="hidden" name="r" value="'.$yii->getParam('r').'">
    <label style="margin-right:10px;"> <span>关键字：</span>
    <input id="keywords" style="width:200px;" class="input-text" type="text"
     name="keywords" value="'.$yii->getParam('keywords').'">
    </label>
    <button class="btn btn-blue" type="submit">查询</button>
    </form>
   </div><!--box-search end-->';
    return $s1;
   }
// 通用查询
// $data=array('idname'=>$idname,'col'=>$colname);
  public function selectShow($thism,$model,$data,$arclist,$pages) {
       $s1='<div class="box"><div class="box-content">';
       $s1.=$this->searchHtml();
       $s1=$this->tableBoxHtml($arclist,$data['col'],$model);
       echo $s1;
       $this->echoPage($thism,$pages);
       $s1='</div><!--box-content end-->';
       $s1.='</div><!--box end-->';
       echo $s1;
    }
    

  public function echoPage($thism,$pages) {
      echo '<div class="box-page c">';
      $thism->page($pages);
      echo  '</div>';
    }

  public function tableBoxHtml($arclist,$colname,$model) {
      $s1='<div class="box-table">';
      $s1.=$this->tableHtml($arclist,$colname,$model);
      return $s1.'</div><!--box-table end-->';
  }

  public function tableHtml($arclist,$colname,$model){
   	$s1='<table class="list" id="table_input" name="table_input">';
    $s1.=$this->tableheahHtml($model,$colname);
    $s1.=$this->tablebodyHtml($arclist,$colname);
    return $s1.'</table>';
  }
/*
 $col='f_goodsid:h,f_code:10%:r,f_name:35%:r,f_sname:20:r,f_amount:10:r';//
 */
  public function tableheahHtml($pmodel,$colname,$padd=0) {
    $ds=explode(',',$colname);
    $coln=$this->getRown($ds);
    $m=$pmodel::model();
    $s0='<a id="j-add" class="btn" href="javascript:;"';
    $s0.=' onclick="add_proca();">添加</a>';
    $s1='<td colspan="'.$coln.'" >'.(($padd==0) ?'请选择' : $s0);
    $s1.='</td></tr><tr>';
    if($padd==0){
      $s1.='<td class="check"><input id="j-checkall" ';
      $s1.='class="input-check" type="checkbox"></td>';
    }
    foreach ($ds as $key => $value) {
      if(indexof($value,':h')<0){
        $ds1=explode(':',$value);
        $tn= $m->getAttributeLabel($ds1[0]);
        $s1.='<td style="text-align:center;">'.$tn.'</td>';
      }
    }
    if($padd) $s1.='<td style="text-align:center;" width="5%">操作</td>';
    return '<tr>'.$s1.'</tr>';
  }

  //读取表头列数
  public function getRown($ds) {
    $coln=1;
    foreach ($ds as $key => $value) {
      if(indexOf($value,':h')<0){
         $coln++;
      }
    }
    return $coln; 
  }

/*
 $rdata {"name":"goods","id":"id","col":"f_goodsid:id,f_code,f_name,f_sname,f_amount=0"}
 */
  public function tablebodyHtml($arclist,$colname) {
  $s1='';$r=0;
  $ds=getToFields($colname);
  $rdata=setGetValue('select_rdata');
  //$rdata=set_session('select_rdata');
  $idname= $rdata['id'];
  $df=getToFields($rdata['col'],1);
  foreach($arclist as $v){ 
      $s0='';
      $id=$v[$idname];

      $s1.='<tr id="line'.$r.'" data-id="'. $id.'"'; 
      $s1.=' data-code="'.$idname.'"'; 
      //$s1.=' data-str="'.$s0.'"';
      $s1.=' data-index="'.$r.'">';
      $s1.='<td class="check check-item"><input class="input-check" ';
      $s1.='type="checkbox" value="'.$id.'"></td>';
      foreach ($ds as  $v1) {
        $s1.='<td style="text-align:center;">'.$v[$v1[0]].'</td>';
      }
      $s1.='</tr>';
      $r++;
    } 
    return '<tbody>'.$s1.'</tbody>';
  }

//$form,$arclist,$id,$mname,$mmodel;'id'=>'id','colName'=>$colName);
//参数分别报考 表达，数据列表，表的主健名ID, 显示的表值，模型名称等
public function tableRowinputHtml($form,$arclist,$id,$mname,$mmodel) {
  $s1='';$s0='';
  //$s01='f_code:0:1:label,f_name:0:1:label,f_sname:0:1,f_amount:0:1';
  $s0=''; $r=-1;
  $s00='<input name="'.$mmodel.'[';
  $s01='][]" type="hidden" value="';
  $dm= $this->tonewCols($mname);//$dm[0] 要输入的字段，$dm[0] 要隐藏字段
  $w1='<td><a class="btn" href="javascript:;" onclick="delrec(';
  $w2=');" title="删除"><i class="fa fa-trash-o"></i></a></td>';
  foreach($arclist as $v){
     $r++;
     $s1=BaseLib::model()->tableInput($form,$v,$dm[0][0]);
     $s1=str_replace('<table id="table1" name="table1" >',"",$s1);
     $s1=str_replace("</table>","",$s1);
     $s1=str_replace(']"','][]"',$s1);
     $s02="";
     foreach ($dm[1][0] as $vv0) {
       $v0=$vv0;
       $s02.=$s00.$v0.$s01.$v[$v0].'" />';
     }
     $w0=$w1.$r.$w2.$s02;
     $s1=str_replace("</tr>",$w0."</tr> ",$s1);
     $s0.=str_replace('<tr ','<tr index="'.$r.'" ',$s1);//index="'.$r.'" id="aaa"
   } 
   setGetValue("select_index",$r);
   setGetValue("select_update_field",$id.str_replace('"','',$dm[2]) );//模型处理需要
  
  $s23='"'.$mmodel.'"'.$dm[2];//用于生产 录入和保存的字段使用

  $s0='<tbody id="tbody1" name="tbody1">'.$s0.'</tbody>';

  return $s0;
}

// 2023.11.18

// 把列格式有1 转2
// 1 f_goodsid:h,f_code:10%:r,f_name:35%:r,f_sname:20:r,f_price,f_amount
// 2  f_code:0:1:label,f_name:0:1:label,f_sname:0:1,f_amount:0:1
 function tonewCols($s1){
   $ds=explode(',',$s1);
   $s21='';$s22=array();$r="";$b1='';$b2='';
   $coln=1;$s23='';
   foreach($ds as $key => $value) {
      $d=explode(':', $value);
      if(indexOf($value,':h')>=0){
        $s22[]=$d[0];
      } else{
         if(indexOf($value,':r')>=0){ //显示的字段
          $r=':label';
         } else{ //输入的字段 用于
            $s23.=',"'.$d[0].'"';//,"'f_price','f_amount'
         }
         $s21.=$b1.$d[0].':0:1'.$r;//构成输入的字符格式f_code:0:1:label,f_name:0:1:label,f_sname:0:1,f_amount:0:1
         $b1=',';$r='';
      }
      $r='';
    }
    return array(array($s21),array($s22),$s23); 
}


/*
//$sdata=array('modelname'=>'goodsData','pid'=>$smodel->id,
    'pidname'=>'f_rid','id'=>'id','colName'=>$colName);
  */
  public function getUpdateMore($form,$datas){
    $sdata=$datas['smode'];
    $pdata=$sdata['pmode'];
    setGetValue("select_col",$datas['rmode']);//关联数据描述模式
    //$sdata['modelname'] 外键名称，$sdata['pid']外键值
    $w1=$pdata['pname'].'='.$pdata['pid'];//查找条件
    $m=$sdata['name'];
    $tmp=$m::model()->findAll($w1);//子表记录
    $colnames=$sdata['col'];
    $s1=$this->tableheahHtml($m,$colnames,1);
    $s1.=$this->tableRowinputHtml($form,$tmp,$sdata['id'],$colnames,$m);
    return '<table class="list" id="table_input" name="table_input">'.$s1.'</table>';
   }

 public function getUpdateData($thisv,$model,$title,$schcmd,$data){
  	$bm=BaseLib::model();
  	$form=$bm->showHeadUpdate($thisv,$title);
    $s0=$bm->tableInput($form,$model,$schcmd);
    return $s0;
   }

 public function updateHead(){
  $s0='<div class="box-title c">
  <h1>当前界面：选择数据名称处理》 <a class="nav-a">数据名称选择详情</a></h1>
  <span class="back"><a class="btn" href="javascript:;" onclick="we.back();">
  <i class="fa fa-reply"></i>返回</span></a></h1>
  </div><!--box-title end-->
  <script>
  setModel("goodsData","f_amount,f_price");
  </script>
  ';
    return $s0;
   }

/*
  $opdata=array('title'=>$tltle,'savecmd'=>'保存:baocun');
  $mdata=array('model'=>$smodel,'updatename'=>$mnames);//主数据模型和字段
  //主子数据模型，模型名，主键，修改字段
  $smode=array('name'=>'goodsData','id'=>'id','col'=>$colName);
  //关联父模型
  $pmode=array('name'=>'goodsreport','pid'=>$smodel->id,'pidName'=>'f_rid');
  //关联子模型来源，可能多个
  $rcol='f_goodsid:id,f_code,f_name,f_sname,f_amount=0';
  $rmode=array('name'=>'goods','id'=>'id','col'=>$rcol);
  $datas=array('mmode'=>$mmodel,'smode'=>$smodel,'pmode'=>$pmodel,'rmode'=>$rmode);
?>
*/
 public function updatelist($thisv,$opdata,$datas){
    $mdata=$datas['mmode'];
    $sdata=$datas['smode'];
    $rdata=$datas['rmode'];
    setGetValue('select_rdata',$rdata);
    setGetValue('select_sdata',$sdata);
    setGetValue('select_form',$thisv);
    echo '<div class="box">';
    echo $this->updateHead();
    $bm=BaseLib::model();
    $form= $bm->widgetStart($thisv);
    echo '<table class="table-title"><tr><td>信息修改</td></tr></table>';
    echo $bm->tableInput($form,$mdata['model'],$mdata['updatename']);
    echo $this->getUpdateMore($form,$datas);
    echo $bm->updateSaveBox($opdata['savecmd']);
   $bm->widgetEnd($thisv);
}

//$M 是主表(要保存的表），$tmp选择数据的表，报考关联表
public function selectHtml($m,$tmp) {
      $rs=setGetValue("select_col");//数据来源字段
      $sdata=setGetValue('select_sdata');//数据表
      $pmode=$rs['name'];//'goods';$id='id';
      $idname=$rs['id'];
      $pcolnames=
      $fieldstr=$rs['col'];
      $data = array('colname'=>$pcolnames,'idname'=>$id);
     // $tmp = $pmode::model()->findAll($idname.' in ('.$ids.')');
     // $m=goodsData::model()->find();
      $ds =$this->tonewCols($sdata['col']);//属性处理隐蔽属性ds[/1]和显示属性[0]
      $hf=$ds[1];$sf=$ds[0];
      $mid=$sdata['id'];//主表数据
      $pmode=$sdata['name'];//主表名称
      $mp[$mid]=0;//0表示添加
      $s1='';
      $r=setGetValue("select_index");
      $w1='<td><a class="btn" href="javascript:;" onclick="delrec(';
      $w2=');" title="删除"><i class="fa fa-trash-o"></i></a></td>';
      foreach ($tmp as $k => $v) {
         $r++;
         $m->setFromArray($v,$fieldstr);//数据生产新表
         $s01=$this->hiddenInput($m,$pmode,$hf);//隐藏内容
         $s01.=$this->inputData($m,$pmode,$sf);//显示标签内容说明
         $w0=$w1.$r.$w2;
         $s1.=' <tr index="'.$r.'" >'.$s01.$w0.'</tr> ';
      }
      setGetValue("select_index",$r);
      return $s1;
  }

public function hiddenInput($m,$mmodel,$fields) {
  $s1='';
  //$s01='f_code:0:1:label,f_name:0:1:label,f_sname:0:1,f_amount:0:1';
  $s00='<input name="'.$mmodel.'[';
  $s01='][]" type="hidden" value="';
  foreach($fields[0] as $v){
    $v0=$v;//隐藏属性
    $s1.=$s00.$v0.$s01.$m[$v0].'" />';
   }
   return $s1;   
}

public function onInput($mmodel,$fields,$value) {
  $idn=$mmodel.'_'.$fields;
  $s1.='<input class="input-text click_time" style="height:25px"';
  $s1.=' name="'.$mmodel.'['.$fields.'][]"';
  $s1.=' id="'.$idn.'" type="text" value="'.$value.'" />';
  $s1.='<div class="errorMessage" style="display:none"';
  $s1.=' id="'.$idn.'_em_" ></div>';
  return $s1;   
}

public function inputData($m,$mmodel,$fields) {
  $s1='';
  $ds=explode(',',$fields[0]); 
  foreach($ds as $v){
    $dm=explode(':',$v);
    $na=$dm[0];//属性名称
    $val=$m[$na];
    if(indexOf($v,'label')<0){
      $val=$this->onInput($mmodel,$na,$val);
    }
    $s1.='<td>'.$val.'</td>';
   }
   return $s1;   
} 

public function  getPath(){
   return BasePath::model()->sitePath();
}

public function  linkcs($pfile){
   $ps=$this->getPath();
   $rs='<link rel="stylesheet" type="text/css" href="'.$ps.'static/admin/';
   return $rs.$pfile.'" />'.chr(13).chr(10);
}

public function  linkjs($pfile){
    $ps=$this->getPath();
   $rs='<script type="text/javascript" src="'.$ps.'static/admin/';
   return $rs.$pfile.'"></script>'.chr(13).chr(10);
}
public function  linkasjs($pfile){
   $ps=$this->getPath();
   $rs='<script type="text/javascript" src="'.$ps.'assets/c6aea6c/';
   return $rs.$pfile.'"></script>'.chr(13).chr(10);
}
public function getJsfile(){
   $rs= '<meta charset="utf-8">';
   $rs.=$this->linkcs('css/public.css');
   $rs.=$this->linkcs('css/font.css');
   $rs.=$this->linkcs('css/style.css');
   $rs.=$this->linkcs('js/jquery.fallr/jquery.fallr.css');
   $rs.=$this->linkcs('js/jquery.datetimepicker.css');
   $rs.=$this->linkcs('js/jquery.uploadifive/uploadifive.css');
   $rs.=$this->linkcs('js/artDialog/skins/default.css'); 
   $rs.=$this->linkcs('js/jquery.contextMenu/jquery.contextMenu.css');

   $rs.=$this->linkasjs('jquery.min.js'); 
   $rs.=$this->linkjs('js/jquery.nicescroll.js');
   $rs.=$this->linkjs('js/jquery.fallr/jquery.fallr.js');
   $rs.=$this->linkjs('js/ueditor/ueditor.config.js'); 
   $rs.=$this->linkjs('js/ueditor/ueditor.all.min.js');

  $rs.=$this->linkjs('js/ueditor/lang/zh-cn/zh-cn.js');
  $rs.=$this->linkjs('js/ueditor/ueditor.parse.min.js');
  $rs.=$this->linkjs('js/jquery.datetimepicker.js');
  $rs.=$this->linkjs('js/jquery.uploadifive/jquery.uploadifive.min.js');
  $rs.=$this->linkjs('js/My97DatePicker/WdatePicker.js');
  $rs.=$this->linkjs('js/artDialog/jquery.artDialog.js');
  $rs.=$this->linkjs('js/artDialog/plugins/iframeTools.js');
  $rs.=$this->linkjs('js/jquery.contextMenu/jquery.ui.position.js');
  $rs.=$this->linkjs('js/jquery.contextMenu/jquery.contextMenu.js');
  $rs.=$this->linkjs('js/md5.js');
  $rs.=$this->linkjs('js/Base64.js');
  $rs.=$this->linkjs('js/base64_1.js');
  $rs.=$this->linkjs('js/public.js');
  $rs.=$this->linkjs('js/spark-md5.js');
  ///$rs.=$this->linkjs('');
  return $rs;
}

public function tohtml($output){
    $s0=chr(13).chr(10);
    $s2=baseTemplate::model()->getJsfile();
    $s1=str_replace('<title></title>',$s2.'<title></title>',$output);
    $s1=str_replace($s0.$s0,$s0,$s1);
    $s1=str_replace($s0.$s0,$s0,$s1);
    $s1=str_replace($s0.$s0,$s0,$s1);
    if(indexof($s1,'<tbody>')>=0){
      $s1=str_replace('<tbody>','<tbody id="table_html">',$s1);
    }else{
      $s0='</thead>';
      $s0= (indexof($s1,$s0)>0) ? $s0 :'</tr>';
      $r1=indexof($s1,$s0);
      if($r1>=0)
      {
       $s3=substr($s1, 0,$r1).$s0.'<tbody id="table_html">';
       $s3.=substr($s1,$r1+4);
       $r1=indexof($s3,'</table>');
       $s1=substr($s3, 0,$r1).'</tbody>'.substr($s3,$r1);
      }
    }
    $s00=$this->checkFile();
    $s00=chr(13).chr(10).'<script> var mfields='.$s00.'</script>'.chr(13).chr(10);
    $s0='class="box-page c"';
    $s1=str_replace($s0,$s0.' id="page_html" ',$s1);
    $s1=str_replace('</body>',$s00.'</body>',$s1);
  //  putStrTohtml($s1);
 }

function checkFile(){
   $rs=$this->getPhpFile();
   if(indexof($rs,'<table')>=0){
     $r1=indexof($rs,'<table');
     $r2=indexof($rs,'</table');
     $rs=substr($rs,$r1,$r2-$r1);
     $r1=indexof($rs,'</tr');
     $rs=substr($rs,$r1+5);
     $r1=indexof($rs,'<tr');
     $r2=indexof($rs,'</tr');
     $rs=substr($rs,$r1,$r2-$r1);
     $rs=$this->deleMemo($rs);
     $str=json_encode( $rs,JSON_UNESCAPED_UNICODE);
     return $str;
   }
}

function deleMemo($rs){
    while (indexof($rs,'<!--')>=0 ) {
       $r1=indexof($rs,'<!--');
       $r2=indexof($rs,'-->');
       $rs=substr($rs,0,$r1).substr($rs,$r2+3);
     }
    $rs=$this->deleMoreChar($rs,'</td ','</td');
    $rs=$this->deleMoreChar($rs,' <td','<td');
    $rs=$this->deleMoreChar($rs,'<td  ','<td ');
    $rs=str_replace(chr(13),'',$rs);
    $rs=str_replace(chr(10),'',$rs);
    $rs=$this->deleMoreChar($rs,' <?php','<?php');
    $rs=$this->deleMoreChar($rs,'<?php  ','<?php ');
    $rs=$this->deleMoreChar($rs,'  ?>',' ?>');
    $rs=$this->deleMoreChar($rs,' ?> ',' ?>');
    $rs=$this->deleMoreChar($rs,' ?>','?>');
    $rs=$this->deleMoreChar($rs,'  echo',' echo');
    $rs=$this->deleMoreChar($rs,' echo  ',' echo ');
    $rs=$this->deleMoreChar($rs,'<?php','{');
    $rs=$this->deleMoreChar($rs,'?>','}');
    $rs=$this->deleMoreChar($rs,'echo ','{');// {
    $rs=$this->deleMoreChar($rs,' {','{');
    $rs=$this->deleMoreChar($rs,';}','}}');
    $r1=indexof($rs,'<td');
    $rs=substr($rs,$r1);
    $ds=$this->deleTd($rs);
    return $ds;

}
function deleMoreChar($rs,$ch1,$ch2){
   while (indexof($rs,$ch1)>=0 ) {
      $rs=str_replace($ch1,$ch2,$rs);
   }
 return $rs;
}

function deleTd($rs){
  $ds=explode('</td>',$rs);
  $rs=array();
  $rr=count($ds)-1;
  foreach ($ds as $k => $v) {//>
    $r1=indexof($v,'>');
    if(!($rr==$k)){
      $rs[$k]=substr($v,$r1+1);
    };
  }

 return $rs;
  }
function getPhpFile($pfname=''){
    $rs='';
    $ms=setGetValue("html_dir");
    $path=ROOT_PATH.'/admin/views/'.$ms;
    $fname=$path.'/'.setGetValue("html_file").'.php';
    if(filein($fname)){
      $rs = file_get_contents($fname); // 将文件内容存入变量 $content
    }
 
    return $rs;

  }
}
