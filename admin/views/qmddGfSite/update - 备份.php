<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》资源登记》场地登记》<a class="nav-a"><?php echo (empty($model->id)) ? '添加' : '详情'; ?></a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-detail-bd">
        <div style="display:block;" class="box-detail-tab-item">
        <?php echo $form->hiddenField($model, 'user_club_id', array('value'=>get_session('club_id'))); ?>
        <table class="table-title">
            <tr>
                <td colspan="8">场馆信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td><?php echo $form->labelEx($model, 'site_id'); ?></td>
                <td><?php echo $form->hiddenField($model, 'site_id', array('class' => 'input-text','onchange'=>'selectOnchang();')); ?>
                    <span id="site_box"><?php if(!empty($model->site)) { ?><span class="label-box"><?php echo $model->site->site_name;?></span><?php } ?></span>
                    <input id="site_select_btn" class="btn" type="button" value="请选择">
                    <?php echo $form->error($model, 'site_id', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'site_address'); ?></td>
                <!-- <td><span id="site_address"><?php // echo $model->site_address; ?></span></td> -->
                <td id="site_address"><?php echo $model->site_address; ?></td>
                <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                <td id="contact_phone"><?php echo $model->contact_phone; ?></td>
                <td><?php echo $form->labelEx($model, 'user_club_name'); ?></td>
                <td>
                    <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'user_club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'user_club_id', array('class' => 'input-text', 'value'=>get_session('club_id'))); ?></span><?php } ?></span>
                </td>
            </tr>
        </table>
        <table class="table-title" style="margin-top: -1px;">
            <tr>
                <td colspan="8"><span style="float: left; display: block; width: 95%;">登记场地</span><span style="margin-left: 20px;"><a class="btn" href="javascript:;" onclick="fnAddSite();" title="单击添加一行">添加</a></span></td>
            </tr>
        </table>
        <table style="margin-top: -1px;">
            <?php echo $form->hiddenField($model, 'sites_list'); ?>
            <tr>
                <td style="background-color: #efefef;"><?php echo $form->labelEx($model, 'site_code'); ?></td>
                <td style="background-color: #efefef;"><?php echo $form->labelEx($model, 'site_name'); ?></td>
                <td style="background-color: #efefef;"><?php echo $form->labelEx($model, 'site_type'); ?></td>
                <td style="background-color: #efefef;"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                <td style="background-color: #efefef;"><?php echo $form->labelEx($model, 'site_parent'); ?></td>
                <td style="background-color: #efefef;"><?php echo $form->labelEx($model, 'site_pic'); ?></td>
                <td style="background-color: #efefef;" colspan="2">操作</td>
            </tr>
            <?php if(!empty($sites)){?>
                <?php foreach($sites as $v){?>
                    <tr>
                        <td><?php echo $v->site_code;?></td>
                        <td><input type="hidden" class="input-text" name="sites_list[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" />
                        <input onchange="fnUpdateSite();" class="input-text" name="sites_list[<?php echo $v->id;?>][site_name]" value="<?php echo $v->site_name;?>"></td>
                        <td><input onchange="fnUpdateSite();" class="input-text" name="sites_list[<?php echo $v->id;?>][site_type]" value="<?php echo $v->site_type;?>"></td>
                        <td><input onchange="fnUpdateSite();" class="input-text" name="sites_list[<?php echo $v->id;?>][project_id]" value="<?php echo $v->project_id;?>"></td>
                        <td><input onchange="fnUpdateSite();" class="input-text" name="sites_list[<?php echo $v->id;?>][site_parent]" value="<?php echo $v->site_parent;?>"></td>
                        <td><input onchange="fnUpdateSite();" class="input-text" name="sites_list[<?php echo $v->id;?>][site_pic]" value="<?php echo $v->site_pic;?>"></td>
                        <td style="text-align:left;"><input onclick="fnAddSite();" class="btn" type="button" value="添加行">&nbsp;<input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
                    </tr>
                <?php }?>
            <?php }else{?>
                <tr>
                    <td></td>
                    <td>
                        <input type="hidden" class="input-text" name="sites_list[new][id]" value="null" />
                        <!-- <input onchange="fnUpdateSite();" class="input-text" name="sites_list[new][site_name]"> -->
                        <?php echo $form->textField($model, 'site_name', array('class' => 'input-text', 'onchange' => 'fnUpdateSite();', 'name' => 'sites_list[new][site_name]')); ?>
                        <?php echo $form->error($model, 'site_name', $htmlOptions = array()); ?>
                    </td>
                    <td>
                        <?php echo $form->dropDownList($model, 'site_type', Chtml::listData(BaseCode::model()->getCode(1517), 'f_id', 'F_NAME'), array('prompt'=>'请选择', 'onchange' => 'fnUpdateSite();', 'name' => 'sites_list[new][site_type]')); ?>
                        <?php echo $form->error($model, 'site_type', $htmlOptions = array()); ?>
                    </td>
                    <!-- 无法获取 -->
                    <td>
                        <?php //echo $form->checkBoxList($model, 'project_id', Chtml::listData($project, 'id', 'project_name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'onchange' => 'fnUpdateSite();', 'name' => 'sites_list[new][project_id]', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php //echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        <?php echo $form->checkBoxList($model, 'project_id', Chtml::listData($project, 'id', 'project_name'), $htmlOptions = array('onchange' => 'fnUpdateSite();', 'separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                    </td>
                    <!-- 无法获取 -->
                    <td>
                        <?php echo $form->hiddenField($model, 'site_parent', array('class' => 'input-text')); ?>
                        <span id="parent_box">
                            <?php if(!empty($parent)) foreach($parent as $v) {
                                echo '<span class="label-box" onchange="fnUpdateSite();" name="sites_list[new][site_parent]" id="parent_item_<?php echo $v->id?>" data-id="<?php echo $v->id?>"><?php echo $v->site_name;?><i onclick="fnDeleteProject(this);"></i></span>';
                            } ?>
                        </span>
                        <input id="parent_select_btn" class="btn" type="button" value="请选择">
                        <?php echo $form->error($model, 'site_parent', $htmlOptions = array()); ?>
                    </td>
                    <td>
                        <?php $basepath=BasePath::model()->getPath(170);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php echo $form->hiddenField($model, 'site_pic', array('class' => 'input-text fl')); ?>
                        <?php if($model->site_pic!=''){?>
                            <div class="upload_img fl" id="upload_pic_qmddGfSite_site_pic" name="sites_list[new][site_pic]" onchange="fnUpdateSite();">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" width="100">
                                </a>
                            </div>
                        <?php }?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_site_pic','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'site_pic', $htmlOptions = array()); ?>
                    </td>
                    <td colspan="2"><input onclick="fnAddSite();" class="btn" type="button" value="添加行"><input onclick="fnDeleteSite(this);" class="btn" type="button" value="删除"></td>
                </tr>
            <?php }?>
            <?php echo $form->error($model, 'sites_list', $htmlOptions = array()); ?>
        </table>




        <!-- <table class="table-title">
            <tr>
                <td colspan="4">场地资源信息</td>
            </tr>
        </table> -->
