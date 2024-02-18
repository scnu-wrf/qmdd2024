<?php
    if(!isset($_REQUEST['mall_member_price_id'])){
        $_REQUEST['mall_member_price_id']='0';
    }
    if(!isset($_REQUEST['club_id'])){
        $_REQUEST['club_id']=0;
    }
?>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="mall_member_price_id" value="<?php echo $_REQUEST['mall_member_price_id'];?>">
                <input type="hidden" name="club_id" value="<?php echo $_REQUEST['club_id'];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入商品名称或上架方案名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"><span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                        <th>商品编号</th>
                        <th>商品名称</th>
                        <th>商品属性</th>
                        <th>可下架数量</th>
                        <th>已销售数量</th>
                        <th>上架方案名称</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){?>
                        <?php 
                        /*
                        $n_count=0;
                        $detail=MallPriceSetDetails::model()->findAll('down_pricing_set_details_id='.$v->down_pricing_set_details_id.' and f_check=371');
                        if(!empty($detail)) foreach($detail as $d){
                            $n_count=$n_count+$d->Inventory_quantity;
                        } 
                        if($v->Inventory_quantity<=($n_count+$v->available_quantity)){ */?>
                        
                        <tr id="line<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" 
                            data-code="<?php echo $v->product_code; ?>" 
                            data-title="<?php echo $v->product_name; ?>" 
                            data-attr="<?php echo $v->json_attr; ?>" 
                            data-pricingtype="<?php echo $v->pricing_type; ?>" 
                            data-available="<?php echo $v->sale_order_data_quantity; ?>"
                            data-productid="<?php echo $v->product_id; ?>"  
                            data-downsetid="<?php echo $v->set_id; ?>"
                            data-upquantity="<?php echo $v->Inventory_quantity; ?>" 
                            data-inventory="<?php echo $v->Inventory_quantity; ?>"
                            data-saleid="<?php echo $v->sale_id; ?>" 
                            data-salename="<?php echo $v->sale_name; ?>">
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><?php echo $v->product_code; ?></td>
                            <td><?php echo $v->product_name; ?></td>
                            <td><?php echo $v->json_attr; ?></td>
                            <td><?php echo $v->Inventory_quantity-$v->sale_order_data_quantity; ?></td>
                            <td><?php echo $v->sale_order_data_quantity; ?></td>
                            <td><?php echo $v->event_name; ?></td>
                        </tr>
                    <?php } //}?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        var parentt = $.dialog.parent;  // 父页面window对象
        api = $.dialog.open.api;	// art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name:'确定',
                callback:function(){
                    return add_chose();
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        );
    });
    function add_chose(){
        var boxnum = $('table.list ').find('.selected');
        $.dialog.data('id', -1);
        $.dialog.data('title', boxnum);
        $.dialog.close();
    };
</script>