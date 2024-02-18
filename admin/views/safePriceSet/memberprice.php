<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="15%" style="text-align:center">销售方式</th>
                        <th width="15%" style="text-align:center">销售对象</th>
                        <th width="15%" style="text-align:center">认证类型</th>
                        <th width="10%" style="text-align:center">会员等级</th>
                        <th width="10%" style="text-align:center">销售价折扣率</th>
                        <th width="10%" style="text-align:center">体育豆折扣率</th>
                        <th width="10%" style="text-align:center">销售价</th>
                        <th width="10%" style="text-align:center">体育豆</th>
                        <th width="10%" style="text-align:center">限购数量</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr>
                        <td><?php echo $v->sale_show_name; ?></td>
                        <td><?php echo $v->customer_name; ?></td>
                        <td><?php $paytype=array(0=>'无偿', 1=>'有偿', 453=>'免费认证', 454=>'轻松支付'); echo $paytype[$v->gf_salesperson_paytype]; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php echo $v->discount_price; ?>%</td>
                        <td><?php echo $v->discount_beans; ?>%</td>
                        <td><?php echo $v->shopping_price; ?></td>
                        <td><?php echo $v->shopping_beans; ?></td>
                        <td><?php echo $v->sale_max; ?></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->