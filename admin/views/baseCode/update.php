
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>公共部类型设置</h1><span class="back"><a href="javascript:;" class="btn" onclick="getBack();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'F_TCODE'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'F_TCODE', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'F_TCODE', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'F_CODE'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'F_CODE', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'F_CODE', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'F_TYPECODE'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'F_TYPECODE', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'F_TYPECODE', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'F_NAME'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'F_NAME', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'F_NAME', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'F_SHORTNAME'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'F_SHORTNAME', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'F_SHORTNAME', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <?php if(!empty($faterId)){echo $form->hiddenField($model, 'fater_id', array('class' => 'input-text','value' => $faterId));}if($_GET['r']=='baseCode/create'){echo $form->hiddenField($model, 'if_oper', array('class' => 'input-text','value' => 1));} ?>
            </table>
            <table>
                <tr>
                    <td class="detail-hd">可执行操作：</td>
                    <td colspan="3">
                        <!-- <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button> -->
                        <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                        <button class="btn" type="button" onclick="getBack();">取消</button>
                    </td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->
<script>
    function getBack(){
        history.go(-1);
    }
</script>