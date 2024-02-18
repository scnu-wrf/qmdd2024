<style>
.fontStyle1{
 font-size:14px;
 color:#666;
 font-weight:bold;

}
</style>
<?php
    if($model->start_date=='0000-00-00 00:00:00'){
        $model->start_date='';
    }
    if($model->end_date=='0000-00-00 00:00:00'){
        $model->end_date='';
    }

?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：服务者 》服务者管理 》服务者入驻 》<?php echo (!empty($model->id)) ? '详情' : '添加'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list2('baocun')); ?>

            <!-- <div class="box-detail-tab">
                <ul class="c">
                    <li class="current">基本信息</li>
                    <?php //if(!empty($model->id)){?>
                        <li id="a2">实名信息</li>
                    <?php //}?>
                </ul>
            </div>box-detail-tab end -->
            <div class="box-detail-bd">
                <div style="display: block;" class="box-detail-tab-item">
                    <table width="100%" style="table-layout: auto;">
                        <tr>
                            <td class="fontStyle1" width="15%"><?php echo $form->labelEx($model, 'qualification_type_id'); ?></td>
                            <td class="qualification_type_box">
                                <select name="QualificationsPerson[qualification_type_id]" id="QualificationsPerson_qualification_type_id" onchange="fnResetCertificate();" >
                                    <option value="">请选择</option>
                                    <?php
                                        $list=ClubServicerType::model()->findAll('type=501');
                                        $content='';
                                        foreach($list as $val){
                                            $info=empty($val->certificate_type)?'0':'1';
                                            if($val->member_second_id==$model->qualification_type_id){
                                                $selected = "selected";
                                            }else{
                                                $selected = "";
                                            }
                                            $content.='<option value="'.$val->member_second_id.'" if_project="'.$val->if_project.'" if_info="'.$info.'"  '.$selected.'>'.$val->member_second_name.'</option>';
                                        }
                                        echo $content;
                                    ?>
                                </select>
                                <?php echo $form->error($model, 'qualification_type_id', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr class="project">
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_project_id'); ?>
                            <span class="required">*</span></td>
                            <td>
                                <?php echo $form->dropDownList($model, 'qualification_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt'=>'请选择')); ?>
                                <?php echo $form->error($model, 'qualification_project_id', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                    <table width="100%" style="table-layout: auto; margin-top: 15px;">
                        <tr class="table-title">
                            <?php echo $form->hiddenField($model, 'logon_way', array('value' => 1375)); ?>
                            <?php echo $form->hiddenField($model, 'logon_way_name', array('value' => '后台添加')); ?>
                            <td class="fontStyle1" colspan="2">入驻者信息</td>
                        </tr>
                        <tr>
                            <td width="15%" class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_gf_code'); ?></td>
                            <td><?php echo $model->qualification_gf_code; ?></td>
                        </tr>
                        <tr>
                            <td width="15%" class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_gfaccount'); ?></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'qualification_gfaccount', array('class' => 'input-text')); ?>
                                <?php echo $form->hiddenField($model, 'gfid'); ?>
                                <span id="account_box">
                                <?php if($model->qualification_gfaccount!=0){?>
                                <span class="label-box"><?php echo $model->qualification_gfaccount;?></span>
                                <?php }?>
                                </span>
                                <input id="account_select_btn" class="btn" type="button" value="选择">
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_name'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'qualification_name', array('class' => 'input-text','readonly'=>'readonly')); ?>
                                <?php echo $form->error($model, 'qualification_name', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_sex'); ?></td>
                            <td>
                                <span id="sex"><?php if(!is_null($model->base_sex))echo $model->base_sex->F_NAME; ?></span>
                                <?php echo $form->hiddenField($model, 'qualification_sex'); ?>
                                <?php echo $form->error($model, 'qualification_sex', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'phone'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'phone', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'phone', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'email'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'email', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'area_code'); ?></td>
                            <td>
                                <?php echo areaList($model->area_code); ?>
                                <?php echo $form->error($model, 'area_code', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'address'); ?></td>
                            <td>
                                <?php echo $form->textField($model, 'address', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'address', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr class="qualification_info">
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_identity_num'); ?>
                                <span class="required">*</span></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'qualification_identity_type', array('class' => 'input-text')); ?>
                                <?php echo $form->hiddenField($model, 'qualification_identity_num', array('class' => 'input-text')); ?>
                                <span id="certificate_box">
                                    <?php if(!empty($model->qualification_identity_num)) { ?>
                                        <span class="label-box">
                                            <?php echo $model->qualification_identity_type_name.$model->qualification_title;?>
                                        </span>
                                    <?php } ?>
                                </span>
                                <input id="certificate_select_btn" class="btn" type="button" value="选择">
                                <?php echo $form->error($model, 'qualification_identity_num', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr class="qualification_info">
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_code'); ?>
                                <span class="required">*</span></td>
                            <td>
                                <?php echo $form->textField($model, 'qualification_code', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'qualification_code', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr class="qualification_info">
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'qualification_image'); ?>
                                <span class="required">*</span></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'qualification_image', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->qualification_image!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_qualification_image"><a href="<?php echo $basepath->F_WWWPATH.$model->qualification_image;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->qualification_image;?>" width="70"></a></div><?php }?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_qualification_image', '<?php echo $picprefix;?>');</script>
                                <?php echo $form->error($model, 'qualification_image', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr class="qualification_info">
                            <td class="fontStyle1">
                                <?php echo $form->labelEx($model, 'start_date'); ?>
                                <span class="required">*</span>
                            </td>
                            <td >
                                <?php echo $form->textField($model, 'start_date', array('class' => 'input-text', 'style' => 'width: 200px')); ?>
                                <?php echo $form->error($model, 'start_date', $htmlOptions = array()); ?>
                                <?php echo ' - '.$form->textField($model, 'end_date', array('class' => 'input-text', 'style' => 'width: 200px', 'placeholder'=>'*不填默认长期')); ?>
                                <?php echo $form->error($model, 'end_date', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'head_pic'); ?></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'head_pic', array('class' => 'input-text fl')); ?>

                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->head_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_head_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" width="70"></a></div><?php }?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_head_pic', '<?php echo $picprefix;?>');</script>
                                <?php echo $form->error($model, 'head_pic', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                    <table class="mt15" style="table-layout:auto;">
                        <?php if(!empty($model->id)) { ?>
                            <tr>
                                <td class="fontStyle1">状态</td>
                                <td><?php echo $model->check_state_name; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td class="fontStyle1" width="15%">操作</td>
                            <td>
                                <?php echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php if(!empty($model->id)){?>
                <div class="box-detail-tab-item" style="display:none;">
                    <table style="table-layout:auto;">
                        <tr class="table-title">
                            <td class="fontStyle1" colspan="4">实名信息</td>
                        </tr>
                        <tr>
                            <td class="fontStyle1" style="width:15%;"><?php echo $form->labelEx($model,'qualification_name'); ?></td>
                            <td style="width:35%;"><?php echo $model->qualification_name; ?></td>
                            <td class="fontStyle1" style="width:15%;"><?php echo $form->labelEx($model,'qualification_sex'); ?></td>
                            <td style="width:35%;"><?php echo $model->base_sex->F_NAME; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model,'native'); ?></td>
                            <td><?php echo $model->gf_user_1->native; ?></td>
                            <td class="fontStyle1"><?php echo $form->labelEx($model,'nation'); ?></td>
                            <td><?php echo $model->gf_user_1->nation; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model,'real_birthday'); ?></td>
                            <td><?php echo $model->gf_user_1->real_birthday; ?></td>
                            <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_type'); ?></td>
                            <td><?php echo $model->gf_user_1->id_card_type_name; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card'); ?></td>
                            <td colspan="3"><?php echo $model->gf_user_1->id_card; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_validity_start'); ?></td>
                            <td><?php echo $model->gf_user_1->id_card_validity_start; ?></td>
                            <td class="fontStyle1"><?php echo $form->labelEx($model,'id_card_validity_end'); ?></td>
                            <td><?php echo $model->gf_user_1->id_card_validity_end; ?></td>
                        </tr>
                        <tr>
                            <td class="fontStyle1"><?php echo $form->labelEx($model, 'id_card_pic'); ?></td>
                            <td>
                                <?php $basepath=BasePath::model()->getPath(211);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->gf_user_1->id_card_pic!=null){?>
                                <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_card_pic;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_card_pic;?>" width="100">
                                    </a>
                                </div>
                                <?php }?>
                                <?php echo $form->error($model, 'id_card_pic', $htmlOptions = array()); ?>
                            </td>
                            <td class="fontStyle1" width="15%"><?php echo $form->labelEx($model, 'id_pic'); ?></td>
                            <td>
                                <?php $basepath=BasePath::model()->getPath(210);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->gf_user_1->id_pic!=null){?>
                                <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_pic;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->gf_user_1->id_pic;?>" width="100">
                                    </a>
                                </div>
                                <?php }?>
                                <?php echo $form->error($model, 'id_pic', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <?php }?>
            </div>
            <!--box-detail-tab-item end-->
        <?php $this->endWidget();?>
    </div>
</div>
<?php
function get_form_list2($submit='=='){
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    var if_project=$("#QualificationsPerson_qualification_type_id option:selected").attr("if_project");
                    console.log(if_project)
                    if(if_project==649){
                        if($("#QualificationsPerson_qualification_project_id").val()==""){
                            hasError=true;
                            data.QualificationsPerson_qualification_project_id=["入驻项目 不能为空"];
                            $("#QualificationsPerson_qualification_project_id_em_").html("入驻项目 不能为空").show();
                        }
                    }
                    var if_info=$("#QualificationsPerson_qualification_type_id option:selected").attr("if_info");
                    if(if_info==1){
                        if($("#QualificationsPerson_qualification_identity_num").val()==""){
                            hasError=true;
                            data.QualificationsPerson_qualification_identity_num=["服务者资质 不能为空"];
                            $("#QualificationsPerson_qualification_identity_num_em_").html("服务者资质 不能为空").show();
                        }
                        if($("#QualificationsPerson_qualification_code").val()==""){
                            hasError=true;
                            data.QualificationsPerson_qualification_code=["资质编号 不能为空"];
                            $("#QualificationsPerson_qualification_code_em_").html("资质编号 不能为空").show();
                        }
                        if($("#QualificationsPerson_qualification_image").val()==""){
                            hasError=true;
                            data.QualificationsPerson_qualification_image=["上传资质 不能为空"];
                            $("#QualificationsPerson_qualification_image_em_").html("上传资质 不能为空").show();
                        }
                        if($("#QualificationsPerson_start_date").val()==""){
                            hasError=true;
                            data.QualificationsPerson_start_date=["资质有效期 不能为空"];
                            $("#QualificationsPerson_start_date_em_").html("服务者资质 不能为空").show();
                        }
                    }
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
            )
        );
  }
