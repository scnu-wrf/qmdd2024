
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》毛利管理》<a class="nav-a">毛利分配设置</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('mallPriceSet/index_forprofit');?>">待审核(<span class="red"><b><?php echo $num; ?></b></span>)</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:10px;">
                    <span>显示时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>销售时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start_time" name="start_time" value="<?php echo $start_time;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time;?>">
                </label>
                <label style="margin-right:10px;">
                    	<span>&nbsp;&nbsp;&nbsp;关键字：</span>
                		<input style="width:200px;" class="input-text"  placeholder="请输入方案编码/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                    <tr class="table-title">
                        <th style='width:25px; text-align: center;'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('event_code');?></th>
                        <th width="15%"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th width="15%">上架商品</th>
                        <th><?php echo $model->getAttributeLabel('mall_member_price_id');?></th>
                        <th><?php echo $model->getAttributeLabel('salesperson_profit_id');?></th>
                        <th>显示时间</th>
                        <th>销售时间</th>
                        <th style="text-align:center">操作</th>
                    </tr>
<?php $index = 1;
if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td>
                <?php $sale=MallPriceSetDetails::model()->findAll('set_id='.$v->id.' AND flash_sale=0');
                    $sale_num=count($sale);
                    $sale_text='';
                    if($sale_num>3){
                        for($i=0;$i<3;$i++){
                        $sale_text.=$sale[$i]['product_name'].'<br>';
                        }
                        $sale_text.='...';
                    } else {
                        for($i=0;$i<$sale_num;$i++){
                        $sale_text.=$sale[$i]['product_name'].'<br>';
                        }
                    }
                            echo $sale_text; ?></td>
                        <td><?php echo $v->mall_member_price_name; ?></td>
                        <td><?php echo $v->salesperson_profit_name; ?></td>
                        <td><?php echo $v->star_time; ?><br><?php echo $v->end_time; ?></td>
                        <td><?php echo $v->start_sale_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_profit', array('id'=>$v->id,'flag'=>'sale'));?>" title="详情">查看</a>
                        </td>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>

$(function(){
    var $start_time=$('#start_time');
    var $end_time=$('#end_time');
    var $start=$('#start');
    var $end=$('#end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});

</script>
