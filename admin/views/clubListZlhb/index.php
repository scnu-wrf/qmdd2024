<div class="box">
    <span style="float:right;padding-right:15px;">
        <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
    </span>
    <div class="box-title c">
    <h1><?php if($_REQUEST['index']==1){echo '当前界面：战略伙伴》意向入驻管理》意向入驻审核';}elseif($_REQUEST['index']==2){echo '当前界面：战略伙伴》意向入驻管理》意向入驻审核》待审核';}elseif($_REQUEST['index']==3){echo '当前界面：战略伙伴》意向入驻管理》审核未通过列表';}elseif($_REQUEST['index']==4){echo '当前界面：战略伙伴》意向入驻管理》意向入驻列表';}elseif($_REQUEST['index']==5){echo '当前界面：战略伙伴》意向入驻管理》意向入驻待审核';};?></h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header" style="<?=$_REQUEST['index']!=1?'display:none':''?>">
            <!-- <?php //echo show_command('添加',$this->createUrl('create'),'添加'); ?> -->
            <?php if($_REQUEST['index']==1){?>
            <span class="exam" onclick="on_exam();"><p>待审核：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p></span>
            <!-- <?php //}elseif($_REQUEST['index']==5){?>
                <span class="exam" onclick="on_exam2();"><p>今日申请：<span style="color:red;font-weight: bold;"><?php //echo $count2; ?></span></p></span> -->
            <?php } ?>
            <!-- <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a> -->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input id="index" type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <input id="today" type="hidden" name="today" value="<?php echo Yii::app()->request->getParam('today');?>">
                
                <?php if($_REQUEST['index']==1||$_REQUEST['index']==5||$_REQUEST['index']==2||$_REQUEST['index']==4){?>
                    <label style="margin-right:10px;">
                        <?php
                            if($_REQUEST['index']==5){
                                echo '<span>查询日期</span>';
                            }elseif($_REQUEST['index']==2){
                                echo '<span>申请日期</span>';
                            }elseif($_REQUEST['index']==4){
                                echo '<span>入驻时间</span>';
                            }else{
                                echo '<span>审核日期：</span>';
                            }
                        ?>
                        <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                        <span>-</span>
                        <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                    </label>
                <?php }?>
                <?php if($_REQUEST['index']==4){?>
                    <label style="margin-right:20px;">
                        <span>单位性质：</span>
                        <?php echo downList($company_type,'f_id','F_NAME','company_type'); ?>
                    </label>
                    <label style="margin-right:20px;">
                        <span>单位所在地：</span>
                        <select name="province"></select><select name="city"></select><select name="area"></select>
                        <script>new PCAS("province","city","area","<?php echo Yii::app()->request->getParam('province');?>","<?php echo Yii::app()->request->getParam('city');?>","<?php echo Yii::app()->request->getParam('area');?>");</script>
                    </label>
                <?php }?>
                <?php if($_REQUEST['index']==5){ ?>
                <label style="margin-right:20px;">
                    <span>状态：</span>
                    <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <?php } ?>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入单位账号/名称">
                </label>
                
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <?php if($_REQUEST['index']==1){?>
                    	    <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th>申请<?php echo $model->getAttributeLabel('company');?></th>
                            <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th><?php echo $model->getAttributeLabel('state');?></th>
                            <th><?php echo $model->getAttributeLabel('pass_time');?></th>
                            <th>审核员</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==2){?>
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
                        <?php }elseif($_REQUEST['index']==3){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th>申请<?php echo $model->getAttributeLabel('company');?></th>
                            <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th><?php echo $model->getAttributeLabel('state');?></th>
                            <th><?php echo $model->getAttributeLabel('pass_time');?></th>
                            <th>审核员</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <th>序号</th>
                            <th><?php echo $model->getAttributeLabel('club_code');?></th>
                            <th><?php echo $model->getAttributeLabel('company');?></th>
                            <th><?php echo $model->getAttributeLabel('company_type_id');?></th>
                            <th><?php echo $model->getAttributeLabel('club_address');?></th>
                            <th><?php echo $model->getAttributeLabel('apply_name');?></th>
                            <th><?php echo $model->getAttributeLabel('contact_phone');?></th>
                            <th>认证状态</th>
                            <th>入驻时间</th>
                            <th>操作</th>
                        <?php }elseif($_REQUEST['index']==5){?>
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
                    <?php 
                        $index = 1;foreach($arclist as $v){ 
                        if(!empty(explode(",",$v->club_area_code)[0]))$tRegion=TRegion::model()->find('id='.explode(",",$v->club_area_code)[0]);
                        if(!empty(explode(",",$v->club_area_code)[1]))$tRegion2=TRegion::model()->find('id='.explode(",",$v->club_area_code)[1]);
                        $region="";
                        if(!empty($tRegion))$region.=$tRegion->region_name_c;
                        if(!empty($tRegion2))$region.=$tRegion2->region_name_c;
                    ?>
                    <tr> 	      
                        <?php if($_REQUEST['index']==1){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company;?></td>
                            <td><?php echo $v->company_type;  ?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php  echo $v->state_name;?></td>
                            <td><?php  echo substr($v->pass_time,0,10);?></td>
                            <td><?php echo (!is_null($v->reasonsAdmin)?$v->reasonsAdmin->admin_gfaccount:'').'/'.$v->reasons_adminname; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,"index"=>$_REQUEST['index']))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==2){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company;?></td>
                            <td><?php echo $v->company_type;  ?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->apply_name;  ?></td>
                            <td><?php echo $v->contact_phone;  ?></td>
                            <td><?php  echo $v->state_name;?></td>
                            <td><?php  echo substr($v->apply_time,0,10);?></td>
                            <td>
                                <?php echo show_command('审核',$this->createUrl('update', array('id'=>$v->id,"index"=>$_REQUEST['index']))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==3){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company;?></td>
                            <td><?php echo $v->company_type;  ?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->apply_name; ?></td>
                            <td><?php  echo $v->contact_phone; ?></td>
                            <td><?php  echo $v->state_name;?></td>
                            <td><?php  echo substr($v->pass_time,0,10);?></td>
                            <td><?php echo (!is_null($v->reasonsAdmin)?$v->reasonsAdmin->admin_gfaccount:'').'/'.$v->reasons_adminname; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id))); ?>
                                <a class="btn" onclick="logout(<?=$v->id?>)">注销</a>
                            </td>
                        <?php }elseif($_REQUEST['index']==4){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company;?></td>
                            <td><?php echo $v->company_type;  ?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->apply_name; ?></td>
                            <td><?php echo $v->contact_phone; ?></td>
                            <td><?php echo empty($v->edit_state)?'待认证':$v->edit_state_name;?></td>
                            <td><?php echo $v->pass_time;?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id))); ?>
                            </td>
                        <?php }elseif($_REQUEST['index']==5){?>
                            <td><span class="num num-1"><?php echo $index; ?></td>
                            <td><?php echo $v->club_code; ?></td>
                            <td><?php echo $v->company;?></td>
                            <td><?php echo $v->company_type;  ?></td>
                            <td><?php echo $v->club_area_code!=""?$region:'';?></td>
                            <td><?php echo $v->apply_name; ?></td>
                            <td><?php echo $v->contact_phone; ?></td>
                            <td><?php echo $v->state_name;?></td>
                            <td><?php echo $v->apply_time;?></td>
                            <td>
                                <?php 
                                    if($v->state==1538){
                                        echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'s'=>1,"index"=>$_REQUEST['index']))); 
                                    }else{
                                        echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,"index"=>$_REQUEST['index'])));
                                    }
                                ?>
                                <?php echo $v->state!=371?show_command('删除','\''.$v->id.'\''):'
                                <a class="btn" href="javascript:;" onclick="we.cancel('. $v->id. ', cancelUrl);" title="撤销">撤销</a>'; ?>
                            </td>
                        <?php }?>
                    </tr>
					<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>721,'yes'=>'撤销成功','no'=>'撤销失败'));?>';
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
        var exam = $('.exam p span').text();
        if(exam>0){ 
            $('#index').val(2);
            // $('.box-search select').html('<option value>请选择</option>');
            $('.box-search .input-text').val('');
            document.getElementById('click_submit').click();
        }
    }
    function on_exam2(){
        var exam = $('.exam p span').text();
        if(exam>0){ 
            var now = new Date();
            var time = now.getFullYear() + "-" +((now.getMonth()+1)<10?"0":"")+(now.getMonth()+1)+"-"+(now.getDate()<10?"0":"")+now.getDate();
            $('#today').val(time);
            // $('.box-search select').html('<option value>请选择</option>');
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