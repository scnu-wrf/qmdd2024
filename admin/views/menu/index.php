  <?php $cs = Yii::app()->clientScript;?>
  <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
  <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>

<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); 
  $new=1;
  if (!isset( $_REQUEST['f_code'] ) ) {
       $_REQUEST['f_code']='';
   }
   $club_name="系统>权限管理>菜单名称设置".$_REQUEST['f_code'];
  ?>
<style>
    .bd-span{
        display: inline-block;
        padding: 3px 6px;
        text-align: right;
        width: 150px;
        vertical-align: top;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>【当前界面：<?php echo $club_name ;?>】</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
      <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                <span>主菜单：</span>
                <?php echo downList($main_menu,'f_code','f_name','f_code'); ?>
                </label>
        
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
    <hr style="height:1px;border:none;border-top:1px solid #666;" />
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr>
                        <td width="3%"></td>
                        <td width="97%">菜单名称</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <div class="subnav">
                                <?php 
                                    $ws=array('order' => 'f_code','condition'=>" f_type='". $_REQUEST['f_code']."'",);
                                    $menu_list0=Menu::model()->findAll($ws);//上一级菜单
                                    $menu_role1=array();
                                    foreach($menu_list0 as $v0){
                                        $sc=trim($v0['f_code']);
                                        $menu_role0[substr($sc,0,3)][substr($sc,0,5)][$sc]=$v0['f_id'];
                                    }

                                    $menu_list1=array();
                                    $r=0;
                                    $pl1=3;$pl2=5;$pl3=7;
                                    $ri=-1;  $ri1=0;

                                    foreach($menu_list0 as $v0){

                                        $sc=trim($v0['f_code']);
                                        $chk=0;
                                        $ln=strlen($sc);
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
                                        $menu_list1[$r]['f_name']=trim($v0['f_name']);
                                        $menu_list1[$r]['f_nameb']=trim($v0['f_nameb']);
                                        
                                        // .trim($v0['f_sname']);
                                        $menu_list1[$r]['f_mtype']=$v0['f_mtype'];
                                        $r=$r+1;
                                        }
                                    }
                                    $rr0=0;
                                    //  $parent_opter=Menua::model()->get_parent_opter($model->f_tcode);
                                    for ($i = 0; $i < $r; $i = $i + 1){
                                    //   $tmptype0=$menu_list1[$i]['f_mtype'];
                                        if ($menu_list1[$i]['f_mtype']==1){
                                            $p0=$menu_list1[$i]['f_code'];
                                            $p0name=$menu_list1[$i]['f_name'];
                                            $sc0="✔";
                                ?>
                                <div class="subnav-hd" style="display: table;">
                                    <a href="javascript:;" style="display:table;margin: 10px 0;display:table-cell" class="subnav-hd-title"><i class="fa fa-angle-right"></i><?php echo $p0name;?></a>
                                    <input style="width:120px;margin-left: 20px;" class="input-text" type="text" name="name<?php echo $i;?>" id="name<?php echo $i;?>" value="<?php  echo $menu_list1[$i]['f_name'];?>">
                                    <input type="hidden" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php  echo $menu_list1[$i]['f_id'];?>">
                                    <input type="hidden" name="na<?php echo $i;?>" id="na<?php echo $i;?>" value="<?php  echo $menu_list1[$i]['f_name'];?>">
                                </div>
                                <?php if($i==0) { ?> 
                                    <input type="hidden" name="num" id="num" value="<?php echo $r;?>">
                                <?php } ?>
                                <ul class="subnav-bd" style="display: block">
                                    <table  class="bnn" cellspacing="0" cellpadding="0" style="border-right-style:none;border-spacing:0px 0px;">
                                        <?php 
                                            for ($i1 = $i+1; $i1 < $r; $i1 = $i1 + 1){
                                                $p1=substr($menu_list1[$i1]['f_code'],0,3);
                                                $tmp_type=$menu_list1[$i1]['f_mtype'];
                                                if ($p0!==$p1) break;
                                                if($tmp_type==2){
                                        ?>
                                            <tr>
                                                <td width="35%">
                                                    <label style="margin-right:10px;">
                                                        <span class="bd-span"><?php echo $menu_list1[$i1]['f_name'].':' ; ?></span>
                                                        <input style="width:120px;" class="input-text" type="text" name="name<?php echo $i1;?>" id="name<?php echo $i1;?>" value="<?php  echo $menu_list1[$i1]['f_name'];?>">
                                                         <input style="width:60px;" class="input-text" type="text" name="code<?php echo $i1;?>" id="code<?php echo $i1;?>" value="<?php  echo $menu_list1[$i1]['f_code'];?>">
                                                        <input type="hidden" name="id<?php echo $i1;?>" id="id<?php echo $i1;?>" value="<?php  echo $menu_list1[$i1]['f_id'];?>">
                                                        <input type="hidden" name="na<?php echo $i1;?>" id="na<?php echo $i1;?>" value="<?php  echo $menu_list1[$i1]['f_name'];?>">
                                                         <input type="hidden" name="co<?php echo $i1;?>" id="co<?php echo $i1;?>" value="<?php  echo $menu_list1[$i1]['f_code'];?>">
                                                    </label>
                                                </td>
                                                <td width="60%">
                                                    <?php 
                                                        $tmplen=5;
                                                        $tmenu=array();
                                                        $p1=substr($menu_list1[$i1]['f_code'],0,$tmplen);
                                                        for ($i2 = $i1+1; $i2 < $r; $i2 = $i2 + 1){
                                                        $p2=substr($menu_list1[$i2]['f_code'],0,$tmplen);
                                                        if ($p1!==$p2) break;
                                                        $tmenu[$menu_list1[$i2]['f_id']]=$menu_list1[$i2]['f_name'];
                                                    ?>
                                                    <label style="margin-right:10px;">
                                                        <span><?php echo $menu_list1[$i2]['f_name'].':' ; ?></span>
                                                        <input style="width:55px;" class="input-text" type="text" name="name<?php echo $i2;?>" id="name<?php echo $i2;?>" value="<?php  echo $menu_list1[$i2]['f_name'];?>">
                                                        <input type="hidden" name="id<?php echo $i2;?>" id="id<?php echo $i2;?>" value="<?php  echo $menu_list1[$i2]['f_id'];?>">
                                                        <input type="hidden" name="na<?php echo $i2;?>" id="na<?php echo $i2;?>" value="<?php  echo $menu_list1[$i2]['f_name'];?>">
                                                    </label>
                                                <?php } ?>
                                                </td>
                                            </tr>
                                        <?php } } ?>
                                    </table>
                                </ul>
                            <?php } }; ?>        
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
                if($d_club_type2[j]['fater_id']==show_id|| $d_club_type2[j]['f_id']== $d_club_type_value2){
                    p_html = p_html +'<option value="'+$d_club_type2[j]['f_id']+'"'+s1+'>';
                    p_html = p_html +$d_club_type2[j]['F_NAME']+'</option>';
                }
            }
        }
        $("#Role_f_club_type").html(p_html);
    }
    function opterClick(objnum){ 
        var s1;
        for (i=0;i<1000;i++){
        s1=$('#Role_tmp_opter2_'+objnum+'_'+i+'_0').val();
        if(s1==undefined) break;
        for (j=0;j<500;j++) {
            s1=$('#Role_tmp_opter2_'+objnum+'_'+i+'_'+j).val();
            if(s1==undefined) break;
            $('#Role_tmp_opter2_'+objnum+'_'+i+'_'+j).prop('checked',$('#Role_tmp_opter_'+objnum+'_0').is(':checked'));
            }
        }
    }

</script>
