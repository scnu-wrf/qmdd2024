
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品下架》商品下架申请》<a class="nav-a">添加</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
                <table style="table-layout:auto;">
                	<tr class="table-title">
                    	<td colspan="4">方案信息</td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'supplier_id'); ?></td>
                        <td width="35%">
                            <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'supplier_id', array('class' => 'input-text', 'value'=>get_session('club_id'))); ?></span><?php } ?></span>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'event_code'); ?></td>
                        <td width="35%"><?php echo $model->event_code; ?></td>
                    </tr>
                    <tr> 
                        <td><?php echo $form->labelEx($model, 'event_title'); ?></td>
                        <td>
                        <?php echo $form->textField($model, 'event_title', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'event_title', $htmlOptions = array()); ?>
                        </td>
                         <td><?php echo $form->labelEx($model, 'down_time'); ?></td>
                         <td>
                            <?php echo $form->textField($model, 'down_time', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'down_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'data_sourcer_bz'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textArea($model, 'data_sourcer_bz', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'data_sourcer_bz', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="4">下架商品信息&nbsp;<input id="product_select_btn" class="btn" type="button" value="添加商品"></td>
                    </tr>   
                </table>
                <script>var oldnum=0;</script>               
                <table id="product">
                    <tr style="text-align:center;">
                        <td>销售方式</td>
                        <td>商品编号</td>
                        <td>商品名称</td>
                        <td>型号/规格</td>
                        <td>上架数量</td>
                        <td>库存数量</td>
                        <td>下架数量</td>
                        <td>操作</td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'product', array('class' => 'input-text')); ?>
                    <?php $num=1; if(isset($product_list)) if (is_array($product_list)) foreach ($product_list as $v) {?>
                        <tr style="text-align:center;" id="low_item_<?php echo $v->down_pricing_set_details_id; ?>">
                            <td><?php echo $v->sale_name; ?>
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][sale_id]" value="<?php echo $v->sale_id;?>"></td>
                            <td>
                                <?php echo $v->product_code; ?>
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][id]" value="<?php echo $v->id;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][code]" value="<?php echo $v->product_code;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][title]" value="<?php echo $v->product_name;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][upquantity]" value="<?php echo $v->up_quantity;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][json_attr]" value="<?php echo $v->json_attr;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][productid]" value="<?php echo $v->product_id;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][down_detailsid]" value="<?php echo $v->down_pricing_set_details_id;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][down_set_id]" value="<?php echo $v->down_pricing_set_id;?>">
                                <input type="hidden" class="input-text" name="product[<?php echo $num;?>][available_quantity]" value="<?php echo $v->up_available_quantity; ?>">
                            </td>
                            <td><?php echo $v->product_name; ?></td>
                            <td><?php echo $v->json_attr; ?></td>
                            <td><?php echo $v->up_quantity; ?></td>
                            <td><?php echo $v->up_quantity-$v->up_available_quantity; ?></td>
                            <td><input type="text" class="input-text" name="product[<?php echo $num;?>][inventory_quantity]" value="<?php echo $v->Inventory_quantity; ?>"></td>
                            <td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>
                        </tr>
                        <script>oldnum=<?php echo $v->id ?>;</script>
                    <?php $num=$num+1; } ?>                     
               </table>
        </div><!--box-detail-bd end-->
        <div class="mt15" style="text-align:center;">
            <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核')); ?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        var $down_time=$('#<?php echo get_class($model);?>_down_time');
        $down_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
    });

    var fnDeleteProduct=function(op){
        var a=confirm("确定删除吗？");
        if(a==true){
            $(op).parent().parent().remove();
        }
    };

    $product=$('#product');
    var num=<?php echo $num; ?>;
    $('#product_select_btn').on('click', function(){
        var supplier_id=$('#MallLowerSet_supplier_id').val();
        if(supplier_id==''){
            we.msg('minus','系统没有获取到供应商信息');
            return false;
        }
        $.dialog.data('id', 0);
		$.dialog.open('<?php echo $this->createUrl("select/mallPricingDetails");?>&club_id='+supplier_id,{
            id:'xiajia',
            lock:true,
            opacity:0.3,
            title:'选择下架商品',
            width:'95%',
            height:'95%',
            close: function() {
                if($.dialog.data('id')==-1){
                    var boxnum=$.dialog.data('title');
                    for(var j=0;j<boxnum.length;j++) {
                        // num=num+1;
                        if($('#low_item_'+boxnum[j].dataset.id).length==0){
                            var as=boxnum[j].dataset.inventory-boxnum[j].dataset.available;
                            $product.append(
                                '<tr style="text-align:center;" id="low_item_'+boxnum[j].dataset.id+'">'+
                                    '<td>'+boxnum[j].dataset.salename+'</td>'+
                                    '<td>'+boxnum[j].dataset.code+
                                        '<input type="hidden" class="input-text" name="product['+num+'][sale_id]" value="'+boxnum[j].dataset.saleid+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][id]" value="null">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][code]" value="'+boxnum[j].dataset.code+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][title]" value="'+boxnum[j].dataset.title+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][productid]" value="'+boxnum[j].dataset.productid+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][down_detailsid]" value="'+boxnum[j].dataset.id+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][json_attr]" value="'+boxnum[j].dataset.attr+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][upquantity]" value="'+boxnum[j].dataset.upquantity+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][down_set_id]" value="'+boxnum[j].dataset.downsetid+'">'+
                                        '<input type="hidden" class="input-text" name="product['+num+'][available_quantity]" value="'+boxnum[j].dataset.available+'">'+
                                    '</td>'+
                                    '<td>'+boxnum[j].dataset.title+'</td>'+
                                    '<td>'+boxnum[j].dataset.attr+'</td>'+
                                    '<td>'+boxnum[j].dataset.upquantity+'</td>'+
                                    '<td>'+as+'</td>'+
                                    '<td><input class="input-text" name="product['+num+'][inventory_quantity]" value="'+as+'"></td>'+
                                    '<td><a class="btn" href="javascript:;" onclick="fnDeleteProduct(this);" title="删除"><i class="fa fa-trash-o"></i></a></td>'+
                                '</tr>'
                            );
                            num++;
                        }
                    }
                }
            }
        });
    })
</script>
