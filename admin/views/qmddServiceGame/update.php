<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>赛事服务资源详细</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr  class="table-title">
                	<td colspan="4">基本信息</td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'service_code'); ?></td>
                    <td><?php echo $model->service_code;?></td>
                    <td><?php echo $form->labelEx($model, 'club_id'); ?></td>
                    <td>
                        <span id="club_box"><?php if($model->club_id!=null){?><span class="label-box"><?php echo $model->club_name;?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text', 'value'=>get_session('club_id'))); ?></span><?php } ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'title'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'title', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'title', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'server_name'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'server_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'server_name', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'local_and_phone', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'local_and_phone', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'area'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'area', array('class' => 'input-text')); ?>
						<?php echo $form->hiddenField($model, 'longitude'); ?>
                        <?php echo $form->hiddenField($model, 'latitude'); ?>
                        <?php echo $form->hiddenField($model, 'area_country'); ?>
                        <?php echo $form->hiddenField($model, 'area_province'); ?>
                        <?php echo $form->hiddenField($model, 'area_city'); ?>
                        <?php echo $form->hiddenField($model, 'area_district'); ?>
                        <?php echo $form->hiddenField($model, 'area_township'); ?>
                        <?php echo $form->hiddenField($model, 'area_street'); ?>
                        <?php echo $form->error($model, 'area', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                    <td>
                    <?php $club_id=get_session('club_id');
					if(!empty($model->club_id)) {
						$club_id=$model->club_id;
					} ?>
                    <?php echo $form->dropDownList($model, 'project_id', Chtml::listData(ClubProject::model()->getClubProject2($club_id), 'project_id', 'project_name'), array('prompt'=>'请选择','onchange'=>'selectOnchang(this)')); ?>
                        <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                        <td><?php echo $form->labelEx($model, 'imgUrl'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'imgUrl', array('class' => 'input-text')); ?>
                            <?php $basepath=BasePath::model()->getPath(135);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->imgUrl!=''){?><div class="upload_img fl" id="upload_pic_QmddServiceGame_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->imgUrl;?>" width="100">
                                </a>
                            </div>
                            <?php } ?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_imgUrl','<?php echo $picprefix;?>');</script>
                            <span class="msg">注：图片格式530*530;文件大小≤2M；数量≤1张 </span>
                            <?php echo $form->error($model, 'imgUrl', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'service_pic_img'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'service_pic_img', array('class' => 'input-text')); ?>
                            <?php $basepath=BasePath::model()->getPath(226);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->service_pic_img!=''){?>
                                <div class="upload_img fl" id="upload_pic_QmddServiceGame_service_pic_img">
                                    <?php
                                    if(!empty($service_pic_img)) foreach($service_pic_img as $v) if($v) {?>
                                    <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>
                                    <?php }?>
                                </div>
                            <?php } ?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_service_pic_img','<?php echo $picprefix;?>','','',function(e1,e2){fnScrollpic(e1.savename,e1.allpath);},5);</script>
                            <span class="msg">注：图片格式1080*1080;文件大小≤2M；数量≤5张 </span>
                            <?php echo $form->error($model, 'service_pic_img', $htmlOptions = array()); ?>
                        </td>
                    </tr>
            </table>
            <table class="mt15">
            	<tr class="table-title">
                    <td colspan="4">赛事信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_contain'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'site_contain', array('class' => 'input-text', 'style'=>'width:40px;')); ?>
                        <span class="msg">人</span>
                        <?php echo $form->error($model, 'site_contain', $htmlOptions = array()); ?>
                    </td>
                    <?php $project=0;
					if(!empty($model->project_id)){
					$project=$model->project_id; }
					$arr=ProjectListGame::model()->getProjectGame_id2();?>
