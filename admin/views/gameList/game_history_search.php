<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事 》赛事管理 》<a class="nav-a">历史赛事</a></h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="game_time" name="game_time" value="<?php echo Yii::app()->request->getParam('game_time');?>" placeholder="选择日期">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="game_time_end" name="game_time_end" value="<?php echo Yii::app()->request->getParam('game_time_end');?>" placeholder="选择日期">
                </label>
				<label id="label2" style="margin-right:10px;">
					<span>项目：</span>
					<?php echo downList($project_list,'project_id','project_name','project_id','id="project_id" onchange="changeProjectid(this);"'); ?>
				</label>
                <label style="margin-right:10px;">
                    <span>赛事类型：</span>
                    <?php echo downList($game_level,'f_id','F_NAME','game_level'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="赛事编号/名称">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <ul class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="30px">序号</th>
                        <th width="110px"><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th><?php echo $model->getAttributeLabel('game_level');?></th>
                        <th><?php echo $model->getAttributeLabel('game_area');?></th>
                        <th><?php echo $model->getAttributeLabel('project_list');?></th>
                        <th width="110px"><?php echo $model->getAttributeLabel('signup_time');?></th>
                        <th width="110px"><?php echo $model->getAttributeLabel('effective_time');?></th>
                        <th width="70px"><?php echo $model->getAttributeLabel('game_time1');?></th>
                        <th><?php echo $model->getAttributeLabel('game_state');?></th>
                        <th><?php echo $model->getAttributeLabel('game_online');?></th>
                        <th width="110px">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->game_code; ?></td>
                            <td><?php echo $v->game_title; ?></td>
                            <td><?php echo $v->level_name; ?></td>
                            <td><?php echo $v->area_name; ?></td>
							<td>
							<?php 
								$project=GameListData::model()->findAll('game_id=' . $v->id .'  group by project_id');
								$tx='';
								if(count($project)>=2){
									$tx=$project[0]['project_name'].' '.$project[1]['project_name'].'...';
								} elseif (count($project)==1) {
									$tx=$project[0]['project_name'];
								} 
								echo $tx;
							?>
							</td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->Signup_date)).'<br>'.date("Y-m-d H:i",strtotime($v->Signup_date_end)); ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->effective_time)); ?></td>
                            <td><?php echo date("Y-m-d",strtotime($v->game_time)).'<br>'.date("Y-m-d",strtotime($v->game_time_end)); ?></td>
                            <td><?php echo $v->game_statec; ?></td></td>
                            <td><?php echo (!empty($v->game_online)) ? $v->base_game_online->F_NAME : ''; ?></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('submitupdate', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>1)); ?>" title="详情">详情</a>
                                <a class="btn" href="<?php echo $this->createUrl('GameSignList/game_list_sign', array('game_id'=>$v->id,'back'=>3)); ?>" title="报名">报名</a>
                                <a class="btn" href="<?php echo $this->createUrl('gameListArrange/indexvs', array('game_id'=>$v->id,'back'=>3)); ?>" title="赛程/成绩">赛程/成绩</a>
                                <a class="btn" href="<?php echo $this->createUrl('gfServiceData/game_list_sign', array('service_id'=>$v->id,'back'=>3)); ?>" title="签到">签到</a>
								<a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除">删除</a>
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
<script>
    $(function(){
        $('#game_time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $('#game_time_end').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>