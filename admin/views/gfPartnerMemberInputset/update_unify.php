<?php 
    if(!empty($model->type)){
        $_REQUEST['type']=$model->type;
    }
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑录入属性</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?=$_REQUEST['type']==403?'current':'';?>"><a href="<?php echo $this->createUrl('create_unify',array('type'=>403));?>">个人</a></li>
                <li class="<?=$_REQUEST['type']==404?'current':'';?>"><a href="<?php echo $this->createUrl('create_unify',array('type'=>404));?>">单位</a></li>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr>
                        <td><?php echo $form->labelEx($model, 'attr_name'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'attr_name', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'attr_name', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'attr_unit'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'attr_unit', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'attr_unit', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'attr_input_type'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'attr_input_type', Chtml::listData(BaseCode::model()->getCode(676), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','change'=>'onchange(this);')); ?>
                            <?php echo $form->error($model, 'attr_input_type'); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'sort_order'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'sort_order', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'sort_order', $htmlOptions = array()); ?>
                            <br><span style="color:#666;">*值越大越往前排</span>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td><?php //echo $form->labelEx($model, 'type'); ?></td>
                        <td colspan="3">
                            <?php //echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php //echo $form->error($model, 'type', $htmlOptions = array()); ?>
                        </td>
                    </tr> -->
                    <?php echo $form->hiddenField($model, 'type',array('value' =>$_REQUEST['type'])); ?>
                    <?php echo $form->hiddenField($model, 'attr_values_lsit'); ?>
                    <?php echo $form->hiddenField($model, 'program_list'); ?>
                    <tr id="attr_values" style="<?php if($model->attr_input_type==678 || $model->attr_input_type==720) {?><?php }else{?>display:none;<?php }?>">
                        <td>可选属性值 <span class="required">*</span></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'attr_values_lsit'); ?>
                            <?php echo $form->hiddenField($model, 'program_list'); ?>
                            <table id="program_list" class="showinfo">
                                <tr class="table-title">
                                    <td width="25%">属性值</td>
                                    <td width="25%">操作</td>
                                </tr>
                                <?php 
                                    $model->id=empty($model->id) ?0 : $model->id;
                                    $programs = GfPartnerMemberValues::model()->findAll('set_input_id='.$model->id);
                                    $num=0;
                                    if(!empty($programs))foreach($programs as $v){
                                ?>
                                    <tr class="add_btn_list">
                                        <td><input onchange="fnUpdateProgram();" class="input-text" name="program_list[<?php echo $v->id;?>][attr_values]" value="<?php echo $v->attr_values;?>"></td>
                                        <td style="text-align:left;">
                                            <input onclick="fnAddProgram();" class="btn" type="button" value="添加行">
                                            <input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除行">
                                            <input name="program_list[<?php echo $v->id;?>][id]" type="hidden" value="<?php echo $v->id;?>">
                                        </td>
                                    </tr>
                                <?php }else{?>  
                                    <tr class="add_btn_list">
                                        <td><input onchange="fnUpdateProgram();" class="input-text" name="program_list[<?php echo $num;?>][attr_values]"></td>
                                        <td style="text-align:left;">
                                            <input onclick="fnAddProgram();" class="btn" type="button" value="添加行">
                                            <input name="program_list[<?php echo $num;?>][id]" type="hidden" value="null">
                                        </td>
                                    </tr>
                                <?php $num=$num+1; }?>
                            </table>
                            <?php echo $form->error($model, 'attr_values_lsit', $htmlOptions = array()); ?>
                            </br><p>录入方式为:</br>1.多值添加多行，后面的单位用英文冒号”:“隔开，如：一年级会员:元/月</p>
                            <p>注："从列表中选择"与"手工录入+下拉选择"才需要填写录入方式</p>
                        </td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'adminid', array('value' =>get_session('admin_id'))); ?>
                    <tr>
                        <td colspan="4" align='center'>
                            <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-tab-item end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var num=<?php echo $num;?>;
    // 添加删除属性值
    var num = num+1;
    var $program_list=$('#program_list');
    var $attr_values_lsit=$('#GfPartnerMemberInputset_attr_values_lsit');
    function fnAddProgram(){
        var add_h =
            '<tr>'+
                '<td><input onchange="fnUpdateProgram();" class="input-text" name="program_list['+num+'][attr_values]"></td>'+
                '<td style="text-align:left;">'+
                    '<input onclick="fnAddProgram();" class="btn" type="button" value="添加行">&nbsp;'+
                    '<input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除行">'+
                    '<input name="program_list['+num+'][id]" type="hidden" value="null">'+
                '</td>'+
            '</tr>';
        $program_list.append(add_h);
        fnUpdateProgram();
        num++;
    };

    var fnDeleteProgram=function(op){
        $(op).parent().parent().remove();
        var tab_add=$('.add_btn_list').length;
        if(tab_add<1){
            fnAddProgram();
        }
        fnUpdateProgram();
    };

    var fnUpdateProgram=function(op){
        var arr=[];
        var id;var isEmpty=true;
        $program_list.find('.input-text').each(function(){
            if($(this).val()!=''){
                isEmpty=false;
                //return false;
            }
        });
        if(!isEmpty){
            $attr_values_lsit.val('1').trigger('blur');
        }else{
            $attr_values_lsit.val('').trigger('blur');
        }
    };

    $(function(){
        $("input[type='radio']").change(function(){
            var radio=$("input[type='radio']:checked").val();
            if(radio==678 || radio==720){
                $('#attr_values').show();
            }
            else{
                $('#attr_values').hide();
            }
        })
    })
</script>