<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="赛事编号/名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
				<colgroup>
					<col></col>
					<col width="30%"></col>
					<col></col>
					<col></col>
					<col></col>
				</colgroup>
                <thead>
					<tr>
						<th colspan=5>点击选择</th>
					</tr>
                    <tr>
                        <th class="check">赛事编号</th>
                        <th class="check">赛事名称</th>
                        <th class="check">赛事类型</th>
                        <th class="check">赛事等级</th>
                        <th class="check">发布单位</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr data-game_id="<?php echo $v->id?>" data-game_type="<?php echo $v->game_type?>">
                        <td><?php echo $v->game_code; ?></td>
                        <td><?php echo $v->game_title; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php echo $v->area_name; ?></td>
                        <td><?php echo $v->game_club_name; ?></td>
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
    var parentt = $.dialog.parent;				// 父页面window对象
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button( { name: '取消' } );
	$('.box-table tbody tr').on('click', function(){
        $.dialog.data('game_id', $(this).attr('data-game_id'));
        $.dialog.data('game_type', $(this).attr('data-game_type'));
        $.dialog.close();
    });
});
</script>