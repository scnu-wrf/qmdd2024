<?php
    $_REQUEST['fater_id'] = empty($_REQUEST['fater_id']) ? '' : $_REQUEST['fater_id'];
?>
<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：服务者》服务者设置》资质证登记管理》<?=empty($model->f_id)?'添加':'编辑';?></span></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                        <?php echo $form->hiddenField($model, 'fater_id', array('class' => 'input-text','value' => $_REQUEST['fater_id'])); ?>
                    </tr>
                    <tr>
                        <td width="150px">
                            <?php echo $form->labelEx($model, 'f_code'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'f_code', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_code', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'f_name'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'f_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'f_type_name'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'f_type_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'f_type_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'F_COL1'); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'F_COL1', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'F_COL1', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="3">
                            <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div> <!--box-detail-tab-item end-->
        </div> <!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div> <!--box-detail end-->
</div> <!--box end-->