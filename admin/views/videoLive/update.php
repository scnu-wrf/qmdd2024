<?php if($flag==1){
    $txt='编辑';
} else{
    $txt='添加';
}
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》发布/审核/备案》<a class="nav-a"><?php echo $txt; ?></a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">直播详情</li>
                <li>直播人员</li>
                <li>直播简介</li>
                <li>切播内容</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
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
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span><?php } ?></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'title'); ?></td>
                        <td><?php echo $form->textField($model, 'title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'live_type'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'live_type', Chtml::listData(VideoClassify::model()->getCode(366), 'id', 'sn_name'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'live_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'is_single'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'is_single', Chtml::listData(array(array('id'=>'0','name'=>'连续多场'),array('id'=>'1','name'=>'单场')), 'id', 'name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
							<?php echo $form->error($model, 'is_single', $htmlOptions = array()); ?>
                        </td>
						<td>直播日期 <span class="required">*</span></td>
                        <td>
                            <?php echo $form->textField($model, 'live_start_check', array('class' => 'input-text','onclick'=>'fnStartTime1(this);','style'=>'width:80px;','readonly'=>'readonly')); ?> - <?php echo $form->textField($model, 'live_end_check', array('class' => 'input-text','onclick'=>'fnEndTime1(this);','style'=>'width:80px;','readonly'=>'readonly')); ?>
							<?php echo $form->error($model, 'live_start_check', $htmlOptions = array()); ?>
							<?php echo $form->error($model, 'live_end_check', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'once_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'once_time', array('class' => 'input-text')); ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'airtime_check'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'airtime_check', array('class' => 'input-text','onclick'=>"WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss'});",'readonly'=>'readonly')); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'total_time'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'total_time', array('class' => 'input-text')); ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'club_contacts'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'club_contacts', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'club_contacts', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'address'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'address', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'address', $htmlOptions = array()); ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'club_contacts_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'club_contacts_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'club_contacts_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'live_address'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'live_address', array('class' => 'input-text','readonly'=>true)); ?>
                            <?php echo $form->hiddenField($model, 'longitude'); ?>
                            <?php echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'live_address', $htmlOptions = array()); ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'club_contacts_email'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'club_contacts_email', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'club_contacts_email', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
						<td><?php echo $form->labelEx($model, 'logo'); ?></td>
                        <td colspan=3>
                            <?php echo $form->hiddenField($model, 'logo', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(141);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->logo!=''){?><div class="upload_img fl" id="upload_pic_VideoLive_logo"><a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100"></a></div><?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_logo','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'logo', $htmlOptions = array()); ?>
                            <span class="msg">1042*447</span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'programs_list'); ?></td>
                        <td colspan="3" style="padding:0;">
                            <?php echo $form->hiddenField($model, 'programs_list'); ?>
                            <table id="program_list" class="showinfo" data-num="new" style="margin:0;">
                                <tr class="table-title">
                                    <td width="15%">节目单号</td>
                                    <td width="20%">节目单名称</td>
                                    <td width="15%">开始时间</td>
                                    <td width="15%">结束时间</td>
                                    <td>直播时长</td>
                                    <td>操作</td>
                                </tr>
                                <?php if(!empty($programs)){?>
                                <?php foreach($programs as $v){?>
                                <tr>
                                    <td><?php echo $v->program_code;?></td>
                                    <td><input type="hidden" class="input-text" name="programs_list[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
                                    <input onchange="fnUpdateProgram();" class="input-text" name="programs_list[<?php echo $v->id;?>][title]" value="<?php echo $v->title;?>"></td>
                                    <td><input onchange="fnUpdateProgram();" onblur="fnCountMinute(this);" class="input-text" name="programs_list[<?php echo $v->id;?>][program_time]" value="<?php echo $v->program_time;?>" onclick="fnSetDateTime(this);"></td>
                                    <td><input onchange="fnUpdateProgram();" onblur="fnCountMinute(this);" class="input-text" name="programs_list[<?php echo $v->id;?>][program_end_time]" value="<?php echo $v->program_end_time;?>" onclick="fnSetDateTime(this);"></td>
                                    <td><input onchange="fnUpdateProgram();" class="input-text" style="width:60%;" name="programs_list[<?php echo $v->id;?>][duration]" value="<?php echo $v->duration;?>">分钟</td>
                                    <td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行">&nbsp;<input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
                                </tr>
                                <?php }?>
                                <?php }else{?>
                                <tr>
                                    <td></td>
                                    <td><input type="hidden" class="input-text" name="programs_list[new][id]" value="null" /><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[new][title]"></td>
                                    <td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[new][program_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);"></td>
                                    <td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[new][program_end_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);"></td>
                                    <td><input onchange="fnUpdateProgram();" class="input-text" style="width:60%;" name="programs_list[new][duration]">分钟</td>
                                    <td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行"></td>
                                </tr>
                                <?php }?>
                            </table>
                            <?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
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
                            <?php echo $form->textField($model, 'live_start', array('class' => 'input-text','onclick'=>'fnStartTime(this);','style'=>'width:120px;','readonly'=>'readonly')); ?> - <?php echo $form->textField($model, 'live_end', array('class' => 'input-text','onclick'=>'fnEndTime(this);','style'=>'width:120px;','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model, 'live_start', $htmlOptions = array()); ?><?php echo $form->error($model, 'live_end', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'live_mode'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'live_mode', Chtml::listData(BaseCode::model()->getCode(1358), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <?php echo $form->error($model, 'live_mode', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'project_is'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'project_is', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectProjectIs(this)')); ?>
                            <?php echo $form->error($model, 'project_is', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'if_no_chinese'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'if_no_chinese', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            <span class="msg">注：在国外举办的活动或参与者有外国国籍</span>
                            <?php echo $form->error($model, 'if_no_chinese', $htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr id="ProjectIs" style="display:none;">
                        <td>指定选择项目</td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text')); ?>
                            <span id="project_box"><?php foreach($project_list as $v){?><span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->project_name;?><i onclick="fnDeleteProject(this);"></i></span><?php }?></span>
                            <input id="project_add_btn" class="btn" type="button" value="添加项目">
                            <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'open_club_member'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'open_club_member', Chtml::listData($member_type, 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectMember(this)')); ?>
                            <?php echo $form->error($model, 'open_club_member', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'live_show'); ?></td>
                        <td>
                            <?php echo $form->checkBoxList($model, 'live_show', Chtml::listData(BaseCode::model()->getCode(1367), 'f_id', 'F_NAME'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                             <?php echo $form->error($model, 'live_show'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'gf_price'); ?>（元）<span id="gf_price" style="display:none;" class="required">*</span></td>
                        <td>
                            <?php echo $form->textField($model, 'gf_price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'gf_price', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'member_price'); ?>（元）</td>
                        <td>
                            <?php echo $form->textField($model, 'member_price', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'member_price', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'viewers'); ?>（人）</td>
                        <td>
                            <?php echo $form->textField($model, 'viewers', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'viewers', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 't_duration'); ?>（分钟）</td>
                        <td>
                            <?php echo $form->textField($model, 't_duration', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 't_duration', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>直播人员</td>
                    </tr>
                <?php echo $form->hiddenField($model, 'persons', array('class' => 'input-text')); ?>
                </table>
                <table id="persons">
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'leader'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'leader', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'leader', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'leader_phone'); ?></td>
                        <td width="35%">
                            <?php echo $form->textField($model, 'leader_phone', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'leader_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'guest'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textArea($model, 'guest', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'guest', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'live_content'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'live_content', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'live_content', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'barrage'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'barrage', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'barrage', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'director'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'director', array('class' => 'input-text','style'=>'width:36%;')); ?>
                            <?php echo $form->error($model, 'director', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'camera'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'camera', array('class' => 'input-text','style'=>'width:36%;')); ?>
                            <?php echo $form->error($model, 'camera', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'monitor'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'monitor', array('class' => 'input-text','style'=>'width:36%;')); ?>
                            <?php echo $form->error($model, 'monitor', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'toning'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'toning', array('class' => 'input-text','style'=>'width:36%;')); ?>
                            <?php echo $form->error($model, 'toning', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'media'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'media', array('class' => 'input-text','style'=>'width:36%;')); ?>
                            <?php echo $form->error($model, 'media', $htmlOptions = array()); ?>
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
            <div style="display:none;" class="box-detail-tab-item">
                <table class="table-title">
                    <tr>
                        <td>切播内容</td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'content', array('class' => 'input-text')); ?>
                </table>
                <table id="content">
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'cut_title'); ?><span class="required">*</span></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'cut_title', array('class' => 'input-text','style'=>'width:36%;')); ?>
                            <?php echo $form->error($model, 'cut_title', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'cut_type'); ?><span class="required">*</span></td>
                        <td colspan="3">
                            <?php echo $form->dropDownList($model, 'cut_type', Chtml::listData($cut_type, 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectCuttype(this)')); ?>
                            <?php echo $form->error($model, 'cut_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'cut_material_id'); ?><span class="required">*</span></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'cut_material_id', array('class' => 'input-text')); ?>
                            <div id="cut_box">
                         <?php if(!empty($model->gfmaterial)){ ?>
                        <?php if($model->cut_type==252){ ?>
                                <a href="<?php echo $model->gfmaterial->v_file_path.$model->gfmaterial->v_pic; ?>" target="_blank"><img src="<?php echo $model->gfmaterial->v_file_path.$model->gfmaterial->v_pic; ?>" width="100"></a>
                        <?php } elseif ($model->cut_type==253) { ?>
                                <a href="<?php echo $model->gfmaterial->v_file_path.$model->gfmaterial->v_name; ?>" target="_blank"><?php echo $model->gfmaterial->v_name; ?></a>
                        <?php }} ?>
                            </div>
                        <div id="img_box" style="display:none;">
                            <div class="upload fl">
                            <script>
                                var materialPicUrl='<?php echo $this->createUrl('gfMaterial/uppic');?>';
                            we.materialPic(function(data){ $('#cut_box').html('<a href="'+data.allpath+'" target="_blank"><img src="'+data.allpath+'" width="100"></a>'); $('#VideoLive_cut_material_id').val(data.id); },61,24,'上传');
                            </script>
                            </div>
                        </div>
                        <div id="video_box" style="display:none;">
                            <div class="upload fl">
                            <script>
                                var materialVideoUrl='<?php echo $this->createUrl('gfMaterial/upvideo');?>';
                            we.materialVideo(function(data){ $('#cut_box').html('<a href="'+data.allpath+'" target="_blank">'+data.title+'</a>'); $('#VideoLive_cut_material_id').val(data.id); },'上传',61,24);
                            </script>
                            </div>
                        </div>
                            <input id="cut_select_btn" class="btn" type="button" value="选择">
                            <span class="msg" id="cut_size"></span>
                            <?php echo $form->error($model, 'cut_material_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->

        </div><!--box-detail-bd end-->
        <div id="operate" class="mt15" style="text-align:center;">
            <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
var club_id=<?php echo $model->club_id;?>;
var flag;
var fnUpdatePersons=function(){
    var arr=[];
    var id;
    $('#persons').find('.input-text').each(function(){
        if($(this).val()!=''){
            id=$(this).val();
            arr.push(id);
        }
    });
    $('#VideoLive_persons').val(we.implode(',', arr));

}
var fnUpdateContent=function(){
    var arr=[];
    var id;
    $('#content').find('.input-text').each(function(){
        if($(this).val()!=''){
           id=$(this).val();
            arr.push(id);
        }
    });
    $('#VideoLive_content').val(we.implode(',', arr));
}
var is_click=false;
var confirm = function(){
    is_click=true;
    $('#operate .btn-blue:eq(1)').click();
}
$(function(){

    $('#operate .btn-blue:eq(1)').on('click',function(){
        fnUpdateProgram();
        fnUpdatePersons();
        fnUpdateContent();
        var cu=0;
        var txt='';
        var persons=$('#VideoLive_persons').val();
        var content=$('#VideoLive_content').val();
        var intro_temp=$('#VideoLive_intro_temp').val();
        var project_is=$("#VideoLive_project_is").val();
        var member=$('#VideoLive_open_club_member').val();
        var gf_price=$('#VideoLive_gf_price').val();
        var project_list=$("#VideoLive_project_list").val();
        if(project_is==649 && project_list==''){
            we.msg('minus','展示项目不能为空');
            return false;
        }
        if(member==210 && gf_price==''){
            we.msg('minus','GF会员收费不能为空');
            return false;
        }
        if(flag>0){
            we.msg('minus','请填写完整的节目单');
            return false;
        }
        if(content==''){
            we.msg('minus','【切播内容】不能为空');
            return false;
        }

        if(persons==''){
            cu++;
            txt=txt+'【直播人员】 '
        }
        if(intro_temp==''){
            cu++;
            txt=txt+'【直播简介】'
        }
        if(!is_click){

            if(cu>0){
                $.fallr('show', {
                    buttons: {
                        button1: {text: '是', danger: true, onclick: confirm},
                        button2: {text: '否'}
                    },
                    content: txt+'未填写，是否提交审核？',
                    afterHide: function() {
                        we.loading('hide');
                    }
                });
                return false;
            }
        }
        is_click=false;


    });

});
fnUpdatePersons();
fnUpdateContent();

// 选择素材
    var $product_list=$('#product_list');
    $('#cut_select_btn').on('click', function(){
    var cut_type = $('#VideoLive_cut_type').val();
    var club_id=$('#VideoLive_club_id').val();
    if(cut_type==''){
            we.msg('minus','请先选择类型');
            return false;
        }
        $.dialog.data('material_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/material");?>&type='+cut_type+'&club_id='+club_id,{
            id:'sucai',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $('#VideoLive_cut_material_id').val($.dialog.data('material_id')).trigger('blur');;
                    if (cut_type==253) {
                        $('#cut_box').html('<a href="'+$.dialog.data('v_path')+'" target="_blank">'+$.dialog.data('material_title')+'</a>');
                    } else if (cut_type==252) {
                        $('#cut_box').html('<a href="'+$.dialog.data('v_path')+'" target="_blank"><img src="'+$.dialog.data('v_path')+'" width="100"></a>');
                    }
                       // we.uploadpic('sub_product_list_'+$.dialog.data('material_id'), '<php echo $picprefix;?>');
                }
            }
        });
    });
selectCuttype($('#VideoLive_cut_type'));
function selectCuttype(obj){
    var show_type=$(obj).val();
    if(show_type==252){
        $('#img_box').show();
        $('#video_box').hide();
        $('#cut_size').text('规格：1042px*447px');
    } else if(show_type==253){
        $('#img_box').hide();
        $('#video_box').show();
        $('#cut_size').text('格式：mp4');
    }
}

selectProjectIs($('#VideoLive_project_is'));
function selectProjectIs(obj){
    var show_type=$(obj).val();
    if(show_type==649){
        $('#ProjectIs').show();
    } else{
        $('#ProjectIs').hide();
    }
}
selectMember($('#VideoLive_open_club_member'));
function selectMember(obj){
    var show_type=$(obj).val();gf_price
    if(show_type==210){
        $("#VideoLive_gf_price").attr("disabled",false).val("0.00");
        $("#gf_price").show();
    } else{
        $('#VideoLive_gf_price').val('');
        $("#VideoLive_gf_price").attr("disabled",true);
        $("#gf_price").hide();
    }
}
// 删除项目
var $project_box=$('#project_box');
var $VideoLive_project_list=$('#VideoLive_project_list');
var fnUpdateProject=function(){
    var arr=[];
    var id;
    $project_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $VideoLive_project_list.val(we.implode(',', arr));
};

var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};


// 添加删除更新节目
var $program_list=$('#program_list');
var $VideoLive_programs_list=$('#VideoLive_programs_list');
var fnAddProgram=function(){
    var num=$program_list.attr('data-num')+1;
    $program_list.append('<tr><td></td>'+
        '<td><input type="hidden" class="input-text" name="programs_list['+num+'][id]" value="null" /><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][title]"></td>'+
        '<td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][program_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);" readonly></td>'+
        '<td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][program_end_time]" onclick="fnSetDateTime(this);" onblur="fnCountMinute(this);" readonly></td>'+
        '<td><input onchange="fnUpdateProgram();" class="input-text" style="width:60%;" name="programs_list['+num+'][duration]">分钟</td>'+
        '<td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加行">&nbsp;<input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>'+
        '</tr>');
    $program_list.attr('data-num',num);
};
var fnDeleteProgram=function(op){
    $(op).parent().parent().remove();
    fnUpdateProgram();
};
var fnUpdateProgram=function(){
    var isEmpty=true;
    flag=0;
    $program_list.find('.input-text').each(function(){
        if($(this).val()!=''){
            isEmpty=false;
            //return false;
        } else{
            flag++;
        }
    });
    if(!isEmpty){
        $VideoLive_programs_list.val('1').trigger('blur');
    }else{
        $VideoLive_programs_list.val('').trigger('blur');
    }
};
var fnCountMinute=function(op){
    var current_line=$(op).parent().parent().find('input');
    var star_time = current_line.eq(2).val();
    var end_time = current_line.eq(3).val();
    if((end_time!='') && (star_time!='')){
        if(star_time>=end_time){
            we.msg('minus', '结束时间必须大于开始时间');
            $(op).val('');
            return false;
        }else{
            var date1 = new Date(star_time);
            var date2 = new Date(end_time);
            var s1=date1.getTime();
            var s2=date2.getTime();
            var minute=parseInt((s2-s1)/(1000*60));
			if(minute>1440){
				we.msg('minus', '单个节目时长不能超过24小时');
				$(op).val('');
				return false;
			}
            current_line.eq(4).val(minute);
        }

    }

}

// 设置时间
var fnSetDateTime=function(){
    WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss'});
};
//显示时间开始时间
var fnStartTime=function(op){
        WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss',onpicked:function(dp){
            var star_time =$(op).val();
            var end_time =$('#VideoLive_live_end').val();
            if(end_time!='' && star_time>=end_time){
                we.msg('minus', '开始时间不能大于或等于结束时间');
                $(op).val('');
                return false;
            }

        }});
    };
//显示时间结束时间
var fnEndTime=function(op){
        WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss',onpicked:function(dp){
            var end_time =$(op).val();
            var star_time =$('#VideoLive_live_start').val();
            if(star_time!='' && end_time<=star_time){
                we.msg('minus', '结束时间不能小于或等于开始时间');
                $(op).val('');
                return false;
            }

        }});
}
//直播日期开始时间
var fnStartTime1=function(op){
        WdatePicker({dateFmt:'yyyy-MM-dd',realDateFmt:'yyyy-MM-dd',onpicked:function(dp){
            var star_time =$(op).val();
            var end_time =$('#VideoLive_live_end_check').val();
            if(end_time!='' && star_time>end_time){
                we.msg('minus', '开始时间不能大于结束时间');
                $(op).val('');
                return false;
            }

        }});
    };
