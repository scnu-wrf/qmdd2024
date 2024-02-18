<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》销售统计》<a class="nav-a">每日销售统计</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>销售日期：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start_time" name="start_time" value="<?php echo $start_time;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="商品编号/名称/方案编号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
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
                        <th style='width:25px; text-align: center;'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('set_code');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th><?php echo $model->getAttributeLabel('product_name');?></th>
                        <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th style='width:120px;'>销售时间</th>
                        <th>上架总数量</th>
                        <th>上架剩余库存</th>
                        <th>销售数量(日)</th>
                        <th>销售总额(含运费，日)</th>
                        <th>退货数量(日)</th>
                        <th>退货总额(日)</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
if (is_array($arclist)) foreach($arclist as $v){ ?>
<?php $s_num=0; $r_num=0;$s_amount=0; $r_amount=0;
$orderdata=MallSalesOrderData::model()->findAll('(set_detail_id='.$v->id.' and change_type=0 AND order_Date >="'.$start_time.' 00:00:00" AND order_Date <="'.$end_time.' 23:59:59") order by id DESC');
$returndata=MallSalesOrderData::model()->findAll('(set_detail_id='.$v->id.' and change_type=1137 AND order_Date >="'.$start_time.' 00:00:00" AND order_Date <="'.$end_time.' 23:59:59") order by id DESC');

if(!empty($orderdata)) foreach($orderdata as $d) {
    $s_num=$s_num+$d->buy_count;
    $s_amount=$s_amount+$d->total_pay;
}
if(!empty($returndata)) foreach($returndata as $r){
    $r_num=$r_num+$r->ret_count;
    $r_amount=$r_amount+$r->ret_amount;
}
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->set_code; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_name; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td><?php echo $v->start_sale_time; ?><br><?php echo $v->down_time; ?></td>
                        <td><?php echo $v->Inventory_quantity; ?></td>
                        <td><?php echo $v->Inventory_quantity-$v->sale_order_data_quantity; ?></td>
                        <td><?php echo $s_num; ?></td>
                        <td>¥<?php echo $s_amount; ?></td>
                        <td><?php echo $r_num; ?></td>
                        <td>¥<?php echo $r_amount; ?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnLog(<?php echo $v->id;?>);" title="销售明细">明细</a>
                            <a class="btn" href="javascript:;" onclick="fnUpdate(<?php echo $v->id;?>);">刷新</a>
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
    var $start_time=$('#start_time');
    var $end_time=$('#end_time');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
//刷新库存
function fnUpdate(detail_id){
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('quantity');?>&detail_id='+detail_id,
            data: {detail_id:detail_id},
            dataType: 'json',
            success: function(data) {
                if(data!=''){
                    we.msg('minus', '刷新成功');
                    we.reload();
                  }else{
                    we.msg('minus', '刷新失败');
                }
            }
        }); 

}
// 查看销售明细
var fnLog=function(detail_id){
    $.dialog.open('<?php echo $this->createUrl("log");?>&detail_id='+detail_id,{
        id:'jilu',
        lock:true,
        opacity:0.3,
        title:'查看销售明细',
        width:'95%',
        height:'95%',
        close: function () {}
    });
};
</script>