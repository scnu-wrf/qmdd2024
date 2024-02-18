
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商城管理查询》<a class="nav-a">退/换货查询</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->     
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>申请时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:10px;">
                        <span>售后类型：</span>
                        <?php echo downList($change_type,'f_id','F_NAME','change_type'); ?>
                </label>
                <label style="margin-right:10px;">
                        <span>审核状态：</span>
                        <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:220px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="售后单号/名称/商家名称">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center; width:25px;">序号</th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th style="width:10%;"><?php echo $model->getAttributeLabel('return_order_num');?></th>
                        <th>退换商品</th>
                        <th>商品状态</th>
                        <th><?php echo $model->getAttributeLabel('change_type');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_count');?></th>
                        <th><?php echo $model->getAttributeLabel('ret_money');?></th>
                        <th>审核状态</th>
                        <th><?php echo $model->getAttributeLabel('after_sale_state');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_id');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('order_date');?></th>
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
                        <td><?php echo ($v->orderdata->logistics_id>0) ? '已发货' : '未发货'; ?></td>
                        <td><?php echo (!empty($v->change_base)) ? $v->change_base->F_NAME : ''; ?></td>
                        <td><?php echo $v->ret_count; ?></td>
                        <td>¥<?php echo $v->ret_money; ?></td>
                        <td><?php echo $v->orderdata->ret_state_name; ?></td>
                        <td><?php echo $v->after_sale_state_name; ?></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><?php echo $v->order_date; ?></td>
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