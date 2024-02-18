<?php //var_dump($_GET)?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>供应商入驻经营类目设置</h1><span class="back"><a href="javascript:;" class="btn" onclick="getBack();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'ct_code'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'ct_code', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'ct_code', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'ct_mark'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'ct_mark', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'ct_mark', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'ct_name'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'ct_name', array('class' => 'input-text','style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'ct_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <?php if(!empty($_GET['faterId'])){
                    echo $form->hiddenField($model, 'fater_id', array('class' => 'input-text','value' => $_GET['faterId']));
                } ?>
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