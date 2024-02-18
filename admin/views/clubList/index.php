<div class="box">
    <div class="box-title c">
        <h1>当前界面：首页 》得闲体育 》官方</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th><?php echo $model->getAttributeLabel('club_code');?></th>
                        <th><?php echo $model->getAttributeLabel('partnership_type');?></th>
                        <th><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th><?php echo $model->getAttributeLabel('company');?></th>
                        <th><?php echo $model->getAttributeLabel('club_address');?></th>
                        <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                        <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                        <th>项目数量</th>
                        <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(123);?>
                    <?php 
                        foreach($arclist as $v){ 
                            if(!empty(explode(",",$v->club_area_code)[0]))$tRegion=TRegion::model()->find('id='.explode(",",$v->club_area_code)[0]);
                            if(!empty(explode(",",$v->club_area_code)[1]))$tRegion2=TRegion::model()->find('id='.explode(",",$v->club_area_code)[1]);
                            $region="";
                            if(!empty($tRegion))$region.=$tRegion->region_name_c;
                            if(!empty($tRegion2))$region.=$tRegion2->region_name_c;
                    ?>
                    <tr> 	
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td> 
                        <td><?php echo CHtml::link($v->club_code, array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->partnership_name; ?></td>
                        <td><?php echo $v->club_name; ?></td>
                        <td><?php echo $v->company; ?></td>
                        <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                        <td><?php echo $v->apply_name;?></td>
                        <td><?php echo $v->contact_phone;?></td>
                        <td>
                            <?php 
                                $p_count=ClubProject::model()->count('club_id='.$v->id.' and auth_state=461 and free_state_Id=1202');
                                echo $p_count;  
                            ?>
                        </td>
                        <td><?php echo substr($v->apply_time,0,10); ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="<?php echo $this->createUrl('clubProject/index_unit',array('club_id' => $v->id,'index'=>2));?>" title="单位项目">项目</a>
                        </td>
                    </tr>
					<?php } ?>
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