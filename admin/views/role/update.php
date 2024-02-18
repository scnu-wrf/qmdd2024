  <?php $cs = Yii::app()->clientScript;?>
  <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
  <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>

<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); 
  $new=1;
  if (!isset($_REQUEST['p_id'])) {$_REQUEST['p_id']=0;}
  if (isset( $_REQUEST['f_type'] ) ) {
       $new=0;
   }
 //  $model->club_id=$_REQUEST['club_id'] ;
   $model->p_id=$_REQUEST['p_id'];
   $tc=$model->p_id;
   if ($_REQUEST['club_type']==-1) {
    $_REQUEST['club_id']=get_session('club_id');
    $club_name='系统>权限管理>'.get_session('club_name').'角色权限设置';

  } else
  {
    $_REQUEST['club_id']=0;
    $club_name="系统>权限管理>平台角色权限设置";
  }
   if (get_SESSION('use_club_id')=='0'){
    } else {
      $mod1=Role::model()->find('club_id='.$model->club_id.' and f_type=1');
      if(!empty($mod1)){
          $model->f_club_item_type=$mod1->f_club_item_type; 
          $model->f_club_item_type_name=$mod1->f_club_item_type_name;
          $model->f_club_type=$mod1->f_club_type;
          $model->f_club_type_name=$mod1->f_club_type_name;
         }
      $model->club_id=get_session('club_id');
   
    }
    $model->f_tcode=$_REQUEST['f_tcode'];
    // $model->f_opter='7,12,17,28,33,38';
 ?>
 <div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>【当前界面：<?php echo $club_name;?>>详情】</h1><span class="back">
    <a class="btn" href="javascript:;" onclick="we.back();">
    <i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
  <hr style="height:1px;border:none;border-top:1px solid #666;" />
    <div class="box-detail">
 <div class="box">
    <div class="box-title c"><h1>【角色设置】</h1>
  </div><!--box- >end-->
  <div class="box-detail-bd">
      <div style="display:block;" class="box-detail-tab-item">
          <table class="mt15"  >
        <tr>
            <td width="15%"><?php echo $form->labelEx($model, 'f_rcode').'前部分编码('.$_REQUEST['f_tcode']; ?>)</td>
            <td width="35%"><?php echo $form->textField($model, 'f_rcode', array('class' => 'input-text','onchange'=>'check_code(this,'."'".$_REQUEST['f_tcode']."');")); ?>
                <?php echo $form->error($model, 'f_rcode', $htmlOptions = array()); ?></td>
            <td width="15%"><?php echo $form->labelEx($model, 'f_rname'); ?></td>
            <td width="35%">
                <?php echo $form->textField($model, 'f_rname', array('class' => 'input-text')); ?>
                <?php echo $form->error($model, 'f_rname', $htmlOptions = array()); ?>
            </td>
       </tr>

           <?php if(empty($model->f_tcode)) { ?>
         <tr>
            <td><?php echo $form->labelEx($model, 'f_temporary'); ?></td>
            <td colspan="3">
            <?php echo $form->radioButtonList($model, 'f_temporary', Chtml::listData(BaseCode::model()->temporary(), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
            </td>
      
        </tr>
           <?php  } ?>
    </table>
      <?php echo $form->hiddenField($model, 'f_tcode', array('class' => 'input-text')); ?>        
      <?php echo $form->hiddenField($model, 'f_type', array('class' => 'input-text')); ?>
      <?php echo $form->hiddenField($model, 'p_id', array('class' => 'input-text')); ?>
      <?php echo $form->hiddenField($model, 'if_delete', array('class' => 'input-text')); ?>
  
       <input type="hidden" name="Role[club_id]" id="Role_club_id" value="<?php echo get_session('club_id');?>">
     
    
      
   <table class="mt15">
    <tr>
        <td width="3%"></td>
        <td width="97%">功能授权</td>
        </tr>
            
  <tr><td></td>
  <td>
  <div class="subnav">
<?php 
//$encode_str='AAABaqDDGpkBAAAAAAABhqM%3D.9DmGs33OWLNg9NLBT%2FR3wRja7irgvdoTgT0ocCkKhpKSqR44fMgO02LKuwUdV0eC.hSsThnOF%2F5iI7cQEaSn45tjXfJ8kfcgZhkSlLdwbbOM%3D';
//$s1="AAABaeLsaZsCAAAAAAABhyQ%3D";
//$encode_str=$s1;
//echo unicode_decode($name);
//$encode_str=urldecode($encode_str);
//echo $encode_str;
//token.Replace("=", "%3D").Replace("/", "%2F").Replace("+", "%2B");
//$encode_str=str_replace("%3D","=",$encode_str);
//$encode_str=str_replace("%2F","/",$encode_str);
//$encode_str=str_replace("%2B","+",$encode_str);

//echo  $encode_str;
//echo  '==kkk'.base64_decode($encode_str,"UTF-8").'==kkk';
//$encode_str=base64_decode($encode_str,"UTF-8");
//echo tgetBytes($encode_str);
//$dbs=getBytes($encode_str);
 
//$dm= Chtml::listData(Menua::model()->findAll('f_mtype=1'), 'f_id', 'f_name');

  $rcode=$model->f_tcode;
  if(empty($rcode)) $rcode="";
  $ws="f_type=2";
  if(strlen(trim($_REQUEST['f_tcode']))>0){
    $ws="f_rcode='".substr($rcode,0,strlen($rcode))."'";
  }
  $tmp0=Role::model()->find($ws);
  $ws="f_mtype<=2 or f_mtype>2";
  if(!empty($tmp0)){
       if (!empty($tmp0->f_opter)){
        $ws=" f_mtype<=2 or f_mtype>2 and f_id in (".$tmp0->f_opter.')'; 
       } 
  } 
  $ws=array('order' => 'f_code','condition'=> $ws." and f_name<>' '",);
  $menu_list0=Menu::model()->findAll($ws);//上一级菜单
  $menu_role0=array();
  $s11=','.trim($model->if_delete).',';
  foreach($menu_list0 as $v0){
     if ($v0['f_mtype']>2){
       $sc=trim($v0['f_code']);
       $menu_role0[substr($sc,0,3)][substr($sc,0,5)][$sc]=$v0['f_id'];
       if(strpos($s11,','.$v0['f_id'].',') !== false){
        $menu_role1[substr($sc,0,3)]=1;
       }
     }
  }

  //$menu_list0=Menu::model()->findAll(array( 'order'=> 'f_code'));//全部菜单
  $menu_list1=array();
  $r=0;
  $pl1=3;$pl2=5;$pl3=7;
  $ri=-1;  $ri1=0;
  $oname='aa';
  foreach($menu_list0 as $v0){
     $sc=trim($v0['f_code']);
     $chk=0;$ln=strlen($sc);
     if($ln==3) {
      if(isset($menu_role0[substr($sc,0,3)])) $chk=1;
     }
    if($ln==5) {
      if(isset($menu_role0[substr($sc,0,3)][substr($sc,0,5)])) $chk=1;
     }
    if($ln==9) {
      if(isset($menu_role0[substr($sc,0,3)][substr($sc,0,5)][$sc])) $chk=1;
     }
     if($chk==1){
       $menu_list1[$r]['f_id']=$v0['f_id'];
       $menu_list1[$r]['f_code']=$sc;
       $menu_list1[$r]['f_name']=trim($v0['f_name']).trim($v0['f_sname']);
       $menu_list1[$r]['f_mtype']=$v0['f_mtype'];
       $s1='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       $s2=mb_strlen($v0['f_typename']);
       $s3='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       if($s2==3)  $s3='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       if($s2==4)  $s3='&nbsp;&nbsp;&nbsp;&nbsp;';
       if($s2==5)  $s3='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
       $menu_list1[$r]['f_typename']=(($oname==$v0['f_typename']) ? $s3 : $v0['f_typename']).$s1;
       $oname=$v0['f_typename'];
       $r=$r+1;
     }
 }
 $rr0=0;
//  $parent_opter=Menua::model()->get_parent_opter($model->f_tcode);
  for ($i = 0; $i < $r; $i = $i + 1)
  {
  //   $tmptype0=$menu_list1[$i]['f_mtype'];
     if ($menu_list1[$i]['f_mtype']==1){
        $p0=$menu_list1[$i]['f_code'];
        $p0name= $menu_list1[$i]['f_typename'].''.$menu_list1[$i]['f_name'];
        $rr0=$rr0+0;
        $r20=0;
    if (isset($menu_role0[substr($p0,0,3)]) ){ //有下级菜单
          $sc=$model->f_opter;
          $sc0='';
          if(isset($menu_role1[substr($p0,0,3)])){ $sc0="✔"; }
    ?>

    <div class="subnav-hd">
       <a href="javascript:;" style="display:table;margin: 10px 0;display:table-cell" class="subnav-hd-title"><?php if(empty( $menu_list1[$i]['f_typename'])) echo $s1;?><i class="fa fa-angle-right"></i><?php echo $p0name;?></a>
        <a  style="display:table-cell;padding: 0px 10px 0px 20px;"  href="javascript:void(0)" title="添加" style="width:70px" >
        <?php 
             $ri=$ri+1; 
             $ri1=-1;
             $model->tmp_opter[$ri]=$sc;//$model->f_opter;
             $show=array($menu_list1[$i]['f_id']=>$sc0);
             echo  $form->checkBoxList($model, 'tmp_opter['.$ri.']',$show, $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>', 'onclick' => 'opterClick('.$ri.')')); 
           ?>  
        </a>
    </div>
   
        <ul class="subnav-bd" style="display: none">
          <table  class="bnn" cellspacing="0" cellpadding="0" style="border-right-style:none;border-spacing:0px 0px;">
         <?php 

          for ($i1 = $i+1; $i1 < $r; $i1 = $i1 + 1)
          { 
             $p1=substr($menu_list1[$i1]['f_code'],0,$pl1);
             if ($p0!==$p1) break;
              $tmp_type=$menu_list1[$i1]['f_mtype'];
             if ($tmp_type==2){
                $tmplen=($tmp_type==2) ? 5  : 7;
              //  $tmptype=($tmp_type==2) ? 4  : 5;
                $tmenu=array();
                $p1=substr($menu_list1[$i1]['f_code'],0,$tmplen);
                for ($i2 = $i1+1; $i2 < $r; $i2 = $i2 + 1){         
                  $p2=substr($menu_list1[$i2]['f_code'],0,$tmplen);
                  if ($p1==$p2){ //break;
                 // if (!($tmptype==$menu_list1[$i2]['f_mtype'])) break;
                    $tmenu[$menu_list1[$i2]['f_id']]=$menu_list1[$i2]['f_name'];
                   }
                }
              ?>
              <tr><td width="2%"></td>
              <?php 
              echo ($tmp_type==2) 
                ?'<td colspan="2">'.$menu_list1[$i1]['f_name'].'</td>'
                :'<td width="8%"></td><td width="20%">'.$menu_list1[$i1]['f_name'].'</td>';
               ?>
              <td width="70%" >
                <li>
                    <?php 
                       $ri1=$ri1+1; 
                       $model->tmp_opter2[$ri][$ri1]=$model->f_opter;
                        echo  $form->checkBoxList($model, 'tmp_opter2['.$ri.']['.$ri1.']',$tmenu, $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>', 'onclick' => 'opterClickb()'));
                     ?>
                </li>
              </td></tr>
             <?php 
             }
          } ?>
          </table>
        </ul>
  <?php } 
   }
  }
  ?>
          
  </td>
  </tr>
        </table>
        </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
     
        <div class="box-detail-submit">
          <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
          <button class="btn" type="button" onclick="we.back();">取消</button>
         </div>
<?php $this->endWidget();?>
</div><!--box-detail end-->
</div><!--box end-->
<script>	
selectOnchang('#Role_f_club_item_type');
function selectOnchang(obj){ 
  var show_id=$(obj).val();
  var  p_html ='<option value="">请选择</option>';
  if (show_id>=0) {
     for (j=0;j<$d_club_type2.length;j++) {
       var s1="";
       if( $d_club_type2[j]['f_id']== $d_club_type_value2) s1="selected";
        if($d_club_type2[j]['fater_id']==show_id|| $d_club_type2[j]['f_id']== $d_club_type_value2)
       {
        p_html = p_html +'<option value="'+$d_club_type2[j]['f_id']+'"'+s1+'>';
        p_html = p_html +$d_club_type2[j]['F_NAME']+'</option>';
      }
     }
    }
   $("#Role_f_club_type").html(p_html);
}
function opterClick(objnum){ 
  var s1,s2;s2="0";
  for (i=0;i<1000;i++){
   s1=$('#Role_tmp_opter2_'+objnum+'_'+i+'_0').val();
  if(s1==undefined) break;
  for (j=0;j<500;j++) {
       s1=$('#Role_tmp_opter2_'+objnum+'_'+i+'_'+j).val();
       if(s1==undefined) break;
       $('#Role_tmp_opter2_'+objnum+'_'+i+'_'+j).prop('checked',$('#Role_tmp_opter_'+objnum+'_0').is(':checked'));
      }
   }
   opterClickb();
}
//console.log('280');
function opterClickb(){ 
  var s1,s2,s3;
  s2="";s3="";
 for (objnum=0;objnum<1000;objnum++){

  for (i=0;i<1000;i++){
      s1=$('#Role_tmp_opter2_'+objnum+'_'+i+'_0').val();
     if(s1==undefined){ break;  }
     for (j=0;j<500;j++) {
        s1=$('#Role_tmp_opter2_'+objnum+'_'+i+'_'+j).val();
       if(s1==undefined){ break;}
        if($('#Role_tmp_opter2_'+objnum+'_'+i+'_'+j).is(':checked'))
        {
         s2=s2+s3+s1;
         s3=",";  
        }
     }
   }
 }
 $('#Role_if_delete').val(s2);
}

function check_code(op,pcode){
  var ops=$(op).val();
  var codelen1=pcode.length;
   if(codelen1==0) { codelen1=1;}
    else { codelen1=codelen1+2;}
  if(ops.length!=codelen1){
    alert('编码长度不正确，应该是：'+codelen1);
  }
  else{
    if(ops.substring(0,pcode.length)!=pcode){
       alert('编码前部分不正确，应该是：'+pcode+'='+ops.substring(0,codelen1)+'=l='+codelen1);
     }
  }

}
//console.log('332');

</script>
