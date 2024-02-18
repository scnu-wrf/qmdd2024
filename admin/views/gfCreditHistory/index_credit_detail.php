
<div class="box">
    <div class="box-title c">
        <h1>当前界面：系统》积分管理》会员积分明细</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="gf_id" value="<?php echo Yii::app()->request->getParam('gf_id');?>">
                <input type="hidden" name="object2" value="<?php echo Yii::app()->request->getParam('object2');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
				<label style="margin-right:20px;">
                    <span>兑换类型：</span>
                    <?php echo downList($object,'f_id','F_NAME','object'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入账号/名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <thead>
                <table class="list">
                    <tr>
                        <th>序号</th>
                        <th>GF账号/管理账号</th>
                        <th>姓名/名称</th>
                        <th>兑换类型</th>
                        <th>兑换内容</th>
                        <th>获得积分</th>
                        <th>兑换数量</th>
                        <th>消耗积分</th>
                        <th>剩余积分</th>
                        <th>日期</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->account;?></td>
                            <td><?php echo $v->nickname;?></td>
                            <td><?php if(!empty($v->gfCredit->baseCode->F_NAME))echo $v->gfCredit->baseCode->F_NAME; ?></td>
                            <td><?php echo $v->got_credit_reson;?></td>
                            <td><?php echo $v->add_or_reduce==1?$v->credit:''; ?></td>
                            <td><?php if(!is_null($v->beansHistory))echo $v->beansHistory->got_beans_num; ?></td>
                            <td><?php echo $v->add_or_reduce==2?$v->credit:''; ?></td>
                            <td>
                                <?php if($v->object==502){
                                    if(!is_null($v->clubname))echo $v->clubname->club_credit;
                                }else{
                                    if(!is_null($v->gfuser))echo $v->gfuser->CREDIT;
                                } ?>
                            </td>
                            <td><?php echo $v->exchange_time;?></td>
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
