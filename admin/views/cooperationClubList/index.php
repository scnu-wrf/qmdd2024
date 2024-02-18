<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>联盟单位列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="fnAddClub();"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <span id="j-delete"></span>
            <!--<a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="fnCancelInvite(we.checkval('.check-item input:checked'));"><i class="fa fa-reply"></i>撤销邀请</a>-->
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>单位名称：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>联盟项目：</span>
                    <select name="project_id">
                        <option value="">请选择</option>
                        <?php foreach($projectlist as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project_id')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>联盟状态：</span>
                    <select name="state">
                        <option value="">请选择</option>
                        <?php foreach($base_code as $v){?>
                        <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('state')!==null && Yii::app()->request->getParam('state')!==''  && Yii::app()->request->getParam('state')==$v->f_id){?> selected<?php }?>><?php echo $v->F_NAME;?></option>
                        <?php }?>
                    </select>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id"><?php echo $model->getAttributeLabel('id');?></th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('invite_club_id');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th><?php echo $model->getAttributeLabel('cooperation_state');?></th>
                        <th><?php echo $model->getAttributeLabel('udate');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <?php $last_delete_log=null; if($v->cooperation_state==497){ $last_delete_log=$v->getLastDeleteLog(); }?>
<tr <?php if($v->cooperation_state==338 || $v->cooperation_state==499 || $v->cooperation_state==511){?> style="color:#ddd;"
    <?php }?> 
id="invite_item_<?php echo $v->id;?>" 
data-id="<?php echo $v->id;?>"
class="invite_status_<?php echo $v->cooperation_state;?>
                <?php if($v->club_id==Yii::app()->session['club_id']){?> 
                    invite_<?php echo $v->cooperation_state;?>
                <?php }elseif($v->invite_club_id==Yii::app()->session['club_id']){?> 
                    invite2_<?php echo $v->cooperation_state;?>
                <?php }?>
