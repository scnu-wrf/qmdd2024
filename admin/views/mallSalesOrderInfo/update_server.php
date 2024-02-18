<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》服务预订》订单列表》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td colspan="8">订单信息</td>
                </tr>
                <?php
                    $record = OrderRecord::model()->find('(order_num="'.$model->order_num.'") order by id DESC');
                    $sdata = GfServiceData::model()->find('(info_order_num="'.$model->order_num.'") order by id DESC');
                    echo $model->id;
                ?>
                <tr>
                    <td width="10%">订单类型</td>
                    <td><?php echo $model->order_type_name; ?></td>
                    <td width="10%">服务类别</td>
                    <td><?php if(!empty($sdata)) echo $sdata->t_stypename; //if($record->order_state==465){ echo "已支付"; } else echo $record->order_state_name; ?></td>
                    <td width="10%">服务单位</td>
                    <td><?php if(!empty($sdata)) echo $sdata->supplier_name; ?></td>
                    <td width="10%">订单状态</td>
                    <td><?php if(!empty($sdata)) echo $sdata->is_pay_name; ?></td>
                </tr>
                <tr>
                    <td>支付方式</td>
                    <td><?php echo $model->pay_supplier_type_name; ?></td>
                    <td>支付流水号</td>
                    <td><?php echo $model->payment_code; ?></td>
                    <td>订单号</td>
                    <td><?php echo $model->order_num; ?></td>
                    <td>下单人</td>
                    <td><?php echo $model->order_gfaccount; ?>/<?php echo $model->order_gfname; ?></td>
                </tr>
                <tr>
                    <td>下单时间</td>
                    <td><?php echo $model->order_Date; ?></td>
                    <td>联系电话</td>
                    <td><?php echo $model->contact_phone; ?></td>
                    <td>支付时间</td>
                    <td colspan="3"><?php echo $model->pay_time; ?></td>
                </tr>
            </table>
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="6">订单明细</td>  
                </tr>
                <tr>
                    <td>序号</td>
                    <td>服务流水号</td>
                    <td>服务名称（前端）</td>
                    <td>服务资源</td>
                    <td>预订服务时段</td>
                    <td>预订金额（元）</td>
                </tr>
                <?php
                    $price_count = 0.00;
                    $beans_count = 0;
                    $index = 1;
                    foreach($order_data as $v){
                        if(!empty($v->gf_service_id)) {
                            //$service_data=explode(',', $gf_service_id);
                            $service_data=GfServiceData::model()->findAll('id in ('.$v->gf_service_id.')');
                            foreach($service_data as $s){
                                $price_count = $price_count+$s->buy_price;
                                if($s->is_pay==464) $beans_count = $beans_count + $s->buy_price;
                ?>
                    <tr>
                        <td><?php echo $index; ?></td>
                        <td><?php echo $s->order_num; ?></td>
                        <td><?php echo $s->service_name; ?></td>
                        <td><?php echo $s->service_name; ?></td>
                        <td><?php echo $s->service_data_name; ?></td>
                        <td><?php echo $s->buy_price; ?></td>
                    </tr>
                <?php }}$index++;}?>
                <tr>
                    <td colspan="4"></td>
                    <td style="text-align: right;color: red;">订单总额（元）</td>
                    <td style="color: red;"><?php echo round($price_count,2); ?></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td style="text-align: right;color: red;">实付金额（元）</td>
                    <td style="color: red;"><?php echo round($price_count,2); ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <!-- <div class="mt15">
            <table>
                <tr class="table-title">
                	<td colspan="4">订单操作记录</td>  
                </tr>
                <tr>
                	<td>操作人</td>
                    <td>操作时间</td>
                    <td colspan="2">操作备注&nbsp;&nbsp;<a onClick="fnLog(this);" href="javascript:;" title="查看记录">查看</a></td>
                </tr>
                <?php //foreach($order_record as $v){?>
                <tr class="op_log" style="display:none;">
                	<td><?php //echo $v->operator_gfname; ?></td>
                    <td><?php //echo $v->order_state_des_time; ?></td>
                    <td colspan="2">
                        <?php
                            //echo $form->hiddenField($model,'content',array('value'=>$v->order_state_des_content));
                            //echo $v->order_state_des_content; ?>
                        </td>
                </tr>
                <?php //} ?>
            </table>
        </div> -->
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