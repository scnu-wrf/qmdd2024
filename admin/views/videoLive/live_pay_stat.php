<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播统计》<a class="nav-a">观看收费统计</a></h1>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
		<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('videoLive/live_pay_list');?>">观看收费明细</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<?php if(empty(get_SESSION('use_club_id'))){?>
                <label style="margin-right:20px;">
                    <span>直播单位：</span>
                    <?php echo downList($live_club_list,'club_id','club_name','club_id'); ?>
                </label>
				<?php }?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="直播编号/名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;">序号</th>
                        <th>直播编号</th>
                        <th>直播名称</th>
                        <th><?php echo $model->getAttributeLabel('open_club_member');?></th>
                        <th>直播观看收费</th>
                        <th>付费总人数</th>
                        <th>收费总金额（元）</th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
				<?php foreach($arclist as $k=>$v){?>
				<?php $pay_user_count=MallSalesOrderData::model()->count('order_type=366 and service_id='.$v->id);?>
				<?php $condition=array('condition'=>'order_type=366 and service_id='.$v->id,'select'=>'sum(buy_count*buy_price) as buy_price');
				$pay_user_amount=MallSalesOrderData::model()->find($condition);?>
					<tr>
						<td style="text-align:center;"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></td>
						<td><?php echo $v->code; ?></td>
						<td><?php echo $v->title; ?></td>
						<td><?php echo $v->open_club_member_name; ?></td>
						<td><?php echo ($v->member_price .(($v->open_club_member==210)?('/'.$v->gf_price):'')); ?></td>
						<td><?php echo $pay_user_count; ?></td>
						<td><?php echo number_format(empty($pay_user_amount)?0:$pay_user_amount["buy_price"],2); ?></td>
						<td><?php echo $v->club_name; ?></td>
						<td><a class="btn pay_stat_detail" href="javascript:;" title="<?php echo $v->title; ?> 收费明细" live_id="<?php echo $v->id;?>">明细</a></td>
					</tr>
				<?php }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
$('.pay_stat_detail').on('click', function(){
	$.dialog.open('<?php echo $this->createUrl("live_pay_stat_detail");?>&live_id='+$(this).attr("live_id"),{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'60%',height:'60%',
		title:$(this).attr("title"),
		close: function () {
			
		}
	});
})
</script>