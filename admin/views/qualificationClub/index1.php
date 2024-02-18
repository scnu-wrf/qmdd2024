
<div class="box" div style="font-size: 9px">
    <div class="box-title c">
        <h1>项目服务者</h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <?php if ($_REQUEST['club_id']==get_session('club_id')) { ?>
            <div class="box-header"><!--资质人信息--->
                <a class="btn" href="javascript:;" onclick="fnInvite();">
                <i class="fa fa-plus"></i>邀请服务者</a>
            </div><!--box-header end-->
        <?php } ?> 
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input class="input-text" type="hidden" name="club_id" value="<?php echo $_GET["club_id"];?>">
                <input class="input-text" type="hidden" name="project_id" value="<?php echo $_GET["project_id"];?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <input  type="hidden" name="club_id" value="<?php echo $_REQUEST['club_id']; ?>">
                <button class="btn btn-blue" type="submit">查询</button>
         
               </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th>服务者编码</th>
                        <th><?php echo $model->getAttributeLabel('account');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('level_title');?></th>
                        <th><?php echo $model->getAttributeLabel('binding_way');?></th>
                        <th><?php echo $model->getAttributeLabel('logon_way');?></th>
                        <th>服务者状态</th>
                        <th><?php echo $model->getAttributeLabel('state_name');?></th>
                        <th><?php echo $model->getAttributeLabel('ccie_date');?></th>
                        <th>加入单位时间</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $index = 1; foreach($arclist as $v){ ?>
                        <tr>
                            <td><span class="num num-1"><?php echo $index; ?></span></td>
                            <td><?php if(isset($v->qualifications_person)) echo $v->qualifications_person->qualification_gf_code; ?></td>
                            <td><?php if(isset($v->qualifications_person)) echo $v->qualifications_person->qualification_gfaccount; ?></td>
                            <td><?php if(isset($v->qualifications_person)) echo $v->qualifications_person->qualification_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->type_name; ?></td>
                            <td><?php if(isset($v->qualifications_person)) echo $v->qualifications_person->qualification_identity_type_name.$v->qualifications_person->qualification_title; ?></td>
                            <td>
                                <?php 
                                    if($v->logon_way==1460||$v->logon_way==1461){
                                        echo $v->logon_way_name;
                                    }else{
                                        if(isset($v->qualification_invite)){
                                            if($v->qualification_invite->invite_initiator==502){
                                                echo '单位邀请';
                                            }elseif($v->qualification_invite->invite_initiator==501){
                                                echo '服务者申请';
                                            }
                                        }
                                    }
                                ?>
                            </td>
                            <td><?php echo $v->logon_way_name; ?></td>
                            <td><?php if(isset($v->qualifications_person)) echo $v->qualifications_person->acc_status->F_NAME; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php if(!empty($v->qualifications_person->expiry_date_end))echo date('Y年m月d日',strtotime($v->qualifications_person->expiry_date_end)); ?></td>
                            <td><?php echo $v->add_date; ?></td>
                        <td>     
            <?php //$v->club_id==Yii::app()->session['club_id'] && 
			 if($v->state==498 && $v->club_id==get_session('club_id')){?>
                                <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销邀请"><i class="fa fa-reply"></i></a>
                            <?php }?>
                            <?php if($v->state==337 && $v->club_id==get_session('club_id')){?>
                            <a class="btn" href="javascript:;" onclick="fnDeleteInvite(<?php echo $v->id;?>);" title="解除绑定"><i class="fa fa-scissors"></i></a>
							<?php }?>
                            <?php if($v->state==497 && $v->club_id==get_session('club_id')){?>
                                <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', canceldel);" title="撤销解除"><i class="fa fa-reply"></i></a>
                            <?php }?>
                            <?php if($v->state==496 && $v->club_id==get_session('club_id')){?>
                                <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $v->id;?>, 'yes');" title="同意申请"><i class="fa fa-check"></i></a>
                                <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $v->id;?>, 'no');" title="拒绝申请"><i class="fa fa-minus-circle"></i></a>
                            <?php }?>
                            <?php if($v->state==339 && $v->club_id==get_session('club_id')){?>
                                <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $v->id;?>, 'yes');" title="同意解除"><i class="fa fa-check"></i></a>
                                <!--a class="btn" href="javascript:;" onclick="fnIsdelInvite(<php echo $v->id;?>, 'no');" title="拒绝解除"><i class="fa fa-minus-circle"></i></a-->
                            <?php }?>
                            <?php if(($v->state==499||$v->state==338||$v->state==787) && $v->club_id==get_session('club_id')){?>
                             <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                            <?php } ?>
                            <a class="btn" href="<?php echo $this->createUrl('clubQualificationPerson/update', array('id'=>$v->qualification_person_id));?>" title="服务者信息"><i class="fa fa-edit"></i></a>
                            
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
var cancel = '<?php echo $this->createUrl('cancelInvite', array('id'=>'ID'));?>';
var canceldel = '<?php echo $this->createUrl('cancelDeleteInvite', array('id'=>'ID'));?>';
</script>

