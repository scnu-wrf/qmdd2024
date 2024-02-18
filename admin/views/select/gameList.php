<?php if(empty($_GET["club_id"])){
    $_GET["club_id"]='';
}
?>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="game" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead><tr><th>点击选择</th></tr></thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->game_code; ?>" data-title="<?php echo $v->game_title; ?>" data-star="<?php echo $v->dispay_star_time; ?>" data-end="<?php echo $v->dispay_end_time; ?>">
        <td><?php echo $v->game_title; ?></td>
    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var arclist=<?php echo json_encode(toArray($arclist,'id,game_code,game_title,dispay_star_time,dispay_end_time,video_live_id'));?>
</script>
<script>
$(function(){
    api = $.dialog.open.api;    //          art.dialog.open扩展方法
    if (!api) return;

    // 操作对话框
    api.button( { name: '取消' } );
    $('.box-table tbody tr').on('click', function(){
        var id=$(this).attr('data-id');
        $.dialog.data('game_id', $(this).attr('data-id'));
        $.dialog.data('game_title', $(this).attr('data-title'));
        $.dialog.data('star', $(this).attr('data-star'));
        $.dialog.data('end', $(this).attr('data-end'));
        $.each(arclist,function(e,q){
            if(id==q.id){
                $.dialog.data('data', JSON.stringify(q));
            }
        })
        $.dialog.close();
    });
});
</script>