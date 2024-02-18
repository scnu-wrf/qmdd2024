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
                <thead><tr><th>点击选择</th></tr></thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->club_code; ?>" data-title="<?php echo $v->club_name; ?>" data-logo="<?php echo $v->club_logo_pic; ?>" data-address="<?php echo $v->club_address; ?>">
        <td><?php echo $v->individual_enterprise==403?$v->apply_name:$v->company; ?></td>
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
    api.button( { name: '取消' } );
    $('.box-table tbody tr').on('click', function(){
    //    var id=$(this).attr('data-id');
    //    var title=$(this).attr('data-title');
        $.dialog.data('club_id', $(this).attr('data-id'));
        $.dialog.data('club_code', $(this).attr('data-code'));
        $.dialog.data('club_title', $(this).attr('data-title'));
        $.dialog.data('club_logo_pic', $(this).attr('data-logo'));
        $.dialog.data('club_address', $(this).attr('data-address'));
        $.dialog.close();
    });
});
</script>