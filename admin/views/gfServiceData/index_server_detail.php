<style>.box-table .list tr th,.box-table .list tr td{text-align:center;}</style>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务收费明细表</h1></div><!--box-title end-->     
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">               
                <label style="margin-right:10px;">
                    <span>订单号：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入订单编号">
                </label>
                <label style="margin-right:10px;">
                    <span>下单时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <!-- <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th> -->
                        <th class="list-id">序号</th>
                        <th><?php echo $model->getAttributeLabel('info_order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('order_type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('service_name');?></th>
                        <th><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th><?php echo $model->getAttributeLabel('servic_time_star');?></th>
                        <th><?php echo $model->getAttributeLabel('servic_time_end');?></th>
                        <th><?php echo $model->getAttributeLabel('buy_price');?></th>
                        <th><?php echo $model->getAttributeLabel('service_type');?></th>
                        <th><?php echo $model->getAttributeLabel('cancelled');?></th>
                    </tr>
                </thead>
                <tbody>
					<?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <!-- <td class="check check-item"><input class="input-check" type="checkbox" value="<?php //echo CHtml::encode($v->id); ?>"></td> -->
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->info_order_num; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->gf_name; ?></td>
                        <td><?php echo $v->servic_time_star; ?></td>
                        <td><?php echo $v->servic_time_end; ?></td>
                        <td><?php echo $v->buy_price; ?></td>
                        <td><?php echo $v->service_type_name; ?></td>
                        <td><?php echo ($v->cancelled!=0) ? '服务取消' : ''; ?></td>
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
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            var end_input=$dp.$('end_date')
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
        });
    });
</script>