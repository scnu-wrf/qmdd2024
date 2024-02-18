<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加水印</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'w_title'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'w_title', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'w_title', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'w_pic'); ?></td>
                <td>
                    <?php $basepath=BasePath::model()->getPath(181);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php echo $form->hiddenField($model, 'w_pic'); ?>
                    <?php echo $form->hiddenField($model, 'w_file_path', array('value'=>$basepath->F_WWWPATH)); ?>
                    <div class="upload_img fl" id="upload_pic_GfWatermark_w_pic"><img src="<?php echo SITE_PATH;?>/static/admin/img/noupload.jpg" width="100"></div>
                    <div style="margin-left:10px;width:244px;" class="fl">
                        <div>注意：为了最佳视觉效果，水印应为透明图片png格式，且大小不超超过200kb，高宽不超过200*200像素。如果需要更换水印，请修改默认图样。</div>
                        <script>we.uploadpic('<?php echo get_class($model);?>_w_pic','<?php echo $picprefix;?>', '', '', function(data){$('#GfWatermark_w_pic').val(data.savename);$('#upload_pic_GfWatermark_w_pic').html('<a href="'+data.allpath+'" target="_blank"><img src="'+data.allpath+'" width="100"></a>');$('#waterdemo_pic').attr('src',data.allpath);});</script>
                    </div>
                    <?php echo $form->error($model, 'w_pic', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                <td>
                    <span id="club_box"><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span></span>
                    <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'watermark_area'); ?></td>
                <td>
                    <?php echo $form->radioButtonList($model, 'watermark_area', Chtml::listData(BaseCode::model()->getCode(698), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <div style="margin-top:10px;">
                        <span><?php echo $form->labelEx($model, 'dispay_x_area'); ?> <?php echo $form->textField($model, 'dispay_x_area', array('class' => 'input-text', 'style'=>'width:48px;', 'value'=>'5')); ?> %</span>
                        <span style="margin-left:20px;"><?php echo $form->labelEx($model, 'dispay_y_area'); ?> <?php echo $form->textField($model, 'dispay_y_area', array('class' => 'input-text', 'style'=>'width:48px;', 'value'=>'10')); ?> %</span>
                    </div>
                    <?php echo $form->error($model, 'watermark_area', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td>效果预览</td>
                <td><div class="waterdemo"><img id="waterdemo_pic" src="<?php echo SITE_PATH;?>/static/admin/img/noupload.jpg" width="50"></div></td>
            </tr>
        </table>
        <div class="box-detail-submit">
		<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
        <button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
$(function(){
    var $waterdemo_pic=$('#waterdemo_pic');
    var $GfWatermark_watermark_area=$('#GfWatermark_watermark_area');
    var $GfWatermark_watermark_area_item=$('#GfWatermark_watermark_area .input-check');
    var $GfWatermark_dispay_x_area=$('#GfWatermark_dispay_x_area');
    var $GfWatermark_dispay_y_area=$('#GfWatermark_dispay_y_area');
    var cssX='left',cssY='top';
    var fnUpdateWater=function(){
        var id=$GfWatermark_watermark_area.find('input:checked').val();
        if(id==699){
            cssX='left';
            cssY='top';
        }else if(id==700){
            cssX='right';
            cssY='top';
        }else if(id==701){
            cssX='left';
            cssY='bottom';
        }if(id==702){
            cssX='right';
            cssY='bottom';
        }
        $waterdemo_pic.attr('style', cssX+':'+$GfWatermark_dispay_x_area.val()+'%;'+cssY+':'+$GfWatermark_dispay_y_area.val()+'%;');
    };
    fnUpdateWater();
    $GfWatermark_watermark_area_item.on('click', function(){
        fnUpdateWater();
    });
    $GfWatermark_dispay_x_area.on('change', function(){
        $waterdemo_pic.attr('style', cssX+':'+$GfWatermark_dispay_x_area.val()+'%;'+cssY+':'+$GfWatermark_dispay_y_area.val()+'%;');
    });
    $GfWatermark_dispay_y_area.on('change', function(){
        $waterdemo_pic.attr('style', cssX+':'+$GfWatermark_dispay_x_area.val()+'%;'+cssY+':'+$GfWatermark_dispay_y_area.val()+'%;');
    });
});
</script>