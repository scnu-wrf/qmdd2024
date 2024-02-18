<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加类别详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-table">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'code'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'code', array('class' => 'input-text', 'style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'code', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'title'); ?>：</th>
                    <td>
                        <?php echo $form->textField($model, 'title', array('class' => 'input-text', 'style'=>'width:150px;')); ?>
                        <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'type'); ?>：</th>
                    
                    <td>
                            <?php echo $form->dropDownList($model, 'type', Chtml::listData(BaseCode::model()->getCode(402), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'type', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th class="detail-hd"><?php echo $form->labelEx($model, 'project_id'); ?>：</th>
                    <td>
                        <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box">
                               <?php if($model->project_list!=null){?><span class="label-box"><?php echo $model->project_list->project_name;?></span><?php }else{?>
                                <?php ?><span class="label-box" style="display:inline-block;width:20px;"></span><?php }?>
                            </span>
                            <input id="project_select_btn" class="btn" type="button" value="选择">
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'if_certificate'); ?>：</th>
                    <td>
                            <?php echo $form->dropDownList($model, 'if_certificate', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'if_certificate', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'rules'); ?>：</th>
                    <td>
                            <?php echo $form->dropDownList($model, 'rules', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'rules', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <th><?php echo $form->labelEx($model, 'club_id'); ?>：</th>
                    <td>
                         <span id="club_box"><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span></span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                    </td>
                </tr>
               <tr>
                        <td><?php echo $form->labelEx($model, 'rules_description_temp'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'rules_description_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_rules_description_temp', '<?php echo get_class($model);?>[rules_description_temp]');</script>
                            <?php echo $form->error($model, 'rules_description_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                <tr>
                <tr>
                    <th>&nbsp;</th>
                    <td>
                        <button class="btn btn-blue" type="submit">保存</button>
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
var project_id=0;



$(function(){
    
    // 选择项目
    var $project_box=$('#project_box');
    var $GfPartnerMemberSet_project_id=$('#GfPartnerMemberSet_project_id');
    $('#project_select_btn').on('click', function(){
		var club_id=$('#GfPartnerMemberSet_club_id').val();
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project_list");?>&club_id='+club_id,{
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
                    $GfPartnerMemberSet_project_id.val($.dialog.data('project_id')).trigger('blur');
                    $project_box.html('<span class="label-box">'+$.dialog.data('project_title')+'</span>');
                }
            }
        });
    });


});
</script>