<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：项目》单位项目费用》超时未支付列表</span></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search" style="padding-bottom: 15px;">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>记录时间：</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_start" name="time_start" value="<?php echo $time_start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" placeholder="" id="time_end" name="time_end" value="<?php echo $time_end; ?>">
                </label>
                <label style="margin-right:20px;">
                    <span>注册项目：</span>
                    <?php echo downList($project,'id','project_name','project'); ?>
                </label>
                <label style="margin-right:10px;display: inline-block;width: auto;padding-top: 5px;">
                    <span>关键字：</span>
                    <input style="width:150px;" class="input-text" type="text" placeholder="请输入账号/姓名" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit" >查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <tr>
                    <th class="check" ><input type="checkbox" id="j-checkall" class="input-check"></th>
                    <th>序号</th>
                    <th><?php echo $model->getAttributeLabel('p_code');?></th>
                    <th><?php echo $model->getAttributeLabel('club_name');?></th>
                    <th><?php echo $model->getAttributeLabel('club_type');?></th>
                    <th><?php echo $model->getAttributeLabel('project_id');?></th>
                    <th><?php echo $model->getAttributeLabel('pay_blueprint');?></th>
                    <th><?php echo $model->getAttributeLabel('cost_admission');?></th>
                    <th><?php echo $model->getAttributeLabel('pay_way');?></th>
                    <th>支付状态</th>
                    <th>注册状态</th>
                    <th>记录时间</th>
                    <th>操作</th>
                </tr>
                <?php $index = 1; foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->p_code; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->club_type_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo $v->pay_blueprint_name; ?></td>
                        <td><?php echo $v->cost_admission; ?></td>
                        <td><?php echo $v->pay_way_name; ?></td>
                        <td><?php echo $v->free_state_name; ?></td>
                        <td><?php echo '无效'; ?></td>
                        <td><?php echo $v->cut_date; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update_examine', array('id'=>$v->id))); ?>
                        </td>
                    </tr>
                <?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    $(function(){
        var time_start = $('#time_start');
        var time_end = $('#time_end');
        time_start.on('click',function(){
            var end_input=$dp.$('time_end');
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'time_end\')}'});
        });
        time_end.on('click',function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'time_start\')}'});
        });
    })
    
</script>