<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="type" value="<?php echo Yii::app()->request->getParam('type');?>">
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
                        <th>点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->select_id; ?>" data-code="<?php echo $v->v_name; ?>" data-title="<?php if($v->select_title!=''){ echo $v->select_title;}else{ echo $v->v_name; } ?>" data-clubid="<?php echo $v->club_id; ?>" data-pic="<?php echo $v->v_pic; ?>" data-path="<?php echo $v->v_file_path.$v->v_name;?>" data-duration="<?php echo $v->v_file_insert_size;?>" data-file_format="<?php echo pathinfo( parse_url($v->v_file_path . $v->v_name)['path'] )['extension'];?>">
                        <td><?php if($v->select_title!=''){ echo $v->select_title;}else{ echo $v->v_name; } ?></td>
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
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button(
        {
            name: '取消'
        }
    );
    $('.box-table tbody a').on('click', function(event){
         event.stopPropagation();
    });
    $('.box-table tbody tr').on('click', function(){
        var id=$(this).attr('data-id');
        var code=$(this).attr('data-code');
        var title=$(this).attr('data-title');
		var club_id=$(this).attr('data-clubid');
		var pic=$(this).attr('data-pic');
		var path=$(this).attr('data-path');
		var duration=$(this).attr('data-duration');
		var file_format=$(this).attr('data-file_format');
        $.dialog.data('material_id', id);
        $.dialog.data('material_code', code);
        $.dialog.data('material_title', title);
		$.dialog.data('club_id', club_id);
		$.dialog.data('v_pic', pic);
		$.dialog.data('v_path', path);
		$.dialog.data('duration', duration);
		$.dialog.data('file_format', file_format);
        $.dialog.close();
    });
});
</script>