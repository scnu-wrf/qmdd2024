<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》服务预订》<a class="nav-a">动动约预订数据</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->   
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
            <label style="margin-right:10px;">
                <span>预订日期：</span>
                <input style="width:80px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
            </label>
            <label style="margin-right:10px;">
                <span>服务日期：</span>
                <input style="width:80px;" class="input-text" type="text" id="star" name="star" value="<?php echo Yii::app()->request->getParam('star');?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo Yii::app()->request->getParam('end');?>">
            </label>
            <label style="margin-right:10px;">
                <span>支付状态：</span>
                <?php echo downList($is_pay,'f_id','F_NAME','is_pay'); ?>
            </label>
            <label style="margin-right:10px;">
                <span>关键字：</span>
                <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="流水号 / 服务名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
            </label>
            <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center;">序号</th>
                        <th><?php echo $model->getAttributeLabel('order_num');?></th> 
                        <th><?php echo $model->getAttributeLabel('order_type');?></th>
                        <th><?php echo $model->getAttributeLabel('service_name');?></th>
                        <th><?php echo $model->getAttributeLabel('order_state');?></th>
                        <th><?php echo $model->getAttributeLabel('is_pay');?></th>
                        <th><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th><?php echo $model->getAttributeLabel('service_data_name');?></th>              
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('add_time');?></th> 
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('info_order_num');?></th>
                        <th style="text-align:center;">操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php
                    $index = 1;
                      
                     foreach($arclist as $v){ ?>
                    <tr>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->order_type_name; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->order_state_name; ?></td>
                        <td><?php echo $v->is_pay_name; ?></td>
                        <td><?php echo $v->gf_name; ?></td>
                        <td><?php echo $v->service_data_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td><?php echo $v->info_order_num; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_server', array('id'=>$v->id));?>" title="详情"><i class="fa fa-edit"></i></a>

                        </td>
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
    var $star_time=$('#start_date');
    var $end_time=$('#end_date');
    $star_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    var $star=$('#star');
    var $end=$('#end');
    $star.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
});
</script>