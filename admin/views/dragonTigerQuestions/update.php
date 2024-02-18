<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>会员信息</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
   <div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            
            <table class="mt15">
            	<tr class="table-title">
                    <td colspan="4" >基本信息</td>
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'project_id'); ?></td> 
                    <td width="35%" id="project_id" >
                        <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box">
                               <?php if($model->project_list!=null){?><span class="label-box"><?php echo $model->project_list->project_name;?></span><?php }else{?>
                                <?php ?><span class="label-box" style="display:inline-block;width:20px;"></span><?php }?>
                            </span>
                            <input id="project_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'member_type'); ?></td>
                    <td width="35%" id="member_type"><?php echo $form->dropDownList($model, 'member_type', Chtml::listData(BaseCode::model()->getCode(208), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?></td> 
                </tr>  
                <tr >
                    <td width="15%"><?php echo $form->labelEx($model, 'grade'); ?></td> 
                    <td width="35%" id="grade" >
                        <?php echo $form->dropDownList($model, 'grade', Chtml::listData(MemberCard::model()->getCode(210), 'f_id', 'card_name'), array('prompt'=>'请选择')); ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'exam_time'); ?></td>
                    <td width="35%" id="exam_time"><?php echo $form->textField($model, 'exam_time', array('class' => 'input-text')); ?></td> 
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'qualified_score'); ?></td>
                    <td width="35%" id="qualified_score"><?php echo $form->textField($model, 'qualified_score', array('class' => 'input-text')); ?></td> 
                    <td width="15%"><?php echo $form->labelEx($model, 'questions_528type_num'); ?></td>
                    <td width="35%" id="questions_528type_num"><?php echo $form->textField($model, 'questions_528type_num', array('class' => 'input-text')); ?></td> 
                </tr>
                <tr > 
                    <td width="15%"><?php echo $form->labelEx($model, 'questions_529type_num'); ?></td>
                    <td width="35%" id="questions_529type_num"><?php echo $form->textField($model, 'questions_529type_num', array('class' => 'input-text')); ?></td> 
                    <td width="15%"><?php echo $form->labelEx($model, 'questions_530type_num'); ?></td>
                    <td width="35%" id="questions_530type_num"><?php echo $form->textField($model, 'questions_530type_num', array('class' => 'input-text')); ?></td> 
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
we.tab('.box-detail-tab li','.box-detail-tab-item');
var project_id=0;

$(function(){
 
    // 选择项目
    var $project_box=$('#project_box');
    var $DragonTigerQuestions_project_id=$('#DragonTigerQuestions_project_id');
    $('#project_select_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project_list");?>',{
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
                    $DragonTigerQuestions_project_id.val($.dialog.data('project_id')).trigger('blur');
                    $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                }
            }
        });
    });
    

});

</script> 

