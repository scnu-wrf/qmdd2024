<?php
    //include_once $qmdd_init_file;

    if(!isset($_SESSION)){
        session_start();
    }
    if (!isset($_REQUEST['game_id'])){
    $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['game_name'])){
        $_REQUEST['game_name']='';
    }
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['data_type'])){
        $_REQUEST['data_type']=0;
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    $game_data1=GameListData::model()->find('id='.$_REQUEST['data_id']);
    $qmdd_path=get_qmdd_path();
    $yii_path=get_yii_path();
?>
<div class="box" style="margin-left:0;">
	<div class="gamesign c">
    	<?php if($_REQUEST['game_id']<>0) { ?>
            <div class="gamesign-rt game_list_arrange">
                <div class="gamesign-group">
                    <span class="gamesign-title">竞赛项目</span>
                        <!-- <a <?php //if($data_id==0){?> class="current"<?php //}?> href="<?php //echo $this->createUrl('gameTeamTable/index', array('game_id'=>$_REQUEST['game_id'],'game_name'=>$_REQUEST['game_name']));?>">全部</a> -->
                    <?php foreach($game_data as $v){ ?>
                        <a<?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php if($v->game_player_team==665) { echo $this->createUrl('gameSignList/index', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'])); } else if($v->game_player_team==666 || $v->game_player_team==982) { echo $this->createUrl('gameTeamTable/index', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'])); }?>"><?php echo $v->game_data_name;?><span>(<?php echo $v->number_of_join_now;?>)</span></a>
                    <?php }?>
                </div>
            </div><!--gamesign-rt end-->
        <?php } ?>
    	<div class="<?php if($_REQUEST['game_id']<>0) { ?>gamesign-lt <?php } else { ?>box-content<?php } ?>" style=" border:none;">
            <div class="box-title c">
                <h1><i class="fa fa-table"></i><?php if($game_data1){?><?php echo $game_data1->game_name; ?> - <?php echo $game_data1->game_data_name?> - 赛事成员管理<?php }else{ ?>赛事成员管理<?php }?></h1>
                <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a></span>
            </div><!--box-title end-->
            <div class="box-detail-tab box-detail-tab-green mt15">
                <ul class="c" id="li_click">
                    <?php $action=Yii::app()->controller->getAction()->id;?>
                    <li id="li_click_team" class='current'><a href="<?php echo $this->createUrl('gameTeamTable/index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id']));?>">团队</a></li>
                    <li id="li_click_sign"><a href="<?php echo $this->createUrl('gameSignList/index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id']));?>">个人</a></li>
                    <li id="li_click_refeees"><a href="<?php echo $this->createUrl('gameRefereesList/index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id']));?>">裁判</a></li>
                </ul>
            </div><!--box-detail-tab end--> 
   			<div class="box-header">
                <?php if ($_REQUEST['data_id']>0 && ($_REQUEST['data_type']!=665)) { ?><a class="btn" href="<?php echo $this->createUrl('create', array('data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id']));?>"><i class="fa fa-plus"></i>添加</a><?php } ?>
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
                <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            </div><!--box-header end-->
            <div class="box-search">
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    <input type="hidden" name="data_id" value="<?php echo $_REQUEST["data_id"];?>">
                    <input type="hidden" name="game_id" value="<?php echo $_REQUEST["game_id"];?>">
                    <input type="hidden" name="game_name" value="<?php echo  $_REQUEST['game_name'];?>">
                    <input type="hidden" name="data_type" value="<?php echo $_REQUEST["data_type"];?>">
                    <label style="margin-right:10px;">
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="队名 / 赛事名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                            <th><?php echo $model->getAttributeLabel('logo');?></th>
                            <th><?php echo $model->getAttributeLabel('name');?></th>
                            <th><?php echo $model->getAttributeLabel('tvname');?></th>
                            <th><?php echo $model->getAttributeLabel('game_id');?></th>    
                            <th><?php echo $model->getAttributeLabel('sign_game_data_id');?></th>    
                            <th><?php echo $model->getAttributeLabel('sign_project_name');?></th>                  
                            <th><?php echo $model->getAttributeLabel('state');?></th>
                            <th><?php echo $model->getAttributeLabel('is_pay');?></th>
                            <th><?php echo $model->getAttributeLabel('add_time');?></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $basepath=BasePath::model()->getPath(182);?>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><a href="<?php echo $basepath->F_WWWPATH.$v->logo; ?>" target="_blank"><div style="width:50px; height:50px;overflow:hidden;"><img src="<?php echo $basepath->F_WWWPATH.$v->logo; ?>" width="50"></div></a></td>        
                            <td><?php echo $v->name; ?></a></td>
                            <td><?php echo $v->tvname; ?></td>
                            <td><?php echo $v->game_name; ?></td>
                            <td><?php echo $v->sign_game_data_name; ?></td>
                            <td><?php echo $v->sign_project_name; ?></td>
                            <td><?php if(!empty($v->basecode)) echo $v->basecode->F_NAME; ?></td>
                            <td><?php echo $v->is_pay_name; ?></td>
                            <td><?php echo $v->add_time; ?></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'data_id'=>$v->sign_game_data_id,'game_id'=>$v->game_id,'game_name'=>$_REQUEST['game_name'],'data_type'=>$_REQUEST['data_type'],'p_id'=>$_REQUEST['p_id']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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
    // var cancelsvi = '<?php echo $this->createUrl('cancelsvi', array('id'=>'ID'));?>';
</script>