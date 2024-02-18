<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/admin/js/jquery.yiiactiveform.js"></script>
<div class="box">
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" style="table-layout:auto;">

                    <tr class="table-title">
                        <td colspan="2"><?php echo '详情介绍'; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'introduct_temp', array('class' => 'input-text')); ?>
                            <script>
                                we.editor('<?php echo get_class($model);?>_introduct_temp', '<?php echo get_class($model);?>[introduct_temp]');
                                <?php if($model->check_state==372) echo 'var ue=UE.getEditor("editor_QmddServerPerson_introduct_temp");ue.ready(function() {ue.setDisabled();})'; ?>
                            </script>
                            <?php echo $form->error($model, 'introduct_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 15%; background-color: #efefef;">操作</td>
                        <td>(功能未完善，暂不可用)
                            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            <!-- <button type="button" class="btn" onclick="clickBack();">取消</button> -->
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
            'id':'QmddServerPerson_introduct',
            'inputID':'QmddServerPerson_introduct',
            'errorID':'QmddServerPerson_introduct_em_',
            'model':'QmddServerPerson',
            'name':'introduct',
            'enableAjaxValidation':false,
            'status':1
        }],'errorCss':'error'});
    });
/*]]>*/
</script>