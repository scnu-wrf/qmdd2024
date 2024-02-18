<div class="box">
    <div class="box-title c"><h1>当前界面：视频》视频分集管理》视频分集列表》<a class="nav-a">详情</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd" style="margin-top: 10px;">
			<table class="table-title" style='margin-top:10px;'><tr><td>分集信息</td></tr></table>
			<?php echo $form->hiddenField($model, 'programs_list'); ?>
			<table id="program_list">
				<tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'video_series_code'); ?></td>
                    <td><?php echo $model->video_series_code;?></td>
					<td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                    <td><?php echo $model->club_name; ?></td>
                </tr>
				<tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'video_id'); ?></td>
                    <td><?php echo $model->video_title;?><?php echo $form->hiddenField($model, 'video_id', array('class' => 'input-text')); ?></td>
					<td width="15%"><?php echo $form->labelEx($model, 'publish_classify'); ?></td>
                    <td><?php echo $model->publish_classify_name; ?></td>
                </tr>
				<tr>
                    <td style="width:100px;"><?php echo $form->labelEx($model, 'video_series_title'); ?></td>
                    <td><?php echo $form->textField($model, 'video_series_title', array('class' => 'input-text')); ?><?php echo $form->error($model, 'video_series_title', $htmlOptions = array()); ?></td>
                    <td style="width:100px;"><?php echo $form->labelEx($model, 'video_source_id'); ?></td>
                    <td>
						<span id="video_box" class="fl"><?php if($model->gf_material!=null){?><span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="<?php echo $this->createUrl("gfMaterial/video_player", array('id'=>$model->gf_material->id));?>" target="_blank" title="<?php if($model->gf_material->v_title!=''){ echo $model->gf_material->v_title; }else{ echo $model->gf_material->v_name; }?>"><?php if($model->gf_material->v_title!=''){ echo $model->gf_material->v_title; }else{ echo $model->gf_material->v_name; }?></a></span><?php }?></span>
					</td>
                </tr>
				<tr>
                    <td style="width:100px;"><?php echo $form->labelEx($model, 'video_format'); ?></td>
                    <td><?php echo $model->video_format; ?></td>
                    <td style="width:100px;"><?php echo $form->labelEx($model, 'video_duration'); ?></td>
                    <td><?php echo $model->video_duration; ?>分钟</td>
                </tr>
			</table>
        </div><!--box-detail-bd end-->
		<div class="box-detail-bd">
			<table class="table-title" style='margin-top:10px;'><tr><td>操作信息</td></tr></table>
			<table>
				<tr>
					<td>可执行操作</td>
					<td colspan="3">
						<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
						<button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
			</table>
        </div><!--box-detail-bd end-->
        
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->