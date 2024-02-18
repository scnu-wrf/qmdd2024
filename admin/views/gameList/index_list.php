<?php 
   check_request('game_type',0);
   check_post('data_id',0);
   check_post('data_type',0);
?>
<style>
    .box-search div{ display:inline-block; }
    #keywords{ margin-left: 12px; }
</style>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：》 赛事 》 赛事管理 》<a class="nav-a">赛事列表</a></h1>
        <span style="float:right;margin-right:15px;"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="game_type" value="<?php echo Yii::app()->request->getParam('game_type');?>">
                <label style="margin-right:10px;">
                    <span>赛事类型：</span>
                    <?php echo downList($game_level,'f_id','F_NAME','game_level'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编码或标题">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
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
                        <th width="12%"><?php echo $model->getAttributeLabel('game_address');?></th>
                        <th><?php echo $model->getAttributeLabel('game_state');?></th>
                        <th><?php echo $model->getAttributeLabel('game_online');?></th>
                        <th width="110px">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
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
							<td><?php echo $v->game_address; ?></td>
                            <td><?php echo $v->game_statec; ?></td></td>
                            <td><?php echo $v->online_name; ?></td></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('detail', array('id'=>$v->id,'type'=>$v->game_type,'p_id'=>1)); ?>" title="详情">详情</a>
                                <a class="btn" href="<?php echo $this->createUrl('GameSignList/game_list_sign', array('game_id'=>$v->id,'back'=>1)); ?>" title="报名">报名</a>
                                <a class="btn" href="<?php echo $this->createUrl('gameListStage/index', array('game_id'=>$v->id,'back'=>1)); ?>" title="赛程/成绩">赛程/成绩</a>
                                <a class="btn" href="<?php echo $this->createUrl('gfServiceData/game_list_sign', array('service_id'=>$v->id,'back'=>1)); ?>" title="签到">签到</a>
                                <!--<a class="btn" href="<?php echo $this->createUrl('gameListArrange/game_list_sign', array('game_id'=>$v->id,'back'=>1)); ?>" title="成绩">成绩</a>-->
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
    function clickTimeSetting(id){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl('settion_time'); ?>&id='+id,{
            id:'tianjia',
            lock:true,
            opacity:0.3,
            title:'赛事时间设置',
            width:'55%',
            height:'55%',
            close: function () {
                // window.location.reload(true);
            }
        });
    }
</script>