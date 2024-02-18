  <?php $cs = Yii::app()->clientScript;?>
  <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
  <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>
<?php
  if (!isset($_REQUEST['f_tcode'])) {$_REQUEST['f_tcode']='';}
  if (!isset($_REQUEST['club_id'])) {$_REQUEST['club_id']=-1;}
  $club_name='';
  if ($_REQUEST['club_type']==-1) {
 
    $club_name='系统>权限管理>'.get_session('club_name').'角色权限设置';
  } else
  {
    $club_name="系统>权限管理>平台角色权限设置";
  }
  $f_ln=strlen($_REQUEST['f_tcode']);
  $s1=($f_ln<1) ? "" : substr($_REQUEST['f_tcode'],0,$f_ln-1); 
  $nf=$f_ln+1;
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table">
    </i><?php echo $club_name;?></h1>
  </div><!--box- >end-->
 <div class="box-content">
<div class="box-header">
<?php  if ($_REQUEST['club_type']==0) { ?>
    <a class="btn" href="<?php 
    echo $this->createUrl('create', array('club_id'=>$_REQUEST['club_id'],'f_tcode'=>$_REQUEST['f_tcode'],'f_type'=>$nf,'club_type'=>$_REQUEST['club_type']));?>"><i class="fa fa-plus"></i>添加</a>

    <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
 <?php } ?>
     <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

        </div><!--box-header end-->
       
        </div><!--box-table end-->
      
    </div><!--box-content end-->
</div><!--box end-->
  <div class="subnav">
<?php 
  $ri=-1;  
  $ri1=0;$rr0=-1;
  $trees=array();
  $rline=array();
  $trees[0]="";
  $club_type=$_REQUEST['club_type'];
  $role_list=Role::model()->get_tree($_REQUEST['club_type']);
  foreach ($role_list as $v) {
        $rline[$ri1]=$v['f_rcode'];
        $ri1=$ri1+1;
    }
    $rline[$ri1]='//==END';//表示结束
    $ri1=0;
    $bk='&nbsp;&nbsp;&nbsp;&nbsp;';
    $bk2='&nbsp;&nbsp;';
    $pf='';
    $s_clubid=$_REQUEST['club_id'];

  foreach($role_list as $v0){
    $sc=$v0['f_rcode'];
    $sc0=$v0['f_tcode'];
    $sn0=$v0['f_rname'];
    $s_id=$v0['f_id'];
   
    $ln=strlen( $sc);
    $ri1=$ri1+1;
    $scn=$rline[$ri1];
    $scnln=strlen( $scn);
    $bk0="";
    $rr1=$rr0+1;
    for($i=0;$i<=$rr1;$i++) $bk0.=$bk;
    if (($ri1==1)||($ln==1)||(substr($scn,0,$ln)==$sc)){ //同级
       $rr0=$rr0+1;
      ?>
        <div class="subnav-hd"  style="display:table;margin: 10px 10px;">
           <a href="javascript:;" style="display: table-cell;width:200px;" class="subnav-hd-title"><i class="fa fa-angle-right"></i><?php echo $bk0.$sc.'_'.$sn0.$bk0;?></a>
           <a  style="display:table-cell;position: relative;right:10px;" class="btn" href="<?php echo $this->createUrl('create', array('f_id'=>$s_id,'club_id'=>$s_clubid,'f_tcode'=>$v0->f_rcode,'club_type'=>$club_type));?>" title="添加"  ><b class="fa fa-plus"></b></a>
      <?php if($_REQUEST['club_type']==0) {?>
     <a  style="display:table-cell;position: relative;right:5px;" class="btn" href="<?php echo $this->createUrl('update', array('f_id'=>$s_id,'club_id'=>$s_clubid,'f_tcode'=>$sc0,'club_type'=>$club_type));?>" title="编辑"  ><b  class="fa fa-edit"></b></a>
            <a class="btn" style="display:table-cell;" href="javascript:;" onclick="we.dele('<?php echo $s_id;?>', deleteUrl);" title="删除"><b class="fa fa-trash-o"></b></a>
          <?php } ?>
        </div>
        <ul class="subnav-bd" style="display: none">
    <?php 

     $trees[$rr0]=$sc;$pf=$sc;
     if (substr($scn,0,1)!==substr($sc,0,1)){
      $rr0=-1;  echo '</ul>';
      }
        
  } else
  {
   for($i=0;$i<=$rr1;$i++) $bk0.=$bk;
    $px=strlen($bk0+$sc.'_'.$sn0);
      $px=250+(($px<15) ? 15 : $px)*1.5;
     echo '<li style="display:table;margin: 10px 10px;"><a style="display:table-cell;width:260px;">'.$bk0.$sc.'_'.$sn0.'.</a>';?>
    <a  style="display:table-cell;position: relative;right:30px;" class="btn" href="<?php echo $this->createUrl('create', array('f_id'=>$s_id,'club_id'=>$s_clubid,'f_tcode'=>$v0->f_rcode,'club_type'=>$club_type));?>" title="添加"  ><b class="fa fa-plus"></b></a>
          <a  style="display:table-cell;position: relative;right:15px;" class="btn" href="<?php echo $this->createUrl('update', array('f_id'=>$s_id,'club_id'=>$s_clubid,'f_tcode'=>$sc0,'club_type'=>$club_type));?>" title="编辑"  ><b class="fa fa-edit"></b></a>

            <a class="btn" sstyle="display:table-cell;" href="javascript:;" onclick="we.dele('<?php echo $s_id;?>', deleteUrl);" title="删除" ><b class="fa fa-trash-o"></b></a></li>
         <?php 
      if  (($scnln!=$ln)|| substr($sc,0,$scnln-2)!=substr($scn,0,$scnln-2)) {
               while($rr0>=0){
                     $sc0=$trees[$rr0];
                     $r0=strlen($sc0);$pf=$trees[$rr0];
                    if (substr($sc0,0,$r0)==substr($scn,0,$r0) ) break;
                     echo '</ul>';$r0=$r0-2;
                    $rr0=$rr0-1;
                   //  if (substr($sc,0,$r0)!==substr($scn,0,$r0)) break; 
               }
         }
   }
  }
?>
</div><!--subnav end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>

