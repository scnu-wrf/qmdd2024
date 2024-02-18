<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务类型列表</h1><span class="back"><a href="javascript:;" class="btn" onclick="getBack();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'base_name'); ?>：</td>
                    <td><?php echo $form->dropDownList($model, 'base_f_id', Chtml::listData(BaseCode::model()->getCode(736), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'base_f_id', $htmlOptions = array()); ?></td>
                </tr>
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model, 'type'); ?>：</td>
                    <td>
                        <?php echo $form->textField($model, 'type', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table>
                <tr>
                    <td>可执行操作：</td>
                    <td colspan="3">
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <!--<?php echo show_shenhe_box(array('baocun'=>'保存')); ?>-->
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