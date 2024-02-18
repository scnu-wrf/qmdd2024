<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>直播详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li>直播详情</li>
                <li>直播人员</li>
                <li>直播简介</li>
                <li>切播内容</li>
                <li class="current">备案信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:none;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>直播信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td width="35%"><?php echo $model->code;?></td>
                        <td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td><?php echo $model->title;?></td>
						<td><?php echo $form->labelEx($model, 'live_type'); ?></td>
                        <td><?php if(!empty($model->livetype)) echo $model->livetype->sn_name; ?></td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'is_single'); ?></td>
                        <td><?php echo $form->radioButtonList($model, 'is_single', Chtml::listData(array(array('id'=>'0','name'=>'连续多场'),array('id'=>'1','name'=>'单场')), 'id', 'name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','disabled'=>true)); ?>
						<?php echo $form->error($model, 'is_single', $htmlOptions = array()); ?></td>
						<td>直播日期 <span class="required">*</span></td>
                        <td>
                            <?php echo $model->live_start_check."~".$model->live_end_check;?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'once_time'); ?></td>
                        <td>
                            <?php echo $model->once_time; ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'airtime_check'); ?></td>
                        <td>
                            <?php echo $model->airtime_check; ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'total_time'); ?></td>
                        <td>
                            <?php echo $model->total_time; ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'club_contacts'); ?></td>
                        <td>
                            <?php echo $model->club_contacts; ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'address'); ?></td>
                        <td>
                            <?php echo $model->address; ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'club_contacts_phone'); ?></td>
                        <td>
                            <?php echo $model->club_contacts_phone; ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'live_address'); ?></td>
                        <td>
                            <?php echo $model->live_address; ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'club_contacts_email'); ?></td>
                        <td>
                            <?php echo $model->club_contacts_email; ?>
                        </td>
                    </tr>
					<tr>
						<td><?php echo $form->labelEx($model, 'logo'); ?></td>
                        <td colspan=3>
                            <?php $basepath=BasePath::model()->getPath(141);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->logo!=''){?><div class="upload_img fl" id="upload_pic_VideoLive_logo"><a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100"></a></div><?php }?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'programs_list'); ?></td>
                        <td colspan="3" style="padding:0;">
                            <table id="program_list" class="showinfo" data-num="new" style="margin:0;">
                                <tr class="table-title">
                                    <td width="15%">节目单号</td>
                                    <td width="20%">节目单名称</td>
                                    <td width="15%">开始时间</td>
                                    <td width="15%">结束时间</td>
                                    <td>直播时长</td>
                                </tr>
                                <?php if(!empty($programs)) foreach($programs as $v){?>
                                <tr>
                                    <td><?php echo $v->program_code;?></td>
                                    <td><?php echo $v->title;?></td>
                                    <td><?php echo $v->program_time;?></td>
                                    <td><?php echo $v->program_end_time;?></td>
                                    <td><?php echo $v->duration;?>分钟</td>
                                </tr>
                                <?php }?>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="table-title">
                    <tr>
                        <td>直播设置</td>
                    </tr>
                </table>
                <table>
					<tr>
                        <td width="15%">显示时间 <span class="required">*</span></td>
                        <td width="35%">
                            <?php echo $model->live_start;?>~<?php echo $model->live_end;?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'live_mode'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'live_mode', Chtml::listData(BaseCode::model()->getCode(1358), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'live_mode', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'project_is'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'project_is', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectProjectIs(this)','disabled'=>'true')); ?>
                            <?php echo $form->error($model, 'project_is', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'if_no_chinese'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'if_no_chinese', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <span class="msg">注：在国外举办的活动或参与者有外国国籍</span>
                            <?php echo $form->error($model, 'if_no_chinese', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="ProjectIs" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                        <td colspan="3">
                            <span id="project_box"><?php foreach($project_list as $v){?><span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->project_name;?></span><?php }?></span>
                            <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'open_club_member'); ?></td>
                        <td><?php if(!empty($model->clubmember)) echo $model->clubmember->F_NAME; ?></td>
                        <td><?php echo $form->labelEx($model, 'live_show'); ?></td>
                        <td>
                            <?php echo $form->checkBoxList($model, 'live_show', Chtml::listData(BaseCode::model()->getCode(1367), 'f_id', 'F_NAME'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                             <?php echo $form->error($model, 'live_show'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'gf_price'); ?>（元）</td>
                        <td><?php echo $model->gf_price;?></td>
                        <td><?php echo $form->labelEx($model, 'member_price'); ?>（元）</td>
                        <td><?php echo $model->member_price;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'viewers'); ?>（人）</td>
                        <td><?php echo $model->viewers;?></td>
                        <td><?php echo $form->labelEx($model, 't_duration'); ?>（分钟）</td>
                        <td><?php echo $model->t_duration;?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
             <div style="display:none;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>直播人员</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'leader'); ?></td>
                        <td width="35%"><?php echo $model->leader;?></td>
                        <td width="15%"><?php echo $form->labelEx($model, 'leader_phone'); ?></td>
                        <td width="35%"><?php echo $model->leader_phone;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'guest'); ?></td>
                        <td colspan="3"><?php echo $model->guest;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_content'); ?></td>
                        <td><?php echo $model->live_content;?></td>
                        <td><?php echo $form->labelEx($model, 'barrage'); ?></td>
                        <td><?php echo $model->barrage;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'director'); ?></td>
                        <td colspan="3"><?php echo $model->director;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'camera'); ?></td>
                        <td colspan="3"><?php echo $model->camera;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'monitor'); ?></td>
                        <td colspan="3"><?php echo $model->monitor;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'toning'); ?></td>
                        <td colspan="3"><?php echo $model->toning;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'media'); ?></td>
                        <td colspan="3"><?php echo $model->media;?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td><?php echo $form->labelEx($model, 'intro_temp'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'intro_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_intro_temp', '<?php echo get_class($model);?>[intro_temp]');</script>
                            <?php echo $form->error($model, 'intro_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>切播内容</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'cut_title'); ?></td>
                        <td colspan="3"><?php echo $model->cut_title; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'cut_type'); ?></td>
                        <td colspan="3"><?php if(!empty($model->cuttype)) echo $model->cuttype->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'cut_material_id'); ?></td>
                        <td colspan="3">
                         <?php if(!empty($model->gfmaterial)){ ?>
                        <?php if($model->cut_type==252){ ?>
                                <a href="<?php echo $model->gfmaterial->v_file_path.$model->gfmaterial->v_pic; ?>" target="_blank"><img src="<?php echo $model->gfmaterial->v_file_path.$model->gfmaterial->v_pic; ?>" width="100"></a>
                        <?php } elseif ($model->cut_type==253) { ?>
                                <a href="<?php echo $model->gfmaterial->v_file_path.$model->gfmaterial->v_name; ?>" target="_blank"><?php echo $model->gfmaterial->v_name; ?></a>
                        <?php }} ?>
                            </div>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div style="display:block;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>备案信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'checkin_code'); ?><span class="required">*</span></td>
                        <td><?php echo $form->textField($model, 'checkin_code', array('class' => 'input-text','style'=>'width:36%;')); ?>
                            <?php echo $form->error($model, 'checkin_code', $htmlOptions = array()); ?>
                                
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'checkin_img'); ?><span class="required">*</span></td>
                        <td><?php echo $form->hiddenField($model, 'checkin_img'); ?>
                            <?php $basepath=BasePath::model()->getPath(273);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->checkin_img!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_checkin_img"><a href="<?php echo $basepath->F_WWWPATH.$model->checkin_img;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->checkin_img;?>" width="100"></a></div><?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_checkin_img','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'checkin_img', $htmlOptions = array()); ?>
                            
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
			<table class="mt15" id="t7" style="table-layout:auto;">
				<tr>
					<td width='10%'><?php echo $form->labelEx($model, 'live_state_reasons_failure'); ?></td>
					<td width='90%' colspan="3">
						<?php 
							echo $model->live_state_reasons_failure; 
						?>
					</td>
				</tr>
				<tr>
					<td width='10%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
					<td width='90%' colspan="3">
						<?php 
						if($model->state==1362){
							echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text')); 
						}else{
							echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text','readonly'=>'readonly')); 
						}
						?>
						<?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
					</td>
				</tr>
                <tr>
                    <td width='10%'>备案操作</td>
                    <td width='90%' colspan="3">
                        <?php echo show_shenhe_box(array('tongguo'=>'备案通过','butongguo'=>'备案未通过'));?>
						<button onclick="submitType='zhongzhi'" class="btn" type="submit">申请终止</button>
						<button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
var club_id=<?php echo $model->club_id;?>;
$(function(){
setTimeout(function(){ UE.getEditor('editor_VideoLive_intro_temp').setDisabled('fullscreen'); }, 500);
});
selectProjectIs($('#VideoLive_project_is'));
function selectProjectIs(obj){
    var show_type=$(obj).val();
    if(show_type==649){ 
        $('#ProjectIs').show();
    } else{
        $('#ProjectIs').hide();
    }
}
$('#tongguo').on('click',function(){
	var checkin_code=$('#VideoLive_checkin_code').val();
	var checkin_img=$("#VideoLive_checkin_img").val();
	if(checkin_code==''){
		we.msg('minus','备案编号不能为空');
		return false;
	}
	if(checkin_img==''){
		we.msg('minus','备案扫描件不能为空');
		return false;
	}
});

</script>