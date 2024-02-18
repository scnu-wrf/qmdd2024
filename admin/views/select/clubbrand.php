<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="brand" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead><tr><th colspan="2">点击选择</th></tr></thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->brand_no; ?>" data-title="<?php echo $v->brand_title; ?>">
        <td width="70%"><?php echo $v->brand_title; ?></td>
        <td width="30%"><?php echo $v->club_name; ?></td>
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
        $.dialog.data('brand_id', $(this).attr('data-id'));
        $.dialog.data('brand_no', $(this).attr('data-code'));
        $.dialog.data('brand_title', $(this).attr('data-title'));
        $.dialog.close();
    });
});
</script>