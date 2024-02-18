<?php
	if(!empty($model->video_start=='0000-00-00 00:00:00')){
        $model->video_start='';
    }
    if(!empty($model->video_end=='0000-00-00 00:00:00')){
        $model->video_end='';
    }
?>
<?php
 function get_form_list2($submit='=='){
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError||(submitType=="'.$submit.'")){
                        we.overlay("show");
                        $.ajax({
                            type:"post",
                            url:form.attr("action"),
                            data:form.serialize()+"&submitType="+submitType,
                            dataType:"json",
                            success:function(d){
                                if(d.status==1){
                                    we.success(d.msg, d.redirect);
                                }else{
                                    we.error(d.msg, d.redirect);
                                }
                            }
                        });
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
            ),
        );
  }
?>
<div class="box">
    <div class="box-title c"><h1>当前界面：视频》发布视频》发布视频》<a class="nav-a">添加</a></h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span></div><!--box-title end-->
    <div class="box-detail">
		<?php  $form = $this->beginWidget('CActiveForm', get_form_list2('baocun')); ?>
        <div class="box-detail-bd">
			<table class="table-title">
				<tr>
					<td>基本信息</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'video_code'); ?></td>
					<td>
						<span style="color:#7a7a7a">系统生成</span>
					</td>
					<td width="15%" ><?php echo $form->labelEx($model, 'club_id'); ?></td>
					<td>
						<span id="club_box"><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span></span>
						<?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
					</td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'publish_classify'); ?>（单选）</td>
					<td width="35%">
						<?php echo $form->hiddenField($model, 'publish_classify', array('class' => 'input-text')); ?>
						<span id="publish_classify_box"></span>
						<input id="publish_classify_add_btn" class="btn" type="button" value="添加分类">
						<?php echo $form->error($model, 'publish_classify', $htmlOptions = array()); ?>
					</td>
					<td><?php echo $form->labelEx($model, 'video_classify'); ?>（多选）</td>
					<td>
						<?php echo $form->hiddenField($model, 'video_classify', array('class' => 'input-text')); ?>
						<span id="classify_box"></span>
						<input id="classify_add_btn" class="btn" type="button" value="添加分类">
						<?php echo $form->error($model, 'video_classify', $htmlOptions = array()); ?>
					</td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'video_title'); ?></td>
					<td width="35%">
						<?php echo $form->textField($model, 'video_title', array('class' => 'input-text')); ?>
						<?php echo $form->error($model, 'video_title', $htmlOptions = array()); ?>
					</td>
					<td><?php echo $form->labelEx($model, 'video_sec_title'); ?></td>
					<td>
						<?php echo $form->textField($model, 'video_sec_title', array('class' => 'input-text')); ?>
					</td>
				</tr>
				<tr>
					<td><?php echo $form->labelEx($model, 'video_logo'); ?><br>规格1080*540px</td>
					<td colspan="3">
						<?php echo $form->hiddenField($model, 'video_logo', array('class' => 'input-text fl')); ?>
						<?php $basepath=BasePath::model()->getPath(143);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
						<input style="margin-left:5px;" id="picture_select_btn" class="btn" type="button" value="图库选择" >
						<script>we.uploadpic('<?php echo get_class($model);?>_video_logo','<?php echo $picprefix;?>');</script>
						<?php echo $form->error($model, 'video_logo', $htmlOptions = array()); ?>
					</td>
				</tr>
			</table>
			<table class="table-title" style="margin-top:10px;">
				<tr>
					<td>视频信息</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'program_num'); ?></td>
					<td width="35%"><?php echo $form->textField($model, 'program_num', array('class' => 'input-text','placeholder' => '输入数字','onkeyup'=>"this.value=this.value.replace(/\D/g,'')",'onchange'=>"this.value=this.value.replace(/[^\d.]/g,'')")); ?><?php echo $form->error($model, 'program_num', $htmlOptions = array()); ?></td>
					<td width="15%"><?php echo $form->labelEx($model, 'year'); ?></td>
					<td><?php echo $form->textField($model, 'year', array('class' => 'input-text','style'=>'width:60px;','readonly'=>'readonly')); ?><?php echo $form->error($model, 'year', $htmlOptions = array()); ?></td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'area'); ?></td>
					<td width="35%"><?php echo $form->dropDownList($model, 'area', Chtml::listData(array(array('value'=>'内地','name'=>'内地'),array('value'=>'中国香港','name'=>'中国香港'),array('value'=>'中国台湾','name'=>'中国台湾'),array('value'=>'美国','name'=>'美国'),array('value'=>'英国','name'=>'英国'),array('value'=>'韩国','name'=>'韩国'),array('value'=>'泰国','name'=>'泰国'),array('value'=>'日本','name'=>'日本'),array('value'=>'其他','name'=>'其他')), 'value', 'name'), array('prompt'=>'请选择')); ?><?php echo $form->error($model, 'area', $htmlOptions = array()); ?></td>
					<td width="15%"><?php echo $form->labelEx($model, 'topic'); ?></td>
					<td><?php echo $form->dropDownList($model, 'topic', Chtml::listData(array(array('value'=>'喜剧','name'=>'喜剧'),array('value'=>'爱情','name'=>'爱情'),array('value'=>'动作','name'=>'动作'),array('value'=>'都市生活','name'=>'都市生活'),array('value'=>'古装历史','name'=>'古装历史'),array('value'=>'军旅抗战','name'=>'军旅抗战'),array('value'=>'体育电竞','name'=>'体育电竞'),array('value'=>'罪案谍战','name'=>'罪案谍战'),array('value'=>'网络剧','name'=>'网络剧'),array('value'=>'科幻','name'=>'科幻'),array('value'=>'戏剧','name'=>'戏剧'),array('value'=>'其他','name'=>'其他')), 'value', 'name'), array('prompt'=>'请选择')); ?><?php echo $form->error($model, 'topic', $htmlOptions = array()); ?></td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'video_intro'); ?></td>
					<td colspan="3">
						<?php echo $form->textarea($model,'video_intro',array('class'=>'input-text')); ?>
						<?php echo $form->error($model, 'video_intro', $htmlOptions = array()); ?>
					</td>
				</tr>
			</table>
			<table class="table-title" style="margin-top:10px;table-layout:auto;">
				<tr>
					<td width="90%">视频分集</td>
					<td><input onclick="fnAddProgram();" class="btn" type="button" value="添加行"></td>
				</tr>
			</table>
			<table>
				<tr>
					<td>
						<?php echo $form->hiddenField($model, 'programs_list'); ?>
						<input name="fileCode" id="fileCode" value="204_gm" type="hidden" />
						<table id="program_list" class="showinfo" data-num="new" style="margin:0;table-layout:auto;">
							<tr class="table-title">
								<td width="20%">分集编号</td>
								<td width="15%">分集名称<span class="required">*</span></td>
								<td width="8%">分集排序<span class="required">*</span></td>
								<td>视频文件<span class="required">*</span><span style="color:#7a7a7a;font-size:smaller;">（点击播放）</span></td>
								<td width="8%">格式</td>
								<td width="8%">时长</td>
								<td width="6%">操作</td>
							</tr>
							<tr>
								<td><span style="color:#7a7a7a">系统生成</span></td>
								<td><input type="hidden" class="input-text" name="programs_list[new][id]" value="null" /><input onchange="fnUpdateProgram();" class="input-text up_title" name="programs_list[new][video_series_title]" style="width:80%;"></td>
								<td><input onchange="fnUpdateProgram();" class="input-text up_title" name="programs_list[new][video_series_num]" style="width:80%;"></td>
								<td class="up_btn">
									<span class="fl">
										<div class="up_progress" style="width: 200px;height: 25px;line-height: 25px;background-color:#f7f7f7;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);border-radius:4px;background-image:linear-gradient(to bottom,#f5f5f5,#f9f9f9);display:none;">
											<div class="up_finish" style="width: 0%;background-color: #149bdf;
