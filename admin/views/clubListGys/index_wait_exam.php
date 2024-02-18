<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：战略伙伴》意向入驻管理》添加待审核</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <input type="hidden" name="state" value="<?php echo Yii::app()->request->getParam('state'); ?>">
                <input type="hidden" name="edit_state" value="<?php echo Yii::app()->request->getParam('edit_state'); ?>">
                <input id="date" type="hidden" name="date" value="<?php echo Yii::app()->request->getParam('date'); ?>">
                <input type="hidden" id="to_day" name="to_day" value="">
                <label style="margin-right:10px;">
                    <span>查询日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date'); ?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date'); ?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>" placeholder="请输入申请单位/申请人名称">
                </label>

                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div>

        <div class="box-table">
            <table class="list" style="text-align:left;">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('club_code'); ?></th>
                        <th><?php echo $model->getAttributeLabel('company'); ?></th>
                        <th><?php echo $model->getAttributeLabel('company_type_id'); ?></th>
                        <th><?php echo $model->getAttributeLabel('club_address'); ?></th>
                        <th><?php echo $model->getAttributeLabel('apply_name'); ?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone'); ?></th>
                        <th>状态</th>
                        <th><?php echo $model->getAttributeLabel('apply_time'); ?></th>
                        <th >操作</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $index = 1;
                    foreach ($arclist as $v) {
                        if (!empty(explode(",", $v->club_area_code)[0])) $tRegion = TRegion::model()->find('id=' . explode(",", $v->club_area_code)[0]);
                        if (!empty(explode(",", $v->club_area_code)[1])) $tRegion2 = TRegion::model()->find('id=' . explode(",", $v->club_area_code)[1]);
                        $region = "";
                        if (!empty($tRegion)) $region .= $tRegion->region_name_c;
                        if (!empty($tRegion2)) $region .= $tRegion2->region_name_c;
                        ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company; ?></td>
                            <td><?php echo $v->company_type;  ?></td>
                            <td><?php echo $v->club_area_code != "" ? $region : ''; ?></td>
                            <td><?php echo $v->apply_name; ?></td>
                            <td><?php echo $v->contact_phone; ?></td>
                            <td><?php echo $v->state_name;?></td>
                            <td><?php echo $v->apply_time;?></td>
                            <td> 
                                <?php 
                                    if($v->state==1538){
                                        echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,"action"=>'index_wait_exam'))); 
                                    }else{
                                        echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,"action"=>'index_wait_exam')));
                                    }
                                ?>
                                <?php echo $v->state!=371?show_command('删除','\''.$v->id.'\''):'
                                <a class="btn" href="javascript:;" onclick="we.cancel('. $v->id. ', cancelUrl);" title="撤销">撤销</a>'; ?>
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
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>721,'yes'=>'撤销成功','no'=>'撤销失败'));?>';
    
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
</script>