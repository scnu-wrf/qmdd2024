<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['game_name'])){
        $_REQUEST['game_name']='';
    }
    if(!isset($_REQUEST['data_type'])){
        $_REQUEST['data_type']=0;
    }
    if(!isset($data_id)){
        $data_id=0;
    }
    $f_dataid = $_REQUEST['data_id']==0 ? $data_id : $_REQUEST['data_id'];
    $game_data1=GameListData::model()->find('id='.$f_dataid);
    $qmdd_path=get_qmdd_path();
    $yii_path=get_yii_path();
    echo '<style>.box-search{margin-top: 0;padding-top: 0;border-top: 0;}</style>';
?>
<div class="box" style="margin-left:0;">
	<div class="gamesign c">
    	<?php if($_REQUEST['game_id']<>0) { ?>
            <div class="gamesign-rt game_list_arrange">
                <div class="gamesign-group">
                    <span class="gamesign-title">竞赛项目</span>
                        <!-- <a<?php //if($data_id==0){?> class="current"<?php //}?> href="<?php //echo $this->createUrl('gameSignList/index_rank', array('game_id'=>$_REQUEST['game_id'],'game_name'=>$_REQUEST['game_name']));?>">全部<span>(<?php //echo $all_num;?>)</span></a> -->
                    <?php foreach($game_data as $v){ ?>
                        <a<?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php if($v->game_player_team==665) { echo $this->createUrl('gameSignList/index_rank', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'])); } else if($v->game_player_team==666 || $v->game_player_team==982) { echo $this->createUrl('gameTeamTable/index_rank', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'])); }?>"><?php echo $v->game_data_name;?><span>(<?php echo $v->number_of_join_now;?>)</span></a>
                    <?php }?>
                </div>
            </div><!--gamesign-rt end-->
        <?php } ?>
    	<div class="<?php if($_REQUEST['game_id']<>0) { ?>gamesign-lt <?php } else { ?>box-content<?php } ?>" style=" border:none;">
            <div class="box-title c">
                <h1><i class="fa fa-table"></i><?php echo $_REQUEST['game_name'].' - '.$game_data1->game_data_name; ?>/名次公告</h1>
                <span class="back">
                    <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
                    <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('. check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
                    <a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a>
                </span>
            </div><!--box-title end-->
            <div class="box-search" <?php if($_REQUEST['game_id']<>0) { ?>style="margin-left:10px;"<?php } ?>>
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    <input type="hidden" name="data_id" value="<?php echo $_REQUEST["data_id"];?>">
                    <input type="hidden" name="game_id" value="<?php echo $_REQUEST["game_id"];?>">
                    <input type="hidden" name="game_name" value="<?php echo $_REQUEST["game_name"];?>">
                    <input type="hidden" name="data_type" value="<?php echo $_REQUEST["data_type"];?>">
                    <label style="margin-right:10px;">
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text" type="text" placeholder="请输入GF帐号 / 姓名" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                    </label>
                    <button class="btn btn-blue" type="submit">查询</button>
                </form>
            </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('sing_game_ranking');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_game_score');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->sing_game_ranking; ?></td>
                        <td><?php echo $v->sign_name; ?></td>
                        <td><?php echo $v->sign_game_score; ?></td>      
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('gameListOrder/index', array('sign_id'=>$v->id,'data_id'=>$v->sign_game_data_id,'game_id'=>$v->sign_game_id,'sign_name'=>$v->sign_name,'game_name'=>$v->sign_game_name,'data_name'=>$v->games_desc,'data_type'=>$_REQUEST['data_type']));?>" title="得分历史">得分历史</a>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->       
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--gamesign-lt end-->
    
      </div><!--gamesign c end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>