background-image:linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent);background-size:40px 40px;height: 100%;color: #fff;text-align: right;padding-right: 5px;box-sizing: border-box;" progress="0"></div>
										</div>
									</span>
									<span class="fl video_box"></span>
									<div class="upload fl">
										<script>we.materialVideoNew("<?php echo $this->createUrl('GfMaterial/saveMaterial');?>");</script>
									</div>
									<input style="margin-left:5px;" class="btn fl video_select_btn" type="button" value="选择视频">
									<input type="hidden" class="input-text up_source" name="programs_list[new][video_source_id]" value="null" />
									<input type="hidden" class="input-text" name="programs_list[new][video_format]" />
									<input type="hidden" class="input-text" name="programs_list[new][video_duration]" />
								</td>
								<td></td>
								<td></td>
								<td style="text-align:left;"><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
							</tr>
						</table>
						<?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
					</td>
				</tr>
			</table>
			<table class="table-title mt15">
				<tr>
					<td>视频设置</td>
				</tr>
			</table>
			<table>
				<tr>
					<td width="15%">是否上线 <span class="required">*</span></td>
					<td>
						<?php echo $form->radioButtonList($model, 'is_uplist', Chtml::listData(array(array("id"=>"1","name"=>"是"),array("id"=>"0","name"=>"否")), 'id', 'name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
						<?php echo $form->error($model, 'is_uplist'); ?><br>
						<span style="color:#7a7a7a;font-size:smaller;">（是:上线,展示前端　否:下线,不展示前端）</span>
					</td>
					<td width="15%">上/下线时间 <span class="required">*</span><br><span style="color:#7a7a7a;font-size:smaller;">显示前端的时间</span></td>
					<td>
						<?php echo $form->textField($model, 'video_start', array('class' => 'input-text','onclick'=>'fnStartTime(this);','style'=>'width:110px;','readonly'=>'readonly')); ?> - <?php echo $form->textField($model, 'video_end', array('class' => 'input-text','onclick'=>'fnEndTime(this);','style'=>'width:110px;','readonly'=>'readonly')); ?>
						<?php echo $form->error($model, 'video_start', $htmlOptions = array()); ?><?php echo $form->error($model, 'video_end', $htmlOptions = array()); ?>
					</td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'project_is'); ?></td>
					<td>
						<?php echo $form->radioButtonList($model, 'project_is', Chtml::listData(array(array("id"=>"648","name"=>"不限项目"),array("id"=>"649","name"=>"指定项目")), 'id', 'name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','onchange'=>'selectProjectIs(this)')); ?>
						<?php echo $form->error($model, 'project_is', $htmlOptions = array()); ?>
					</td>
					<td width="15%"><?php echo $form->labelEx($model, 'video_show'); ?></td>
					<td>
						<?php echo $form->checkBoxList($model, 'video_show', Chtml::listData(BaseCode::model()->getCode(1542), 'f_id', 'F_NAME'),
						  $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
						<?php echo $form->error($model, 'video_show'); ?>
					</td>
				</tr>
				<tr id="ProjectIs" style="display:none;">
					<td width="15%">选择指定项目</td>
					<td colspan="3">
						<?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text')); ?>
						<span id="project_box"><?php foreach($project_list as $v){?><span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->project_name;?><i onclick="fnDeleteProject(this);"></i></span><?php }?></span>
						<input id="project_add_btn" class="btn" type="button" value="添加项目">
						<?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
					</td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'open_club_member'); ?><br><span style="color:#7a7a7a;font-size:smaller;">GF会员含单位会员</span></td>
					<td colspan="3">
						<?php echo $form->radioButtonList($model, 'open_club_member', Chtml::listData($member_type, 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','onchange'=>'selectMember(this)')); ?>
						<?php echo $form->error($model, 'open_club_member', $htmlOptions = array()); ?>
				  </td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 'gf_price'); ?>（元）<br><span style="color:#7a7a7a;font-size:smaller;">0元视为免费观看</span></td>
					<td>
						<?php echo $form->textField($model, 'gf_price', array('class' => 'input-text','onblur'=>"this.value=this.value.replace(/[^\d.]/g,'');value=value.replace(/^(\d+)\.(\d\d).*$/,'$1.$2')",'onkeyup'=>"this.value=this.value.replace(/[^\d.]/g,'')")); ?>
					</td>
					<td width="15%"><?php echo $form->labelEx($model, 'member_price'); ?>（元）<br><span style="color:#7a7a7a;font-size:smaller;">0元视为免费观看</span></td>
					<td>
						<?php echo $form->textField($model, 'member_price', array('class' => 'input-text','onblur'=>"this.value=this.value.replace(/[^\d.]/g,'');value=value.replace(/^(\d+)\.(\d\d).*$/,'$1.$2')",'onkeyup'=>"this.value=this.value.replace(/[^\d.]/g,'')")); ?>
					</td>
				</tr>
				<tr>
					<td width="15%"><?php echo $form->labelEx($model, 't_duration'); ?>（分钟）</td>
					<td>
						<?php echo $form->textField($model, 't_duration', array('class' => 'input-text','placeholder' => '输入数字','onkeyup'=>"this.value=this.value.replace(/\D/g,'')",'onblur'=>"this.value=this.value.replace(/[^\d.]/g,'')")); ?>
					</td>
					<td colspan="2"></td>
				</tr>
			</table>
			<table style='margin-top:10px;'>
				<tr>
					<td width="15%">可执行操作</td>
					<td colspan="3">
						<?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
						<button class="btn" type="button" onclick="we.back();">取消</button>
					</td>
				</tr>
			</table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->

<script>
$(window).on('beforeunload',function(event){
	if($(".up_progress").is(":visible")){
		return "视频正在上传，是否确认离开";
	}
}); 
we.tab('.box-detail-tab li','.box-detail-tab-item');
var club_id=0;
//从图库选择图片
var $BoutiqueVideo_video_logo=$('#BoutiqueVideo_video_logo');
    $('#picture_select_btn').on('click', function(){
		var club_id=$('#BoutiqueVideo_club_id').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>143));?>&club_id='+club_id,{
            id:'picture',
            lock:true,
            opacity:0.3,
            title:'请选择素材',
            width:'100%',
            height:'90%',
            close: function () {
                if($.dialog.data('material_id')>0){
                    $('#BoutiqueVideo_video_logo').val($.dialog.data('app_icon')).trigger('blur');
                    $('#upload_pic_BoutiqueVideo_video_logo').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
                    +'"  width="100"></a>');
               }

            }
        });
    });
