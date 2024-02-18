<div class="box">
    <div class="box-title c"><h1>当前界面：会员 》龙虎会员管理 》资质置换龙虎积分 》详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
			<table class="detail" border="0" style="width:65%">
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'gf_account'); ?>：</th>
                    <td colspan="3">
						<?php if($model->gf_user_name!=null){echo $model->gf_user_name->GF_ACCOUNT;} ?>&nbsp;&nbsp;
						<a href="../qmdd2018/index.php?r=gfUser1/update&id=<?php echo $model->get_score_gfid?>"><input type="button" name="会员信息" value="会员信息" style='padding: 2px 10px 2px 10px'></a>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'zsxm'); ?>：</th>
                    <td colspan="3">
						<?php if($model->gf_user_name!=null){echo $model->gf_user_name->ZSXM;} ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'get_score_project_id'); ?>：</th>
                    <td colspan="3">
                     	<?php if($model->project_list!=null){echo $model->project_list->project_name;} ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'type_id'); ?>：</th>
                    <td colspan="3">
                        <?php echo $model->type_name; ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'qua_id'); ?>：</th>
                    <td colspan="3">
                         <?php 
                            if($model->base_code_qua!=null){$ce=ServicerCertificate::model()->find('id='.$model->base_code_qua->fater_id);}else{$ce='';}
                            if(!empty($ce))echo $ce->f_name.'-'.$model->person_name; 
                         ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'person_code'); ?>：</th>
                    <td colspan="3">
                     	<?php echo $model->person_code; ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'person_pic'); ?>：</th>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'person_pic', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(199);$picprefix='';

                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME;}?>
                        <?php if($model->person_pic!=''){?>
                            <div class="upload_img fl" id="upload_pic_CommentList_person_pic">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->person_pic;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->person_pic;?>" width="100"></a></div>
                            <?php }?>
                        <!-- <script>we.uploadpic('<?php //echo get_class($model);?>person_pic','<?php //echo $picprefix;?>');</script> -->
                        <?php echo $form->error($model, 'person_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
				
				<tr>
                    <th class="detail-hd" style="text-align: right"><?php echo $form->labelEx($model, 'uDate'); ?>：</th>
                    <td colspan="3">
                     	<?php echo $model->uDate; ?>
                    </td>
                </tr>
				<tr>
                    <th class="detail-hd" style="text-align: right;"><?php echo $form->labelEx($model, 'get_score'); ?>：</th>
                    <td colspan="3" style="font: bold;font-size: 36px; color: #EF5510;">
                     	<?php echo  $model->get_score ?>
                    </td>
                </tr>
                <?php if($model->state==371){?>
				<tr>
					<th class="detail-hd" style="text-align: right">可执行操作：</th>
					<td colspan="3">
						 <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                         <button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
                <?php }?>
				<tr>
                    <th class="detail-hd" style="text-align: right">操作备注：</th>
                    <td colspan="3">
						<?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
					</td>
                </tr>
				<tr>
                    <td class="detail-hd" rowspan="2" style="text-align: right;padding:0;">操作备注：</t'd>
                    <td width="100px;">操作时间</td>
                    <td width="100px;">管理员</td>
                    <td width="100px;">操作内容</td>
                </tr>
				<tr>
                    <td><?php echo $model->state_time; ?></td>
                    <td><?php echo $model->state_qmddname; ?></td>
                    <td><?php echo $model->state_name; ?></td>
                </tr>
			</table>
           
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->