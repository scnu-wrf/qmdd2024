  <?php $cs = Yii::app()->clientScript;?>
  <?php $cs->registerCssFile(Yii::app()->request->baseUrl.'/static/admin/css/index.css');?>
  <?php $cs->registerScriptFile(Yii::app()->request->baseUrl.'/static/admin/js/index.js', CClientScript::POS_END);?>

<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); 

    $club_name="系统>主菜单名称设置";
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
        <h1><i class="fa fa-table"></i>【当前界面：主菜单名称设置】</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
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
                                    $ws=array('order' => 'f_code','condition'=>"1=1",);
                                    $menu_list0=MenuMain::model()->findAll($ws);//上一级菜单
                                    $r=0;

                                    foreach($menu_list0 as $v0){

                                        $menu_list1[$r]['f_id']=$v0['f_id'];
                                        $menu_list1[$r]['f_code']=$v0['f_code'];
                                        $menu_list1[$r]['f_name']=trim($v0['f_name']);
                                         $menu_list1[$r]['f_image']=trim($v0['f_image']);
                                        $r=$r+1;
                                       
                                    }
                                    $rr0=0;
                                
                                    for ($i = 0; $i < $r; $i = $i + 1){
                                            $p0=$menu_list1[$i]['f_code'];
                                            $p0name=$p0.'-'.$menu_list1[$i]['f_name'];
                                ?>
                                <div class="subnav-hd" style="display: table;">
                                    <a href="javascript:;" style="display:table;margin: 10px 0;display:table-cell" class="subnav-hd-title"><i class="fa fa-angle-right"></i><?php echo $p0name;?></a>
                                    <input style="width:120px;margin-left: 20px;" class="input-text" type="text" name="name<?php echo $i;?>" id="name<?php echo $i;?>" value="<?php  echo $menu_list1[$i]['f_name'];?>">
                                图标： <input style="width:120px;margin-left: 20px;" class="input-text" type="text" name="f_image<?php echo $i;?>" id="f_image<?php echo $i;?>" value="<?php  echo $menu_list1[$i]['f_image'];?>">
                                    <input type="hidden" name="id<?php echo $i;?>" id="id<?php echo $i;?>" value="<?php  echo $menu_list1[$i]['f_id'];?>">
                                    <input type="hidden" name="na<?php echo $i;?>" id="na<?php echo $i;?>" value="<?php  echo $menu_list1[$i]['f_name'];?>">
                                </div>
                                <?php if($i==0) { ?> 
                                    <input type="hidden" name="num" id="num" value="<?php echo $r;?>">
                                <?php } ?>
                                
                            <?php  }; ?>        
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="box-detail-submit">
            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit"> 保存</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
