<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名》赛事报名》报名费用明细》详情</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">服务订单信息</td>
                </tr>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td width="35%"><?php echo $model->order_num; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'info_order_num'); ?></td>
                    <td width="35%"><?php echo $model->info_order_num; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'gfid'); ?></td>
                    <td><?php echo $model->gf_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php echo $model->contact_phone; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_itme'); ?></td>
                    <td><?php echo $model->order_type_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'add_time'); ?></td>
                    <td><?php echo $model->add_time; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'mall_time'); ?></td>
                    <td><?php if(!empty($model->info_order_num)) echo $model->mall_order_num->pay_time; ?></td>
                    <td><?php echo $form->labelEx($model, 'mall_pay_type'); ?></td>
                    <td><?php if(!empty($model->info_order_num)) echo $model->mall_order_num->pay_type_name; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'mall_payment_code'); ?></td>
                    <td colspan="3"><?php if(!empty($model->info_order_num)) echo $model->mall_order_num->payment_code; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'set_code'); ?></td>
                    <td><?php echo $model->set_code; ?></td>
                    <td><?php echo $form->labelEx($model, 'set_name'); ?></td>
                    <td><?php echo $model->set_name; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">赛事信息</td>
                </tr>
                <tr class="table-title">
                	<td width="15%">赛事名称</td>
                	<td width="35%">竞赛项目</td>
                	<td width="15%">收费项目名称</td>
                	<td width="35%">收费金额</td>
                </tr>
                <tr>
                    <?php $club_membership_fee = ClubMembershipFee::model()->find('code="TS45"'); ?>
                    <td><?php echo $model->service_name; ?></td>
                    <td><?php echo $model->service_data_name; ?></td>
                    <td><?php if(!empty($club_membership_fee)) echo $club_membership_fee->name; ?></td>
                    <td><?php echo $model->buy_price; ?></td>
                </tr>
                <tr class="red">
                    <td colspan="2" style="text-align:right;">小计：<?php echo $model->buy_price; ?></td>
                    <td>优惠金额：<?php echo (empty($model->free_money)) ? 0 : $model->free_money; ?></td>
                    <td>实付金额：<?php echo number_format($model->buy_price-$model->free_money,2); ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->