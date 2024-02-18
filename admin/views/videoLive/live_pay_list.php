<div class="box">
    <div class="box-title c">
        <h1>当前界面：直播》直播统计》<a class="nav-a">观看收费明细</a></h1>
        <span class="back"><a class="btn" href="<?php echo Yii::app()->request->url;?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
		<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('videoLive/live_pay_stat');?>">观看收费统计</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:10px;">
                    <span>支付时间：</span>
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
                        <th>支付时间</th>
                        <th>付费会员</th>
                        <th>支付金额（元）</th>
                        <th>支付方式</th>
                        <th>直播名称</th>
                        <th>直播编号</th>
                        <th>直播单位</th>
                    </tr>
                </thead>
                <tbody>
				<?php foreach($arclist as $k=>$v){?>
					<tr>
						<td style="text-align:center;"><?php echo ($pages->currentPage)*($pages->pageSize)+$k+1 ?></td>
						<td><?php echo $v->order_Date;?></td>
						<td><?php echo $v->gf_name .'('.$v->order_gfaccount.')';?></td>
						<td><?php echo $v->buy_price;?></td>
						<td><?php echo $v->pay_supplier_type_name;?></td>
						<td><?php echo $v->service_name;?></td>
						<td><?php echo $v->service_code;?></td>
						<td><?php echo $v->club_name;?></td>
					</tr>
				<?php }?>
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