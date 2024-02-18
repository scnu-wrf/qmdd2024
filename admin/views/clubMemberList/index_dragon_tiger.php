
<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1>
            <span>当前界面：会员 》龙虎会员管理 》龙虎会员列表</span>
        </h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header"> 
            <?php echo show_command('添加',$this->createUrl('create_dragon_tiger'),'添加'); ?>
        </div>
        <div class="box-search" style="padding-bottom: 15px;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>注册时间：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" placeholder="" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit" >查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <tr>
                        <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('member_project_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('gf_account') ?></th>
                        <th><?php echo $model->getAttributeLabel('zsxm') ?></th>
                        <th><?php echo $model->getAttributeLabel('integral') ?></th>
                        <th><?php echo $model->getAttributeLabel('project_level_id') ?></th>
                        <th><?php echo $model->getAttributeLabel('logon_way') ?></th>
                        <th><?php echo $model->getAttributeLabel('grade_achieve_time') ?></th>
                        <th>操作</th>
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->gf_account; ?></td>
                        <td><?php echo $v->zsxm; ?></td>
                        <td><?php echo $v->integral; ?></td>
                        <td><?php echo $v->project_level_name; ?></td>
                        <td><?php echo $v->logon_way_name; ?></td>
                        <td><?php if(!is_null($v->upgrade_list))echo $v->upgrade_list->grade_achieve_time; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update_dragon_tiger', array('id'=>$v->id))); ?>
                            <a class="btn" href="<?php echo $this->createUrl('topScoreHistory/index', array('gf_id'=>$v->member_gfid,'project_id'=>$v->member_project_id));?>" title="积分明细">积分明细</a>
                        </td>
                    </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var time_start = $('#time_start');
        var time_end = $('#time_end');
        time_start.on('click',function(){
            var end_input=$dp.$('time_end');
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'time_end\')}'});
        });
        time_end.on('click',function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'time_start\')}'});
        });
</script>