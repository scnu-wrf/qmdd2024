   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务预订详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title">
                <tr><td>服务详细</td></tr>
            </table>
            <table>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td width="35%"><?php echo $model->order_num; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td width="35%"><?php echo $model->order_type_name; ?></td>
                </tr>
                <tr>
                    
                    <td>赛事名称</td>
                    <td><?php echo $model->service_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_state_name'); ?></td>
                    <td><?php echo $model->order_state_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td><?php echo $model->project_name; ?></td>
                    <td>竞赛项目</td>
                    <td><?php echo $model->service_data_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                    <td colspan="3"><?php echo $model->supplier_name; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'service_address'); ?></td>
                    <td><?php echo $model->service_address; ?></td>
                    <td><?php echo $form->labelEx($model, 'udate'); ?></td>
                    <td><?php echo $model->udate; ?></td>
                </tr>
            </table>
            <table class="table-title">
                <tr><td>订单信息</td></tr>
            </table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'info_order_num'); ?></td>
                    <td width="35%"><?php echo $model->info_order_num; ?></td>
                    <td width="15%"></td><td width="35%"></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'is_pay'); ?></td>
                    <td><?php echo $model->is_pay_name; ?></td>
                    <td>下单时间</td>
                    <td><?php echo $model->add_time; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'gf_account'); ?></td>
                    <td><?php echo $model->gf_account; ?></td>
                    <td><?php echo $form->labelEx($model, 'gf_name'); ?></td>
                    <td><?php echo $model->gf_name; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td colspan="3"><?php echo $model->contact_phone; ?></td>
                </tr>
            </table>
            <table>
            	 <tr  class="table-title">
                	<td colspan="6">服务信息</td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'service_code'); ?></td>
                    <td><?php echo $form->labelEx($model, 'service_ico'); ?></td>
                    <td><?php echo $form->labelEx($model, 'service_name'); ?></td>
                    <td><?php echo $form->labelEx($model, 'service_data_name'); ?></td>
                    <td><?php echo $form->labelEx($model, 'buy_count'); ?></td>
                    <td><?php echo $form->labelEx($model, 'buy_price'); ?></td>
                </tr>
                <tr>
                	<td><?php echo $model->service_code; ?></td>
                    <td>
                   		<?php echo $form->hiddenField($model, 'service_ico', array('class' => 'input-text fl')); ?>
						<?php $basepath=BasePath::model()->getPath(135);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->service_ico!=''){?><div><a href="<?php echo $basepath->F_WWWPATH.$model->service_ico;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->service_ico;?>" style="max-height:70px; max-width:70px;"></a></div><?php }?>
                        <?php echo $form->error($model, 'service_ico', $htmlOptions = array()); ?>
                    
                    </td>
                    <td><?php echo $model->service_name; ?></td>
                    <td><?php echo $model->service_data_name; ?></td>
                    <td><?php echo $model->buy_count; ?></td>
                    <td><?php echo $model->buy_price; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
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
                <td><?php echo $model->state_name; ?>|<?php echo $model->is_pay_name; ?>|<?php echo $model->order_state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->