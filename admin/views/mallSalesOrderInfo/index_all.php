<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-home"></i>当前界面：订单管理>综合订单列表><a class="nav-a">综合订单查询</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>"> 
                <label style="margin-right:20px;">
                    <span>订单类型：</span>
                    <?php echo downList($order_type,'f_id','F_NAME','order_type'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>支付平台：</span>
                    <?php echo downList($pay_type,'f_id','F_NAME','pay_type'); ?>
                </label>            
                <label style="margin-right:10px;">
                    <span>订单编号：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入订单号" type="text" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>下单人：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入下单人帐号/姓名" type="text" name="gf_name" value="<?php echo Yii::app()->request->getParam('gf_name');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>支付时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>         
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check">序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('order_gfaccount');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('order_gfname');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th style='text-align: center;'>订单金额</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('total_money');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('pay_supplier_type');?></th> 
                        <th style='text-align: center;'>单位</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('pay_time');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                      $index = 1;
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><?php echo $index; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->order_gfaccount; ?></td>
                        <td><?php echo $v->order_gfname; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo $v->order_money; ?></td>
                        <td><?php echo $v->total_money; ?></td>
                        <td><?php echo $v->pay_supplier_type_name; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td><?php echo $v->pay_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="详情">查看</a>

                        </td>
                        </td>
                    </tr>
                    <?php $index++;  } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

$(function(){
    
    var $star_time=$('#start_date');
    var $end_time=$('#end_date');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});
    });
    
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