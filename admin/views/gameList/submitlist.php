<?php 
    check_request('game_type',0);
    check_post('data_id',0);
    check_post('data_type',0);
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id'] = 1;
    }
?>
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事 》赛事发布 》<a class="nav-a">发布审核</a></h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
		<div class="box-detail-tab">
			<ul class="c">
				<li class="current"><a href="<?php echo $this->createUrl('submitlist'); ?>">待审核 <?php echo $stay_state; ?></a></li>
				<li><a href="<?php echo $this->createUrl('shlist'); ?>">审核记录</a></li>
			</ul>
		</div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="赛事编号/名称">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <ul class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th style='width:30px;'>序号</th>
                    <th style='width:85px;'><?php echo $model->getAttributeLabel('game_code');?>
                    </th>
                    <th style='width:12%'><?php echo $model->getAttributeLabel('game_title');?></th>
                    <th><?php echo $model->getAttributeLabel('game_level');?></th>
                    <th><?php echo $model->getAttributeLabel('game_area');?></th>
                    <th><?php echo $model->getAttributeLabel('project_list');?></th>
                    <th><?php echo $model->getAttributeLabel('game_time1');?></th>
                    <th style='width:12%'><?php echo $model->getAttributeLabel('game_address');?></th>
                    <th><?php echo $model->getAttributeLabel('game_club_id');?></th>
                    <th><?php echo $model->getAttributeLabel('publish_time1');?></th>
                    <th style='width:60px;'>操作</th>
                </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->game_code; ?></td>
                            <td><?php echo $v->game_title; ?></td>
                            <td><?php echo $v->level_name; ?></td>
                            <td><?php echo $v->area_name; ?></td>
                            <td><?php echo GameListData::model()->getProjects($v->id);?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->game_time)).'<br>'.date("Y-m-d H:i",strtotime($v->game_time_end)); ?></td>
                            <td><?php echo $v->game_address; ?></td>
                            <td><?php echo $v->game_club_name; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->publish_time)); ?></td>
                            <td> <!-- display:inline-flex;-->
                                <?php echo show_command('详情',$this->createUrl('submitupdate', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>$_REQUEST['p_id'])),'审核'); ?>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->