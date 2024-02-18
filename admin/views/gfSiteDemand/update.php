<?php 
    if($model->site_date_start=='0000-00-00 00:00:00'){
        $model->site_date_start='';
    }
    if($model->site_date_end=='0000-00-00 00:00:00'){
        $model->site_date_end='';
    }
?>
   <div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>场地需求详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                	<td colspan="4">场地信息</td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'site_code'); ?></td>
                    <td><?php echo $form->hiddenField($model, 'site_code', array('class' => 'input-text')); ?><?php echo $model->site_code;?></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_name'); ?></td>
                    <td><?php echo $model->site_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'site_envir'); ?></td>
                    <td><?php if($model->site_envir!=null) echo $model->base_code_envir->F_NAME; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_date_start'); ?></td>
                    <td><?php echo $model->site_date_start; ?></td>
                    <td><?php echo $form->labelEx($model, 'site_date_end'); ?></td>
                    <td><?php echo $model->site_date_end; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td><?php echo $model->contact_phone; ?></td>
                    <td><?php echo $form->labelEx($model, 'site_address'); ?></td>
                    <td><?php echo $model->site_address; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_belong'); ?></td>
                    <td><?php if($model->site_belong!=null) echo $model->base_code_belong->F_NAME; ?></td>
                    <td><?php echo $form->labelEx($model, 'belong_name'); ?></td>
                    <td><?php echo $model->belong_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'user_club_id'); ?></td>
                    <td><?php echo $form->hiddenField($model, 'user_club_id', array('class' => 'input-text')); ?>
                        <?php echo $form->hiddenField($model, 'user_club_name', array('class' => 'input-text')); ?>
                        <span id="club_box"><?php if($model->user_club_id!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php }?></span>
                        <!--<input id="club_select_btn" class="btn" type="button" value="选择">-->
                        <?php echo $form->error($model, 'user_club_id', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'rent'); ?></td>
                    <td>
						<?php echo $model->rent; ?>&nbsp;元/月
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
                        <span id="project_box">
                            <?php 
                            if(!empty($project_list)){
                            foreach($project_list as $v){?>
                                <span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>">
                                <?php echo $v->project_list->project_name;?>
                                <!--<i onclick="fnDeleteProject(this);"></i>-->
                                </span>
                            <?php }}?>
                        </span>
                        <!--<input id="project_add_btn" class="btn" type="button" value="添加">-->
                        <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_facilities'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'site_facilities', array('class' => 'input-text')); ?>
                        <span id="classify_box">
                        <?php //if(!empty($site_facilities)){
                        if(is_array($site_facilities)) foreach($site_facilities as $v){?><span class="label-box" id="classify_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->name;?><!--<i onclick="fnDeleteClassify(this);"></i>--></span><?php } ?></span>
                        <!--<input id="classify_add_btn" class="btn" type="button" value="添加分类">-->
                        <?php echo $form->error($model, 'site_facilities', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'site_pic'); ?></td>
                    <td colspan="3">
						<?php echo $form->hiddenField($model, 'site_pic', array('class' => 'input-text fl')); ?>
						<?php $basepath=BasePath::model()->getPath(118);$picprefix='';
                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->site_pic!=''){?>
                      <div class="upload_img fl" id="upload_pic_GfSite_site_pic">
                         <a href="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" target="_blank">
                         <img src="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" width="100"></a></div>
                         <?php }?>
                      <!--<script>we.uploadpic('<?php echo get_class($model);?>_site_pic','<?php echo $picprefix;?>');</script>-->
                        <?php echo $form->error($model, 'site_pic', $htmlOptions = array()); ?>
                    
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_prove'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'site_prove', array('class' => 'input-text')); ?>
                        <div class="upload_img fl" id="upload_pic_site_prove">
                            <?php foreach($site_prove as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><!--<i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i>--></a>
                            <?php }?>
                        </div>
                    <!--<script>we.uploadpic('<?php echo get_class($model);?>_site_prove','<?php echo $picprefix;?>','','',function(e1,e2){fnScrollpic(e1.savename,e1.allpath);},5);</script>-->
                        <?php echo $form->error($model, 'site_prove', $htmlOptions = array()); ?>
                    </td>
                </tr>   
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_description'); ?></td>
                    <td colspan="3">
                    	<?php echo $form->hiddenField($model, 'site_description_temp', array('class' => 'input-text')); ?>
						<script>we.editor('<?php echo get_class($model);?>_site_description_temp', '<?php echo get_class($model);?>[site_description_temp]');</script>
                        <?php echo $form->error($model, 'site_description_temp', $htmlOptions = array()); ?>
                    </td>
                </tr>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
            	<tr>
                	<td width='15%'><?php echo $form->labelEx($model, 'site_level'); ?></td>
                    <td width='85%'>
						<?php echo $form->radioButtonList($model, 'site_level', Chtml::listData(BaseCode::model()->getCode(386), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'site_level'); ?>
                    </td>
                </tr>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td>
                    	<!--<button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                        <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>
                        <button onclick="submitType='tongguo'" class="btn btn-blue" type="submit">审核通过</button>
                        <button onclick="submitType='butongguo'" class="btn btn-blue" type="submit">审核不通过</button>-->
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                        <button onclick="fnGfDemand();" class="btn btn-blue" type="button">申请服务</button>
                    </td>
                </tr>
            </table>
        </div>
        <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">审核状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php echo $model->reasons_time; ?></td>
                <td><?php echo $model->reasons_adminname; ?></td>
                <td><?php echo $model->site_state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td colspan="5">认领信息</td>
                </tr>
            </table>
            <table class="showinfo" style="margin-top: 0px;">
                <tr>
                	<td>认领单位</td>
                    <td>联系人</td>
                    <td>联系电话</td>
                    <td>认领时间</td>
                    <td>状态</td>
                </tr>
                <?php if(isset($cluSite_id)) foreach($cluSite_id as $v){ ?>
                <tr>
                	<td><?php echo $v->club_name; ?></td>
                    <td><?php echo $v->club_contacts; ?></td>
                    <td><?php echo $v->club_contacts_phone; ?></td>
                    <td><?php echo $v->claim_time; ?></td>
                    <td><?php if($v->state) echo $v->base_code->F_NAME; ?></td>
                </tr>
                <?php }?>
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
$('#GfSite_site_date_start').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#GfSite_site_date_end').on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss '});});
	
// 删除已添加项目
var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};
// 项目添加或删除时，更新
var fnUpdateProject=function(){
    var arr=[];
    $('#project_box span').each(function(){
        arr.push($(this).attr('data-id'));
    });
    $('#GfSite_project_list').val(we.implode(',',arr));
};
fnUpdateProject();

