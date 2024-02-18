<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table">详细</i></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
                <table>
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'gf_name'); ?></td>
                        <td><?php echo $model->gf_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td><?php echo $model->code; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_name'); ?></td>
                        <td><?php echo $model->club_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'levelid'); ?></td>
                        <td><?php echo $model->levelname; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'name'); ?></td>
                        <td><?php echo $model->name; ?></td>
                        <td><?php echo $form->labelEx($model, 'scale_no'); ?></td>
                        <td><?php echo $model->scale_no; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'scale_amount'); ?></td>
                        <td><?php echo $model->scale_amount; ?> /<?php echo $model->json_attr; ?></td>
                        <td><?php echo $form->labelEx($model, 'scale_type'); ?></td>
                        <td><?php echo $model->scale_type; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'date_start_scale'); ?></td>
                        <td><?php echo $model->date_start_scale; ?></td>
                        <td><?php echo $form->labelEx($model, 'date_end_scale'); ?></td>
                        <td><?php echo $model->date_end_scale; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'product_name'); ?></td>
                        <td><?php echo $model->product_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'product_code'); ?></td>
                        <td><?php echo $model->product_code; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'date_scale'); ?></td>
                        <td colspan="3"><?php echo $model->date_scale; ?></td>
                    </tr>
                </table>
            </div>
            <div class="mt15">
                <table>
                    <tr class="table-title">
                        <td colspan="4">操作记录</td>
                    </tr>
                    <tr>
                        <td>操作人</td>
                        <td><?php echo $model->f_username; ?></td>
                        <td>修改日期</td>
                        <td><?php echo $model->f_userdate; ?></td>
                    </tr>
                </table>
            </div>
        <?php $this->endWidget();?>
    </div>
</div>