<div class="box">
    <div class="box-title c">
        <h1>
            <?php 
                if($_REQUEST['index']==1){
                    echo '当前界面：培训/活动 》活动结算 》活动结算统计 》结算明细';
                }elseif($_REQUEST['index']==2){
                    echo '当前界面：财务 》活动结算统计 》结算明细';
                }
            ?>
        </h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li style="padding:0 10px;"><a href="<?php echo $this->createUrl('activityList/index_stat',array('index'=>$_REQUEST['index']));?>">活动结算统计</a></li>
                <li class="current" style="padding:0 10px;">日结算明细</li>
            </ul>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input type="hidden" name="club_id" value="<?php echo Yii::app()->request->getParam('club_id');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <label style="margin-right:20px;">
                    <span>活动标题：</span>
                    <?php echo downList($activity_list,'id','activity_title','title','onchange="changeSignData(this);"'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/账号/发布单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>活动编号</th>
                        <th>活动标题</th>
                        <th>活动内容</th>
                        <th>报名人</th>
                        <th>支付时间</th>
                        <th>实收金额（元）</th>
                        <th><?php echo $model->getAttributeLabel('gf_gross');?></th>
                        <th>平台结算额（元）</th>
                        <th><?php echo $model->getAttributeLabel('club_gross');?></th>
                        <th>单位结算额（元）</th>
                        <th>日期</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                    ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->service_code; ?></td>
                            <td><?php echo $v->service_name; ?></td>
                            <td><?php echo $v->service_data_name; ?></td>
                            <td><?php if(!is_null($v->activity_sign))echo $v->activity_sign->sign_name.'('.$v->sign_account.')'; ?></td>
                            <td><?php if(!is_null($v->mall_order_num))echo $v->mall_order_num->pay_time; ?></td>
                            <td><?php echo $v->buy_price-$v->free_money; ?></td>
                            <td><?php echo floatval($v->gf_gross).'%'; ?></td>
                            <td><?php echo $v->gf_money; ?></td>
                            <td><?php echo floatval($v->club_gross).'%'; ?></td>
                            <td><?php echo $v->club_money; ?></td>
                            <td><?php echo $v->pay_confirm_time; ?></td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    var $start_date=$('#start_date');
    var $end_date=$('#end_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>