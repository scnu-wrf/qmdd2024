<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>编辑</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
   <div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            
            <table class="mt15">
            	<tr class="table-title">
                    <td colspan="4" >题目信息</td>
                    <?php echo $form->hiddenField($model, 'questions_id', array('class' => 'input-text','value'=>$_REQUEST['pid'])); ?>
                </tr>
                <tr > 
                    <td style="width:10%"><?php echo $form->labelEx($model, 'subject_code'); ?></td> 
                    <td style="width:35%" id="subject_code" >
                        <?php echo $model->subject_code; ?>
                    </td>
                    <td style="width:10%"><?php echo $form->labelEx($model, 'type'); ?></td>
                    <td style="width:35%" id="member_type"><?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(527), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?></td> 
                </tr> 
                <tr > 
                    <td style="width:10%"><?php echo $form->labelEx($model, 'subject'); ?></td> 
                    <td style="width:35%" id="subject" >
                        <?php echo $form->textArea($model, 'subject', array('class' => 'input-text')); ?>
                            
                        <?php echo $form->error($model, 'subject', $htmlOptions = array()); ?>
                    </td>
                    <td style="width:10%"><?php echo $form->labelEx($model, 'subject_score'); ?></td>
                    <td style="width:35%" id="subject_score"><?php echo $form->textField($model, 'subject_score', array('class' => 'input-text')); ?></td> 
                </tr>
                
        	</table>
            <div class="box-detail-submit">
              <button class="btn btn-blue" type="submit">保存</button>
              <button class="btn" type="button" onclick="we.back();">取消</button>
            <!--php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value' =>$_REQUEST['club_id'])); ?-->
            </div>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
// 添加删除更新节目
var $program_list=$('#program_list');
var $DragonTigerAnswer_answer_list=$('#DragonTigerAnswer_answer_list');
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
        $DragonTigerAnswer_answer_list.val('1').trigger('blur');
    }else{
        $DragonTigerAnswer_answer_list.val('').trigger('blur');
    }
};
</script>
