<style>
    .fontStyle1 {
        font-size: 14px;
        color: #666;
        font-weight: bold;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1><i class="fa fa-table"></i>服务者信息</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->

    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
     	<div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li id="a2">实名信息</li>
                <!-- <li id="a3">服务者管理信息</li>
                <li id="a4">服务者介绍</li>
                <li id="a5">挂靠单位信息</li> -->
            </ul>
        </div><!--box-detail-tab end-->
        
        <div class="box-detail-bd">
                <div style="display:block;" class="box-detail-tab-item">
                   <table width="100%" style="table-layout:auto;">
                        <tr class="table-title">
                            <td class="fontStyle1" colspan="4">基本信息</td>
                        </tr>
                        <!-- <tr>
                            <td><?php echo $form->labelEx($model, 'qcode'); ?></td>
                            <td><?php echo $model->qcode; ?></td>
                            <td><?php echo $form->labelEx($model, 'project_name'); ?></td>
                            <td><?php echo $model->project_name; ?></td>
                        </tr> -->
                        
                        <tr>
                            <td width="10%" class="fontStyle1"><?php echo $form->labelEx($model, 'gf_code'); ?></td>
                            <td colspan="3"><?php echo $model->gf_code; ?></td>

                        </tr>
                        
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'gfaccount'); ?></td>
                            <td width="27%"><?php echo $model->gfaccount; ?></td>
                            <td width="9%" class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_name'); ?></td>
                            <td width="54%"><?php echo $model->qualification_name; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_type'); ?></td>
                            <td><?php echo $model->qualification_type; ?></td>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'project_name'); ?></td>
                            <td><?php echo $model->project_name; ?></td>
                            <!-- <td><?php echo $form->labelEx($model, 'qualification_title'); ?></td>
                            <td><?php echo $model->identity_type_name.$model->qualification_title; ?></td> -->
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'phone'); ?></td>
                            <td><?php echo $model->phone; ?></td>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'email'); ?></td>
                            <td><?php echo $model->email; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'address'); ?></td>
                            <td colspan="3"><?php echo $model->address; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'head_pic'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'head_pic', array('class' => 'input-text')); ?>
                                <?php
                                    $basepath=BasePath::model()->getPath(213);
                                    if($model->head_pic!=''){
                                ?>
                                    <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_head_pic">
                                        <a href="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" style="max-width:100px; max-height:100px;">
                                        </a>
                                    </div>
                                <?php }?>
                            </td>
                        </tr>
                    </table>
                   <table width="100%" style="table-layout:auto; margin-top:10px;">
                        <tr class="table-title">
                            <td  class="fontStyle1" colspan="4">资质信息</td>
                        </tr>
                        <tr>
                            <td width="10%" class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_title'); ?></td>
                            <td colspan="3"><?php echo $model->identity_type_name.$model->qualification_title; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_code'); ?></td>
                            <td colspan="3"><?php echo $model->qualification_code; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_image'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'qualification_image',array('class' => 'input-text')); ?>
                                <div class="upload_img fl" id="upload_pic_qualification_image">
                                    <?php
                                        $basepath=BasePath::model()->getPath(121);
                                        foreach($qualification_image as $v) if($v) {
                                    ?>
                                        <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;">
                                        </a>
                                    <?php }?>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'start_date'); ?></td>
                            <td width="40%"><?php echo $model->start_date; ?></td>
                            <td width="4%" class="fontStyle1" style="text-align:center;"><?php echo $form->labelEx($model, 'end_date'); ?></td>
                            <td width="46%"><?php echo $model->end_date; ?></td>
                        </tr>
                    </table>
                    <table class="mt15" style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="4" class="fontStyle1">操作信息</td>
                        </tr>
                        <tr>
                           <td class="fontStyle1" width="10%"><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                            <td colspan="3">
                            <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' )); ?>
                            <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                            </td> 
                        </tr>
                        <tr>
                            <td class="fontStyle1">可执行操作</td>
                            <td colspan="3">
                                <?php echo $model->check_state_name; ?>
                            </td>
                        </tr>
                    </table>
                    
                   <table class="mt15 showinfo" style="table-layout:auto;">
                        <tr>
                            <th class="fontStyle1" rowspan="2" width="10%">操作记录</th>
                            <th>操作人</th>
                            <th>操作时间</th>
                            <th>操作内容</th>
                        </tr>
                        <tr>
                            <td><?php echo $model->process_nick; ?></td>
                            <td><?php echo $model->uDate; ?></td>
                            <td><?php echo $model->check_state_name; ?></td>
                        </tr>
                    </table>
                    
                    
                </div>
            <div style="display:none;" class="box-detail-tab-item">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">实名信息</tr>
                    </tr>
                    <tr>
                        <td style="width:15%;"><?php echo $form->labelEx($model,'qualification_name'); ?></td>
                        <td style="width:35%;"><?php echo $model->qualification_name; ?></td>
                        <td style="width:15%;"><?php echo $form->labelEx($model,'sex'); ?></td>
                        <td style="width:35%;"><?php echo $model->sex->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'native'); ?></td>
                        <td><?php echo $model->userlist->native; ?></td>
                        <td><?php echo $form->labelEx($model,'nation'); ?></td>
                        <td><?php echo $model->userlist->nation; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'real_birthday'); ?></td>
                        <td><?php echo $model->userlist->real_birthday; ?></td>
                        <td><?php echo $form->labelEx($model,'id_card_type'); ?></td>
                        <td><?php echo $model->userlist->id_card_type_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'id_card'); ?></td>
                        <td colspan="3"><?php echo $model->userlist->id_card; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'id_card_validity_start'); ?></td>
                        <td><?php echo $model->userlist->id_card_validity_start; ?></td>
                        <td><?php echo $form->labelEx($model,'id_card_validity_end'); ?></td>
                        <td><?php echo $model->userlist->id_card_validity_end; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'id_card_pic'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(211);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->userlist->id_card_pic!=null){?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->userlist->id_card_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->userlist->id_card_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php echo $form->error($model, 'id_card_pic', $htmlOptions = array()); ?>
                        </td>
                        <td width="15%"><?php echo $form->labelEx($model, 'id_pic'); ?></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(210);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->userlist->id_pic!=null){?>
                            <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->userlist->id_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->userlist->id_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php echo $form->error($model, 'id_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="display:none;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr>
                        <td colspan="4" style="background:#fafafa;">服务者个人管理信息（审核通过生成的数据）</td>
                    </tr>
                    <!-- <tr>
                        <td ><?php echo $form->labelEx($model, 'gf_code'); ?></td>
                        <td >
                            <?php echo $model->gf_code;?>
                            <?php echo $form->error($model, 'gf_code', $htmlOptions = array()); ?>
                        </td>
                        <td >服务者证书</td>
                        <td><input type="button"  name=''  id=''  value="下载证书" /></td>
                    </tr> -->
                    <tr>
                        <td><?php echo $form->labelEx($model, 'qualification_level'); ?></td>
                        <td><?php echo $model->level_name;?></td>
                        <td><?php echo $form->labelEx($model, 'qualification_score'); ?></td>
                        <td><?php echo $model->qualification_score;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'achi_h_ratio'); ?></td>
                        <td><?php echo $model->achi_h_ratio;?></td>
                        <td><?php echo $form->labelEx($model, 'check_state_name'); ?></td>
                        <td><?php echo $model->check_state_name;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'expiry_date_start'); ?></td>
                        <td><?php echo $model->expiry_date_start;?></td>
                        <td><?php echo $form->labelEx($model, 'expiry_date_end'); ?></td>
                        <td><?php echo $model->expiry_date_end;?></td>
                    </tr>
                </table>
        	</div><!--box-detail-tab-item end-->
            <div  class="box-detail-tab-item"  style="display:none;">
                <table class="showinfo">
                    <tr  class="table-title">
                        <td>图文介绍</td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'introduct_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_introduct_temp', '<?php echo get_class($model);?>[introduct_temp]');</script>
                            <?php echo $form->error($model, 'introduct_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table id="timelist">
                    <td>选择视频</td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'video_list', array('class' => 'input-text')); ?>
                        <input id="product_add_btn" class="btn" type="button" value="添加">
                        <div class="upload fl">
                            <script>var materialVideoUrl='<?php echo $this->createUrl('gfMaterial/upvideo');?>';
                            we.materialVideo(function(data){ $('#product_list').append('<tr id="product_item_'+data.id+'"><td>'+data.title+'</td><td>'+'<div class="upload_img" data-id="'+data.id+'" id="upload_pic_sub_product_list_'+data.id+'">'+data.allpath+'</div><td style="display:none;" id="box_sub_product_list_'+data.id+'"></td><td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td></tr>'); fnUpdateProduct(); },61,24,'上传');
                            </script>
                        </div>
                        <br>
                        <table id="product_list" style="width:80%; text-align:center;" class="showinfo">
                            <tr>
                                <th>视频标题</th>
                                <th>视频文件</th>
                                <th>&nbsp;</th>
                            </tr>
                            <?php if(is_array($sub_product_list)) foreach($sub_product_list as $v){?>
                            <tr id="product_item_<?php echo $v->video_title;?>">
                                <td><?php echo $v->video_title;?></td>
                                <td data-id="<?php echo $v->material_id;?>">
                                <div class="upload_img" data-id="<?php echo $v->material_id;?>"><?php echo $v->video_files;?></div>
                                </td>
                                <td><a onclick="fnDeleteProduct(this);" href="javascript:;">删除</a></td>
                            </tr>
                            <?php }?>
                        </table>
                    </td>
               </table>
                <table class="table-title" style='margin-top:10px;'><tr> <td>操作信息</td></tr></table>
                <table>
                    <tr>
                        <td colspan="2" style="text-align:center;">
                            <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                            <button class="btn" type="button" onclick="back();">取消</button>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">操作时间</td>
                        <td style="text-align:center;">操作人</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;"><?php echo $model->state_time; ?></td>
                        <td style="text-align:center;"><?php echo $model->process_nick; ?></td>
                    </tr>
                </table> 
            </div><!--box-table end-->
            <div  class="box-detail-tab-item"  style="display:none;">
                <table >
                    <thead class="table-title">
                        <tr >
                            <td>单位名称</td>
                            <td>项目</td>
                            <td>类型</td>
                            <td>状态</td>
                            <td>操作日期</td>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    if(is_array($club_list)) foreach($club_list as $v){ ?>
                        <tr>
                            <td><?php echo $v->club_name; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->type_name; ?></td>
                            <td><?php echo $v->state_name; ?></td>
                            <td><?php echo $v->udate; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div><!--box-table end-->
        </div><!--box-detail-bd end-->
    </div><!--box-detail end-->
</div><!--box end-->

<?php $this->endWidget();?>
<script>
///模拟界面切换
we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
    if(index==1){

    }
    return true;
});

