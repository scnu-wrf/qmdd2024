<?php $class = get_class($model); ?>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i></h1>
        <span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <div class="box-content">
        <div class="box-table">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <table class="detail">
                <tr>
                    <td class="detail-hd"><?php echo $form->labelEx($model,'pricing_details_id'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model,'pricing_details_id'); ?>
                        <span id="mall_pricing">
                            <span class="label-box"><?php if(!empty($model->pricing_details_id) && !empty($model->mall_pricing_details_id))echo $model->mall_pricing_details_id->product_name; ?></span>
                        </span>
                        <input type="button" class="btn" onclick="clickPricing();" value="选择">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'code'); ?></td>
                    <td>
                        <?php
                            echo $form->textField($model,'code',array('class'=>'input-text','style'=>'width: 10%;','readonly'=>'readonly'));
                            echo $form->error($model,'code',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'recharge_amount'); ?></td>
                    <td>
                        <?php
                            echo $form->textField($model,'recharge_amount',array('class'=>'input-text','style'=>'width: 10%;','readonly'=>'readonly'));
                            echo $form->error($model,'recharge_amount',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'exchange_num'); ?></td>
                    <td>
                        <?php
                            echo $form->textField($model,'exchange_num',array('class'=>'input-text','style'=>'width: 10%;','readonly'=>'readonly'));
                            echo $form->error($model,'exchange_num',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td><?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核')); ?></td>
                </tr>
            </table>
        <?php $this->endWidget(); ?>
        </div>
    </div>
</div><!--box end-->
<script>
    function clickPricing(){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/virtualMallPriceSetDetails");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择虚拟商品',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    $('#<?php echo $class; ?>_pricing_details_id').val($.dialog.data('mallpricingdetailsid'));
                    $('#<?php echo $class; ?>_code').val($.dialog.data('code'));
                    $('#<?php echo $class; ?>_name').val($.dialog.data('name'));
                    $('#<?php echo $class; ?>_recharge_amount').val($.dialog.data('shoppingprice'));
                    $('#<?php echo $class; ?>_exchange_num').val($.dialog.data('salebean'));
                    $('#mall_pricing').html('<span class="label-box">'+$.dialog.data('name')+'</span>');
                }
            }
        });
    }
</script>