<script>
// 邀请服务者$_GET["club_id"]
var InviteHtml='<div style="width:500px;">'+
'<table class="box-detail-table showinfo">'+
    '<tr>'+
        '<td width="15%">类别<input id="dialog_club_id" type="hidden" value="<?php echo get_session('club_id');?>"><input id="dialog_project_id" type="hidden" value="<?php echo $_GET["project_id"];?>"></td>'+
        '<td><select onchange="fnResetGfid();" id="dialog_type"><?php if(is_array($type)) foreach($type as $v){?><option value="<?php echo $v->member_second_id;?>"><?php echo $v->member_second_name;?></option><?php }?></select></td>'+
    '</tr>'+
    '<tr>'+
        '<td>目标帐号</td>'+
        '<td><input id="dialog_gfid" type="hidden" value=""><span id="account_box"></span><input onclick="fnSelectGfid();" class="btn" type="button" value="选择服务者"></td>'+
    '</tr>'+
    '<tr>'+
        '<td>邀请附言</td>'+
        '<td><textarea id="dialog_msg" class="input-text"></textarea></td>'+
    '</tr>'+
'</table>'+
'</div>';

// 邀请服务者
var fnInvite=function(){
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
    var project_id=$('#dialog_project_id').val();
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
        url: '<?php echo $this->createUrl('sendInvite');?>',
        data: {club_id: club_id,project_id: project_id,type_id: type_id, gfid:gfid, msg:msg},
        dataType: 'json',
        success: function(data) {
            if(data.status==1){
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
	if(type_id<=0){
        we.msg('minus', '请先选择类别');
        return false;
    }
	// 选择服务者
    var $account_box=$('#account_box');
        $.dialog.data('gfid', 0);
        $.dialog.open('<?php echo $this->createUrl("select/qualification",array("project_id"=>$_GET["project_id"]));?>&type_id='+type_id,{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
			if($.dialog.data('gfid')>0 && $('#account_item_'+$.dialog.data('gfid')).length==0){
                $account_box.append('<span id="account_item_'+$.dialog.data('gfid')+'" class="label-box" data-id="'+$.dialog.data('gfid')+'">'+$.dialog.data('qualification_gfaccount')+'<i onclick="fnDeleteGfid(this);"></i></span>');
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
                        url: '<?php echo $this->createUrl('deleteInvite');?>&id='+invite_id,
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

// 通过邀请操作
var fnPassInvite=function(invite_id, type){
    if(type==undefined){ type='yes'; }
    var dialogText='同意申请';
    if(type!='yes'){
        type='no';
        dialogText='拒绝申请';
    }
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">审核留言</td>'+
            '<td><textarea id="dialog_invite2_496_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'tongguoshenqing',
        lock:true,
        opacity:0.3,
        title:dialogText,
        content:html,
        button:[
            {
                name:dialogText,
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('passInvite');?>&id='+invite_id,
                        data: {invite_id:invite_id, msg:$('#dialog_invite2_496_msg').val(), type:type},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['tongguoshenqing'].close();
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

// 是否同意退出操作
var fnIsdelInvite=function(invite_id, type){
    if(type==undefined){ type='yes'; }
    var dialogText='同意解除';
    if(type!='yes'){
        type='no';
        dialogText='拒绝解除';
    }
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">审核留言</td>'+
            '<td><textarea id="dialog_invite_isdel_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'tongyijiechu',
        lock:true,
        opacity:0.3,
        title:dialogText,
        content:html,
        button:[
            {
                name:dialogText,
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('isdelInvite');?>&id='+invite_id,
                        data: {invite_id:invite_id, msg:$('#dialog_invite_isdel_msg').val(), type:type},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['tongyijiechu'].close();
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