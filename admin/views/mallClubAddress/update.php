<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑地址信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <span>单位名称：<?php if(!empty($model->club_list)){ echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?><?php } else { echo get_session('club_name');?> <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); } ?></span>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'address'); ?>：</td>
                    <td colspan="3">
                        <?php echo $form->textArea($model, 'address', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'consignee'); ?>：</td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'consignee', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'consignee', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'phone'); ?>：</td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'phone', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'phone', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'zipcode'); ?>：</td>
                    <td colspan="3">
                        <?php echo $form->textField($model, 'zipcode', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'zipcode', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td colspan="3">
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
            <?php $this->endWidget(); ?>
    </div><!--box-content end-->
</div><!--box end-->
