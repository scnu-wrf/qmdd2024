<div class="box">
    <div class="box-title c"><h1>当前界面：赛事/排名 》积分管理 》龙虎置换排名积分确认 》详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
			<table class="detail" border="0" style="width:65%">
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'GF_ACCOUNT'); ?>：</th>
                    <td colspan="3">
						<?php if($model->come->gf_user_name!=null){echo $model->come->gf_user_name->GF_ACCOUNT;} ?>&nbsp;&nbsp;
						<a href="../qmdd2018/index.php?r=userlist/update&id=<?php echo $model->gf_id?>"><input type="button" name="会员信息" value="会员信息" style='padding: 2px 10px 2px 10px'></a>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'ZSXM'); ?>：</th>
                    <td colspan="3">
						<?php if($model->come->gf_user_name!=null){echo $model->come->gf_user_name->ZSXM;} ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'project_id'); ?>：</th>
                    <td colspan="3">
                     	<?php if($model->come->project_list!=null){echo $model->come->project_list->project_name;} ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'type_id'); ?>：</th>
                    <td colspan="3">
                        <?php echo $model->come->type_name; ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'qua_id'); ?>：</th>
                    <td colspan="3">
                         <?php 
                            if($model->come->base_code_qua!=null){$ce=ServicerCertificate::model()->find('id='.$model->come->base_code_qua->fater_id);}else{$ce='';}
                            if(!empty($ce))echo $ce->f_name.'-'.$model->come->person_name; 
                         ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'person_code'); ?>：</th>
                    <td colspan="3">
                     	<?php echo $model->come->person_code; ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'person_pic'); ?>：</th>
                    <td colspan="3">
                        <?php $basepath=BasePath::model()->getPath(199);$picprefix='';

                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME;}?>
                        <?php if($model->come->person_pic!=''){?>
                            <div class="upload_img fl" id="upload_pic_CommentList_person_pic">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->come->person_pic;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->come->person_pic;?>" width="100"></a></div>
                        <?php }?>
                        <?php echo $form->error($model, 'person_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
				
				<tr>
                    <th class="detail-hd" style="text-align: right;"><?php echo $form->labelEx($model, 'get_score'); ?>：</th>
                    <td colspan="3" style="font: bold;font-size: 36px; color: #EF5510;">
                     	<?php echo  $model->come->get_score ?>
                    </td>
                </tr>
                <?php echo $form->hiddenField($model, 'state'); ?>
                <?php if($model->state==371){?>
				<tr>
					<th class="detail-hd" style="text-align: right">可执行操作：</th>
					<td colspan="3">
                        <button id="tongguo" onclick="submitType='tongguo'" class="btn btn-blue" type="submit">确认</button>
                         <button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
                <?php }?>
			</table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->