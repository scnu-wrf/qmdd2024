<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》服务预订》<a class="nav-a">约赛/约练</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->   
    <div class="box-content">
        <div class="box-search" style="border:none; margin:0">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
            <label style="margin-right:10px;">
                <span>预订日期：</span>
                <input style="width:80px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
            </label>
            <label style="margin-right:10px;">
                <span>服务日期：</span>
                <input style="width:80px;" class="input-text" type="text" id="star" name="star" value="<?php echo $star;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
            </label>
            <label style="margin-right:10px;">
                <span>服务状态：</span>
                <?php echo downList($server_state,'f_id','F_NAME','server_state'); ?>
            </label>
            <label style="margin-right:10px;">
                <span>订单状态：</span>
                <?php echo downList($order_state,'f_id','F_NAME','order_state'); ?>
            </label>
            <label style="margin-right:10px;">
                <span>关键字：</span>
                <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="流水号 / 服务名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
            </label>
            <button class="btn btn-blue" type="submit">查询</button>
            <?php $now=date('Y-m-d'); ?>
            <table class="list" style="border:1px solid #ddd;">
                <tr>
                    <td>服务类别</td>
            <?php foreach($stype as $s){ ?>
                    <td><?php echo $s->f_uname; ?></td>
            <?php } ?>
                </tr>
                <tr>
                    <td>今日预定总量</td>
            <?php foreach($stype as $s){ ?>
            <?php $num1=GfServiceData::model()->count('t.add_time>="'.$now.' 00:00:00" and exists(select * from qmdd_server_set_data qsa where qsa.id=t.service_data_id and t_stypeid='.$s->id.')'); ?>
                    <td><span class="red"><?php echo $num1; ?></span></td>
            <?php } ?>
                </tr>
                <tr>
                    <td>今日服务总量</td>
            <?php foreach($stype as $s){ ?>
            <?php $num2=GfServiceData::model()->count('t.servic_time_star>="'.$now.' 00:00:00" and t.servic_time_end<="'.$now.' 23:59:59" and exists(select * from qmdd_server_set_data qsa where qsa.id=t.service_data_id and t_stypeid='.$s->id.')'); ?>
                    <td><span class="red"><?php echo $num2; ?></span></td>
            <?php } ?>
                </tr>
            </table>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style="text-align:center; width:25px;">序号</th> 
                        <th><?php echo $model->getAttributeLabel('order_num');?></th> 
                        <th>服务类别</th>
                        <th><?php echo $model->getAttributeLabel('data_name');?></th>
                        <th>服务项目</th>
                        <th><?php echo $model->getAttributeLabel('service_data_name');?></th> 
                        <th><?php echo $model->getAttributeLabel('buy_price');?></th>
                        <th><?php echo $model->getAttributeLabel('order_state');?></th>
                        <th><?php echo $model->getAttributeLabel('server_state');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th><?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th><?php echo $model->getAttributeLabel('info_order_num');?></th>             
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1;
            foreach($arclist as $v){ ?>
                    <tr>
                        <td style="text-align:center;"><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td> 
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php if(!empty($v->service_data)) echo $v->service_data->t_stypename; ?></td>
                        <td><?php echo $v->data_name; ?></td>
                        <td><?php if(!empty($v->service_data)) echo $v->service_data->order_project_name; ?></td>
                        <td><?php echo $v->service_data_name; ?></td>
                        <td><?php echo $v->buy_price; ?></td>
                        <td><?php echo $v->order_state_name; ?></td>
                        <td><?php echo $v->server_state_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td><?php echo $v->gf_account; ?>/<?php echo $v->gf_name; ?></td>
                        <td><?php echo $v->info_order_num; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update_server', array('id'=>$v->id));?>" title="详情">查看</a>

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