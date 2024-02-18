<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input  style="width:200px;" class="input-text" type="hidden" name="type" value="<?php echo Yii::app()->request->getParam('type');?>">
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
                        <th>点击打开</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id; ?>" data-title="<?php echo $v->video_title; ?>">
                        <td><a href="<?php if(!empty($v->gf_material)){ echo $v->gf_material->v_file_path.$v->gf_material->v_name; }?>" target="_blank"><?php echo $v->video_title; ?></a></td>
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
	/*
    $('.box-table tbody tr').on('click', function(){
        var id=$(this).attr('data-id');
        var title=$(this).attr('data-title');
        $.dialog.data('belong_id', id);
        $.dialog.data('belong_title', title);
        $.dialog.close();
    });
	*/
});
</script>