<div class="box">
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4"><?php echo (empty($model->id)) ? '添加场馆配套及积分' : '设置场馆配套及积分'; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->LabelEx($model,'facilities_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'facilities_name',array('class'=>'input-text')); ?>
                            <?php echo $form->error($model,'facilities_name',$htmlOption=array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->LabelEx($model,'credit'); ?></td>
                        <td><?php echo $form->textField($model,'credit',array('class'=>'input-text')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->LabelEx($model,'facilities_pic'); ?></td>
                        <td>
                            <?php
                                echo $form->hiddenField($model, 'facilities_pic', array('class' => 'input-text fl'));
                                echo $form->error($model,'facilities_pic',$htmlOption=array());
                                $basepath = BasePath::model()->getPath(303);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->facilities_pic!=''){
                            ?>
                                <div class="upload_img fl" id="upload_pic_GfSiteCredit_facilities_pic">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->facilities_pic;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->facilities_pic;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_facilities_pic','<?php echo $picprefix;?>');</script>
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

    $('#baocun').on('click',function(){
        setTimeout(() => {
            $.dialog.data('id',1);
            $.dialog.close();
        }, 1500);
    })
</script>
<!-- 弹窗方法，没有更好的关闭方法时，暂时用这个 -->
<script type="text/javascript">
//     /*<![CDATA[*/
//     jQuery(function($) {
//         jQuery('#active-form').yiiactiveform({'validateOnSubmit':true,'afterValidate':function(form,data,hasError){
//             if(!hasError||(submitType=="==")){
//                 we.overlay("show");
//                 $.ajax({
//                     type:"post",
//                     url:form.attr("action"),
//                     data:form.serialize()+"&submitType="+submitType,
//                     dataType:"json",
//                     success:function(d){
//                         if(d.status==1){
//                             we.success(d.msg, d.redirect);
//                             setTimeout(() => {
//                                 $.dialog.data('id',1);
//                                 $.dialog.close();
//                             }, 1000);
//                         }else{
//                             we.error(d.msg, d.redirect);
//                         }
//                     }
//                 });
//             }else{
//                 var html="";
//                 var items = [];
//                 for(item in data){
//                     items.push(item);
//                     html+="<p>"+data[item][0]+"</p>";
//                 }
//                 we.msg("minus", html);
//                 var $item = $("#"+items[0]);
//                 $item.focus();
//                 $(window).scrollTop($item.offset().top-10);
//             }
//         },'attributes':[{
//             'id':'GfSiteCredit_facilities_name',
//             'inputID':'GfSiteCredit_facilities_name',
//             'errorID':'GfSiteCredit_facilities_name_em_',
//             'model':'GfSiteCredit',
//             'name':'facilities_name',
//             'enableAjaxValidation':false,
//             'status':1,
//             // 'clientValidation':function(value, messages, attribute){}
//         }],'errorCss':'error'});
//     });
// /*]]>*/
</script>