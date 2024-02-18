<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品上架》<a class="nav-a">待售商品列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>销售时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_time" name="start_time" value="<?php echo $start_time;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time;?>">
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
                        <th><?php echo $model->getAttributeLabel('Inventory_quantity');?></th>
                        <th><?php echo $model->getAttributeLabel('sale_price');?></th>
                        <th>销售时间</th>
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
                        <td><?php echo $v->Inventory_quantity; ?></td>
                        <td><?php echo $v->sale_price; ?></td>
                        <td><?php echo $v->start_sale_time; ?><br><?php echo $v->down_time; ?></td>
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

</script>