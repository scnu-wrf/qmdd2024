<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <input type="hidden" name="order_num" value="<?php echo $_GET["order_num"];?>">
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
                        <th colspan="5">点击选择</th>
                    </tr>
                </thead>
                <tbody>
                	<tr>
                        <th style="text-align:center;">商品编码</th>
                        <th style="text-align:center;">商品名称</th>
                        <th style="text-align:center;">型号/规格</th>
                        <th style="text-align:center;">数量</th>
                        <th style="text-align:center;">金额</th>
                    </tr>
<?php foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id;?>" data-price="<?php echo $v->buy_price;?>" data-gfid="<?php echo $v->gfid;?>" data-code="<?php echo $v->product_code;?>" data-name="<?php echo $v->product_title;?>" data-attr="<?php echo $v->json_attr;?>" data-count="<?php echo $v->buy_count;?>">
                        <td width="15%"><?php echo $v->product_code; ?></td>
                        <td width="30%"><?php echo $v->product_title; ?></td>
                        <td width="15%"><?php echo $v->json_attr; ?></td>
                        <td width="10%"><?php echo $v->buy_count; ?></td>
                        <td width="15%"><?php echo $v->buy_count;?>&nbsp;x&nbsp;<?php echo $v->buy_price;?></td>
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
        $.dialog.data('product_name', $this.attr('data-name'));
        $.dialog.data('product_code', $this.attr('data-code'));
		$.dialog.data('product_attr', $this.attr('data-attr'));
        $.dialog.data('product_count', $this.attr('data-count'));
		$.dialog.data('buy_price', $this.attr('data-price'));
        $.dialog.close();
    });
});
</script>