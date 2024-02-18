<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="15%">商品编号</th>
                        <th width="20%">商品名称</th>
                        <th width="15%">型号/规格</th>
                        <th width="10%">单价</th>
                        <th width="10%">数量</th>
                        <th width="10%">金额</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_title; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td><?php echo $v->buy_price; ?></td>
                        <td><?php echo $v->buy_count; ?></td>
                        <td><?php echo $v->buy_amount; ?></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->