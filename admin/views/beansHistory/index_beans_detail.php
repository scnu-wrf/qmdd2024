
<div class="box">
    <div class="box-title c">
        <h1>当前界面：系统》积分管理》体育豆明细</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="member_id" value="<?php echo Yii::app()->request->getParam('member_id');?>">
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
                        <th><?php echo $model->getAttributeLabel('got_beans_code');?></th>
                        <th><?php echo $model->getAttributeLabel('got_beans_name');?></th>
                        <th>兑换类型</th>
                        <th>兑换内容</th>
                        <th>增加豆数</th>
                        <th>消耗豆数</th>
                        <th>剩余体育豆</th>
                        <th>日期</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->got_beans_code;?></td>
                            <td><?php echo $v->got_beans_name;?></td>
                            <td><?php if(!is_null($v->baseCode))echo $v->baseCode->F_NAME; ?></td>
                            <td><?php echo $v->got_beans_reson_name;?></td>
                            <td><?php echo $v->got_beans_num; ?></td>
                            <td><?php echo $v->consume_beans_num; ?></td>
                            <td>
                                <?php if(!empty($v->gfuser)){
                                    echo $v->gfuser->beans;
                                }elseif(!empty($v->clubname)){
                                    echo $v->clubname->beans;
                                }?>
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
