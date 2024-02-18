<!-- <style>
    .box-detail-tab li{
        width:24.9173%;
        border-right:solid 1px #d9d9d9;
        line-height: 30px;
        font-size:0.5rem;
    }
    .box-detail-tab{
        margin:10px auto 0;
    }
    .box-title h4{
        display: inline-block;
        width: auto;
        color: #444;
        font-size:12px;
        line-height: 30px;
    }
    .lode_po{
        color:#333;
    }
</style> -->
<div class="box">
    <!-- <div class="box-detail-tab">
        <ul class="c">
            <li><a href="<?php //echo $this->createUrl('clubProject/index_examine'); ?>">单位项目待审核列表</a></li>
            <li class="current" style="border-right:none;"><a href="<?php //echo $this->createUrl('qualificationsPerson/index_examine'); ?>">服务者待审核列表</a></li>
        </ul>
    </div>box-detail-tab end -->
    <div class="box-title c">
        <h1><span>当前界面：服务者 》服务者管理 》服务者入驻</span></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <!-- <label style="margin-right:20px;">
                    <span>性别：</span>
                    <?php //echo downList($sex,'f_id','F_NAME','qualification_sex'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php //echo downList($project_list,'id','project_name','project'); ?>
                </label>
                <label for="">
                    <span>类型：</span>
                    <?php //echo downList($qualification_type_id,'f_id','F_NAME','qualification_type_id'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>资质等级：</span>
                    <?php //echo downList($identity,'f_id','F_NAME','identity'); ?>
                </label> -->
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>关键字：</span>
                    <input type="text" style="width:200px" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入账号/姓名">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>
        <div class="box-table">
            <table class="list">
                <thead>
                <tr>
                    <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                    <th width="3%">序号</th>
                    <th width="13.8%">账号姓名</th>
                    <th width="13.8%">持有资质</th>
                    <th width="13.8%"><?php echo $model->getAttributeLabel('qualification_project_name') ?></th>
                    <th width="13.8%"><?php echo $model->getAttributeLabel('qualification_type_id') ?></th>
                    <th width="13.8%">状态</th>
                    <th width="13.8%">操作时间</th>
                    <th width="13.8%">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php $index = 1; foreach($arclist as $v) {?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->qualification_gfaccount.'/'.$v->qualification_name; ?></td>
                        <td><?php echo $v->qualification_identity_type_name.'/'.$v->qualification_title; ?></td>
                        <td><?php echo $v->qualification_project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->check_state_name; ?></td>
                        <td><?php if($v->uDate!='0000-00-00 00:00:00')echo $v->uDate; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';

    var $start_date=$('#start_date');
    var $end_date=$('#end_date');
    $start_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_date.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>