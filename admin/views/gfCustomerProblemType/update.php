<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(empty($model->id)) {?>添加业务类型<?php }else{?>编辑业务类型<?php }?></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
	<div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
		<div class="box-detail-bd">
			<table>
                <tr>
                    <td><?php echo $form->labelEx($model, 'name'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'name', array('class' => 'input-text')); ?><?php echo $form->error($model,'name'); ?>
					</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'fater_id'); ?></td>
                    <td>
						<?php $fater_list=GfCustomerProblemType::model()->findAll("fater_id is null");; echo $form->dropDownList($model, 'fater_id', Chtml::listData($fater_list, 'id', 'name'), array('prompt'=>'请选择')); ?>
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
