<?php //var_dump($_SESSION);?>
<?php //var_dump($_SERVER['SERVER_NAME']);?>
<?php 
?>
<div class="box">
    <span style="float:right;padding-right:15px;">
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    </span>
    <div class="box-title c">
    <h1><?php if($_REQUEST['index']==1){echo '当前界面：社区单位》单位认证管理 》单位认证审核';}elseif($_REQUEST['index']==2){echo '当前界面：社区单位 》单位认证管理 》信息认证审核 》待审核';}elseif($_REQUEST['index']==3){echo '当前界面：社区单位 》单位认证管理 》单位认证取消/审核未通过';}elseif($_REQUEST['index']==4){echo '当前界面：社区单位 》社区单位管理 》社区单位列表';}elseif($_REQUEST['index']==5){echo '当前界面：社区单位 》单位认证管理 》单位认证待审核';}?></h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header" style="<?=$_REQUEST['index']!=1?"display:none;":""?>">
            <?php if($_REQUEST['index']==1){?>
            <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <?php } ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input id="index" type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input type="hidden" name="state" id="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <input type="hidden" name="edit_state" id="edit_state" value="<?php echo Yii::app()->request->getParam('edit_state');?>">
                <?php if($_REQUEST['index']==1||$_REQUEST['index']==2){ ?>
                    <label style="margin-right:10px;">
                        <span><?=$_REQUEST['index']==1?"审核":"申请"?>日期：</span>
                        <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                        <span>-</span>
                        <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                    </label>
                    <label style="margin-right:20px;">
                        <span>入驻类型：</span>
                        <?php echo downList($individual_enterprise,'f_id','F_NAME','individual_enterprise'); ?>
                    </label>
                <?php }elseif($_REQUEST['index']==5||$_REQUEST['index']==4){ ?>
                    <label style="margin-right:10px;">
                        <span><?=$_REQUEST['index']==4?"认证时间":"申请日期"?>：</span>
                        <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                        <span>-</span>
                        <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                    </label>
                    <?php if($_REQUEST['index']==4){ ?>
                        <label style="margin-right:20px;">
                            <span>入驻类型：</span>
                            <?php echo downList($individual_enterprise,'f_id','F_NAME','individual_enterprise'); ?>
                        </label>
                    <?php } ?>
                <?php } ?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入管理账号/服务平台名称">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
