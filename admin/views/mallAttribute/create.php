<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加属性</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
           <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">   
  <?php echo $form->hiddenField($model, 'parent', array('class' => 'input-text','value'=>$_REQUEST['p_id'])); ?>       
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'attr_name'); ?>：</th>
                    <td>
                       <?php echo $form->textField($model, 'attr_name', array('class' => 'input-text','style'=>'width:200px;')); ?>
                      <?php echo $form->error($model, 'attr_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'attr_value'); ?>：</th>
                    <td>
                       <?php echo $form->textField($model, 'attr_value', array('class' => 'input-text','style'=>'width:200px;')); ?>
                      <?php echo $form->error($model, 'attr_value', $htmlOptions = array()); ?>
                    </td>
                </tr>
                
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'attr_type'); ?>：</th>
                    <td>
                            <?php echo $form->dropDownList($model, 'attr_type', Chtml::listData(BaseCode::model()->getAttrtype(), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'attr_type', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'if_del'); ?>：</th>
                    <td>
                            <?php echo $form->dropDownList($model, 'if_del', Chtml::listData(BaseCode::model()->getCode(508), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'if_del', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->

