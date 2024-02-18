
<div class="box">
    <div class="box-title c">
        <h1>
            当前界面：系统》体育豆》会员体育豆列表
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>更新时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_time" name="start_time" value="<?php echo $start_time; ?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_time" name="end_time" value="<?php echo $end_time; ?> ">
                </label>
                <label style="margin-right:10px;">
                    <span>积分范围：</span>
                    <input style="width:40px;" class="input-text" type="text" name="min_credit" value="<?php echo Yii::app()->request->getParam('min_credit'); ?>" placeholder="最小值">
                    <span>-</span>
                    <input style="width:40px;" class="input-text" type="text" name="max_credit" value="<?php echo Yii::app()->request->getParam('max_credit'); ?>" placeholder="最大值">
                </label>
                <label style="margin-right:10px;">
                    <span>体育豆范围：</span>
                    <input style="width:40px;" class="input-text" type="text" name="min_beans" value="<?php echo Yii::app()->request->getParam('min_beans'); ?>" placeholder="最小值">
                    <span>-</span>
                    <input style="width:40px;" class="input-text" type="text" name="max_beans" value="<?php echo Yii::app()->request->getParam('max_beans'); ?>" placeholder="最大值">
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
                        <th width="150px;"><?php echo $model->getAttributeLabel('got_beans_code');?></th>
                        <th width="200px;"><?php echo $model->getAttributeLabel('got_beans_name');?></th>
                        <th>当前积分</th>
                        <th>体育豆数量</th>
                        <th>更新日期</th>
                        <th width="200px;">操作</th>
                    </tr>
                    <?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo isset($v->id)?$v->club_code:$v->GF_ACCOUNT;?></td>
                            <td><?php echo isset($v->id)?$v->club_name:$v->GF_NAME;?></td>
                            <td><?php echo isset($v->id)?$v->club_credit:$v->CREDIT;?></td>
                            <td><?php echo $v->beans;?></td>
                            <td><?php echo $v->cb_uDate;?></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('gfCreditHistory/index_credit_detail',array('gf_id' => isset($v->id)?$v->id:$v->GF_ID,'object2'=>isset($v->id)?502:210));?>" title="积分明细">积分明细</a>
                                <a class="btn" href="<?php echo $this->createUrl('index_beans_detail', array('member_id'=>isset($v->id)?$v->id:$v->GF_ID));?>" title="体育豆明细">体育豆明细</a>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </table>
            </thead>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';

    var $start_time=$('#start_time');
    var $end_time=$('#end_time');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
    });
</script>
