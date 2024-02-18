<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table border="1" cellspacing="1" cellpadding="0" class="product_publish_content" style="width:100%;margin-bottom:10px;">
                    <tr> 
                        <td style="text-align:center;padding:15px;" width="15%"><?php echo $form->labelEx($model, 'communication_news_title'); ?></td> 
                        <td style="padding:15px;"  width="35%" id="d_gf_name"><?php echo $form->textField($model, 'communication_news_title', array('class' => 'input-text')); ?></td> 
                        <td style="text-align:center;padding:15px;"  width="15%"><?php echo $form->labelEx($model, 'type'); ?></td>
                        <td style="padding:15px;"  id="dcom_real_sex"><?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(847), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?></td>
                        
                    </tr>
                    <tr>
                        <td style="text-align:center;padding:15px;"  width="15%"><?php echo $form->labelEx($model, 'communication_gfaccount'); ?></td>
                        <td style="padding:15px;"  width="35%" id="d_gf_name"><?php echo $form->textField($model, 'communication_gfaccount', array('class' => 'input-text')); ?></td> 
                        <td style="text-align:center;padding:15px;" ><?php echo $form->labelEx($model, 'communication_gfnick'); ?></td>
                        <td style="padding:15px;"  width="35%" id="d_gf_name"><?php echo $form->textField($model, 'communication_gfnick', array('class' => 'input-text')); ?></td>    
                    </tr>
                    <tr> 
                        
                        <td style="text-align:center;padding:15px;"  width="15%"><?php echo $form->labelEx($model, 'communication_type'); ?></td>
                        <td style="padding:15px;"  id="dcom_real_sex"><?php echo $form->dropDownList($model, 'communication_type', Chtml::listData(BaseCode::model()->getCode(853), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?></td>
                        <td style="text-align:center;padding:15px;" width="15%"></td> 
                        <td style="padding:15px;"  width="35%" id="d_gf_name"></td> 
                        
                    </tr>
                    <tr>
                        <td style="text-align:center;padding:15px;"  width="15%"><?php echo $form->labelEx($model, 'communication_content'); ?></td>
                        <td colspan="3"  style="padding:15px;"  width="35%" id="d_gf_name"><?php echo $form->textField($model, 'communication_content', array('class' => 'input-text')); ?></td> 
                            
                    </tr>
                    <tr  style="text-align:center;">
                        
                        <td><?php echo $form->labelEx($model, 'evaluate_img_url'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'evaluate_img_url', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(190);$picprefix='';

                            if($basepath!=null){ $picprefix=$basepath->F_CODENAME;}?>
                            <?php if($model->evaluate_img_url!=''){?>
                             <div class="upload_img fl" id="upload_pic_CommentList_evaluate_img_url">
                             <a href="<?php echo $basepath->F_WWWPATH.$model->evaluate_img_url;?>" target="_blank">
                             <img src="<?php echo $basepath->F_WWWPATH.$model->evaluate_img_url;?>" width="100"></a></div>
                             <?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_evaluate_img_url','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'evaluate_img_url', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr> 
                        
                        <td style="text-align:center;padding:15px;"  width="15%"><?php echo $form->labelEx($model, 'if_dispay'); ?></td>
                        <td style="padding:15px;"  id="dcom_real_sex"><?php echo $form->radioButtonList($model, 'if_dispay', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?></td>
                        <td style="text-align:center;padding:15px;" width="15%"><?php echo $form->labelEx($model, 'communication_praise'); ?></td> 
                        <td style="padding:15px;"  width="35%" id="d_gf_name"><?php echo $form->textField($model, 'communication_praise',  array('class'=>'text-input')); ?></td> 
                        
                    </tr>
                    
                    <table border="1" cellspacing="1" cellpadding="0" style="width:100%" class="product_publish_content" ><!--提交成功后，管理人员类型登录显示-->
                        <tr>
                          <td style="padding:15px;"  colspan="4" style="background:#efefef;">管理员操作</td>
                        </tr>
                        <tr>
                            <td style="text-align:center;padding:15px;" ><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                            <td  style="padding:15px;" colspan="3">         
                             <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' ,'value'=>'')); ?></textarea>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:15px;" >可执行操作</td>
                            <td style="padding:15px;"  colspan="3">
                              <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            </td>
                        </tr>
                        <tr>
                          <td style="padding:15px;"  colspan="4" style="background:#fafafa;">操作记录</td>
                        </tr>
                        <tr>
                            <th style="padding:15px;" ><?php echo $form->labelEx($model, 'state_time'); ?></th>
                            <th style="padding:15px;" ><?php echo $form->labelEx($model, 'state_qmddid'); ?></th>
                            <th style="padding:15px;" ><?php echo $form->labelEx($model, 'state_name'); ?></th>
                            <th style="padding:15px;" ><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></th>
                        </tr>
                        <tr>
                            
                            <td style="padding:15px;"  id="d_reasons_time" width="20%"><?php echo $model->state_time; ?></td>     
                            <td style="padding:15px;"  id="d_reasons_adminID" width="20%"><?php echo $model->state_qmddid; ?></td>
                            <td style="padding:15px;"  id="d_state" width="20%"><?php echo $model->state_name; ?></td>
                            <td style="padding:15px;"  id="d_reasons_for_failure"><?php echo $model->reasons_for_failure; ?></td> 
                        </tr>
                    </table>
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
    var $ClubMemberList_member_project_id=$('#ClubMemberList_member_project_id');
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
                    $ClubMemberList_member_project_id.val($.dialog.data('project_id')).trigger('blur');
                    $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                }
            }
        });
    });
    // 选择单位
    var $club_box=$('#club_box');
    var $ClubMemberList_club_id=$('#ClubMemberList_club_id');
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
                    $ClubMemberList_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });


});
</script> 

