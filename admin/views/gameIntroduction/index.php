<?php
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['title'])){
        $_REQUEST['title']=0;
    }
    if(empty($_REQUEST['type'])){
        $_REQUEST['type']=0;
    }
    $gamelist=GameList::model()->find('id='.$_REQUEST['game_id']);
?>
<style>.box-detail-tab li { width: 120px; }</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事发布 》 竞赛规程</h1>
        <span class="back">
            <?php if ($_REQUEST['game_id']>0) { ?>
                <a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/index');?>');"><i class="fa fa-reply"></i>返回上一层</a>
            <?php } ?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content" style="margin-top: 10px;">
        <div class="box-detail-tab">
            <ul class="c">
                <?php $action=Yii::app()->controller->getAction()->id;?>
                <li><a href="<?php echo $this->createUrl('gameList/update',array('id'=>$_REQUEST['game_id'],'type'=>$gamelist->game_type));?>">基本信息</a></li>
                <li><a href="<?php echo $this->createUrl('gameListData/index',array('game_id'=>$_REQUEST['game_id'],'type'=>$gamelist->game_type,'title'=>$_REQUEST['title']));?>">竞赛项目</a></li>
                <li class="current"><a href="<?php echo $this->createUrl('gameIntroduction/index',array('game_id'=>$_REQUEST['game_id'],'type'=>$gamelist->game_type,'title'=>$_REQUEST['title']));?>">竞赛规程</a></li>
                <li><a href="<?php echo $this->createUrl('gameList/sign_notice',array('id'=>$gamelist->id)); ?>">报名须知</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-header">
            <?php if($gamelist->state==721 || $gamelist->state==373) {?>
                <a class="btn" href="<?php echo $this->createUrl('gameIntroduction/create',array('game_id'=>$_REQUEST['game_id'],'type'=>$gamelist->game_type,'title'=>$_REQUEST['title']));?>"><i class="fa fa-plus"></i>添加</a>
            <?php }?>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('intro_title');?></th>
                        <!-- <th style='text-align: center;'><?php //echo $model->getAttributeLabel('intro_simple_content');?></th> -->
                        <!-- <th style='text-align: center;'><?php //echo $model->getAttributeLabel('update');?></th> -->
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1;
                        foreach($arclist as $v){
                    ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->intro_title; ?></td>
                        <!-- <td style='text-align: center;'><?php //echo $v->intro_simple_content; ?></td> -->
                        <!-- <td style='text-align: center;'><?php //echo $v->update; ?></td> -->
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update',array('id'=>$v->id,'game_id'=>$_REQUEST['game_id'],'type'=>$gamelist->game_type,'title'=>$_REQUEST['title']));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
				<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>