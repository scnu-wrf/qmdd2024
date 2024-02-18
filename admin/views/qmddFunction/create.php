
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>创建功能菜单列表</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-content">
        <div class="box-table">
            <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'function_title'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'function_title', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'function_title', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'function_icon'); ?>：</th>
                    <td>
                        <?php echo $form->hiddenField($model, 'function_icon', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(175);$picprefix='';
                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->function_icon!=''){?>
                        <div class="upload_img fl" id="upload_pic_news_pic">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->function_icon;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->function_icon;?>" width="100"></a>
                        </div>
                        <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_function_icon','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'function_icon', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'function_click_icon'); ?>：</th>
                    <td>
                        <?php echo $form->hiddenField($model, 'function_click_icon', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(228);$picprefix='';
                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->function_click_icon!=''){?>
                        <div class="upload_img fl" id="upload_pic_news_pic">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->function_click_icon;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->function_click_icon;?>" width="100"></a>
                        </div>
                        <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_function_click_icon','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'function_click_icon', $htmlOptions = array()); ?>
                    </td>
                </tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'icon_size'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'icon_size', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <div class="msg">*（单位：像素），如10*10</div>
                        <?php echo $form->error($model, 'icon_size', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'android_hrer'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'android_hrer', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'android_hrer', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'ios_href'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'ios_href', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'ios_href', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'web_href'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'web_href', array('class' => 'input-text', 'style' => 'width:300px;')); ?>
                        <?php echo $form->error($model, 'web_href', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作：</td>
                    <td>
                    	<button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div>
    </div>
</div>