<style>
    .upload_img a{
        width: 100px;
        height: 100px;
        display: inline-flex!important;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
    }
    .upload_img a img{
        width: auto!important;
        height:auto!important;
        max-width:100%;
        max-height:100%;
    }
</style>
<div class="box">
    <div class="box-title c"><h1>供应商信息</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <div class="box-detail">
        <table id="t1">
            <tr class="table-title">
                <td colspan="4">联系人信息</td>
            </tr>
            <tr>
                <td  width="15%"><?php echo $form->labelEx($model, 'apply_name'); ?> <span class="required">*</span></td>
                <td width="85%">
                    <?php echo $form->textField($model, 'apply_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'apply_name', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'apply_club_gfaccount'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->hiddenField($model, 'apply_club_gfid'); ?>
                    <?php echo $form->textField($model, 'apply_club_gfaccount', array('class' => 'input-text','onChange' =>'accountOnchang(this)')); ?>
                    <?php echo $form->error($model, 'apply_club_gfaccount', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_phone'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'contact_phone', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'email'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'email', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'con_address'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'con_address', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'con_address', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'apply_id_card'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'apply_id_card', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'apply_id_card', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'contact_id_card_face'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->hiddenField($model, 'contact_id_card_face', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(217);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->contact_id_card_face!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_contact_id_card_face"><a href="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_face;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_face;?>" width="100"></a></div><?php }?>
            <script>we.uploadpic('<?php echo get_class($model);?>_contact_id_card_face', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'contact_id_card_face', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'contact_id_card_back'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->hiddenField($model, 'contact_id_card_back', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(217);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->contact_id_card_back!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_contact_id_card_back"><a href="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_back;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_back;?>" width="100"></a></div><?php }?>
            <script>we.uploadpic('<?php echo get_class($model);?>_contact_id_card_back', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'contact_id_card_back', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15" id="t2">
            <tr class="table-title">
                <td colspan="4">经营信息</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'club_name'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'club_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                </td>
                <td><label>供应商类别</label> <span class="required">*</span></td>
                <td>
                    <?php echo $form->hiddenField($model, 'club_type', array('class' => 'input-text','value' => $_REQUEST['club_type'])); ?>
                    <?php echo $form->dropDownList($model, 'partnership_type', Chtml::listData(BaseCode::model()->getCode(380), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                    <?php echo $form->error($model, 'partnership_type', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'certificates_number'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'certificates_number', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'certificates_number', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'certificates'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->hiddenField($model, 'certificates', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(219);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->certificates!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_certificates"><a href="<?php echo $basepath->F_WWWPATH.$model->certificates;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->certificates;?>" width="100"></a></div><?php }?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_certificates', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'certificates', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'valid_until_start'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'valid_until_start', array('class' => 'input-text', 'style'=>'width:100px;','placeholder' => '开始时间')); ?>
                    <?php echo $form->error($model, 'valid_until_start', $htmlOptions = array()); ?>
                </td>
                <td>至</td>
                <td>
                    <?php echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'style'=>'width:100px;','placeholder' => '有效期')); ?>
                    <?php echo $form->error($model, 'valid_until', $htmlOptions = array()); ?>
                    <br><span class="msg">*未填写默认为“长期有效”</span>
                </td>
            </tr>
            <tr>
                <td rowspan="2"><?php echo $form->labelEx($model, 'club_address'); ?> <span class="required">*</span></td>
                <td colspan="3">
                    
                <?php  $area=explode(',',$model->club_area_code);foreach($area as $h){?>
                    <?php 
                        $text='';
                        $tRegion=TRegion::model()->findAll('level=1');
                        $option='';
                        foreach($tRegion as $tion){
                            $option.='<option value="'.$tion->id.'">'.$tion->region_name_c.'</option>';
                        }
                        $text.= '<select name="area[1][club_area_code]" id="ClubList_club_area_code1" onchange="showArea(this)" value="1" style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                        echo $text;
                    ?>
                    <?php }?>
                    <?php echo $form->hiddenField($model, 'club_area_province'); ?>
                    <?php echo $form->hiddenField($model, 'club_area_city'); ?>   
                    <?php echo $form->hiddenField($model, 'club_area_district'); ?>
                    <?php echo $form->hiddenField($model, 'club_area_township'); ?>
                    <?php echo $form->hiddenField($model, 'club_area_code'); ?>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <?php echo $form->textField($model, 'club_address', array('class' => 'input-text','placeholder' => '详细地址')); ?>
                    <?php echo $form->error($model, 'club_address', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'management_category'); ?> <span class="required">*</span></td>
                <td colspan="3">
                    <?php echo $form->hiddenField($model, 'management_category', array('class' => 'input-text')); ?>
                    <span id="classify_box"></span>
                    <input id="classify_add_btn" class="btn" type="button" value="添加分类">
                    <?php echo $form->error($model, 'management_category', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15" id="t3">
            <tr class="table-title">
                <td colspan="4">法人信息</td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'apply_club_gfnick'); ?> <span class="required">*</span></td>
                <td width="85%">
                        <?php echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'apply_club_gfnick', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'apply_club_phone'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'apply_club_phone', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'apply_club_phone', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'apply_club_email'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'apply_club_email', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'apply_club_email', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'apply_club_id_card'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'apply_club_id_card', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'id_card_face'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->hiddenField($model, 'id_card_face', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(214);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->id_card_face!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_face"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>" width="100"></a></div><?php }?>
            <script>we.uploadpic('<?php echo get_class($model);?>_id_card_face', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'id_card_face', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'id_card_back'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->hiddenField($model, 'id_card_back', array('class' => 'input-text fl')); ?>
                    <?php $basepath=BasePath::model()->getPath(214);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                    <?php if($model->id_card_back!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_back"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_back;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_back;?>" width="100"></a></div><?php }?>
            <script>we.uploadpic('<?php echo get_class($model);?>_id_card_back', '<?php echo $picprefix;?>');</script>
                    <?php echo $form->error($model, 'id_card_back', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15" id="t4">
            <tr class="table-title">
                <td colspan="4">银行信息</td>
            </tr>
            <tr>
                <td width="15%"><?php echo $form->labelEx($model, 'bank_name'); ?> <span class="required">*</span></td>
                <td width="85%">
                    <?php echo $form->textField($model, 'bank_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'bank_name', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'bank_branch_name'); ?> <span class="required">*</span></td>
                <td>
                    <?php echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'bank_branch_name', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'bank_account'); ?> <span class="required">*</span></td>
                <td colspan="3">
                    <?php echo $form->textField($model, 'bank_account', array('class' => 'input-text')); ?>
                    <?php echo $form->error($model, 'bank_account', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15" id="add_brand">
            <tr class="table-title">
                <td colspan="4">品牌信息</td>
            </tr>
            <tr style="text-align:center;">
                <td width="15%"><?php echo $form->labelEx($model, 'brand_name'); ?> <span class="required">*</span></td>
                <td width="85%"><?php echo $form->labelEx($model, 'brand_logo'); ?> <span class="required">*</span></td>
                <td><?php echo $form->labelEx($model, 'brand_lock'); ?> <span class="required">*</span></td>
                <td><input type="button" class="btn btn-blue" onclick="add_tag();" value="添加"></td>
            </tr>
            <?php
                $num = 0;
                if(!empty($ids))foreach($ids as $mabb_brand){
            ?>
                <tr style="text-align:center;" brand_id="<?php echo $mabb_brand->id; ?>">
                    <input class="input-text brand" name="add_tag[<?php echo $num; ?>][brand_id]" type="hidden" value="<?php echo $mabb_brand->id; ?>">
                    <td><input class="input-text brand_title" name="add_tag[<?php echo $num; ?>][brand_name]" type="text" value="<?php echo $mabb_brand->brand_title; ?>"></td>
                    <td>
                        <?php $basepath=BasePath::model()->getPath(214);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME;}?>
                        <input class="input-text brand_img" type="hidden" name="add_tag[<?php echo $num;?>][brand_logo]" id="add_tag_brand_logo_<?php echo $num;?>" value="<?php echo $mabb_brand->brand_logo_pic;?>">
                        <div class="upload_img fl" id="upload_pic_<?php echo get_class($mabb_brand);?>_brand_logo<?php echo $num; ?>">
                            <?php if($mabb_brand->brand_logo_pic!=''){?>
                                <a href="<?php echo $basepath->F_WWWPATH.$mabb_brand->brand_logo_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$mabb_brand->brand_logo_pic;?>">
                                </a>
                            <?php }?>
                        </div>
                        <!-- <?php //if(empty($mabb_brand->id)) {?> -->
                        <script>we.uploadpic('add_tag_brand_logo_<?php echo $num; ?>', '<?php echo $picprefix;?>');</script>
                        <!-- <?php //}?> -->
                    </td>
                    <td><textarea name="add_tag[<?php echo $num; ?>][brand_lock]" class="input-text brand_intro"><?php echo $mabb_brand->brand_content; ?></textarea></td>
                    <td class="del_tag"><a class="btn dis_a" href="javascript:;" onclick="delete_brand(this);">删除</a></td>
                </tr>
            <?php $num++; }else{?>
                <tr style="text-align:center;">
                    <input class="input-text brand" name="add_tag[<?php echo $num; ?>][brand_id]" type="hidden" value="">
                    <td><input class="input-text brand_title" name="add_tag[<?php echo $num; ?>][brand_name]" type="text"></td>
                    <td>
                        <input id="add_tag_brand_logo_<?php echo $num;?>" class="brand_img" name="add_tag[<?php echo $num;?>][brand_logo]" type="hidden">
                        <div id="box_add_tag_brand_logo_<?php echo $num;?>" style="margin-left:0.5rem;"><script>we.uploadpic("add_tag_brand_logo_<?php echo $num;?>", "<?php echo $picprefix;?>");</script></div>
                    </td>
                    <td><textarea  name="add_tag[<?php echo $num; ?>][brand_lock]"  class="input-text brand_intro"></textarea></td>
                    <td class="del_tag"><a class="btn dis_a" href="javascript:;" onclick="delete_brand(this);">删除</a></td>
                </tr>
            <?php }?>
            <?php echo $form->hiddenField($model, 'remove_brand_ids', array('class' => 'input-text fl'));?>
        </table>
        <table class="mt15" id="t6">
            <tr class="table-title">
                <td colspan="4">资质附件</td>
            </tr>
            <tr>
                <!--此外为多国，链接club_list_pic表-->
                <td><?php echo $form->labelEx($model, 'club_list_pic'); 
                    // $club_list_pic=ClubListPic::model()->findall('club_id='.$model->id); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'club_list_pic', array('class' => 'input-text')); ?>
                        <div class="upload_img fl" id="upload_pic_club_list_pic">
                            <?php $basepath=BasePath::model()->getPath(187);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                            if(!empty($club_list_pic)){
                            foreach($club_list_pic as $v) { ?>
                            <a class="picbox" data-savepath="<?php  echo $v['club_aualifications_pic'];?>" 
                            href="<?php  echo $basepath->F_WWWPATH.$v['club_aualifications_pic'];?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$v['club_aualifications_pic'];?>" width="100">
                            <i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i></a>
                            <?php }?>
                            <?php }?>
                        </div>
                    <script>  
                        we.uploadpic('<?php echo get_class($model);?>_club_list_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnClub_list_pic(e1.savename,e1.allpath);},5);
                    </script>
                    <?php echo $form->error($model, 'club_list_pic', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15" id="t7">
            <tr class="table-title">
                <td colspan="4">审核信息</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model,'visible'); ?></td>
                <td colspan="3"><?php echo $form->radioButtonList($model, 'visible', array(0=>'不显示', 1=>'显示'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>')); ?></td>
            </tr>
            <tr>
                <td>可执行操作</td>
                <td colspan="3">
                    <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
                    <!--<button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button>
                    <button onclick="submitType='shenhe'" class="btn btn-blue" type="submit">提交审核</button>-->
                    <button class="btn" type="button" onclick="we.back();">取消</button>
                </td>
            </tr>
        </table>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>

var club_id=0;
we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
    if(index==3){
    }
    return true;
});

$('#ClubListGys_valid_until,#ClubListGys_valid_until_start').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

// 滚动图片处理
var $club_list_pic=$('#ClubList_club_list_pic');
var $upload_pic_club_list_pic=$('#upload_pic_club_list_pic');
var $upload_box_club_list_pic=$('#upload_box_Club_list_pic');

// 添加或删除时，更新图片
var fnUpdateClub_list_pic=function(){
    var arr=[];
    $upload_pic_club_list_pic.find('a').each(function(){
        arr.push($(this).attr('data-savepath'));
    });
    $club_list_pic.val(we.implode(',',arr));
    $upload_box_club_list_pic.show();
    if(arr.length>=5) {
        $upload_box_club_list_pic.hide();
    }
};
// 上传完成时图片处理
var fnClub_list_pic=function(savename,allpath){
    $upload_pic_club_list_pic.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i></a>');
    fnUpdateClub_list_pic();
};

// 删除分类
var $classify_box=$('#classify_box');
var $ClubList_management_category=$('#ClubList_management_category');
var fnUpdateClassify=function(){
    var arr=[];
    var id;
    $classify_box.find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $ClubList_management_category.val(we.implode(',', arr));
};

var fnDeleteClassify=function(op){
    $(op).parent().remove();
    fnUpdateClassify();
};
$(function(){
<?php if(!empty($_REQUEST['club_type'])&&$_REQUEST['club_type']==380){?>
    $('#t7 .btn-blue').eq(1).on('click',function(){
        if($("#ClubListGys_apply_name").val()==''){
            we.msg('minus','请输入联系人');
            return false;
        }
        if($("#ClubListGys_apply_club_gfaccount").val()==''){
            we.msg('minus','请输入申请人账号');
            return false;
        }
        if($("#ClubListGys_contact_phone").val()==''){
            we.msg('minus','请输入联系人电话');
            return false;
        }
        if($("#ClubListGys_email").val()==''){
            we.msg('minus','请输入联系人邮箱');
            return false;
        }
        if($("#ClubListGys_con_address").val()==''){
            we.msg('minus','请输入联系人地址');
            return false;
        }
        if($("#ClubListGys_apply_id_card").val()==''){
            we.msg('minus','请输入联系人身份证');
            return false;
        }
        if($("#ClubListGys_contact_id_card_face").val()==''){
            we.msg('minus','请上传联系人身份证正面');
            return false;
        }
        if($("#ClubListGys_contact_id_card_back").val()==''){
            we.msg('minus','请上传联系人身份证反面');
            return false;
        }
        if($("#ClubListGys_club_name").val()==''){
            we.msg('minus','请输入供应商名称');
            return false;
        }
        if($("#ClubListGys_partnership_type").val()==''){
            we.msg('minus','请选择供应商类别');
            return false;
        }
        if($("#ClubListGys_certificates_number").val()==''){
            we.msg('minus','请输入统一社会信用代码');
            return false;
        }
        if($("#ClubListGys_certificates").val()==''){
            we.msg('minus','请上传营业执照');
            return false;
        }
        if($("#ClubListGys_valid_until_start").val()==''){
            we.msg('minus','请输入营业期限开始时间');
            return false;
        }
        if($(".area").val()==''){
            we.msg('minus','请选择所在地区');
            return false;
        }
        if($("#ClubListGys_club_address").val()==''){
            we.msg('minus','请输入所在地区详细地址');
            return false;
        }
        if($("#ClubListGys_management_category").val()==''){
            we.msg('minus','请添加经营分类');
            return false;
        }
        if($("#ClubListGys_apply_club_gfnick").val()==''){
            we.msg('minus','请输入法人');
            return false;
        }
        if($("#ClubListGys_apply_club_phone").val()==''){
            we.msg('minus','请输入法人电话');
            return false;
        }
        if($("#ClubListGys_apply_club_email").val()==''){
            we.msg('minus','请输入法人邮箱');
            return false;
        }
        if($("#ClubListGys_apply_club_id_card").val()==''){
            we.msg('minus','请输入法人身份证号');
            return false;
        }
        if($("#ClubListGys_id_card_face").val()==''){
            we.msg('minus','请上传法人身份证正面');
            return false;
        }
        if($("#ClubListGys_id_card_back").val()==''){
            we.msg('minus','请上传法人身份证反面');
            return false;
        }
        if($("#ClubListGys_bank_name").val()==''){
            we.msg('minus','请输入开户名称');
            return false;
        }
        if($("#ClubListGys_bank_branch_name").val()==''){
            we.msg('minus','请输入开户行支行名称');
            return false;
        }
        if($("#ClubListGys_bank_account").val()==''){
            we.msg('minus','请输入银行帐号');
            return false;
        }
        var brand_title=true;
        $(".brand_title").each(function(){
            if($(this).val()===''){
                brand_title=false;
            }
        })
        if(!brand_title){
            we.msg('minus','请输入品牌名称');
            return false;
        }
        var brand_img=true;
        $(".brand_img").each(function(){
            if($(this).val()===''){
                brand_img=false;
            }
        })
        if(!brand_img){
            we.msg('minus','请输入品牌LOGO');
            return false;
        }
        var brand_intro=true;
        $(".brand_intro").each(function(){
            if($(this).val()===''){
                brand_intro=false;
            }
        })
        if(!brand_intro){
            we.msg('minus','请输入品牌简介');
            return false;
        }
    })
<?php }?>




 // 添加分类
    var $classify_add_btn=$('#classify_add_btn');
    $classify_add_btn.on('click', function(){
        $.dialog.data('classify_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/manage_type");?>',{
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
    
<?php if(empty($_REQUEST['club_type'])){?>
    // 选择服务地区
    var $ClubList_club_address=$('#ClubList_club_address');
    var $ClubList_Longitude=$('#ClubList_Longitude');
    var $ClubList_latitude=$('#ClubList_latitude');
    $ClubList_club_address.on('click', function(){
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
                    $('#ClubList_club_address').val($.dialog.data('maparea_address'));
                    $ClubList_Longitude.val($.dialog.data('maparea_lng'));
                    $ClubList_latitude.val($.dialog.data('maparea_lat'));
					$('#ClubList_club_area_country').val($.dialog.data('country'));
					$('#ClubListGys_club_area_province').val($.dialog.data('province'));
					$('#ClubListGys_club_area_city').val($.dialog.data('city'));
					$('#ClubListGys_club_area_district').val($.dialog.data('district'));
					$('#ClubList_club_area_street').val($.dialog.data('street'));
                }
            }
        });
    });
<?php }?>
	
	// 选择单位
    var $club_box=$('#club_box');
    var $ClubList_club_id=$('#ClubList_recommend');
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
                    $ClubList_club_id.val($.dialog.data('club_id')).trigger('blur');
                    $club_box.html('<span class="label-box">'+$.dialog.data('club_title')+'</span>');
                }
            }
        });
    });
	
	
});
//单位类型二级联动下拉菜单
 function selectOnchang(obj){ 
  var show_id=$(obj).val();
  var  p_html ='<option value="">请选择</option>';
  if (show_id>0) {
    //'partnership_type
     for (j=0;j<$d_club_type2.length;j++) 
        if($d_club_type2[j]['fater_id']==show_id)
       {
        p_html = p_html +'<option value="'+$d_club_type2[j]['f_id']+'">';
        p_html = p_html +$d_club_type2[j]['F_NAME']+'</option>';
      }
    }
   $("#ClubList_partnership_type").html(p_html);
}

//城市联动
    function showArea(obj){
        var show_id=$(obj).val();
        if($(obj).attr("value")==1){
            $("#ClubList_club_area_code2,#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListGys_club_area_city,#ClubListGys_club_area_district,#ClubListGys_club_area_township").val('');
            $("#ClubListGys_club_area_province").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==2){
            $("#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListGys_club_area_district,#ClubListGys_club_area_township").val('');
            $("#ClubListGys_club_area_city").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==3){
            $("#ClubList_club_area_code4").remove();
            $("#ClubListGys_club_area_township").val('');
            $("#ClubListGys_club_area_district").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==4){
            $("#ClubListGys_club_area_township").val($(obj).find("option[value='"+show_id+"']").text());
        }
        var area_arr=[];
        $("#t2 tr:eq(4) td:eq(1) select").each(function(){
            area_arr.push($(this).val());
        })
        console.log(area_arr)
        $("#ClubListGys_club_area_code").val(area_arr.join(","))
        if(show_id>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('scales');?>&info_id='+show_id,
                dataType: 'json',
                success: function(data) {
                    var content='';
                    if(data[0].level==2){
                        $("#t2 tr:eq(4) td:eq(1)").append('<select name="area[2][club_area_code]" id="ClubList_club_area_code2" onchange="showArea(this)" value="2" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==2){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code2").append(content);
                    }else if(data[0].level==3){
                        $("#t2 tr:eq(4) td:eq(1)").append('<select name="area[3][club_area_code]" id="ClubList_club_area_code3" onchange="showArea(this)" value="3" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==3){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code3").append(content);
                    }else if(data[0].level==4){
                        $("#t2 tr:eq(4) td:eq(1)").append('<select name="area[4][club_area_code]" id="ClubList_club_area_code4" onchange="showArea(this)" value="4" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==4){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code4").append(content);
                    }
                }
            });
        }
    }

    var num=<?php if(!empty($num)){echo $num;}else{echo 1;} ?>;
    function add_tag(){
        var add_brand = $('#add_brand');
        var html = 
            '<tr style="text-align:center">'+
                '<input class="input-text brand" name="add_tag['+num+'][brand_id]" type="hidden" value="0">'+
                '<td><input name="add_tag['+num+'][brand_name]" class="input-text"></td>'+
                '<td>'+
                    '<input id="add_tag_brand_logo_'+num+'" name="add_tag['+num+'][brand_logo]" type="hidden">'+
                    '<div id="box_add_tag_brand_logo_'+num+'" style="margin-left:0.5rem;"><script>we.uploadpic("add_tag_brand_logo_'+num+'", "<?php echo $picprefix;?>");<\/script></div>'+
                '</td>'+
                '<td><textarea name="add_tag['+num+'][brand_lock]"  class="input-text"></textarea></td>'+
                '<td><a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_brand(this);">删除</a></td>'+
            '</tr>';
        num++;
        add_brand.append(html);
    }

    var remove_arr=[];
    function delete_brand(obj){
        var removeValue=$(obj).parent().parent().attr("brand_id");
        remove_arr.push(removeValue);
        $("#ClubList_remove_brand_ids").val(remove_arr.join(','))
        $(obj).parent().parent().remove();
    }

    // 验证账号
    function accountOnchang(obj){
        var changval=$(obj).val();
        // if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval,
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        $('#ClubList_apply_club_gfid').val(data.gfid);
                    }else{
                        $(obj).val('');
                        $('#ClubList_apply_club_gfid').val(0);
                        we.msg('minus', data.msg);
                    }
                }
            });
        // }
    }
</script>