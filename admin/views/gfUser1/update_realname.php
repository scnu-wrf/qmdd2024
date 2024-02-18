<table width="100%" style="table-layout:auto; margin-top:10px;">
<?php if($_REQUEST['passed']==372){?>
    <tr class="table-title">
        <td colspan="4">实名信息</td>
    </tr>
    <tr>
        <td width="15%"><?php echo $form->labelEx($model, 'ZSXM'); ?></td>
        <td width="35%">
            <?php echo $form->textField($model, 'ZSXM', array('class' => 'input-text')); ?>
            <?php echo $form->error($model, 'ZSXM', $htmlOptions = array()); ?>
        </td>
        <td>
            <?php echo $form->labelEx($model, 'real_sex'); ?>
            <?php // echo $form->labelEx($model, 'SEX'); ?>
        </td>
        <td>
            <?php // echo $form->dropDownList($model, 'SEX', Chtml::listData(array(array('value' => '1', 'name' => '男'), array('value' => '0', 'name' => '女')), 'value', 'name'), array('prompt'=>'请选择')); ?>
            <?php // echo $form->dropDownList($model, 'real_sex', '"205":"\u7537","207":"\u5973"', array('prompt'=>'请选择')); ?>
            <?php echo $form->dropDownList($model, 'real_sex', Chtml::listData(BaseCode::model()->getSex(204), 'f_id', 'F_NAME'), array('prompt' => '请选择')); ?>
            <?php // echo $form->error($model, 'SEX', $htmlOptions = array()); ?>
            <?php echo $form->error($model, 'real_sex', $htmlOptions = array()); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'real_birthday'); ?></td>
        <td>
            <?php echo $form->textField($model, 'real_birthday', array('class' => 'input-text')); ?>
            <?php echo $form->error($model, 'real_birthday', $htmlOptions = array()); ?>
        </td>
        <td><?php echo $form->labelEx($model, 'native'); ?></td>
        <td>
            <?php echo $form->textField($model, 'native', array('class' => 'input-text')); ?>
            <?php echo $form->error($model, 'native', $htmlOptions = array()); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'id_card_type'); ?></td>
        <td>
            <?php echo $form->dropDownList($model, 'id_card_type', Chtml::listData(BaseCode::model()->getCode(842), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
            <?php echo $form->error($model, 'id_card_type', $htmlOptions = array()); ?>
        </td>
        <td><?php echo $form->labelEx($model, 'id_card'); ?></td>
        <td>
            <?php echo $form->textField($model, 'id_card', array('class' => 'input-text')); ?>
            <?php echo $form->error($model, 'id_card', $htmlOptions = array()); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo $form->labelEx($model, 'id_card_validity_start'); ?></td>
        <td colspan="3">
            <?php echo $form->textField($model, 'id_card_validity_start', array('class' => 'input-text', 'style' => 'width: 180px;', 'placeholder'=>'开始日期')); ?>
            <?php echo ' - '.$form->textField($model, 'id_card_validity_end', array('class' => 'input-text', 'style' => 'width: 180px;', 'placeholder'=>'截止日期')); ?>
            <?php echo $form->error($model, 'id_card_validity_start', $htmlOptions = array()); ?>
            <?php echo $form->error($model, 'id_card_validity_end', $htmlOptions = array()); ?>
        </td>
    </tr>
    <tr>
        <td class="id_card_pic1"><?php echo $form->labelEx($model, 'id_card_pic'); ?> <span class="required">*</span></td>
        <td class="id_card_pic2" colspan="3">
            <div style="float: left; display: block; margin-right: 100px;">
                <?php echo $form->hiddenField($model, 'id_card_pic', array('class' => 'input-text fl')); ?>
                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                <?php if($model->id_card_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_pic;?>" width="70"></a></div><?php }?>
                <script>we.uploadpic('<?php echo get_class($model);?>_id_card_pic', '<?php echo $picprefix;?>', '', '', '', '', '上传正面');</script>
                <?php echo $form->error($model, 'id_card_pic', $htmlOptions = array()); ?>
            </div>
            <div style="margin-left: 85px;" class="id_pic">
                <?php echo $form->hiddenField($model, 'id_pic', array('class' => 'input-text fl')); ?>
                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                <?php if($model->id_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->id_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_pic;?>" width="70"></a></div><?php }?>
                <script>we.uploadpic('<?php echo get_class($model);?>_id_pic', '<?php echo $picprefix;?>', '', '', '', '', '上传反面');</script>
                <?php echo $form->error($model, 'id_pic', $htmlOptions = array()); ?>
            </div>
        </td>
    </tr>
    <table width="100%" class="mt15" style="table-layout:auto;">
        <tr>
            <td width="15%">操作</td>
            <td colspan="3">
                <?php
                    echo show_shenhe_box(array('tongguo'=>'审核通过')).'&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                ?>
            </td>
        </tr>
    </table>
<?php }else{ ?>
    <table width="100%" class="mt15" style="table-layout:auto;">
        <tr>
            <td width="15%">操作</td>
            <td colspan="3">
                <?php
                    echo show_shenhe_box(array('quxiao'=>'注册')).'&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                ?>
            </td>
        </tr>
    </table>
<?php } ?>
</table>
<?php echo $form->hiddenField($model, 'logon_way', array('class' => 'input-text','value' => 1375)); ?>
<?php echo $form->hiddenField($model, 'logon_way_name', array('class' => 'input-text','value' => '后台添加')); ?>