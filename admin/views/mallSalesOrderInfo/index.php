<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》订单管理》<a class="nav-a">订单列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->    
    <div class="box-content">
        <div class="box-header">
            <span class="label-box" >今日成交订单：<b class="red"><?php echo $num; ?></b></span>
            <span class="label-box" >今日交易商品：<b class="red"><?php echo $p_num; ?></b></span>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                        <span>订单类型：</span>
                        <?php echo downList($order_type,'f_id','F_NAME','order_type'); ?>
                </label>
                <label style="margin-right:10px;">
                        <span>支付方式：</span>
                        <?php echo downList($pay_type,'f_id','F_NAME','pay_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>支付时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                        <span>关键字：</span>
                        <input style="width:200px;" class="input-text"  placeholder="订单号/商品信息" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align:center; width:25px'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th width="15%">商品信息</th>
                        <th><?php echo $model->getAttributeLabel('order_gfname');?></th>
                        <th><?php echo $model->getAttributeLabel('order_money');?></th>
                        <th><?php echo $model->getAttributeLabel('post');?></th>
                        <th><?php echo $model->getAttributeLabel('beans_discount');?></th>
                        <th><?php echo $model->getAttributeLabel('total_money');?></th>
                        <th><?php echo $model->getAttributeLabel('order_type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('order_state');?></th>
                        <th><?php echo $model->getAttributeLabel('pay_supplier_type');?></th>
                        <th style='width:70px;'><?php echo $model->getAttributeLabel('pay_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><?php echo $index; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php 
                            $orderdata=MallSalesOrderData::model()->findAll('info_id='.$v->id.' and supplier_id='.get_session('club_id'));
                            $tx='';
                            $o_num=count($orderdata);
                            if($o_num>1){
                                $tx=$orderdata[0]['product_title'].','.$orderdata[0]['json_attr'].','.$orderdata[0]['buy_count'].'<br>...';
                            } elseif ($o_num==1) {
                                $tx=$orderdata[0]['product_title'].','.$orderdata[0]['json_attr'].','.$orderdata[0]['buy_count'];
                            }
                            echo $tx; ?></td>
                        <td><?php echo $v->order_gfaccount; ?>(<?php echo $v->order_gfname; ?>)</td>
                        <td><?php echo $v->order_money; ?></td>
                        <td><?php echo $v->post; ?></td>
                        <td><?php echo $v->beans; ?></td>
                        <td><?php echo $v->total_money; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <?php $record=OrderRecord::model()->find('(order_num="'.$v->order_num.'") order by id DESC'); ?>
                        <td><?php $c_num=0;
                        foreach($orderdata as $d) if($d->logistics_id>0) $c_num++;
                        if(!empty($record)){
                            if($record->order_state==465 && $c_num==0){ echo "已支付"; 
                        } elseif ($record->order_state==465 && ($c_num>0 && $c_num<$o_num)) {
                            echo "部分发货";
                        } elseif ($record->order_state==465 && $c_num==$o_num) {
                            echo "已发货";
                        } else echo $record->order_state_name; 
                        } ?></td>
                        <td><?php echo $v->pay_supplier_type_name; ?></td>
                        <td><?php echo $v->pay_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="详情">查看</a>
                        </td>
                        </td>
                    </tr>
<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
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