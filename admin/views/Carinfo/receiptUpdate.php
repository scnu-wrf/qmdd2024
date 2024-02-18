   
   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>收货信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('update', array('id'=>$model->id));?>');"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
     
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>  
            <table>
                <tr>
                  <td><?php echo $form->labelEx($model, 'rec_name'); ?></td>
                  <td colspan="3"><?php echo $form->textField($model, 'rec_name', array('class' => 'input-text')); ?></td>
                </tr>            
                <tr>
                  <td><?php echo $form->labelEx($model, 'rec_address'); ?></td>
                  <td colspan="3"><?php echo $form->textField($model, 'rec_address', array('class' => 'input-text')); ?></td>
                </tr> 
                <tr>
                  <td><?php echo $form->labelEx($model, 'rec_phone'); ?></td>
                  <td colspan="3"><?php echo $form->textField($model, 'rec_phone', array('class' => 'input-text')); ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'best_delivery_time'); ?></td>
                    <td colspan="3">
                            <?php echo $form->dropDownList($model, 'best_delivery_time', Chtml::listData(BaseCode::model()->getCode(477), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    </td>
                </tr>
            </table>
            <div class="box-detail-submit"><?php //echo show_shenhe_box(array('baocun'=>'保存'));?><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back('<?php echo $this->createUrl('update', array('id'=>$model->id));?>');">取消</button></div>
            <?php $this->endWidget(); ?>
    
    </div><!--box-detail end-->
    
</div><!--box end-->
