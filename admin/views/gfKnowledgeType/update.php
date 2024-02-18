<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)) {?>添加客服类型设置<?php }else{?>编辑客服类型设置<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
	<div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<div class="box-detail-bd">
		<?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text',"value"=>get_session("club_id"))); ?>
			<table>
				<tr>
                    <td><?php echo $form->labelEx($model, 'problem_title'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'problem_title', array('class' => 'input-text','style'=>'width:200px;')); ?><?php echo $form->error($model, 'problem_title'); ?>
					</td>
                </tr>
				<tr>
                    <td><?php echo $form->labelEx($model, 'reply_content'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'reply_content', array('class' => 'input-text','style'=>'width:200px;')); ?><?php echo $form->error($model, 'reply_content'); ?>
					</td>
                </tr>
				<tr>
                    <td><?php echo $form->labelEx($model, 'keywords'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'keywords', array('class' => 'input-text','style'=>'width:200px;')); ?><?php echo $form->error($model, 'keywords'); ?>
					</td>
                </tr>
				<tr>
                    <td><?php echo $form->labelEx($model, 'type_id'); ?></td>
                    <td>
						<?php $type_list=GfKnowledgeType::model()->findAll(); 
						echo $form->dropDownList($model, 'type_id', Chtml::listData($type_list, 'id', 'title'), array('prompt'=>'请选择','style'=>'width:218px;')); ?><?php echo $form->error($model,'type_id'); ?>
					</td>
                </tr>
				<tr>
                    <td><?php echo $form->labelEx($model, 'validity_type'); ?></td>
                    <td>
						<?php $customer_service_type_list=array(array("id"=>"649","name"=>"永久"),array("id"=>"648","name"=>"自定义")); echo $form->dropDownList($model, 'validity_type', Chtml::listData($customer_service_type_list, 'id', 'name'), array('prompt'=>'请选择','style'=>'width:218px;')); ?><?php echo $form->error($model,'validity_type'); ?>
					</td>
                </tr>
            </table>
		</div><!--box-detail-bd end-->
		<div id="operate" class="mt15" style="text-align:center;">
			<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
		<?php $this->endWidget(); ?>
	</div><!--box-table end-->
</div><!--box end-->
<script>

</script>