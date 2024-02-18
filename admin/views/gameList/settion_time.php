<script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/static/admin/js/jquery.yiiactiveform.js"></script>
<div class="box">
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <div style="display:block;" class="box-detail-tab-item">
                    <table style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="3">赛事时间设置</td>
                            <?php echo $form->hiddenField($model,'id'); //echo $form->error($model,'id',$htmlOptions = array()); ?>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model,'Signup_date1') ?></td>
                            <td><?php echo $form->textField($model,'Signup_date',array('class'=>'input-text')); ?></td>
                            <td><?php echo $form->textField($model,'Signup_date_end',array('class'=>'input-text')); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model,'effective_time') ?></td>
                            <td colspan="3"><?php echo $form->textField($model,'effective_time',array('class'=>'input-text','style'=>'width: 43.3%;')); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model,'game_time2') ?></td>
                            <td><?php echo $form->textField($model,'game_time',array('class'=>'input-text')); ?></td>
                            <td><?php echo $form->textField($model,'game_time_end',array('class'=>'input-text')); ?></td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model,'dispay_time1') ?></td>
                            <td><?php echo $form->textField($model,'dispay_star_time',array('class'=>'input-text')); ?></td>
                            <td><?php echo $form->textField($model,'dispay_end_time',array('class'=>'input-text')); ?></td>
                        </tr>
                        <tr style="text-align:center;">
                            <td colspan="3">
                                <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        <?php $this->endWidget();?>
    </div>
</div>
<script>
    $('body').on('click','.input-text', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
    $(function(){
        $('#GameList_effective_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'GameList_Signup_date_end\')}'});});
    })
</script>
<script type="text/javascript">
    /*<![CDATA[*/
    jQuery(function($) {
        jQuery('#active-form').yiiactiveform({'validateOnSubmit':true,'afterValidate':function(form,data,hasError){
            if(!hasError||(submitType=="baocun")){
                we.overlay("show");
                $.ajax({
                    type:"post",
                    url:form.attr("action"),
                    data:form.serialize()+"&submitType="+submitType,
                    dataType:"json",
                    success:function(d){
                        if(d.status==1){
                            we.success(d.msg, d.redirect);
                            setTimeout(function() {
                                parent.location.reload();
                            }, 1500);
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
        }})
    });
    /*]]>*/
</script>