<?php // var_dump($_REQUEST);?>
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['index']==1){ ?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th>申请单位/申请人</th>
                            <th><?php echo $model->getAttributeLabel('individual_enterprise');?></th>
                            <th><?php echo $model->getAttributeLabel('club_name');?></th>
                            <th><?php echo $model->getAttributeLabel('enter_project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th>审核状态</th>
                            <th><?php echo $model->getAttributeLabel('edit_pass_time');?></th>
                            <th>审核员</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th>申请单位/申请人</th>
                            <th><?php echo $model->getAttributeLabel('individual_enterprise');?></th>
                            <th><?php echo $model->getAttributeLabel('club_name');?></th>
                            <th><?php echo $model->getAttributeLabel('enter_project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th>状态</th>
                            <th><?php echo $model->getAttributeLabel('edit_apply_time');?></th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th>申请单位/申请人</th>
                            <th><?php echo $model->getAttributeLabel('individual_enterprise');?></th>
                            <th><?php echo $model->getAttributeLabel('club_name');?></th>
                            <th><?php echo $model->getAttributeLabel('enter_project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th>状态</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th><?php echo $model->getAttributeLabel('club_name');?></th>
                            <th><?php echo $model->getAttributeLabel('individual_enterprise');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th>联系人</th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th>状态</th>
                            <th>项目数量</th>
                            <th>认证时间</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==5){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th>申请单位/申请人</th>
                            <th><?php echo $model->getAttributeLabel('individual_enterprise');?></th>
                            <th><?php echo $model->getAttributeLabel('club_name');?></th>
                            <th><?php echo $model->getAttributeLabel('enter_project_id');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th>状态</th>
                            <th><?php echo $model->getAttributeLabel('edit_apply_time');?></th>
                            <th>操作</th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(123);?>
                    <?php 
                        $index = 1;foreach($arclist as $v){ 
                        if(!empty(explode(",",$v->club_area_code)[0]))$tRegion=TRegion::model()->find('id='.explode(",",$v->club_area_code)[0]);
                        if(!empty(explode(",",$v->club_area_code)[1]))$tRegion2=TRegion::model()->find('id='.explode(",",$v->club_area_code)[1]);
                        $region="";
                        if(!empty($tRegion))$region.=$tRegion->region_name_c;
                        if(!empty($tRegion2))$region.=$tRegion2->region_name_c;
                    ?>
                    <tr> 	    
                        <?php if($_REQUEST['index']==1){ ?>   
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code;?></td>
                            <td><?php echo $v->individual_enterprise==403?$v->apply_name:$v->company;?></td>
                            <td><?php echo $v->individual_enterprise_name;?></td>
                            <td><?php echo $v->club_name;?></td>
                            <td><?php if(!empty($v->enter_project->project_name))echo $v->enter_project->project_name;?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->contact_phone;?></td>
                            <td><?php echo $v->edit_state_name;?></td>
                            <td><?php echo $v->edit_pass_time;?></td>
                            <td><?php echo (!is_null($v->editAdmin)?$v->editAdmin->admin_gfaccount:'').'/'.$v->edit_adminname; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update_data', array('id'=>$v->id))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code;?></td>
                            <td><?php echo $v->individual_enterprise==403?$v->apply_name:$v->company;?></td>
                            <td><?php echo $v->individual_enterprise_name;?></td>
                            <td><?php echo $v->club_name;?></td>
                            <td><?php if(!empty($v->enter_project->project_name))echo $v->enter_project->project_name;?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->contact_phone;?></td>
                            <td><?php echo $v->edit_state_name;?></td>
                            <td><?php echo $v->edit_apply_time;?></td>
                            <td>
                                <?php echo show_command('审核',$this->createUrl('update_data', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code;?></td>
                            <td><?php echo $v->individual_enterprise==403?$v->apply_name:$v->company;?></td>
                            <td><?php echo $v->individual_enterprise_name;?></td>
                            <td><?php echo $v->club_name;?></td>
                            <td><?php if(!empty($v->enter_project->project_name))echo $v->enter_project->project_name;?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->contact_phone;?></td>
                            <td><?php echo $v->edit_state_name;?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update_data', array('id'=>$v->id,'index'=>$_REQUEST['index']))); ?>
                                <a class="btn" onclick="logout(<?=$v->id?>)">注销</a>
                            </td>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code;?></td>
                            <td><?php echo $v->club_name;?></td>
                            <td><?php echo $v->individual_enterprise_name;?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->apply_name;?></td>
                            <td><?php echo $v->contact_phone;?></td>
                            <td><?php echo $v->unit_state==648?'正常':'已注销';?></td>
                            <td>
                                <?php 
                                    $p_count=ClubProject::model()->count('club_id='.$v->id.' and auth_state=461 and free_state_Id=1202');
                                    echo $p_count;  
                                ?>
                            </td>
                            <td><?php echo $v->edit_pass_time;?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update_data', array('id'=>$v->id))); ?>
                                <a class="btn" href="<?php echo $this->createUrl('clubProject/index_unit',array('club_id' => $v->id,'index'=>2));?>" title="单位项目">项目</a>
                            </td>
                        <?php }elseif($_REQUEST['index']==5){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code;?></td>
                            <td><?php echo $v->individual_enterprise==403?$v->apply_name:$v->company;?></td>
                            <td><?php echo $v->individual_enterprise_name;?></td>
                            <td><?php echo $v->club_name;?></td>
                            <td><?php if(!empty($v->enter_project->project_name))echo $v->enter_project->project_name;?></td>
                            <td><?php echo $v->contact_phone;?></td>
                            <td><?php echo $v->edit_state_name;?></td>
                            <td><?php echo $v->edit_apply_time;?></td>
                            <td>
                                <?php 
                                    if(!empty($v->edit_state)&&$v->edit_state==1538){
                                        echo show_command('修改',$this->createUrl('update_data', array('id'=>$v->id,'s'=>1)));
                                    }else{
                                        echo show_command('详情',$this->createUrl('update_data', array('id'=>$v->id,'index'=>$_REQUEST['index']))); 
                                    }
                                ?>
                                <?php 
                                    if($v->edit_state!=371){
                                        echo '<a class="btn" href="javascript:;" onclick="we.cancel('. $v->id. ', cancelUrl);" title="取消">取消</a>';
                                    }else{
                                        echo '<a class="btn" href="javascript:;" onclick="we.cancel('. $v->id. ', cancelUrl2);" title="撤销">撤销</a>';
                                    }
                                ?>
                            </td>
                        <?php } ?>
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
var cancelUrl2 = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'edit_state','del'=>721,'yes'=>'撤销成功','no'=>'撤销失败'));?>';
</script>
<script>
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});

    function on_exam(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#index').val(2);
            $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        }
    }

    function logout(id){
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('clubList/updata_club');?>',
            data: {deal_id: id,user_state: 649,lock_reason: "系统注销"},
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if(data.status==1){
                    we.loading('hide');
                    we.success(data.msg, data.redirect);
                }else{
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    }
</script>