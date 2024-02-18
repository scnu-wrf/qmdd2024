<?php
if(!isset($_REQUEST['club_id'])){
     $_REQUEST['club_id']=get_session('club_id');
     $r_val=0;
}else{
    $_go=true;
}
//  var_dump($_SESSION);
// var_dump($_REQUEST);
if(empty($_REQUEST['index'])){
    $_REQUEST['index']='';
}
?>
<style>
    #j-delete{
        margin:10px;
    }
    <?php 
        if($_REQUEST['index']==5){
            echo ".box-header{padding:0;}";
        }
    ?>
</style>
<div class="box">
    <div class="box-title c">
        <h1><?php if($_REQUEST['index']==3){echo '当前界面：项目》单位项目注册》注册项目';}elseif($_REQUEST['index']==1){echo '当前界面：项目 》单位项目注册 》项目注册审核';}elseif($_REQUEST['index']==2){echo '当前界面：项目 》单位项目管理 》单位项目列表';}elseif($_REQUEST['index']==4){echo '当前界面：项目》单位项目注册》项目注册审核》待审核';}elseif($_REQUEST['index']==5){echo '当前界面：项目》单位项目注册》审核未通过列表';}elseif($_REQUEST['index']==6){echo '当前界面：项目管理->项目冻结';}elseif($_REQUEST['index']==7){echo '当前界面：项目 》单位项目注册 》注册待审核';}?></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
        <?php if(!empty($_go)&&$_go==1){?>
            <span class="back"><a class="btn"  href="javascript:history.go(-1)" ><i class="fa fa-reply"></i>返回</a></span>
        <?php }?>
    </div><!--box-title end-->
    <div class="box-content">
        <?php 
            $club_state=ClubList::model()->find('club_type in(8,189) and id='.get_session("club_id"));
            if(((get_session("club_id")==8||get_session("club_id")==189)&&isset($club_state->edit_state)&&$club_state->edit_state==2)||(get_session("club_id")!=8||get_session("club_id")!=189)){
        ?>
    	<div class="box-header" style="<?=$_REQUEST['index']!=1&&$_REQUEST['index']!=3&&$_REQUEST['index']!=5?'display:none':''?>">
            <?php if($_REQUEST['index']==1){?>
            <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <?php } ?>
            <?php if($_REQUEST['index']==3){?>
            <?php echo show_command('添加',$this->createUrl('create_unit',array('club_id'=>$_REQUEST['club_id'])),'添加'); ?>
            <?php } ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <?php }?>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input id="index" type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input type="hidden" name="club_id" value="<?php if(isset($r_val)){echo $r_val;}else{echo $_REQUEST["club_id"];}?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <?php if($_REQUEST['index']==3||$_REQUEST['index']==7||$_REQUEST['index']==1||$_REQUEST['index']==4||$_REQUEST['index']==5){?>
                <label style="margin-right:10px;">
                    <span><?php if($_REQUEST['index']==3||$_REQUEST['index']==7||$_REQUEST['index']==4){echo '申请日期：';}else{echo '审核日期：';};?></span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
                <?php }?>
                <?php if($_REQUEST['index']==1){?>
				<label style="margin-right:20px;">
                    <span>单位类别：</span>
                    <?php echo downList($partnership_type,'member_second_id','member_second_name','partnership_type'); ?>
                </label>
                <?php }?>
                <?php if($_REQUEST['index']==2){?>
                    <label style="margin-right:20px;">
                        <span>项目：</span>
                        <?php echo downList($project_list,'id','project_name','project_id'); ?>
                    </label>
                <?php }?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="注册单位名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list"><!--此处项目，链接club_project表-->
                	<tr class="table-title">
                        <?php if($_REQUEST['index']==1){?>
                            <td >序号</td>
                            <td ><?php echo $model->getAttributeLabel('p_code');?></td>
                            <td ><?php echo $model->getAttributeLabel('club_name');?></td>
                            <td ><?php echo $model->getAttributeLabel('partnership_type');?></td>
                            <td ><?php echo $model->getAttributeLabel('project_id');?></td>
                            <td ><?php echo $model->getAttributeLabel('approve_state');?></td>
                            <td ><?php echo $model->getAttributeLabel('refuse_state_name');?></td>
                            <td ><?php echo $model->getAttributeLabel('audit_time');?></td> 
                            <td ><?php echo $model->getAttributeLabel('audit_adminid');?></td> 
                            <td>操作</td>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <td >序号</td>
                            <th><?php echo $model->getAttributeLabel('project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('project_level');?></th>
                            <th><?php echo $model->getAttributeLabel('project_state');?></th>
                            <th><?php echo $model->getAttributeLabel('effective_date');?></th>
                            <th><?php echo $model->getAttributeLabel('valid_until');?></th>
                            <td>操作</td>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <td >序号</td>
                            <td><?php echo $model->getAttributeLabel('project_id');?></td>
                            <td><?php echo $model->getAttributeLabel('approve_state');?></td>
                            <td>状态</td>
                            <td><?php echo $model->getAttributeLabel('uDate');?></td>
                            <td>操作</td>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <td >序号</td>
                            <td ><?php echo $model->getAttributeLabel('p_code');?></td>
                            <td ><?php echo $model->getAttributeLabel('club_name');?></td>
                            <td ><?php echo $model->getAttributeLabel('partnership_type');?></td>
                            <td ><?php echo $model->getAttributeLabel('project_id');?></td>
                            <td ><?php echo $model->getAttributeLabel('approve_state');?></td>
                            <td ><?php echo $model->getAttributeLabel('refuse_state_name');?></td>
                            <td ><?php echo $model->getAttributeLabel('add_time');?></td>
                            <td>操作</td>
                        <?php }elseif($_REQUEST['index']==5){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <td >序号</td>
                            <td ><?php echo $model->getAttributeLabel('p_code');?></td>
                            <td ><?php echo $model->getAttributeLabel('club_name');?></td>
                            <td ><?php echo $model->getAttributeLabel('partnership_type');?></td>
                            <td ><?php echo $model->getAttributeLabel('project_id');?></td>
                            <td ><?php echo $model->getAttributeLabel('approve_state');?></td>
                            <td ><?php echo $model->getAttributeLabel('refuse_state_name');?></td>
                            <td ><?php echo $model->getAttributeLabel('audit_time');?></td>
                            <td ><?php echo $model->getAttributeLabel('audit_adminid');?></td> 
                            <td>操作</td>
                        <?php }elseif($_REQUEST['index']==6){?>
                            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                            <td >序号</td>
                            <td ><?php echo $model->getAttributeLabel('project_id');?></td>
                            <td ><?php echo $model->getAttributeLabel('club_name');?></td>
                            <td ><?php echo $model->getAttributeLabel('p_code');?></td>
                            <td ><?php echo $model->getAttributeLabel('partnership_type');?></td>
                            <td ><?php echo $model->getAttributeLabel('project_state');?></td>
                            <td ><?php echo $model->getAttributeLabel('add_time');?></td>
                            <td ><?php echo $model->getAttributeLabel('uDate');?></td>  
                            <td ><?php echo $model->getAttributeLabel('admin_gfid');?></td>  
                            <td ><?php echo $model->getAttributeLabel('refuse');?></td>  
                            <td>操作</td>
                        <?php }elseif($_REQUEST['index']==7){?>
                            <td >序号</td>
                            <td ><?php echo $model->getAttributeLabel('project_id');?></td>
                            <td ><?php echo $model->getAttributeLabel('approve_state');?></td>
                            <td >状态</td>
                            <td ><?php echo $model->getAttributeLabel('add_time');?></td>
                            <td>操作</td>
                        <?php } ?>
                    </tr>
                    <?php
					$index = 1;
					 foreach($arclist as $v){ ?>
                    <tr>
                        <?php if($_REQUEST['index']==1){?>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->partnership_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->approve_state_name; ?></td>
                            <td><?php echo $v->refuse_state_name; ?></td>
                            <td><?php echo substr($v->audit_time,0,10); ?></td>
                            <td><?php echo (!is_null($v->auditAdmin)?$v->auditAdmin->admin_gfaccount:'').'/'.$v->audit_adminname; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update_unit', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td> 
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->level_name; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo $v->entry_validity; ?></td>
                            <td><?php if(!empty($v->effective_date)&&!empty($v->valid_until))echo $v->effective_date.'<br>'.$v->valid_until; ?></td>
                            <td>
                                <a class="btn" href="<?php echo $this->createUrl('qualificationClub/index1',array('id'=>$v->id, 'club_id'=>$v->club_id, 'project_id'=>$v->project_id));?>" title="服务者">服务者</a>
                                <?php echo show_command('详情',$this->createUrl('update_unit', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td> 
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->approve_state_name; ?></td>
                            <td><?php echo $v->refuse_state_name; ?></td>
                            <td><?php echo $v->uDate; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update_unit', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                                <?php echo show_command('删除','\''.$v->id.'\''); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->partnership_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->approve_state_name; ?></td>
                            <td><?php echo $v->refuse_state_name; ?></td>
                            <td><?php echo $v->add_time; ?></td>
                            <td>
                                <?php echo show_command('审核',$this->createUrl('update_unit', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==5){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td> 
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->partnership_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->approve_state_name; ?></td>
                            <td><?php echo $v->refuse_state_name; ?></td>
                            <td><?php echo $v->audit_time; ?></td>
                            <td><?php echo (!is_null($v->auditAdmin)?$v->auditAdmin->admin_gfaccount:'').'/'.$v->audit_adminname; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update_unit', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                                <?php //echo show_command('删除','\''.$v->id.'\''); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==6){?>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td> 
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->p_code; ?></td>
                            <td><?php echo $v->partnership_name; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo $v->add_time; ?></td>
                            <td><?php echo substr($v->uDate,0,10); ?></td>
                            <td><?php echo $v->admin_gfname; ?></td>
                            <td><?php echo $v->refuse; ?></td>
                            <td>
                                <?php echo show_command('修改',$this->createUrl('update_unit', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==7){?>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->approve_state_name; ?></td>
                            <td><?php echo $v->refuse_state_name; ?></td>
                            <td><?php echo $v->add_time; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update_unit', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                                <?php 
                                    if($v->state==371){
                                        echo '<a class="btn" href="javascript:;" onclick="we.cancel('. $v->id. ', cancelUrl);" title="撤销">撤销</a>';
                                    }elseif($v->state==373){
                                        echo show_command('删除','\''.$v->id.'\''); 
                                    }
                                ?>
                            </td>
                        <?php } ?>
                    </tr>
                   <?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>721,'yes'=>'撤销成功','no'=>'撤销失败'));?>';

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

    function getBack(){
        history.go(-1);
    }

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#index').val(4);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        }
    }
</script>
