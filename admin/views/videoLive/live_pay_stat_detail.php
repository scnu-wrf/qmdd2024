<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
					<tr>
						<th>支付时间</th>
						<th>付费会员</th>
						<th>支付金额（元）</th>
						<th>支付方式</th>
					</tr>
				</thead>
                <tbody>
				<?php foreach($arclist as $k=>$v){ ?>
					<tr>
						<td><?php echo $v->order_Date;?></td>
						<td><?php echo $v->gf_name .'('.$v->order_gfaccount.')';?></td>
						<td><?php echo $v->buy_price;?></td>
						<td><?php echo $v->pay_supplier_type_name;?></td>
					</tr>
				<?php  } ?>
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
    api.button( { name: '取消' } );
});
</script>