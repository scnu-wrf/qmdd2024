<div class="box">
	<div class="box-title c">
        <h1>当前界面：直播》直播统计》<a class="nav-a">数据统计详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end--> 
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">观看人数统计</li>
                <li>分享榜</li>
                <li>礼物榜</li>
                <li>红包榜</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
			<?php $watch_total=LiveMessage::model()->count('m_type=33 and live_id='.$model->id);?>
			<?php $programs=VideoLivePrograms::model()->findAll('live_id=' . $model->id);?>
                <table style="width:50%;margin:0 auto;">
                    <thead>
						<tr>
							<th style="text-align:center;" colspan=2>观看人数统计</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>当前在线人数：<?php echo $model->online_users; ?></td>
							<td>总访问量：<?php echo $watch_total;?></td>
						</tr>
					</tbody>
                </table>
                <table style="width:50%;margin:0 auto;">
					<thead>
						<tr>
							<th style="text-align:center;">序号</th>
							<th style="text-align:center;">节目单名称</th>
							<th style="text-align:center;">访问量</th>
						</tr>
					</thead>
					<tbody>
					<?php foreach($programs as $k=>$v){?>
						<tr>
							<td><?php echo $k+1;?></td>
							<td><?php echo $v->title;?></td>
							<td><?php $watch_num=LiveMessage::model()->count('m_type=33 and live_id='.$model->id.' and live_program_id='.$v->id);echo $watch_num;?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
			<?php $share_total=VideoLiveUserStatusRecord::model()->count('m_type=33 and inviter_gfid<>0 and live_id='.$model->id);?>
			<?php $invites=VideoLiveUserStatusRecord::model()->findAllBySql('SELECT COUNT(*) as invite_count,gf_user_1.GF_NAME,gf_user_1.GF_ACCOUNT FROM video_live_user_status_record join gf_user_1 on gf_user_1.GF_ID=video_live_user_status_record.inviter_gfid WHERE video_live_user_status_record.m_type=33 and video_live_user_status_record.inviter_gfid<>0 and video_live_user_status_record.live_id='.$model->id.' GROUP BY video_live_user_status_record.inviter_gfid ORDER BY invite_count DESC LIMIT 5');?>
			<?php $invites_total=VideoLiveUserStatusRecord::model()->countBySql('SELECT COUNT(DISTINCT inviter_gfid) from video_live_user_status_record where m_type=33 and inviter_gfid<>0 and live_id='.$model->id);?>
                <table style="width:50%;margin:0 auto;">
                    <thead>
						<tr>
							<th style="text-align:center;" colspan=4>分享榜</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan=4>总分享量：<?php echo $share_total;?></td>
						</tr>
						<tr>
							<td>排名</td>
							<td>账号</td>
							<td>昵称</td>
							<td>分享数</td>
						</tr>
					<?php foreach($invites as $k=>$v){?>
						<tr>
							<td><?php echo $k+1;?></td>
							<td><?php echo $v->GF_ACCOUNT;?></td>
							<td><?php echo $v->GF_NAME;?></td>
							<td><?php echo $v->invite_count;?></td>
						</tr>
					<?php }?>
					</tbody>
                </table>
				<?php if($invites_total>0){?>
					<div id="share_list" style="width:50%;margin:0 auto;"><a href="javascript:;">查看更多信息(<?php echo $invites_total;?>)</a></div>
				<?php }?>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
			<?php $gift_num_amount=LiveMessage::model()->find(array('condition'=>'m_type=32 and live_id='.$model->id,'select'=>'sum(live_reward_num) as live_reward_num'));?>
			<?php $gift_price_amount=LiveMessage::model()->find(array('condition'=>'m_type=32 and live_id='.$model->id,'select'=>'sum(live_reward_price*live_reward_num) as live_reward_price'));?>
			<?php $gift=LiveMessage::model()->findAllBySql('SELECT sum(m.live_reward_num) as gift_num_amount,sum(m.live_reward_price*m.live_reward_num) as gift_price_amount,u.GF_NAME,u.GF_ACCOUNT FROM livemessage m join gf_user_1 u on u.GF_ID=m.s_gfid WHERE m.m_type=32 and m.live_id='.$model->id.' GROUP BY s_gfid ORDER BY gift_price_amount DESC,gift_num_amount DESC LIMIT 5');?>
			<?php $gift_total=LiveMessage::model()->countBySql('SELECT COUNT(DISTINCT s_gfid) from livemessage where m_type=32 and live_id='.$model->id);?>
                <table style="width:50%;margin:0 auto;">
                    <thead>
						<tr>
							<th style="text-align:center;" colspan=5>礼物榜</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan=5>总礼物量：<?php echo empty($gift_num_amount["live_reward_num"])?'0':$gift_num_amount["live_reward_num"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;直播豆总收益：<?php echo empty($gift_price_amount["live_reward_price"])?'0':$gift_price_amount["live_reward_price"];?></td>
						</tr>
						<tr>
							<td>排名</td>
							<td>账号</td>
							<td>昵称</td>
							<td>礼物数量</td>
							<td>礼物直播豆</td>
						</tr>
					<?php foreach($gift as $k=>$v){?>
						<tr>
							<td><?php echo $k+1;?></td>
							<td><?php echo $v->GF_ACCOUNT;?></td>
							<td><?php echo $v->GF_NAME;?></td>
							<td><?php echo $v->gift_num_amount;?></td>
							<td><?php echo $v->gift_price_amount;?></td>
						</tr>
					<?php }?>
					</tbody>
                </table>
				<?php if($gift_total>0){?>
					<div id="gift_list" style="width:50%;margin:0 auto;"><a href="javascript:;">查看更多信息(<?php echo $gift_total;?>)</a></div>
				<?php }?>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
            <?php $gift_num_amount=LiveMessage::model()->find(array('condition'=>'m_type=40 and live_id='.$model->id,'select'=>'sum(live_reward_num) as live_reward_num'));?>
			<?php $gift_price_amount=LiveMessage::model()->find(array('condition'=>'m_type=40 and live_id='.$model->id,'select'=>'sum(live_reward_price*live_reward_num) as live_reward_price'));?>
			<?php $gift=LiveMessage::model()->findAllBySql('SELECT sum(m.live_reward_num) as gift_num_amount,sum(m.live_reward_price*m.live_reward_num) as gift_price_amount,u.GF_NAME,u.GF_ACCOUNT FROM livemessage m join gf_user_1 u on u.GF_ID=m.s_gfid WHERE m.m_type=40 and m.live_id='.$model->id.' GROUP BY s_gfid ORDER BY gift_price_amount DESC,gift_num_amount DESC LIMIT 5');?>
			<?php $gift_total=LiveMessage::model()->countBySql('SELECT COUNT(DISTINCT s_gfid) from livemessage where m_type=40 and live_id='.$model->id);?>
                <table style="width:50%;margin:0 auto;">
                    <thead>
						<tr>
							<th style="text-align:center;" colspan=5>红包榜</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td colspan=5>总红包量：<?php echo empty($gift_num_amount["live_reward_num"])?'0':$gift_num_amount["live_reward_num"];?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;红包总收益：<?php echo number_format(empty($gift_price_amount["live_reward_price"])?'0':$gift_price_amount["live_reward_price"],2);?></td>
						</tr>
						<tr>
							<td>排名</td>
							<td>账号</td>
							<td>昵称</td>
							<td>红包数量</td>
							<td>打赏金额（元）</td>
						</tr>
					<?php foreach($gift as $k=>$v){?>
						<tr>
							<td><?php echo $k+1;?></td>
							<td><?php echo $v->GF_ACCOUNT;?></td>
							<td><?php echo $v->GF_NAME;?></td>
							<td><?php echo $v->gift_num_amount;?></td>
							<td><?php echo number_format($v->gift_price_amount,2);?></td>
						</tr>
					<?php }?>
					</tbody>
                </table>
				<?php if($gift_total>0){?>
					<div id="envelope_list" style="width:50%;margin:0 auto;"><a href="javascript:;">查看更多信息(<?php echo $gift_total;?>)</a></div>
				<?php }?>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
		<div class="mt15" style="text-align:center;">
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
we.tab('.box-detail-tab li','.box-detail-tab-item');
var club_id=<?php echo $model->club_id;?>;
$(function(){
setTimeout(function(){ UE.getEditor('editor_VideoLive_intro_temp').setDisabled('fullscreen'); }, 500);
});
selectProjectIs($('#VideoLive_project_is'));
function selectProjectIs(obj){
    var show_type=$(obj).val();
    if(show_type==649){ 
        $('#ProjectIs').show();
    } else{
        $('#ProjectIs').hide();
    }
}
$('#share_list').on('click', function(){
	$.dialog.open('<?php echo $this->createUrl("video_live_share_list");?>&live_id=<?php echo $model->id;?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'60%',height:'60%',
		title:'分享榜',
		close: function () {
			
		}
	});
})
$('#gift_list').on('click', function(){
	$.dialog.open('<?php echo $this->createUrl("video_live_gift_list");?>&live_id=<?php echo $model->id;?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'60%',height:'60%',
		title:'礼物榜',
		close: function () {
			
		}
	});
})
$('#envelope_list').on('click', function(){
	$.dialog.open('<?php echo $this->createUrl("video_live_envelope_list");?>&live_id=<?php echo $model->id;?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'60%',height:'60%',
		title:'红包榜',
		close: function () {
			
		}
	});
})

</script>