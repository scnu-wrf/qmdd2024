<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="show_menu">学员申请信息</div>
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table border="1" cellspacing="1" cellpadding="0" class="product_publish_content" style="width:100%;margin-bottom:10px;">
                    <tr style="text-align:center;"> 
                        <td style="padding:15px;" width="15%"><?php echo $form->labelEx($model, 'gf_account'); ?></td> 
                        <td width="35%" id="dr_gf_account" ><?php echo $model->gf_account; ?></td>
                        <td style="padding:15px;"  width="15%"><?php echo $form->labelEx($model, 'zsxm'); ?></td>
                        <td width="35%" id="d_gf_name"><?php echo $model->zsxm; ?></td> 
                    </tr>
                    <tr style="text-align:center;">
                        
                        <td style="padding:15px;" class="detail-hd"><?php echo $form->labelEx($model, 'member_project_id'); ?>：</td>
                        <td style="padding:15px;" >
                            <?php echo $model->project_name; ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'real_sex'); ?></td>
                        <td id="dcom_real_sex">
                            <?php if($model->base_code_sex!=null){?>
                                <?php echo $model->base_code_sex->F_NAME; ?>
                            <?php }else{?>
                               <span  style="display:inline-block;width:20px;"></span>
                            <?php }?> 
                        </td>   
                    </tr>
                    <tr style="text-align:center;"> 
                        <td style="padding:15px;"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td>
                            <?php echo $model->club_list->club_name;?>
                        </td>
                        <td style="padding:15px;" ><?php echo $form->labelEx($model, 'agree_club'); ?></td> 
                        <td id="dcom_agree_club"><?php echo $model->base_code_agree->F_NAME; ?></td> 
                    </tr>
                    <tr style="text-align:center;">
                        <td style="padding:15px;" ><?php echo $form->labelEx($model, 'member_level_register_time'); ?></td>
                        <td id="d_member_level_register_time"><?php echo $model->member_level_register_time; ?></td>  
                        <td><?php echo $form->labelEx($model, 'start_time'); ?></td>
                        <td id="d_start_time"><?php echo $model->start_time; ?></td>
                    </tr>
                    <tr style="text-align:center;">  
                        <td style="padding:15px;" ><?php echo $form->labelEx($model, 'unbund_time'); ?></td>
                        <td id="d_unbund_time"><?php echo $model->unbund_time; ?></td>
                        <td><?php echo $form->labelEx($model, 'end_time'); ?></td>
                        <td id="d_end_time"><?php echo $model->end_time; ?></td>
                    </tr>
                    <tr style="text-align:center;"> 
                        <td style="padding:15px;" ><?php echo $form->labelEx($model, 'member_content'); ?></td>
                        <td colspan="3"  id="d_member_content"><?php echo  $model->member_content; ?></td> 
                    </tr>
                    <tr style="text-align:center;"> 
                        <td style="padding:15px;" ><?php echo $form->labelEx($model, 'remove_reason'); ?></td>
                        <td colspan="3"  id="d_remove_reason"><?php echo $form->textArea($model, 'remove_reason', array('class' => 'input-text','style'=>'margin:15px;')); ?></td> 
                    </tr>
                    <tr style="text-align:center;">
                        <td colspan="4" style="text-align:center;padding:20px;">
                            <!-- <button class="btn btn-blue" type="submit">保存</button> -->
                            <button onclick="submitType='agree'" class="btn btn-blue" type="submit">同意加入</button>
                            <button onclick="submitType='disagree'" class="btn btn-blue" type="submit">不同意加入</button>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
var club_id=0;
var project_id=0;
$('#ClubMember_member_level_register_time').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#ClubMember_start_time').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#ClubMember_unbund_time').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#ClubMember_end_time').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});


$(function(){

    // 添加项目
     var $project_box=$('#project_box');
    var $ClubMember_member_project_id=$('#ClubMember_member_project_id');
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
                    $ClubMember_member_project_id.val($.dialog.data('project_id')).trigger('blur');
                    $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                }
            }
        });
    });
    // 选择单位
    var $club_box=$('#club_box');
    var $ClubMember_club_id=$('#ClubMember_club_id');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club", array('partnership_type'=>16));?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('club_id')>0){
                    club_id=$.dialog.data('club_id');
                    $ClubMember_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });


});
</script> 

