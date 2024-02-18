<div class="box">
    <div class="box-title c"><h1>当前界面：视频》视频管理》视频列表》<a class="nav-a">详情</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
			<table class="table-title">
				<tr>
					<td>基本信息</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'video_code'); ?></td>
					<td style="color:#7a7a7a"><?php echo $model->video_code;?></td>
					<td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
					<td style="color:#7a7a7a">
						<span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?></span><?php } ?></span>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'publish_classify'); ?></td>
					<td style="color:#7a7a7a">
						<?php echo $form->hiddenField($model, 'publish_classify', array('class' => 'input-text')); ?>
						<span id="publish_classify_box"><?php foreach($publish_classify as $v){?><span class="label-box" id="publish_classify_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->sn_name;?></span><?php }?></span>
						  <?php echo $form->error($model, 'publish_classify'); ?>
					</td>
					<td><?php echo $form->labelEx($model, 'video_classify'); ?></td>
					<td style="color:#7a7a7a">
						<?php echo $form->hiddenField($model, 'video_classify', array('class' => 'input-text')); ?>
						<span id="classify_box"><?php foreach($video_classify as $v){?><span class="label-box" id="classify_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->sn_name;?></span><?php }?></span>
						  <?php echo $form->error($model, 'video_classify'); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'video_title'); ?></td>
					<td style="color:#7a7a7a"><?php echo $model->video_title;?></td>
					<td><?php echo $form->labelEx($model, 'video_sec_title'); ?></td>
					<td style="color:#7a7a7a"><?php echo $model->video_sec_title;?></td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'video_logo'); ?></td>
					<td style="color:#7a7a7a" colspan="3">
						<?php $basepath=BasePath::model()->getPath(143);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
						<?php if($model->video_logo!=''){ ?><div class="upload_img fl" id="upload_pic_BoutiqueVideo_video_logo"><?php  ?><a href="<?php echo $basepath->F_WWWPATH.$model->video_logo;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->video_logo;?>" width="100"></a><?php  ?></div><?php }?>
					</td>
				</tr>
			</table>
			<table class="table-title" style="margin-top:10px;">
				<tr>
					<td>视频信息</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'program_num'); ?></td>
					<td style="color:#7a7a7a" width="35%"><?php echo $model->program_num;?></td>
					<td width="15%"><?php echo $form->labelEx($model, 'year'); ?></td>
					<td style="color:#7a7a7a"><?php echo $model->year;?></td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'area'); ?></td>
					<td style="color:#7a7a7a" width="35%"><?php echo $model->area;?></td>
					<td width="15%"><?php echo $form->labelEx($model, 'topic'); ?></td>
					<td style="color:#7a7a7a"><?php echo $model->topic;?></td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'video_intro'); ?></td>
					<td style="color:#7a7a7a" colspan="3"><?php echo $model->video_intro;?><?php echo $form->hiddenField($model, 'video_intro', array('class' => 'input-text')); ?></td>
				</tr>
			</table>
			<table class="table-title" style="margin-top:10px;table-layout:auto;">
				<tr>
					<td width="90%">视频分集</td>
					<td></td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<?php echo $form->hiddenField($model, 'programs_list'); ?>
						<input name="fileCode" id="fileCode" value="204_gm" type="hidden" />
						<table id="program_list" class="showinfo" data-num="new" style="margin:0;table-layout:auto;">
							<tr class="table-title">
								<td width="150px">分集编号</td>
								<td>分集名称<span class="required">*</span></td>
								<td>视频文件<span class="required">*</span><span style="color:#7a7a7a;font-size:smaller;">（点击播放）</span></td>
								<td>格式</td>
								<td>时长</td>
							</tr>
							<?php if(!empty($programs)){?>
							<?php foreach($programs as $k=>$v){?>
							<tr>
								<td style="color:#7a7a7a"><?php echo $v->video_series_code;?></td>
								<td style="color:#7a7a7a"><?php echo $v->video_series_title;?></td>
								<td class="up_btn">
									<span class="fl video_box"><?php if($v->gf_material!=null){?><span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="<?php echo $this->createUrl("gfMaterial/video_player", array('id'=>$v->gf_material->id));?>" target="_blank" title="<?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?>"><?php if($v->gf_material->v_title!=''){ echo $v->gf_material->v_title; }else{ echo $v->gf_material->v_name; }?></a></span><?php }?></span>
								</td>
								<td style="color:#7a7a7a"><?php echo $v->video_format;?></td>
								<td style="color:#7a7a7a"><?php echo $v->video_duration;?>分钟</td>
							</tr>
							<?php }?>
							<?php }?>
						</table>
						<?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
					</td>
				</tr>
			</table>
			<table class="table-title mt15">
				<tr>
					<td>视频设置</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="15%">是否上线 <span class="required">*</span></td>
					<td style="color:#7a7a7a">
						<?php echo $model->is_uplist==1?'是':'否';?>
						<span style="color:#7a7a7a;font-size:smaller;">（是:上线,展示前端　否:下线,不展示前端）</span>
					</td>
					<td width="15%">上/下线时间 <span class="required">*</span><br><span style="color:#7a7a7a;font-size:smaller;">显示前端的时间</span></td>
					<td style="color:#7a7a7a">
						<?php echo $model->video_start;?><br><?php echo $model->video_end;?>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'project_is'); ?></td>
					<td style="color:#7a7a7a">
						<?php if($model->project_is==648){?>
							<span id="project_box">不限项目</span>
						<?php }else{?>
							<span id="project_box"><?php foreach($project_list as $v){?><span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->project_name;?></span><?php }?></span>
						<?php }?>
					</td>
					<td><?php echo $form->labelEx($model, 'video_show'); ?></td>
					<td style="color:#7a7a7a">
						<?php echo $form->checkBoxList($model, 'video_show', Chtml::listData(BaseCode::model()->getCode(1542), 'f_id', 'F_NAME'),
						  $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>','disabled'=>'disabled')); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'open_club_member'); ?><br><span style="color:#7a7a7a;font-size:smaller;">GF会员含单位会员</span></td>
					<td colspan="3" style="color:#7a7a7a">
						<?php echo $model->open_club_member_name->F_NAME; ?>
				  </td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'gf_price'); ?>（元）<br><span style="color:#7a7a7a;font-size:smaller;">0元视为免费观看</span></td>
					<td style="color:#7a7a7a">
						<?php echo $model->gf_price; ?>
					</td>
					<td><?php echo $form->labelEx($model, 'member_price'); ?>（元）<br><span style="color:#7a7a7a;font-size:smaller;">0元视为免费观看</span></td>
					<td style="color:#7a7a7a">
						<?php echo $model->member_price; ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 't_duration'); ?>（分钟）</td>
					<td style="color:#7a7a7a">
						<?php echo $model->t_duration; ?>
					</td>
					<td colspan="2"></td>
				</tr>
			</table>
			<table class="table-title" style='margin-top:10px;'><tr><td>操作信息</td></tr></table>
			<table>
				<tr>
					<td width="15%">状态</td>
					<td colspan="3" style="color:#7a7a7a"><?php echo $model->is_uplist==1?'上线':'下线'; ?></td>
				</tr>
				<tr>
					<td>可执行操作</td>
					<td colspan="3">
						<?php if($model->is_uplist==1){ ?>
						<button id="shanchu" onclick="we.down('<?php echo $model->id;?>', downUrl);" class="btn btn-blue" type="button">下线</button>
						<?php } else{ ?>
						<button id="shanchu" onclick="we.online('<?php echo $model->id;?>', onlineUrl);" class="btn btn-blue" type="button">上线</button>
						<?php }?>
						<button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
			</table>
        </div><!--box-detail-bd end-->
        
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
var downUrl = '<?php echo $this->createUrl('down', array('id'=>'ID'));?>';
var onlineUrl = '<?php echo $this->createUrl('online', array('id'=>'ID'));?>';
</script>