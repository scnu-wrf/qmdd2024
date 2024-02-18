
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i><?php echo $model->id; ?>详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
                    <table class="mt15">
                        <tr>
                            <td><?php echo $form->labelEx($model, 'service_id'); ?>：</td>
                            <td>
                                <?php echo $form->textField($model, 'service_id', array('class' => 'input-text', 'style'=>'widtd:300px;')); ?>
                                <?php echo $form->error($model, 'service_id', $htmlOptions = array()); ?>
                            <td><?php echo $form->labelEx($model, 'service_id'); ?>：</td>
                            <td>
                                <?php echo $form->textField($model, 'service_id', array('class' => 'input-text', 'style'=>'widtd:300px;')); ?>
                                <?php echo $form->error($model, 'service_id', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>可执行操作：</td>
                            <td colspan="3">
                                <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            </td>
                        </tr>
                    </table>
                <?php $this->endWidget(); ?>
            </div>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
    
</script>