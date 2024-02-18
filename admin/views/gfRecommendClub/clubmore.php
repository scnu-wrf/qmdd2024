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
                <label style="margin-right:10px;vertical-align: middle;">
                    <span style="vertical-align: middle;">单位类型：</span>
					<?php $club_type=ClubType::model()->findAllBySql("select a.* from club_type as a,(select * from club_type where f_id in (1124,1471,1467,1479)) as b where left(a.f_ctcode,3)=b.f_ctcode and a.f_level=2");?>
                    <?php echo downList($club_type,'id','f_ctname','partnership_type','style="vertical-align: middle;"'); ?>
                </label>
                <label style="margin-right:10px;vertical-align: middle;">
                    <span style="vertical-align: middle;">关键字：</span>
                    <input id="club" style="width:100px;vertical-align: middle;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
					<tr>
						<th class="check">
							<input id="j-checkall" class="input-check" type="checkbox" title="全选">
							<span style="display:none;"><a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="add_chose();">添加</a></span>
						</th>
						<th>单位编号</th>
						<th>单位名称</th>
						<th>单位类型</th>
					</tr>
				</thead>
                <tbody>
                <?php foreach($arclist as $v){ ?>
                    <tr id="line<?php echo $v->select_id; ?>" data-id="<?php echo $v->select_id; ?>" data-code="<?php echo $v->select_code; ?>" data-title="<?php echo $v->select_title; ?>">
                        <td class="check check-item" width="8%"><input class="input-check" type="checkbox" id="id<?php echo CHtml::encode($v->select_id); ?>" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td width="20%"><?php echo $v->select_code; ?></td>
                        <td><?php echo $v->select_title; ?></td>
                        <td width="20%"><?php echo $v->partnership_name; ?></td>
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
                name:'添加',
                callback:function(){
                    return add_chose();
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
	 );
});


function add_chose(){
        var boxnum = $('table.list ').find('.selected');
        $.dialog.data('club_id', -1);
        $.dialog.data('club_code', $(this).attr('data-code'));
        $.dialog.data('club_title', boxnum );
        $.dialog.close();
 };
</script>