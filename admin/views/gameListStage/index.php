<?php
    if(!isset($_REQUEST['back'])) $_REQUEST['back'] = 0;
    if(!isset($_REQUEST['back'])){
        $_REQUEST['back'] = 0;
    }
    $url = '';
    if($_REQUEST['back']==1){
        $url = 'gameList/index_list';
    }
    else if($_REQUEST['back']==2){
        $url = 'gameList/game_club_search';
    }
    else if($_REQUEST['back']==3){
        $url = 'gameList/game_history_search';
    }
    else if($_REQUEST['back']==4){
        $url = 'gameList/game_club_history_search';
    }
?>
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
	<div class="box-detail-tab">
		<ul class="c">
			<?php $action=Yii::app()->controller->getAction()->id;?>
			<li class="current"><a href="">赛段设置</a></li>
			<li><a href="">赛程安排</a></li>
			<li><a href="">签位录入</a></li>
			<li><a href="">计时记分</a></li>
			<li><a href="">成绩确认</a></li>
			<li><a href="">总名次</a></li>
		</ul>
	</div>
    <div class="box-title c">
        <h1>当前界面：赛事 》赛事管理 》赛事列表 》<a class="nav-a">赛程/成绩</a></h1>
        <span class="back">
            <?php if($_REQUEST['back']>0) {?>
                <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
		<div class="box-search">
			<form action="<?php echo Yii::app()->request->url;?>" method="get">
				<input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<input type="hidden" name="game_id" value="<?php echo Yii::app()->request->getParam('game_id');?>">
				<input type="hidden" name="back" value="<?php echo Yii::app()->request->getParam('back');?>">
				<label style="margin-right:10px;">
					<span>赛事：</span><span><?php echo $game_name; ?></span>
				</label>
				<label id="label2" style="margin-right:10px;">
					<span>赛事项目：</span>
					<?php echo downList($project_list,'project_id','project_name','project_id','id="project_id" onchange="changeProjectid(this);"'); ?>
				</label>
				<label id="label2" style="margin-right:10px;">
					<span>比赛项目：</span>
					<select name="data_id" id="data_id">
						<option value="">请选择</option>
					</select>
				</label>
				<button id="search_submit" onclick="submitType='find';" class="btn btn-blue" type="submit">查询</button>
				<a class="btn btn-blue" style="vertical-align: middle;" href="<?php echo $this->createUrl('create',array('game_id'=>$game_id)); ?>">添加赛段</a>
				<a style="display:none;vertical-align: middle;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
			</form>
		</div><!--box-search end-->
        <form id="save_time" name="save_time">
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
							<th width="30px">序号</th>
							<th width="100px">赛事项目</th>
							<th width="100px">比赛项目</th>
							<th>赛段</th>
                            <th width="200px">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($arclist as $k=>$v){
                    ?>
                        <tr class="<?php echo $sc; ?> tr">
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
							<td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></span></td>
							<td><?php echo $v->game_project_name; ?></td>
							<td><?php echo $v->game_data_name; ?></td>
							<td><?php echo $v->stage_name; ?></td>
                            <td>
								<a class="btn" href="<?php echo $this->createUrl('update',array('id'=>$v->id)); ?>" title="编辑">编辑</a>
								<a class="btn" href="javascript:;" onclick="create_arrange('<?php echo $v->id;?>');" title="生成赛程">生成赛程</a>
								<a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div><!--box-table end-->
        </form>
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
	
	changeProjectid($('#project_id'));
    function changeProjectid(obj){
        var val = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(val > 0){
            var pr = '<?php echo $data_id; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('GameSignList/getDataByProject'); ?>&game_id=<?php echo $game_id;?>&project_id='+val,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data[0].length;i++){
                        s_html += '<option value="'+data[0][i]['id']+'" '+((data[0][i]['id']==pr) ? 'selected>' : '>')+data[0][i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
        }
    }
</script>
<script>
function create_arrange(id){
	var url = '<?php echo $this->createUrl('create_arrange', array('id'=>'ID'));?>';
	we.overlay('show');
	var fnCancel = function() {
		url = url.replace(/ID/, id);
        $.ajax({
			type: 'get',
			url: url,
			dataType: 'json',
			success: function(data) {
				if (data.status == 1) {
					we.msg('check', data.msg, function() {
						we.loading('hide');
						we.reload();
					});
				} else {
					we.msg('error', data.msg, function() {
						we.loading('hide');
					});
				}
			}
		});
    };
    $.fallr('show', {
        buttons: {
            button1: {text: '确定', danger: true, onclick: fnCancel},
            button2: {text: '取消'}
        },
        content: '确定生成赛程？',
        icon: 'trash',
        afterHide: function() {
            we.loading('hide');
        }
    });
	
}


</script>