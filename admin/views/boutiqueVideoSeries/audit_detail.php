<div class="box">
    <div class="box-title c"><h1>当前界面：视频》视频分集管理》发布审核》<a class="nav-a">详情</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd" style="margin-top: 10px;">
			<table>
				<tr>
                    <td width="15%">视频名称</td>
                    <td style="color:#7a7a7a">
						<?php echo $model->video_title;?>
					</td>
					<td width="15%"><?php echo $form->labelEx($model, 'publish_classify'); ?></td>
					<td style="color:#7a7a7a"><?php echo $model->publish_classify_name;?></td>
                </tr>
				<tr>
					<td width="15%">是否上线 <span class="required">*</span><br><span style="color:#7a7a7a;font-size:smaller;">是:上线,展示前端<br>否:下线,不展示前端</span></td>
					<td colspan=3 style="color:#7a7a7a">
						<?php echo $model->is_uplist==1?'是':'否';?>
						<?php echo $form->error($model, 'is_uplist'); ?>
					</td>
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
						</table>
						<?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
					</td>
				</tr>
			</table>
			<table class="table-title" style='margin-top:10px;'><tr><td>操作信息</td></tr></table>
			<table>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'state'); ?></td>
					<td colspan="3"><?php echo $model->state_name;?></td>
				</tr>
				<tr>
					<td>操作备注</td>
					<td colspan="3">
						<?php echo $model->reasons_failure;?>
					</td>
				</tr>
			</table>
        
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
</script>