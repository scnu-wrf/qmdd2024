   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务预订详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title">
                <tr><td>服务预订详情</td></tr>
            </table>
            <table>
                <tr>
                    <td width="10%"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td><?php echo $model->order_type_name; ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                    <td><?php echo $model->supplier_name; ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'info_order_num'); ?></td>
                    <td><?php echo $model->info_order_num; ?></td>
                    
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'gf_name'); ?></td>
                    <td><?php echo $model->gf_account; ?>/<?php echo $model->gf_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'add_time'); ?></td>
                    <td><?php echo $model->add_time; ?></td>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php echo $model->contact_phone; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td><?php echo $model->order_num; ?></td>
                    <td>支付流水号</td>
                    <td><?php if(!empty($model->mall_order_num)) echo $model->mall_order_num->payment_code; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_state_name'); ?></td>
                    <td><?php echo $model->order_state_name; ?></td>
                </tr>
            </table>
            <table>
            	 <tr  class="table-title">
                	<td colspan="7">服务信息</td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'service_code'); ?></td>
                    <td>类型/类别</td>
                    <td><?php echo $form->labelEx($model, 'data_name'); ?></td>
                    <td><?php echo $form->labelEx($model, 'service_data_name'); ?></td>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td><?php echo $form->labelEx($model, 'buy_count'); ?></td>
                    <td><?php echo $form->labelEx($model, 'buy_price'); ?></td>
                </tr>
                <tr>
                	<td><?php echo $model->service_code; ?></td>
                    <td><?php if(!empty($model->service_data)) echo $model->service_data->t_stypename.'/'.$model->service_data->t_typename; ?></td>
                    <td><?php echo $model->data_name; ?></td>
                    <td><?php echo $model->service_data_name; ?></td>
                    <td><?php echo $model->project_name; ?></td>
                    <td><?php echo $model->buy_count; ?></td>
                    <td><?php echo $model->buy_price; ?></td>
                </tr>
            </table>
            <table class="showinfo">
                <tr>
                    <th>操作时间</th>
                    <th>操作人</th>
                    <th>状态</th>
                    <th>操作备注</th>
                </tr>
                <tr>
                    <td><?php echo $model->state_time; ?></td>
                    <td><?php echo $model->admin_name; ?></td>
                    <td><?php echo $model->state_name; ?>|<?php echo $model->server_state_name; ?>|<?php echo $model->order_state_name; ?></td>
                    <td><?php echo $model->reasons_failure; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->