function back(){
    history.back(-1)
}

$('#ClubQualificationPerson_qualification_time').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});
$('#ClubQualificationPerson_start_date').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});
$('#ClubQualificationPerson_end_date').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd'});});

// 滚动图片处理
var $upload_pic_pic=$('#upload_pic_scroll_qualification_pic');
var $upload_box_pic=$('#upload_box_scroll_qualification_pic');
var $scroll_pic_img=$('#ClubQualificationPerson_scroll_qualification_pic');


// 添加或删除时，更新图片
var fnUpdatescrollPic=function(){
    var arr=[];var s1="";
    $upload_pic_pic.find('a').each(function(){
         s1=$(this).attr('data-savepath');
      //  console.log(s1);
        if(s1!=""){
        arr.push($(this).attr('data-savepath'));}
    });
    $('#ClubQualificationPerson_qualification_pic').val(we.implode(',',arr));
    $upload_box_pic.show();
    if(arr.length>=5) {  $upload_box_pic.hide();}
};
// 上传完成时图片处理
var fnscrollPic=function(savename,allpath){
    $upload_pic_pic.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
    fnUpdatescrollPic();
};
var $product_list=$('#product_list');
    var $ClubQualificationPerson_vidio_list=$('#ClubQualificationPerson_vidio_list');
    var fnUpdateProduct=function(){
        var arr=[];
        var id;
        $product_list.find('div.upload_img').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $ClubQualificationPerson_vidio_list.val(we.implode(',', arr)).trigger('blur');
    };
var fnDeleteProduct=function(op){
    $(op).parent().parent().remove();
    fnUpdateProduct();
};

</script> 

