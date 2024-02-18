<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['team_id'])){
        $_REQUEST['team_id']=0;
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
    if(!isset($_GET['order_num'])){
        $_GET['order_num']='';
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    if(!isset($data_id)){
        $data_id=0;
    }
    $f_dataid = $_REQUEST['data_id']==0 ? $data_id : $_REQUEST['data_id'];
    $game_data1=GameListData::model()->find('id='.$f_dataid);
    // $qmdd_path=get_qmdd_path();
    // $yii_path=get_yii_path();
?>
<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align: center;
    }
</style>
<div class="box" style="margin-left:0;">
	<div class="gamesign c">
    	<?php if($_REQUEST['game_id']<>0) { ?>
            <div class="gamesign-rt game_list_arrange">
                <div class="gamesign-group">
                    <span class="gamesign-title">竞赛项目</span>
                        <!-- <a<?php //if($data_id==0){?> class="current"<?php //}?> href="<?php //echo $this->createUrl('gameSignList/index', array('game_id'=>$_REQUEST['game_id'],'game_name'=>$_REQUEST['game_name']));?>">全部<span>(<?php //echo $all_num;?>)</span></a> -->
                    <?php foreach($game_data as $v){ ?>
                        <a <?php if($data_id==$v->id){?>class="current"<?php }?> href="<?php if($v->game_player_team==665) { echo $this->createUrl('gameSignList/index', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id'])); } else if($v->game_player_team==666 || $v->game_player_team==982) { echo $this->createUrl('gameTeamTable/index', array('data_id'=>$v->id,'game_id'=>$v->game_id,'data_type'=>$v->game_player_team,'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id'])); }?>"><?php echo $v->game_data_name;?><span>(<?php echo $v->number_of_join_now;?>)</span></a>
                    <?php }?>
                </div>
            </div><!--gamesign-rt end-->
        <?php } ?>
        <div class="<?php if($_REQUEST['game_id']<>0) { ?>gamesign-lt <?php } else { ?>box-content<?php } ?>" style=" border:none;">
            <div class="box-title c">
                <h1>
                    <i class="fa fa-table"></i>
                    <?php
                        if($_REQUEST['game_name']!='' && $_REQUEST['data_id']==0){
                            echo $_REQUEST['game_name'].' /';
                        }
                        else if($game_data1){
                            echo $game_data1->game_name.'-'.$game_data1->game_data_name.'- ';
                        }
                    ?>赛事成员管理
                </h1>
                <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a></span>
            </div><!--box-title end-->
            <div class="box-detail-tab box-detail-tab-green mt15">
                <ul class="c">
                    <?php $action=Yii::app()->controller->getAction()->id;;?>
                    <li><a href="<?php echo $this->createUrl('gameTeamTable/index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id']));?>">团队</a></li>
                    <li class="current"><a href="<?php echo $this->createUrl('gameSignList/index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id']));?>">个人</a></li>
                    <li><a href="<?php echo $this->createUrl('gameRefereesList/index',array('game_id'=>$_REQUEST['game_id'],'data_type'=>$_REQUEST['data_type'],'game_name'=>$_REQUEST['game_name'],'p_id'=>$_REQUEST['p_id']));?>">裁判</a></li>
                </ul>
            </div><!--box-detail-tab end-->       
            <div class="box-header">
                <?php if ($_REQUEST['data_id']>0 && $_REQUEST['data_type']==665 && $_REQUEST['p_id']!=0) { ?><a class="btn" href="<?php echo $this->createUrl('create',array('data_id'=>$_REQUEST['data_id']));?>"><i class="fa fa-plus"></i>添加</a><?php } ?>
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
                <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            </div><!--box-header end-->
            <div class="box-search" <?php if($_REQUEST['game_id']<>0) { ?>style="margin-left:10px;"<?php } ?>>
                <form action="<?php echo Yii::app()->request->url;?>" method="get">
                    <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                    <input type="hidden" name="team_id" value="<?php echo Yii::app()->request->getParam('team_id');?>">
                    <input type="hidden" name="order_num" value="<?php echo $_GET["order_num"];?>">
                    <input type="hidden" name="data_id" value="<?php echo $_REQUEST["data_id"];?>">
                    <input type="hidden" name="game_id" value="<?php echo $_REQUEST["game_id"];?>">
                    <input type="hidden" name="game_name" value="<?php echo  $_REQUEST['game_name'];?>">
                    <input type="hidden" name="data_type" value="<?php echo $_REQUEST["data_type"];?>">
                    <?php if($_REQUEST['game_id']==0) {?>
                    <label style="margin-right:20px;">
                        <span>所属赛事：</span>
                        <select name="game">
                            <option value="">请选择</option>
                            <?php if(is_array($game)) foreach($game as $v){?>
                            <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('game')==$v->id){?> selected<?php }?>><?php echo $v->game_title;?></option>
                            <?php }?>
                        </select>
                    </label>
                    <?php }?>
                    <label style="margin-right:20px;">
                        <span>审核状态：</span>
                        <select name="state">
                            <option value="">请选择</option>
                            <?php foreach($state as $v){?>
                            <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                            <?php }?>
                        </select>
                    </label>
                    <label style="margin-right:20px;">
                        <span>支付状态：</span>
                        <select name="is_pay">
                            <option value="">请选择</option>
                            <?php foreach($is_pay as $v){?>
                            <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('is_pay')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                            <?php }?>
                        </select>
                    </label>
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
                            <th style="width: 4%;">序号</th>
                            <th><?php echo $model->getAttributeLabel('sign_account');?></th>
                            <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                            <th><?php echo $model->getAttributeLabel('sign_sname');?></th>
                            <th><?php echo $model->getAttributeLabel('sign_game_id');?></th>
                            <th><?php echo $model->getAttributeLabel('sign_game_data_id');?></th>
                            <th><?php echo $model->getAttributeLabel('team_id');?></th>
                            <th><?php echo $model->getAttributeLabel('state');?></th>
                            <th><?php echo $model->getAttributeLabel('is_pay');?></th>
                            <th><?php echo $model->getAttributeLabel('add_time');?></th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $index = 1; foreach($arclist as $v){ ?>
                            <tr>
                                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" <?php if($v->state==372 && $v->is_pay==464)echo 'disabled="disabled"'; ?>></td>
                                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                                <td><?php echo $v->sign_account; ?></td>
                                <td><?php echo $v->sign_name; ?></td>
                                <td><?php echo $v->sign_sname; ?></a></td>
                                <td><?php echo $v->sign_game_name; ?></td>
                                <td><?php if($v->game_list_data!=null){ echo $v->game_list_data->game_data_name; } ?></td>
                                <td><?php echo $v->team_name; ?></td>
                                <td><?php echo $v->state_name; ?><?php if($v->agree_state==374) echo ' - '.$v->agree_name; ?></td>
                                <td><?php echo $v->pay_name; ?></td>
                                <td><?php echo substr($v->add_time,0,10).'<br>'.substr($v->add_time,10); ?></td>
                                <td>
                                    <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'data_id'=>$_REQUEST['data_id'],'p_id'=>$_REQUEST['p_id']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                                    <?php if($v->state!=372 && $v->is_pay!=464) {?>
                                        <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                                    <?php }?>
                                    <?php //if($v->is_pay==463) { if($v->agree_state!=374){?>
                                        <!-- <a class="btn" href="javascript:;" onclick="we.cancelsvi('<?php echo $v->id;?>', cancelsvi);" title="取消服务"><i class="fa fa-trash-o"></i></a> -->
                                    <?php //}}?>
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