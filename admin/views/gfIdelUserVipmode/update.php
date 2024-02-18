<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)) {?>添加VIP类型<?php }else{?>编辑VIP类型<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
	<div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<div class="box-detail-bd">
			<table>
                <tr>
                    <td><?php echo $form->labelEx($model, 'f_name'); ?></td>
                    <td><?php echo $form->textField($model, 'f_name', array('class' => 'input-text')); ?><?php echo $form->error($model,'f_name'); ?></td>
                    <td><?php echo $form->labelEx($model, 'f_mode'); ?></td>
                    <td><?php echo $form->textField($model, 'f_mode', array('class' => 'input-text')); ?><?php echo $form->hiddenField($model, 'f_len', array('class' => 'input-text fl')); ?><?php echo $form->error($model,'f_mode'); ?></td>
                </tr>   
                <tr>
                    <td><?php echo $form->labelEx($model, 'f_lvevl'); ?></td>
                    <td><?php echo $form->dropDownList($model, 'f_lvevl', Chtml::listData(GfIdelUserNumberLevel::model()->findAll(), 'id', 'level_name'), array('prompt'=>'请选择')); ?><?php echo $form->error($model,'f_lvevl'); ?></td>
                    <td><?php echo $form->labelEx($model, 'f_rule'); ?></td>
                    <td><?php echo $form->textField($model, 'f_rule', array('class' => 'input-text')); ?><?php echo $form->error($model,'f_rule'); ?></td>
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
	$("#GfIdelUserVipmode_f_mode").on("input",function(){
		$("#GfIdelUserVipmode_f_len").val($(this).val().length);
	})
</script>