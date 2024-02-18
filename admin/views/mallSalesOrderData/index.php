<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》销售统计》<a class="nav-a">每日销售明细</a></h1>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('index');?>" ><i class="fa fa-refresh"></i>刷新</a></span><span class="back"><a class="btn" href="<?php echo $this->createUrl('index',array('keywords'=>Yii::app()->request->getParam('keywords'),'order_type'=>Yii::app()->request->getParam('order_type'),'pay_type'=>Yii::app()->request->getParam('pay_type'),'start'=>Yii::app()->request->getParam('start'),'end'=>Yii::app()->request->getParam('end'),'is_excel'=>1));?>" ><i class="fa fa-file-excel-o"></i>导出</a></span>
    </div><!--box-title end--> 
    <div class="box-content"> 
  
          <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>订单类型：</span>
                    <?php echo downList($order_type,'f_id','F_NAME','order_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>收支类型：</span>
                    <?php echo downList($orter_item,'f_id','F_NAME','orter_item'); ?>
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
                        <input style="width:200px;" class="input-text"  placeholder="商品编号/名称/订单号" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-search">
        <span class="label-box">今日销售单：<b class="red"><?php echo $t_num; ?></b></span>
        <span class="label-box">今日销售额：<b class="red">￥<?php echo $money; ?></b></span>
        <span class="label-box">今日退款单：<b><?php echo $r_num; ?></b></span>
        <span class="label-box">今日退货金额：<b>￥<?php echo $r_money; ?></b></span>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px;text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th><?php echo $model->getAttributeLabel('product_title');?></th>
                        <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_price');?></th>
                        <th><?php echo $model->getAttributeLabel('post');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_count');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_amount');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_count');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_amount');?></th>
                        <th>支付方式</th>
                        <th style="width:70px;">操作时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                     $index = 1; 
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo (!empty($v->type)) ? $v->type->F_NAME : '购买'; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_title; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td><?php echo $v->ret_count ? "" : '¥'.$v->buy_price; ?></td>
                        <td><?php echo $v->ret_count ? "" : '¥'.$v->post; ?></td>
                        <td><?php echo $v->ret_count ? "" : $v->buy_count; ?></td>
                        <td><?php echo $v->ret_count ? "" : '¥'.$v->total_pay; ?></td>
                        <td><?php echo $v->ret_count ?  $v->ret_count : ""; ?></td>
                        <td><?php echo $v->ret_count ?  '¥'.$v->ret_amount : ""; ?></td>
                        <td><?php if(!empty($v->order_info)) echo $v->order_info->pay_supplier_type_name;?></td>
                        <td><?php echo $v->order_Date;?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('mallSalesOrderInfo/update', array('id'=>$v->info_id));?>" title="详情">查看</a>
                        </td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        </div>
        
        <div class="box-page c"><?php $this->page($pages); ?></div>

</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

$(function(){
    var $start_time=$('#start');
    var $end_time=$('#end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
function excel(){
    $("#is_excel").val(1);
    var v=$("#is_excel").val();
    $("#submit_button").click();
    //$("#is_excel").val('0');
}
</script>