// 删除项目
var $project_box=$('#project_box');
var $BoutiqueVideo_project_list=$('#BoutiqueVideo_project_list');
var fnUpdateProject=function(){
    var arr=[];
    var id;
    $project_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $BoutiqueVideo_project_list.val(we.implode(',', arr));
};

var fnDeleteProject=function(op){
    $(op).parent().remove();
    fnUpdateProject();
};

// 删除发布分类
var $publish_classify_box=$('#publish_classify_box');
var $BoutiqueVideo_publish_classify=$('#BoutiqueVideo_publish_classify');
var fnUpdatePublishClassify=function(){
    var arr=[];
    var id;
    $publish_classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $BoutiqueVideo_publish_classify.val(we.implode(',', arr));
};
var fnDeletePublishClassify=function(op){
    $(op).parent().remove();
    fnUpdatePublishClassify();
};

// 删除展示分类
var $classify_box=$('#classify_box');
var $BoutiqueVideo_video_classify=$('#BoutiqueVideo_video_classify');
var fnUpdateClassify=function(){
    var arr=[];
    var id;
    $classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $BoutiqueVideo_video_classify.val(we.implode(',', arr));
};
var fnDeleteClassify=function(op){
    $(op).parent().remove();
    fnUpdateClassify();
};

// 选择单位
$(function(){
	setInterval(function(){$.ajax({url:"<?php echo $this->createUrl('BoutiqueVideo/get_date');?>",type:'post'});}, 600000);
	$('#BoutiqueVideo_year').on('click', function(){
		WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy'});
	});
    // 添加项目
    var $project_add_btn=$('#project_add_btn');
    $project_add_btn.on('click', function(){
		var club_id=$('#BoutiqueVideo_club_id').val();
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project", array('project_type'=>1));?>&club_id='+club_id,{
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

    // 添加发布分类
    var $publish_classify_add_btn=$('#publish_classify_add_btn');
    $publish_classify_add_btn.on('click', function(){
        $.dialog.data('classify_id', 0);
        $.dialog.open('<?php echo $this->createUrl("classify", array('base_f_id'=>365));?>',{
            id:'xiangmu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('classify_id')>0){
                    if($('#publish_classify_item_'+$.dialog.data('classify_id')).length==0){
                       $publish_classify_box.html('<span class="label-box" id="publish_classify_item_'+$.dialog.data('classify_id')+'" data-id="'+$.dialog.data('classify_id')+'">'+$.dialog.data('classify_title')+'<i onclick="fnDeletePublishClassify(this);"></i></span>');
                       fnUpdatePublishClassify();
                    }
                }
            }
        });
    });
    // 添加展示分类
    var $classify_add_btn=$('#classify_add_btn');
    $classify_add_btn.on('click', function(){
        $.dialog.data('classify_id', 0);
        $.dialog.open('<?php echo $this->createUrl("classify", array('base_f_id'=>365));?>',{
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

    // 选择视频
    $('.video_select_btn').on('click', function(){
		var $_this=$(this);
        $.dialog.data('video_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/material", array("type"=>"253,254","club_id"=>get_SESSION("club_id")));?>',{
            id:'shipin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('material_id')>0){
					$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+$.dialog.data('material_id')+'" target="_blank" title="'+$.dialog.data('material_title')+'">'+$.dialog.data('material_title')+'</a></span>');
					$_this.parents('.up_btn').find('.input-text').eq(0).val($.dialog.data('material_id'));
					$_this.parents('.up_btn').find('.input-text').eq(1).val($.dialog.data('file_format'));
					$_this.parents('.up_btn').find('.input-text').eq(2).val($.dialog.data('duration'));
					$_this.parents('.up_btn').next('td').html($.dialog.data('file_format'));
					$_this.parents('.up_btn').next('td').next('td').html($.dialog.data('duration')+'分钟');
					fnUpdateProgram();
                }
            }
        });
    });
});

//显示时间开始时间
var fnStartTime=function(op){
	WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss',onpicked:function(dp){
		var star_time =$(op).val();
		var end_time =$('#BoutiqueVideo_video_end').val();
		if(end_time!='' && star_time>=end_time){
			we.msg('minus', '开始时间不能大于或等于结束时间');
			$(op).val('');
			return false;
		}

	}});
};
//显示时间结束时间
var fnEndTime=function(op){
	WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',realDateFmt:'yyyy-MM-dd HH:mm:ss',onpicked:function(dp){
		var end_time =$(op).val();
		var star_time =$('#BoutiqueVideo_video_start').val();
		if(star_time!='' && end_time<=star_time){
			we.msg('minus', '结束时间不能小于或等于开始时间');
			$(op).val('');
			return false;
		}

	}});
};
selectProjectIs($('input[type="radio"][name="BoutiqueVideo[project_is]"]:checked'));
function selectProjectIs(obj){
    var show_type=$(obj).val();
    if(show_type==649){
        $('#ProjectIs').show();
    } else{
        $('#ProjectIs').hide();
		$("#ProjectIs .label-box").remove();
		$("#BoutiqueVideo_project_list").val('');
    }
}
selectMember($('input[type="radio"][name="BoutiqueVideo[open_club_member]"]:checked'));
function selectMember(obj){
    var show_type=$(obj).val();
    if(show_type==210){
        $("#BoutiqueVideo_gf_price").attr("disabled",false).val("0.00");
        $("#gf_price").show();
    } else{
        $('#BoutiqueVideo_gf_price').val('');
        $("#BoutiqueVideo_gf_price").attr("disabled",true);
        $("#gf_price").hide();
    }
}


