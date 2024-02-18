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
                    <tr><th colspan="2">点击选择</th></tr>
                    <tr>
                        <th><?php echo $model->getAttributeLabel('activity_code');?></th>
                        <th><?php echo $model->getAttributeLabel('activity_title');?></th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id; ?>">
                        <td width="70%"><?php echo $v->activity_code;?></td>
                        <td width="70%"><?php echo $v->activity_title;?></td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var arclist=<?php echo json_encode(toArray($arclist,'id,activity_title,video_live_id'));?>
</script>
<script>
$(function(){
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button( { name: '取消' } );
    $('.box-table tbody tr').on('click', function(){
        var id=$(this).attr('data-id');
        $.dialog.data('id', $(this).attr('data-id'));
        $.each(arclist,function(e,q){
            if(id==q.id){
                $.dialog.data('data', JSON.stringify(q));
            }
        })
        $.dialog.close();
    });
});
</script>