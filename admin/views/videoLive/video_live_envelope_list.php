<div class="box">
    <div class="box-content">
        <div class="box-table">
            <table class="list">
                <thead>
					<tr>
						<th>排名</th>
						<th>账号</th>
						<th>昵称</th>
						<th>红包数量</th>
						<th>打赏金额（元）</th>
					</tr>
				</thead>
                <tbody>
				<?php foreach($arclist as $k=>$v){ ?>
					<tr>
						<td><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></td>
						<td><?php echo $v->GF_ACCOUNT;?></td>
						<td><?php echo $v->GF_NAME;?></td>
						<td><?php echo $v->gift_num_amount;?></td>
						<td><?php echo $v->gift_price_amount;?></td>
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