  <?php $cs = Yii::app()->clientScript;?>
  <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
  <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>

<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); 
  $new=1;
  if (!isset( $_REQUEST['f_code'] ) ) {
       $_REQUEST['f_code']='';
   }
   $club_name="系统>权限管理>菜单名称调整".$_REQUEST['f_code'];
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
                 <label style="margin-right:20px;">
                 编码：<input style="width:30px;margin-left: 20px;" class="input-text" type="text" name="code" id="code" value="">
        名称:<input style="width:100px;margin-left: 20px;" class="input-text" type="text" name="name" id="name" value="">
       <button class="btn btn-blue" type="submit">添加</button>
            </label>
            </form>
        </div><!--box-search end-->
    <hr style="height:1px;border:none;border-top:1px solid #666;" />
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr>
                        <td width="5%"></td>
                        <td width="95%">菜单名称</td>
                    </tr>
                  
                                <?php 
$ws=array('order' => 'f_btype,f_bcode,f_code','condition'=>" f_mtype<4",);
                        $menu_list0=Menu::model()->findAll($ws);//上一级菜单
  $r=0;                 
foreach($menu_list0 as $v0){
    $sc=trim($v0['f_code']);
    $v0['f_imgshow']=str_replace('images/Backstage-icon/menu/','',$v0['f_imgshow']);
    $v0['f_imgdown']=str_replace('images/Backstage-icon/menu/','',$v0['f_imgdown']);
    $f_id0=$v0['f_id'].','.$v0['f_bcode'].','.$v0['f_bname'].','.$sc;
    $i=$r;
    $r=$r+1;
    if ($v0['f_mtype']==1){
    ?>
    <tr>
    <td colspan="2">
    <div class="subnav-hd" style="display: table;">
        <a href="javascript:;" style="display:table;margin: 10px 0;display:table-cell" class="subnav-hd-title"><i class="fa fa-angle-right"></i><?php echo $v0['f_name'];?></a>
      
        编码：<input style="width:30px;margin-left: 20px;" class="input-text" type="text" name="code<?php echo $i;?>" id="code<?php echo $i;?>" value="<?php  echo $v0['f_bcode'];?>">
        名称:<input style="width:100px;margin-left: 20px;" class="input-text" type="text" name="name<?php echo $i;?>" id="name<?php echo $i;?>" value="<?php  echo $v0['f_bname'];?>">
          
        下拉图：<input style="width:250px;margin-left: 20px;" class="input-text" type="text" name="cshow<?php echo $i;?>" id="cshow<?php echo $i;?>" value="<?php  echo $v0['f_imgshow'];?>">
        收起图:<input style="width:250px;margin-left: 20px;" class="input-text" type="text" name="cdown<?php echo $i;?>" id="cdown<?php echo $i;?>" value="<?php  echo $v0['f_imgdown'];?>">
        
        <input type="hidden" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php  echo $f_id0;?>">
    </div>
  </td></tr>
  <?php } else { ?>
    <tr><td></td>
 
    <td >
        <label style="margin-right:10px;">
            <span class="bd-span"><?php echo $v0['f_name'].':' ; ?></span>
           编码：<input style="width:120px;margin-left: 20px;" class="input-text" type="text" name="code<?php echo $i;?>" id="code<?php echo $i;?>" value="<?php  echo $v0['f_bcode'];?>">
        名称<input style="width:120px;margin-left: 20px;" class="input-text" type="text" name="name<?php echo $i;?>" id="name<?php echo $i;?>" value="<?php  echo $v0['f_bname'];?>">
        
        <input type="hidden" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php  echo $f_id0;?>">

                        </label>
                    </td>
            
                </tr>
            <?php } 
            }// for
             ?>
        </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
 <input type="hidden" name="num" id="num" value="<?php echo $r;?>">
            <button class="btn" type="baocun" >保存</button>
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

<script>
    function update(id,title){
        var action = '<?php echo $this->createUrl("create"); ?>';
        $.dialog.data('id', 0);
        $.dialog.open(action,{
            id:'tianjia',
            lock:true,
            opacity:0.3,
            title:title+' -详情',
            width:'50%',
            height:'70%',
            close: function () {
                // console.log('77');
            }
        });
    }
</script>
