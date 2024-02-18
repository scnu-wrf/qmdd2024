
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>更新文章</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
                    <table class="mt15">
                        <tr style="width:100%;">
                            <td style="width:15%;"><?php echo $form->labelEx($model, 'title'); ?>：</td>
                            <td style="width:35;">
                                <?php echo $form->textField($model, 'title', array('class' => 'input-text', 'style'=>'widtd:300px;')); ?>
                                <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                            </td>
                            <td style="width:15%;"><?php echo $form->labelEx($model, 'cat_id'); ?></td>
                            <td style="width:35%;">
                                <!--<?php echo $form->dropDownList($model, 'cat_id', Chtml::listData(AutoFilterSet::model()->getTypename('attribute'), 'id', 'name'), array('prompt'=>'请选择')); ?>-->
                                <!--<?php echo $form->dropDownList($model, 'cat_id', Chtml::listData(MallProductsTypeSname::model()->getAll(), 'id', 'sn_name'), array('prompt'=>'请选择')); ?>-->
                                <?php echo $form->dropDownList($model, 'cat_id', Chtml::listData(GfArticleCat::model()->getAll(),'id','cat_name'), array('prompt'=>'请选择')); ?>
                                <?php echo $form->error($model, 'cat_id', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'is_open'); ?>：</td>
                            <td>
                                <?php echo $form->radioButtonList($model, 'is_open', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'keywords'); ?>：</td>
                            <td>
                                <?php echo $form->textField($model, 'keywords', array('class' => 'input-text', 'style'=>'widtd:300px;')); ?>
                                <?php echo $form->error($model, 'keywords', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'description'); ?>：</td>
                            <td>
                                <?php echo $form->textArea($model,'description', array('class' => 'input-text', 'maxlength'=>'30' )); ?>
                                <p>*简短介绍，最多可输入30个字符，含数字特殊符号：-&nbsp;/&nbsp;\&nbsp;等；</p>
                                <?php echo $form->error($model, 'description', $htmlOptions = array()); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'link'); ?>：</td>
                            <td>
                                <?php echo $form->textField($model, 'link', array('class' => 'input-text', 'style'=>'widtd:300px;')); ?>
                                <?php echo $form->error($model, 'link', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'material_id'); ?></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'material_id', array('class' => 'input-text')); ?>
                                <div class="c">
                                    <span id="video_box" class="fl"><?php if($model->gf_material!=null){?><span class="label-box"><a href="<?php echo $model->gf_material->v_file_path.$model->gf_material->v_name;?>" target="_blank"><?php if($model->gf_material->v_title!=''){ echo $model->gf_material->v_title; }else{ echo $model->gf_material->v_name; }?></a></span><?php }?></span>
                                    <div class="upload fl"><script>var materialVideoUrl='<?php echo $this->createUrl('gfMaterial/upvideo');?>';we.materialVideo(function(data){ $('#GfArticle_material_id').val(data.id).trigger('blur'); $('#video_box').html('<span class="label-box">'+data.name+'</span>'); },61,24,'上传');</script></div>
                                    <input style="margin-left:5px;" id="video_select_btn" class="btn fl" type="button" value="选择视频">
                                </div>
                                <?php echo $form->error($model, 'material_id', $htmlOptions = array()); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'file_url'); ?>：</td>
                            <td>
                                <?php echo $form->textField($model, 'file_url', array('class' => 'input-text', 'style'=>'widtd:300px;')); ?>
                                <div class="msg">例如：http://upload.gf41.net:60/</div>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'content'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'content_temp', array('class' => 'input-text')); ?>
                                <script>we.editor('<?php echo get_class($model);?>_content_temp', '<?php echo get_class($model);?>[content_temp]');</script>
                                <?php echo $form->error($model, 'content_temp', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td>可执行操作：</td>
                            <td colspan="3">
                                <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            </td>
                        </tr>
                    </table>
                <?php $this->endWidget(); ?>
            </div>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
    // 选择视频
    var $video_box=$('#video_box');
    var $GfArticle_material_id=$('#GfArticle_material_id');
    $('#video_select_btn').on('click', function(){
        $.dialog.data('video_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/material", array('type'=>253));?>',{
            id:'shipin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $GfArticle_material_id.val($.dialog.data('material_id')).trigger('blur');
                    $video_box.html('<span class="label-box">'+$.dialog.data('material_title')+'</span>');
                }
            }
        });
    });
</script>