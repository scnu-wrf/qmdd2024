<?php //var_dump($_SESSION);?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》
            <?php 
                if($_REQUEST['order_type']==352){
                    echo '培训报名 》培训订单';
                }elseif($_REQUEST['order_type']==354){
                    echo '活动报名 》活动订单';
                }elseif($_REQUEST['order_type']==1537){
                    echo '课程购买》课程订单';
                }
            ?>
        </h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->    
    <div class="box-content">
        <div class="box-header">
            <span class="label-box" >今日成交订单：<b class="red"><?php echo $num; ?></b></span>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="order_type" value="<?php echo Yii::app()->request->getParam('order_type');?>">
                <?php if($_REQUEST['order_type']==352||$_REQUEST['order_type']==1537){?>
                    <label style="margin-right:10px;">
                        <span>订单类别：</span>
                        <?php echo downList($train_type,'id','classify','train_type'); ?>
                    </label>
                <?php }?>
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
                        <input style="width:200px;" class="input-text"  placeholder="请输入订单号、服务流水号、下单人" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align:center; width:25px'>序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th>服务流水号</th>
                        <th><?php echo $model->getAttributeLabel('order_gfname');?></th>
                        <th><?php echo $model->getAttributeLabel('order_money');?></th>
                        <th><?php echo $model->getAttributeLabel('total_money');?></th>
                        <th><?php echo $model->getAttributeLabel('order_type_name');?></th>
                        <?php if($_REQUEST['order_type']==352||$_REQUEST['order_type']==1537){?>
                            <th>订单类别</th>
                        <?php }?>
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
                        <td><?php if(!is_null($v->order_data->gfService))echo $v->order_data->gfService->order_num; ?></td>
                        <td><?php echo $v->order_gfaccount; ?>(<?php echo $v->order_gfname; ?>)</td>
                        <td><?php echo $v->order_money; ?></td>
                        <td><?php echo $v->total_money; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <?php if($_REQUEST['order_type']==352||$_REQUEST['order_type']==1537){?>
                            <td><?php if(!is_null($v->order_data->gfService->train_list_data))echo $v->order_data->gfService->train_list_data->type_name; ?></td>
                        <?php }?>
                        <td><?php if(!is_null($v->order_data->gfService))echo $v->order_data->gfService->order_state_name; ?></td>
                        <td><?php echo $v->pay_supplier_type_name; ?></td>
                        <td><?php echo $v->pay_time; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update_serve_type', array('id'=>$v->id))); ?>
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