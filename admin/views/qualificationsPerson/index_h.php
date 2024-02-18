
<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：服务者 》服务者管理 》入驻待审核</span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">

        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <label style="margin-right:10px;">
                    <span>申请时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $startDate;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $endDate;?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input type="text" style="width:200px" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入账号/姓名">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th width="3%">序号</th>
                        <th width="12%"><?php echo $model->getAttributeLabel('qualification_gfaccount') ?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('qualification_name') ?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('qualification_project_name') ?></th>
                        <th width="12%"><?php echo $model->getAttributeLabel('qualification_type_id') ?></th>
                        <th width="12%">入驻来源</th>
                        <th width="12%">入驻状态</th>
                        <th width="12%">申请时间</th>
                        <th width="12%">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; foreach($arclist as $v) {?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php echo $v->qualification_gfaccount; ?></td>
                            <td><?php echo $v->qualification_name; ?></td>
                            <td><?php echo $v->qualification_project_name; ?></td>
                            <td><?php echo $v->qualification_type; ?></td>
                            <td><?php echo $v->logon_way_name; ?></td>
                            <td><?php echo $v->check_state_name; ?></td>
                            <td><?php if($v->uDate!='0000-00-00 00:00:00')echo $v->uDate; ?></td>
                            <td>
                                <?php echo show_command('审核', $this->createUrl('update_examine', array('id'=>$v->id,'s'=>'1')), '审核'); ?>
                            </td>
                        </tr>
                    <?php $index++; }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div>
<script>
    $(function(){
        var $lock_date_start=$('#lock_date_start,#start_date');
        var $lock_date_end=$('#lock_date_end,#end_date');
        $lock_date_start.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
        $lock_date_end.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});
        });
    });
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'check_state','del'=>374,'yes'=>'撤销成功','no'=>'撤销失败'));?>';
</script>