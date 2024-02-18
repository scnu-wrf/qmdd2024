
   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>订单详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            <table class="table-title">
                    <tr>
                        <td>基本信息</td>
                    </tr>
            </table>
            <table>
                <?php $record=OrderRecord::model()->find('(order_num="'.$model->order_num.'") order by id DESC'); ?>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td width="35%"><?php echo $model->order_num; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td width="35%"><?php echo $model->order_type_name; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_gfaccount'); ?></td>
                    <td><?php echo $model->order_gfaccount; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_gfname'); ?></td>
                    <td><?php echo $model->order_gfname; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'order_Date'); ?></td>
                    <td><?php echo $model->order_Date; ?></td>
                    <td>订单状态</td>
                    <td><?php if($record->order_state==465){ echo "已支付"; } else echo $record->order_state_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'pay_time'); ?></td>
                    <td><?php echo $model->pay_time; ?></td>
                    <td><?php echo $form->labelEx($model, 'pay_supplier_type'); ?></td>
                    <td><?php echo $model->pay_supplier_type_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'payment_code'); ?></td>
                    <td colspan="3"><?php echo $model->payment_code; ?></td>
                </tr>
            </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table>
                <tr  class="table-title">
                	<td colspan="5">订单明细</td>  
                </tr>
                <tr>
                    <td>服务编码</td>
                	<td>服务名称</td>
                    <td>应收金额</td>
                    <td>减免金额</td>
                    <td>实付金额</td>
                </tr>
                <?php $price_count=0.00;
                $beans_count=0;
				 foreach($order_data as $v){
                     ?>
                <tr>
                	<td><?php echo $v->product_code; ?></td>
                 	<td><?php echo $v->product_title; ?></td>
                    <td><?php echo $v->total_pay; ?></td>
                    <td><?php echo $v->bean_discount+$v->coupon_discount; ?></td>
                    <td><?php echo $v->total_pay-($v->bean_discount+$v->coupon_discount); ?></td>
                 </tr>
                <?php }?>
            </table>
        </div>
        <div class="mt15">
            <table>
                <tr class="table-title">
                	<td colspan="4">订单操作记录</td>  
                </tr>
                <tr>
                	<td>操作人</td>
                    <td>操作时间</td>
                    <td colspan="2">操作备注&nbsp;&nbsp;<a onClick="fnLog(this);" href="javascript:;" title="查看记录">查看</a></td>
                </tr>
                <?php foreach($order_record as $v){?>
                <tr class="op_log" style="display:none;">
                	<td><?php echo $v->operator_gfname; ?></td>
                    <td><?php echo $v->order_state_des_time; ?></td>
                    <td colspan="2">
                        <?php
                            //echo $form->hiddenField($model,'content',array('value'=>$v->order_state_des_content));
                            echo $v->order_state_des_content; ?>
                        </td>
                </tr>
                <?php } ?>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

function fnSign_in(id){
      $.ajax({
        type: 'get',
        url: '<?php echo $this->createUrl("sign_in");?>',
        data: {id: id},
        dataType:'json',
        success: function(data) {
          if (data.status==1){
            //we.success(data.msg, data.redirect);
			we.msg('minus', data.msg);
          }else{
            we.msg('minus', data.msg);
          }
       },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
            console.log(textStatus);
        }
    });
}

//// 查看操作记录
var fnLog=function(op){
	var op_text=$(op).text();
	if(op_text=='查看'){
		$('.op_log').show();
		$(op).text('收起');
	} else {
		$('.op_log').hide();
		$(op).text('查看');
	}
}

</script>