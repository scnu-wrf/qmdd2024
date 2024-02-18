<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>编辑品牌</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
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
        ));
        ?>
        <table class="table-title">
            <tr>
                <td>品牌信息</td>
            </tr>
        </table>
        <table>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'Brand_TITLE'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'Brand_TITLE', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'Brand_TITLE', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'Brand_Logo_Pic'); ?></td>
                <td width="35%">
                    <?php echo $form->hiddenField($model, 'Brand_Logo_Pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(116);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->advertisement_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_Brand_Logo_Pic"><a href="<?php echo $basepath->F_WWWPATH.$model->Brand_Logo_Pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->Brand_Logo_Pic;?>" width="100"></a></div><?php }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_Brand_Logo_Pic', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'Brand_Logo_Pic', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text')); ?>
                    <span id="project_box"><?php foreach($project_list as $v){?><span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->project_name;?><i onclick="fnDeleteProject(this);"></i></span><?php }?></span>
                    <input id="project_add_btn" class="btn" type="button" value="添加项目">
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15">
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'ADVER_TITLE'); ?></td>
                <td width="35%">
                    <?php echo $form->textField($model, 'ADVER_TITLE', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'ADVER_TITLE', $htmlOptions = array()); ?>
                </td>
                <td width="15%"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text')); ?>
                    <span id="club_box"><?php if(isset($model->club_list)){?><span class="label-box"><?php echo $model->club_list->club_name;?></span><?php }?></span>
                    <input id="club_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->error($model, 'club_id', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'advertisement_pic'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'advertisement_pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(116);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->advertisement_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_advertisement_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->advertisement_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->advertisement_pic;?>" width="100"></a></div><?php }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_advertisement_pic', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'advertisement_pic', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'project_list'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'project_list', array('class' => 'input-text',)); ?>
                    <span id="project_box">
                        <?php if(!empty($model->advertisement_project)){?>
                            <?php foreach($model->advertisement_project as $v){?><span class="label-box" id="project_item_<?php echo $v->project_id?>" data-id="<?php echo $v->project_id?>"><?php echo $v->project_list->project_name;?><i onclick="fnDeleteProject(this);"></i></span><?php }?>
                        <?php }?>
                    </span>
                    <input id="project_add_btn" class="btn" type="button" value="添加">
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'advertisement_type'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'advertisement_type', Chtml::listData(AdverName::model()->getParentAll(), 'id', 'adv_name'), array('prompt'=>'请选择')); ?>
                    <?php $sub_product_list_type=0; if(!empty($sub_product_list)){ $sub_product_list_type=$sub_product_list[0]->advertisement_type; }?>
                    <select id="sub_advertisement_type" class="sub_advertisement_type" name="sub_advertisement_type">
                        <?php foreach(AdverName::model()->getByfid(5) as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if($sub_product_list_type==$v->id){?> selected<?php }?>><?php echo $v->adv_name;?></option>
                        <?php }?>
                    </select>
                    <?php echo $form->error($model, 'advertisement_type', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'ADVER_URL_ID'); ?></td>
                <td>
                    <?php echo $form->dropDownList($model, 'ADVER_URL_ID', Chtml::listData(AdverUrl::model()->getAll(), 'id', 'ADV_URL_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'ADVER_URL_ID', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr style="display:none;" id="row-ADVER_WHERE">
                <td><?php echo $form->labelEx($model, 'ADVER_WHERE'); ?></td>
                <td colspan="3">
                    <span id="ADVER_WHERE_box"><?php if($model->ADVER_WHERE!=''){?><span class="label-box"><?php Yii::app()->runController('select/getAdverService/adver_url_id/'.$model->ADVER_URL_ID.'/id/'.$model->ADVER_WHERE);?></span><?php }?></span>
                    <input id="service_select_btn" class="btn" type="button" value="选择">
                    <?php echo $form->hiddenField($model, 'ADVER_WHERE'); ?>
                    <?php echo $form->error($model, 'ADVER_WHERE', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr style="display:none;" id="row-ADVER_URL">
                <td><?php echo $form->labelEx($model, 'ADVER_URL'); ?></td>
                <td colspan="3">
                    <div id="row-ADVER_URL_text"><?php echo $form->textField($model, 'ADVER_URL', array('class' => 'input-text fl', 'placeholder'=>'请输入跳转网址')); ?></div>
                    <div id="row-ADVER_URL_pic">
                        <div class="upload_img fl" id="upload_pic_Advertisement_ADVER_URL"><a href="<?php echo $model->ADVER_URL;?>" target="_blank"><img src="<?php echo $model->ADVER_URL;?>" width="100"></a></div>
                        <script>we.uploadpic('<?php echo get_class($model);?>_ADVER_URL', '<?php echo $picprefix;?>');</script>
                    </div>
                    <?php echo $form->error($model, 'ADVER_URL', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'ADVER_DATE_START'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'ADVER_DATE_START', array('style'=>'width:120px;', 'class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'ADVER_DATE_START', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'ADVER_DATE_END'); ?></td>
                <td>
                    <?php echo $form->textField($model, 'ADVER_DATE_END', array('style'=>'width:120px;', 'class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'ADVER_DATE_END', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'advertisement_number'); ?></td>
                <td colspan="3">
                    <?php echo $form->textField($model, 'advertisement_number', array('style'=>'width:120px;', 'class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'advertisement_number', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>审核信息</td>
                </tr>
            </table>
            <table>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'ADVER_STATE'); ?></td>
                    <td width="35%">
                        <?php echo $form->radioButtonList($model, 'ADVER_STATE', array(1 => '上线', 0 => '下线'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'ADVER_STATE'); ?>
                    </td>
                    <td width="15%">&nbsp;</td>
                    <td width="35%">&nbsp;</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td>
                        <?php echo $form->radioButtonList($model, 'state', Chtml::listData(BaseCode::model()->getCode(370), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?>
                        <?php echo $form->error($model, 'state'); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td>
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' ,'value'=>'')); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
        </div>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <table class="showinfo">
            <tr>
                <th style="width:20%;">操作时间</th>
                <th style="width:20%;">操作人</th>
                <th style="width:20%;">状态</th>
                <th>操作备注</th>
            </tr>
            <tr>
                <td><?php if($model->state!=371 && $model->state!=721){ echo $model->uDate; } ?></td>
                <td><?php if($model->state!=371 && $model->state!=721){ echo $model->admin_gfnick; } ?></td>
                <td><?php if(isset($model->base_code->F_NAME) && $model->state!=371 && $model->state!=721){ echo $model->base_code->F_NAME; }?></td>
                <td><?php if($model->state!=371 && $model->state!=721){ echo $model->reasons_for_failure; } ?></td>
            </tr>
        </table>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
var club_id=<?php echo $model->club_id;?>;
$(function(){
    var $start_time=$('#<?php echo get_class($model);?>_ADVER_DATE_START');
    var $end_time=$('#<?php echo get_class($model);?>_ADVER_DATE_END');
    $start_time.on('click', function(){
        var end_input=$dp.$('<?php echo get_class($model);?>_ADVER_DATE_END')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'<?php echo get_class($model);?>_ADVER_DATE_END\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'<?php echo get_class($model);?>_ADVER_DATE_START\')}'});
    });
});
</script>
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
    $('#Advertisement_project_list').val(we.implode(',',arr));
};
fnUpdateProject();

// 广告类型为赛事馆时，跳转类型只能是二级商品
var $Advertisement_advertisement_type=$('#Advertisement_advertisement_type');
var $Advertisement_ADVER_URL_ID=$('#Advertisement_ADVER_URL_ID');
var $row_subgoods=$('#row-subgoods');
var $sub_advertisement_type=$('#sub_advertisement_type');
var fnUpdateAdverUrl=function(){
    $Advertisement_ADVER_URL_ID.find('option[value=16]').attr('disabled', true);
    if($Advertisement_advertisement_type.val()==5){
        $sub_advertisement_type.show();
        //$Advertisement_ADVER_URL_ID.hide();
        $Advertisement_ADVER_URL_ID.find('option[value=16]').attr('disabled', false);
        $Advertisement_ADVER_URL_ID.val(16).prop('disabled', true);
        $row_subgoods.show();
        $('#row-ADVER_WHERE').hide();
    }else{
        $sub_advertisement_type.hide();
        //$Advertisement_ADVER_URL_ID.show();
        $Advertisement_ADVER_URL_ID.prop('disabled', false);
        $Advertisement_ADVER_URL_ID.find('option[value=16]').attr('disabled', true);
        $row_subgoods.hide();
        if($Advertisement_ADVER_URL_ID.val()===null){
            $Advertisement_ADVER_URL_ID.val('');
        }
    }
};
fnUpdateAdverUrl();

// 删除已添加商品
var fnDeleteProduct=function(op){
    $(op).parent().parent().remove();
};

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
    
    // 选择广告类型
    $Advertisement_advertisement_type.on('change', function(){
        fnUpdateAdverUrl();
    });
    
    // 选择单位
    var $club_box=$('#club_box');
    $('#club_select_btn').on('click', function(){
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club");?>',{
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
                    $('#Advertisement_club_id').val($.dialog.data('club_id'));
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
    
    // 跳转类型切换
    var adver_url_json=<?php echo AdverUrl::model()->getAllJson();?>;
    var adver_url_id=$('#Advertisement_ADVER_URL_ID').val();
    var $row_adver_where=$('#row-ADVER_WHERE');
    var $row_adver_url=$('#row-ADVER_URL');
    var $row_adver_url_text=$('#row-ADVER_URL_text');
    var $row_adver_url_pic=$('#row-ADVER_URL_pic');
    var $row_subgoods=$('#row-subgoods');
    var $Advertisement_ADVER_WHERE=$('#Advertisement_ADVER_WHERE');
    var $ADVER_WHERE_box=$('#ADVER_WHERE_box');
    var fnAdverUrlIdChange=function(adver_url_id, setEmpty){
        if(setEmpty==undefined){
            setEmpty=true;
        }

        if(setEmpty){
            $Advertisement_ADVER_WHERE.val('');
            $ADVER_WHERE_box.html('');
        }
        if(adver_url_json[adver_url_id].ADV_URL_TABLE!=''){
            $row_adver_where.show();
            $row_adver_url.hide();
        }else{
            if(adver_url_id==15){
                if(setEmpty){
                    $('#Advertisement_ADVER_URL').val('');
                    $('#upload_pic_Advertisement_ADVER_URL').html('');
                }
                $row_adver_url_text.hide();
                $row_adver_url_pic.show();
            }else{
                if(setEmpty){
                    $('#Advertisement_ADVER_URL').val('');
                    $('#upload_pic_Advertisement_ADVER_URL').html('');
                }
                $row_adver_url_text.show();
                $row_adver_url_pic.hide();
            }
            $row_adver_url.show();
            $row_adver_where.hide();
        }
        
        if($Advertisement_advertisement_type.val()==5){
            $row_adver_where.hide();
        }
    };
    $('#Advertisement_ADVER_URL_ID').on('change', function(){
        adver_url_id=$(this).val();
        fnAdverUrlIdChange(adver_url_id);
    });
    fnAdverUrlIdChange(<?php echo $model->ADVER_URL_ID;?>, false);
    
    $('#service_select_btn').on('click', function(){
        if(club_id<=0){
            we.msg('minus', '请先选择发布单位');
            return false;
        }
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/adverService");?>'+'&adver_url_id='+adver_url_id+'&noid=<?php echo $model->id;?>&club_id='+club_id,{
            id:'fuwu',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                if($.dialog.data('id')>0){
                    $Advertisement_ADVER_WHERE.val($.dialog.data('id'));
                    $ADVER_WHERE_box.html('<span class="label-box">'+$.dialog.data('title')+'</span>');
                }
            }
        });
    });
    
    // 添加二级商品
    var $product_list=$('#product_list tbody');
    $('#product_add_btn').on('click', function(){
        $.dialog.data('product_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/products");?>',{
            id:'shangpin',
            lock:true,
            opacity:0.3,
            title:'选择具体内容',
            width:'500px',
            height:'60%',
            close: function () {
                //console.log($.dialog.data('product_id'));
                if($.dialog.data('product_id')>0){
                    if($('#product_item_'+$.dialog.data('product_id')).length==0){
                        $product_list.append('<tr id="product_item_'+$.dialog.data('product_id')+'">'+
                            '<td>'+$.dialog.data('product_name')+'</td>'+
                            '<td><div class="upload_img fl" id="upload_pic_sub_product_list_'+$.dialog.data('product_id')+'"><a href="<?php echo $basepath->F_WWWPATH;?>'+$.dialog.data('product_pic')+'" target="_blank"><img src="<?php echo $basepath->F_WWWPATH;?>'+$.dialog.data('product_pic')+'" width="100"></a></div><div class="fl" id="box_sub_product_list_'+$.dialog.data('product_id')+'"></div><input id="sub_product_list_'+$.dialog.data('product_id')+'" name="sub_product_list['+$.dialog.data('product_id')+'][pic]" value="'+$.dialog.data('product_pic')+'" type="hidden"></td>'+
                            '<td><input style="width:90%;" class="input-text" name="sub_product_list['+$.dialog.data('product_id')+'][title]" value="'+$.dialog.data('product_name')+'" type="text"></td>'+
                            '<td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td>'+
                        '</tr>');
                        we.uploadpic('sub_product_list_'+$.dialog.data('product_id'), '<?php echo $picprefix;?>');
                    }
                }
            }
        });
        //$product_list.append('');
    });
    
//    var fnCheckState=function(){
//        if($('input[name="Advertisement[state]"]:checked').val()==373){
//            $('#state_msg').show();
//        }else{
//            $('#state_msg').hide();
//        }
//    };
//    fnCheckState();
//    // 审核未通过原因
//    $('#Advertisement_state').on('click', function(){
//        fnCheckState();
//    });
});
</script>