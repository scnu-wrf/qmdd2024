
<div class="box">
    <div class="box-title c">
        <h1>当前界面：项目》单位项目费用》项目费用明细</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>确认时间：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
                <!-- <label style="margin-right:20px;">
                    <span>单位类型：</span>
                    <?php //echo downList($base_code,'f_id','F_NAME','type'); ?>
                </label> -->
                <label style="margin-right:20px;">
                    <span>注册项目：</span>
                    <?php echo downList($project,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入项目/单位/账号/缴费单号">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <tr>
                        <th>序号</th>
                        <th>支付订单号</th>
                        <th>单位管理账号</th>
                        <th>服务平台名称</th>
                        <th>单位类型</th>
                        <th>注册项目</th>
                        <th>收费项目名称</th>
                        <th>收费方式</th>
                        <th>应收费用</th>
                        <th>减免金额</th>
                        <th>实收费用</th>
                        <!-- <th>支付方式</th> -->
                        <th>确认时间</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo $v->order_num+$v->id; ?></td>
                            <td><?php if(!empty($v->club_projectid->p_code))echo $v->club_projectid->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php if(!empty($v->club_projectid->club_type_name))echo $v->club_projectid->club_type_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php if(!empty($v->club_projectid->cost_oper)){ echo '入驻费'; }else if(!empty($v->club_projectid->renew_oper)){ echo '续签费'; } ?></td>
                            <td><?php if(!empty($v->club_projectid->pay_way_name))echo $v->club_projectid->pay_way_name; ?></td>
                            <?php if(!empty($v->club_projectid->cost_oper)){?>
                            <td><?php echo $v->club_projectid->cost_admission; ?></td>
                            <td><?php echo $v->club_projectid->free_charge; ?></td>
                            <td><?php echo $v->club_projectid->cost_account; ?></td>
                            <?php }else if(!empty($v->club_projectid->renew_oper)){?>
                            <td><?php echo $v->club_projectid->renew; ?></td>
                            <td><?php echo $v->club_projectid->renew_free; ?></td>
                            <td><?php echo $v->club_projectid->renew_date; ?></td>
                            <?php }else{?>
                            <td><?php echo ''; ?></td>
                            <td><?php echo ''; ?></td>
                            <td><?php echo ''; ?></td>
                            <?php }?>
                            <!-- <th>支付方式</th> -->
                            <td><?php echo $v->f_userdate; ?></td>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </thead>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var $start_time=$('#time_start');
    var $end_time=$('#time_end');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>