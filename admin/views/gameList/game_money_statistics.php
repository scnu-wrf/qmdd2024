<?php ?>
<div class="box" style="margin: 0px 10px 10px 0;">
    <div style="position: fixed;margin-top: -165px;width: 99.4%;background-color: #f2f2f2;z-index: 99;">
        <div class="box-title c" style="width: 99%;position: fixed;background-color: #F2F2F2;z-index: 99;">
            <h1>当前界面：赛事/排名 》赛事报名 》赛事费用统计</h1>
            <span style="float:right;">
                <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>&nbsp;
            </span>
        </div><!--box-title end-->
        <div id="title_top" class="box-detail-tab" style="position: fixed;width: 99.4%;top: 53px;z-index: 99;">
            <ul class="c">
                <li class="current"><a href="<?php echo Yii::app()->request->url; ?>">赛事费用统计</a></li>
                <li><a href="<?php echo $this->createUrl('sign_money_details'); ?>">报名费用明细</a></li>
            </ul>
        </div>
        <div class="box-search" style="margin-top: 100px;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>统计时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="Signup_date" name="Signup_date" value="<?php echo $Signup_date;?>" placeholder="比赛开始时间">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="Signup_date_end" name="Signup_date_end" value="<?php echo $Signup_date_end;?>" placeholder="比赛结束时间">
                </label>
                <label>
                    <span>赛事名称：</span>
                    <input style="width:200px;" class="input-text" type="text" id="game_title" name="game_title" value="<?php echo Yii::app()->request->getParam('game_title');?>" placeholder="赛事名称">
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="编号/账号/发布单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
    </div>
    <div class="box-content" style="margin: 0px;">
        <div class="box-table" style="margin-top: 165px;">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('game_code');?></th>
                        <th><?php echo $model->getAttributeLabel('game_title');?></th>
                        <th><?php echo $model->getAttributeLabel('signup_time');?></th>
                        <th>报名总人数</th>
                        <th>实收总额</th>
                        <th><?php echo $model->getAttributeLabel('game_club_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo $v->game_code; ?></td>
                            <td><?php echo $v->game_title; ?></td>
                            <td><?php echo date("Y-m-d H:i",strtotime($v->Signup_date)).'<br>'.date("Y-m-d H:i",strtotime($v->Signup_date_end)); ?></td>
                            <td></td>
                            <td>
                                <?php
                                    $game_data = GameListData::model()->findAll('game_id='.$v->id.' ');
                                    $me = 0;
                                    if(!empty($game_data))foreach($game_data as $gd){
                                        $me = $me+$gd->game_money;
                                    }
                                    echo $me;
                                ?>
                            </td>
                            <td><?php echo $v->game_club_name; ?></td>
                            <td><a class="btn" href="<?php echo $this->createUrl('sign_money_details',array('game_id'=>$v->id,'Signup_date'=>$Signup_date,'Signup_date_end'=>$Signup_date_end,'keywords2'=>$keywords,'back'=>1)); ?>">明细</a></td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        $('#Signup_date').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $('#Signup_date_end').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>