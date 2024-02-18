<?php if (!isset($_REQUEST['real_sex'])) {$_REQUEST['real_sex']='0';} ?>
<?php if (!isset($_REQUEST['ms_start'])) {$_REQUEST['ms_start']=' ';} ?>
<?php if (!isset($_REQUEST['ms_end'])) {$_REQUEST['ms_end']=' ';} ?>
<div class="box">
    <div class="box-content">
        <div>
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="real_sex" value="<?php echo $_REQUEST['real_sex'];?>">
                <input type="hidden" name="ms_start" value="<?php echo $_REQUEST['ms_start'];?>">
                <input type="hidden" name="ms_end" value="<?php echo $_REQUEST['ms_end'];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input id="clubmemberlist" style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th colspan="2">点击选择</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr data-id="<?php echo $v->id; ?>" data-code="<?php echo $v->gf_account; ?>" data-title="<?php echo $v->zsxm; ?>" data-title="<?php echo $v->zsxm; ?>" data-club="<?php echo $v->club_id; ?>" data-clubname="<?php echo $v->club_name; ?>">
                        <td width="30%"><?php echo $v->gf_account; ?></td>
                        <td width="70%"><?php echo $v->zsxm; ?></td>
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
            name: '取消'
        }
    );
    $('.box-table tbody tr').on('click', function(){
        $.dialog.data('id',$(this).attr('data-id'));
		$.dialog.data('gf_account',$(this).attr('data-code'));
        $.dialog.data('zsxm',$(this).attr('data-title'));
        $.dialog.data('club_id',$(this).attr('data-club'));
        $.dialog.data('club_name',$(this).attr('data-clubname'));
        $.dialog.close();
    });
});
</script>