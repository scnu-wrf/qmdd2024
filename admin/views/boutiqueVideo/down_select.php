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
						<th colspan=6>点击选择</th>
					</tr>
                    <tr>
                        <th width="20%" class="check"><input id="j-checkall" class="input-check" type="checkbox" value="全选"></th>
                        <th class="check">视频编号<span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span></th>
                        <th class="check">视频名称</th>
                        <th class="check">发布分类</th>
                        <th class="check">分集数</th>
                        <th class="check">发布单位</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr id="line<?php echo $v->id; ?>" data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->video_title; ?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->video_code; ?></td>
                        <td><?php echo $v->video_title; ?></td>
                        <td><?php echo $v->publish_classify_name; ?></td>
                        <td><?php echo $v->series_num; ?></td>
                        <td><?php echo $v->club_name; ?></td>
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
        var boxnum = $('table.list ').find('.selected');
		$.dialog.data('video_id', -1);
		$.dialog.data('video_list', boxnum );
        $.dialog.close();
 };
</script>