<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务资源详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table>
                <tr  class="table-title">
                	<td colspan="4">基本信息</td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 's_code'); ?></td>
                    <td><?php echo $model->s_code;?></td>
                    <td><?php echo $form->labelEx($model, 's_name'); ?></td>
                    <td>
						<?php echo $form->textField($model, 's_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 's_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 't_typeid'); ?></td>
                    <td>
                             <?php echo $form->dropDownList($model, 't_typeid', Chtml::listData(QmddServerType::model()->getServertype(), 'id', 't_name'), array('prompt'=>'请选择','onchange' =>'selectOnchang(this)')); ?>
                            <?php echo $form->error($model, 't_typeid', $htmlOptions = array()); ?>
                            <?php $arr=QmddServerUsertype::model()->getServerusertype_all(); ?>
<script> 
var $t_type2= <?php echo json_encode($arr)?>;
</script> 
                            <?php echo $form->dropDownList($model, 't_stypeid', Chtml::listData(QmddServerUsertype::model()->getServerusertype(), 'id', 'f_uname'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 't_stypeid', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 's_levelid'); ?></td>
                    <td>
                             <?php echo $form->dropDownList($model, 's_levelid', Chtml::listData(MemberCard::model()->getLevel_all(), 'f_id', 'card_name'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 's_levelid', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'contact_number'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'contact_number', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'contact_number', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 's_address'); ?></td>
                    <td>
						<?php echo $form->textField($model, 's_address', array('class' => 'input-text')); ?>
						<?php echo $form->hiddenField($model, 'Longitude'); ?>
                        <?php echo $form->hiddenField($model, 'latitude'); ?>
                        <?php echo $form->hiddenField($model, 'area_country'); ?>
                        <?php echo $form->hiddenField($model, 'area_province'); ?>
                        <?php echo $form->hiddenField($model, 'area_city'); ?>
                        <?php echo $form->hiddenField($model, 'area_district'); ?>
                        <?php echo $form->hiddenField($model, 'area_street'); ?>
                        <?php echo $form->error($model, 's_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                    <td>
                        <span id="club_box"><?php if($model->club_id!=null){?><span class="label-box"><?php echo $model->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text', 'value'=>get_session('club_id'))); ?></span><?php } ?></span>
                    </td>
                    <td><?php echo $form->labelEx($model, 'project_ids'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'project_ids', array('class' => 'input-text',)); ?>
                        <span id="project_box">
                            <?php if(!empty($project)){ foreach($project as $v){?>
                                <span class="label-box" id="project_item_<?php echo $v->id?>" data-id="<?php echo $v->id?>"><?php echo $v->project_name;?><i onclick="fnDeleteProject(this);"></i></span>
                            <?php }}?>
                        </span>
                        <input id="project_add_btn" class="btn" type="button" value="添加">
                        <?php echo $form->error($model, 'project_ids', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'logo_pic'); ?></td>
                    <td colspan="3">
						<?php echo $form->hiddenField($model, 'logo_pic', array('class' => 'input-text fl')); ?>
						<?php $basepath=BasePath::model()->getPath(170);$picprefix='';
                        if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->logo_pic!=''){?>
                      <div class="upload_img fl" id="upload_pic_QmddServerSourcer_logo_pic">
                         <a href="<?php echo $basepath->F_WWWPATH.$model->logo_pic;?>" target="_blank">
                         <img src="<?php echo $basepath->F_WWWPATH.$model->logo_pic;?>" width="100"></a></div>
                         <?php }?>
                      <script>we.uploadpic('<?php echo get_class($model);?>_logo_pic','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'logo_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 's_picture'); ?></td>
                    <td colspan="3">
                        <?php $base_path=BasePath::model()->getPath(172);$pic_prefix='';if($base_path!=null){ $pic_prefix=$base_path->F_CODENAME; }?>
                            <?php echo $form->hiddenField($model, 's_picture', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_s_picture">
                                <?php 
                                foreach($picture as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $base_path->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $base_path->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>
                                <?php }?>
                            </div>
                    <script>
we.uploadpic('<?php echo get_class($model);?>_s_picture','<?php echo $pic_prefix;?>','','',function(e1,e2){fnScrollpic(e1.savename,e1.allpath);},5);
                        </script>
                        <?php echo $form->error($model, 's_picture', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table>
            	<tr class="table-title">
                    <td colspan="4">赛事信息</td>
                </tr>
                <tr>
                    <td>可服务人数</td>
                    <td>
                        <?php echo $form->textField($model, 's_name', array('class' => 'input-text','style'=>'width:50px;')); ?> 至 <?php echo $form->textField($model, 's_name', array('class' => 'input-text','style'=>'width:50px;')); ?>人
                    </td>
                    <td>赛事模式</td>
                    <td>
                        <?php echo $form->dropDownList($model, 's_levelid', Chtml::listData(MemberCard::model()->getLevel_all(), 'f_id', 'card_name'), array('prompt'=>'请选择')); ?>
                        <?php echo $form->error($model, 's_levelid', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table id="servant_box">
            	<tr class="table-title">
                    <td colspan="5">服务者信息<input id="servant_add_btn" class="btn" type="button" value="添加"></td>
                </tr>
                <tr>
                	<th>服务类别</th>
                    <th>服务编号</th>
                    <th>姓名</th>
                    <th>等级</th>
                    <th>操作</th>
                </tr>
 <?php if(!empty($servant)) foreach ($servant as $v) { ?>
                <tr>
                    <td><?php echo $v->qualification_type; ?></td>
                    <td><?php echo $v->qcode; ?></td>
                    <td><?php echo $v->qualification_name; ?></td>
                    <td><?php echo $v->qualification_level_name; ?></td>
                    <td></td>
                </tr>
 <?php } ?>
            </table>
            <table class="mt15">
            	<tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td width='15%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td colspan="3">
                        <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td colspan="3">
                        <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核','tongguo'=>'审核通过','butongguo'=>'审核不通过'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
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
                <td><?php echo $model->state_name; ?></td>
                <td><?php echo $model->reasons_failure; ?></td>
            </tr>
        </table>
        </div><!--box-detail-bd end-->  
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>  
// 滚动图片处理
var $s_picture=$('#QmddServerSourcer_s_picture');
var $upload_pic_s_picture=$('#upload_pic_s_picture');
var $upload_box_s_picture=$('#upload_box_s_picture');
// 添加或删除时，更新图片
var fnUpdateScrollpic=function(){
    var arr=[];
    $upload_pic_s_picture.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $s_picture.val(we.implode(',',arr));
    $upload_box_s_picture.show();
    if(arr.length>=5) {
        $upload_box_s_picture.hide();
    }
}
// 上传完成时图片处理
var fnScrollpic=function(savename,allpath){
    $upload_pic_s_picture.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
    fnUpdateScrollpic();
} 

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
        $('#QmddServerSourcer_project_ids').val(we.implode(',',arr));
    };
    //fnUpdateProject();

    $(function(){
        // 添加项目
        var $project_box=$('#project_box');
        $('#project_add_btn').on('click', function(){
			var club_id=$('#QmddServerSourcer_club_id').val();
            $.dialog.data('project_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/project");?>&club_id='+club_id,{
                id:'xiangmu',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('project_id')==-1){
                        var boxnum=$.dialog.data('project_title');
                        for(var j=0;j<boxnum.length;j++) {
                            if($('#project_item_'+boxnum[j].dataset.id).length==0){
                                var s1='<span class="label-box" id="project_item_'+boxnum[j].dataset.id;
                                s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                                $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                                fnUpdateProject(); 
                            }
                        }
                    }
                }
            });
        });
        
    // 选择服务地区
    $('#QmddServerSourcer_s_address').on('click', function(){
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
                    $('#QmddServerSourcer_s_address').val($.dialog.data('maparea_address'));
					$('#QmddServerSourcer_area_country').val($.dialog.data('country'));
					$('#QmddServerSourcer_area_province').val($.dialog.data('province'));
					$('#QmddServerSourcer_area_city').val($.dialog.data('city'));
					$('#QmddServerSourcer_area_district').val($.dialog.data('district'));
					$('#QmddServerSourcer_area_street').val($.dialog.data('street'));
                    $('#QmddServerSourcer_Longitude').val($.dialog.data('maparea_lng'));
                    $('#QmddServerSourcer_latitude').val($.dialog.data('maparea_lat'));
                }
            }
        });
    });
	
});
function selectOnchang(obj){ 
  var show_id=$(obj).val();
  var  p_html ='<option value="">请选择</option>';
  if (show_id>0) {
    //'partnership_type
     for (j=0;j<$t_type2.length;j++) 
        if($t_type2[j]['t_typeid']==show_id)
       {
        p_html = p_html +'<option value="'+$t_type2[j]['id']+'">';
        p_html = p_html +$t_type2[j]['f_uname']+'</option>';
      }
    }
   $("#QmddServerSourcer_t_stypeid").html(p_html);
}
        
</script>
<script>
// 添加服务者
        var $servant_box=$('#servant_box');
        $('#servant_add_btn').on('click', function(){
			var club_id=$('#QmddServerSourcer_club_id').val();
            $.dialog.data('person_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/servant");?>&club_id='+club_id,{
                id:'xiangmu',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('person_id')>0){
						if($('#servant_item_'+$.dialog.data('person_id')).length==0){
							$servant_box.append('<tr id="servant_item_'+$.dialog.data('person_id')+'" data-id="'+$.dialog.data('person_id')+'"><td>'+$.dialog.data('servant_type')+'</td><td>'+$.dialog.data('servant_code')+'</td><td>'+$.dialog.data('servant_name')+'</td><td>'+$.dialog.data('servant_level')+'</td><td><a class="btn" href="<?php echo $this->createUrl('update');?>id='+$.dialog.data('person_id')+'" title="查看详情">查看详情</a></td></tr>'); 
				   fnUpdateProject();
						}
                    }
                }
            });
        });
</script>