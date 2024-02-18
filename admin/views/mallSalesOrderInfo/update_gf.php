
   <div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》订单管理》订单列表》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table class="table-title"><tr><td>订单信息</td></tr></table>
            <table>
                <?php $record=OrderRecord::model()->find('(order_num="'.$model->order_num.'") order by id DESC'); ?>
                <tr>
                    <td width="10%"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td><?php echo $model->order_num; ?></td>
                    <td width="10%"><?php echo $form->labelEx($model, 'order_Date'); ?></td>
                    <td><?php echo $model->order_Date; ?></td>
                    <td width="10%">订单状态</td>
                    <td><?php $o_num=count($order_data);$c_num=0;
                    foreach($order_data as $d) if($d->logistics_id>0) $c_num++; ?>
                        <?php if(!empty($record)){
                            if($record->order_state==465 && $c_num==0){ echo "已支付"; 
                        } elseif ($record->order_state==465 && ($c_num>0 && $c_num<$o_num)) {
                            echo "部分发货";
                        } elseif ($record->order_state==465 && $c_num==$o_num) {
                            echo "已发货";
                        } else echo $record->order_state_name; }?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'order_gfname'); ?></td>
                    <td><?php echo $model->order_gfaccount; ?>(<?php echo $model->order_gfname; ?>)</td>
                    <td><?php echo $form->labelEx($model, 'pay_time'); ?></td>
                    <td><?php echo $model->pay_time; ?></td>
                    <td><?php echo $form->labelEx($model, 'rec_name'); ?></td>
                    <td><?php echo $model->rec_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'order_type'); ?></td>
                    <td><?php echo $model->order_type_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'pay_supplier_type'); ?></td>
                    <td><?php echo $model->pay_supplier_type_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'rec_phone'); ?></td>
                    <td><?php echo $model->rec_phone; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'payment_code'); ?></td>
                    <td><?php echo $model->payment_code; ?></td>
                    <td><?php echo $form->labelEx($model, 'rec_address'); ?></td>
                    <td colspan="3"><?php echo $model->rec_address; ?></td>
                </tr>
            </table>
            <table>
                <tr class="table-title">
                    <td colspan="9">商品信息</td>  
                </tr>
                <tr>
                    <td>商家名称</td>
                    <td>商品编号</td>
                    <td>商品名称</td>
                    <td>型号/规格</td>
                    <td>单价(元)</td>
                    <td>运费(单件/元)</td>
                    <td>数量</td>
                    <td>商品金额(含运费/元)</td>
                    <td>发货单号</td>
                </tr>
                <?php $price_count=0.00;$order_price=0.00;$post_count=0.00;
                 foreach($order_data as $v){?>
                <tr data-count="<?php echo $v->buy_count; ?>">
                    <td><?php echo $v->supplier_name; ?></td>
                <?php if($v->order_type==361 || $v->order_type==355 || $v->order_type==357){ ?>
                    <td><?php echo $v->product_code; ?></td>
                    <td><?php echo $v->product_title; ?></td>
                    <td><?php echo $v->json_attr; ?></td>
                <?php } else { ?>
                    <td><?php echo $v->service_code; ?></td>
                    <td><?php echo $v->service_name; ?></td>
                    <td><?php echo $v->service_data_name; ?></td>
                <?php } ?>
                    <td><?php echo $v->buy_price;$order_price=$order_price+$v->buy_amount; ?></td>
                    <td><?php echo $v->post; $post_count= $post_count+$v->post_total; ?></td>
                    <td><?php echo $v->buy_count; ?></td>
                    <td><?php echo $v->total_pay; $price_count= $price_count+$v->total_pay;?></td>
                    <td><?php if(!empty($v->logistics)) echo $v->logistics->logistics_xh; ?></td>
                 </tr>
                <?php } ?>
                 <tr class="table-title" style="text-align:right;">
                    <td colspan="9">
                        <label style="margin-right:20px;">商品小计:&nbsp;&nbsp;<b class="red">¥<?php echo sprintf("%.2f",$order_price); ?></b></label>
                        <label style="margin-right:20px;">运费:&nbsp;&nbsp;<b class="red">¥<?php echo sprintf("%.2f",$post_count); ?></b></label>
                        <label style="margin-right:20px;">实付金额:&nbsp;&nbsp;<b class="red">¥<?php echo sprintf("%.2f",$price_count); ?></b></label>
                    </td>
                 </tr>
            </table>
        </div><!--box-detail-bd end-->
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