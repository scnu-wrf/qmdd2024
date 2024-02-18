<?php
    $level = array(281=>'☆',282=>'☆☆',283=>'☆☆☆',284=>'☆☆☆☆',285=>'☆☆☆☆☆');
    // $txt;
    // if (!empty($model->$id)) {
    //     $txt = "详情";
    // }else{
    //     $txt = "添加";
    // }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约》资源登记》场馆登记》<a class="nav-a"><?php echo (empty($model->id)) ? '添加' : '详情'; ?></a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-bd">
            <!-- <div style="display:block;" class="box-detail-tab-item"> -->
            <table>
                <tr class="table-title">
                    <td colspan="4">场馆信息</td>
                </tr>
            </table>
            <table style="margin-top: -1px;">
                <tr>
                	<td style="width: 15%;"><?php echo $form->labelEx($model, 'site_code'); ?></td>
                    <td style="width: 35%;"><?php echo $model->site_code;?></td>
                    <td style="width: 15%;"><?php echo $form->labelEx($model, 'user_club_id'); ?></td>
                    <td style="width: 35%;">
                        <span id="club_box"><?php if($model->club_list!=null){?><span class="label-box"><?php echo $model->club_list->club_name;?><?php echo $form->hiddenField($model, 'user_club_id', array('class' => 'input-text')); ?></span><?php } else {?><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'user_club_id', array('class' => 'input-text', 'value'=>get_session('club_id'))); ?></span><?php } ?></span>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_name'); ?></td>
                    <td>
						<?php echo $form->textField($model, 'site_name', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'site_name', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_envir'); ?></td>
                    <td>
                    <?php echo $form->checkBoxList($model, 'site_envir', Chtml::listData(BaseCode::model()->getCode(667), 'f_id', 'F_NAME'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                    <?php echo $form->error($model, 'site_envir', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'area_province'); ?></td>
                    <td>
                        <?php echo $form->dropDownList($model, 'area_province', Chtml::listData(TRegion::model()->getProvinceCode(), 'region_name_c', 'region_name_c'), array('prompt'=>'请选择','onchange'=>'selectchange(this,"city",1)')); ?>
                        <?php echo $form->error($model, 'area_province', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_address'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'site_address', array('class' => 'input-text')); ?>
                        <?php echo $form->error($model, 'site_address', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'contact_phone', array('class' => 'input-text','maxlength'=>11)); ?>
                        <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_location'); ?></td>
                    <td>
                        <?php echo $form->textField($model, 'site_location', array('class' => 'input-text')); ?>
                        <?php echo $form->hiddenField($model, 'site_longitude'); ?>
                        <?php echo $form->hiddenField($model, 'site_latitude'); ?>
                        <?php echo $form->hiddenField($model, 'area_country'); ?>
                        <?php // echo $form->hiddenField($model, 'area_province'); ?>
                        <?php echo $form->hiddenField($model, 'area_city'); ?>
                        <?php echo $form->hiddenField($model, 'area_district'); ?>
                        <?php echo $form->hiddenField($model, 'area_township'); ?>
                        <?php echo $form->hiddenField($model, 'area_street'); ?>
                        <?php echo $form->error($model, 'site_location', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
                        <span id="project_box">
                            <?php if(!empty($project_list)){ foreach($project_list as $v){?>
                                <span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>"><?php echo $v->project_list->project_name;?><i onclick="fnDeleteProject(this);"></i></span>
                            <?php }}?>
                        </span>
                        <input id="project_add_btn" class="btn" type="button" value="选择项目">
                        <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'site_origin'); ?></td>
                    <td>
                        <?php echo $form->dropDownList($model, 'site_origin', Chtml::listData(BaseCode::model()->getCode(1526), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        <?php echo $form->error($model, 'site_origin', $htmlOptions = array()); ?>
                    </td>
                <?php $basepath=BasePath::model()->getPath(170);$picprefix=''; if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <td><?php echo $form->labelEx($model, 'site_prove'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'site_prove', array('class' => 'input-text')); ?>
                        <div class="upload_img fl" id="upload_pic_site_prove">
                            <?php
                            foreach($site_prove as $v) if($v) {?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateProvepic();return false;"></i></a>
                            <?php }?>
                        </div>
                        <script>we.uploadpic('<?php echo get_class($model);?>_site_prove','<?php echo $picprefix;?>','','',function(e1,e2){fnProvepic(e1.savename,e1.allpath);},50);</script>
                        <?php echo $form->error($model, 'site_prove', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'site_pic'); ?></td>
                    <td>
						<?php echo $form->hiddenField($model, 'site_pic', array('class' => 'input-text fl')); ?>

                        <?php if($model->site_pic!=''){?>
                      <div class="upload_img fl" id="upload_pic_GfSite_site_pic">
                         <a href="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" target="_blank">
                         <img src="<?php echo $basepath->F_WWWPATH.$model->site_pic;?>" width="100"></a></div>
                         <?php }?>
                      <script>we.uploadpic('<?php echo get_class($model);?>_site_pic','<?php echo $picprefix;?>');</script>
                        <?php echo $form->error($model, 'site_pic', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'site_scroll'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'site_scroll', array('class' => 'input-text')); ?>
                        <div class="upload_img fl" id="upload_pic_site_scroll">
                            <?php
                            foreach($site_scroll as $v) if($v) {?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>
                            <?php }?>
                        </div>
                        <script>we.uploadpic('<?php echo get_class($model);?>_site_scroll','<?php echo $picprefix;?>','','',function(e1,e2){fnScrollpic(e1.savename,e1.allpath);},50);</script>
                        <?php echo $form->error($model, 'site_scroll', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr class="table-title">
                    <td colspan="4">场馆配套及等级评定（<?php if(!empty($model->site_level)) echo $level[$model->site_level]; ?><?php echo $model->site_level_name; ?>）</td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'site_facilities'); ?></td>
                    <td colspan="3">
                    <?php echo $form->checkBoxList($model, 'site_facilities', Chtml::listData($site_facilities, 'id', 'item_name'),
                              $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?>
                    </td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'facilities_pic'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'facilities_pic', array('class' => 'input-text')); ?>
                        <div class="upload_img fl" id="upload_pic_facilities_pic">
                            <?php
                            foreach($facilities_pic as $v) if($v) {?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"><i onclick="$(this).parent().remove();fnUpdateFacilitiespic();return false;"></i></a>
                            <?php }?>
                        </div>
                        <script>we.uploadpic('<?php echo get_class($model);?>_facilities_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnFacilitiespic(e1.savename,e1.allpath);},50);</script>
                        <?php echo $form->error($model, 'facilities_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table style="margin-top: -1px;">
                <tr class="table-title">
                    <td><span style="float: left; width: 95%;">场馆介绍</span><span><a style="margin-left: 20px;" class="btn" href="" onclick="">编辑</a></span></td>
                </tr>
                <tr><td><?php echo $model->site_description_temp;?></td></tr>
                <tr>
                    <td>
                         <?php echo $form->hiddenField($model, 'site_description_temp', array('class' => 'input-text')); ?>
                         <p style="text-align: right; margin-right: 10px;">功能完善后删除此框</p>
                         <div id="des_box">
                        <script>we.editor('<?php echo get_class($model);?>_site_description_temp', '<?php echo get_class($model);?>[site_description_temp]');</script>
                        </div>
                        <?php echo $form->error($model, 'site_description_temp', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
<?php // if($model->site_state!=1538){ ?>
            <!-- <table class="mt15">
                <tr>
                    <td width="15%">可执行操作</td>
                    <td>
                        <?php // echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <button class="btn btn-blue" type="button" onclick="we.next(1);">下一步</button>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table> -->
<?php // } ?>
            <!-- </div> -->
            <!-- <div style="display:none;" class="box-detail-tab-item"> -->
            <!-- <table>
                <tr class="table-title">
                    <td><?php // echo $form->labelEx($model, 'site_description'); ?></td>
                </tr>
                <tr>
                    <td>
                         <?php // echo $form->hiddenField($model, 'site_description_temp', array('class' => 'input-text')); ?>
                         <div id="des_box">
                        <script>we.editor('<?php // echo get_class($model);?>_site_description_temp', '<?php // echo get_class($model);?>[site_description_temp]');</script>
                        </div>
                        <?php // echo $form->error($model, 'site_description_temp', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table> -->
<?php // if($model->site_state!=1538){ ?>
            <!-- <table class="mt15">
                <tr>
                    <td width="15%">可执行操作</td>
                    <td>
                        <?php // echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table> -->
<?php // } ?>
        <!-- </div> -->
        <table style="margin-top: -1px;">
            <?php if(!empty($model->id)) { ?>
            <tr>
                <td width='15%'><?php echo $form->labelEx($model, 'site_state'); ?></td>
                <td><?php echo $model->site_state_name; ?></td>
            </tr>
            <?php } ?>
            <?php if($model->site_state!=721 && $model->site_state!=371 && !empty($model->id)) { ?>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model,'reasons_failure'); ?></td>
                    <td><?php echo $model->reasons_failure; ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td width="15%">操作</td>
                <td>
                    <?php
                        if($model->site_state==721 || empty($model->id)) {
                            echo show_shenhe_box(array('baocun'=>'保存'));
                        }
                        if($model->site_state==721 || $model->site_state==1538 || empty($model->id)) {
                            echo show_shenhe_box(array('shenhe'=>'提交审核'));
                        }
                        if($model->site_state==374) {
                            echo show_shenhe_box(array('shenhe'=>'重新提交'));
                        }
                    ?>
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                </td>
            </tr>
        </table>
        </div><!--box-detail-bd end-->


    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
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
			var club_id=$('#GfSite_user_club_id').val();
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
    });
 //场馆证明
    // 多图片对应单个字段处理
    var $site_prove=$('#GfSite_site_prove');
    var $upload_pic_site_prove=$('#upload_pic_site_prove');
    var $upload_box_site_prove=$('#upload_box_GfSite_site_prove');
    // 添加或删除时，更新图片
    var fnUpdateProvepic=function(){
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
    var fnProvepic=function(savename,allpath){
        $upload_pic_site_prove.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateProvepic();return false;"></i></a>');
        fnUpdateProvepic();
    };
    fnUpdateProvepic();
//详情图
    // 多图片对应单个字段处理
    var $site_scroll=$('#GfSite_site_scroll');
    var $upload_pic_site_scroll=$('#upload_pic_site_scroll');
    var $upload_box_site_scroll=$('#upload_box_GfSite_site_scroll');
    // 添加或删除时，更新图片
    var fnUpdateScrollpic=function(){
        var arr=[];
        $upload_pic_site_scroll.find('a').each(function(){
            arr.push($(this).attr('data-savepath'));
        });
        $site_scroll.val(we.implode(',',arr));
        $upload_box_site_scroll.show();
        if(arr.length>=5) {
            $upload_box_site_scroll.hide();
        }
    };
    // 上传完成时图片处理
    var fnScrollpic=function(savename,allpath){
        $upload_pic_site_scroll.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateScrollpic();return false;"></i></a>');
        fnUpdateScrollpic();
    };
    fnUpdateScrollpic();
//设施图片
    // 多图片对应单个字段处理
    var $facilities_pic=$('#GfSite_facilities_pic');
    var $upload_pic_facilities_pic=$('#upload_pic_facilities_pic');
    var $upload_box_facilities_pic=$('#upload_box_GfSite_facilities_pic');
    // 添加或删除时，更新图片
    var fnUpdateFacilitiespic=function(){
        var arr=[];
        $upload_pic_facilities_pic.find('a').each(function(){
            arr.push($(this).attr('data-savepath'));
        });
        $facilities_pic.val(we.implode(',',arr));
        $upload_box_facilities_pic.show();
        if(arr.length>=10) {
            $upload_box_facilities_pic.hide();
        }
    };
    // 上传完成时图片处理
    var fnFacilitiespic=function(savename,allpath){
        $upload_pic_facilities_pic.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateFacilitiespic();return false;"></i></a>');
        fnUpdateFacilitiespic();
    };
    fnUpdateFacilitiespic();

    // 选择服务地区
    var $site_location=$('#GfSite_site_location');
    $site_location.on('click', function(){
        $.dialog.data('maparea_address', '');
        $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>',{
            id:'diqu',
            lock:true,
            opacity:0.3,
            title:'添加导航定位',
            width:'907px',
            height:'504px',
            close: function () {;
                if($.dialog.data('maparea_address')!=''){
                    $('#GfSite_site_location').val($.dialog.data('maparea_address'));
					$('#GfSite_area_country').val($.dialog.data('country'));
					$('#GfSite_area_province').val($.dialog.data('province'));
					$('#GfSite_area_city').val($.dialog.data('city'));
					$('#GfSite_area_district').val($.dialog.data('district'));
					$('#GfSite_area_township').val($.dialog.data('township'));
					$('#GfSite_area_street').val($.dialog.data('street'));
                    $('#GfSite_site_longitude').val($.dialog.data('maparea_lng'));
                    $('#GfSite_site_latitude').val($.dialog.data('maparea_lat'));
                }
            }
        });
    });

</script>