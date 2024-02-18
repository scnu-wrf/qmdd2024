<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
						<th>序号</th>
						<th>账号</th>
						<th>用户名称</th>
						<th>用户类型</th>
						<th>授权角色</th>
						<th>授权日期</th>
					</tr>
				</thead>
                <tbody>
				<?php 
				$index = 1;
				foreach($arclist as $k=>$v){ ?>
				<?php 
					$server=Yii::app()->db->createCommand("select * from gf_user_1 u where u.GF_ID=".$v->admin_gfid)->queryRow();
				?>
					<tr data-admin_id="<?php echo $v->id?>" data-admin_name="<?php echo $server["ZSXM"]?>" data-admin_gfaccount="<?php echo $v->admin_gfaccount?>" data-admin_gfnick="<?php echo $v->admin_gfnick?>">
						<td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
						<td><?php echo $v->admin_gfaccount?></td>
						<td><?php echo $v->admin_gfnick?></td>
						<td><?php echo ($v->lang_type==0?"单位":"个人")?></td>
						<td><?php echo $v->role_name?></td>
						<td><?php echo $v->uDate?></td>
					</tr>
					<?php $index++; } ?>
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
    $('.box-table tbody tr').on('click', function(){
        $.dialog.data('admin_id', $(this).attr('data-admin_id'));
        $.dialog.data('admin_name', $(this).attr('data-admin_name'));
        $.dialog.data('admin_gfaccount', $(this).attr('data-admin_gfaccount'));
        $.dialog.data('admin_gfnick', $(this).attr('data-admin_gfnick'));
        $.dialog.close();
    });
});
</script>