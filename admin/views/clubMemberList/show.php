<?php 

if($_REQUEST['index']==1){
    $txt='邀请学员';
	$txt2='》查看';
	
} elseif ($_REQUEST['index']==2){
    $txt='邀请学员》今日邀请';
	$txt2='》查看';
} elseif ($_REQUEST['index']==3){
    $txt='学员审核';
	$txt2='》查看';
} elseif ($_REQUEST['index']==4){
    $txt='学员审核》待审核';
	//$txt2='';
} 
elseif ($_REQUEST['index']==5){
    $txt='学员列表';
	//$txt2='';
} 
elseif ($_REQUEST['index']==6){
    $txt='学员解除';
	//$txt2='';
} 
elseif ($_REQUEST['index']==7){
    $txt='审核未通过';
	$txt2='审核未通过';
}
elseif ($_REQUEST['index']==8){
    $txt='各单位学员查询';
    //$txt2='';
}


?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：会员》会员管理》<?php echo $txt;?><?php echo $txt2;?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();">
                <i class="fa fa-reply"></i>返回
            </a>
        </span>
    </div>
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
  
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
    <table style="table-layout:auto;" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr class="table-title">
            <td class="fontStyle1" colspan="4">邀请学员详情</td>
        </tr>
        <tr> 
           
            <td width="10%"  class="fontStyle1" style="width:5px;"><?php echo $form->labelEx($model, 'gf_account'); ?></td> 
            <?php echo $form->hiddenField($model, 'gf_account', array('class' => 'input-text','id'=>"dr_gf_account")); ?> 
            <td width="90%" ><?php echo $model->gf_account; ?></td>

        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'zsxm'); ?></td>
            <td><?php echo $model->zsxm; ?></td>

        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'member_project_id'); ?></td>
            <td><?php echo $model->project_name; ?></td>                      
        </tr>
        <tr>
            <td>龙虎级别</td>
            <td></td>                      
        </tr>
        
        <tr>
            <td>邀请附言</td>
            <td><?php if(!is_null($model->club_member))echo $model->club_member->member_content; ?></td>
        </tr>

    </table>
            </div>
            
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

    we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
        return true;
    });

var club_id=0;
var project_id=0;
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
});// 撤销邀请操作
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
    var dialogText='同意加入';
    if(type!='yes'){
        type='no';
        dialogText='拒绝加入';
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

// 解除会员操作
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
        title:'解除会员',
        content:html,
        button:[
            {
                name:'解除会员',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('deleteInvite');?>&id='+invite_id,
                        data: {msg:$('#dialog_invite_status_337_msg').val()},
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
</script> 

