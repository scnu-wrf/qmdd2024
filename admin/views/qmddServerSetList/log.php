<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <td colspan="10">
                    <?php
					$s_type='';
					$s_usertype='';
					 if(!empty($detail->s_type)) $s_type=$detail->s_type->t_name;
					 if(!empty($detail->s_usertype)) $s_usertype=$detail->s_usertype->f_uname; ?>
                    <?php 
                    echo "服务:".$detail->s_code." ".$detail->s_name.' '.$s_type.' '.$s_usertype.' '.$detail->s_levelname. '  发布单位:'.$detail->club_name;
                    ?></td>
                </tr> 
                <tr>
                    <td colspan="10">销售单：<span class="red"><?php echo $b_count;?></span>&nbsp;&nbsp;销售额：<span class="red">￥<?php echo $s_amount;?></span>&nbsp;&nbsp;退货单：<span><?php echo $r_count;?></span></td>
                </tr>   
                    <tr>
                    	<th width="5%" style='text-align: center;'>序号</th>
                        <th width="20%">订单号</th>
                        <th width="8%">服务标题</th>
                        <th width="8%">型号/规格</th>
                        <th width="8%">购买单价</th>
                        <th width="8%">购买数量</th>
                        <th width="8%">退货金额</th>
                        <th width="8%">退货数量</th>
                        <th width="8%">实付金额</th>
                        <th width="15%">下单时间</th>
                    </tr>
                </thead>
                <tbody>
<?php $index=1;
 foreach($arclist as $v){  ?>
                <tr>
                	<td style='text-align: center;'><?php echo $index; ?></td>
                    <td><?php echo $v->order_num; ?></td>
                    <td><?php echo $v->service_name; ?></td>
                    <td><?php echo $v->service_data_name; ?></td>
                    <td><?php echo $v->buy_amount; ?></td>
                    <td><?php echo $v->buy_count; ?></td>
                    <td><?php echo $v->ret_amount; ?></td>
                    <td><?php echo $v->ret_count; ?></td>
                    <td><?php echo $v->buy_amount*$v->buy_count; ?></td>
                    <td><?php echo $v->order_Date; ?></td>
                </tr>         

<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->