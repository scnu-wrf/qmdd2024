<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑广告位置</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'adv_name'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'adv_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'adv_name', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'adv_code'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'adv_code', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                    <?php echo $form->error($model, 'adv_code', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'how_long_dispay'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'how_long_dispay', array('class' => 'input-text', 'style'=>'width:48px;')); ?>
                    <span>秒</span>
                    <?php echo $form->error($model, 'how_long_dispay', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'dispay_time'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'dispay_time', array('class' => 'input-text', 'style'=>'width:48px;')); ?>
                    <span>秒</span>
                    <?php echo $form->error($model, 'dispay_time', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'pic_px'); ?></td>
                <td>
                	<?php echo $form->textField($model, 'pic_px', array('class' => 'input-text', 'style'=>'width:100px;')); ?>
                    <span class="msg">如：1080px*720px</span>
                    <?php echo $form->error($model, 'pic_px', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'if_state'); ?></td>
                <td>
                <?php echo $form->radioButtonList($model, 'if_state', Chtml::listData(BaseCode::model()->getCode(791), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                <?php echo $form->error($model, 'if_state', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'dispay_num'); ?></td>
                <td colspan="3">
                    <?php echo $form->textField($model, 'dispay_num', array('class' => 'input-text', 'style'=>'width:48px;')); ?>
                    <span class="msg">个，留空为不限制数量</span>
                    <?php echo $form->error($model, 'dispay_num', $htmlOptions = array()); ?>
                </td>
            </tr>
            <!--<tr>
                <td><php echo $form->labelEx($model, 'product_data_id'); ?></td>
                <td colspan="3">
                    <php echo $form->hiddenField($model, 'product_data_id', array('class' => 'input-text')); ?>
                    <input id="product_select_btn" class="btn" type="button" value="选择">
                    <br>
                        <table class="showinfo">
                            <tr>
                                <th width="15%">商品货号</th>
                                <td width="35%" id="product_code"><php if(!empty($model->mall_product_data)){ echo $model->mall_product_data->mall_products->code; }?></td>
                                <th width="15%">商品名称</th>
                                <td width="35%" id="product_name"><php if(!empty($model->mall_product_data)){ echo $model->mall_product_data->mall_products->name; }?></td>
                            </tr>
                            <tr>
                                <th>商品属性</th>
                                <td id="product_attr"><php if(!empty($model->mall_product_data)){ echo $model->mall_product_data->json_attr; }?></td>
                                <th>价格</th>
                                <td id="product_price"><php if(!empty($model->mall_product_data)){?>预估价格：<php echo $model->mall_product_data->price;?>，以当时价格为准<php }?></td>
                            </tr>
                        </table>
                    <php echo $form->error($model, 'product_data_id', $htmlOptions = array()); ?>
                </td>
            </tr>-->
        </table>
        <div class="box-detail-submit">
		<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
        <!--button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button-->
        <button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<!--script>
$(function(){
    var $product_code = $('#product_code');
    var $product_name = $('#product_name');
    var $product_attr = $('#product_attr');
    var $product_price = $('#product_price');
    //var $product_data_id = $('#AdverName_product_data_id');
    $('#product_select_btn').on('click', function(){
        $.dialog.open('<php echo $this->createUrl("select/productData");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('product_id')>0){
                    $product_data_id.val($.dialog.data('product_id'));
                    $product_code.html($.dialog.data('product_code'));
                    $product_name.html($.dialog.data('product_name'));
                    $product_attr.html($.dialog.data('product_attr'));
                    $product_price.html('预估价格：'+$.dialog.data('product_price')+'，以当时价格为准');
                }
            }
        });
    });
});
</script-->