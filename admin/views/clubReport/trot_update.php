<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-detail">
        <table id="t1">
            <tr class="table-title">
                <td colspan="4">举报人信息</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                <td><?php echo $model->gf_account; ?></td>
                <td><?php echo $form->labelEx($model, 'connect_name'); ?></td>
                <td><?php echo $model->connect_name; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'connect_number'); ?></td>
                <td><?php echo $model->connect_number; ?></td>
                <td><?php echo $form->labelEx($model, 'connect_eamil'); ?></td>
                <td><?php echo $model->connect_eamil; ?></td>
            </tr>
        </table>
        <table class="mt15">
        	<tr class="table-title">
                <td colspan="4">举报信息</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'connect_publisher_code'); ?></td>
                <td><?php echo $model->connect_publisher_code; ?></td>
                <td><?php echo $form->labelEx($model, 'connect_publisher_title'); ?></td>
                <td><?php echo $model->connect_publisher_title; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'connect_title'); ?></td>
                <td><?php echo $model->connect_title; ?></td>
                <td><?php echo $form->labelEx($model, 'report_type_id'); ?></td>
                <td><?php if(!empty($model->r_type)) echo $model->r_type->type; ?></td>
            </tr>
        </table>
        <table class="mt15">
        	<tr class="table-title">
                <td colspan="4">被侵权人信息</td>
            </tr>
            <tr>
                <td><?php $model->the_infringed_type=='403'?$n='姓名':$n='名称'; echo $n; ?></td>
                <td><?php echo $model->the_infringed_name; ?></td>
                <td><?php $model->the_infringed_type=='403'?$n2='身份证号':$n2='法人姓名'; echo $n2; ?></td>
                <td><?php echo $model->the_infringed_id_card; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'the_infringed_concat'); ?></td>
                <td><?php echo $model->the_infringed_concat; ?></td>
                <td><?php echo $form->labelEx($model, 'the_infringed_eamil'); ?></td>
                <td><?php echo $model->the_infringed_eamil; ?></td>
            </tr>
            <tr>
                <td><?php $model->the_infringed_type=='403'?$n3='身份证正反面照片':$n3='营业执照照片'; echo $n3; ?></td>
                <td colspan="3"><?php echo $model->the_infringed_concat; ?></td>
            </tr>
        </table>
        <table class="mt15">
        	<tr class="table-title">
                <td colspan="4">举报描述</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'report_detail'); ?></td>
                <td colspan="3"><?php echo $model->report_detail; ?></td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'report_pic'); ?></td>
                <td colspan="3">
                <?php echo $form->hiddenField($model, 'report_pic',array('class' => 'input-text')); ?>
                    <?php $basepath=BasePath::model()->getPath(188);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <div class="upload_img fl" id="upload_pic_report_pic">
                        <?php 
                        foreach($report_pic as $v) if($v) {?>
                        <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"></a>
                        <?php }?>
                    </div>
                </td>
            </tr>
        </table>
        <?php if($model->audit_status!=2&&$model->audit_status!=373){?>
            <table id="t2" class="mt15">
                <tr class="table-title">
                    <td colspan="4">举报处理操作</td>
                </tr>
                <!-- <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' )); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr> -->
                <tr>
                    <td width='15%'>审核状态</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                    </td>
                </tr>
            </table>
        <?php }?>
        <?php if($model->audit_status==2){?>
            <table class="showinfo">
                <tr class="table-title">
                    <th>违规信息</th>
                    <th>处理部门</th>
                    <th>处理结果</th>
                    <th>是否处理</th>
                </tr>
                <tr>
                    <td>违规内容</td>
                    <td><?php echo $form->dropDownList($model, 'service_department', Chtml::listData(Role::model()->findAll('club_id='.get_session('club_id')), 'f_id', 'f_rname'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'service_department', $htmlOptions = array()); ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'report_processing_msg_id', Chtml::listData(BaseCode::model()->getCode(1270), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'report_processing_msg_id'); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getReturn('753,755'), 'f_id', 'F_SHORTNAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'state'); ?>
                    </td>
                </tr>
                <tr>
                    <td>违规账号</td>
                    <td><?php echo $form->dropDownList($model, 'account_service_department', Chtml::listData(Role::model()->findAll('club_id='.get_session('club_id')), 'f_id', 'f_rname'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'account_service_department', $htmlOptions = array()); ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'report_processing_obj_id', Chtml::listData(BaseCode::model()->getCode(1272), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'report_processing_obj_id'); ?>
                    </td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'report_processing_obj_state', Chtml::listData(BaseCode::model()->getCode(752), 'f_id', 'F_SHORTNAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'report_processing_obj_state'); ?>
                    </td>
                </tr>
            </table>
            <!-- <?php //var_dump($_SESSION);?> -->
            <table class="mt15">
                <tr>
                    <td>可执行操作</td>
                    <td colspan="3">
                        <!-- <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button> -->
                        <?php echo show_shenhe_box(array('baocun'=>'确定')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
            <table class="showinfo">
                <tr>
                    <th>操作时间</th>
                    <th>操作人</th>
                    <th colspan="2">操作内容</th>
                </tr>
                <tr>
                    <td><?php if(isset($model->udate) ){ echo $model->udate; } ?></td>
                    <td><?php if(isset($model->admin_account)){ echo $model->admin_name->role_name.'-'.$model->admin_name->admin_gfnick; } ?></td>
                    <td colspan="2"><?php if(isset($model->auditStatusName->F_NAME)){ echo $model->auditStatusName->F_NAME; }?></td>
                    <!-- <td><?php if(isset($model->reasons_for_failure)){ echo $model->reasons_for_failure; } ?></td> -->
                </tr>
		        <?php $c_record = ClubReportRecord::model()->findAll('report_id='.$model->id); ?>
                <?php foreach($c_record as $v){?>
                    <tr>
                        <td><?php echo $v->add_time; ?></td>
                        <td><?php echo $v->connect_title; ?></td>
                        <td colspan="2">
                            <?php
                                echo $v->content; ?>
                            </td>
                    </tr>
                <?php } ?>
            </table>
        <?php }?>
         
        
    </div><!--box-detail end-->
	<?php $this->endWidget(); ?>
</div><!--box end-->
<script>
</script>
