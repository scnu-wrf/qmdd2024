<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
        <h1><?php if(empty($_REQUEST['edit_state'])){echo '当前界面：战略伙伴》意向入驻管理》意向入驻申请';}else{echo '当前界面：战略伙伴》单位认证管理》单位认证申请';};?></h1>
        <?php 
            if(!empty($_REQUEST['date'])&&$_REQUEST['date']==1){
                echo '<span class="back"><a class="btn" href="'.$this->createUrl('index_list',['state'=>$_REQUEST['state'],'edit_state'=>!empty($_REQUEST['edit_state'])?$_REQUEST['edit_state']:'']).'" ><i class="fa fa-reply"></i>返回</a></span>';
            }
        ?>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header" style="<?= !empty($_REQUEST['date'])?'display:none':''?>">
            <?php 
                // if(empty($_REQUEST['date'])){
                //     echo '<span class="exam" onclick="on_exam();"><p>今日申请数：(<span style="color:red;font-weight: bold;">'.$count1.'</span>)</p></span>&nbsp;';
                // }
                if(empty($_REQUEST['date'])){
                    if($_REQUEST['state']==721){
                        echo show_command('添加',$this->createUrl('create',array('s'=>1)),'添加');
                    }else{
                        echo show_command('添加','','添加');
                    }
                }
            ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <input type="hidden" name="edit_state" value="<?php echo Yii::app()->request->getParam('edit_state');?>">
                <input id="date" type="hidden" name="date" value="<?php echo Yii::app()->request->getParam('date');?>">
                <label style="margin-right:10px;">
                    <span>申请日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号/名称">
                </label>
                
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if(!empty($_REQUEST['edit_state'])){?>
                    	    <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th><?php echo $model->getAttributeLabel('partnership_type');?></th>
                            <th><?php echo $model->getAttributeLabel('club_name');?></th>
                            <th><?php echo $model->getAttributeLabel('enter_project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th><?php echo $model->getAttributeLabel('edit_state');?></th>
                            <th><?php echo $model->getAttributeLabel('edit_apply_time');?></th>
                            <th>操作</th>
					    <?php }else{?>
                            <th class="check">
                                <input id="j-checkall" class="input-check" type="checkbox">
                            </th>
                    	    <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th>申请<?php echo $model->getAttributeLabel('company');?></th>
                            <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th>状态</th>
                            <th><?php echo $model->getAttributeLabel('apply_time');?></th>
                            <th>操作</th>
					    <?php }?>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(123);?>
					<?php $index = 1;foreach($arclist as $v){ 
                        if(!empty(explode(",",$v->club_area_code)[0]))$tRegion=TRegion::model()->find('id='.explode(",",$v->club_area_code)[0]);
                        if(!empty(explode(",",$v->club_area_code)[1]))$tRegion2=TRegion::model()->find('id='.explode(",",$v->club_area_code)[1]);
                        $region="";
                        if(!empty($tRegion))$region.=$tRegion->region_name_c;
                        if(!empty($tRegion2))$region.=$tRegion2->region_name_c;
                    ?>
                    <tr> 	   
                        <?php if(!empty($_REQUEST['edit_state'])){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code;?></td>
                            <td><?php echo $v->partnership_name;?></td>
                            <td><?php echo $v->club_name;?></td>
                            <td><?php if(!empty($v->enter_project->project_name))echo $v->enter_project->project_name;?></td>
                            <td><?php echo $v->apply_name;?></td>
                            <td><?php echo $v->contact_phone;?></td>
                            <td><?php echo $v->edit_state_name;?></td>
                            <td><?php echo substr($v->uDate,0,10); ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update_data', array('id'=>$v->id,'s'=>1))); ?>
                                <?php echo empty($v->edit_state)||(!empty($v->edit_state)&&$v->edit_state==721)?'<a class="btn" href="javascript:;" onclick="we.cancel('. $v->id. ', cancelUrl);" title="取消">取消</a>':''; ?>
                            </td>
					    <?php }else{?>
                            <td class="check check-item">
                                <input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>" <?=$v->state!=721?"disabled=disabled":''?>>
                            </td>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code;?></td>
                            <td><?php echo $v->company;?></td>
                            <td><?php echo $v->company_type;?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->apply_name;?></td>
                            <td><?php echo $v->contact_phone;?></td>
                            <td><?php echo $v->state_name;?></td>
                            <td><?php echo substr($v->uDate,0,10); ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'s'=>1))); ?>
                                <?php echo $v->state==721?show_command('删除','\''.$v->id.'\''):''; ?>
                            </td>
					    <?php }?>
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
var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'edit_state','del'=>null,'yes'=>'取消成功','no'=>'取消失败'));?>';
</script>
<script>
    $(function(){
        var $start_time=$('#start_date');
        var $end_time=$('#end_date');
        $start_time.on('click', function(){
            var end_input=$dp.$('end_date')
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
        });
    });
    
    function on_exam(){
        $('#date').val(1); 
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }

    <?php if($_REQUEST['state']!=721){?>
        $(".box-header>.btn:eq(0)").on("click",function(){
            $.dialog.data('club_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/clubEditlist", array('club_type'=>189,'state'=>2));?>',{
                id:'danwei',
                lock:true,
                opacity:0.3,
                title:'资料待完善的单位',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('club_id')>0){
                        window.location.href="<?php echo $this->createUrl('update_data'); ?>&id="+$.dialog.data('club_id')+'&s=1';
                    }
                }
            });
            return false;
        })
    <?php }?>
</script>