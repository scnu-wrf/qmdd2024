
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》<a class="nav-a">换货发货处理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('returnGoods/index_forchange');?>">待换货(<b class="red"><?php echo $num;?></b>)</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>操作时间：</span>
                    <input style="width:75px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start; ?>">
                    <span>-</span>
                    <input style="width:75px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="售后单号/物流单号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px; text-align:center;">序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th>换货商品</th>
                        <th><?php echo $model->getAttributeLabel('buy_count');?></th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th>物流信息</th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('change_date');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->return_order_num; ?></td>
                        <td><?php echo $v->orderdata->product_title; ?>，<?php echo $v->orderdata->json_attr; ?></td>
                        <td><?php echo $v->ret_count; ?></td>
                        <td><?php echo $v->after_sale_state_name; ?></td>
                        <td><?php echo $v->change_logistics_name; ?>/<?php echo $v->change_no; ?></td>
                        <td><?php echo $v->change_date; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_change', array('id'=>$v->id));?>" title="发货详情">查看</a>
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

    var $time_start=$('#start');
    var $time_end=$('#end');
    var end_input=$dp.$('end');
    $time_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();}});
    });
    $time_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',minDate:"#F{$dp.$D(\'start\')}"});
    });

</script>