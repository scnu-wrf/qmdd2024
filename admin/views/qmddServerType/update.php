
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务类型列表</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 't_code'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 't_code', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 't_code', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 't_name'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 't_name', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 't_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <!-- <tr>
                    <td class="detail-hd"><?php //echo $form->labelEx($model, 't_eday'); ?>：</td>
                    <td>
                        <?php //echo $form->textField($model, 't_eday', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php //echo $form->error($model, 't_eday', $htmlOptions = array()); ?>
                    </td>
                </tr> -->
                <!-- <tr>
                    <td class="detail-hd"><?php //echo $form->labelEx($model, 't_count'); ?>：</td>
                    <td>
                        <?php //echo $form->textField($model, 't_count', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php //echo $form->error($model, 't_count', $htmlOptions = array()); ?>
                    </td>
                </tr> -->
                <!-- <tr>
                    <td class="detail-hd"><?php //echo $form->labelEx($model, 't_timeset'); ?>：</td>
                    <td>
                        <?php //echo $form->textField($model, 't_timeset', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php //echo $form->error($model, 't_timeset', $htmlOptions = array()); ?>
                    </td>
                </tr> -->
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