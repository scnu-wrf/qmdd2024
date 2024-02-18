<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }if(!isset($_REQUEST['team_id'])){
        $_REQUEST['team_id']=0;
    }
    if(!isset($_SESSION)){
        session_start();
    }
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_GET['order_num'])){
        $_GET['order_num']='';
    }
    if(!isset($_REQUEST['data_type'])){
        $_REQUEST['data_type']=0;
    }
    if(!isset($_REQUEST['state'])){
        $_REQUEST['state']=0;
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    $qmdd_path=get_qmdd_path();
    $yii_path=get_yii_path();
?>

<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>团队详情</h1><?php if ($_REQUEST['data_id']>0) { ?><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameTeamTable/player', array('data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id']));?>');"><i class="fa fa-reply"></i>返回</a></span><?php } ?></div><!--box-title end-->
    <div class="box-detail-tab">
        <ul class="c">
            <?php $action=Yii::app()->controller->getAction()->id;?>
            <li><a href="<?php echo $this->createUrl('gameTeamTable/update',array('id'=>$_REQUEST['team_id'],'data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id'],'p_id'=>$_REQUEST['p_id']));?>">基本信息</a></li>
            <li class="current"><a href="<?php echo $this->createUrl('gameSignList/index_team',array('data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id'],'team_id'=>$_REQUEST['team_id'],'data_type'=>$_REQUEST['data_type'],'p_id'=>$_REQUEST['p_id']));?>">成员信息</a></li>
        </ul>
   </div><!--box-detail-tab end-->     
    <div class="box-content">
        <div class="box-header">
        <?php if ($_REQUEST['state']!=372 || $_REQUEST['p_id']!=0) { ?>
            <a class="btn" href="<?php echo $this->createUrl('create_team',array('data_id'=>$_REQUEST['data_id'],'team_id'=>$_REQUEST['team_id'],'game_id'=>$_REQUEST['game_id']));?>"><i class="fa fa-plus"></i>添加</a><?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="team_id" value="<?php echo Yii::app()->request->getParam('team_id');?>">
                <input type="hidden" name="order_num" value="<?php echo $_GET["order_num"];?>">
                <input type="hidden" name="data_id" value="<?php echo $_GET["data_id"];?>">
                <input type="hidden" name="game_id" value="<?php echo $_GET["game_id"];?>">
                <input type="hidden" name="data_type" value="<?php echo $_GET["data_type"];?>">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_head_pic');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th>出生日期</th>
                        <th><?php echo $model->getAttributeLabel('sign_sex');?></th>
                        <th><?php echo $model->getAttributeLabel('sign_game_contect');?></th>
                        <th><?php echo $model->getAttributeLabel('game_man_type');?></th>
                        <th><?php echo $model->getAttributeLabel('insurance_policy');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(191); $index = 1; foreach($arclist as $v){?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->sign_account; ?></td>
                        <td><a href="<?php echo $basepath->F_WWWPATH.$v->sign_head_pic; ?>" target="_blank"><div style="width:50px; height:50px;overflow:hidden;"><img src="<?php echo $basepath->F_WWWPATH.$v->sign_head_pic; ?>" width="50"></div></a></td>
                        <td><?php echo $v->sign_name; ?></td>
                        <td><?php if(!empty($v->user)) echo $v->user->real_birthday; ?></td>
                        <td><?php if(!empty($v->usersex)) echo $v->usersex->F_NAME; ?></td>
                        <td><?php echo $v->sign_game_contect; ?></td>
                        <td><?php if(!empty($v->sign_type)) echo $v->sign_type->F_NAME; ?></td>
                        <td><?php echo $v->insurance_policy; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_team', array('id'=>$v->id,'game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id'],'team_id'=>$v->team_id,'p_id'=>$_REQUEST['p_id']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php if($_REQUEST['state']==372) {?>
                                <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                            <?php }?>
                        </td>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>