?>
<script>
    we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
        return true;
    });

	// 选择服务者
    var $account_box=$('#account_box');
    $('#account_select_btn').on('click', function(){
        $.dialog.data('GF_ID', 0);
        $.dialog.open('<?php echo $this->createUrl("select/gfuser");?>',{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',
        close: function () {
            if($.dialog.data('GF_ID')>0){
                console.log($.dialog.data('passed'))
                if($.dialog.data('passed')==372){
                    $('#QualificationsPerson_qualification_gfaccount').val($.dialog.data('GF_ACCOUNT'));
                    $('#QualificationsPerson_gfid').val($.dialog.data('GF_ID'));
                    $('#QualificationsPerson_qualification_name').val($.dialog.data('zsxm'));
                    $('#QualificationsPerson_qualification_name').attr('disabled', 'disabled');
                    $('#QualificationsPerson_qualification_sex').val($.dialog.data('real_sex'));
                    var sex='';
                    if($.dialog.data('real_sex')==205){
                        var sex='男';
                    }else if($.dialog.data('real_sex')==207){
                        var sex='女';
                    }
                    $("#sex").html(sex);
                    $account_box.html('<span class="label-box">'+$.dialog.data('GF_ACCOUNT')+'</span>');
                }else{
                    we.msg('minus','该账号未实名');
                }
            }
         }
       });
    });

    // 选择联系地址
    var $QualificationsPerson_address=$('#QualificationsPerson_address');
    $QualificationsPerson_address.on('click', function(){
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
                    $QualificationsPerson_address.val($.dialog.data('maparea_address'));
                }
            }
        });
    });

    fnResetCertificate(1);
    function fnResetCertificate(e){
        var if_project=$("#QualificationsPerson_qualification_type_id option:selected").attr("if_project");
        if(if_project==649){
            $(".project").show();
            // $(".qualification_type_box").attr("colspan","0")
        }else{
            $(".project").hide();
            // $(".qualification_type_box").attr("colspan","3")
        }

        var if_info=$("#QualificationsPerson_qualification_type_id option:selected").attr("if_info");
        if(if_info==1){
            $(".qualification_info").show();
        }else{
            $(".qualification_info").hide();
        }
        if(e!=1){
            $("#QualificationsPerson_qualification_identity_type").val('');
            $("#QualificationsPerson_qualification_identity_num").val('');
            $("#certificate_box").empty();
        }
    }
    //选择证书等级
    var $certificate_box=$('#certificate_box');
    $('#certificate_select_btn').on('click', function(){
		var type_id = $('#QualificationsPerson_qualification_type_id').val();
        console.log(type_id)
        if(type_id==''){
            we.msg('minus','请选择服务者类型');
            return false;
        }
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/certificate_type");?>&type_id='+type_id,{
        id:'zhengshu',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',
        close: function () {
            if($.dialog.data('id')>0){
                $('#QualificationsPerson_qualification_identity_type').val($.dialog.data('fater_id'));
                $('#QualificationsPerson_qualification_identity_num').val($.dialog.data('id'));
                $certificate_box.html('<span class="label-box">'+$.dialog.data('fater_name')+$.dialog.data('F_NAME')+'</span>');
            }
         }
       });
    });

$('#QualificationsPerson_start_date').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$('#QualificationsPerson_end_date').on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});


</script>