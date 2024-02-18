<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="7">点击选择</th>
                    </tr>
                </thead>
                	<tr>
                    	<td width="15%">订单号</td>
                        <td width="10%">商品货号</td>
                        <td width="10%">下单人</td>
                        <td width="15%">商品信息</td>
                        <td width="10%">收货人</td>
                        <td width="10%">联系电话</td>
                        <td width="30%">收货地址</td>
                    </tr>
                <tbody>
                	
<?php foreach($arclist as $v){ ?>
                    <?php $order=MallSalesOrderInfo::model()->find('order_num="'.$v->order_num.'"'); ?>
                    <tr data-id="<?php echo $v->id;?>" data-num="<?php echo $v->order_num;?>" data-gfid="<?php echo $v->gfid;?>" data-code="<?php echo $v->product_code;?>" data-name="<?php echo $v->product_title;?>" data-attr="<?php echo $v->json_attr;?>" data-count="<?php echo $v->buy_count;?>" data-recname="<?php echo $order['rec_name']; ?>" data-address="<?php echo $order['rec_address']; ?>" data-phone="<?php echo $order['rec_phone']; ?>">
                    	<td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->supplier_code; ?></td>
                        <td><?php if(!empty($v->order_info)) echo $v->order_info->order_gfaccount; ?>(<?php echo $v->gf_name; ?>)</td>
                        <td><?php echo $v->product_title; ?>，<?php echo $v->json_attr; ?>，<?php echo $v->buy_count; ?></td>
                        <td><?php echo $order['rec_name']; ?></td>
                        <td><?php echo $order['rec_phone']; ?></td>
                        <td><?php echo $order['rec_address']; ?></td>
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
        $.dialog.data('orderdata_id', $this.attr('data-id'));
		$.dialog.data('gfid', $this.attr('data-gfid'));
		$.dialog.data('order_num', $this.attr('data-num'));
        $.dialog.data('product_name', $this.attr('data-name'));
        $.dialog.data('product_code', $this.attr('data-code'));
		$.dialog.data('product_attr', $this.attr('data-attr'));
        $.dialog.data('product_count', $this.attr('data-count'));
		
		$.dialog.data('rec_name', $this.attr('data-recname'));
		$.dialog.data('rec_address', $this.attr('data-address'));
        $.dialog.data('rec_phone', $this.attr('data-phone'));
        $.dialog.close();
    });
});
</script>