<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事 》统计结算 》<a class="nav-a">赛事订单列表</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->   
    <div class="box-content">
		<div class="box-header">
            <span class="label-box" >今日成交订单：<b class="red"><?php echo $num; ?></b></span>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="order_type" value="<?php echo $_GET["order_type"];?>">
                <label style="margin-right:10px;">
                    <span>支付方式：</span>
                    <?php echo downList($pay_list,'f_id','F_NAME','pay_supplier_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>支付时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label> 
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="订单编号/下单人帐号/姓名" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>        
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center; width:25px;'>序号</th>
                        <th>订单编号</th>
                        <th>订单类型</th>
                        <th>商品/服务</th>
                        <th>下单人</th>
                        <th>订单金额(元)</th>
                        <th>收费方式</th>
                        <th>实付金额(元)</th> 
                        <th>订单状态</th>
                        <th>支付方式</th>
                        <th width="105px">支付时间</th>
                        <th>服务单位</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v){
                    $sdata = GfServiceData::model()->find('(info_order_num="'.$v->order_num.'") order by id DESC');
                    $record = OrderRecord::model()->find('(order_num="'.$v->order_num.'") order by id DESC');
                    if($sdata->t_stypeid==14 && $sdata->qmdd_server_set_list_id){
                        $sql = 'select gs.site_name from gf_site gs where '.get_where_club_project('gs.user_club_id');
                        $sql .=' and exists(select * from qmdd_server_set_list qs where id='.$sdata->qmdd_server_set_list_id.' and qs.site_id>0 and gs.id=qs.site_id)';
                        // echo $sql.'<br>';
                        $site_list = Yii::app()->db->createCommand($sql)->queryRow();
                    }
                    if($sdata->t_stypeid>0 && $sdata->t_stypeid<14 && $sdata->qmdd_server_set_list_id){
                        $sql = 'select qs.server_name from qmdd_server_person qs where '.get_where_club_project('qs.club_id');
                        $sql .= ' and exists(select * from qmdd_server_set_list qss where qss.id='.$sdata->qmdd_server_set_list_id.' and qss.s_code=qs.qcode)';
                        // echo $sql.'<br>';
                        // $server_list = Yii::app()->db->createCommand($sql)->queryRow();
                    }
                ?>
                    <tr>
                        <td style='text-align: center;'><?php echo $index; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php if(!empty($sdata)) echo $sdata->order_type_name; ?></td>
                        <td><?php if(!empty($sdata)) echo $sdata->service_name; ?></td>
                        <td><?php echo $v->order_gfaccount; ?>(<?php echo $v->order_gfname; ?>)</td>
                        <td><?php echo $v->order_money; ?></td>
                        <td><?php if(!empty($sdata)) echo $sdata->free_make==0?'免单':'实缴报名费用'; ?></td>
                        <td><?php echo $v->total_money; ?></td>
                        <td>
                            <?php
                                if(!empty($record)){
                                    if($record->order_state==465 && (isset($c_num) && $c_num==0)){
                                        echo "已支付";
                                    }
                                    else echo $record->order_state_name;
                                }
                            ?>
                        </td>
                        <td><?php echo $v->pay_supplier_type_name; ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($v->pay_time)); ?></td>
                        <td><?php if(!empty($sdata)) echo $sdata->supplier_name; ?></td>
                        <td><?php echo show_command('详情',$this->createUrl('update_server', array('id'=>$v->id)));?></td>
                    </tr>
                <?php $index++;  } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        var $star=$('#start');
        var $end=$('#end');
        $star.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
        $end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });
</script>