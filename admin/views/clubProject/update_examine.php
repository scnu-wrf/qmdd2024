<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>详情</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list());?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="4">项目信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_name'); ?></td>
                        <td><?php echo $model->club_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'p_code'); ?></td>
                        <td><?php echo $model->p_code; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td><?php echo $model->project_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'add_time'); ?></td>
                        <td><?php echo $model->add_time; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'approve_state'); ?></td>
                        <td><?php echo $model->approve_state_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'valid_until'); ?></td>
                        <td><?php echo $model->valid_until; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_level'); ?></td>
                        <td><?php echo $model->level_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'project_credit'); ?></td>
                        <td><?php echo $model->project_credit; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_state'); ?></td>
                        <td><?php echo $model->state_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'auth_state'); ?></td>
                        <td><?php echo $model->auth_state_name; ?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table>
                <tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'refuse'); ?></td>
                    <td>
                       <?php echo $form->textArea($model, 'refuse', array('class' => 'input-text' )); ?>
                       <?php echo $form->error($model, 'refuse', $htmlOptions = array()); ?>
                    </td>
                	<td>可执行操作</td>
                    <td>
                        <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div> 
         <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->uDate; ?></td>
                <td><?php echo $model->admin_gfname; ?></td>
                <td><?php echo $model->refuse_state_name; ?></td>
                <td><?php echo $model->refuse; ?></td>
            </tr>
        </table>
    <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->