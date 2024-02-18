<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>选择方案：</span>
                    <?php echo downList($set_id,'id','name','set_id'); ?>
                </label>
                <br>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="keywords" style="width:200px;margin-left: 12px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编码/商品名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="4">点击选择</th>
                    </tr>
                    <tr>
                        <td>商品编码</td>
                        <td>商品名称</td>
                        <td>商品价格</td>
                        <td>体育币</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($arclist as $v){ ?>
                        <tr data-id="<?php echo $v->id;?>" 
                            data-name="<?php echo $v->product_name; ?>" 
                            data-code="<?php echo $v->product_code; ?>" 
                            data-productid="<?php echo $v->product_id; ?>"
                            data-shoppingprice="<?php echo $v->shopping_price; ?>"
                            data-salebean="<?php echo $v->sale_bean; ?>"
                            data-mallpricingdetailsid="<?php echo $v->mall_pricing_details_id; ?>">
                            <td width="20%"><?php echo $v->product_code; ?></td>
                            <td width="30%"><?php echo $v->product_name; ?></td>
                            <td width="20%"><?php echo $v->shopping_price; ?></td>
                            <td width="30%"><?php echo $v->sale_bean; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        api = $.dialog.open.api;	// 			art.dialog.open扩展方法
        if (!api) return;

        // 操作对话框
        api.button(
            {
                name: '取消'
            }
        );
        $('.box-table tbody tr').on('click', function(){
            var $this=$(this);
            $.dialog.data('id', $this.attr('data-id'));
            $.dialog.data('name', $this.attr('data-name'));
            $.dialog.data('code', $this.attr('data-code'));
            $.dialog.data('product_id', $this.attr('data-productid'));
            $.dialog.data('shoppingprice', $this.attr('data-shoppingprice'));
            $.dialog.data('salebean', $this.attr('data-salebean'));
            $.dialog.data('mallpricingdetailsid', $this.attr('data-mallpricingdetailsid'));
            $.dialog.close();
        });
    });
</script>