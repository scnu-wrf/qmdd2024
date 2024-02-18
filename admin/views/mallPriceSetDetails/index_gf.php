<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商城管理查询》<a class="nav-a">库存及销售明细查询</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>销售时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_time" name="start_time" value="<?php echo $start_time;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>商家名称：</span>
                    <input style="width:200px;" class="input-text" type="text" name="supplier" value="<?php echo Yii::app()->request->getParam('supplier');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="商品编号/商品名称/方案编号" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='width:25px; text-align: center;'>序号</th>
                        <th style='width:10%;'><?php echo $model->getAttributeLabel('set_code');?></th>
                        <th style='width:10%;'><?php echo $model->getAttributeLabel('product_code');?></th>
                        <th><?php echo $model->getAttributeLabel('product_name');?></th>
                        <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th><?php echo $model->getAttributeLabel('sale_price');?></th>
                        <th><?php echo $model->getAttributeLabel('post_price');?></th>
                        <th><?php echo $model->getAttributeLabel('Inventory_quantity');?></th>
                        <th><?php echo $model->getAttributeLabel('available_quantity');?></th>
                        <th>上架剩余库存</th>
                        <th>销售时间</th>
                        <th><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
if (is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    <?php $record=MallPricingDetails::model()->find('(set_details_id='.$v->id.') order by id DESC'); ?>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->set_code; ?></td>
                        <td><?php echo $v->product_code; ?></td>
                        <td><?php echo $v->product_name; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td><?php echo $v->sale_price; ?></td>
                        <td><?php echo $v->post_price; ?></td>
                        <td><?php echo $v->Inventory_quantity; ?></td>
                        <td><?php echo $v->sale_order_data_quantity; ?></td>
                        <td><?php echo $v->Inventory_quantity-$v->sale_order_data_quantity; ?></td>
                        <td><?php echo $v->start_sale_time; ?><br><?php echo $v->down_time; ?></td>
                        <td><?php echo $v->supplier_name; ?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnLog(<?php echo $v->id;?>);" title="销售明细">明细</a>
                            <a class="btn" href="javascript:;" onclick="fnUpdate(<?php echo $v->id;?>);"><i class="fa fa-refresh"></i>刷新</a>
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