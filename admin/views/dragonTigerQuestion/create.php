<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑题库</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4" >基本信息</td>
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'member_type'); ?></td> 
                    <td width="35%" id="member_type" >
                            <?php echo $form->dropDownList($model, 'member_type', Chtml::listData(BaseCode::model()->getCode(208), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'member_type', $htmlOptions = array()); ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td width="35%" id="project_id"><?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box">
                               <?php if($model->project_list!=null){?><span class="label-box"><?php echo $model->project_list->project_name;?></span><?php }else{?>
                                <?php ?><span class="label-box" style="display:inline-block;width:20px;"></span><?php }?>
                            </span>
                            <input id="project_select_btn" class="btn" type="button" value="选择"></td> 
                </tr>  
                <tr >
                    <td width="15%"><?php echo $form->labelEx($model, 'grade'); ?></td> 
                    <td width="35%" id="grade" >
                        <?php echo $form->dropDownList($model, 'grade', Chtml::listData(MemberCard::model()->getCode(210), 'f_id', 'card_name'), array('prompt'=>'请选择')); ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'exam_time'); ?></td>
                    <td width="35%" id="exam_time"><?php echo $form->textField($model, 'exam_time', array('class' => 'input-text','style'=>'width:90%;')); ?></td> 
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'qualified_score'); ?></td>
                    <td width="35%" id="qualified_score"><?php echo $form->textField($model, 'qualified_score', array('class' => 'input-text','style'=>'width:90%;')); ?></td> 
                    <td width="15%"><?php echo $form->labelEx($model, 'questions_528type_num'); ?></td>
                    <td width="35%" id="questions_528type_num"><?php echo $form->textField($model, 'questions_528type_num', array('class' => 'input-text','style'=>'width:90%;')); ?></td> 
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'questions_529type_num'); ?></td>
                    <td width="35%" id="questions_529type_num"><?php echo $form->textField($model, 'questions_529type_num', array('class' => 'input-text','style'=>'width:90%;')); ?></td> 
                    <td width="15%"><?php echo $form->labelEx($model, 'questions_530type_num'); ?></td>
                    <td width="35%" id="questions_530type_num"><?php echo $form->textField($model, 'questions_530type_num', array('class' => 'input-text','style'=>'width:90%;')); ?></td> 
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'type'); ?></td>
                    <td width="35%" id="type"><?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(527), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?></td> 
                    <td width="15%"><?php echo $form->labelEx($model, 'subject'); ?></td>
                    <td width="35%" id="subject"><?php echo $form->textArea($model, 'subject', array('class' => 'input-text','style'=>'width:90%;')); ?></td> 
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'answer_list'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'answer_list'); ?>
                        <table id="program_list" class="showinfo" data-num="new">
                            <tr class="table-title">
                                <td width="20%">答案</td>
                                <td width="20%">答案结果</td>
                                <td width="150">操作</td>
                            </tr>
                            <?php 
                            if(!empty($programs)){?>
                            <?php foreach($programs as $v){?>
                            <tr>
                                <td><input onchange="fnUpdateProgram();" class="input-text" name="programs[<?php echo $v->id;?>][answer]" value="<?php echo $v->answer;?>"></td>
                                <td></span><select  name="programs[<?php echo $v->id;?>][answer_result]" value="<?php echo $v->answer_result; ?>">
                                    <option value="">请选择</option>
                                    <option value="532">正确</option>
                                    <option value="533">不正确</option>
                                    </select>
                                    
                                </td>
                                <td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加答案"><input onclick="fnDeleteProgram(this);" style="margin-left:10px;" class="btn" type="button" value="删除答案"></td>
                            </tr>
                            <?php }?>
                            <?php }else{?>
                            <tr>
                                <td><input onchange="fnUpdateProgram();" class="input-text" name="programs[new][answer]"></td>
                                <td><select onchange="fnUpdateProgram();" name="programs[new][answer_result]">
                                    <option value="">请选择</option>
                                    <option value="532">正确</option>
                                    <option value="533">不正确</option>
                                    </select>
                                </td>
                                <td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加答案"></td>
                            </tr>
                            <?php }?>
                        </table>
                        <?php echo $form->error($model, 'answer_list', $htmlOptions = array()); ?>
                    </td>
                </tr>

            </table>
            <div class="box-detail-submit">
              <button class="btn btn-blue" type="submit">保存</button>
              <button class="btn" type="button" onclick="we.back();">取消</button>
            <!--php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value' =>$_REQUEST['club_id'])); ?-->
            </div>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
var project_id=0;

// 添加删除更新节目
var $program_list=$('#program_list');
var $DragonTigerQuestion_answer_list=$('#DragonTigerQuestion_answer_list');
var fnAddProgram=function(){
    var num=$program_list.attr('data-num')+1;
    $program_list.append('<tr>'+
        '<td><input onchange="fnUpdateProgram();" class="input-text" name="programs['+num+'][answer]"></td>'+
        '<td><select  onchange="fnUpdateProgram();" name="programs['+num+'][answer_result]">'+
        '<option value="">请选择</option><option value="532">正确</option><option value="533">不正确</option></select></td>'+
        '<td style="text-align:left;"><input onclick="fnAddProgram();" class="btn" type="button" value="添加答案"><input onclick="fnDeleteProgram(this);" style="margin-left:10px;" class="btn" type="button" value="删除答案"></td>'+
        '</tr>');
    $program_list.attr('data-num',num);
};
var fnDeleteProgram=function(op){
    $(op).parent().parent().remove();
};
var fnUpdateProgram=function(){
    var isEmpty=true;
    $program_list.find('.input-text').each(function(){
        if($(this).val()!=''){
            isEmpty=false;
            //return false;
        }
    });
    if(!isEmpty){
        $DragonTigerQuestion_answer_list.val('1').trigger('blur');
    }else{
        $DragonTigerQuestion_answer_list.val('').trigger('blur');
    }
};

$(function(){

    $('#GfPartnerMemberApply_effective_start_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
    $('#GfPartnerMemberApply_effective_end_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
    
    // 选择项目
    var $project_box=$('#project_box');
    var $DragonTigerQuestion_project_id=$('#DragonTigerQuestion_project_id');
    $('#project_select_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('project_id')>0){
                    project_id=$.dialog.data('project_id');
                    $DragonTigerQuestion_project_id.val($.dialog.data('project_id')).trigger('blur');
                    $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                }
            }
        });
    });
    

});
</script>