<?php if($v->cooperation_state==497 && $last_delete_log!=null && $last_delete_log->join_or_del==772){ 

        if($last_delete_log->club_id!=Yii::app()->session['club_id']){?> 
            invite_isdel

<?php }else{ ?> 

    invite_canceldel

<?php } } ?>">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo CHtml::encode($v->id); ?></td>
                        <td><?php if($v->club!=null) echo $v->club->club_name; ?></td>
                        <td><?php if(!empty($v->invite_club)) echo $v->invite_club->club_name; ?></td>
                        <td><?php if(!empty($v->project_list)) echo $v->project_list->project_name; ?></td>
                        <td><?php if(!empty($v->base_code)) echo $v->base_code->F_NAME; ?></td>
                        <td><?php echo $v->udate; ?></td>
                        <td>
                            <a class="btn" href="javascript:;" onclick="fnInviteLog(<?php echo $v->id;?>);" title="查看记录"><i class="fa fa-list"></i></a>
                            <?php if($v->club_id==Yii::app()->session['club_id'] && $v->cooperation_state==498){?>
                                <a class="btn" href="javascript:;" onclick="fnCancelInvite(<?php echo $v->id;?>);" title="撤销邀请"><i class="fa fa-reply"></i></a>
                            <?php }?>
                            <?php if($v->invite_club_id==Yii::app()->session['club_id'] && $v->cooperation_state==498){?>
                                <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $v->id;?>, 'yes');" title="同意邀请"><i class="fa fa-check"></i></a>
                                <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $v->id;?>, 'no');" title="拒绝邀请"><i class="fa fa-minus-circle"></i></a>
                            <?php }?>
                            <?php if($v->cooperation_state==337){?><a class="btn" href="javascript:;" onclick="fnDeleteInvite(<?php echo $v->id;?>);" title="解除联盟"><i class="fa fa-trash-o"></i></a><?php }?>
                            <?php if($v->cooperation_state==497 && $last_delete_log!=null && $last_delete_log->club_id==Yii::app()->session['club_id'] && $last_delete_log->join_or_del==772){?>
                                <a class="btn" href="javascript:;" onclick="fnCancelDeleteInvite(<?php echo $v->id;?>);" title="撤销解除"><i class="fa fa-reply"></i></a>
                            <?php }?>
                            <?php if($v->cooperation_state==497 && $last_delete_log!=null && $last_delete_log->club_id!=Yii::app()->session['club_id'] && $last_delete_log->join_or_del==772){?>
                                <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $v->id;?>, 'yes');" title="同意解除"><i class="fa fa-check"></i></a>
                                <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $v->id;?>, 'no');" title="拒绝解除"><i class="fa fa-minus-circle"></i></a>
                            <?php }?>
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>
<script>
// 撤销邀请操作
var fnCancelInvite=function(invite_id){
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">撤销原因</td>'+
            '<td><textarea id="dialog_invite_498_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'chexiaoyaoqing',
        lock:true,
        opacity:0.3,
        title:'撤销邀请',
        content:html,
        button:[
            {
                name:'确认撤销',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('cancelInvite');?>',
                        data: {invite_id:invite_id, msg:$('#dialog_invite_498_msg').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['chexiaoyaoqing'].close();
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
    var dialogText='同意邀请';
    if(type!='yes'){
        type='no';
        dialogText='拒绝邀请';
    }
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">审核留言</td>'+
            '<td><textarea id="dialog_invite2_498_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'tongguoyaoqing',
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
                        url: '<?php echo $this->createUrl('passInvite');?>',
                        data: {invite_id:invite_id, msg:$('#dialog_invite2_498_msg').val(), type:type},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['tongguoyaoqing'].close();
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

// 解除联盟操作
var fnDeleteInvite=function(invite_id){
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">解除原因</td>'+
            '<td><textarea id="dialog_invite_status_337_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'jiechulianmeng',
        lock:true,
        opacity:0.3,
        title:'解除联盟',
        content:html,
        button:[
            {
                name:'解除联盟',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('deleteInvite');?>',
                        data: {invite_id:invite_id, msg:$('#dialog_invite_status_337_msg').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['jiechulianmeng'].close();
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

// 撤销解除操作
var fnCancelDeleteInvite=function(invite_id){
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">撤销原因</td>'+
            '<td><textarea id="dialog_invite_canceldel_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'chexiaojiechu',
        lock:true,
        opacity:0.3,
        title:'撤销解除',
        content:html,
        button:[
            {
                name:'确认撤销',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('cancelDeleteInvite');?>',
                        data: {invite_id:invite_id, msg:$('#dialog_invite_canceldel_msg').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['chexiaojiechu'].close();
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

// 是否同意解除联盟操作
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
                        url: '<?php echo $this->createUrl('isdelInvite');?>',
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

// 查看记录
var fnInviteLog=function(invite_id){
    $.dialog.open('<?php echo $this->createUrl("inviteLog");?>&invite_id='+invite_id,{
        id:'danwei',
        lock:true,
        opacity:0.3,
        title:'联盟历史记录',
        width:'800px',
        height:'60%',
        close: function () {}
    });
};
$(function(){
    // 邀请方
    // 状态邀请中，右键菜单撤销邀请
    $.contextMenu({
        selector: '.invite_498', 
        callback: function(key, op) {
            if(key=='cancel'){
                fnCancelInvite(op.$trigger.attr('data-id'));
            }
        },
        items: {
            "cancel": {name: "撤销邀请", icon: "fa-reply"},
            "sep1": "---------",
            "quit": {name: "取消", icon: "fa-times"}
        }
    });
    
    // 被邀请方
    // 状态邀请中，右键菜单审核
    $.contextMenu({
        selector: '.invite2_498', 
        callback: function(key, op) {
            if(key=='yes' || key=='no'){
                fnPassInvite(op.$trigger.attr('data-id'), key);
            }
        },
        items: {
            "yes": {name: "同意邀请", icon: "fa-check"},
            "no": {name: "拒绝邀请", icon: "fa-minus-circle"},
            "sep1": "---------",
            "quit": {name: "取消", icon: "fa-times"}
        }
    });
    
    // 已经联盟时
    // 状态在职，右键解除联盟
    $.contextMenu({
        selector: '.invite_status_337', 
        callback: function(key, op) {
            if(key=='delete'){
                fnDeleteInvite(op.$trigger.attr('data-id'));
            }
        },
        items: {
            "delete": {name: "解除联盟", icon: "fa-trash-o"},
            "sep1": "---------",
            "quit": {name: "取消", icon: "fa-times"}
        }
    });
    
    // 状态解除中，右键菜单撤销解除
    $.contextMenu({
        selector: '.invite_canceldel', 
        callback: function(key, op) {
            if(key=='cancel'){
                fnCancelDeleteInvite(op.$trigger.attr('data-id'));
            }
        },
        items: {
            "cancel": {name: "撤销解除", icon: "fa-reply"},
            "sep1": "---------",
            "quit": {name: "取消", icon: "fa-times"}
        }
    });
    
    // 对方发送状态解除中，我方右键是否同意解除
    $.contextMenu({
        selector: '.invite_isdel', 
        callback: function(key, op) {
            if(key=='yes' || key=='no'){
                fnIsdelInvite(op.$trigger.attr('data-id'), key);
            }
        },
        items: {
            "yes": {name: "同意解除", icon: "fa-check"},
            "no": {name: "拒绝解除", icon: "fa-minus-circle"},
            "sep1": "---------",
            "quit": {name: "取消", icon: "fa-times"}
        }
    });
});

var addClubHtml='<div style="width:500px;">'+
'<table class="box-detail-table showinfo">'+
    '<tr>'+
        '<td width="15%">联盟项目</td>'+
        '<td><select onchange="fnResetClub();" id="dialog_project"><?php foreach($projectlist as $v){?><option value="<?php echo $v->id;?>"><?php echo $v->project_name;?></option><?php }?></select></td>'+
    '</tr>'+
    '<tr>'+
        '<td>目标单位</td>'+
        '<td><input id="dialog_club" type="hidden" value=""><span id="club_box"></span><input onclick="fnSelectClub();" class="btn" type="button" value="选择单位"></td>'+
    '</tr>'+
    '<tr>'+
        '<td>联盟附言</td>'+
        '<td><textarea id="dialog_msg" class="input-text"></textarea></td>'+
    '</tr>'+
'</table>'+
'</div>';

// 添加联盟单位
var fnAddClub=function(){
    $.dialog({
        id:'addlianmeng',
        lock:true,
        opacity:0.3,
        title:'邀请单位',
        content:addClubHtml,
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
    var project_id=$('#dialog_project').val();
    var club_id=$('#dialog_club').val();
    var msg=$('#dialog_msg').val();
    if(club_id==''){
        we.msg('minus', '请先选择目标单位');
        return false;
    }
    we.loading('show');
    $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('sendInvite');?>',
        data: {project_id: project_id, club_id:club_id, msg:msg},
        dataType: 'json',
        success: function(data) {
            if(data.status==1){
                we.loading('hide');
                $.dialog.list['addlianmeng'].close();
                we.success(data.msg, data.redirect);
            }else{
                we.loading('hide');
                we.msg('minus', data.msg);
            }
        }
    });
    return false;
};

// 更新单位
var fnUpdateClub=function(){
    var arr=[];
    var id;
    $('#club_box').find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $('#dialog_club').val(we.implode(',', arr));
};

// 选择单位
var fnSelectClub=function(){
    var project_id=$('#dialog_project').val();
    if(project_id<=0){
        we.msg('minus', '请先选择联盟项目');
        return false;
    }
    // 选择单位
    var $club_box=$('#club_box');
    $.dialog.data('club_id', 0);
    $.dialog.open('<?php echo $this->createUrl("select/club", array('no_cooperation'=>Yii::app()->session['club_id']));?>&project_id='+project_id,{
        id:'danwei',
        lock:true,
        opacity:0.3,
        title:'选择具体内容',
        width:'500px',
        height:'60%',
        close: function () {
            //console.log($.dialog.data('club_id'));
            if($.dialog.data('club_id')>0 && $('#club_item_'+$.dialog.data('club_id')).length==0){
                $club_box.append('<span id="club_item_'+$.dialog.data('club_id')+'" class="label-box" data-id="'+$.dialog.data('club_id')+'">'+$.dialog.data('club_title')+'<i onclick="fnDeleteClub(this);"></i></span>');
                fnUpdateClub();
            }
        }
    });
};

// 删除已选择单位
var fnDeleteClub=function(op){
    $(op).parent().remove();
    fnUpdateClub();
};

// 重置单位
var fnResetClub=function(){
    $('#club_box').html('');
    $('#dialog_club').val('');
};
</script>