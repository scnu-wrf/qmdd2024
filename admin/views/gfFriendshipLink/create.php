<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑录入属性</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'title'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'title', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'logo'); ?>：</th>
                    <td>
                        <!--<input type="file" />-->
                        <!--<?php echo $form->textField($model, 'logo', array('class' => 'input-text', 'style'=>'width:100px;height:50px;')); ?>-->
                        <?php echo $form->hiddenField($model, 'logo', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(196);$picprefix='';
                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->logo!=''){?>
                        <div class="upload_img fl" id="upload_pic_news_pic">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100"></a>
                        </div>
                        <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_logo','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'logo', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'link_address'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'link_address', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'link_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'email'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'email', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'introduction'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'introduction', array('class' => 'input-text', 'style'=>'width:300px;')); ?>
                        <?php echo $form->error($model, 'introduction', $htmlOptions = array()); ?>
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
<!--<script>

$(function(){
    var $start_time=$('#add_time');
    // var $end_time=$('#end_date');
    $start_time.on('click', function(){
        // var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'add_time\')}'});
    });
});

</script>-->