<?php // echo $form->hiddenField($model, 'user_club_id', array('value'=>get_session('club_id'))); ?>
        <!-- <table>
            <tr>
                <td width="15%"><?php // echo $form->labelEx($model, 'site_code'); ?></td>
                <td width="35%"><?php // echo $model->site_code;?></td>
            	<td width="15%"><?php // echo $form->labelEx($model, 'site_id'); ?></td>
                <td width="35%"><?php // echo $form->hiddenField($model, 'site_id', array('class' => 'input-text','onchange'=>'selectOnchang();')); ?>
                    <span id="site_box"><?php // if(!empty($model->site)) { ?><span class="label-box"><?php // echo $model->site->site_name;?></span><?php // } ?></span>
                    <input id="site_select_btn" class="btn" type="button" value="选择">
                    <?php // echo $form->error($model, 'site_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php // echo $form->labelEx($model, 'site_name'); ?></td>
                <td>
                    <?php // echo $form->textField($model, 'site_name', array('class' => 'input-text')); ?>
                    <?php // echo $form->error($model, 'site_name', $htmlOptions = array()); ?>
                </td>
                <td><?php // echo $form->labelEx($model, 'site_address'); ?></td>
                <td id="site_address"><?php // echo $model->site_address; ?></td>
            </tr>
            <tr>
                <td><?php // echo $form->labelEx($model, 'project_id'); ?></td>
                <td>
                    <?php // echo $form->checkBoxList($model, 'project_id', Chtml::listData($project, 'id', 'project_name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php // echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                </td>
                <td><?php // echo $form->labelEx($model, 'site_location'); ?></td>
                <td id="site_location"><?php // echo $model->site_location; ?></td>
            </tr>
            <tr>
                <td><?php // echo $form->labelEx($model, 'site_type'); ?></td>
                <td>
                    <?php // echo $form->dropDownList($model, 'site_type', Chtml::listData(BaseCode::model()->getCode(1517), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    <?php // echo $form->error($model, 'site_type', $htmlOptions = array()); ?>
                </td>
                <td><?php // echo $form->labelEx($model, 'site_parent'); ?></td>
                <td><?php // echo $form->hiddenField($model, 'site_parent', array('class' => 'input-text')); ?>
                    <span id="parent_box">
                        <?php // if(!empty($parent)) foreach($parent as $v){?>
                            <span class="label-box" id="parent_item_<?php // echo $v->id?>" data-id="<?php // echo $v->id?>"><?php // echo $v->site_name;?><i onclick="fnDeleteProject(this);"></i></span>
                        <?php // }?>
                    </span>
                    <input id="parent_select_btn" class="btn" type="button" value="选择">
                    <?php // echo $form->error($model, 'site_parent', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table> -->
        <table style="margin-top: -1px;">
