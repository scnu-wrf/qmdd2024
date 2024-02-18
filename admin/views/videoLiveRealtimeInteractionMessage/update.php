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
                    <td class="detail-hd">选择帐号</td>
                    <td>
                        <?php echo $form->hiddenField($model,'s_gfaccount'); ?>
                        <?php echo $form->hiddenField($model,'s_gfid'); ?>
                        <span id="mall_s_gfaccount">
                            <?php if(!empty($model->id)) {?>
                                <span class="label-box"><?php echo $model->s_gfaccount; ?></span>
                            <?php }?>
                        </span>
                        <input type="button" class="btn" onclick="gfuser();" value="选择">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'recharge_amount'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model,'pricing_details_id'); ?>
                        <?php echo $form->hiddenField($model,'set_details_id'); ?>
                        <?php
                            echo $form->textField($model,'recharge_amount',array('class'=>'input-text','style'=>'width: 10%;','onclick'=>'clickPricing();','readonly'=>'readonly'));
                            echo $form->error($model,'recharge_amount',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'rechange_virtual_coin'); ?></td>
                    <td>
                        <?php
                            echo $form->textField($model,'rechange_virtual_coin',array('class'=>'input-text','style'=>'width: 10%;','readonly'=>'readonly'));
                            echo $form->error($model,'rechange_virtual_coin',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>可执行操作</td>
                    <td><?php echo show_shenhe_box(array('baocun'=>'保存')); ?></td>
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
                    $('#<?php echo $class; ?>_recharge_amount').val($.dialog.data('shoppingprice'));
                    $('#<?php echo $class; ?>_rechange_virtual_coin').val($.dialog.data('salebean'));
                    $('#<?php echo $class; ?>_pricing_details_id').val($.dialog.data('mallpricingdetailsid'));
                    $('#<?php echo $class; ?>_set_details_id').val($.dialog.data('id'));
                }
            }
        });
    }

    function gfuser(){
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择虚拟商品',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('GF_ID')>0){
                    $('#<?php echo $class; ?>_s_gfaccount').val($.dialog.data('GF_ACCOUNT'));
                    $('#<?php echo $class; ?>_s_gfid').val($.dialog.data('GF_ID'));
                    $('#mall_s_gfaccount').html('<span class="label-box">'+$.dialog.data('GF_ACCOUNT')+'</span>');
                }
            }
        });
    }
</script>