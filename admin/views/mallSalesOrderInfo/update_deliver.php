   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>发货地址</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('update', array('id'=>$model->id));?>');"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                	<td colspan="4">
                    基本信息
                    </td>  
                </tr>
                <?php $record=OrderRecord::model()->find('(order_num="'.$model->order_num.'") order by id DESC'); ?>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td><?php echo $model->order_num; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_state'); ?></td>
                    <td><?php echo $record['order_state_name']; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_gfname'); ?></td>
                    <td><?php echo $model->order_gfname; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_Date'); ?></td>
                    <td><?php echo $model->order_Date; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'pay_type'); ?></td>
                    <td><?php echo $model->pay_type_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'pay_time'); ?></td>
                    <td><?php echo $model->pay_time; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'leaving_a_message'); ?></td>
                    <td colspan="3"><?php echo $model->leaving_a_message; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        
        <div class="mt15">
            <table>
                <tr  class="table-title">
                	<td colspan="4">收货人信息</td>  
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'rec_name'); ?></td>
                    <td><?php echo $model->rec_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'rec_phone'); ?></td>
                    <td><?php echo $model->rec_phone; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'rec_address'); ?></td>
                    <td><?php echo $model->rec_address; ?></td>
                    <td><?php echo $form->labelEx($model, 'best_delivery_time'); ?></td>
                    <td><?php if (!empty($model->best_time)) echo $model->best_time->F_NAME; ?></td>
                </tr>
            </table>
        </div>
        <div class="mt15">
            <table>
                <tr  class="table-title">
                	<td>费用信息</td>  
                </tr>
                <tr>
                    <td>商品总金额:￥<?php echo $model->money; ?> + 配送费用:￥<?php echo $model->post; ?> + 保险费用:￥<?php echo $model->post_Insurance; ?></td>
                </tr>
                <tr>
                    <td>=订单总金额:￥<?php echo $model->order_money; ?></td>
                </tr>
                <tr>
                	<td>订单总金额:￥<?php echo $model->order_money; ?>- 优惠券抵减:<span class="red">￥<?php echo $model->coupon_discount; ?></span> - 体育豆抵减<span class="red">￥<?php echo $model->beans_discount; ?></span>-余额支付￥<?php echo $model->wallet_pay; ?> - 商家优惠金额:<span class="red">￥<?php echo $model->merchant_discount; ?></span></td>
                </tr>
                <tr>
                    <td>=实付金额:<span class="red"><b>￥<?php echo $model->total_money; ?></b></span></td>
                </tr>
            </table>
        </div>
        <div class="mt15">
            <table id="deliver">
                <tr  class="table-title">
                	<td colspan="10">商品信息</td>  
                </tr>
                <tr>
                	<td>商品名称</td>
                    <td>货号</td>
                    <td>销售价</td>
                    <td>体育豆</td>
                    <td>数量</td>
                    <td>规格属性</td>
                    <td>库存</td>
                    <td>小计</td>
                    <td>已发货数量</td>
                    <td>此次发货数量</td>
                </tr>
                <?php echo $form->hiddenField($model, 'deliver_num'); ?>
                <?php foreach($order_data as $v){?>
                <?php
					$recode_num=0;
					 if(isset($v->order_num)) { 
                    $recode_l=OrderInfoLogistics::model()->findAll('logistics_order_xh="'.$v->id.'"');
					foreach($recode_l as $s){
						$recode_num=$recode_num+$s->buy_count;
					}} ?>
                <?php if ($v->buy_count>$recode_num) { ?>
                <tr data-count="<?php echo $v->buy_count; ?>">
                    <input type="hidden" class="input-text" name="deliver_num[<?php echo $v->id; ?>][id]" value="<?php echo $v->id; ?>" >
                    <input type="hidden" class="input-text" name="deliver_num[<?php echo $v->id; ?>][supplier_id]" value="<?php echo $v->supplier_id; ?>" >
                	<td><?php echo $v->product_title; ?></td>
                    <td><?php echo $v->product_code; ?></td>
                    <td><?php echo $v->buy_price; ?></td>
                    <td><?php echo $v->buy_beans; ?></td>
                    <td><?php echo $v->buy_count; ?></td>
                    <td><?php echo $v->json_attr; ?></td>
                    <?php if(isset($v->product_data_id)) { 
					$pdata=MallProductData::model()->find('id="'.$v->product_data_id.'"'); } ?>
                    <td><?php echo $pdata->count-$pdata->data_sales_quantity; ?></td>
                    <td><?php echo $v->buy_price*$v->buy_count; ?></td>
                    <td><?php echo $recode_num; ?></td>
                    
                    <td><?php //echo $form->textField($model, 'deliver_num', array('class' => 'input-text' ,'value'=>'', 'onBlur' =>'deliverBlur(this)')); ?>
                    <input type="text" class="input-text" name="deliver_num[<?php echo $v->id; ?>][num]" oninput="deliverBlur(this)" onpropertychange="deliverBlur(this)" ></td>
                </tr>
                <?php } ?>
                <?php } ?>
            </table>
        </div>
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'content'); ?></td>
                    <td width='85%'>
                    <?php echo $form->textArea($model, 'content', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'content', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td>
                    	<button onclick="submitType='fahuodan'" class="btn btn-blue" type="submit">生成发货单</button>
                        <button class="btn" type="button" onclick="we.back('<?php echo $this->createUrl('update', array('id'=>$model->id));?>');">取消</button>
                    </td>
                </tr>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
deliverBlur('#MallSalesOrderInfo_deliver_num');
function deliverBlur(obj){ 
   var deliver_num=$(obj).val();
   var delivered=<?php echo $recode_num; ?>;
   var b_count=$(obj).parent().parent().attr('data-count');
   //console.log('543=='+b_count);
   var d_count=b_count-delivered;
   if (deliver_num>d_count)
   {	   
	   we.msg('minus', '此次发货数量不得超过未发货数量');
	   $(obj).val('');
	   $(obj).focus();
	   return false;
   } else {
	   fnUpdateDeliver();
	   return true;
   }
   
}
var fnUpdateDeliver=function(){
    var isEmpty=true;
    $('#deliver').find('.input-text').each(function(){
        if($(this).val()!=''){
            isEmpty=false;
            //return false;
        }
    });
    if(!isEmpty){
        $MallSalesOrderInfo_deliver_num.val('1').trigger('blur');
    }else{
        $MallSalesOrderInfo_deliver_num.val('').trigger('blur');
    }
 };

</script>