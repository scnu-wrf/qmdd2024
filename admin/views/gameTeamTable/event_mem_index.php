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
                <a <?php if($data_id==0){?> class="current"<?php }?> href="<?php echo $this->createUrl('gameTeamTable/event_mem_index', array('game_id'=>$_REQUEST['game_id'],'game_name'=>$_REQUEST['game_name']));?>">全部</a>
                <?php foreach($game_data as $v){ ?>
                <a <?php if($data_id==$v->id){?> class="current"<?php }?> href="<?php if($v->game_player_team==665) { echo $this->createUrl('gameSignList/event_mem_index', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'])); } else if($v->game_player_team==666 || $v->game_player_team==982) { echo $this->createUrl('gameTeamTable/event_mem_index', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'])); }?>"><?php echo $v->game_data_name;?></a>
                <?php }?>
            </div>
        </div><!--gamesign-rt end-->
       <?php } ?>
    	<div class="<?php if($_REQUEST['game_id']<>0) { ?>gamesign-lt <?php } else { ?>box-content<?php } ?>" style=" border:none;">
    <div class="box-title c">
      <h1><i class="fa fa-table"></i><?php if($game_data1){?><?php echo $game_data1->game_name; ?> - <?php echo $game_data1->game_data_name?> - 赛事成员管理<?php }else{ ?>赛事成员管理<?php }?></h1><?php if ($_REQUEST['game_id']>0) { ?><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/event_mem_index');?>');"><i class="fa fa-reply"></i>返回</a></span><?php } ?></div><!--box-title end-->
      <div class="box-detail-tab box-detail-tab-green mt15">
        <ul class="c" id="li_click">
            <?php $action=Yii::app()->controller->getAction()->id;?>
            <li id="li_click_team" class='current'><a href="<?php echo $this->createUrl('gameTeamTable/event_mem_index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name']));?>">团队</a></li>
            <li id="li_click_sign"><a href="<?php echo $this->createUrl('gameSignList/event_mem_index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name']));?>">个人</a></li>
        </ul>
   </div><!--box-detail-tab end--> 
      <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
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
                        <th class="check" style="text-align: center;"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id" style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('logo');?></th>   
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('name');?></th>   
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php $basepath=BasePath::model()->getPath(182);?>
                <?php 
                $index = 1;
                foreach($arclist as $v){ 
                ?>
                    <tr>
                        <td class="check check-item" style="text-align: center;"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align: center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center;"><a href="<?php echo $basepath->F_WWWPATH.$v->logo; ?>" target="_blank" style="display: inline-block;"><div style="width:50px; height:50px;overflow:hidden;"><img src="<?php echo $basepath->F_WWWPATH.$v->logo; ?>" width="50"></div></a></td>        
                        <td style="text-align: center;"><?php echo $v->name; ?></a></td>
                        <td style="text-align: center;"><?php echo $v->add_time; ?></td>
                        <td style="text-align: center;">
                            <a class="btn" onclick="addRegister(<?php echo $v->id;?>);" title="编辑">添加报到</a>
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
<script>
    // 添加报到
    function addRegister(id){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('get_add_register');?>',
            data: {id: id},
            dataType: 'json',
            success: function(data) {
                if(data.status==1){
                    we.success(data.msg, data.redirect);
                }else{
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>