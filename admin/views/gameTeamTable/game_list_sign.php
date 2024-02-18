<?php
    $data_id = empty($_REQUEST['data_id']) ? 0 : $_REQUEST['data_id'];
    $game_id = empty($_REQUEST['game_id']) ? 0 : $_REQUEST['game_id'];
    $game_list = GameList::model()->find('id='.$game_id);
    $game_data = GameListData::model()->find('id='.$data_id);
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
    <div class="gamesign c">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事 》赛事管理 》赛事列表 》报名表</h1>
            <span style="float:right;margin-right:15px;">
                <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
                <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: bottom;margin-left:20px;"><i class="fa fa-refresh"></i>刷新</a>
            </span>
        </div><!--box-title end-->
        <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 43px;">
            <div class="gamesign-group">
                <span class="gamesign-title">赛事项目</span>
				<select style="width:100%;" onchange="location.href='<?php echo $this->createUrl('game_list_sign');?>&game_id=<?php echo $game_id;?>&back=1&project_id='+this.value">
					<?php foreach($project_list as $k=>$v){?>
					<option value="<?php echo $v->project_id;?>" <?php if($project_id==$v->project_id){?> selected<?php }?>><?php echo $v->project_name;?></option>
					<?php }?>
				</select>
                <span class="gamesign-title">比赛项目</span>
                <?php foreach($data_list as $v){ ?>
                    <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('game_list_sign',array('game_id'=>$v->game_id,'data_id'=>$v->id,'project_id'=>$v->project_id,'game_player'=>$v->game_player_team,'back'=>$_REQUEST['back']));?>"><?php echo $v->game_data_name;?></a>
                <?php }?>
            </div>
        </div><!--gamesign-rt end-->
        <div class="<?php echo ($_REQUEST['game_id']!=0) ? 'gamesign-lt' : 'box-content'; ?>">
            <div class="box-header" style="margin-top: 43px;padding-bottom: 0;">
                <span style="font-size:14px;font-weight:700;">
                    <span><?php if(!empty($game_data)){ echo $game_data->game_name.' 》'.$game_data->game_data_name.' 》'; }elseif(!empty($game_list)) echo $game_list->game_title.' 》'; ?>报名信息</span>
                </span>
            </div>
            <div class="box-table" style="margin: 0;">
                <!--<table class="table-num-money">
                    <?php
                        $data_total_quota = (!empty($game_data)) ? $game_data->max_num_team : 0;
                        $table_list = GameTeamTable::model()->findAll('sign_game_data_id='.$data_id.' and state=372 and is_pay=464 and pay_confirm=1');
                        // $total_money = Yii::app()->db->createCommand('select sum(game_money) from game_team_table where sign_game_data_id='.$data_id.' and state=372')->queryScalar();
                    ?>
                    <tr>
                        <td>选手名额</td>
                        <td><?php echo $data_total_quota; ?></td>
                        <td>已报名额</td>
                        <td><?php echo count($table_list); ?></td>
                        <td>实收费用总额</td>
                        <td>
                            <?php
                                $total_money = 0;
                                if(!empty($table_list))foreach($table_list as $sl){
                                    if(!$sl->add_type==1){
                                        $total_money = $total_money+$sl->game_money;
                                    }
                                }
                                echo $total_money;
                            ?>
                        </td>
                    </tr>
                </table>-->
                <table class="list mt15">
                    <thead>
                        <?php
                            $logo_acccount = (!empty($game_data) && $game_data->game_player_team!=666) ? 'create_account' : 'logo';
                            $titel_name = (!empty($game_data) && $game_data->game_player_team!=666) ? 'name1' : 'name';
                            $sex_tvn = (!empty($game_data) && $game_data->game_player_team!=666) ? 'sign_sex' : 'tvname';
                        ?>
                        <tr>
                            <th>序号</th>
                            <th>报名选手/队</th>
                            <th>报名费（元）</th>
                            <th>报名时间</th>
                            <th>报名方式</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $index = 1;
                            $path = BasePath::model()->get_www_path();
                            foreach($arclist as $v) {
                                $team_list = GameSignList::model()->findAll('sign_game_data_id='.$v->sign_game_data_id.' and team_id='.$v->id);
                                $account = '';$name = '';$sex = '';$level = '';
                                if(($game_data->game_player_team==982 || $game_data->game_player_team==1452) && !empty($team_list))foreach($team_list as $tl){
                                    if(!empty($account)) $account .= '/';
                                    $account .= $tl->sign_account;
                                    if(!empty($name)) $name .= '/';
                                    $name .= $tl->sign_name;
                                    if(!empty($sex)) $sex .= '/';
                                    $sex .= ($tl->sign_sex==205) ? '男' : '女';
                                    if(!empty($level)) $level .= '/';
                                    $level .= (!empty($tl->sign_gfid) && !empty($tl->club_member_level)) ? $tl->club_member_level->project_level_name : '';
                                }
                        ?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td>
                                    <?php if($logo_acccount=='logo'){ $logo_path = $path.$v->$logo_acccount; ?>
                                        <div class="upload_img fl">
                                            <?php if(!empty($v->$logo_acccount)) {?>
                                                <a href="<?php echo $logo_path; ?>" target="_blank"><img src="<?php echo $logo_path;?>" width="50"></a>
                                            <?php }?>
                                        </div>
                                    <?php }elseif($game_data->game_player_team==982 || $game_data->game_player_team==1452) echo $account; ?>
                                </td>
                                <td>
                                    <?php
                                        if($game_data->game_player_team==666){
                                            echo $v->name;
                                        }
                                        elseif($game_data->game_player_team==982 || $game_data->game_player_team==1452){
                                            echo $name;
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        if($game_data->game_player_team==666){
                                            echo $v->tvname;
                                        }
                                        elseif($game_data->game_player_team==982 || $game_data->game_player_team==1452){
                                            echo $sex;
                                        }
                                    ?>
                                </td>
                                <?php if(!empty($game_data) && $game_data->game_player_team==666) {?>
                                    <td><?php $money = ($v->add_type==1) ? $v->game_money-$v->game_money : $v->game_money; echo (empty($money)) ? '0.00' : $money ;?></td>
                                    <td><?php echo $v->coach_name; ?></td>
                                    <td><?php echo $v->tour_leader_name; ?></td>
                                    <td><?php echo $v->coach_phone; ?></td>
                                <?php }else{?>
                                    <td><?php echo $level; ?></td>
                                    <td><?php $money = ($v->add_type==1) ? $v->game_money-$v->game_money : $v->game_money; echo (empty($money)) ? '0.00' : $money ;?></td>
                                    <td><?php if(!empty($v->order_num)) echo $v->order_num_service->contact_phone; ?></td>
                                <?php }?>
                                <td>
                                    <?php $arr = array('id'=>$v->id,'game_id'=>$v->game_id,'data_id'=>$v->sign_game_data_id,'p_id'=>0); ?>
                                    <a class="btn" href="<?php echo $this->createUrl('player_update', $arr); ?>"><?php if(!empty($v->game_list_data)) echo ($v->game_list_data->game_player_team==666) ? '成员信息' : '查看'; ?></a>
                                </td>
                            </tr>
                        <?php $index++; }?>
                    </tbody>
                </table>
            <div/><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->