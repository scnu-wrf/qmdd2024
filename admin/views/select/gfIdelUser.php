<style>
    .box-table .list tr:hover td{
        background-color:transparent;
    }
    .box-table .list tr td:hover{
        background-color:#f8f8f8;
    }
</style>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>搜索指定号码:</span>
                    <input id="gfuser" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>换一批</a>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="4">点击选择</th>
                    </tr>
                </thead>
                <tbody>
                <tr>
<?php foreach($arclist as $v=>$v2){?>
            <td data-id="<?php echo $v2->id; ?>"><?php echo $v2->non_account; ?></td>
            <?php if(($v+1)%4==0&&($v+1)!=count($arclist)){?>
                </tr><tr>
            <?php } ?>
<?php } ?>
                </tr>
                </tbody>
            </table>
        </div><!--box-table end-->
        <!-- <div class="box-page c"><?php //$this->page($pages); ?></div> -->
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
            name: '取消'
        }
    );
    $('.box-table tbody td').on('click', function(){
        $.dialog.data('id',$(this).attr('data-id'));
        $.dialog.data('non_account',$(this).text());
        $.dialog.close();
    });
});
</script>
