
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑敏感词</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
       <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table class="table-title">
            <tr>
                <td>敏感词信息</td>
            </tr>
        </table>

        <table class="mt15">

            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'sensitive_type_name'); ?></td>
                <td width="85%">
                   <div style="display:inline;">
                       <div style="display:inline-block">
                            <?php
                            echo $form->dropDownList($model, 'sensitive_type', Chtml::listData(BaseCode::model()->getCode(1018), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); 
                            echo $form->error($model, 'sensitive_type_name', $htmlOptions = array()); ?>
                        </div>
                        <div style="display:inline-block">
                            <input style="margin-left:5px;" id="type_add_btn" class="btn" type="button" value="添加类型" >
                        </div>
                   </div>
                </td>
            </tr>


            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'sensitive_content'); ?></td>
                <td width="85%">
                        <?php echo $form->textField($model, 'sensitive_content', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'sensitive_content', $htmlOptions = array()); ?>
                </td>
            </tr>
<!-- xywh -->
        </table>


        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->

<script>
    var $type_add_btn=$('#type_add_btn');
    $type_add_btn.on('click', function(){
        $.dialog.data('f_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/sensitive");?>',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'添加敏感词类型',
            width:'50%',
            height:'90%',
            close: function () {
                 
                if($.dialog.data('f_id')>0){

                    $("<option value='"+$.dialog.data('f_id')+"'>"+$.dialog.data('F_NAME')+"</option>").appendTo("#SensitiveWords_sensitive_type");

                    $("#SensitiveWords_sensitive_type").find("option[value = '"+$.dialog.data('f_id')+"']").attr("selected",true).trigger('blur');   
                            
                }
            }
        });
    });
 
</script>

