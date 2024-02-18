<?php
    $data_id = empty($_REQUEST['data_id']) ? $data_id : $_REQUEST['data_id'];
    $game_id = empty($_REQUEST['game_id']) ? 0 : $_REQUEST['game_id'];
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
    .box-table .list tr th,.box-table .list tr td{ text-align: center; }
    .table-num-money{ border-right: 1px #ddd solid;border-bottom: 1px #ddd solid; }
    .table-num-money tr td{ border-top: 1px #ddd solid;border-left: 1px #ddd solid;padding: 5px;font-weight:700; }
    .table-num-money tr td:last-child{ border-right: 1px #ddd solid; }
    .table-num-money tr td:nth-child(odd){ width:85px; }
    .table-num-money tr td:nth-child(even){ width:100px;color:red; }
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
	<div class="box-title c">
        <h1>当前界面：》 赛事 》 赛事管理 》赛事列表  》 <a class="nav-a">报名表</a></h1>
        <span style="float:right;margin-right:15px;"><a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="gamesign c">
		<div class="box-content">
			<div class="box-search">
				<form action="<?php echo Yii::app()->request->url;?>" method="get">
					<input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
					<input type="hidden" name="game_id" value="<?php echo Yii::app()->request->getParam('game_id');?>">
					<input type="hidden" name="back" value="<?php echo Yii::app()->request->getParam('back');?>">
					<label style="margin-right:10px;">
						<span>赛事项目：</span>
						<?php echo downList($project_list,'project_id','project_name','project_id','id="project_id" onchange="changeProjectid(this);"'); ?>
					</label>
					<label style="margin-right:10px;">
						<span>比赛项目：</span>
						<select name="data_id" id="data_id">
							<option value="">请选择</option>
						</select>
					</label>
					<label>
						<span>关键字：</span>
						<input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="选手/队名称">
					</label>
					<button id="submit_button" class="btn btn-blue" type="submit">查询</button>
					<input id="is_excel" type="hidden" name="is_excel" value="0">
				</form>
			</div><!--box-search end-->
			<div class="box-table">
				<table class="table-num-money">
                    <tr>
                        <td>报名名额</td>
                        <td>0</td>
                        <td>已报名额</td>
                        <td>0</td>
                    </tr>
                </table>
				<table class="list">
					<thead>
                        <tr>
                            <th>序号</th>
                            <th>报名选手/队</th>
                            <th>比赛项目</th>
                            <th>报名费（元）</th>
                            <th>报名时间</th>
                            <th>报名方式</th>
                            <th>操作</th>
                        </tr>
                    </thead>
					<tbody>
                        <?php $index = 1; foreach($arclist as $v) {?>
                            <tr>
                                <td><?php echo $index; ?></td>
								<td><?php echo $v->sign_name; ?></td>
								<td><?php echo $v->sign_project_name; ?>-<?php echo $v->games_desc; ?></td>
                                <td><?php $money = ($v->add_type==1) ? $v->game_money-$v->game_money : $v->game_money; echo (empty($money)) ? '0.00' : $money ;?></td>
                                <td><?php echo date("Y-m-d H:i",strtotime(($v->add_type==1)?$v->pay_confirm_time:($money==0?$v->state_time:$v->pay_time))); ?></td>
                                <td><?php echo $v->add_type==1?'后台添加':'前端报名'; ?></td>
                                <td>
									<?php if(empty($v->team_id)){?>
                                    <a class="btn" href="<?php echo $this->createUrl('update',array('id'=>$v->id,'data_id'=>$v->sign_game_data_id,'p_id'=>0)); ?>">详情</a>
									<?php }else{?>
									<?php $arr = array('id'=>$v->team_id,'game_id'=>$v->sign_game_id,'data_id'=>$v->sign_game_data_id,'p_id'=>0); ?>
                                    <a class="btn" href="<?php echo $this->createUrl('gameTeamTable/player_update', $arr); ?>">详情</a>
									<?php }?>
									<a class="btn" href="javascript:;" onclick="" title="取消报名">取消报名</a>
                                </td>
                            </tr>
                        <?php $index++; }?>
                    </tbody>
				</table>
			</div><!--box-table end-->
			<div class="box-page c"><?php $this->page($pages);?></div>
		</div><!--box-content end-->
    </div>
</div><!--box end-->
<script>
	changeProjectid($('#project_id'));
    function changeProjectid(obj){
        var val = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(val > 0){
            var pr = '<?php echo $data_id; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('getDataByProject'); ?>&game_id=<?php echo $game_id;?>&project_id='+val,
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