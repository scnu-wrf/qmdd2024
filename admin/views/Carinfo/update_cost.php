<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>费用信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('update', array('id'=>$model->id));?>');"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail">
            <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <div class="box-detail-bd">
            <table>   
                <tr>
                  <td><?php echo $form->labelEx($model, 'money'); ?></td>
                  <td colspan="3">￥<?php echo $model->money; ?></td>
                </tr>            
                <tr>
                  <td><?php echo $form->labelEx($model, 'post'); ?></td>
                  <td colspan="3">￥<?php echo $form->textField($model, 'post', array('class' => 'input-text','oninput' =>'postOnchang(this)','onpropertychange' =>'postOnchang(this)')); ?></td>
                </tr> 
                <tr>
                  <td><?php echo $form->labelEx($model, 'merchant_discount'); ?></td>
                  <td colspan="3">￥<?php echo $form->textField($model, 'merchant_discount', array('class' => 'input-text', 'oninput' =>'discountOnchang(this)', 'onpropertychange' =>'discountOnchang(this)')); ?></td>
                </tr>
                <tr>
                  <td><?php echo $form->labelEx($model, 'order_money'); ?></td>
                  <?php echo $form->hiddenField($model, 'order_money', array('class' => 'input-text')); ?>
                  <td colspan="3">￥<span id="order_money"><?php echo $model->order_money; ?></span></td>
                </tr>
                <tr>
                  <td><?php echo $form->labelEx($model, 'coupon_discount'); ?></td>
                  <td colspan="3">￥<?php echo $model->coupon_discount; ?></td>
                </tr>
                <tr>
                  <td><?php echo $form->labelEx($model, 'beans_discount'); ?></td>
                  <td colspan="3">￥<?php echo $model->beans_discount; ?></td>
                </tr>
                <tr>
                  <td><?php echo $form->labelEx($model, 'wallet_pay'); ?></td>
                  <td colspan="3">￥<?php echo $model->wallet_pay; ?></td>
                </tr>
                <tr>
                  <td><?php echo $form->labelEx($model, 'total_money'); ?></td>
                  <?php echo $form->hiddenField($model, 'total_money', array('class' => 'input-text')); ?>
                  <td colspan="3">￥<span id="total_money"><?php echo $model->total_money; ?></span></td>
                </tr>
                <tr>
                    <td colspan="4" align="center">
                        <?php //echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <button class="btn" type="button" onclick="we.back('<?php echo $this->createUrl('update', array('id'=>$model->id));?>');">取消</button>
                    </td>
                </tr>
            </table>
            </div>
            <?php $this->endWidget(); ?>
        </div><!--box-table end-->
    </div><!--box-content end-->
</div><!--box end-->
<script>
//运费改变函数
function postOnchang(obj){ 
  var changval=$(obj).val();
  var orderval= parseFloat(<?php echo $model->money; ?>)+parseFloat(changval);
  var totalval= parseFloat(<?php echo $model->money; ?>)+parseFloat(changval)-parseFloat($('#Carinfo_merchant_discount').val())-parseFloat(<?php echo $model->coupon_discount; ?>)-parseFloat(<?php echo $model->beans_discount; ?>)-parseFloat(<?php echo $model->wallet_pay; ?>);
  $('#Carinfo_order_money').val(orderval);
  $('#Carinfo_total_money').val(totalval);
  $('#order_money').text(orderval);
  $('#total_money').text(totalval);
}
//商家优惠金额改变函数
function discountOnchang(obj){ 
  var changval=$(obj).val();
  var discount=Math.floor(parseFloat(changval)*100)/100;
  //console.log('1=='+discount);
  var orderval=parseFloat($('#Carinfo_order_money').val());
  if(discount>orderval){
	  $(obj).val(0);
	  we.msg('minus','商家优惠金额不能大于订单金额');
      return false;
  }
  var totalval= parseFloat(<?php echo $model->money; ?>)+parseFloat($('#Carinfo_post').val())-discount-parseFloat(<?php echo $model->coupon_discount; ?>)-parseFloat(<?php echo $model->beans_discount; ?>)-parseFloat(<?php echo $model->wallet_pay; ?>);
  $('#Carinfo_total_money').val(totalval.toFixed(2));
  $('#total_money').text(totalval.toFixed(2));
}
$(function () {
	var orderval=parseFloat($('#Carinfo_order_money').val());
	var discount=parseFloat($('#Carinfo_merchant_discount').val());
	if(discount>orderval){
	  $('#Carinfo_merchant_discount').val(0);
	  we.msg('minus','商家优惠金额不能大于订单金额');
      return false;
    }
});

</script>