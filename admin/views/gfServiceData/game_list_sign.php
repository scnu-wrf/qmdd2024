<?php
    check_request('service_state',0);
    $data_id = empty($_REQUEST['service_data_id']) ? $service_data_id : $_REQUEST['service_data_id'];
    $game_id = empty($_REQUEST['service_id']) ? 0 : $_REQUEST['service_id'];
    $game_list = GameList::model()->find('id='.$game_id);
    $game_data = GameListData::model()->find('id='.$service_data_id);
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
</style>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div class="gamesign c">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事/排名 》赛事管理 》赛事列表 》签到</h1>
            <span style="float:right;margin-right:15px;">
                <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
                <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: bottom;margin-left:20px;"><i class="fa fa-refresh"></i>刷新</a>
            </span>
        </div><!--box-title end-->
        <div class="gamesign-rt game_list_arrange" style="background-color:#e0e0e0;top: 43px;">
            <div class="gamesign-group">
                <span class="gamesign-title">竞赛项目</span>
                <?php foreach($data_list as $v){ ?>
                    <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php echo $this->createUrl('game_list_sign',array('service_id'=>$v->game_id,'service_data_id'=>$v->id,'back'=>$_REQUEST['back']));?>"><?php echo $v->game_data_name;?></a>
                <?php }?>
            </div>
        </div><!--gamesign-rt end-->
        <div class="<?php echo ($_REQUEST['service_id']!=0) ? 'gamesign-lt' : 'box-content'; ?>">
            <div class="box-search" style="margin-top: 43px;">
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    <input type="hidden" name="service_id" value="<?php echo $game_id;?>">
                    <input type="hidden" name="service_data_id" value="<?php echo $data_id;?>">
                    <label style="margin-right:10px;">
                        <span>签到状态：</span>
                        <select name="service_state">
                            <option value="">请选择</option>
                            <option value="1" <?php if($_REQUEST['service_state']==1) echo 'selected'; ?>>已签到</option>
                            <option value="2" <?php if($_REQUEST['service_state']==2) echo 'selected'; ?>>未签到</option>
                            <option value="3" <?php if($_REQUEST['service_state']==3) echo 'selected'; ?>>已补签</option>
                        </select>
                    </label>
                    <label style="margin-right:10px;">
                        <span>关键字：</span>
                        <input style="width:200px;" type="text" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="服务流水号/预订人/联系电话">
                    </label>
                    <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                </form>
            </div><!--box-search end-->
            <div class="box-header" style="margin-top: 1px;padding-bottom: 0;">
                <span style="font-size:14px;font-weight:700;">
                    <span><?php if(!empty($game_data)){ echo $game_data->game_name.' 》'.$game_data->game_data_name.' 》'; }elseif(!empty($game_list)) echo $game_list->game_title.' 》'; ?>签到情况</span>
                </span>
            </div>
            <div class="box-table" style="margin: 0;">
                <table class="list">
                    <thead>
                        <tr>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('order_num'); ?></th>
                            <th><?php echo $model->getAttributeLabel('service_game_data_id'); ?></th>
                            <th><?php echo $model->getAttributeLabel('service_game_time'); ?></th>
                            <th><?php echo $model->getAttributeLabel('gf_name'); ?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone'); ?></th>
                            <th><?php echo $model->getAttributeLabel('sign_come'); ?></th>
                            <th><?php echo $model->getAttributeLabel('sign_code'); ?></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; foreach($arclist as $v) {?>
                            <tr>
                                <td><?php echo $index; ?></td>
                                <td><?php echo $v->order_num; ?></td>
                                <td><?php echo $v->service_data_name; ?></td>
                                <td><?php echo $v->servic_time_star; ?></td>
                                <td><?php echo $v->gf_name; ?></td>
                                <td><?php echo $v->contact_phone; ?></td>
                                <td><?php echo $v->sign_come; ?></td>
                                <td><?php echo $v->sign_code; ?></td>
                                <td><?php echo ($v->sign_come>'0000-00-00 00:00:01') ? ($v->sign_come<$v->servic_time_end) ? '已签到' : '已补签' : '未签到'; ?></td>
                            </tr>
                        <?php $index++; }?>
                    </tbody>
                </table>
            <div/><!--box-table end-->
            <div class="box-page c"><?php $this->page($pages); ?></div>
        </div><!--box-content || gamesign-lt end-->
    </div>
</div><!--box end-->