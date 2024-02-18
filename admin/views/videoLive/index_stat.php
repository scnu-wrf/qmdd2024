<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播统计》<a class="nav-a">直播数据统计</a></h1>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
				<?php if(empty(get_SESSION('use_club_id'))){?>
                <label style="margin-right:20px;">
                    <span>直播单位：</span>
                    <?php echo downList($live_club_list,'club_id','club_name','club_id'); ?>
                </label>
				<?php }?>
                <label style="margin-right:10px;">
                    <span>直播名称：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入直播名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;">序号</th>
                        <th>直播名称</th>
                        <th>当前在线人数</th>
                        <th>总访问量</th>
                        <th>总分享量</th>
                        <th>总礼物量</th>
                        <th>直播豆总收益</th>
                        <th>总红包量</th>
                        <th>红包总收益（元）</th>
                        <th>直播单位</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php  $index = 1;
 foreach($arclist as $v){ 
	$watch_total=LiveMessage::model()->count('m_type=33 and live_id='.$v->id);//总访问量
	$share_total=VideoLiveUserStatusRecord::model()->count('m_type=33 and inviter_gfid<>0 and live_id='.$v->id);//总分享量
	$condition=array('condition'=>'m_type=32 and live_id='.$v->id,'select'=>'sum(live_reward_num) as live_reward_num');
	$gift_num_amount=LiveMessage::model()->find($condition);//总礼物量
	$condition=array('condition'=>'m_type=32 and live_id='.$v->id,'select'=>'sum(live_reward_price*live_reward_num) as live_reward_price');
	$gift_price_amount=LiveMessage::model()->find($condition);//直播豆总收益
	$condition=array('condition'=>'m_type=40 and live_id='.$v->id,'select'=>'sum(live_reward_num) as live_reward_num');
	$envelopes_num_amount=LiveMessage::model()->find($condition);//总红包量
	$condition=array('condition'=>'m_type=40 and live_id='.$v->id,'select'=>'sum(live_reward_price*live_reward_num) as live_reward_price');
	$envelopes_price_amount=LiveMessage::model()->find($condition);//红包总收益
 ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->title; ?></td>
                        <td><?php echo $v->online_users; ?></td>
                        <td><?php echo $watch_total; ?></td>
                        <td><?php echo $share_total; ?></td>
                        <td><?php echo empty($gift_num_amount["live_reward_num"])?'0':$gift_num_amount["live_reward_num"]; ?></td>
                        <td><?php echo empty($gift_price_amount["live_reward_price"])?'0':$gift_price_amount["live_reward_price"]; ?></td>
						<td><?php echo empty($envelopes_num_amount["live_reward_num"])?'0':$envelopes_num_amount["live_reward_num"]; ?></td>
						<td><?php echo number_format(empty($envelopes_price_amount["live_reward_price"])?'0':$envelopes_price_amount["live_reward_price"],2); ?></td>
						<td><?php echo $v->club_name; ?></td>
                        <td>
							<a class="btn" href="<?php echo $this->createUrl('update_stat', array('id'=>$v->id));?>" title="查看">查看</a>
                        </td>
                    </tr>
<?php  $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $star_time=$('#start_date');
    var $end_time=$('#end_date');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
</script>