<?php //if(!empty($model->site_state)) { ?>
<?php if(!empty($model->id)) { ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'site_state'); ?></td>
                <td colspan="7"><?php echo $model->site_state_name; ?></td>
            </tr>
<?php } ?>
<?php if($model->site_state==1538){ ?>
            <tr>
                <td><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                <td colspan="7">
                    <?php echo $model->reasons_failure; ?>
                    <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                </td>
            </tr>
<?php } ?>
            <tr>
                <td style="background-color: #efefef;">操作</td>
                <td colspan="7">
<?php if(empty($model->id) || $model->site_state==721) { ?>
                    <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
<?php } ?>
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                </td>
            </tr>
        </table>
        </div>
    <div class="mt15">
    <p>注：关联资源：即登记时可选择与之存在关联关系的其他登记资源（可关联单个或多个资源）。设置关联后，当服务被预定时，登记资源或关联资源的某一个时段被预定的，同一时段的其他关联资源则被视为存在冲突，而不可被预定。</p>
    <p>如：登记A全场时，选择关联资源有A1半场、A2半场，那么：当用户预订A半场时，同一时段的A1半场、A2半场则不能再预订；当用户预订了A1半场，那同一时间的A全场也不能预订。</p>

    </div>
    </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
</script>
<script>
var club_id=<?php echo get_session('club_id'); ?>;
// 删除已添加场地
    var fnDeleteProject=function(op){
        $(op).parent().remove();
        fnUpdateProject();
    };
    // 场地添加或删除时，更新
    var fnUpdateProject=function(){
        var arr=[];
        $('#parent_box span').each(function(){
            arr.push($(this).attr('data-id'));
        });
        $('#QmddGfSite_site_parent').val(we.implode(',',arr));
    };
    fnUpdateProject();
	// 选择场馆
    var $site_box=$('#site_box');
    $('#site_select_btn').on('click', function(){
		if(club_id==''){
			we.msg('minus', '抱歉，系统没有获取到发布单位');
			return false;
		}
        $.dialog.data('site_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfsite");?>&club_id='+club_id,{
        id:'changguan',
		lock:true,opacity:0.3,
		width:'80%',
		height:'80%',
        title:'场馆选择',
        close: function () {
            //console.log($.dialog.data('club_id'));
            if($.dialog.data('site_id')>0){
				$('#QmddGfSite_site_id').val($.dialog.data('site_id'));
                $site_box.html('<span class="label-box">'+$.dialog.data('site_name')+'</span>');
                //$('#QmddGfSite_site_parent').val('');
                $('#parent_box').html('');
				$('#QmddGfSite_site_id').change();
            }
         }
       });
    });
    // 选择场地
    $('#parent_select_btn').on('click', function(){
        var site_id=$('#QmddGfSite_site_id').val();
        if(club_id==''){
            we.msg('minus', '抱歉，系统没有获取到发布单位');
            return false;
        }
        if(site_id==''){
            we.msg('minus', '请先选择所属场馆');
            return false;
        }
        $.dialog.data('site_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/qmddgfsite");?>&club_id='+club_id+'&site_id='+site_id,{
        id:'changdi',
        lock:true,opacity:0.3,
        width:'80%',
        height:'80%',
        title:'关联资源选择',
        close: function () {
            if($.dialog.data('site_id')==-1){
                var boxnum=$.dialog.data('qmddsite');
                for(var j=0;j<boxnum.length;j++) {
                    if($('#parent_item_'+boxnum[j].dataset.id).length==0){
                        var s1='<span class="label-box" id="parent_item_'+boxnum[j].dataset.id;
                        s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                        $('#parent_box').append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                        fnUpdateProject();
                    }
                }
            }
         }
       });
    });


