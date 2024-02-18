<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训统计 》报名费用统计</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="current" style="padding:0 10px;">报名费用统计</li>
                <li style="padding:0 10px;"><a href="<?php echo $this->createUrl('clubTrainSign/pay_stat_data',array('club_id'=>get_session('club_id')));?>">报名费用明细</a></li>
            </ul>
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end;?>">
                </label>
                <label>
                    <span>培训标题：</span>
                    <input style="width:200px;" class="input-text" type="text" id="train_title" name="train_title" value="<?php echo Yii::app()->request->getParam('train_title');?>" placeholder="请输入培训标题">
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
                        <th><?php echo $model->getAttributeLabel('train_code');?></th>
                        <th><?php echo $model->getAttributeLabel('train_title');?></th>
                        <th>报名/参加人数</th>
                        <th>实收总额（元）</th>
                        <th><?php echo $model->getAttributeLabel('train_clubid');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                        $count=ClubTrainSign::model()->count('train_id='.$v->id.' and state=2 and free_state_Id=1202');
                        $num=0;
                        $signList = GfServiceData::model()->findAll('order_type=352 and service_id='.$v->id.' and pay_confirm=1');
                        foreach($signList as $b){
                            $num=$num+($b->buy_price-$b->free_money);
                        }
                    ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->train_code; ?></td>
                            <td><?php echo $v->train_title; ?></td>
                            <td><?php echo $count; ?></td>
                            <td><?php echo $num; ?></td>
                            <td><?php echo $v->train_clubname; ?></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('clubTrainSign/pay_stat_data',array('club_id'=>$v->train_clubid,'title'=>$v->id));?>" title="明细">明细</a>
                            </td>
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

    var $start=$('#start');
    var $end=$('#end');
    $start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>