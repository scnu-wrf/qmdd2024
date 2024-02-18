<?php 

if($_REQUEST['index']==4){
    $txt='学员审核》待审核';
	$txt2='》审核';
	
} elseif ($_REQUEST['index']==5){
    $txt='学员列表';
	$txt2='》详情';
} 
elseif ($_REQUEST['index']==6){
    $txt='学员解除';
	$txt2='》详情';
} 
elseif ($_REQUEST['index']==7){
    $txt='审核未通过';
	$txt2='》详情';
} 
elseif ($_REQUEST['index']==8){
    $txt='各单位学员查询';
	$txt2='》详情';
} 
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：会员》学员管理》<?php echo $txt;?><?php echo $txt2;?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();">
                <i class="fa fa-reply"></i>返回
            </a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">个人资料</li>
                <li id="a2">实名信息</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table style="width:100%;table-layout:auto;">
                    <tr class="table-title">
                        <td class="fontStyle1" colspan="4">基本信息</td>
                    </tr>
                    <tr> 
                        <?php echo $form->hiddenField($model, 'member_gfid', array('class' => 'input-text','id'=>"member_gfid")); ?> 
                        <td class="fontStyle1" style="width:5px;"><?php echo $form->labelEx($model, 'gf_account'); ?></td> 
                        <?php echo $form->hiddenField($model, 'gf_account', array('class' => 'input-text','id'=>"dr_gf_account")); ?> 
                        <td style="width:35%;"><?php echo $model->gf_account; ?></td>
                        <td class="fontStyle1" style="width:5px;"><?php echo $form->labelEx($model, 'GF_NAME'); ?></td>
                        <?php echo $form->hiddenField($model, 'zsxm', array('class' => 'input-text','id'=>"d_gf_name")); ?> 
                        <td style="width:35%;"><?php echo $model->gf_user->GF_NAME; ?></td> 
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'PHONE'); ?></td>
                        <td><?php echo $model->gf_user->PHONE; ?></td>
                        <td><?php echo $form->labelEx($model, 'EMAIL'); ?></td>
                        <td><?php echo $model->gf_user->EMAIL; ?></td>   
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'GRQM'); ?></td>
                        <td><?php echo $model->gf_user->GRQM; ?></td>
                        <td><?php echo $form->labelEx($model, 'TXNAME'); ?></td>
                        <td>
                            <?php 
                                $basepath=BasePath::model()->getPath(211);
                                $picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->gf_user->TXNAME!=null){
                            ?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user->TXNAME;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user->TXNAME;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php echo $form->error($model, 'TXNAME', $htmlOptions = array()); ?>
                        </td>   
                    </tr>
                    <tr class="table-title">
                        <td class="fontStyle1" colspan="4">详细信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'guardian'); ?></td>
                        <td><?php echo $model->gf_user->guardian; ?></td>
                        <td><?php echo $form->labelEx($model, 'guardian_contact_information'); ?></td>
                        <td><?php echo $model->gf_user->guardian_contact_information; ?></td>   
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'BLOOD'); ?></td>
                        <td><?php echo $model->gf_user->BLOOD; ?></td>
                        <td><?php echo $form->labelEx($model, 'height'); ?></td>
                        <td><?php echo $model->gf_user->height; ?></td>   
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'weight'); ?></td>
                        <td><?php echo $model->gf_user->weight; ?></td>
                        <td><?php echo $form->labelEx($model, 'FamilyHistory'); ?></td>
                        <td><?php echo $model->gf_user->FamilyHistory; ?></td>   
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'occupation'); ?></td>
                        <td><?php echo $model->gf_user->occupation; ?></td>
                        <td><?php echo $form->labelEx($model, 'work_unit'); ?></td>
                        <td><?php echo $model->gf_user->work_unit; ?></td>   
                    </tr>
                    <tr>
                        <td>家庭住址</td>
                        <td></td>
                        <td><?php echo $form->labelEx($model, 'INTEREST'); ?></td>
                        <td>
                            <?php 
                                $text='';
                                if(!empty($model->gf_user->INTEREST))foreach(explode("|",$model->gf_user->INTEREST) as $t){
                                    $text.=explode(":",$t)[1].',';
                                }
                                echo rtrim($text,','); 
                            ?>
                        </td>   
                    </tr>
                    
                    <tr>
                        <td><?php echo $form->labelEx($model, 'IDNAME'); ?></td>
                        <td colspan="3">
                            <?php 
                                $basepath=BasePath::model()->getPath(211);
                                $picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->gf_user->IDNAME!=null){
                            ?>
                                <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user->IDNAME;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user->IDNAME;?>" width="100">
                                </a>
                                </div>
                            <?php }?>
                            <?php echo $form->error($model, 'IDNAME', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>可执行操作</td>
                        <td colspan="3">
                        <?php if($model->club_status==498){ ?>
                            <a class="btn" href="javascript:;" onclick="fnCancelInvite(<?php echo $model->id;?>);" title="撤销邀请">撤销邀请</i></a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php }?>
                        <?php if($model->club_status==496&&$_REQUEST['index']==4){?>
                            <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $model->id;?>, 'yes');" title="同意加入">同意加入</a>
                            <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $model->id;?>, 'no');" title="拒绝加入">拒绝加入</a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php }?>
                        <?php if($model->club_status==337){?><a class="btn" href="javascript:;" onclick="fnDeleteInvite(<?php echo $model->id;?>);" title="解除学员">解除学员</a><?php }?>
                        <?php if($model->club_status==497){?>
                            <a class="btn" href="javascript:;" onclick="fnCancelDeleteInvite(<?php echo $model->id;?>);" title="撤销解除">撤销解除</a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php }?>
                        <?php if($model->club_status==339){?>
                            <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $model->id;?>, 'yes');" title="同意解除">同意解除</a>
                            <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $model->id;?>, 'no');" title="拒绝解除">拒绝解除</a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php }?>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="box-detail-tab-item" style="display:none;">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td class="fontStyle1" colspan="4">实名信息</tr>
                    </tr>
                    <tr>
                        <td class="fontStyle1" style="width:15%;"><?php echo $form->labelEx($model,'zsxm'); ?></td>
                        <td style="width:35%;"><?php echo $model->zsxm; ?></td>
                        <td class="fontStyle1" style="width:15%;"><?php echo $form->labelEx($model,'real_sex'); ?></td>
                        <td style="width:35%;"><?php echo $model->base_code_sex->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'native'); ?></td>
                        <td><?php echo $model->gf_user->native; ?></td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'nation'); ?></td>
                        <td><?php echo $model->gf_user->nation; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'real_birthday'); ?></td>
                        <td><?php echo $model->gf_user->real_birthday; ?></td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_type'); ?></td>
                        <td><?php echo $model->gf_user->id_card_type_name; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card'); ?></td>
                        <td ><?php echo $model->gf_user->id_card; ?></td>
                        <td >证件附件</td>
                        <td ></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_validity_start'); ?></td>
                        <td><?php echo $model->gf_user->id_card_validity_start; ?></td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_validity_end'); ?></td>
                        <td><?php echo $model->gf_user->id_card_validity_end; ?></td>
                    </tr>
                    <tr>
                        <td class="fontStyle1"><?php echo $form->labelEx($model, 'id_card_pic'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(211);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->gf_user->id_card_pic!=null){?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user->id_card_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user->id_card_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php echo $form->error($model, 'id_card_pic', $htmlOptions = array()); ?>
                        </td>
                        <td class="fontStyle1"><?php echo $form->labelEx($model, 'id_pic'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(210);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->gf_user->id_pic!=null){?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user->id_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user->id_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php echo $form->error($model, 'id_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- class="mt15" -->
          <!--<table>
                <tr>
                  <td>
                        <button class="btn btn-blue" type="submit">保存</button>
                        <button onclick="submitType='jiechu'" class="btn btn-blue" type="submit">解除学员</button>
                        
                    </td>
                    <td colspan="4" style="text-align:center;padding:20px;">
                        <?php //if($model->club_status==498){ ?>
                            <a class="btn" href="javascript:;" onclick="fnCancelInvite(<?php //echo $model->id;?>);" title="撤销邀请">撤销邀请</i></a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php //}?>
                        <?php //if($model->club_status==496&&$_REQUEST['index']==4){?>
                            <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php //echo $model->id;?>, 'yes');" title="同意加入">同意加入</a>
                            <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php //echo $model->id;?>, 'no');" title="拒绝加入">拒绝加入</a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php //}?>
                        <?php //if($model->club_status==337){?><a class="btn" href="javascript:;" onclick="fnDeleteInvite(<?php //echo $model->id;?>);" title="解除学员">解除学员</a><?php //}?>
                        <?php //if($model->club_status==497){?>
                            <a class="btn" href="javascript:;" onclick="fnCancelDeleteInvite(<?php //echo $model->id;?>);" title="撤销解除">撤销解除</a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php //}?>
                        <?php //if($model->club_status==339){?>
                            <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php //echo $model->id;?>, 'yes');" title="同意解除">同意解除</a>
                            <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php //echo $model->id;?>, 'no');" title="拒绝解除">拒绝解除</a>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        <?php //}?>
                    </td>
                </tr>
            </table>-->
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
var fnDeleteInvite=function(id){
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
                        url: '<?php echo $this->createUrl('DeleteInvite');?>',
                        data: {id:id,msg:$('#dialog_invite_status_337_msg').val()},
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

