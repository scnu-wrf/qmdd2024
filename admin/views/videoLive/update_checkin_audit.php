<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>直播详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li>频道详细</li>
                <li>直播岗位</li>
                <li>直播简介</li>
                <li class="current">备案信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:none;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>频道信息</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td width="35%"><?php echo $model->code;?></td>
                        <td width="15%"><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td width="35%"><?php echo $model->title;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'logo'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(141);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->logo!=''){?><div class="upload_img fl" id="upload_pic_VideoLive_logo"><a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100"></a></div><?php }?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'live_type'); ?></td>
                        <td><?php if(!empty($model->livetype)) echo $model->livetype->sn_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_belong'); ?></td>
                        <td><?php if(!empty($model->livebelong)) echo $model->livebelong->F_NAME; ?></td>
                        <td><?php echo $form->labelEx($model, 'belong_id'); ?></td>
                        <td>
                            <span id="belong_box"><span class="label-box" id="belong_item_<?php echo $model->belong_id;?>" data-id="<?php echo $model->belong_id;?>"><?php echo $model->belong_name;?></span></span>
                            <?php echo $form->error($model, 'belong_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'isHot'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'isHot', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'isHot', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                        <td>
                            <span id="project_box"><?php foreach($project_list as $v){?><span class="label-box" id="project_item_<?php echo $v->project_id;?>" data-id="<?php echo $v->project_id;?>"><?php echo $v->project_list->project_name;?></span><?php }?></span>
                            <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <?php if(get_session('club_id')==2450) {?>
                    <tr>
                        <td><?php echo $form->labelEx($model,'recommend_type'); ?></td>
                        <td colspan="3">
                            <?php echo $form->dropDownList($model, 'recommend_type', Chtml::listData(BaseCode::model()->getCode(1009), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectRecommendType(this)','disabled'=>'true')); ?>
                        </td>
                    </tr>
                    <?php }?>
                    <tr id="dis_club_list" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'club_list'); ?></td>
                        <td colspan="3">
                            <span id="club_list_box"><?php if(!empty($club_list)) foreach($club_list as $v){?><span class="label-box" id="club_item_<?php echo $v->recommend_club_id;?>" data-id="<?php echo $v->recommend_club_id;?>"><?php if(!empty($v->club_list)){ echo $v->club_list->club_name;} else { echo '无效单位';} ?></span><?php }?></span>
                            <?php echo $form->error($model, 'club_list', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_start'); ?></td>
                        <td><?php echo $model->live_start; ?></td>
                        <td><?php echo $form->labelEx($model, 'live_end'); ?></td>
                        <td><?php echo $model->live_end; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'watermark_id'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'watermark_id', array('class' => 'input-text')); ?>
                            <span id="watermark_box"><?php if($model->gf_watermark!=null){?><span class="label-box"><?php echo $model->gf_watermark->w_title;?></span><?php }?></span>
                            <?php echo $form->error($model, 'watermark_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'open_club_member'); ?></td>
                        <td><?php if(!empty($model->clubmember)) echo $model->clubmember->F_NAME; ?>
                            <?php echo $form->error($model, 'open_club_member', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'is_pay'); ?></td>
                        <td><?php if(!empty($model->ispay)) echo $model->ispay->F_NAME; ?>
                            <?php echo $form->error($model, 'is_pay', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td>
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_name;?></span><?php } ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'if_no_chinese'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'if_no_chinese', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check','disabled'=>'true', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <span class="msg">注：在国外举办的活动或参与者有外国国籍</span>
                            <?php echo $form->error($model, 'if_no_chinese', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_contacts'); ?></td>
                        <td><?php echo $model->club_contacts;?></td>
                        <td><?php echo $form->labelEx($model, 'club_contacts_phone'); ?></td>
                        <td><?php echo $model->club_contacts_phone;?></td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_address'); ?></td>
                        <td><?php echo $model->live_address;?></td>
                        <td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                        <td><?php echo $model->order_num;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'programs_list'); ?></td>
                        <td colspan="3">
                            <table id="program_list" class="showinfo" data-num="new">
                                <tr class="table-title">
                                    <td width="20%">节目标题</td>
                                    <td width="20%">开始时间</td>
                                    <td width="20%">结束时间</td>
                                    <td>回放地址</td>
                                </tr>
                                <?php if(!empty($programs)){?>
                                <?php foreach($programs as $v){?>
                                <tr>
                                    <td><?php echo $v->title;?></td>
                                    <td><?php echo $v->program_time;?></td>
                                    <td><?php echo $v->program_end_time;?></td>
                                    <td><?php echo $v->playback_url;?></td>
                                </tr>
                                <?php }?>
                                <?php }?>
                            </table>
                        </td>
                    </tr>
                </table>
                <table class="table-title mt15">
                    <tr>
                        <td>直播服务设置</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'live_source_RTMP'); ?></td>
                        <td width="35%"><?php echo $model->live_source_RTMP; ?></td>
                        <td width="15%"></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_source_RTMP_H'); ?></td>
                        <td><?php echo $model->live_source_RTMP_H; ?></td>
                        <td><?php echo $form->labelEx($model, 'live_source_RTMP_N'); ?></td>
                        <td><?php echo $model->live_source_RTMP_N; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_source_FLV_H'); ?></td>
                        <td><?php echo $model->live_source_FLV_H; ?></td>
                        <td><?php echo $form->labelEx($model, 'live_source_FLV_N'); ?></td>
                        <td><?php echo $model->live_source_FLV_N; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_source_HLS_H'); ?></td>
                        <td><?php echo $model->live_source_HLS_H; ?></td>
                        <td><?php echo $form->labelEx($model, 'live_source_HLS_N'); ?></td>
                        <td><?php echo $model->live_source_HLS_N; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'channelState'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'channelState', Chtml::listData(BaseCode::model()->getCode(695), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'channelState', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'isRecord'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'isRecord', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'isRecord', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table>
                    <tr class="table-title">
                        <td><?php echo $form->labelEx($model, 'intro_project_temp'); ?></td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'intro_project_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_intro_project_temp', '<?php echo get_class($model);?>[intro_project_temp]');</script>
                            <div class="msg red">注：如活动含有秩序册、活动开展文件请上传附件</div>
                            <?php echo $form->error($model, 'intro_project_temp', $htmlOptions = array()); ?>
                        </td>
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
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'checkin_code'); ?></td>
                        <td><?php echo $model->checkin_code; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'checkin_img'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(273);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->checkin_img!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_checkin_img"><a href="<?php echo $model->checkin_img;?>" target="_blank"><img src="<?php echo $model->checkin_img;?>" width="100"></a></div><?php }?>
                            <?php echo $form->error($model, 'checkin_img', $htmlOptions = array()); ?>
                            
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
           
        </div><!--box-detail-bd end-->
		<div class="mt15">
        <table class="table-title" style='margin-top:10px;'><tr> <td>审核信息</td></tr></table>
         <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'state'); ?></td>
                <td width="35%"><?php echo $model->state_name;?></td>
                <td width="15%"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                <td width="35%">
                   <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                    <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
            	<td>可执行操作</td>
                <td colspan="3">
                	<?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                </td>
            </tr>
        </table>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
$(function(){
setTimeout(function(){ UE.getEditor('editor_VideoLive_intro_project_temp').setDisabled('fullscreen'); }, 500);
setTimeout(function(){ UE.getEditor('editor_VideoLive_intro_temp').setDisabled('fullscreen'); }, 500);
});

</script>