// 添加删除更新节目
var $program_list=$('#program_list');
var $VideoLive_programs_list=$('#BoutiqueVideo_programs_list');
var fnAddProgram=function(){
    var num=$program_list.attr('data-num')+1;
	var op='up'+new Date().getTime()+parseInt(Math.random()*100000);
	var html='<div id="uploadifive-upload_'+op+'" class="uploadifive-button" style="height: 24px; line-height: 24px; overflow: hidden; position: relative; text-align: center; width: 61px;">上传视频<input id="upload_'+op+'" type="file" accept="video/mp4,audio/mp3" style="font-size: 24px; opacity: 0; position: absolute; right: -3px; top: -3px; z-index: 999;"></div><div id="uploadifive-upload_'+op+'-queue" class="uploadifive-queue"></div>';
	var $video_series_title=$('<input class="input-text up_title" name="programs_list['+num+'][video_series_title]" style="width:80%;" onchange="fnUpdateProgram();">');
	var $txt=$('<td><input type="hidden" class="input-text" name="programs_list['+num+'][id]" value="null" /></td>').append($video_series_title);
	var $video_series_num=$('<td><input class="input-text up_title" name="programs_list['+num+'][video_series_num]" style="width:80%;" onchange="fnUpdateProgram();"></td>');
	var $content=$('<tr><td><span style="color:#7a7a7a">系统生成</span></td></tr>').append($txt).append($video_series_num).append('<td class="up_btn"><span class="fl"><div class="up_progress" style="width: 200px;height: 25px;line-height: 25px;background-color:#f7f7f7;box-shadow:inset 0 1px 2px rgba(0,0,0,0.1);border-radius:4px;background-image:linear-gradient(to bottom,#f5f5f5,#f9f9f9);display:none;"><div class="up_finish" style="width: 0%;background-color: #149bdf;background-image:linear-gradient(45deg,rgba(255,255,255,0.15) 25%,transparent 25%,transparent 50%,rgba(255,255,255,0.15) 50%,rgba(255,255,255,0.15) 75%,transparent 75%,transparent);background-size:40px 40px;height: 100%;color: #fff;text-align: right;padding-right: 5px;box-sizing: border-box;" progress="0"></div></div></span><span class="fl video_box"></span>'+
		'<div class="upload fl">'+html+'</div>'+
		'<input style="margin-left:5px;" class="btn fl video_select_btn" type="button" value="选择视频"><input type="hidden" class="input-text up_source" name="programs_list['+num+'][video_source_id]" value="null" /><input type="hidden" class="input-text" name="programs_list['+num+'][video_format]" /><input type="hidden" class="input-text" name="programs_list['+num+'][video_duration]" /></td>'+
        '<td></td>'+
        '<td></td>'+
        '<td style="text-align:left;"><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>');
    $program_list.append($content);
    $program_list.attr('data-num',num);
	fnUpdateProgram();
	var fileForm = document.getElementById('upload_'+op);
	var upload = new Upload();
	fileForm.onchange = function(){
        upload.addFileAndSend(this);
    }
	function Upload(){
        var xhr = new XMLHttpRequest();
        var form_data = new FormData();
        const LENGTH = 1024 * 1024 * 5;
        var start = 0;
        var end = start + LENGTH;
        var blob_num = 1;
        var is_stop = 0;
        var running=false;
		var filename='';
		var filetitle='';
		var res_json;
        //对外方法，传入文件对象
        this.addFileAndSend = function(that){
			$('#upload_'+op).parents('.up_btn').find(".up_progress").show();
			$('#upload_'+op).parents('.up_btn').find(".up_finish").html('0%');

			var file = that.files[0];
            var filename = file.name;
            var index = filename.lastIndexOf(".");
    		var suffix = filename.substr(index+1);
        	if(suffix=='mp4'||suffix=='mp3'){
	            //获取音频、视频时长
		        var url = URL.createObjectURL(file);
		        var audioElement = new Audio(url);
		    	var duration;
		        audioElement.addEventListener("loadedmetadata", function (_event) {
		            duration = Math.ceil(audioElement.duration);
		            doFileToMd5(file,duration);
		        });
        	}else{
	            doFileToMd5(file,0);
        	}
        }
        //停止文件上传
        this.stop = function(){
            xhr.abort();
            is_stop = 1;
        }

		//获取文件Md5
        function doFileToMd5(file,duration) {
            if (running) {
                return;
            }
            if (file.size==0) {
                return;
            }
            var blobSlice = File.prototype.slice || File.prototype.mozSlice || File.prototype.webkitSlice,
                chunkSize = 1024 * 1024 * 5,                           // read in chunks of 2MB
                chunks = Math.ceil(file.size / chunkSize),
                currentChunk = 0,
                spark = new SparkMD5.ArrayBuffer(),
                time,
                fileReader = new FileReader(),md5_str='';
            fileReader.onload = function (e) {
                spark.append(e.target.result);                 // append array buffer
                currentChunk += 1;
                if (currentChunk < chunks) {
                    loadNext();
                } else {
                    running = false;
                    md5_str=spark.end();
                    askSendFile(file,md5_str,duration);
                }
            };
            fileReader.onerror = function () {
                running = false;
            };
            function loadNext() {
                var start = currentChunk * chunkSize,
                    end = start + chunkSize >= file.size ? file.size : start + chunkSize;
                fileReader.readAsArrayBuffer(blobSlice.call(file, start, end));
            }
            running = true;
            time = new Date().getTime();
            loadNext();
        }

        //切割文件
        function cutFile(file){
            var file_blob = file.slice(start,end);
            start = end;
            end = start + LENGTH;
            return file_blob;
        };
		//请求发送文件
        function askSendFile(file,md5_str,duration){
			filetitle=file.name;
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: {action:'upload_ask',slen:file.size,segs:Math.ceil(file.size / LENGTH),file_md5:md5_str,fileName:file.name,duration:Math.ceil(duration),fileCode:fileCode.value},
				dataType: 'json',
				success: function (json) {
					res_json=json;
					var filename_arr=json.filename.split('/');
					filename=filename_arr[filename_arr.length-1]
                    if(json.code==0){
                        sendFile(cutFile(file),file,json.fileId);
                    }else if(json.error>0){
						askSendFile(file,md5_str,duration);
					}else{
						askSendFile(file,md5_str,duration);
					}
				}
			});
        }
        //发送文件
        function sendFile(blob,file,fileId){
			var total_blob_num = Math.ceil(file.size / LENGTH);
            form_data = new FormData();
            form_data.append('action','chunk_upload_file');
            form_data.append('file',blob);
            form_data.append('fileId',fileId);
            form_data.append('segno',blob_num);
            form_data.append('start',start-LENGTH);
			$.ajax({
				url: "/gw/chunk_upload.php",
				type: 'post',
				data: form_data,
				processData: false,
				contentType: false,
				dataType: 'json',
				success: function (json) {
					if(json.code==0){
                    	var progress;
		                var progressObj = $('#upload_'+op).parents('.up_btn').find(".up_finish").get(0);
		                if(total_blob_num == 1){
		                    progress = 100;
		                }else{
		                    progress = Math.min(100,(blob_num/total_blob_num)* 100 );
		                }
		                progressObj.style.width = progress+'%';
						$('#upload_'+op).parents('.up_btn').find(".up_finish").html(parseInt(progress));
		                var t = setTimeout(function(){
		                    if(start < file.size && is_stop === 0){
		                        sendFile(cutFile(file),file,fileId);
		                    }else{
		                        setTimeout(t);
		                    }
		                },500);
						if(progress == 100){
							var index = filetitle.lastIndexOf(".");
							var suffix = filetitle.substr(index+1);
							var v_type=253;
							if(suffix=="mp3"){
								v_type=254;
							}else if(suffix=="mp4"){
								v_type=253;
							}
							$.ajax({
								url: "<?php echo $this->createUrl('GfMaterial/saveMaterial');?>",
								type: 'post',
								data: {v_title:filetitle,v_type:v_type,v_name:res_json.filename,v_file_path:res_json.fileUrl,v_file_insert_size:sec_format(res_json.playtime_seconds)},
								dataType: 'json',
								success: function (d) {
									var $_this=$('#upload_'+op);
									$_this.parents('.up_btn').find(".up_progress").hide();
									$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+d.id+'" target="_blank" title="'+filetitle+'">'+filetitle+'</a></span>');
									$_this.parents('.up_btn').find('.input-text').eq(0).val(d.id);
									$_this.parents('.up_btn').find('.input-text').eq(1).val(d.file_format);
									$_this.parents('.up_btn').find('.input-text').eq(2).val(d.duration);
									$_this.parents('.up_btn').next('td').html(d.file_format);
									$_this.parents('.up_btn').next('td').next('td').html(d.duration+'分钟');
									fnUpdateProgram();
								}
							});
						}
                    }else if(json.error>0){
						sendFile(blob,file,fileId);
					}else{
		                sendFile(blob,file,fileId);
                    }
                    blob_num  += 1;
				}
			});
        }
    }

	// 选择视频
    $('.video_select_btn').on('click', function(){
		var $_this=$(this);
        $.dialog.data('video_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/material", array("type"=>"253,254","club_id"=>get_SESSION("club_id")));?>',{
            id:'shipin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('material_id')>0){
					$_this.parents('.up_btn').find(".video_box").html('<span class="label-box" style="max-width: 120px;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;word-break: keep-all;"><a href="../qmdd2018/index.php?r=gfMaterial/video_player&id='+$.dialog.data('material_id')+'" target="_blank" title="'+$.dialog.data('material_title')+'">'+$.dialog.data('material_title')+'</a></span>');
					$_this.parents('.up_btn').find('.input-text').eq(0).val($.dialog.data('material_id'));
					$_this.parents('.up_btn').find('.input-text').eq(1).val($.dialog.data('file_format'));
					$_this.parents('.up_btn').find('.input-text').eq(2).val($.dialog.data('duration'));
					$_this.parents('.up_btn').next('td').html($.dialog.data('file_format'));
					$_this.parents('.up_btn').next('td').next('td').html($.dialog.data('duration')+'分钟');
					fnUpdateProgram();
                }
            }
        });
    });
};

var fnDeleteProgram=function(op){
    $(op).parent().parent().remove();
    fnUpdateProgram();
};
var fnUpdateProgram=function(){
    var isEmpty=true;
    $program_list.find('.up_title').each(function(k){
        if($(this).val()==''){
            isEmpty=true;
			return false;
        } else{
			isEmpty=false;
        }
    });
	if(!isEmpty){
		$program_list.find('.up_source').each(function(){
			if($(this).val()=='null'){
				isEmpty=true;
				return false;
			} else{
				isEmpty=false;
			}
		});
	}
    if(!isEmpty){
        $VideoLive_programs_list.val('1').trigger('blur');
    }else{
        $VideoLive_programs_list.val('').trigger('blur');
    }
};
</script>