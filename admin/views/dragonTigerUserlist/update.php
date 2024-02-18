<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
           
            
            <table border="1" cellspacing="1" cellpadding="0" class="product_publish_content" style="width:100%;margin-bottom:10px;">
                <form enctype="multipart/form-data" action="" method="post" id="theForm_price" name="theForm_price">
                    <tr>
                        <th style="text-align:center;" class="detail-hd"><?php echo $form->labelEx($model, 'check_number'); ?>：</th>
                        <td colspan="3" style="padding:20px;">
                            <?php echo $model->check_number; ?>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;" class="detail-hd"><?php echo $form->labelEx($model, 'order_num'); ?>：</th>
                        <td style="padding:20px;">
                            <?php echo $model->order_num; ?>
                        </td>
                        <th style="text-align:center;"  class="detail-hd"><?php echo $form->labelEx($model, 'project_name'); ?>：</th>
                        <td style="padding:20px;">
                            <?php echo $model->project_name; ?>
                                
                        </td>  
                    </tr>
                    <tr>
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'gf_account'); ?>：</th>
                        <td style="padding:20px;">
                            <?php echo $model->gf_account; ?>
                        </td> 
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'gf_name'); ?>：</th>
                        <td style="padding:20px;">
                            <?php echo $model->gf_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'member_type_name'); ?></th>
                        <td style="padding:20px;">
                            <?php echo $model->member_type_name; ?>
                        </td>
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'grade_name'); ?></th>
                        <td style="padding:20px;">
                            <?php echo $model->grade_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'add_time'); ?></th>
                        <td style="padding:20px;">
                            <?php echo $model->add_time; ?>
                        </td>
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'end_time'); ?></th>
                        <td style="padding:20px;">
                            <?php echo $model->end_time; ?>
                        </td>
                    </tr>
                    <tr>
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'if_pass_name'); ?>：</th>
                        <td style="padding:20px;">
                            <?php echo $model->if_pass_name; ?>
                            
                        </td>
                        <th style="text-align:center;" ><?php echo $form->labelEx($model, 'achievement'); ?>：</th>
                        <td style="padding:20px;">
                            <?php echo $model->achievement; ?>
                            
                        </td>
                    </tr>
                </form>
            </table>
            <table border="1" cellspacing="1" cellpadding="0" class="product_publish_content" style="width:100%;margin-bottom:20px;">
                <tr>
                  <td colspan="5" style="padding:20px;">考核详细</td>
                </tr>
                <tr>
                    <td style="padding:20px;">考试时间</td>            
                    <td style="padding:20px;">题目</td>
                    <td style="padding:20px;">类型</td>
                    <td style="padding:20px;">是否合格</td>
                    <td style="padding:20px;">小题得分</td>
                </tr>
                <?php 
                if(!empty($model->useranswer)) foreach($model->useranswer as $v){ 
                ?>
                <tr>
                    <td style='text-align: center;'><?php echo $v->questions_subject_code; ?></td>
                    <td style='text-align: center;'><?php echo $v->subject; ?></td>
                    <td style='text-align: center;'><?php echo $v->type_name; ?></td>
                    <td style='text-align: center;'><?php echo $v->whether_right; ?></td>
                    <td style='text-align: center;'><?php echo $v->earned_score; ?></td>
                </tr>
                <?php  } ?>
                
            </table>

            <table border="1" cellspacing="1" cellpadding="0" class="product_publish_content" style="width:100%;">
                <tr>
                  <td colspan="4" style="padding:20px;">操作记录</td>
                </tr>
                <tr>
                    <td style="padding:20px;">考试时间</td>            
                    <td style="padding:20px;">用时</td>
                    <td style="padding:20px;">成绩</td>
                    <td style="padding:20px;">是否合格</td> 
                </tr>
                <tr>
                    <td style="padding:20px;" id="d_udate"></td>            
                    <td style="padding:20px;"></td><!-- 计算所得 -->
                    <td style="padding:20px;" id="d_achievement"></td>
                    <td style="padding:20px;" id="d_if_pass"></td> 
                </tr>
                <!--tr>
                    <td colspan="4" style="text-align:center;padding:20px;">
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr-->
            </table>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');

var project_id=<?php echo $model->project_id;?>;

    $('#DragonTigerUserlist_add_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
    $('#DragonTigerUserlist_end_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});

$(function(){


    // 选择项目
    var $project_box=$('#project_box');
    var $DragonTigerUserlist_project_id=$('#DragonTigerUserlist_project_id');
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
                    $DragonTigerUserlist_project_id.val($.dialog.data('project_id')).trigger('blur');
                    $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                }
            }
        });
    });


});
</script>
  </div><!--box-detail end-->
</div><!--box end-->

