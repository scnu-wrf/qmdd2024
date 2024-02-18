   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>订单详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                	<td colspan="4">
                    基本信息
                    </td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td><?php echo $model->order_num; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td><?php if (!empty($model->order_type)) echo $model->ordertype->F_NAME; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'order_gfid'); ?></td>
                    <td><?php if (!empty($model->order_gfid)) echo $model->gfid->ZSXM; ?></td>
                    <td><?php echo $form->labelEx($model, 'order_Date'); ?></td>
                    <td><?php echo $model->order_Date; ?></td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'leaving_a_message'); ?></td>
                    <td colspan="3"><?php echo $model->leaving_a_message; ?></td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->

        <div class="mt15">
            <table>
                <tr  class="table-title"><!--a href="<php //echo $this->createUrl('receiptUpdate',array('rid'=>$model->id));?>"></a-->
                	<td colspan="4">收货人信息<button class="btn" onClick="fnReceiptUpdate(<?php echo $model->id; ?>)" type="button">编辑</button></td>
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
                    <td><?php if ($model->best_time!=null) { echo $model->best_time->F_NAME; } ?></td>
                </tr>
            </table>
        </div>
        <div class="mt15">
            <table>
                <tr class="table-title"><!--a class="btn" href="<php echo $this->createUrl('update_cost', array('id'=>$model->id));?>" title="编辑">编辑</a-->
                	<td>费用信息<button class="btn" onClick="fnCostUpdate(<?php echo $model->id; ?>)" type="button">编辑</button></td>
                </tr>
                <tr>
                    <td>商品总金额:￥<?php echo $model->money; ?> + 配送费用:￥<?php echo $model->post; ?> + 保险费用:￥<?php echo $model->post_Insurance; ?></td>
                </tr>
                <tr>
                    <td>=订单总金额:￥<?php echo $model->order_money; ?></td>
                </tr>
                <tr>
                	<td>订单总金额:￥<?php echo $model->order_money; ?> - 优惠券抵减:<span class="red">￥<?php echo $model->coupon_discount; ?></span> - 体育豆抵减<span class="red">￥<?php echo $model->beans_discount; ?></span>-余额支付￥<?php echo $model->wallet_pay; ?> - 商家优惠金额:<span class="red">￥<?php echo $model->merchant_discount; ?></span></td>
                </tr>
                <tr>
                    <td>=实付金额:<span class="red"><b>￥<?php echo $model->total_money; ?></b></span></td>
                </tr>
            </table>
        </div>
        <div class="mt15">
            <table>
                <tr  class="table-title">
                	<td colspan="7">商品信息</td>
                </tr>
                <tr>
                	<td>商品名称</td>
                    <td>货号</td>
                    <td>销售价</td>
                    <td>体育豆</td>
                    <td>数量</td>
                    <td>规格属性</td>
                    <td>小计</td>
                </tr>
                <?php $d_num=0;
				 foreach($model->shopping_car as $v){?>
                <tr data-count="<?php echo $v->buy_count; ?>">
                	<td><?php echo $v->product_title; ?></td>
                    <td><?php echo $v->product_code; ?></td>
                    <td><?php echo $v->buy_price; ?></td>
                    <td><?php echo $v->buy_beans; ?></td>
                    <td><?php echo $v->buy_count; ?></td>
                    <td><?php echo $v->json_attr; ?></td>
                    <td><?php echo $v->buy_price*$v->buy_count; ?></td>
                </tr>
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
                    <button onclick="submitType='mianzhifu'" class="btn btn-blue" type="submit">免支付款</button>
                        <button onclick="fnConfirmcancel(this)" class="btn btn-blue" type="submit">取消订单</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
var fnCostUpdate=function(id){
    var c_html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'money'); ?></td>'+
            '<td>￥<?php echo $model->money; ?></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'post'); ?></td>'+
            '<td><input id="dialog_post" class="input-text" oninput="postOnchang(this)" onpropertychange="postOnchang(this)" type="text" value="<?php echo $model->post; ?>" ></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'merchant_discount'); ?></td>'+
            '<td><input id="dialog_merchant_discount" class="input-text" oninput="discountOnchang(this)" onpropertychange="discountOnchang(this)" type="text" value="<?php echo $model->merchant_discount; ?>" ></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'order_money'); ?><input id="dialog_order_money" type="hidden" value="<?php echo $model->order_money; ?>" ></td>'+
            '<td>￥<span id="order_money"><?php echo $model->order_money; ?></span></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'coupon_discount'); ?></td>'+
            '<td>￥<?php echo $model->coupon_discount; ?></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'beans_discount'); ?></td>'+
            '<td>￥<?php echo $model->beans_discount; ?></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'wallet_pay'); ?></td>'+
            '<td>￥<?php echo $model->wallet_pay; ?></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="30%"><?php echo $form->labelEx($model, 'total_money'); ?><input id="dialog_total_money" type="hidden" value="<?php echo $model->total_money; ?>" ></td>'+
            '<td>￥<span id="total_money"><?php echo $model->total_money; ?></span></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'feiyongxinxi',
        lock:true,
        opacity:0.3,
        title:'费用信息',
        content:c_html,
        button:[
            {
                name:'确认修改',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('cost');?>',
                        data: {id:id, post:$('#dialog_post').val(),discount:$('#dialog_merchant_discount').val(),order_money:$('#dialog_order_money').val(),total_money:$('#dialog_total_money').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['feiyongxinxi'].close();
                                we.success(data.msg, data.redirect);
                            }else{
                                we.loading('hide');
                                we.msg('minus', data.msg);
                            }
                        }
                    });
                    return false;
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};
//运费改变函数
function postOnchang(obj){
  var changval=$(obj).val();
  var orderval= parseFloat(<?php echo $model->money; ?>)+parseFloat(changval);
  var totalval= parseFloat(<?php echo $model->money; ?>)+parseFloat(changval)-parseFloat($('#dialog_merchant_discount').val())-parseFloat(<?php echo $model->coupon_discount; ?>)-parseFloat(<?php echo $model->beans_discount; ?>)-parseFloat(<?php echo $model->wallet_pay; ?>);
  $('#dialog_order_money').val(orderval);
  $('#dialog_total_money').val(totalval);
  $('#order_money').text(orderval);
  $('#total_money').text(totalval);
}
//商家优惠金额改变函数
function discountOnchang(obj){
  var changval=$(obj).val();
  var discount=Math.floor(parseFloat(changval)*100)/100;
  //console.log('1=='+discount);
  var orderval=parseFloat($('#dialog_order_money').val());
  if(discount>orderval){
	  $(obj).val(0);
	  we.msg('minus','商家优惠金额不能大于订单金额');
      return false;
  }
  var totalval= parseFloat(<?php echo $model->money; ?>)+parseFloat($('#dialog_post').val())-discount-parseFloat(<?php echo $model->coupon_discount; ?>)-parseFloat(<?php echo $model->beans_discount; ?>)-parseFloat(<?php echo $model->wallet_pay; ?>);
  $('#dialog_total_money').val(totalval.toFixed(2));
  $('#total_money').text(totalval.toFixed(2));
}
$(function () {
	var orderval=parseFloat($('#dialog_order_money').val());
	var discount=parseFloat($('#dialog_merchant_discount').val());
	if(discount>orderval){
	  $('#dialog_merchant_discount').val(0);
	  we.msg('minus','商家优惠金额不能大于订单金额');
      return false;
    }
});
///////////////////////修改收货信息
var fnReceiptUpdate=function(id){
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%"><?php echo $form->labelEx($model, 'rec_name'); ?></td>'+
            '<td><input id="dialog_rec_name" class="input-text" type="text" value="<?php echo $model->rec_name; ?>" ></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="15%"><?php echo $form->labelEx($model, 'rec_phone'); ?></td>'+
            '<td><input id="dialog_rec_phone" class="input-text" type="text" value="<?php echo $model->rec_phone; ?>" ></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="15%"><?php echo $form->labelEx($model, 'rec_address'); ?></td>'+
            '<td><input id="dialog_rec_address" class="input-text" type="text" value="<?php echo $model->rec_address; ?>" ></td>'+
        '</tr>'+
		'<tr>'+
            '<td width="15%"><?php echo $form->labelEx($model, 'best_delivery_time'); ?></td>'+
            '<td><select id="dialog_best_delivery_time"><?php if(!empty($model->best_time)) { ?><option value="<?php echo $model->best_delivery_time;?>"><?php echo $model->best_time->F_NAME;?></option><?php } else { ?><option value="">请选择</option><?php } ?><?php foreach($best_time as $v){?><option value="<?php echo $v->f_id;?>"><?php echo $v->F_NAME;?></option><?php }?></select></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'shouhuoxinxi',
        lock:true,
        opacity:0.3,
        title:'收货信息',
        content:html,
        button:[
            {
                name:'确认修改',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('receipt');?>',
                        data: {id:id, rec_name:$('#dialog_rec_name').val(),rec_phone:$('#dialog_rec_phone').val(),rec_address:$('#dialog_rec_address').val(),best_delivery_time:$('#dialog_best_delivery_time').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['shouhuoxinxi'].close();
                                we.success(data.msg, data.redirect);
                            }else{
                                we.loading('hide');
                                we.msg('minus', data.msg);
                            }
                        }
                    });
                    return false;
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};
//fnConfirmfree(this)
var fnConfirmcancel=function(obj){
	type=$(obj);
	$.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnConcelSubmit},
            button2: {text: '取消'}
        },
        content: '确定取消订单吗？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
	var fnConcelSubmit=function(){
		submitType='qvxiao';
		type.submit();

	}

}


var fnConfirmfree=function(obj){
	type=$(obj);
	$.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnFreeSubmit},
            button2: {text: '取消'}
        },
        content: '确定免支付款吗？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
	var fnFreeSubmit=function(){
		submitType='mianzhifu';
		type.submit();
	}
}


</script>