<div class="box" div style="font-size: 9px">
	<div class="box-title c">
        <h1>当前界面：服务者 》平台服务者 》GF服务者列表</h1>
        <span class="back">
            <?php echo show_command('批删除','','删除'); ?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>操作时间：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($type_id,'member_second_id','member_second_name','type_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" placeholder="请输入编码 / 帐号 / 姓名" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('gf_code');?></th>
                        <th><?php echo $model->getAttributeLabel('gfaccount');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_type');?></th>
                        <th><?php echo $model->getAttributeLabel('qualification_level');?></th>
                        <th><?php echo $model->getAttributeLabel('logon_way');?></th>
                        <th><?php echo $model->getAttributeLabel('unit_state');?></th>
                        <th>注销日期</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $index = 1;foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo CHtml::link($v->gf_code, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo CHtml::link($v->gfaccount, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->qualification_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->qualification_type; ?></td>
                        <td><?php echo $v->level_name; ?></td>
                        <td><?php echo $v->logon_way_name; ?></td>
                        <td><?php echo $v->unit_state==649?"已注销":""; ?></td>
                        <td><?php echo date('Y-m-d',strtotime($v->state_time)); ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
                <?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
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