<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加省份列表</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'CODE'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'CODE', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'CODE', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'level'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'level', array('class' => 'input-text', 'style'=>'width:200px;','value'=>$_REQUEST['level'],'readonly'=>'readonly')); ?>
                        <?php echo $form->error($model, 'level', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'country_code'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'country_code', array('class' => 'input-text', 'style'=>'width:200px;','value'=>$_REQUEST['country_code'],'readonly'=>'readonly')); ?>
                        <?php echo $form->error($model, 'country_code', $htmlOptions = array()); ?>
                    </td>
                </tr>
                        <?php echo $form->hiddenField($model, 'country_id', array('class' => 'input-text', 'style'=>'width:200px;','value'=>$_REQUEST['country_id'],'readonly'=>'readonly')); ?>
                    
                <?php if($_REQUEST['pid']==0){?>
                
                        <?php echo $form->hiddenField($model, 'upper_region', array('class' => 'input-text', 'style'=>'width:200px;','readonly'=>'readonly')); ?>
                    
                
                <?php }else{?>
                    
                        <?php echo $form->hiddenField($model, 'upper_region', array('class' => 'input-text', 'style'=>'width:200px;','value'=>$_REQUEST['pid'],'readonly'=>'readonly')); ?>
                    
                <?php }?>
                <tr>
                    <th><?php echo $form->labelEx($model, 'region_name_e'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'region_name_e', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'region_name_e', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'region_name_c'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'region_name_c', array('class' => 'input-text', 'style'=>'width:200px;')); ?>
                        <?php echo $form->error($model, 'region_name_c', $htmlOptions = array()); ?>
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
