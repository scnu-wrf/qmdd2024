<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="club" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="按编号/名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
					<tr>
						<th colspan=8>点击选择</th>
					</tr>
                    <tr>
                        <th width="20%" class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"></th>
                        <th class="check">赛事编号<span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                        <th class="check">赛事名称</th>
                        <th class="check">赛事类型</th>
                        <th class="check">赛事等级</th>
                        <th class="check">比赛时间</th>
                        <th class="check">赛事状态</th>
                        <th class="check">发布单位</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr id="line<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->video_title; ?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->game_code; ?></td>
                        <td><?php echo $v->game_title; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php echo $v->area_name; ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($v->game_time)).'<br>'.date("Y-m-d H:i",strtotime($v->game_time_end)); ?></td>
                        <td><?php echo $v->game_statec; ?></td>
                        <td><?php echo $v->game_club_name; ?></td>
                    </tr>
<?php } ?>
					<tr>
						<td colspan=2>下架原因<span class="required"></span></td><td colspan=6><textarea class="input-text" id="down_reason"></textarea></td>
					</tr>
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
    api.button(
			{
                name:'下架',
                callback:function(){
					$.dialog.data('down_type',<?php if(empty(get_session('use_club_id'))){echo 3;}else{echo 1;}?>);
                    return add_chose();
                }
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
    );
});

function add_chose(){
	we.overlay('show');
	if ($("#down_reason").val()=="") {
        we.msg('error', '请填写下架原因', function() {
            we.loading('hide');
        });
        return false;
    }
	var boxnum = $('table.list ').find('.selected');
	$.dialog.data('game_id', -1);
	$.dialog.data('game_list', boxnum );
	$.dialog.data('down_reason', $("#down_reason").val() );
	$.dialog.close();
 };
</script>