//直播日期结束时间
var fnEndTime1=function(op){
        WdatePicker({dateFmt:'yyyy-MM-dd',realDateFmt:'yyyy-MM-dd',onpicked:function(dp){
            var end_time =$(op).val();
            var star_time =$('#VideoLive_live_start_check').val();
            if(star_time!='' && end_time<star_time){
                we.msg('minus', '结束时间不能小于开始时间');
                $(op).val('');
                return false;
            }

        }});
}
$(function(){

    // 添加项目
    $('#project_add_btn').on('click', function(){
        var club_id=$('#VideoLive_club_id').val();
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>&club_id='+club_id,{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')==-1){
                    var boxnum=$.dialog.data('project_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#project_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                            fnUpdateProject();
                        }
                    }
                }
            }
        });
    });


    // 选择直播地址
    var $VideoLive_live_address=$('#VideoLive_live_address');
    var $VideoLive_longitude=$('#VideoLive_longitude');
    var $VideoLive_latitude=$('#VideoLive_latitude');
    $VideoLive_live_address.on('click', function(){
    var address=$('#VideoLive_live_address').val();
    var longitude=$('#VideoLive_longitude').val();
    var latitude=$('#VideoLive_latitude').val();
        $.dialog.data('maparea_address', '');
        $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>&address='+address+'&longitude='+longitude+'&latitude='+latitude,{
            id:'diqu',
            lock:true,
            opacity:0.3,
            title:'选择服务地区',
            width:'907px',
            height:'400px',
            close: function () {;
                if($.dialog.data('maparea_address')!=''){
                    $VideoLive_live_address.val($.dialog.data('maparea_address'));
                    $VideoLive_longitude.val($.dialog.data('maparea_lng'));
                    $VideoLive_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });


});

