
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商品销售方式</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'sale_name'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'sale_name', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'sale_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'sale_namea'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'sale_namea', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'sale_namea', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'sale_nameb'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'sale_nameb', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'sale_nameb', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>可执行操作：</td>
                    <td colspan="3">
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <!--<?php echo show_shenhe_box(array('baocun'=>'保存')); ?>-->
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->