function selectOnchang(){
  var site_id=$('#QmddGfSite_site_id').val();
  html_p='';
  html_pid='';
  html_img='';
  if (site_id>0) {
	  $.ajax({
		type: 'post',
		url: '<?php echo $this->createUrl('select_site');?>&site_id='+site_id,
		data: {site_id:site_id},
		dataType: 'json',
		success: function(data) {
			if(data!=''){
                //console.log(data.site_name);
				//$('#QmddGfSite_site_name').val(data.site_name);
                //$('#area_province').html(data.area_province);
                $('#site_address').html(data.site_address);
                $('#site_location').html(data.site_location);
                $('#contact_phone').html(data.contact_phone);
				for(i=0;i<data.project.length;i++){
                    // html_pid=html_pid+'<span class="check"><input onchange="fnUpdateSite();" class="input-check" id="QmddGfSite_project_id_'+i+'" value="'+data.project[i]['project_id']+'" type="checkbox" name="QmddGfSite[project_id][]"><label for="QmddGfSite_project_id_'+i+'">'+data.project[i]['project_name']+'</label></span>';
                    html_pid=html_pid+'<span class="check"><input onchange="fnUpdateSite();" class="input-check" id="QmddGfSite_project_id_'+i+'" value="'+data.project[i]['project_id']+'" type="checkbox" name="sites_list[new][project_id]"><label for="QmddGfSite_project_id_'+i+'">'+data.project[i]['project_name']+'</label></span>';
                }
				$('#QmddGfSite_project_id').html(html_pid);
			}else{
				$('#QmddGfSite_site_id').val('');
				we.msg('minus', '抱歉，没有获取到该场地的信息');
			}
		}
	});

  }
}


    // 多图片对应单个字段处理
    var $site_prove=$('#QmddGfSite_site_prove');
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
    $('#QmddGfSite_site_address').on('click', function(){
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
                    $('#QmddGfSite_site_address').val($.dialog.data('maparea_address'));
					$('#QmddGfSite_area_country').val($.dialog.data('country'));
					$('#QmddGfSite_area_province').val($.dialog.data('province'));
					$('#QmddGfSite_area_city').val($.dialog.data('city'));
					$('#QmddGfSite_area_district').val($.dialog.data('district'));
					$('#QmddGfSite_area_township').val($.dialog.data('township'));
					$('#QmddGfSite_area_street').val($.dialog.data('street'));
                    $('#QmddGfSite_site_longitude').val($.dialog.data('maparea_lng'));
                    $('#QmddGfSite_site_latitude').val($.dialog.data('maparea_lat'));
                }
            }
        });
    });

    // 添加/更新/删除场地
    var $site_list=$('#site_list');
    var $QmddGfSite_sites_list=$('#QmddGfSite_sites_list');
    var fnAddSite=function(){
        // alert('it work');
        var num=$site_list.attr('data-num')+1;
        $site_list.append('<tr><td></td>'+
            '<td><input type="hidden" class="input-text" name="sites_list['+num+'][id]" value="null" /><input onchange="fuUpdateSite();" class="input-text" name="sites_list['+num+'][site_name]"></td>'+

            '<td><input onchange="fuUpdateSite();" class="input-text" name="sites_list['+num+'][site_type]"></td>'+

            '<td><input onchange="fuUpdateSite();" class="input-text" name="sites_list['+num+'][project_id]"></td>'+

            '<td><input onchange="fuUpdateSite();" class="input-text" name="sites_list['+num+'][site_parent]"></td>'+

            '<td><input onchange="fuUpdateSite();" class="input-text" name="sites_list['+num+'][site_pic]"></td>'+

            '<td colspan="2"><input onclick="fnDeleteSite(this);" class="btn" type="button" value="删除"></td>'+

            '</tr>');
        $site_list.attr('data-num',num);
    }
    function fnUpdateSite() {
        // alert('it work');
        var isEmpty=true;
        flag=0;
        $site_list.find('.input-text').each(function(){
            if($(this).val()!=''){
                isEmpty=false;
                //return false;
            } else{
                flag++;
            }
        });
        if(!isEmpty){
            $QmddGfSite_sites_list.val('1').trigger('blur');
        }else{
            $QmddGfSite_sites_list.val('').trigger('blur');
        }
    }
    function fnDleeteSite() {
        // alert('it work');
        $(op).parent().parent().remove();
        fnUpdateSite();
    }

</script>