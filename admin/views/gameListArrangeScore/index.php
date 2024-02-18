<?php
    // if(!isset($_REQUEST['type'])){$_REQUEST['type']=NULL;}
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['data_title'])){
        $_REQUEST['data_title']=0;
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    $game_data=GameListData::model()->find('id='.$_REQUEST['data_id']);
?>
<style>
    .box-table .list tr th,.box-table .list tr td{
        text-align: center;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i><?php if($game_data){?><?php echo $game_data->game_name; ?> / <?php echo $game_data->game_data_name?> /<?php }?>成绩管理</h1>
        <?php if($_REQUEST['p_id']==0) {?>
            <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回赛事列表</a></span>
        <?php }?>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入赛事名称/赛程编码/赛程描述">
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
                        <th><?php echo $model->getAttributeLabel('game_name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('game_data_id');?></th>
                        <th><?php echo $model->getAttributeLabel('arrange_tcode');?></th>
                        <th><?php echo $model->getAttributeLabel('type');?></th>
                        <th><?php echo $model->getAttributeLabel('game_player_id');?></th>
                        <th><?php echo $model->getAttributeLabel('game_site');?></th>
                        <th><?php echo $model->getAttributeLabel('star_time');?></th>
                        <th><?php echo $model->getAttributeLabel('end_time');?></th>
                        <th><?php echo $model->getAttributeLabel('game_mark');?></th>
                        <th><?php echo $model->getAttributeLabel('game_score');?></th>
                        <th><?php echo $model->getAttributeLabel('game_order');?></th>
                        <th><?php echo $model->getAttributeLabel('game_over');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->game_name; ?></td>
                        <td><?php echo $v->game_project_name; ?></td>
                        <td><?php echo $v->game_data_name; ?></td>
                        <td><?php echo $v->arrange_tcode; ?></td>
                        <td><?php if(!empty($v->game_player_id))echo $v->base_game_player_id->F_NAME; ?></td>
                        <td><?php echo ($v->game_player_id==666 || $v->game_player_id==982) ? $v->team_name : $v->sign_name; ?></td>
                        <td><?php echo $v->game_site; ?></td>
                        <td><?php if($v->star_time=='0000-00-00 00:00:00') {echo $v->star_time='';}else{echo $v->star_time;}; ?></td>
                        <td><?php if($v->end_time=='0000-00-00 00:00:00') {echo $v->end_time='';}else{echo $v->end_time;}; ?></td>
                        <td><?php echo $v->game_mark; ?></td>
                        <td><?php echo $v->game_score; ?></td>
                        <td><?php echo $v->game_order; ?></td>
                        <td><?php echo $v->game_over_name; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'p_id'=>$_REQUEST['p_id']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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