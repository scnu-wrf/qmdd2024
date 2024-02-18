
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事 》赛事管理 》<a class="nav-a">赛事修改</a></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
		<div class="box-header">
            <a class="btn" id="add_edit_btn" href="javascript:;" onclick="">添加修改</a>
        </div><!--box-header end-->
		<div class="box-search">
			<form action="<?php echo Yii::app()->request->url;?>" method="get">
				<input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:10px;">
					<span>赛事类型：</span>
					<?php echo downList($game_level,'f_id','F_NAME','game_level',''); ?>
				</label>
				<label style="margin-right:10px;">
					<span>项目：</span>
					<?php echo downList($project_list,'project_id','project_name','project_id',''); ?>
				</label>
				<label>
					<span>关键字：</span>
					<input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="赛事编号/名称/项目">
				</label>
				<button id="search_submit" onclick="submitType='find';" class="btn btn-blue" type="submit">查询</button>
			</form>
		</div><!--box-search end-->
        <form id="save_time" name="save_time">
            <div class="box-table">
                <table class="list">
                    <thead>
                        <tr>
							<th width="30px">序号</th>
							<th width="110px">赛事编号</th>
							<th width="200px">赛事名称</th>
							<th>赛事类型</th>
							<th><?php echo $model->getAttributeLabel('udate');?></th>
							<th><?php echo $model->getAttributeLabel('admin_id');?></th>
							<th width="120px"><?php echo $model->getAttributeLabel('admin_club_id');?></th>
                            <th width="110px">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach($arclist as $k=>$v){
                    ?>
                        <tr>
							<td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></span></td>
							<td><?php echo $v->game_code; ?></td>
							<td><?php echo $v->game_title; ?></td>
							<td><?php echo $v->level_name; ?></td>
							<td><?php echo date("Y-m-d H:i",strtotime($v->udate)); ?></td>
							<td><?php echo $v->admin_account; ?></td>
							<td><?php echo $v->admin_club_name; ?></td>
                            <td>
								<a class="btn" href="<?php echo $this->createUrl('update',array('id'=>$v->id)); ?>" title="详情">详情</a>
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
$(function(){
    var $add_edit_btn=$('#add_edit_btn');
    $add_edit_btn.on('click', function(){
		$.dialog.data('game_id', 0);
        $.dialog.open('<?php echo $this->createUrl("game_select");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择视频分集',
            width:'65%',
            height:'65%',
            close: function () {
				if($.dialog.data('game_id')>0){
					we.overlay('show');
					location.href="<?php echo $this->createUrl('GameList/update_edit');?>&id="+$.dialog.data('game_id')+"&type="+$.dialog.data('game_type')+"&p_id=1";
				}
            }
        });
    });
});


</script>