<script>
var $gameitem= <?php echo json_encode($arr)?>;
</script>
                    <td><?php echo $form->labelEx($model, 'game_item'); ?></td>
                    <td><?php $model->game_item=explode(',',$model->game_item); ?>
                        <?php echo $form->checkBoxList($model, 'game_item', Chtml::listData(ProjectListGame::model()->getItem($project), 'id', 'game_item'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                     </td>
                </tr>
            </table>
            <?php echo $form->hiddenField($model,'servic_person_ids')?>
            <table id="servant_box" class="mt15">
            	<tr class="table-title">
                   <td colspan="5">服务者信息<input id="servant_add_btn" class="btn" type="button" value="添加"></td>
                </tr>
                <tr>
                	<th style="text-align:center;">服务类别</th>
                    <th style="text-align:center;">服务编号</th>
                    <th style="text-align:center;">服务者姓名</th>
                    <th style="text-align:center;">服务者等级</th>
                    <th style="text-align:center;">操作</th>
                </tr>
                <?php

                        if(!empty($servant_list)) foreach($servant_list as $p){
                ?>
                <tr class="servant_item" id="servant_item_<?php echo $p->id;?>" data-id="<?php echo $p->id;?>">
                    <td><?php echo $p->type_name;?></td>
                    <td><?php echo $p->qualifications_person->qcode;?></td>
                    <td><?php echo $p->qualifications_person->qualification_name;?></td>
                    <td><?php echo $p->qualifications_person->qualification_level_name;?></td>
                    <td><a class="btn" href="<?php echo $this->createUrl('clubQualificationPerson/update',array('id'=>$p->qualification_person_id));?>" title="查看详情">查看详情</a>&nbsp;&nbsp;<a class="btn" onclick="fnDeleteServer(this);" title="删除">删除</a></td>
                </tr>
                <?php } ?>
            </table>
            <?php echo $form->hiddenField($model,'servic_site_ids')?>
            <table id="site_box" class="mt15">
            	<tr class="table-title">
                    <td colspan="4">场地信息<input id="site_add_btn" class="btn" type="button" value="添加"></td>
                </tr>
                <tr>
                    <th style="text-align:center;">服务编号</th>
                    <th style="text-align:center;">场地名称</th>
                    <th style="text-align:center;">场地等级</th>
                    <th style="text-align:center;">操作</th>
                </tr>
                <?php
                        if(!empty($site_list)) foreach($site_list as $s){
                ?>
                <tr class="site_item" id="site_item_<?php echo $s->id;?>" data-id="<?php echo $s->id;?>">
                    <td><?php echo $s->site_code;?></td>
                    <td><?php echo $s->site_name;?></td>
                    <td><?php echo $s->site_level_name;?></td>
                    <td><a class="btn" href="<?php echo $this->createUrl('qmddGfSite/update',array('id'=>$s->id));?>" title="查看详情">查看详情</a>&nbsp;&nbsp;<a class="btn" onclick="fnDeleteSite(this);" title="删除">删除</a></td>
                </tr>
                <?php }?>
            </table>
            <div class="mt15" style="text-align:center;">
        <?php
		$club=0;
		if(get_session('club_id')==$model->club_id || empty($model->club_id)){
			$club=1;
		}
		 if(!empty($model->state)){
			$state=$model->state;
		} else {
			$state=721;
		}?>
            <?php if($state<>371 && $club==1) echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
            <?php if($state==371) { ?><button onclick="submitType='baocun'" class="btn" type="submit">撤销审核</button><?php } ?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
        // 选择服务地区
        var $QmddServiceGame_area=$('#QmddServiceGame_area');
        $QmddServiceGame_area.on('click', function(){
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
                        $QmddServiceGame_area.val($.dialog.data('maparea_address'));
                        $('#QmddServiceGame_longitude').val($.dialog.data('maparea_lng'));
                        $('#QmddServiceGame_latitude').val($.dialog.data('maparea_lat'));
						$('#QmddServiceGame_area_country').val($.dialog.data('country'));
						$('#QmddServiceGame_area_province').val($.dialog.data('province'));
						$('#QmddServiceGame_area_city').val($.dialog.data('city'));
						$('#QmddServiceGame_area_district').val($.dialog.data('district'));
						$('#QmddServiceGame_area_township').val($.dialog.data('township'));
						$('#QmddServiceGame_area_street').val($.dialog.data('street'));
                    }
                }
            });
        });

    // 滚动图片处理
    var $service_pic_img=$('#QmddServiceGame_service_pic_img');
    var $upload_pic_service_pic_img=$('#upload_pic_QmddServiceGame_service_pic_img');
    var $upload_box_service_pic_img=$('#upload_box_QmddServiceGame_service_pic_img');
    // 添加或删除时，更新图片
    var fnUpdateScrollpic=function(){
        var arr=[];
        $upload_pic_service_pic_img.find('a').each(function(){
            arr.push($(this).attr('data-savepath'));
        });
        $service_pic_img.val(we.implode(',',arr));
        var as=$service_pic_img.val(we.implode(',',arr));
        $upload_box_service_pic_img.show();
        if(arr.length>=5) {
            $upload_box_service_pic_img.hide();
        }
    }

    // 上传完成时图片处理
    var fnScrollpic=function(savename,allpath){
        $upload_pic_service_pic_img.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
        fnUpdateScrollpic();
    };


    // 删除已添加服务者
    function fnDeleteServer(event){
        $(event).parent().parent().remove();
        fnUpdateClub();
    };

    // 服务者更新、删除
    var $servant_box=$('#servant_box');
    var $QmddServiceGame_servic_person_ids=$('#QmddServiceGame_servic_person_ids');
    function fnUpdateClub(){
        var arr=[];
        $servant_box.find('.servant_item').each(function(){
            arr.push($(this).attr('data-id'));
        });
        $QmddServiceGame_servic_person_ids.val(we.implode(',', arr));
    };
    // 添加服务者
    var $servant_box=$('#servant_box');
    $('#servant_add_btn').on('click', function(){
        var club_id=$('#QmddServiceGame_club_id').val();
		var project_id=$('#QmddServiceGame_project_id').val();
        $.dialog.data('person_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/servant");?>&club_id='+club_id+'&project_id='+project_id,{
            id:'fuwuzhe',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data('person_id')>0){
                    if($('#servant_item_'+$.dialog.data('person_id')).length==0){
                        $servant_box.append(
                            '<tr class="servant_item" id="servant_item_'+$.dialog.data('person_id')+'" data-id="'+$.dialog.data('person_id')+'">'+
                                '<td>'+$.dialog.data('servant_type')+'</td><td>'+$.dialog.data('servant_code')+'</td>'+
                                '<td>'+$.dialog.data('servant_name')+'</td><td>'+$.dialog.data('servant_level')+'</td>'+
                                '<td><a class="btn" href="<?php echo $this->createUrl('update');?>"id='+$.dialog.data('person_id')+'" title="查看详情">查看详情</a>&nbsp;&nbsp;<a class="btn" onclick="fnDeleteServer(this);" title="删除">删除</a></td></tr>');
                        fnUpdateClub();
                    }
                }
            }
        });
    });

    // 删除已添加场地
    function fnDeleteSite(event){
        $(event).parent().parent().remove();
        fnUpdateSite();
    };
    // 场地更新、删除
    var $site_box=$('#site_box');
    var $QmddServiceGame_servic_site_ids=$('#QmddServiceGame_servic_site_ids');
    function fnUpdateSite(){
        var arr=[];
		var site_id=0;
        $site_box.find('.site_item').each(function(){
            arr.push($(this).attr('data-id'));
        });
        $QmddServiceGame_servic_site_ids.val(we.implode(',', arr));
		site_id=arr[0];
		//console.log(arr[0]);
		if(site_id>0){
			//console.log('tre=='+site_id);
			$.ajax({
			type: 'post',
			url: '<?php echo $this->createUrl('site_address');?>&site_id='+site_id,
			data: {site_id:site_id},
			dataType: 'json',
			success: function(data) {
				if(data!=''){
					//console.log('tre=1='+data.site_address);
					$('#QmddServiceGame_area').val(data.site_address);
					$('#QmddServiceGame_longitude').val(data.longitude);
					$('#QmddServiceGame_latitude').val(data.latitude);
					$('#QmddServiceGame_area_country').val(data.area_country);
					$('#QmddServiceGame_area_province').val(data.area_province);
					$('#QmddServiceGame_area_city').val(data.area_city);
					$('#QmddServiceGame_area_district').val(data.area_district);
					$('#QmddServiceGame_area_township').val(data.area_township);
					$('#QmddServiceGame_area_street').val(data.area_street);

				}else{
					//$('#QmddGfSite_site_id').val('');
					we.msg('minus', '抱歉，没有获取到场地的地址');
				}
			}
		});
		}
    };
    // 添加场地
    $('#site_add_btn').on('click', function(){
		var club_id=$('#QmddServiceGame_club_id').val();
        var project_id=$('#QmddServiceGame_project_id').val();
		$.dialog.data('site_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/qmddgfSite");?>'+'&club_id='+club_id+'&project_id='+project_id,{
            id:'changdi',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'80%',
            height:'80%',
            close: function () {
                if($.dialog.data("site_id")>0){
                    if($('#site_item_'+$.dialog.data("site_id")).length==0){
						s_html='';
						s_html='<tr class="site_item" id="site_item_'+$.dialog.data("site_id")+'" data-id="'+$.dialog.data("site_id")+'">'+
                                '<td>'+$.dialog.data("site_code")+'</td>'+
                                '<td>'+$.dialog.data("site_name")+'</td>'+
                                '<td>'+$.dialog.data("site_level")+'</td>'+
                                '<td><a class="btn" href="id='+$.dialog.data('site_id')+'" title="查看详情">查看详情</a>&nbsp;&nbsp;<a class="btn" onclick="fnDeleteSite(this);" title="删除">删除</a></td></tr>';
                        $('#site_box').append(s_html);
                        fnUpdateSite();
                    }
                }
            }
        });
    });

function selectOnchang(obj){
  var show_id=$(obj).val();
  var  p_html ='';
  if (show_id>0) {
    //'partnership_type
     for (j=0;j<$gameitem.length;j++)
        if($gameitem[j]['project_id']==show_id)
       {
        p_html = p_html +'<span class="check"><input class="input-check" id="QmddServiceGame_game_item_'+j+'" value="'+$gameitem[j]['id']+'" type="checkbox" name="QmddServiceGame[game_item][]"><label for="QmddServiceGame_game_item_'+j+'">'+$gameitem[j]['game_item']+'</label></span>';
      }
    }
   $("#QmddServiceGame_game_item").html(p_html);
}

</script>