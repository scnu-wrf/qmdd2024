<?php 
    if(empty($model->project_id)){
        $model->project_id=0;
    }
    if(empty($model->dispay_type)){
        $model->dispay_type=0;
    }
    if(($model->dispay_end_time=='0000-00-00 00:00:00')){
        $model->dispay_end_time='';
    }
 ?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>添加功能</h1><span class="back"><a href="javascript:;" class="btn" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div>
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'set_code'); ?></td>
                        <td width="85%" colspan="5"><?php echo $model->set_code; ?></td>
                    </tr>
                    <tr>
                        <td style="width:15%;"><?php echo $form->labelEx($model, 'function_area_id'); ?></td>
                        <td style="width:35%;" colspan="2">
                            <?php echo $form->dropDownList($model, 'function_area_id', Chtml::listData(QmddFunctionArea::model()->findAll(), 'id', 'area_name'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'function_area_id', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:15%;"><?php echo $form->labelEx($model, 'dispay_num'); ?></td>
                        <td style="width:35%;" colspan="2">
                            <?php echo $form->textField($model, 'dispay_num', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'dispay_num', $htmlOptions = array()); ?>
                            <div class="msg">*排序号越大，越往前排</div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'function_id'); ?></td>
                        <td colspan="2">
                            <?php echo $form->dropDownList($model, 'function_id', Chtml::listData(QmddFunction::model()->findAll(), 'id', 'function_describe'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'function_id', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'dispay_title'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'dispay_title', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'dispay_title', $htmlOptions = array()); ?>
                            <div class="msg">*不填写按默认显示</div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'dispay_icon'); ?></td>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'dispay_icon', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(176);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->dispay_icon!=''){?>
                            <div class="upload_img fl" id="upload_pic_QmddFuntionData_dispay_icon">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->dispay_icon;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->dispay_icon;?>" width="100"></a>
                            </div>
                            <?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_dispay_icon','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'dispay_icon', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'dispay_click_icon'); ?></td>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'dispay_click_icon', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(229);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->dispay_click_icon!=''){?>
                            <div class="upload_img fl" id="upload_pic_QmddFuntionData_dispay_click_icon">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->dispay_click_icon;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->dispay_click_icon;?>" width="100"></a>
                            </div>
                            <?php }?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_dispay_click_icon','<?php echo $picprefix;?>');</script>
                            <?php echo $form->error($model, 'dispay_click_icon', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'dispay_type'); ?></td>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'dispay_type', array('class' => 'input-text')); ?>
                            <span id="dispay_box"><?php if(!empty($dispay_type))foreach($dispay_type as $v){?><span class="label-box" id="dispay_item_<?php echo $v->f_id;?>" data-id="<?php echo $v->f_id;?>"><?php echo $v->F_NAME;?><i onclick="fnDeleteDispay(this);"></i></span><?php }?></span>
                            <input id="dispay_add_btn" class="btn" type="button" value="添加类型">
                            <?php echo $form->error($model, 'dispay_type', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'dispay_format'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'dispay_format', array('id'=>'this_value', 'class' => 'input-text','maxlength'=>'2','onkeyup'=>'this.value=this.value.replace(/\D/gi,"");','placeholder'=>'请输入数字'));?>
                            <?php echo $form->error($model, 'dispay_format', $htmlOptions = array()); ?>
                            <div class="msg">*注：占单行份数，如1为占单行一分之一空间；2为占单行二分之一空间，以此类推</div>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'dispay_star_time'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'dispay_star_time', array('class' => 'input-text')); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'dispay_end_time'); ?></td>
                        <td colspan="2">
                            <?php echo $form->textField($model, 'dispay_end_time', array('class' => 'input-text')); ?>
                            <div class="msg">*未填写不限制结束时间</div>
                        </td> 
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td colspan="2">
                            <?php echo $form->hiddenField($model, 'project_id', array('class' => 'input-text')); ?>
                            <span id="project_box"><?php if(!empty($project_list))foreach($project_list as $v){?><span class="label-box" id="projectnot_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->project_name;?><i onclick="fnDeleteProject(this);"></i></span><?php }?></span>
                            <input id="project_add_btn" class="btn" type="button" value="添加项目">
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'if_user'); ?></td>
                        <td colspan="2">
                            <?php echo $form->radioButtonList($model, 'if_user', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td width="35%" colspan="5" id='dcom_qmdd_club_id'>
                            <span id="club_box"><span class="label-box"><?php echo get_session('club_name');?><?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text','value'=>get_session('club_id'))); ?></span></span>
                        </td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr>
                        <td width="15%">可执行操作</td>
                        <td colspan="5">
                            <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $('#QmddFuntionData_dispay_star_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',maxDate:'#F{$dp.$D(\'QmddFuntionData_dispay_end_time\')}'});
    });
    $('#QmddFuntionData_dispay_end_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',minDate:'#F{$dp.$D(\'QmddFuntionData_dispay_star_time\')}'});
    });

    // 滚动图片处理
    var $dispay_click_icon=$('#QmddFuntionData_dispay_click_icon');
    var $upload_pic_dispay_click_icon=$('#upload_pic_dispay_click_icon');

    // 添加或删除时，更新图片
    var fnUpdatescrollPic=function(){
        var arr1=[];
        $upload_pic_dispay_click_icon.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $dispay_click_icon.val(we.implode(',',arr1));
        $upload_box_scroll_pic_img.show();
    };
    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        $upload_pic_game_big_pic.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
        fnUpdatescrollPic();
    };

    // 使用单位
    var $club_box = $('#club_box');
    var $QmddFuntionData_club_id = $('#QmddFuntionData_club_id');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id',0);
        $.dialog.open('<?php echo $this->createUrl("select/club",array('partnership_type'=>16)); ?>',{
            id:'danwei',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('club_id') > 0){
                    club_id = $.dialog.data('club_id');
                    $QmddFuntionData_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">' + $.dialog.data('club_title') + '</span>');
                }
            }
        });
    });
    
    // 删除类型
    var $dispay_box=$('#dispay_box');
    var $QmddFuntionData_dispay_type=$('#QmddFuntionData_dispay_type');
    var fnUpdateDispay=function(){
        var arr=[];
        var id;
        $dispay_box.find('span').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $QmddFuntionData_dispay_type.val(we.implode(',', arr));
    };
    
    var fnDeleteDispay=function(op){
        $(op).parent().remove();
        fnUpdateDispay();
    };

    // 使用类型
    $('#dispay_add_btn').on('click', function(){
        $.dialog.data('dispay_type', 0);
        $.dialog.open('<?php echo $this->createUrl("select/basecode", array('fid'=>727));?>',{
            id:'shiyongleixing',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('dispay_type')==-1){
                    var boxnum=$.dialog.data('dispay_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#dispay_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="dispay_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $dispay_box.append(s1+'<i onclick="fnDeleteDispay(this);"></i></span>');
                            fnUpdateDispay(); 
                        }
                    }
                }
            }
        });
    });

    // 项目添加
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
                if($.dialog.data('project_id')==-1){
                    var boxnum=$.dialog.data('project_title');
                    for(var j=0;j<boxnum.length;j++) {
                        if($('#projectnot_item_'+boxnum[j].dataset.id).length==0){
                            var s1='<span class="label-box" id="projectnot_item_'+boxnum[j].dataset.id;
                            s1=s1+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title;
                            $project_box.append(s1+'<i onclick="fnDeleteProject(this);"></i></span>');
                            fnUpdateProject(); 
                        }
                    }
                }
            }
        });
    });

    // 删除项目
    var $project_box=$('#project_box');
    var $QmddFuntionData_project_id=$('#QmddFuntionData_project_id');
    var fnUpdateProject=function(){
        var arr=[];
        var id;
        $project_box.find('span').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $QmddFuntionData_project_id.val(we.implode(',', arr));
    };
    
    var fnDeleteProject=function(op){
        $(op).parent().remove();
        fnUpdateProject();
    };
    
</script>