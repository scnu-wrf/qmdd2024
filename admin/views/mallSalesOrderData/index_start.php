<meta http-equiv="refresh" content="180">
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>今日销售明细列表</h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();" style="margin-right: 15px;"><i class="fa fa-refresh"></i>刷新</a>
            <!-- <a class="btn" href="<?php //echo $this->createUrl('index_start',array('date'=>0));?>" >查看全部</a> -->
        </span>
    </div><!--box-title end-->  
    <div class="box-content">
        <div class="/*box-search*/">
            今日销售单：<b class="red"><?php echo $t_num; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
            今日销售额：<b class="red">￥<?php echo $money; ?></b>&nbsp;&nbsp;&nbsp;&nbsp;
            今日退货金额：<b>￥<?php echo $r_money; ?></b>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:5%;" class="check">序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th><?php echo $model->getAttributeLabel('product_title');?></th>
                        <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_price');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_count');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_amount');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_count');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_amount');?></th>
                        <th>下单时间</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                     $index = 1; 
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_title; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td><?php echo $v->ret_count ? "" : $v->buy_price; ?></td>
                        <td><?php echo $v->ret_count ? "" : $v->buy_count; ?></td>
                        <td><?php echo $v->ret_count ? "" : $v->total_pay; ?></td>
                        <td><?php echo $v->ret_count ?  $v->ret_count : ""; ?></td>
                        <td><?php echo $v->ret_count ?  $v->ret_amount : ""; ?></td>
                        <td><?php echo $v->order_Date;?></td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
    </div>
    <div class="box-page c"><?php $this->page($pages); ?></div>
</div><!--box end-->
<script>
    $(function(){
        console.log(Date());
    });
</script>