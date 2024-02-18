<style>
    .upload_img a{
        width: 100px;
        height: 100px;
        display: inline-flex!important;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
        vertical-align: middle;
    }
    .upload_img a img{
        width: auto!important;
        height:auto!important;
        max-width:100%;
        max-height:100%;
    }
    table{
        table-layout:auto!important;
    }
    table tr td:nth-child(2n+1){
        width:15%;
    }
    table tr td:nth-child(2n){
        width:400px;
    }
    .progress li{
        width: calc(100% / 4);
    }
</style>
<?php 
    // if($model->state==2){
    //     $left='calc((100% / 4) / 2)';
    //     $right='calc(100% - (100% / 4) / 2)';
    //     $float='calc(((100% / 4) / 2) - 2.5% - 5px)';
    // }else
    if($model->state==2&&($model->edit_state==721||is_Null($model->edit_state))){
        $left='calc(50% - 25% / 2)';
        $right='calc(50% + 25% / 2)';
        $float='calc(50% - 25% / 2 - 2.5% - 5px)';
    }elseif($model->state==2&&$model->edit_state==371){
        $left='calc(50% + 25% / 2)';
        $right='calc(50% - 25% / 2)';
        $float='calc(50% + 25% / 2 - 2.5% - 5px)';
    }elseif($model->state==2&&$model->edit_state==2){
        $left='100%';
        $right='0';
        $float='calc(100% - (100% / 4) / 2 - 2.5% - 5px)';
    }else{
        $left='calc(50% + 25% / 2)';
        $right='calc(50% - 25% / 2)';
        $float='calc(50% + 25% / 2 - 2.5% - 5px)';
    }
    // var_dump($_REQUEST);
?>
<?php
 function get_form_list2($submit='=='){
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    var type_id=$("#ClubListZlhb_taxpayer_type .input-check:checked").val();
                    console.log(type_id)
                    if(type_id==649){
                        if($("#ClubListZlhb_taxpayer_pic").val()==""){
                            hasError=true;
                            data.ClubListZlhb_taxpayer_pic=["一般纳税人证明上传 不能为空"];
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
            ),
        );
  }
