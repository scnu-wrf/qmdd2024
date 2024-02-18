<?php //var_dump($_SESSION);?>
   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>订单信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">订单信息</td>
                </tr>
                <tr>
                	<td style="width:10%"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td style="width:40%"><?php echo $model->order_num; ?></td>
                    <td style="width:10%"><?php echo $form->labelEx($model, 'order_Date'); ?></td>
                    <td style="width:40%"><?php echo $model->order_Date; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'pay_time'); ?></td>
                    <td><?php echo $model->pay_time; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_state'); ?></td>
                    <td><?php if(!is_null($model->order_data->gfService)) echo $model->order_data->gfService->order_state_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td><?php echo $model->order_type_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'pay_supplier_type'); ?></td>
                    <td><?php echo $model->pay_supplier_type_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'order_gfname'); ?></td>
                    <td><?php echo $model->order_gfaccount.'('.$model->order_gfname.')'; ?></td>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php if(!is_null($model->order_data->gfService))echo $model->order_data->gfService->contact_phone; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'payment_code'); ?></td>
                    <td colspan="3"><?php echo $model->payment_code; ?></td>
                </tr>
            </table>
            <div class="mt15">
                <table>
                    <tr class="table-title">
                        <td colspan="4">服务信息</td>  
                    </tr>
                    <tr class="table-title">
                        <td><?= $model->order_type==354?'活动':'培训'?>标题</td>
                        <td><?= $model->order_type==354?'活动':'培训'?>内容</td>
                        <td>收费项目名称</td>
                        <td>收费金额（元）</td>
                    </tr>
                    <tr>
                        <td><?php if(!is_null($model->order_data->detail))echo $model->order_data->detail->service_name; ?></td>
                        <td><?php if(!is_null($model->order_data->detail))echo $model->order_data->detail->service_data_name; ?></td>
                        <td><?php if(!is_null($model->order_data->detail))echo $model->order_data->detail->product_name; ?></td>
                        <td><?php if(!is_null($model->order_data->detail))echo $model->order_data->detail->sale_price; ?></td>
                    </tr>
                </table>
            </div>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->