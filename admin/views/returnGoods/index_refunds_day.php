
<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》退款管理》<a class="nav-a">交易退款</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('returnGoods/index_refunds');?>">待退款(<b class="red"><?php echo $for_num;?></b>)</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>订单类型：</span>
                    <?php echo downList($order_type,'f_id','F_NAME','order_type'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>退款时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="退换货单号">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        <table class="list">
                <thead>
                    <tr>
                        <th style="width:25px; text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('refunds_num');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_gfname');?></th>
                        <th>商品信息</th>
                        <th>退款数量</th>
                        <th><?php echo $model->getAttributeLabel('act_ret_money');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_pay_supplier_type');?></th>
                        <th><?php echo $model->getAttributeLabel('state');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('ret_date');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v){?>
                        <tr>
                            <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php if(!empty($v->ordertype)) echo $v->ordertype->F_NAME; ?></td>
                            <td><?php echo $v->order_num; ?></td>
                            <td><?php echo $v->return_order_num; ?></td>
                            <td><?php if(!empty($v->orderinfo)) echo $v->orderinfo->order_gfaccount.'('.$v->orderinfo->order_gfname.')'; ?></td>
                            <td><?php echo $v->orderdata->product_title; ?>，<?php echo $v->orderdata->json_attr; ?></td>
                            <td><?php echo $v->ret_count; ?></td>
                            <td>¥<?php echo $v->act_ret_money; ?></td>
                            <td><?php if(!empty($v->ret_pay))echo $v->ret_pay->F_NAME; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo $v->ret_date; ?></td>
                            <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                            <td><a class="btn" href="<?php echo $this->createUrl('update_refunds', array('id'=>$v->id,'day'=>0));?>" title="编辑">查看</a></td>
                        </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    // var deleteUrl = '<?php //echo $this->createUrl('delete', array('id'=>'ID'));?>';

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