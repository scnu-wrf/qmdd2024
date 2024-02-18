
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》收/发货管理》退/换货收货处理》<a class="nav-a">已退回</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->      
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;" class="input-text" type="text" name="order_num" value="<?php echo Yii::app()->request->getParam('order_num');?>" placeholder="退换货单号/订单编号/发货物流单号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th>退换商品</th>
                        <th><?php echo $model->getAttributeLabel('buy_count');?></th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th>物流公司</th>
                        <th>物流单号</th>
                        <th><?php echo $model->getAttributeLabel('ret_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo (!empty($v->change_base)) ? $v->change_base->F_NAME : ''; ?></td>
                            <td><?php echo $v->orderdata->product_title; ?>，<?php echo $v->orderdata->json_attr; ?></td>
                            <td><?php echo $v->ret_count; ?></td>
                            <td><?php echo $v->after_sale_state_name; ?></td>
                            <td><?php echo $v->ret_logistics_name; ?></td>
                            <td><?php echo $v->ret_logistics; ?></td>
                            <td><?php echo $v->ret_time; ?></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('update_exam', array('id'=>$v->id,'ret_state'=>372));?>" title="详情">查看</a>
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

    var $time_start=$('#time_start');
    var $time_end=$('#time_end');
    $time_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();}});
    });
    $time_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',minDate:"#F{$dp.$D(\'time_start\')}"});
    });

</script>