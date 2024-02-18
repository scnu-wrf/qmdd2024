<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事报名 》 取消/审核未通过</h1>
        <span style="float:right;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab box-detail-tab-green" style="margin-bottom: 0;">
            <ul class="c">
                <li class="current"><a href="<?php echo $this->createUrl('gameSignList/index_tobe_exam',array());?>">个人</a></li>
                <li><a href="<?php echo $this->createUrl('gameTeamTable/index_tobe_exam',array());?>">团队</a></li>
                <li><a href="">裁判</a></li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" type="text" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入赛事名称">
                </label>
                <label style="margin-right:10px;">
                    <span>审核时间：</span>
                    <input style="width:150px;" type="text" class="input-text time" id="time_start" name="time_start" value="<?php echo Yii::app()->request->getParam('time_start'); ?>" placeholder="当前开始日期">
                    <span>-</span>
                    <input style="width:150px;" type="text" class="input-text time" id="time_end" name="time_end" value="<?php echo Yii::app()->request->getParam('time_end'); ?>" placeholder="当前结束日期">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_game_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('games_desc');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uptype');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uDate1');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align: center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center;"><?php echo $v->sign_game_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->games_desc; ?></td>
                        <td style="text-align: center;"><?php if(!empty($v->sign_game_data_id) && !empty($v->game_list_data)) echo $v->game_list_data->game_player_team_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->sign_account; ?></td>
                        <td style="text-align: center;"><?php echo $v->sign_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->state_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->uDate; ?></td>
                        <td style="text-align: center;">
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,'game_id'=>$v->sign_game_id,'data_id'=>$v->sign_game_data_id,'p_id'=>0)),'查看'); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
                <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content || gamesign-lt end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    
    $(function(){
        $('.time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>