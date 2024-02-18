<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑水印</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
                        we.overlay("show");
                        $.ajax({
                            type:"post",
                            url:form.attr("action"),
                            data:form.serialize()+"&submitType="+submitType,
                            dataType:"json",
                            success:function(d){
                                if(d.status==1){
                                    we.success(d.msg, d.redirect);
                                }else{
                                    we.error(d.msg, d.redirect);
                                }
                            }
                        });
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
            ),
        ));
        ?>
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
                    <div class="upload_img fl" id="upload_pic_GfWatermark_w_pic"><a href="<?php echo $model->w_file_path.$model->w_pic;?>" target="_blank"><img src="<?php echo $model->w_file_path.$model->w_pic;?>" width="100"></a></div>
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
                    <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?>
                    <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php }?></span>
                    <input id="club_select_btn" class="btn" type="button" value="选择单位">
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
                <td><div class="waterdemo"><img id="waterdemo_pic" src="<?php echo $model->w_file_path.$model->w_pic;?>" width="50"></div></td>
            </tr>
        </table>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
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
    
    // 选择发布单位
    var $club_box=$('#club_box');
    var $GfWatermark_club_id=$('#GfWatermark_club_id');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club");?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('club_id')>0){
                    club_id=$.dialog.data('club_id');
                    $GfWatermark_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
});
</script>