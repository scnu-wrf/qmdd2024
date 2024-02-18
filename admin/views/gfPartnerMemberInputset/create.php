<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑录入属性</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
            <tr>
                    <th class="detail-hd"></th>
                    <td>
                        <?php echo $form->hiddenField($model, 'set_id', array('class' => 'input-text', 'style'=>'width:100px;','value' =>$_REQUEST['pid']
)); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'attr_name'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'attr_name', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'attr_name', $htmlOptions = array()); ?>
                    </td>
                    
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'attr_unit'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'attr_unit', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'attr_unit', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"></th>
                    <td>
                            <?php echo $form->hiddenField($model, 'type', array('class' => 'input-text', 'style'=>'width:100px;','value' =>$_REQUEST['ptype']
)); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'attr_input_type'); ?>：</th>
                    <td width="35%">
                        <?php echo $form->radioButtonList($model, 'attr_input_type', Chtml::listData(BaseCode::model()->getCode(676), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'attr_input_type'); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'sort_order'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'sort_order', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                        <?php echo $form->error($model, 'sort_order', $htmlOptions = array()); ?>
                        <span style="color:#666;">*值越大越往前排</span>
                    </td>
                </tr>
                <tr>
                        <td><?php echo $form->labelEx($model, 'attr_values'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'attr_values', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                          
                            <?php echo $form->error($model, 'attr_values', $htmlOptions = array()); ?>
                            <span>*多值使用英文逗号“，“隔开，后面单位的用英文冒号”:“隔开，如：一年级会员:元/月,二年级会员:元/月</span>
                        </td>
                    </tr>
                <tr>
                    <th class="detail-hd">&nbsp;</th>
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
