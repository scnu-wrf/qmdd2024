
<style>
    table{
        table-layout:auto!important;
    }
    table tr td:nth-child(2n+1){
        width:150px;
    }
    .progress li{
        width: calc(100% / 3);
    }
</style>
<?php 
    if(!empty($_REQUEST['club_id'])){
        $club_id=$_REQUEST['club_id'];
    }else{
        $club_id=get_session('club_id');
    }
    $club= ClubList::model()->find('id='.$club_id);
    
    if($model->state==721){
        $left='calc((100% / 3) / 2)';
        $right='calc(50% + 100% / 3)';
        $float='calc(((100% / 3) / 2) - 2.5% - 5px)';
    }elseif($model->state==371){
        $left='50%';
        $right='50%';
        $float='calc(50% - 2.5% - 5px)';
    }elseif($model->state==2){
        $left='100%';
        $right='0';
        $float='calc(100% - (100% / 3) / 2 - 2.5% - 5px)';
    }else{
        $left='50%';
        $right='50%';
        $float='calc(50% - 2.5% - 5px)';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1><?php if(empty($model->id)){echo '添加项目';}else{echo '当前界面：项目 》单位注册项目 》详情';}?></h1><span class="back">
        <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    
     <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun"||submitType=="yaoqing'));?>
    <div class="box-detail">
        <div class="progress">
            <div class="progress_bar">
                <div class="progress_left" style="width:<?php echo $left;?>;"></div>
                <div class="progress_right" style="width:<?php echo $right;?>;"></div>
                <div class="progress_float" style="left:<?php echo $float;?>"></div>
            </div>
            <ul>
                <li>添加项目</li>
                <li>项目审核</li>
                <li>添加项目完成</li>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                	<tr class="table-title">
                    	<td colspan="4" >项目信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td>
							<span id="club_box">
                                <?php if($model->club_id!=null){?>
                                    <span class="label-box">
                                        <?php echo $model->club_name;?>
                                        <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?>
                                    </span>
                                <?php } else {?>
                                    <span class="label-box">
                                        <?php echo $club->club_name;?>
                                        <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>$club_id)); ?>
                                    </span>
                                <?php } ?>
                            </span>
                            <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'p_code'); ?></td>
                        <td>
                            <?php if($model->p_code!=null){?>
                                <?php echo $model->p_code;?>
                            <?php } else {?>
                                <?php echo $club->club_code;?>
                            <?php } ?>
                        </td> 
                    </tr>
                    <tr>
                    	<td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td>
                            <?php 
                                $projectid=$model->getClubProject();
                                $clubproject=ProjectList::model()->getClubProject();

                                if(empty($model->project_id)){
                                    $p_count=0;
                                }else{
                                    $p_count=QualificationClub::model()->count('club_id='.$model->club_id.' and project_id='.$model->project_id.' and state<>338 and state<>787 and state<>499');
                                }
                            ?>
                            <script>
                            var $projectid = <?php echo json_encode($projectid) ?>;
                            var $clubproject = <?php echo json_encode($clubproject) ?>;
                            </script>
                            <select id="ClubProject_project_id" name="ClubProject[project_id]" <?php if(!empty($model->id)&&$model->state!=721||$p_count>0){echo 'disabled=disabled';}?> >
                              <?php if(!empty($model->project_id)) { ?>                            
                              <option class="clubp" value="<?php echo $model->project_id; ?>"><?php echo $model->project_list->project_name;?> </option>
							  <?php }?>
                              
                            </select>
                            <?php //if(!empty($model->project_list)) echo $model->project_list->project_name; ?>
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'partnership_type'); ?></td>
                        <td>
                            <?php echo empty($model->id)?$club->partnership_name:$model->partnership_name;?>
                        </td> 
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'approve_state'); ?></td>
                        <td>
                            <?php 
                                if(empty($model->id)){
                                    if(get_session('club_type')==8){
                                        $vl=BaseCode::model()->getApproveState();
                                    }else{
                                        $vl=BaseCode::model()->getReturn('453');
                                    }
                                }else{
                                    if($model->club_type==8){
                                        $vl=BaseCode::model()->getApproveState();
                                    }else{
                                        $vl=BaseCode::model()->getReturn('453');
                                    }
                                }
                            ?>
                            <?php if(!empty($model->id)&&$model->state!=721){echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>'disabled'));}else{echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array('prompt'=>'请选择'));} ?>
                            <?php echo $form->error($model, 'approve_state', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'add_time'); ?></td>
                        <td><?php echo $model->add_time;?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            
            <?php if(get_session('club_type')==8||(!empty($model->club_type)&&$model->club_type==8&&!empty($model->id))){?>
            <div class="box-table" style="padding:0;border-radius:0;">
                <table class="mt15 list" style="border-radius: 0;">
                    <tr class="table-title" style="font-weight: bold;">
                        <td colspan="9">项目服务者信息（要求三名服务者，裁判员1名、教练员1名、单位管理员1名）</td>
                            <?php if($model->state==721||empty($model->state)){?> 
                                <td>
                                    <a class="btn" href="javascript:;" onclick="fnInvite();"><i class="fa fa-plus"></i>添加</a>
                                </td>
                            <?php }?> 
                        </tr>
                        <tr class="table-title">
                            <td style="padding:5px">服务者类型</td>
                            <td style="padding:5px">服务者编号</td>
                            <td style="padding:5px">GF账号</td>
                            <td style="padding:5px">姓名</td>
                            <td style="padding:5px">项目</td>
                            <td style="padding:5px">资质等级</td>
                            <td style="padding:5px">服务者等级</td>
                            <td style="padding:5px">状态</td>
                            <td style="padding:5px">操作时间</td>
                            <?php if($model->state==721||empty($model->state)){?> 
                                <td style="padding:5px">操作</td>
                            <?php }?> 
                        </tr>
                        
                        <?php if(!empty($model2)){$index = 1;foreach($model2 as $info){
                            $code=QualificationsPerson::model()->find("id=".$info->qualification_person_id.' and project_id='.$model->project_id);  
                        ?>
                        <tr>
                            <td style=" padding:5px"><?php echo $info->type_name;?></td>
                            <td style=" padding:5px"><?php if(!empty($code))echo $code->gf_code;?></td>
                            <td style=" padding:5px"><?php if(!empty($code))echo $code->gfaccount;?></td>
                            <td style=" padding:5px"><?php if(!empty($code))echo $code->qualification_name;?></td>
                            <td style=" padding:5px"><?php echo $info->project_name;?></td>
                            <td style=" padding:5px"><?php if(!empty($code))echo $code->qualification_title;?></td>
                            <td style=" padding:5px"><?php if(!empty($code))echo $code->level_name;?></td>
                            <td style=" padding:5px"><?php echo $info->state_name;?></td>
                            <td style=" padding:5px"><?php echo $info->udate;?></td>
                            <?php if($model->state==721||empty($model->state)){?> 
                                <td style="padding:5px">    
                                    <?php if($info->state==498){?>
                                        <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $info->id;?>', cancel);" title="撤销邀请"><i class="fa fa-reply"></i></a>
                                    <?php }?>
                                    <?php if($info->state==337){?>
                                        <a class="btn" href="javascript:;" onclick="fnDeleteInvite(<?php echo $info->id;?>);" title="解除绑定"><i class="fa fa-scissors"></i></a>
                                    <?php }?>
                                    <?php if($info->state==497){?>
                                        <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $info->id;?>', canceldel);" title="撤销解除"><i class="fa fa-reply"></i></a>
                                    <?php }?>
                                    <?php if($info->state==496){?>
                                        <!-- <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $info->id;?>, 'yes');" title="同意申请"><i class="fa fa-check"></i></a>
                                        <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $info->id;?>, 'no');" title="拒绝申请"><i class="fa fa-minus-circle"></i></a> -->
                                    <?php }?>
                                    <?php if($info->state==339){?>
                                        <!-- <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $info->id;?>, 'yes');" title="同意解除"><i class="fa fa-check"></i></a> -->
                                    <?php }?>
                                    <?php if($info->state==499||$info->state==338||$info->state==787){?>
                                    <!-- <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $info->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a> -->
                                    <?php } ?>
                                    <a class="btn" href="<?php echo $this->createUrl('clubQualificationPerson/update', array('id'=>$info->qualification_person_id));?>" title="服务者信息"><i class="fa fa-edit"></i></a>
                                </td>
                            <?php } ?>
                        </tr>
                    <?php $index++;}} ?>
                </table>
            </div>
            <?php }?>
        </div><!--box-detail-bd end-->
        <div class="box-detail-bd">
            <table>
                <tr class="table-title">
                    <td colspan="4">操作信息</td>
                </tr>
                <?php if($model->state!=721){?>
                <tr>
                    <td width='10%'><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td colspan="3"><?php echo $model->refuse_state_name; ?></td>
                </tr>
                <?php }?>
                <?php if($model->state!=721&&($model->state!=371||!empty($_REQUEST['index'])&&$_REQUEST['index']==4)){?>
                    <tr>
                        <td width='15%'>操作备注</td>
                        <td width='85%' colspan="3">
                            <?php 
                            if($model->state==371&&!empty($_REQUEST['index'])&&$_REQUEST['index']==4){
                                echo $form->textArea($model, 'refuse', array('class' => 'input-text')); 
                            }else{
                                echo $form->textArea($model, 'refuse', array('class' => 'input-text','readonly'=>'readonly')); 
                            }
                            ?>
                            <?php echo $form->error($model, 'refuse', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                <?php }?>
                <?php if($model->state==721||$model->state==371){?>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                    <!-- <?php //echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                    <button class="btn" type="button" onclick="we.back();">取消</button> -->
                    <?php if($_REQUEST['r']=='clubProject/update_unit'){?>
                        <?php if($model->state==371){
                            if($_REQUEST['index']==4){
                                echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')).'
                                <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif($_REQUEST['index']==7){
                                if(get_session('club_id')==$model->club_id&&$model->state==371){
                                    echo '<button id="quxiao" onclick="submitType='."'quxiao'".'" class="btn btn-blue" type="submit"> 撤销</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                }elseif($model->state==373){

                                }else{
                                    echo $model->refuse_state_name;
                                }
                            }else{
                                echo $model->refuse_state_name;
                            }
                        }elseif($model->state==721){
                            echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交')).'
                            <button class="btn" type="button" onclick="we.back();">取消</button>';
                        }else{
                            echo $model->refuse_state_name;
                        };?>
                    <?php }else{?>
                        <?php echo '<button id="baocun" onclick="submitType='."'baocun'".'" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit"> 提交审核</button>';?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    <?php }?>
                    <button id="yaoqing" onclick="submitType='yaoqing'" class="btn btn-blue" type="submit" style="display:none">邀请</button>
                    </td>
                </tr>
                <?php }?>
            </table>
        </div> 
<?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>
var cancel = '<?php echo $this->createUrl('qualificationClub/cancelInvite', array('id'=>'ID'));?>';
var canceldel = '<?php echo $this->createUrl('qualificationClub/cancelDeleteInvite', array('id'=>'ID'));?>';

//判断数组中是否有该元素,如：Array.in_array(element);
Array.prototype.in_array = function (element) {  
　　for (var i = 0; i < this.length; i++) {  
　　if (this[i] == element) {  
　　return true;  
        }  
    } return false;  
}     

// 滚动图片处理
var $upload_pic_qualification_pics=$('#upload_pic_qualification_pics');
var $upload_box_Cqualification_pics=$('#upload_box_qualification_pics');

// 添加或删除时，更新图片
var fnUpdatescrollPic=function(){
    var arr=[];var s1="";
    $upload_pic_qualification_pics.find('a').each(function(){
         s1=$(this).attr('data-savepath');
        //console.log(s1);
        if(s1!=""){
        arr.push($(this).attr('data-savepath'));}
    });
    $('#ClubProject_qualification_pics').val(we.implode(',',arr));
    $upload_box_qualification_pics.show();
    if(arr.length>=5) {  $upload_box_qualification_pics.hide();}
};
// 上传完成时图片处理
var fnscrollPic=function(savename,allpath){
    $upload_pic_qualification_pics.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
    fnUpdatescrollPic();
};
$(function() {
	// 选择推荐单位
    var $club_box=$('#club_box');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club");?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('club_id'));
                if($.dialog.data('club_id')>0){
                    club_id=$.dialog.data('club_id');
                    $('#ClubProject_club_id').val($.dialog.data('club_id'));
					fnUpdateProjectNot();
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
	var project_id = $('#ClubProject_project_id').val();
	//console.log(project_id);
});

//单位触发项目下拉
$(function(){
	fnUpdateProjectNot();
});
var fnUpdateProjectNot=function(){
    $('#ClubProject_project_id option').not('.clubp').remove();
	var club_id = $('#ClubProject_club_id').val();
	var arr = [];
	var phtml = '<option value="">请选择</option>';
	for(var j=0;j<$projectid.length;j++) {
		if($projectid[j]['club_id']==club_id) {
			project_id=$projectid[j]['project_id'];
			arr.push(project_id);			
		}
	}
	//console.log(parr);
	for(var i=0;i<$clubproject.length;i++) {
		if(arr.in_array($clubproject[i]['id'])) {
			phtml = phtml+'';
		} else {
			phtml = phtml+'<option value="'+$clubproject[i]['id']+'">'+$clubproject[i]['project_name']+'</option>';
		}
	}
	//console.log(phtml);
	$('#ClubProject_project_id').append(phtml);
}

    // 选择单位
    // var $club_box=$('#club_box');
    // $club_box.on('click', function(){
    //     $.dialog.data('club_id', 0);
    //     $.dialog.open('<?php echo $this->createUrl("select/club");?>',{
    //         id:'danwei',
    //         lock:true,
    //         opacity:0.3,
    //         title:'选择具体内容',
    //         width:'500px',
    //         height:'60%',
    //         close: function () {
    //             //console.log($.dialog.data('club_id'));
    //             if($.dialog.data('club_id')>0){
    //                 club_id=$.dialog.data('club_id');
    //                 $('#Advertisement_club_id').val($.dialog.data('club_id'));
    //                 $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
    //             }
    //         }
    //     });
    // });

    
// 邀请服务者
var fnInvite=function(){
    var InviteHtml='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="17%">项目</td>'+
            '<td id="dialog_project_id" value="'+$("#ClubProject_project_id").val()+'">'+$("#ClubProject_project_id").find("option:selected").text()+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td width="17%">服务者类型<input id="dialog_club_id" type="hidden" value="<?php echo get_session('club_id');?>"></td>'+
            '<td><select onchange="fnResetGfid();" id="dialog_type"><?php if(is_array($type)) foreach($type as $v){?><option value="<?php echo $v->member_second_id;?>"><?php echo $v->member_second_name;?></option><?php }?></select></td>'+
        '</tr>'+
        '<tr>'+
            '<td>目标帐号</td>'+
            '<td><input id="dialog_gfid" type="hidden" value=""><span id="account_box"></span><input onclick="fnSelectGfid();" class="btn" type="button" value="选择服务者"></td>'+
        '</tr>'+
        '<tr>'+
            '<td>邀请内容</td>'+
            '<td><textarea id="dialog_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    if($("#ClubProject_project_id").val()==''){
        we.msg('minus', '请选择注册项目');
        return false;
    }
    $.dialog({
        id:'yaoqing',
        lock:true,
        opacity:0.3,
        title:'邀请服务者',
        content:InviteHtml,
        button:[
            {
                name:'发送邀请',
                callback:function(){
                    return fnSendInvite();
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};

// 发送邀请
var fnSendInvite=function(){
	var club_id=$('#dialog_club_id').val();
    var project_id=$('#dialog_project_id').attr("value");
	var type_id=$('#dialog_type').val();
    var gfid=$('#dialog_gfid').val();
    var msg=$('#dialog_msg').val();
    if(gfid==''){
        we.msg('minus', '请选择服务者');
        return false;
    }
    we.loading('show');
    $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('qualificationClub/inspect');?>',
        data: {club_id: club_id,project_id: project_id,type_id: type_id, gfid:gfid, msg:msg},
        dataType: 'json',
        success: function(data) {
            if(data.status==1){
                $("#yaoqing").click();
                we.loading('hide');
                $.dialog.list['yaoqing'].close();
                we.success(data.msg, data.redirect);
            }else{
                we.loading('hide');
                we.msg('minus', data.msg);
            }
        }
    });
    return false;
};

// 更新服务者
var fnUpdateGfid=function(){
    var arr=[];
    var id;
    $('#account_box').find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $('#dialog_gfid').val(we.implode(',', arr));
};
// 选择服务者
var fnSelectGfid=function(){
	var type_id=$('#dialog_type').val();
	var project_id=$('#dialog_project_id').attr("value");
	if(type_id<=0){
        we.msg('minus', '请先选择类别');
        return false;
    }
	// 选择服务者
    var $account_box=$('#account_box');
        $.dialog.data('gfid', 0);
        $.dialog.open('<?php echo $this->createUrl("select/qualification");?>&project_id='+project_id+'&type_id='+type_id,{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
			if($.dialog.data('gfid')>0 && $('#account_item_'+$.dialog.data('gfid')).length==0){
                $account_box.append('<span id="account_item_'+$.dialog.data('gfid')+'" class="label-box" data-id="'+$.dialog.data('gfid')+'">'+$.dialog.data('gfaccount')+'<i onclick="fnDeleteGfid(this);"></i></span>');
                fnUpdateGfid();
            }
         }
       });
};
// 删除已选择服务者
var fnDeleteGfid=function(op){
    $(op).parent().remove();
    fnUpdateGfid();
};
// 重置目标帐号
var fnResetGfid=function(){
    $('#account_box').html('');
    $('#dialog_gfid').val('');
};

// 解除绑定操作
var fnDeleteInvite=function(invite_id){
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">解除原因</td>'+
            '<td><select id="dialog_type"><?php if(is_array($remove_type)) foreach($remove_type as $v){?><option value="<?php echo $v->id;?>"><?php echo $v->name;?></option><?php }?></select></td>'+
        '</tr>'+
        '<tr>'+
            '<td width="15%">详细说明</td>'+
            '<td><textarea id="dialog_invite_status_337_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'jiechu',
        lock:true,
        opacity:0.3,
        title:'解除绑定',
        content:html,
        button:[
            {
                name:'解除绑定',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('qualificationClub/deleteInvite');?>&id='+invite_id,
                        data: {invite_id:invite_id,type:$('#dialog_type').val(), msg:$('#dialog_invite_status_337_msg').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['jiechu'].close();
                                we.success(data.msg, data.redirect);
                            }else{
                                we.loading('hide');
                                we.msg('minus', data.msg);
                            }
                        }
                    });
                    return false;
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};
</script> 


