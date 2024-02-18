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
                <thead><tr><th colspan="4">点击选择</th></tr></thead>
                        <th>地址</th>   
                        <th>联系人</th>                   
                        <th>联系电话</th>
                        <th>邮编</th>
                <tbody>
<?php foreach($arclist as $v){ ?>
    <tr data-id="<?php echo $v->id; ?>" data-address="<?php echo $v->address; ?>" data-name="<?php echo $v->consignee; ?>" data-phone="<?php echo $v->phone; ?>" data-zipcode="<?php echo $v->zipcode; ?>">
        <td width="50%"><?php echo $v->address; ?></td>
        <td width="20%"><?php echo $v->consignee; ?></td>
        <td width="20%"><?php echo $v->phone; ?></td>
        <td width="10%"><?php echo $v->zipcode; ?></td>
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
        $.dialog.data('address_id', $(this).attr('data-id'));
        $.dialog.data('address', $(this).attr('data-address'));
        $.dialog.data('name', $(this).attr('data-name'));
        $.dialog.data('phone', $(this).attr('data-phone'));
        $.dialog.data('zipcode', $(this).attr('data-zipcode'));
        $.dialog.close();
    });
});
</script>