<?php
    check_request('game_id',0);
    check_request('data_id',0);
    if(!isset($_REQUEST['back'])) $_REQUEST['back'] = 0;
    if(!isset($_REQUEST['state'])){
        $_REQUEST['state'] = 371;
    }
    $url = '';
    if($_REQUEST['back']==1){
        $url = 'gameList/index_list';
    }
    else if($_REQUEST['back']==2){
        $url = 'gameList/game_club_search';
    }
    else if($_REQUEST['back']==3){
        $url = 'gameList/game_history_search';
    }
    else if($_REQUEST['back']==4){
        $url = 'gameList/game_club_history_search';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事报名 》 成员报名审核</h1>
        <span style="float:right;">
            <?php if($_REQUEST['back']>0) {?>
                <a class="btn" href="<?php echo $this->createUrl($url); ?>">返回上一层</a>
            <?php }?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if($_REQUEST['back']==0) {?>
        <div class="box-header">
            <a id="clickState" href="<?php echo $this->createUrl('gameSignList/to_audited'); ?>" style="border:solid 1px #ccc;padding:5px;">
                <span>待审核：<span class="red"><?php echo $count1+$count2; ?></span></span>
            </a>
        </div>
        <?php }?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="back" value="<?php echo $_REQUEST['back']; ?>">
                <label style="margin-right:10px;">
                    <span>赛事名称：</span>
                    <?php echo downList($game_id,'id','game_title','game_id','id="game_id" onchange="changeGameid(this);"'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>竞赛项目：</span>
                    <select name="data_id" id="data_id">
                        <option value="">请选择</option>
                    </select>
                </label>
                <br>
                <label style="margin-right:10px;">
                    <span>审核时间：</span>
                    <input style="width:150px;" type="text" class="input-text time" id="time_start" name="time_start" value="<?php echo Yii::app()->request->getParam('time_start'); ?>" placeholder="当前开始日期">
                    <span>-</span>
                    <input style="width:150px;" type="text" class="input-text time" id="time_end" name="time_end" value="<?php echo Yii::app()->request->getParam('time_end'); ?>" placeholder="当前结束日期">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:150px;" type="text" class="input-text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入姓名/GF账号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;' class="list-id">序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_game_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('games_desc');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('uptype');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sign_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state1');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('is_pay');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state_time');?></th>
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
                        <td style="text-align: center;"><?php echo $v->pay_name; ?></td>
                        <td style="text-align: center;"><?php echo $v->add_time; ?></td>
                        <td style="text-align: center;">
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,'game_id'=>$v->sign_game_id,'data_id'=>$v->sign_game_data_id,'p_id'=>0)),'查看'); ?>
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
    $(function(){
        $('.time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

    var deleteUrl = '<?php echo $this->createUrl('delete',array('id'=>'ID')); ?>';
    changeGameid($('#game_id'));
    function changeGameid(obj){
        var obj = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data[0].length;i++){
                        s_html += '<option value="'+data[0][i]['id']+'" '+((data[0][i]['id']==pr) ? 'selected>' : '>')+data[0][i]['game_data_name']+'</option>';
                    }
                    $('#data_id').html(s_html);
                }
            });
        }
        else{
            $('#data_id').html(s_html);
        }
    }
</script>