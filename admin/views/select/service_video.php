<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input class="input-text" type="hidden" name="type" value="<?php echo $_GET["type"];?>">
                <input class="input-text" type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="service_id" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                    <tr data-id="<?php echo $v->id;?>" data-name="<?php echo $v->video_title;?>" data-code="<?php echo $v->video_code;?>" data-attrid="" data-attr="">
                        <td><?php echo $v->video_title; ?></td>
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
    $('.box-table tbody tr').on('click', function(){
		var id=$(this).attr('data-id');
        var code=$(this).attr('data-code');
        var name=$(this).attr('data-name');
		var data_id=$(this).attr('data-attrid');
        var json_attr=$(this).attr('data-attr');
        $.dialog.data('service_id', id);
        $.dialog.data('service_code', code);
        $.dialog.data('service_name', name);
        $.dialog.data('service_data_id', data_id);
        $.dialog.data('service_data_name', json_attr);
        $.dialog.close();
    });
});
</script>