<?php
$level = array(281=>'☆',282=>'☆☆',283=>'☆☆☆',284=>'☆☆☆☆',285=>'☆☆☆☆☆');
$txt='';
if(!isset($_REQUEST['list'])){
        $_REQUEST['list']='index';
}
$flag=$_REQUEST['list'];
if($flag=='search'){
    $txt='动动约查询》场馆查询》';
} elseif ($flag=='pass') {
    $txt='资源审核》场馆审核》';
} elseif ($flag=='check') {
    $txt='资源审核》场馆审核》待审核》';
} elseif ($flag=='index') {
    $txt='资源登记》场馆登记》';
} elseif ($flag=='list') {
    $txt='资源登记》场馆登记》';
} elseif ($flag=='fail') {
    $txt='资源审核》审核未通过列表》';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》<?php echo $txt; ?><a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            <table class="table-title">
                <tr>
                    <td>场馆信息</td>
                </tr>
            </table>
            <table>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'site_code'); ?></td>
                    <td width="35%"><?php echo $model->site_code;?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'user_club_id'); ?></td>
                    <td width="35%">
                        <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_name'); ?></td>
                    <td><?php echo $model->site_name;?>
                        <?php echo $form->error($model, 'site_name', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_envir'); ?></td>
                    <td>
                    <?php echo $form->checkBoxList($model, 'site_envir', Chtml::listData(BaseCode::model()->getCode(667), 'f_id', 'F_NAME'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'site_envir', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'area_province'); ?></td>
                    <td>
                        <?php echo $model->area_province; ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_address'); ?></td>
                    <td>
                        <?php echo $model->site_address; ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php echo $model->contact_phone;?>
                        <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_location'); ?></td>
                    <td><?php echo $model->site_location;?>
                        <?php echo $form->error($model, 'site_location', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
                        <span id="project_box">
                            <?php if(!empty($project_list)){ foreach($project_list as $v){?>
                                <span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>"><?php echo $v->project_list->project_name;?></span>
                            <?php }}?>
                        </span>
                        <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                    </td>
                </tr>
<?php $basepath=BasePath::model()->getPath(170);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_origin'); ?></td>
                    <td>
                        <?php echo $form->dropDownList($model, 'site_origin', Chtml::listData(BaseCode::model()->getCode(1526), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>'true')); ?>
                        <?php echo $form->error($model, 'site_origin', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_prove'); ?></td>
                    <td>
                        <div class="upload_img fl" id="upload_pic_site_prove">
                            <?php
                            foreach($site_prove as $v) if($v) {?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"></a>
                            <?php }?>
                        </div>
                        <?php echo $form->error($model, 'site_prove', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'site_pic'); ?></td>
                    <td>
                        <?php if($model->site_pic!=''){?>
                      <div class="upload_img fl" id="upload_pic_GfSite_site_pic">
                         <a href="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" target="_blank">
                         <img src="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" width="100"></a></div>
                         <?php }?>
                        <?php echo $form->error($model, 'site_pic', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_scroll'); ?></td>
                    <td>
                        <div class="upload_img fl" id="upload_pic_site_scroll">
                            <?php
                            foreach($site_scroll as $v) if($v) {?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"></a>
                            <?php }?>
                        </div>
                        <?php echo $form->error($model, 'site_scroll', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table style="margin-top: -1px;" class="table-title">
                <tr>
                    <td>场馆配套及等级评定（<?php if(!empty($model->site_level)) echo $level[$model->site_level]; ?><?php echo $model->site_level_name; ?>）</td>
                </tr>
            </table>
            <table style="margin-top: -1px;">
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'site_facilities'); ?></td>
                    <td>
                    <?php echo $form->checkBoxList($model, 'site_facilities', Chtml::listData($site_facilities, 'id', 'item_name'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'facilities_pic'); ?></td>
                    <td>
                        <div class="upload_img fl" id="upload_pic_facilities_pic">
                            <?php
                            foreach($facilities_pic as $v) if($v) {?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"></a>
                            <?php }?>
                        </div>
                        <?php echo $form->error($model, 'facilities_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table style="margin-top: -1px;" class="table-title">
                <tr>
                    <td>场馆介绍</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td><?php echo $model->site_description_temp;?></td>
                </tr>
            </table>
            </div>
<?php $qsite=QmddGfSite::model()->findAll('site_id='.$model->id.' '); ?>
        <div style="margin-top: -1px;">
            <table>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'site_state'); ?></td>
                    <td><?php echo $model->site_state_name; ?></td>
                </tr>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td>
                        <?php echo ($model->site_state==371) ? $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')) : $model->reasons_failure; ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
<?php if($flag!='pass'){ ?>
                <tr>
                    <td>操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('tongguo'=>'审核通过','tuihui'=>'退回修改','butongguo'=>'审核未通过'));?>
<?php if($flag=='index' && $model->site_state==371){ ?>
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">撤销</button>
<?php } ?>
<?php if(($flag=='list' || $flag=='fail' || ($model->site_state==373 && $flag=='index')) && empty($qsite)){ ?>
                        <a class="btn" href="<?php echo $this->createUrl('fnDelete', array('id'=>$model->id));?>">删除</a>
<?php } ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
<?php } ?>
            </table>
        </div>
        </div><!--box-detail-bd end-->


    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
$(function(){
setTimeout(function(){ UE.getEditor('editor_GfSite_intro_temp').setDisabled('fullscreen'); }, 500);
});
</script>