$(function(){
    // 添加项目
    var $project_box=$('#project_box');
    $('#project_add_btn').on('click', function(){
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project");?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('project_id')>0){
                    if($('#project_item_'+$.dialog.data('project_id')).length==0){
                       $project_box.append('<span class="label-box" id="project_item_'+$.dialog.data('project_id')+'" data-id="'+$.dialog.data('project_id')+'">'+$.dialog.data('project_title')+'<i onclick="fnDeleteProject(this);"></i></span>'); 
                       fnUpdateProject();
                    }
                }
            }
        });
    });	
    
});

// 选择单位
    var $club_box=$('#club_box');
	var $GfSite_user_club_id=$('#GfSite_user_club_id');
    var $GfSite_user_club_name=$('#GfSite_user_club_name');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club", array('partnership_type'=>16));?>',{
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
                    $GfSite_user_club_id.val($.dialog.data('club_id')).trigger('blur');
					$GfSite_user_club_name.val($.dialog.data('club_title')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
	
// 多图片对应单个字段处理
var $site_prove=$('#GfSite_site_prove');
var $upload_pic_site_prove=$('#upload_pic_site_prove');
var $upload_box_site_prove=$('#upload_box_site_prove');
// 添加或删除时，更新图片
var fnUpdateScrollpic=function(){
    var arr=[];
    $upload_pic_site_prove.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $site_prove.val(we.implode(',',arr));
    $upload_box_site_prove.show();
    if(arr.length>=5) {
        $upload_box_site_prove.hide();
    }
};
// 上传完成时图片处理
var fnScrollpic=function(savename,allpath){
    $upload_pic_site_prove.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
    fnUpdateScrollpic();
};
	
// 选择服务地区
    var $GfSite_site_address=$('#GfSite_site_address');
    var $GfSite_longitude=$('#GfSite_Longitude');
    var $GfSite_latitude=$('#GfSite_latitude');
    $GfSite_site_address.on('click', function(){
        $.dialog.data('maparea_address', '');
        $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>',{
            id:'diqu',
            lock:true,
            opacity:0.3,
            title:'选择服务地区',
            width:'907px',
            height:'504px',
            close: function () {;
                if($.dialog.data('maparea_address')!=''){
                    $GfSite_site_address.val($.dialog.data('maparea_address'));
                    $GfSite_longitude.val($.dialog.data('maparea_lng'));
                    $GfSite_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });
	
// 删除分类
var $classify_box=$('#classify_box');
var $GfSite_site_facilities=$('#GfSite_site_facilities');
var fnUpdateClassify=function(){
    var arr=[];
    var id;
    $classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $GfSite_site_facilities.val(we.implode(',', arr));
};

var fnDeleteClassify=function(op){
    $(op).parent().remove();
    fnUpdateClassify();
};

 // 添加分类
    var $classify_add_btn=$('#classify_add_btn');
    $classify_add_btn.on('click', function(){
        $.dialog.data('classify_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/category", array('fid'=>226));?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('classify_id')>0){
                    if($('#classify_item_'+$.dialog.data('classify_id')).length==0){
                       $classify_box.append('<span class="label-box" id="classify_item_'+$.dialog.data('classify_id')+'" data-id="'+$.dialog.data('classify_id')+'">'+$.dialog.data('classify_title')+'<i onclick="fnDeleteClassify(this);"></i></span>');
                       fnUpdateClassify();
                    }
                }
            }
        });
    });

    // 11
    var fnGfDemand=function(){
        var site_code=$('#GfSiteDemand_site_code').val();
        var user_club_name=$('#GfSiteDemand_user_club_name').val();
        $.dialog({
            id:'shenqingchangdi',
            lock:true,
            opacity:0.3,
            height:'15%',
            width:'20%',
            title:'申请服务',
            content:'是否申请该场地使用权，并同意管理者提供的服务内容',
            button:[
                {
                    name:'确认申请',
                    callback:function(){
                        we.loading('show');
                        $.ajax({
                            type: 'post',
                            url: '<?php echo $this->createUrl('gfDeman',array('id'=>$model->id));?>',
                            data: {site_code:site_code, user_club_name:user_club_name},
                            dataType: 'json',
                            success: function(data) {
                                if(data.status==1){
                                    we.loading('hide');
                                    $.dialog.list['shenqingchangdi'].close();
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