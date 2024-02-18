<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table>
                <tr>
                    <td>
                    <?php 
                    echo '供应商:'.$detail->supplier_name."  商品:".$detail->product_code."/".$detail->product_name.'/'.$detail->json_attr;
                    ?></td>
                </tr>
            </table>
            <table class="list">
                <thead>    
                    <tr>
                        <th width="10%" rowspan="2" style='text-align: center;'>上架</th>
                        <th width="10%">上架数量</th>
                        <th width="10%">商品单价(元)</th>
                        <th width="10%">运费(元/件)</th>
                        <th width="5%">已售数量</th>
                        <th width="10%">销售总额(含运费,元)</th>
                        <th width="5%">退换数量</th>
                        <th width="10%">退款总额（元）</th>
                        <th width="10%">上架剩余库存</th>
                        <th width="5%">下架数量合计</th>
                        <th width="15%"></th>
                    </tr>
<?php $xjz=0;$ret_p=0;
foreach($arclist as $v){
    if($v->down_set_id>0) $xjz=$xjz+$v->buy_count;
    if($v->change_type==1137) $ret_p=$ret_p+$v->ret_amount;
} 
 ?>
                <tr>
                    <th><?php echo $detail->Inventory_quantity; ?></th>
                    <th><?php echo $detail->sale_price; ?></th>
                    <th><?php echo $detail->post_price; ?></th>
                    <th><?php echo $detail->sale_order_data_quantity-$xjz; ?></th>
                    <th><?php echo sprintf("%.2f",($detail->sale_order_data_quantity-$xjz)*($detail->sale_price+$detail->post_price)); ?></th>
                    <th><?php echo $detail->return_quantity; ?></th>
                    <th><?php echo sprintf("%.2f",$ret_p); ?></th>
                    <th><?php echo $detail->Inventory_quantity-$detail->sale_order_data_quantity; ?></td>
                    <th><?php echo $xjz; ?></th>
                    <th></th>
                </tr>
                </thead>
            </table>
            <table class="list">
                <thead>    
                    <tr>
                    	<th width="5%" style='text-align: center;'>序号</th>
                        <th width="5%">明细类型</th>
                        <th width="10%">订单号/售后单号</th>
                        <th width="10%">销售价格（元）</th>
                        <th width="10%">运费(元/件)</th>
                        <th width="5%">销售数量</th>
                        <th width="10%">订单总额（含运费,元）</th>
                        <th width="5%">退换数量</th>
                        <th width="10%">退款金额（元）</th>
                        <th width="10%">上架剩余库存</th>
                        <th width="5%">下架数量</th>
                        <th width="15%">时间</th>
                    </tr>
                </thead>
                <tbody>
         
<?php $index=1; 
 $kc=$detail->Inventory_quantity;
 $xs=0;$xj=0;
foreach($arclist as $v){ 
  $xs=$xs+(($v->ret_count==0) ? $v->buy_count : 0);
  if($v->down_set_id>0){
    $xjz=$xjz+$v->buy_count;
  }
  $xj=(($v->down_set_id>0) ? $v->buy_count : 0);
  $txt1='';
  $txt2='';
  $txt3='';
  $col='';
  $c_type='';
 if ($v->change_type==0 && $v->down_set_id==0){$txt1='(购买数量)';$col='red';$c_type='购买';}
 elseif ($v->change_type==0 && $v->down_set_id>0) {$col='gray';$c_type='下架';}
 elseif ($v->change_type==1137) {$txt2='(退货数量)';$col='blue';}
 elseif ($v->change_type==1138) {$txt3='(换货数量)';$col='green';}
 // $kc=$kc-$v->buy_count;
?>
                    <tr>
                	    <td style='text-align: center;'><?php echo $index ?></td>
                        <td style=" <?php echo 'color:'.$col; ?>"><?php echo (!empty($v->type)) ? $v->type->F_NAME : $c_type; ?></td>
                        <td><?php echo (empty($v->lowerset)) ? $v->order_num : $v->lowerset->event_code; ?></td>
                        <td><?php echo ($v->ret_count==0 && $xj==0) ?  $v->buy_price : "" ; ?></td>
                        <td><?php echo $v->post; ?></td>
                        <td><?php echo ($v->ret_count==0 && $xj==0) ? $v->buy_count: "" ; ?></td>
                        <td><?php echo ($v->ret_count==0 && $xj==0) ?  sprintf("%.2f",$v->total_pay) : "" ; ?></td>
                        <td><?php echo ($v->ret_count!=0 && $xj==0) ? $v->ret_count.$txt2.$txt3 : ""; ?></td>
                        <td><?php echo ($v->ret_count!=0 && $xj==0) ? $v->ret_amount : ""; ?></td>
                        <td><?php echo $kc-$xs; ?></td>
                        <td><?php echo ($xj) ? $xj : ""; ?></td>
                        <td><?php echo $v->order_Date; ?></td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->