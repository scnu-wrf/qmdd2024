<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>上架方案详情</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                	<tr class="table-title">
                    	<td colspan="4" >方案信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'code'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'code',array('class'=>'input-text')); ?>
                            <?php echo $form->error($model,'code',$htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model,'name'); ?></td>
                        <td>
                            <?php echo $form->textField($model,'name',array('class'=>'input-text')); ?>
                            <?php echo $form->error($model,'name',$htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'star_time'); ?></td>
                        <td><?php echo $form->textField($model,'star_time',array('class'=>'input-text time')); ?></td>
                        <td><?php echo $form->labelEx($model,'end_time'); ?></td>
                        <td><?php echo $form->textField($model,'end_time',array('class'=>'input-text time')); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'is_user'); ?></td>
                        <td><?php echo $form->radioButtonList($model, 'is_user',Chtml::listData(BaseCode::model()->getCode(647),'f_id','F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?></td>
                        <td><?php echo $form->labelEx($model,'add_mall'); ?></td>
                        <td><input type="button" class="btn" id="product_select_btn" value="添加商品"></td>
                    </tr>
                </table>
                <table class="list" id="product">
                    <tr class="table-title">
                        <th style="text-align:center;">商品信息</th>
                        <th style="text-align:center;">上架数量</th>
                        <th style="text-align:center;">价格</th>
                        <th style="text-align:center;">体育币</th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                    <?php
                        $num=1;
                        echo $form->hiddenField($model, 'product', array('class' => 'input-text'));
                        if(!empty($product_list))foreach($product_list as $v) {
                    ?>
                        <tr id="set_mall_<?php echo $v->product_id; ?>">
                            <td>
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][id]" value="<?php echo $v->id;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][product_id]" value="<?php echo $v->product_id;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][product_code]" value="<?php echo $v->product_code;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][product_name]" value="<?php echo $v->product_name;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][mall_pricing_details_id]" value="<?php echo $v->mall_pricing_details_id;?>">
                                <p>商品编号：<?php echo $v->product_code; ?></p>
                                <p>商品名称：<?php echo $v->product_name; ?></p>
                            </td>
                            <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $num;?>][Inventory_quantity]" value="<?php echo $v->Inventory_quantity; ?>"></td>
                            <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $num;?>][shopping_price]" value="<?php echo $v->shopping_price; ?>"></td>
                            <td><input type="text" style="width:80%;" class="input-text" name="product[<?php echo $num;?>][sale_bean]" value="<?php echo $v->sale_bean; ?>"></td>
                            <td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                    <?php $num++;?>
                <?php } ?>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
            <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        $('.time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});
        });
    });

    var fnDeleteProduct=function(op){
        $(op).parent().parent().remove();
    };

	//添加商品
    var num = '<?php echo $num; ?>';
    $('#product_select_btn').on('click', function(){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/virtualMallPricingDetails");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择上架商品',
            width:'60%',
            height:'70%',
            close: function () {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('mall_name');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#set_mall_'+boxnum[j].dataset.productid).length==0){
                            $('#product').append(
                                '<tr id="set_mall_'+boxnum[j].dataset.productid+'">'+
                                    '<input type="hidden" class="input-text" name="product['+num+'][id]" value="null">'+
                                    '<input type="hidden" class="input-text" name="product['+num+'][product_id]" value="'+boxnum[j].dataset.productid+'">'+
                                    '<input type="hidden" class="input-text" name="product['+num+'][product_code]" value="'+boxnum[j].dataset.code+'">'+
                                    '<input type="hidden" class="input-text" name="product['+num+'][product_name]" value="'+boxnum[j].dataset.name+'">'+
                                    '<input type="hidden" class="input-text" name="product['+num+'][mall_pricing_details_id]" value="null">'+
                                    '<td>'+
                                        '<p>商品编号：'+boxnum[j].dataset.code+'</p>'+
                                        '<p>商品名称：'+boxnum[j].dataset.name+'</p>'+
                                    '</td>'+
                                    '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][Inventory_quantity]" value=""></td>'+
                                    '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][shopping_price]" value=""></td>'+
                                    '<td><input type="text" style="width:80%;" class="input-text" name="product['+num+'][sale_bean]" value=""></td>'+
                                    '<td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>'+
                                '</tr>'
                            );
                            num++;
                        }
                    }
                }
            }
        });
    });
</script>