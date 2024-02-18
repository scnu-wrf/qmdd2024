<div class="box">
    <div class="box-title c">
        <h1>当前界面：服务单位 》添加意向入驻</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create_service'),'添加'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
                <!--
                <label style="margin-right:10px;">
                    <span>服务单位类型：</span>
                </label>
                -->
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="申请人名称">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th>入驻申请人</th>
                        <th>单位性质</th>
                        <th>所在地区</th>
                        <th>营业项目</th>
                        <th><?php echo $model->getAttributeLabel('club_type'); ?></th>
                        <th>状态</th>
                        <th>操作日期</th>
                        <th><?php echo $model->getAttributeLabel('reasons_adminid'); ?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(123);?>
                    <?php
                        $index = 1;
                        foreach($arclist as $v){
                            if(!empty(explode(",",$v->club_area_code)[0]))$tRegion=TRegion::model()->find('id='.explode(",",$v->club_area_code)[0]);
                            if(!empty(explode(",",$v->club_area_code)[1]))$tRegion2=TRegion::model()->find('id='.explode(",",$v->club_area_code)[1]);
                            $region="";
                            if(!empty($tRegion))$region.=$tRegion->region_name_c;
                            if(!empty($tRegion2))$region.=$tRegion2->region_name_c;
                    ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $index; ?></td>
                        <td><?php echo $v->individual_enterprise==403 ? $v->apply_name : $v->company; ?></td>
                        <td>未指定</td>    <!-- 单位性质 -->
                        <td><?php
                                echo $v->club_area_province;
                                if($v->club_area_city) echo '/'.$v->club_area_city;
                            ?>
                        </td>
                        <td>未指定</td>    <!-- 营业项目 -->
                        <td>
                            <?php
                                echo $v->club_type_name;
                                if($v->individual_enterprise == 403 || $v->individual_enterprise == 404) {
                                    echo '-'.$v->individual_enterprise_name;
                                }
                            ?>
                        </td>
                        <td><?php echo $v->state_name; ?></td>
                        <td><?php echo $v->uDate; ?></td>
                        <td><?php echo $v->reasons_adminid.'/'.$v->reasons_adminname; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update_service', array('id'=>$v->id,'s'=>1))); ?>
                            <!-- <a class="btn" href="<?php // echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a> -->
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script>
<script>
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
});
</script>