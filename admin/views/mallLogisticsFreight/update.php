<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑运费列表</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                
            <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'send_area_id'); ?>：</th>
                    <td>
                            <?php echo $form->dropDownList($model, 'send_area_id', Chtml::listData(TRegion::model()->getLevel(), 'id', 'region_name_c'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'send_area_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'get_area_id'); ?></th>
                <td>
                    <?php echo $form->dropDownList($model, 'get_area_id', Chtml::listData(TRegion::model()->getLevel(), 'id', 'region_name_c'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'get_area_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'first_weight'); ?></th>
                <td>
                    <?php echo $form->textField($model, 'first_weight', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                    <span>kg</span>
                    <?php echo $form->error($model, 'first_weight', $htmlOptions = array()); ?>
                </td>
                
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'next_weight'); ?></th>
                <td>
                    <?php echo $form->textField($model, 'next_weight', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                    <span>kg</span>
                    <?php echo $form->error($model, 'next_weight', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'first_pay'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'first_pay', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                    <span>元</span>
                    <?php echo $form->error($model, 'first_pay', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo $form->labelEx($model, 'next_pay'); ?></th>
                <td>
                    <?php echo $form->textField($model, 'next_pay', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                    <span>元</span>
                    <?php echo $form->error($model, 'next_pay', $htmlOptions = array()); ?>
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
