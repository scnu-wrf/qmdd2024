

<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页 》费用中心 》已支付订单 》详情</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();">
                <i class="fa fa-reply"></i>返回
            </a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr>
                	<td style="background:#efefef;width:10%;">订单状态：</td>  
                	<td colspan="3">待支付</td>  
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">订单概要</td>  
                </tr>
                <tr>
                    <td style="width:10%;"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td style="width:40%;">
                        <?php echo $model->order_num; ?>
                    </td>
                    <td style="width:10%;"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td style="width:40%;">
                        <?php echo $model->order_type_name; ?>
                    </td>
                </tr>
                <tr>
                    <td style="width:10%;"><?php echo $form->labelEx($model, 'order_Date'); ?></td>
                    <td style="width:40%;">
                        <?php echo $model->order_Date; ?>
                    </td>
                    <td style="width:10%;">支付时间</td>
                    <td style="width:40%;">
                        <?php echo $model->pay_time; ?>
                    </td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">订单详情</td>  
                </tr>
                <tr>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'product_title'); ?></td>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'json_attr'); ?></td>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'buy_count'); ?></td>
                    <td style="width:25%;"><?php echo $form->labelEx($model, 'money'); ?></td>
                </tr>
                <tr>
                    <td style="width:25%;"><?php echo $model->order_data->product_title; ?></td>
                    <td style="width:25%;"><?php echo $model->order_data->json_attr; ?></td>
                    <td style="width:25%;"><?php echo $model->order_data->buy_count; ?></td>
                    <td style="width:25%;"><?php echo $model->money; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">支付方式</td>  
                </tr>
                <tr>
                    <td>
                        <?php echo $model->pay_supplier_type_name;?>
                    </td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;background-color:transparent;">
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'order_money'); ?></td>
                    <td style="width:15%;"><?php echo $model->order_money; ?></td>
                </tr>
                <tr>
                    <td style="width:70%;"></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'total_money'); ?></td>
                    <td style="width:15%;"><?php echo $model->total_money; ?></td>
                </tr>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->