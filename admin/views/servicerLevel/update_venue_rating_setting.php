<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/admin/js/jquery.yiiactiveform.js"></script>
<div class="box">
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" style="table-layout:auto;">
                    <?php
                        echo $form->hiddenField($model,'type',array('value'=>'1157'));
                        // echo $form->error($model,'type',$htmlOption = array());
                    ?>
                    <tr class="table-title">
                        <td colspan="4"><?php echo (empty($model->id)) ? '添加等级' : '等级设置'; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->LabelEx($model,'card_name1'); ?></td>
                        <td><?php echo $form->textField($model,'card_name',array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->LabelEx($model,'card_score'); ?></td>
                        <td><?php echo $form->textField($model,'card_score',array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->LabelEx($model,'card_end_score'); ?></td>
                        <td><?php echo $form->textField($model,'card_end_score',array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->LabelEx($model,'card_level_logo'); ?></td>
                        <td>
                            <?php
                                echo $form->hiddenField($model, 'card_level_logo', array('class' => 'input-text fl'));
                                echo $form->error($model,'card_level_logo',$htmlOption=array());
                                $basepath = BasePath::model()->getPath(303);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->card_level_logo!=''){
                            ?>
                                <div class="upload_img fl" id="upload_pic_GfSiteCredit_card_level_logo">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->card_level_logo;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->card_level_logo;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_card_level_logo','<?php echo $picprefix;?>');</script>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align:center;">
                            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            <button type="button" class="btn" onclick="clickBack();">取消</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<script>
    function clickBack(){
        $.dialog.data('id',0);
        $.dialog.close();
    }
</script>
<!-- 弹窗方法，没有更好的关闭方法时，暂时用这个 -->
<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {
        jQuery('#active-form').yiiactiveform({'validateOnSubmit':true,'afterValidate':function(form,data,hasError){
            if(!hasError||(submitType=="==")){
                we.overlay("show");
                $.ajax({
                    type:"post",
                    url:form.attr("action"),
                    data:form.serialize()+"&submitType="+submitType,
                    dataType:"json",
                    success:function(d){
                        if(d.status==1){
                            we.success(d.msg, d.redirect);
                            setTimeout(() => {
                                $.dialog.data('id',1);
                                $.dialog.close();
                            }, 1000);
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
        },'attributes':[{
            'id':'ServicerLevel_type',
            'inputID':'ServicerLevel_type',
            'errorID':'ServicerLevel_type_em_',
            'model':'ServicerLevel',
            'name':'type',
            'enableAjaxValidation':false,
            'status':1
        }],'errorCss':'error'});
    });
/*]]>*/
</script>