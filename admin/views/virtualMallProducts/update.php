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
                    <td class="detail-hd">选择商品</td>
                    <td>
                        <?php echo $form->hiddenField($model,'mall_pricing_details_id'); ?>
                        <?php echo $form->hiddenField($model,'product_id'); ?>
                        <?php echo $form->hiddenField($model,'product_code'); ?>
                        <span id="mall_pricing">
                            <?php if(!empty($model->id)) {?>
                                <span class="label-box"><?php echo $model->product_name; ?></span>
                            <?php }?>
                        </span>
                        <input type="button" class="btn" onclick="clickPricing();" value="选择">
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'code'); ?></td>
                    <td>
                        <?php
                            echo $form->textField($model,'code',array('class'=>'input-text','style'=>'width: 10%;'));
                            echo $form->error($model,'code',$htmlOption = array());
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'product_name'); ?></td>
                    <td>
                        <?php
                            echo $form->textField($model,'product_name',array('class'=>'input-text','style'=>'width: 10%;'));
                            echo $form->error($model,'product_name',$htmlOption = array());
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
        $.dialog.open('<?php echo $this->createUrl("select/virtualDetail");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择虚拟商品',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    $('#<?php echo $class; ?>_mall_pricing_details_id').val($.dialog.data('id'));
                    $('#<?php echo $class; ?>_product_id').val($.dialog.data('id'));
                    $('#<?php echo $class; ?>_product_code').val($.dialog.data('code'));
                    $('#<?php echo $class; ?>_code').val($.dialog.data('code'));
                    $('#<?php echo $class; ?>_product_name').val($.dialog.data('name'));
                    $('#mall_pricing').html('<span class="label-box">'+$.dialog.data('name')+'</span>');
                }
            }
        });
    }
</script>