// 生成直播频道
var $VideoLive_live_source_RTMP=$('#VideoLive_live_source_RTMP');
var $VideoLive_live_source_RTMP_H=$('#VideoLive_live_source_RTMP_H');
var $VideoLive_live_source_RTMP_N=$('#VideoLive_live_source_RTMP_N');
var $VideoLive_live_source_FLV_H=$('#VideoLive_live_source_FLV_H');
var $VideoLive_live_source_FLV_N=$('#VideoLive_live_source_FLV_N');
var $VideoLive_live_source_HLS_H=$('#VideoLive_live_source_HLS_H');
var $VideoLive_live_source_HLS_N=$('#VideoLive_live_source_HLS_N');
var $VideoLive_live_source_time=$('#VideoLive_live_source_time');
var $VideoLive_live_source_secret=$('#VideoLive_live_source_secret');
var fnOpenVideoLiveService=function(live_id){
    we.loading('show');
    $.ajax({
        type: 'get',
        url: '<?php echo $this->createUrl('getVideoLiveInfo',array('endTime'=>$model->live_end));?>&live_id='+live_id,
        dataType: 'json',
        success: function(data) {
            we.loading('hide');
            console.log(data);
            if (data.status == 1) {
                $VideoLive_live_source_RTMP.val(data.push_url);
                $VideoLive_live_source_RTMP_H.val(data.play_rtmp);
                $VideoLive_live_source_RTMP_N.val(data.play_rtmp_sd);
                $VideoLive_live_source_FLV_H.val(data.play_flv);
                $VideoLive_live_source_FLV_N.val(data.play_flv_sd);
                $VideoLive_live_source_HLS_H.val(data.play_hls);
                $VideoLive_live_source_HLS_N.val(data.play_hls_sd);
            }
        }
    });
}

var fnOpenVideoLiveService_GF=function(live_id,live_code){
    we.loading('show');
    $.ajax({
        type: 'get',
        url: '<?php echo $this->createUrl('getVideoLiveInfo_GF',array('live_id'=>$model->id,'live_code'=>$model->code));?>',
        dataType: 'json',
        success: function(data) {
            we.loading('hide');
            console.log(data);
            if (data.status == 1) {
                $VideoLive_live_source_time.val(data.push_url_date);
                $VideoLive_live_source_secret.val(data.push_url_secret);
                $VideoLive_live_source_RTMP.val(data.push_url);
                $VideoLive_live_source_RTMP_H.val(data.play_rtmp);
                $VideoLive_live_source_RTMP_N.val(data.play_rtmp_sd);
                $VideoLive_live_source_FLV_H.val(data.play_flv);
                $VideoLive_live_source_FLV_N.val(data.play_flv_sd);
                $VideoLive_live_source_HLS_H.val(data.play_hls);
                $VideoLive_live_source_HLS_N.val(data.play_hls_sd);
            } else {
                we.msg('minus', '直播编码为空，无法生成直播频道');
                return false;
            }
        }
    });
}
</script>