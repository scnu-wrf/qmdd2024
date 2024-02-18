<?php
    $s1 = 'f_id,F_NAME';
    $s2 = BaseCode::model()->getCode(383);
    // $s2 = BaseCode::model()->findAll('f_id in(209,210,501,502,1164,1165)');
    $arr = toArray($s2,$s1);
    $fee=QmddServerType::model()->findAll();
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》服务者登记 》登记服务者 》<?php echo empty($model->id) ? '添加' : '详情'; ?></h1>
        <span class="back">
            <a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div>
    <div class="box-content">
        <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="detail" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">服务资源详情表</td>
                </tr>
                <tr>
                	<td>编码</td>
                	<td colspan="3"><?php echo $model->t_code.$model->f_ucode ; ?></td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 't_server_type_id'); ?>：</td>
                    <td style="width:85%;" colspan="3">
                        <?php echo $form->dropDownList($model,'t_server_type_id',CHtml::listData(QmddServerType::model()->findAll(),'id','t_name'), array('prompt'=>'请选择','onchange'=>'changeType(this);')); ?>
                        <?php echo $form->error($model, 't_server_type_id', $htmlOptions = array()); ?>
                    </td>
                    <!-- <td style="width:15%;"><?php //echo $form->labelEx($model, 't_code'); ?>：</td>
                    <td style="width:35%;">
                        <?php //echo $form->textField($model, 't_code', array('class' => 'input-text')); ?>
                        <?php //echo $form->error($model, 't_code', $htmlOptions = array()); ?>
                    </td> -->
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'f_uname'); ?>：</td>
                    <td style="width:35%;">
                        <?php echo $form->textField($model, 'f_uname', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'f_uname', $htmlOptions = array()); ?>
                    </td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'f_ucode'); ?>：</td>
                    <td style="width:35%;">
                        <?php echo $form->textField($model, 'f_ucode', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'f_ucode', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr id="service_type" style="display:none;">
                    <td><?php echo $form->labelEx($model,'service_type'); ?></td>
                    <td colspan="3">
                        <?php echo $form->dropDownList($model, 'service_type', CHtml::listData(ClubType::model()->findAll('left(f_ctcode,3)="U25" and f_level=2 '), 'id', 'f_ctname'), array('prompt'=>'请选择')); ?>
                        <br>
                        <span>注：设置服务类型为“服务者”时，可自定义服务类别或选择服务者类型</span>
                    </td>
                </tr>
            </table>
            <table class="mt15 detail" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">前端展示设置</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'tn_icon'); ?>：</td>
                    <td style="width:35%;" id="dpic_game_small_pic">
                        <?php echo $form->hiddenField($model, 'tn_icon', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(246);$picprefix='';
                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->tn_icon!=''){?>
                        <div class="upload_img fl" id="upload_pic_QmddServerUsertype_tn_icon">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->tn_icon;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->tn_icon;?>" width="100"></a></div>
                            <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_tn_icon','<?php echo $picprefix;?>');</script>
                    </td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'tn_click_icon'); ?>：</td>
                    <td style="width:35%;" id="dpic_game_small_pic">
                        <?php echo $form->hiddenField($model, 'tn_click_icon', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(250);$picprefix='';
                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->tn_click_icon!=''){?>
                        <div class="upload_img fl" id="upload_pic_QmddServerUsertype_tn_click_icon">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->tn_click_icon;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->tn_click_icon;?>" width="100"></a></div>
                            <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_tn_click_icon','<?php echo $picprefix;?>');</script>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'tn_web_icon'); ?>：</td>
                    <td id="dpic_game_small_pic">
                        <?php echo $form->hiddenField($model, 'tn_web_icon', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(251);$picprefix='';
                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->tn_web_icon!=''){?>
                        <div class="upload_img fl" id="upload_pic_QmddServerUsertype_tn_web_icon">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->tn_web_icon;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->tn_web_icon;?>" width="100"></a></div>
                            <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_tn_web_icon','<?php echo $picprefix;?>');</script>
                    </td>
                    <td><?php echo $form->labelEx($model, 'tn_web_click_icon'); ?>：</td>
                    <td id="dpic_game_small_pic">
                        <?php echo $form->hiddenField($model, 'tn_web_click_icon', array('class' => 'input-text fl')); ?>
                        <?php $basepath=BasePath::model()->getPath(252);$picprefix='';
                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->tn_web_click_icon!=''){?>
                        <div class="upload_img fl" id="upload_pic_QmddServerUsertype_tn_web_click_icon">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->tn_web_click_icon;?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$model->tn_web_click_icon;?>" width="100"></a></div>
                            <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_tn_web_click_icon','<?php echo $picprefix;?>');</script>
                    </td>
                </tr>
                <tr>      
                    <td><?php echo $form->labelEx($model, 'display'); ?></td>
                    <td colspan="3">
                    	<?php echo $form->radioButtonList($model, 'display', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'display', $htmlOptions = array()); ?>
                    </td> 
                </tr>
                <tr>
                    <td width="15%">可执行操作：</td>
                    <td width="35%" colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->
<script>
    $(function(){
        changeType($("#QmddServerUsertype_t_server_type_id"));
    })

    function changeType(op){
        if($(op).val()==2){
            $('#service_type').show();
        }
        else{
            $('#service_type').hide();
        }
    }

    // 删除已添加项目
    function fnDeleteProject(event){
        $(event).parent().remove();
        fnUpdateClub($(this).parent().attr("data_id"));
    };

    // 推荐到单位更新、删除
    var $project_box=$('#project_box');
    var $QmddServerUsertype_project_ids=$('#QmddServerUsertype_project_ids');
    function fnUpdateClub(){
        var arr=[];
        $project_box.find('span').each(function(){
            arr.push($(this).attr('data_id'));
        });
        $QmddServerUsertype_project_ids.val(we.implode(',', arr));
    };
    var $project_box=$('#project_box');
    var QmddServerUsertype_project_ids=$("#QmddServerUsertype_project_ids").val();
    $('#project_add_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')==-1){
                    var boxnum=$.dialog.data('project_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#project_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data_id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></div>');
                            fnUpdateClub(); 
                        }
                    }
                }
            }
        });
    });
</script>