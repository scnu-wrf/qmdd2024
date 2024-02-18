<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑物流公司</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'f_code'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'f_code', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'f_code', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'f_name'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'f_name', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'f_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'f_mark'); ?>：</th>
                    <td>
                        <?php echo $form->dropDownList($model, 'f_mark', Chtml::listData(BaseCode::model()->getCode(794), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        <?php echo $form->error($model, 'f_mark', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'f_url'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'f_url', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'f_url', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'f_mobilec'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'f_mobilec', array('class' => 'input-text', 'style'=>'width:100px;','maxlength'=>11)); ?>
                        <?php echo $form->error($model, 'f_mobilec', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
