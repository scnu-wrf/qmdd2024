<div class="box">
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr>
                    <td width="30%"><?php echo $form->labelEx($model,'playback_is'); ?></td>
                    <td width="70%">
                        <?php echo $form->radioButtonList($model, 'playback_is', array(1 => '开', 0 => '关'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'playback_is'); ?>
                            
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'online_users'); ?></td>
                    <td><?php echo $form->textField($model, 'online_users', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'online_users', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" style="text-align:center;"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">确定</button></td>
                </tr>
               
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
