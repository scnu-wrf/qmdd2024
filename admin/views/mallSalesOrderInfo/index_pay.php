<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》销售统计》<a class="nav-a">支付统计</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>"> 
                <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>            
                <label style="margin-right:10px;">
                    <span>订单号：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入订单号" type="text" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>支付方式：</span>
                    <?php echo downList($pay_type,'f_id','F_NAME','pay_type'); ?>
                </label>           
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        <?php $basecode=BaseCode::model()->getPayway();
		$order=0;
		$total=0;
		$beans=0;
		$coupon=0;
		$other=0;
		$arr = array();
		$r=0;
        foreach($pay_type as $b){
			$r=$b->f_id;
            $arr[$r]= 0;
        }
		?>
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center; width: 25px;'>序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_money');?></th>
                        <th><?php echo $model->getAttributeLabel('beans_discount');?></th>
                        <th><?php echo $model->getAttributeLabel('coupon_discount');?></th>
                        <th><?php echo $model->getAttributeLabel('total_money');?></th>
                        <?php foreach ($pay_type as $p) { ?>
                        <th><?php echo $p->F_NAME;?></th>
                        <?php } ?>
                        <th>其他</th>
                        <th><?php echo $model->getAttributeLabel('order_gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('order_Date');?></th>
                        <th><?php echo $model->getAttributeLabel('payment_code');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    $index = 1;                     
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php $order=$order+$v->order_money; echo $v->order_money; ?></td>
                        <td><?php $beans=$beans+$v->beans_discount; echo $v->beans_discount; ?></td>
                        <td><?php $coupon=$coupon+$v->coupon_discount; echo $v->coupon_discount; ?></td>
                        <td><?php $total=$total+$v->total_money; echo $v->total_money; ?></td>
						<?php foreach ($pay_type as $p) { ?>
                        <td><?php if($v->pay_supplier_type==$p->f_id){ $arr[$p->f_id]=$arr[$p->f_id]+$v->total_money; echo $v->total_money; }?></td>
                        <?php } ?>
                        <?php if($v->pay_supplier_type>0){?><td></td><?php } else { ?>
                        <td><?php $other=$other+$v->total_money; echo $v->total_money; ?></td><?php } ?>
                        <td><?php echo $v->order_gfaccount; ?></td>
                        <td><?php echo $v->order_Date; ?></td>
                        <td><?php echo $v->payment_code; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_gf', array('id'=>$v->id));?>" title="编辑">查看</a>
                        </td>
                    </tr>
					<?php $index++; } ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1">小计</span></td>
                    	<td></td>
                        <td><?php echo $order; ?></td>
                        <td><?php echo $beans; ?></td>
                        <td><?php echo $coupon; ?></td>
                        <td><?php echo $total; ?></td>
                        <?php foreach ($pay_type as $p) { ?>
                        <td><?php echo $arr[$p->f_id]; ?></td>
                        <?php } ?>
                        <td><?php echo $other; ?></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

$(function(){
	
	var $star=$('#start');
    var $end=$('#end');
    $star.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});

</script>