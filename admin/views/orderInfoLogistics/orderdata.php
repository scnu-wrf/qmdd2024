<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="keywords" style="width:200px;" class="input-text" type="text" placeholder="请输入订单号/商品编号/商品名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                	<tr>
                        <th width="5%">序号</th>
                    	<th width="10%">订单号</th>
                        <th width="10%">商品编号</th>
                        <th width="10%">商品货号</th>
                        <th width="10%">商品信息</th>
                        <th>收货人</th>
                        <th width="20%">收货地址</th>
                        <th width="10%">联系电话</th>
                        <th width="10%">买家留言</th>
                        <th style="width:70px;">创建时间</th>
                    </tr>
                </thead>
                <tbody>
                	
<?php $index = 1;
 foreach($arclist as $v){ ?>
                    <?php $order=MallSalesOrderInfo::model()->find('order_num="'.$v->order_num.'"'); ?>
                    <tr data-id="<?php echo $v->id;?>">
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                    	<td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->supplier_code; ?></td>
                        <td><?php echo $v->product_title; ?>，<?php echo $v->json_attr; ?>，<?php echo $v->buy_count; ?></td>
                        <td><?php echo $order['rec_name']; ?></td>
                        <td><?php echo $order['rec_address']; ?></td>
                        <td><?php echo $order['rec_phone']; ?></td>
                        <td><?php echo $v->leaving_a_message; ?></td>
                        <td><?php echo $v->order_Date; ?></td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->