?>
<div class="box">
    <div class="box-title c"><h1><?php if($_REQUEST['id']=='[:club_id]'){echo '当前界面：首页 》账号信息 》信息认证 》详情';}elseif(($model->edit_state==721||is_null($model->edit_state))){echo '当前界面：战略伙伴》信息认证管理》信息认证申请》详情';}else{echo '战略伙伴 》信息认证管理 》详情';}?></h1></div><!--box-title end-->
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list2('baocun')); ?>
    <div class="box-detail">
        <div class="progress">
            <div class="progress_bar">
                <div class="progress_left" style="width:<?php echo $left;?>;"></div>
                <div class="progress_right" style="width:<?php echo $right;?>;"></div>
                <div class="progress_float" style="left:<?php echo $float;?>"></div>
            </div>
            <ul>
                <li>意向审核</li>
                <li>提交信息认证</li>
                <li>信息认证审核</li>
                <li>信息认证完成</li>
            </ul>
        </div>
        <div class="box-detail-tab" style="border:none;margin-top:10px;">
            <ul class="c">
                <li class="current">信息认证</li>
                <?php
                    if($model->edit_state==721||($model->edit_state!=1538&&$model->edit_state!=721&&!empty($model->enter_project_id))||is_null($model->edit_state)){
                        echo '<li>项目</li>';
                    }
                ?>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table id="t3">
                    <?php echo $form->hiddenField($model, 'club_type', array('class' => 'input-text','value' => 189)); ?>
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                        <td colspan="3">
                            <?php echo $model->club_code; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>申请<?php echo $form->labelEx($model, 'company'); ?></td>
                        <td>
                            <?php if(!empty($model->id)){echo $form->textField($model, 'company', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'company', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'company_type_id'); ?></td>
                        <td>
                            <?php if(!empty($model->id)&&$model->state!=721){echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1403), 'f_id', 'F_NAME'), array('prompt'=>'请选择',"disabled"=>"disabled" ));}else{echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1403), 'f_id', 'F_NAME'), array('prompt'=>'请选择'));} ?>
                            <?php echo $form->error($model, 'company_type_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2"><?php echo $form->labelEx($model, 'club_address'); ?> <?=!empty($model->id)&&$model->state==721?"<span class='required'>*</span>":""?></td>
                        <td colspan="3">
                            <?php $disabled=!empty($model->id)?'disabled="disabled"':'';if(!empty($model->club_area_code)){$area=explode(',',$model->club_area_code);foreach($area as $h){?>
                                <?php 
                                    $t_region=TRegion::model()->find('id='.$h);
                                    $text='';
                                    if($t_region->level==1){
                                        $t1=$t_region->id;
                                        $tRegion=TRegion::model()->findAll('level=1');
                                        $option='';
                                        foreach($tRegion as $tion){
                                            $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                            $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                        }
                                        $text.= '<select name="area[1][club_area_code]" id="ClubList_club_area_code1" onchange="showArea(this)" value="1" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                    }elseif($t_region->level==2){
                                        $t2=$t_region->id;
                                        $tRegion2=TRegion::model()->findAll('upper_region='.$t1.' and level=2');
                                        $option='';
                                        foreach($tRegion2 as $tion){
                                            $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                            $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                        }
                                        $text.= '<select name="area[2][club_area_code]" id="ClubList_club_area_code2" onchange="showArea(this)" value="2" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                    }elseif($t_region->level==3){
                                        $t3=$t_region->id;
                                        if(!empty($t2)){
                                            $tRegion3=TRegion::model()->findAll('upper_region='.$t2.' and level=3');
                                        }else{
                                            $tRegion3=TRegion::model()->findAll('upper_region='.$t1.' and level=3');
                                        }
                                        $option='';
                                        foreach($tRegion3 as $tion){
                                            $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                            $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                        }
                                        $text.= '<select name="area[3][club_area_code]" id="ClubList_club_area_code3" onchange="showArea(this)" value="3" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                    }elseif($t_region->level==4){
                                        $t4=$t_region->id;
                                        if(!empty($t3)){
                                            $tRegion4=TRegion::model()->findAll('upper_region='.$t3.' and level=4');
                                        }else{
                                            $tRegion4=TRegion::model()->findAll('upper_region='.$t2.' and level=4');
                                        }
                                        $option='';
                                        foreach($tRegion4 as $tion){
                                            $selected=$t_region->id==$tion->id?'selected="selected"':'';
                                            $option.='<option value="'.$tion->id.'" '.$selected.'>'.$tion->region_name_c.'</option>';
                                        }
                                        $text.= '<select name="area[4][club_area_code]" id="ClubList_club_area_code4" onchange="showArea(this)" value="4" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                    }
                                    echo $text;
                                ?>
                            <?php }}else{?>
                                <?php $area=explode(',',$model->club_area_code);foreach($area as $h){?>
                                <?php 
                                    $text='';
                                    $tRegion=TRegion::model()->findAll('level=1');
                                    $option='';
                                    foreach($tRegion as $tion){
                                        $option.='<option value="'.$tion->id.'">'.$tion->region_name_c.'</option>';
                                    }
                                    $text.= '<select name="area[1][club_area_code]" id="ClubList_club_area_code1" onchange="showArea(this)" value="1" '.$disabled.' style="margin-right:10px;"><option value="">请选择</option>'.$option.'</select>';
                                    echo $text;
                                ?>
                                <?php }?>
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
                            <?php if(!empty($model->id)){echo $form->textField($model, 'club_address', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'club_address', array('class' => 'input-text','placeholder' => '详细地址'));} ?>
                            <?php echo $form->error($model, 'club_address', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'valid_until_start'); ?></td>
                        <td>
                            <?php if(!empty($model->id)){echo $form->textField($model, 'valid_until_start', array('class'=>'input-text','disabled'=>'disabled', 'style'=>'width:100px;','placeholder' => '开始时间'));}else{echo $form->textField($model, 'valid_until_start', array('class' => 'input-text', 'style'=>'width:100px;','placeholder' => '开始时间'));} ?>
                            <?php echo $form->error($model, 'valid_until_start', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'valid_until'); ?></td>
                        <td>
                            <?php if(!empty($model->id)){echo $form->textField($model, 'valid_until', array('class' => 'input-text','disabled'=>'disabled', 'style'=>'width:100px;','placeholder' => '有效期'));}else{echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'style'=>'width:100px;','placeholder' => '有效期'));} ?>
                            <?php echo $form->error($model, 'valid_until', $htmlOptions = array()); ?>
                            <br><span class="msg">*未填写默认为“长期有效”</span>
                        </td>
                    </tr>
                    <tr>
                        <!--此外为多国，链接club_list_pic表-->
                        <td><?php echo $form->labelEx($model, 'club_list_pic'); 
                        if(!empty($model->id))$club_list_pic=ClubListPic::model()->findall('club_id='.$model->id);?></td>
                        <td colspan="3">
                        <div>
                            <?php 
                                $v_id='';
                                if(!empty($club_list_pic))foreach($club_list_pic as $d) {
                                    $v_id.=$d->club_aualifications_pic.',';
                                };
                                echo $form->hiddenField($model, 'club_list_pic', array('class' => 'input-text','value'=>rtrim($v_id, ','))); 
                            ?>
                            <div class="upload_img fl" id="upload_pic_club_list_pic" >
                                <?php $basepath=BasePath::model()->getPath(187);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if(!empty($club_list_pic)){
                                if(is_array($club_list_pic)) foreach($club_list_pic as $v) { ?>
                                <a class="picbox" data-savepath="<?php  echo $v['club_aualifications_pic'];?>" 
                                href="<?php  echo $basepath->F_WWWPATH.$v['club_aualifications_pic'];?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$v['club_aualifications_pic'];?>" style="max-height:100px; max-width:100px;">
                                <?php if(empty($model->id)||$model->state==721){?>
                                    <i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i>
                                <?php }?>
                                </a>
                                <?php }?>
                                <?php }?>
                            </div>
                        </div>
                        <?php if(empty($model->id)||$model->state==721){?>
                        <script>
                            we.uploadpic('<?php echo get_class($model);?>_club_list_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnClub_list_pic(e1.savename,e1.allpath);},5);
                        </script>
                        <?php }?>
                        <?php echo $form->error($model, 'club_list_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table id="t2" class="mt15">
                    <tr class="table-title">
                        <td colspan="4">联系人信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_club_gfaccount'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'apply_club_gfid'); ?>
                            <?php if(!empty($model->id)){echo $form->textField($model, 'apply_club_gfaccount', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_gfaccount', array('class' => 'input-text','onChange' =>'accountOnchang(this)'));} ?>
                            <?php echo $form->error($model, 'apply_club_gfaccount', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                        <td>
                            <?php if(!empty($model->id)){echo $form->textField($model, 'apply_name', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_name', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'apply_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                        <td>
                            <?php if(!empty($model->id)){echo $form->textField($model, 'contact_phone', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'contact_phone', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td>
                            <?php if(!empty($model->id)){echo $form->textField($model, 'email', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'email', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="table-title">
                        <td colspan="4">推荐单位</td>
                    </tr>
                    <tr>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'recommend_clubcode'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'recommend'); ?>
                            <?php if(!empty($model->id)&&$model->state!=721){echo $form->textField($model, 'recommend_clubcode', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'recommend_clubcode', array('class' => 'input-text','onChange' =>'codeOnchang(this)'));} ?>
                        </td>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'recommend_clubname'); ?></td>
                        <td>
                            <?php if(!empty($model->id)&&$model->state!=721){echo $form->textField($model, 'recommend_clubname', array('class'=>'input-text','disabled'=>'disabled','readonly'=>"readonly"));}else{echo $form->textField($model, 'recommend_clubname', array('class' => 'input-text','readonly'=>"readonly","placeholder"=>"请输入推荐单位账号"));} ?>
                        </td>
                    </tr>
                </table>
                <table id="t5" class="mt15">
                    <tr class="table-title">
                        <td colspan="4">公司法人信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_club_gfnick'); ?> </td>
                        <td>
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->textField($model, 'apply_club_gfnick', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'apply_club_gfnick', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'apply_club_phone'); ?> </td>
                        <td>
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->textField($model, 'apply_club_phone', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_phone', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'apply_club_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_club_id_card'); ?> </td>
                        <td colspan="3">
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->textField($model, 'apply_club_id_card', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'apply_club_id_card', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'id_card_face'); ?> </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'id_card_face', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(214);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->id_card_face!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_face"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>"></a></div><?php }?>
                            <?php if($model->edit_state==1538||$model->edit_state==721||is_null($model->edit_state)){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_id_card_face', '<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'id_card_face', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'id_card_back'); ?> </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'id_card_back', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(215);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->id_card_back!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_back"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_back;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_back;?>"></a></div><?php }?>
                            <?php if($model->edit_state==1538||$model->edit_state==721||is_null($model->edit_state)){?>
                    <script>we.uploadpic('<?php echo get_class($model);?>_id_card_back', '<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'id_card_back', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table id="t4">
                    <tr class="table-title">
                        <td colspan="4">开户银行账号信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_name'); ?> </td>
                        <td>
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->textField($model, 'bank_name', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_name', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'bank_name', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'bank_branch_name'); ?> </td>
                        <td>
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->textField($model, 'bank_branch_name', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'bank_branch_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_account'); ?> </td>
                        <td colspan="3">
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->textField($model, 'bank_account', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_account', array('class' => 'input-text'));} ?>
                            <?php echo $form->error($model, 'bank_account', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_pic'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'bank_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->bank_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_bank_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->bank_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->bank_pic;?>"></a></div><?php }?> 
                            </div>
                            <?php if($model->edit_state==1538||$model->edit_state==721||is_null($model->edit_state)){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_bank_pic', '<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'bank_pic', $htmlOptions = array()); ?>
                    
                        </td>
                    </tr>
                </table>
                <table id="t6">
                    <tr class="table-title">
                        <td colspan="4">纳税资格信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'taxpayer_type'); ?></td>
                        <td colspan="3">
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '','disabled'=>'disabled', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));}else{echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));} ?>
                            <?php echo $form->error($model, 'taxpayer_type'); ?>
                        </td>
                    </tr>
                    <tr id="taxpayer_pic" <?php if(!empty($model->taxpayer_type)&&$model->taxpayer_type!=649)echo 'style="display:none;"'?> >
                        <td><?php echo $form->labelEx($model, 'taxpayer_pic'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'taxpayer_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->taxpayer_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_taxpayer_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->taxpayer_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->taxpayer_pic;?>"></a></div><?php }?> 
                            </div>
                            <?php if($model->edit_state==1538||$model->edit_state==721||is_null($model->edit_state)){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_taxpayer_pic', '<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'taxpayer_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table id="t1" >
                    <tr class="table-title">
                        <td colspan="4">服务平台信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_name'); ?></td>
                        <td>
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->textField($model, 'club_name', array('class'=>'input-text','onChange' =>'nameOnchang(this)','disabled'=>'disabled'));}else{echo $form->textField($model, 'club_name', array('class' => 'input-text','onChange' =>'nameOnchang(this)'));} ?>
                            <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'partnership_type'); ?></td>
                        <td colspan="3">
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->dropDownList($model, 'partnership_type', Chtml::listData(ClubServicerType::model()->findAll('type=1124'), 'member_second_id', 'member_second_name'), array('prompt'=>'请选择','disabled'=>'disabled'));}else{echo $form->dropDownList($model, 'partnership_type', Chtml::listData(ClubServicerType::model()->findAll('type=1124'), 'member_second_id', 'member_second_name'), array('prompt'=>'请选择'));} ?>
                            <?php echo $form->error($model, 'partnership_type', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'club_logo_pic'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'club_logo_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->club_logo_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_club_logo_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>"></a></div><?php }?> 
                            </div>
                            <?php if($model->edit_state==1538||$model->edit_state==721||is_null($model->edit_state)){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_club_logo_pic', '<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'club_logo_pic', $htmlOptions = array()); ?>
                    
                        </td>
                    </tr>
                </table>
            </div>
            <div style="display:none;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'enter_project_id'); ?></td>
                        <td colspan="3">
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->dropDownList($model, 'enter_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt'=>'请选择','disabled'=>'disabled'));}else{echo $form->dropDownList($model, 'enter_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt'=>'请选择'));} ?>
                            <?php echo $form->error($model, 'enter_project_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'approve_state'); ?></td>
                        <td colspan="3">
                            <?php 
                                $vl=BaseCode::model()->getReturn('453');
                            ?>
                            <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array('disabled'=>'disabled'));}else{echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array());} ?>
                            <?php echo $form->error($model, 'approve_state', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                     <td><?php echo $form->labelEx($model, 'qualification_pics'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'qualification_pics', array('class' => 'input-text')); ?>

                            <div class="upload_img fl" id="upload_pic_qualification_pics">
                            <?php  $basepath=BasePath::model()->getPath(126);$picprefix='';
                            foreach($qualification_pics as $v) if($v){ ?>
                            <a class="picbox" data-savepath="<?php echo $v;?>" 
                            href="<?php echo $basepath->F_WWWPATH.$v;?>"target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                            <?php if($model->edit_state==1538||$model->edit_state==721||is_null($model->edit_state)){?>
                            <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i>
                            <?php }?>
                            </a>
                            <?php }?>
                            </div>
                            <?php if($model->edit_state==1538||$model->edit_state==721||is_null($model->edit_state)){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_qualification_pics','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);},5);</script>
                            <?php }?>
                            <?php echo $form->error($model, 'qualification_pics', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div>
            <table id="t8">
                <tr class="table-title">
                    <td colspan="4">操作信息</td>
                </tr>
                <?php if(empty($model->edit_state)||(!empty($model->edit_state)&&$model->edit_state==721)){?>
                <tr>
                    <td colspan="4">
                        <?php if($model->edit_state!=374&&$model->edit_state!=1538&&$model->edit_state!=721&&!is_null($model->edit_state)){
                            echo $form->checkBox($model, 'is_read', array('value'=>649,'disabled'=>'disabled'));
                            }else{
                                echo $form->checkBox($model, 'is_read', array('value'=>649));
                            } ?>
                        <?php echo $form->labelEx($model, 'is_read'); ?>
                        <?php echo $form->error($model, 'is_read', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <td width='10%'><?php echo $form->labelEx($model, 'edit_state'); ?></td>
                    <td colspan="3"><?php echo empty($model->edit_state)?'待认证':$model->edit_state_name; ?></td>
                </tr>
                <?php if(!empty($model->edit_state)&&($model->edit_state==371||$model->edit_state==2||$model->edit_state==373||$model->edit_state==1538)&&(empty($_REQUEST['index'])||(!empty($_REQUEST['index'])&&$_REQUEST['index']!=6))){?>
                    <tr>
                        <td width='15%'><?php echo $form->labelEx($model, 'edit_reasons_for_failure'); ?></td>
                        <td width='85%' colspan="3">
                            <?php if(!empty($_REQUEST['index'])&&$_REQUEST['index']==2){?>
                                <?php echo $form->textArea($model, 'edit_reasons_for_failure', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'edit_reasons_for_failure', $htmlOptions = array()); ?>
                            <?php }else{ ?>
                                <?php echo $form->textArea($model, 'edit_reasons_for_failure', array('class' => 'input-text','readonly'=>'readonly')); ?>
                                <?php echo $form->error($model, 'edit_reasons_for_failure', $htmlOptions = array()); ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php }?>
                <?php if((isset($_REQUEST['index'])&&($_REQUEST['index']==6||$_REQUEST['index']==2))||(isset($_REQUEST['s'])&&$_REQUEST['s']==1)||$_REQUEST['id']==='[:club_id]'){?>
                <tr>
                    <td width='10%'>可执行操作</td>
                    <td colspan="3">
                        <?php 
                            if($model->edit_state==371){
                                if($_REQUEST['id']=='[:club_id]'||(!empty($_REQUEST['index'])&&$_REQUEST['index']==6)||(!empty($_REQUEST['s'])&&$_REQUEST['s']==1)){
                                    if($model->id==get_session('club_id')){
                                        echo '<button id="quxiao" onclick="submitType='."'quxiao'".'" class="btn btn-blue" type="submit"> 撤销申请</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }else{
                                        // echo '已提交,待管理员审核';
                                        echo show_shenhe_box(array('quxiao'=>'撤销申请')).'<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }
                                }else{
                                    echo show_shenhe_box(array('tongguo'=>'审核通过','tuihui'=>'退回修改','butongguo'=>'审核不通过')).'<button class="btn" type="button" onclick="we.back();">取消</button>';
                                }
                            }else if($model->edit_state==721||empty($model->edit_state)){
                                // echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                                echo '<button id="baocun" onclick="submitType='."'baocun'".'" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit"> 提交审核</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif($model->edit_state==2){
                                echo '审核通过';
                            }elseif($model->edit_state==373){
                                // if($_REQUEST['id']=='[:club_id]'||!empty($_REQUEST['s'])&&$_REQUEST['s']==1){
                                //     echo '<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit">重新提交审核</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                // }else{
                                    echo '审核未通过';
                                // }
                            }elseif($model->edit_state==374){
                                echo '<button id="baocun" onclick="submitType='."'baocun'".'" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit"> 提交审核</button>';
                            }elseif($model->edit_state==1538){
                                if($_REQUEST['id']==='[:club_id]'||!empty($_REQUEST['s'])&&$_REQUEST['s']==1){
                                    echo '<button id="baocun" onclick="submitType='."'baocun'".'" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit"> 提交审核</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                }else{
                                    echo $model->edit_state_name;
                                }
                            }
                        ?>
                    </td>
                </tr>
                <?php }?>
                <!-- <tr>
                    <td rowspan="2">操作记录</td>
                    <td>操作人</td>
                    <td>操作时间</td>
                    <td>操作内容</td>
                <tr>
                    <td><?php //echo $model->reasons_adminname; ?></td>
                    <td><?php //echo $model->uDate; ?></td>
                    <td><?php //echo $model->edit_state_name; ?></td>
                </tr> -->
            </table>
        </div>
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
        return true;
    });

    $(function(){
        var $start_time=$('#ClubListZlhb_taxpayer_start_time');
        var $end_time=$('#ClubListZlhb_taxpayer_end_time');
        $start_time.on('click', function(){
            var end_input=$dp.$('ClubListZlhb_taxpayer_end_time')
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();},});
        });
        $end_time.on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

//城市联动
function showArea(obj){
        var show_id=$(obj).val();
        // var club_area_code=$("#ClubList_club_area_code").val().split(',');
        // console.log(club_area_code)
        if($(obj).attr("value")==1){
            $("#ClubList_club_area_code2,#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListZlhb_club_area_city,#ClubListZlhb_club_area_district,#ClubListZlhb_club_area_township").val('');
            $("#ClubListZlhb_club_area_province").val($(obj).find("option[value='"+show_id+"']").text());
            // club_area_code.push(show_id);
        }else if($(obj).attr("value")==2){
            $("#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListZlhb_club_area_district,#ClubListZlhb_club_area_township").val('');
            $("#ClubListZlhb_club_area_city").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==3){
            $("#ClubList_club_area_code4").remove();
            $("#ClubListZlhb_club_area_township").val('');
            $("#ClubListZlhb_club_area_district").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==4){
            $("#ClubListZlhb_club_area_township").val($(obj).find("option[value='"+show_id+"']").text());
        }
        var area_arr=[];
        $("#t3 tr:eq(2) td:eq(1) select").each(function(){
            area_arr.push($(this).val());
        })
        $("#ClubListZlhb_club_area_code").val(area_arr.join(","))
        if(show_id>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('scales');?>&info_id='+show_id,
                dataType: 'json',
                success: function(data) {
                    var content='';
                    if(data[0].level==2){
                        $("#t3 tr:eq(2) td:eq(1)").append('<select name="area[2][club_area_code]" id="ClubList_club_area_code2" onchange="showArea(this)" value="2" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==2){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code2").append(content);
                    }else if(data[0].level==3){
                        $("#t3 tr:eq(2) td:eq(1)").append('<select name="area[3][club_area_code]" id="ClubList_club_area_code3" onchange="showArea(this)" value="3" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==3){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code3").append(content);
                    }else if(data[0].level==4){
                        $("#t3 tr:eq(2) td:eq(1)").append('<select name="area[4][club_area_code]" id="ClubList_club_area_code4" onchange="showArea(this)" value="4" style="margin-right:10px;"><option value="">请选择</option></select>');
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

    // 是否入驻首个项目
    var is_click=false;
    $("#shenhe").on("click",function(){
        if(!is_click){
            var can1 = function(){
                is_click=true;
                $("#shenhe").click();
            }
            if($('#ClubListZlhb_enter_project_id').val()==''){
                $.fallr('show', {
                    buttons: {
                        button1: {text: '是', danger: true, onclick: can1},
                        button2: {text: '否'}
                    },
                    content: '未选择入驻项目，是否未入驻项目提交？',
                    // icon: 'trash',
                    afterHide: function() {
                        we.loading('hide');
                    }
                });
                return false;
            }
        }
        is_click=false;
    })
    

    // 验证名称是否被注册
    function nameOnchang(obj){
        var changval=$(obj).val();
        // if (changval.length>=6) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('exist');?>&name='+changval,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    if(data.status==0){
                        $(obj).val('');
                        we.msg('minus', data.msg);
                    }
                }
            });
        // }
    }

    
// 滚动图片处理
var $upload_pic_qualification_pics=$('#upload_pic_qualification_pics');
var $upload_box_Cqualification_pics=$('#upload_box_qualification_pics');

// 添加或删除时，更新图片
var fnUpdatescrollPic=function(){
    var arr=[];var s1="";
    $upload_pic_qualification_pics.find('a').each(function(){
         s1=$(this).attr('data-savepath');
        //console.log(s1);
        if(s1!=""){
        arr.push($(this).attr('data-savepath'));}
    });
    $('#ClubListZlhb_qualification_pics').val(we.implode(',',arr));
    $upload_box_qualification_pics.show();
    if(arr.length>=5) {  $upload_box_qualification_pics.hide();}
};
// 上传完成时图片处理
var fnscrollPic=function(savename,allpath){
    $upload_pic_qualification_pics.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
    fnUpdatescrollPic();
};
$("#ClubListZlhb_taxpayer_type .input-check[type='radio']").on("change",function(){
    if($(this).val()==649){
        $("#taxpayer_pic").show();
    }else{
        $("#taxpayer_pic").hide();
    }
})
</script>
