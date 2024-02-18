<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》服务预订》<a class="nav-a">订单列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->   
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">               
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
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('order_gfname');?></th>
                        <th><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th>订单金额</th>
                        <th><?php echo $model->getAttributeLabel('total_money');?></th>
                        <th><?php echo $model->getAttributeLabel('pay_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                      $index = 1;
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><?php echo $index; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->order_gfaccount; ?></td>
                        <td><?php echo $v->order_gfname; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo $v->order_money; ?></td>
                        <td><?php echo $v->total_money; ?></td>
                        <td><?php echo $v->pay_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_member', array('id'=>$v->id));?>" title="详情">查看</a>

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