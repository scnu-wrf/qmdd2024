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
    .progress li{
        width: calc(100% / 4);
    }
</style>
<?php        
    // if($model->state==372){
    //     $left='calc((100% / 4) / 2)';
    //     $right='calc(100% - (100% / 4) / 2)';
    //     $float='calc(((100% / 4) / 2) - 2.5% - 5px)';
    // }else
    if($model->state==372&&($model->edit_state==721||is_Null($model->edit_state))){
        $left='calc(50% - 25% / 2)';
        $right='calc(50% + 25% / 2)';
        $float='calc(50% - 25% / 2 - 2.5% - 5px)';
    }elseif($model->state==372&&$model->edit_state==371){
        $left='calc(50% + 25% / 2)';
        $right='calc(50% - 25% / 2)';
        $float='calc(50% + 25% / 2 - 2.5% - 5px)';
    }elseif($model->state==372&&$model->edit_state==372){
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
                    var type_id=$("#ClubListSqdw_taxpayer_type .input-check:checked").val();
                    console.log(type_id)
                    if(type_id==649){
                        if($("#ClubListSqdw_taxpayer_pic").val()==""){
                            hasError=true;
                            data.ClubListSqdw_taxpayer_pic=["一般纳税人证明上传 不能为空"];
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
    
    <div class="box-title c"><h1><?php if($_REQUEST['id']=='0'){echo '当前界面：起始页》账号管理》信息认证';}else{echo '当前界面：社区单位》单位认证管理》单位认证申请》添加》详情';}?></h1><span class="back"><a class="btn" href="javascript:;" onclick="reload();" style="margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list2('baocun"||submitType=="yaoqing')); ?>
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
                    if($model->edit_state==721||($model->edit_state!=1538&&$model->edit_state!=721&&!empty($model->enter_project_id))||empty($model->edit_state)){
                        echo '<li>项目</li>';
                    }
                ?>
            </ul>
        </div>
        <div class="box-detail-bd">
            <?php if($model->individual_enterprise==403){?>
                <div style="display:block;" class="box-detail-tab-item">
                    <table id="t3">
                        <?php echo $form->hiddenField($model, 'club_type', array('class' => 'input-text','value' => 8)); ?>
                        <tr class="table-title">
                            <td colspan="4">基本信息</td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'individual_enterprise'); ?></td>
                            <td>
                                <?php echo $model->individual_enterprise_name;?>
                            </td>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                            <td>
                                <?php echo $model->club_code?>
                            </td>
                        </tr>
                        <tr>
                            <td>申请人<?php echo $form->labelEx($model, 'apply_club_gfaccount'); ?></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'apply_club_gfid'); ?>
                                <?php if(!empty($model->id)){echo $form->textField($model, 'apply_club_gfaccount', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_gfaccount', array('class' => 'input-text','onChange' =>'accountOnchang(this)'));} ?>
                                <?php echo $form->error($model, 'apply_club_gfaccount', $htmlOptions = array()); ?>
                            </td>
                            <td>申请人<?php echo $form->labelEx($model, 'apply_name'); ?></td>
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
                        <tr>
                            <td><?php echo $form->labelEx($model, 'apply_id_card'); ?></td>
                            <td colspan="3">
                                <?php if(!empty($model->id)&&$model->state!=721){echo $form->textField($model, 'apply_id_card', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_id_card', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'apply_id_card', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'contact_id_card_face'); ?> </td>
                                <td>
                                    <?php echo $form->hiddenField($model, 'contact_id_card_face', array('class' => 'input-text fl')); ?>
                                    <?php $basepath=BasePath::model()->getPath(217);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                    <?php if($model->contact_id_card_face!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_contact_id_card_face"><a href="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_face;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_face;?>"></a></div><?php }?>
                                    <?php if($model->state==721){?>
                                    <script>we.uploadpic('<?php echo get_class($model);?>_contact_id_card_face', '<?php echo $picprefix;?>');</script>
                                    <?php }?>
                                    <?php echo $form->error($model, 'contact_id_card_face', $htmlOptions = array()); ?>
                                </td>
                                <td><?php echo $form->labelEx($model, 'contact_id_card_back'); ?> </td>
                                <td>
                                    <?php echo $form->hiddenField($model, 'contact_id_card_back', array('class' => 'input-text fl')); ?>
                                    <?php $basepath=BasePath::model()->getPath(218);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                    <?php if($model->contact_id_card_back!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_contact_id_card_back"><a href="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_back;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->contact_id_card_back;?>"></a></div><?php }?>
                                    <?php if($model->state==721){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_contact_id_card_back', '<?php echo $picprefix;?>');</script>
                                    <?php }?>
                                    <?php echo $form->error($model, 'contact_id_card_back', $htmlOptions = array()); ?>
                                </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'apply_card_id'); ?></td>
                            <td colspan="3">
                                <?php if(!empty($model->id)&&$model->state!=721){echo $form->dropDownList($model, 'apply_card_id', Chtml::listData(BaseCode::model()->getCode(1417), 'f_id', 'F_NAME'), array('prompt'=>'请选择',"disabled"=>"disabled" ));}else{echo $form->dropDownList($model, 'apply_card_id', Chtml::listData(BaseCode::model()->getCode(1417), 'f_id', 'F_NAME'), array('prompt'=>'请选择'));} ?>
                                <?php echo $form->error($model, 'apply_card_id', $htmlOptions = array()); ?>
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
                        <tr>
                            <td rowspan="2"><?php echo $form->labelEx($model, 'club_address'); ?> <?=!empty($model->id)&&$model->state==721?"<span class='required'>*</span>":""?></td>
                            <td colspan="3" id="city">
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
                    <table id="t4">
                        <tr class="table-title">
                            <td colspan="4">银行账号信息(个人账户)</td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'bank_name'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=373&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'bank_name', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_name', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'bank_name', $htmlOptions = array()); ?>
                            </td>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'bank_branch_name'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=373&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'bank_branch_name', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'bank_branch_name', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'bank_account'); ?> </td>
                            <td colspan="3">
                                <?php if($model->edit_state!=373&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'bank_account', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_account', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'bank_account', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                    <table id="t1" >
                        <tr class="table-title">
                            <td colspan="4">服务平台信息</td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                            <td>
                                <?php if($model->edit_state!=373&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'club_name', array('class'=>'input-text','onChange' =>'nameOnchang(this)','disabled'=>'disabled'));}else{echo $form->textField($model, 'club_name', array('class' => 'input-text','onChange' =>'nameOnchang(this)'));} ?>
                                <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                            </td>
                            <?php 
                                $servicer_type=ClubServicerType::model()->find('type=1467');
                                echo $form->hiddenField($model, 'partnership_type', array('value' => $servicer_type->member_second_id));
                            ?>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'club_logo_pic'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'club_logo_pic', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->club_logo_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_club_logo_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>"></a></div><?php }?> 
                                </div>
                                <?php if($model->edit_state==373||$model->edit_state==721||is_Null($model->edit_state)){?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_club_logo_pic', '<?php echo $picprefix;?>');</script>
                                <?php }?>
                                <?php echo $form->error($model, 'club_logo_pic', $htmlOptions = array()); ?>
                        
                            </td>
                        </tr>
                    </table>
                </div>
                <?php }else{?>
                    <div style="display:block;" class="box-detail-tab-item">
                        <table id="t3">
                            <?php echo $form->hiddenField($model, 'club_type', array('class' => 'input-text','value' => 8)); ?>
                            <tr class="table-title">
                                <td colspan="4">基本信息</td>
                            </tr>
                            <tr>
                                <td style="width:10%"><?php echo $form->labelEx($model, 'individual_enterprise'); ?></td>
                                <td>
                                    <?php echo $model->individual_enterprise_name;?>
                                </td>
                                <td style="width:10%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                                <td>
                                    <?php echo $model->club_code?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $form->labelEx($model, 'company'); ?></td>
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
                            <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_gfaccount'); ?></td>
                            <td>
                                <?php echo $form->hiddenField($model, 'apply_club_gfid'); ?>
                                <?php if(!empty($model->id)){echo $form->textField($model, 'apply_club_gfaccount', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_gfaccount', array('class' => 'input-text','onChange' =>'accountOnchang(this)'));} ?>
                                <?php echo $form->error($model, 'apply_club_gfaccount', $htmlOptions = array()); ?>
                            </td>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'apply_name'); ?></td>
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
                    <table class="mt15">
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
                            <td colspan="4">单位法人信息</td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_gfnick'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'apply_club_gfnick', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'apply_club_gfnick', $htmlOptions = array()); ?>
                            </td>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_phone'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'apply_club_phone', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_phone', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'apply_club_phone', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'apply_club_id_card'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'apply_club_id_card', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'apply_club_id_card', $htmlOptions = array()); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'apply_club_email'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'apply_club_email', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'apply_club_email', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'apply_club_email', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'id_card_face'); ?> </td>
                            <td>
                                <?php echo $form->hiddenField($model, 'id_card_face', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(214);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->id_card_face!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_face"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_face;?>"></a></div><?php }?>
                                <?php if($model->edit_state==1538||$model->edit_state==721||is_Null($model->edit_state)){?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_id_card_face', '<?php echo $picprefix;?>');</script>
                                <?php }?>
                                <?php echo $form->error($model, 'id_card_face', $htmlOptions = array()); ?>
                            </td>
                            <td><?php echo $form->labelEx($model, 'id_card_back'); ?> </td>
                            <td>
                                <?php echo $form->hiddenField($model, 'id_card_back', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(215);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->id_card_back!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_back"><a href="<?php echo $basepath->F_WWWPATH.$model->id_card_back;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->id_card_back;?>"></a></div><?php }?>
                                <?php if($model->edit_state==1538||$model->edit_state==721||is_Null($model->edit_state)){?>
                        <script>we.uploadpic('<?php echo get_class($model);?>_id_card_back', '<?php echo $picprefix;?>');</script>
                                <?php }?>
                                <?php echo $form->error($model, 'id_card_back', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                    <table id="t4">
                        <tr class="table-title">
                            <td colspan="4">银行账号信息(单位账户)</td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'bank_name'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'bank_name', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_name', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'bank_name', $htmlOptions = array()); ?>
                            </td>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'bank_branch_name'); ?> </td>
                            <td>
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'bank_branch_name', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'bank_branch_name', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'bank_account'); ?> </td>
                            <td colspan="3">
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'bank_account', array('class'=>'input-text','disabled'=>'disabled'));}else{echo $form->textField($model, 'bank_account', array('class' => 'input-text'));} ?>
                                <?php echo $form->error($model, 'bank_account', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                    <table id="t6">
                        <tr class="table-title">
                            <td colspan="4">纳税资格信息</td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'taxpayer_type'); ?></td>
                            <td colspan="3">
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '','disabled'=>'disabled', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));}else{echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));} ?>
                                <?php echo $form->error($model, 'taxpayer_type'); ?>
                            </td>
                        </tr>
                        <tr id="taxpayer_pic" <?php if(!empty($model->taxpayer_type)&&$model->taxpayer_type!=649)echo 'style="display:none;"'?> >
                            <td style="width:10%"><?php echo $form->labelEx($model, 'taxpayer_pic'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'taxpayer_pic', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->taxpayer_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_taxpayer_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->taxpayer_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->taxpayer_pic;?>"></a></div><?php }?> 
                                </div>
                                <?php if($model->edit_state==1538||$model->edit_state==721||is_Null($model->edit_state)){?>
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
                            <td style="width:10%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                            <td colspan="3">
                                <?php if($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->textField($model, 'club_name', array('class'=>'input-text','onChange' =>'nameOnchang(this)','disabled'=>'disabled'));}else{echo $form->textField($model, 'club_name', array('class' => 'input-text','onChange' =>'nameOnchang(this)'));} ?>
                                <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                                <?php 
                                    $servicer_type=ClubServicerType::model()->find('type=1467');
                                    echo $form->hiddenField($model, 'partnership_type', array('value' => $servicer_type->member_second_id));
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'club_logo_pic'); ?></td>
                            <td colspan="3">
                                <?php echo $form->hiddenField($model, 'club_logo_pic', array('class' => 'input-text fl')); ?>
                                <?php $basepath=BasePath::model()->getPath(123);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                                <?php if($model->club_logo_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_club_logo_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->club_logo_pic;?>"></a></div><?php }?> 
                                </div>
                                <?php if($model->edit_state==1538||$model->edit_state==721||is_Null($model->edit_state)){?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_club_logo_pic', '<?php echo $picprefix;?>');</script>
                                <?php }?>
                                <?php echo $form->error($model, 'club_logo_pic', $htmlOptions = array()); ?>
                        
                            </td>
                        </tr>
                    </table>
                </div>
                <?php }?>
                <div style="display:none;" class="box-detail-tab-item">
                    <table>
                        <tr class="table-title" style="font-weight: bold;">
                            <td colspan="4">入驻项目信息</td>
                        </tr>
                        <tr>
                            <td style="width:10%"><?php echo $form->labelEx($model, 'enter_project_id'); ?></td>
                            <td colspan="3">
                                <?php
                                if(empty($model->enter_project_id)){
                                    $p_count=0;
                                }else{
                                    $p_count=QualificationClub::model()->count('club_id='.$model->id.' and project_id='.$model->enter_project_id.' and state<>338 and state<>787 and state<>499');
                                }
                                ?>
                                <?php if(($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state))||$p_count>0){echo $form->dropDownList($model, 'enter_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt'=>'请选择','disabled'=>'disabled'));}else{echo $form->dropDownList($model, 'enter_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt'=>'请选择'));} ?>
                                <?php echo $form->error($model, 'enter_project_id', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $form->labelEx($model, 'approve_state'); ?></td>
                            <td colspan="3">
                                <?php 
                                    if($model->club_type==8){
                                        $vl=BaseCode::model()->getApproveState();
                                    }else{
                                        $vl=BaseCode::model()->getReturn('453');
                                    }
                                ?>
                                <?php if(($model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state))||$p_count>0){echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>'disabled'));}else{echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array('prompt'=>'请选择',));} ?>
                                <?php echo $form->error($model, 'approve_state', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    </table>
                    <div class="box-table" style="padding:0;border-radius:0;">
                        <table class="mt15 list" style="border-radius: 0;">
                            <tr class="table-title" style="font-weight: bold;">
                                <td colspan="9">项目服务者信息</td>
                                <?php if($model->edit_state==1538||$model->edit_state==721||empty($model->edit_state)){?> 
                                    <td>
                                        <a class="btn" href="javascript:;" onclick="fnInvite();"><i class="fa fa-plus"></i>添加</a>
                                    </td>
                                <?php }?> 
                            </tr>
                            <tr class="table-title">
                                <td style="padding:5px">服务者类型</td>
                                <td style="padding:5px">服务者编号</td>
                                <td style="padding:5px">GF账号</td>
                                <td style="padding:5px">姓名</td>
                                <td style="padding:5px">项目</td>
                                <td style="padding:5px">资质等级</td>
                                <td style="padding:5px">服务者等级</td>
                                <td style="padding:5px">状态</td>
                                <td style="padding:5px">操作时间</td>
                                <?php if($model->edit_state==1538||$model->edit_state==721||empty($model->edit_state)){?> 
                                    <td style="padding:5px">操作</td>
                                <?php }?> 
                            </tr>
                            <?php if(!empty($model2)){$index = 1;foreach($model2 as $info){
                                $code=QualificationsPerson::model()->find("id=".$info->qualification_person_id.' and qualification_project_id='.$model->enter_project_id);  
                            ?>
                            <tr>
                                <td style=" padding:5px"><?php echo $info->type_name;?></td>
                                <td style=" padding:5px"><?php echo !empty($code->qualification_gf_code)?$code->qualification_gf_code:'';?></td>
                                <td style=" padding:5px"><?php echo !empty($code->qualification_gfaccount)?$code->qualification_gfaccount:'';?></td>
                                <td style=" padding:5px"><?php echo !empty($code->qualification_name)?$code->qualification_name:'';?></td>
                                <td style=" padding:5px"><?php echo $info->project_name;?></td>
                                <td style=" padding:5px"><?php echo !empty($code->qualification_title)?$code->qualification_title:'';?></td>
                                <td style=" padding:5px"><?php echo !empty($code->qualification_level_name)?$code->qualification_level_name:'';?></td>
                                <td style=" padding:5px"><?php echo $info->state_name;?></td>
                                <td style=" padding:5px"><?php echo $info->udate;?></td>
                                <?php if($model->edit_state==1538||$model->edit_state==721||empty($model->edit_state)){?> 
                                <td style="padding:5px">    
                                    <?php if($info->state==498){?>
                                        <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $info->id;?>', cancel);" title="撤销邀请"><i class="fa fa-reply"></i></a>
                                    <?php }?>
                                    <?php if($info->state==337){?>
                                    <a class="btn" href="javascript:;" onclick="fnDeleteInvite(<?php echo $info->id;?>);" title="解除绑定"><i class="fa fa-scissors"></i></a>
                                    <?php }?>
                                    <?php if($info->state==497){?>
                                        <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $info->id;?>', canceldel);" title="撤销解除"><i class="fa fa-reply"></i></a>
                                    <?php }?>
                                    <?php if($info->state==496){?>
                                        <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $info->id;?>, 'yes');" title="同意申请"><i class="fa fa-check"></i></a>
                                        <a class="btn" href="javascript:;" onclick="fnPassInvite(<?php echo $info->id;?>, 'no');" title="拒绝申请"><i class="fa fa-minus-circle"></i></a>
                                    <?php }?>
                                    <?php if($info->state==339){?>
                                        <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $info->id;?>, 'yes');" title="同意解除"><i class="fa fa-check"></i></a>
                                        <!-- <a class="btn" href="javascript:;" onclick="fnIsdelInvite(<?php echo $info->id;?>, 'no');" title="拒绝解除"><i class="fa fa-minus-circle"></i></a> -->
                                    <?php }?>
                                    <?php if($info->state==499||$info->state==338||$info->state==787){?>
                                    <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $info->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                                    <?php } ?>
                                    <a class="btn" href="<?php echo $this->createUrl('clubQualificationPerson/update', array('id'=>$info->qualification_person_id));?>" title="服务者信息"><i class="fa fa-edit"></i></a>
                                </td>
                                <?php } ?>
                            </tr>
                        <?php $index++;}} ?>
                    </table>
                </div>
            </div>
            <table id="t8" class="mt15">
                <tr class="table-title">
                    <td colspan="4">操作信息</td>
                </tr>
                <?php if(empty($model->edit_state)||(!empty($model->edit_state)&&$model->edit_state==721)){?>
                    <tr>
                        <td colspan="4">
                            <?php if($model->edit_state!=374&&$model->edit_state!=1538&&$model->edit_state!=721&&!is_Null($model->edit_state)){echo $form->checkBox($model, 'is_read', array('value'=>649,'disabled'=>'disabled'));}else{echo $form->checkBox($model, 'is_read', array('value'=>649));} ?>
                            <?php echo $form->labelEx($model, 'is_read'); ?>
                            <?php echo $form->error($model, 'is_read', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td width='10%'><?php echo $form->labelEx($model, 'edit_state'); ?></td>
                    <td colspan="3"><?php echo empty($model->edit_state)?'待认证':$model->edit_state_name; ?></td>
                </tr>
                <?php if(!empty($model->edit_state)&&($model->edit_state==371||$model->edit_state==372||$model->edit_state==373||$model->edit_state==1538)&&(empty($_REQUEST['index'])||(!empty($_REQUEST['index'])&&$_REQUEST['index']!=5))){?>
                    <tr>
                        <td width='10%'><?php echo $form->labelEx($model, 'edit_reasons_failure'); ?></td>
                        <td width='90%' colspan="3">
                            <?php if(!empty($_REQUEST['index'])&&$_REQUEST['index']==2){?>
                                <?php echo $form->textArea($model, 'edit_reasons_failure', array('class' => 'input-text')); ?>
                                <?php echo $form->error($model, 'edit_reasons_failure', $htmlOptions = array()); ?>
                            <?php }else{ ?>
                                <?php echo $form->textArea($model, 'edit_reasons_failure', array('class' => 'input-text','readonly'=>'readonly')); ?>
                                <?php echo $form->error($model, 'edit_reasons_failure', $htmlOptions = array()); ?>
                            <?php } ?>
                        </td>
                    </tr>
                <?php }?>
                <?php if((isset($_REQUEST['index'])&&($_REQUEST['index']==5||$_REQUEST['index']==2))||(isset($_REQUEST['s'])&&$_REQUEST['s']==1)||$_REQUEST['id']==='0'){?>
                <tr>
                    <td width='10%'>可执行操作</td>
                    <td colspan="3">
                        <?php 
                            if($model->edit_state==371){
                                if($_REQUEST['id']==='0'||(!empty($_REQUEST['index'])&&$_REQUEST['index']==5)){
                                    if($model->id==get_session('club_id')){
                                        echo '<button id="quxiao" onclick="submitType='."'quxiao'".'" class="btn btn-blue" type="submit"> 撤销申请</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }else{
                                        // echo '已提交,待管理员审核';
                                        echo show_shenhe_box(array('quxiao'=>'撤销申请')).'<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }
                                }else{
                                    echo show_shenhe_box(array('tongguo'=>'审核通过','tuihui'=>'退回修改','butongguo'=>'审核未通过')).'<button class="btn" type="button" onclick="we.back();">取消</button>';
                                }
                            }else if($model->edit_state==721||is_Null($model->edit_state)){
                                // echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                                echo '<button id="baocun" onclick="submitType='."'baocun'".'" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit"> 提交审核</button> <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif($model->edit_state==372){
                                echo '审核通过';
                            }elseif($model->edit_state==373){
                                // if($_REQUEST['id']==='0'||!empty($_REQUEST['s'])&&$_REQUEST['s']==1){
                                //     echo '<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit">重新提交审核</button> <button class="btn" type="button" onclick="we.back();">取消</button>';
                                // }else{
                                    echo '审核未通过';
                                // }
                            }elseif($model->edit_state==374){
                                echo '<button id="baocun" onclick="submitType='."'baocun'".'" class="btn btn-blue" type="submit">保存</button>&nbsp;<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit"> 提交审核</button> <button class="btn" type="button" onclick="we.back();">取消</button>';
                            }elseif($model->edit_state==1538){
                                if($_REQUEST['id']==='0'||!empty($_REQUEST['s'])&&$_REQUEST['s']==1){
                                    echo '<button id="baocun" onclick="submitType='."'baocun'".'" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType='."'shenhe'".'" class="btn btn-blue" type="submit"> 提交审核</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                                }else{
                                    echo $model->edit_state_name;
                                }
                            }
                        ?>
                        <button id="yaoqing" onclick="submitType='yaoqing'" class="btn btn-blue" type="submit" style="display:none">邀请</button>
                    </td>
                </tr>
                <?php }?>
                <!-- <tr>
                    <td rowspan="2">操作记录</td>
                    <td>操作人</td>
                    <td>操作时间</td>
                    <td>操作内容</td>
                </tr>
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
var deleteUrl = '<?php echo $this->createUrl('qualificationClub/delete', array('id'=>'ID'));?>';
var cancel = '<?php echo $this->createUrl('qualificationClub/cancelInvite', array('id'=>'ID'));?>';
var canceldel = '<?php echo $this->createUrl('qualificationClub/cancelDeleteInvite', array('id'=>'ID'));?>';
</script>

<script>
    $(function(){
        var navIndex = sessionStorage.getItem("nav_index");
        $(".box-detail-tab .c li").eq(navIndex).trigger("click");
        sessionStorage.removeItem("nav_index");
    });

    we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
        return true;
    });
    
    function reload(){
        sessionStorage.setItem("nav_index", $(".box-detail-tab .c .current").index());
        window.location.reload(true);
    }

//城市联动
function showArea(obj){
        var show_id=$(obj).val();
        // var club_area_code=$("#ClubList_club_area_code").val().split(',');
        // console.log(club_area_code)
        if($(obj).attr("value")==1){
            $("#ClubList_club_area_code2,#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListSqdw_club_area_city,#ClubListSqdw_club_area_district,#ClubListSqdw_club_area_township").val('');
            $("#ClubListSqdw_club_area_province").val($(obj).find("option[value='"+show_id+"']").text());
            // club_area_code.push(show_id);
        }else if($(obj).attr("value")==2){
            $("#ClubList_club_area_code3,#ClubList_club_area_code4").remove();
            $("#ClubListSqdw_club_area_district,#ClubListSqdw_club_area_township").val('');
            $("#ClubListSqdw_club_area_city").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==3){
            $("#ClubList_club_area_code4").remove();
            $("#ClubListSqdw_club_area_township").val('');
            $("#ClubListSqdw_club_area_district").val($(obj).find("option[value='"+show_id+"']").text());
        }else if($(obj).attr("value")==4){
            $("#ClubListSqdw_club_area_township").val($(obj).find("option[value='"+show_id+"']").text());
        }
        var area_arr=[];
        $("#city select").each(function(){
            area_arr.push($(this).val());
        })
        $("#ClubListSqdw_club_area_code").val(area_arr.join(","))
        if(show_id>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('scales');?>&info_id='+show_id,
                dataType: 'json',
                success: function(data) {
                    var content='';
                    if(data[0].level==2){
                        $("#city").append('<select name="area[2][club_area_code]" id="ClubList_club_area_code2" onchange="showArea(this)" value="2" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==2){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code2").append(content);
                    }else if(data[0].level==3){
                        $("#city").append('<select name="area[3][club_area_code]" id="ClubList_club_area_code3" onchange="showArea(this)" value="3" style="margin-right:10px;"><option value="">请选择</option></select>');
                        $.each(data,function(k,info){
                            if(info.level==3){
                                content+='<option value="'+info.id+'">'+info.region_name_c+'</option>'
                            }
                        })
                        $("#ClubList_club_area_code3").append(content);
                    }else if(data[0].level==4){
                        $("#city").append('<select name="area[4][club_area_code]" id="ClubList_club_area_code4" onchange="showArea(this)" value="4" style="margin-right:10px;"><option value="">请选择</option></select>');
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
            if($('#ClubListSqdw_enter_project_id').val()==''){
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

    // 是否为一般纳税人
    $("#ClubListSqdw_taxpayer_type .input-check[type='radio']").on("change",function(){
        if($(this).val()==649){
            $("#taxpayer_pic").show();
        }else{
            $("#taxpayer_pic").hide();
        }
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
    $('#ClubListSqdw_qualification_pics').val(we.implode(',',arr));
    $upload_box_qualification_pics.show();
    if(arr.length>=5) {  $upload_box_qualification_pics.hide();}
};
// 上传完成时图片处理
var fnscrollPic=function(savename,allpath){
    $upload_pic_qualification_pics.append('<a class="picbox" data-savepath="'+
    savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
    fnUpdatescrollPic();
};

// 邀请服务者
var fnInvite=function(){
    var InviteHtml='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="17%">项目</td>'+
            '<td id="dialog_project_id" value="'+$("#ClubListSqdw_enter_project_id").val()+'">'+$("#ClubListSqdw_enter_project_id").find("option:selected").text()+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td width="17%">服务者类型<input id="dialog_club_id" type="hidden" value="<?php echo $model->id;?>"></td>'+
            '<td><select onchange="fnResetGfid();" id="dialog_type"><?php if(is_array($type)) foreach($type as $v){?><option value="<?php echo $v->member_second_id;?>"><?php echo $v->member_second_name;?></option><?php }?></select></td>'+
        '</tr>'+
        '<tr>'+
            '<td>目标帐号</td>'+
            '<td><input id="dialog_gfid" type="hidden" value=""><span id="account_box"></span><input onclick="fnSelectGfid();" class="btn" type="button" value="选择服务者"></td>'+
        '</tr>'+
        '<tr>'+
            '<td>邀请内容</td>'+
            '<td><textarea id="dialog_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    if($("#ClubListSqdw_enter_project_id").val()==''){
        we.msg('minus', '请选择入驻项目');
        return false;
    }
    if($("#ClubListSqdw_approve_state").val()==''){
        we.msg('minus', '请选择认证方式');
        return false;
    }
    $.dialog({
        id:'yaoqing',
        lock:true,
        opacity:0.3,
        title:'邀请服务者',
        content:InviteHtml,
        button:[
            {
                name:'发送邀请',
                callback:function(){
                    return fnSendInvite();
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};

// 发送邀请
var fnSendInvite=function(){
	var club_id=$('#dialog_club_id').val();
    var project_id=$('#dialog_project_id').attr("value");
	var type_id=$('#dialog_type').val();
    var gfid=$('#dialog_gfid').val();
    var msg=$('#dialog_msg').val();
    if(gfid==''){
        we.msg('minus', '请选择服务者');
        return false;
    }
    we.loading('show');
    $.ajax({
        type: 'post',
        url: '<?php echo $this->createUrl('qualificationClub/inspect');?>',
        data: {club_id: club_id,project_id: project_id,type_id: type_id, gfid:gfid, msg:msg},
        dataType: 'json',
        success: function(data) {
            if(data.status==1){
                sessionStorage.setItem("nav_index", $(".box-detail-tab .c .current").index());
                $("#yaoqing").click();
                we.loading('hide');
                $.dialog.list['yaoqing'].close();
                we.success(data.msg, data.redirect);
            }else{
                we.loading('hide');
                we.msg('minus', data.msg);
            }
        }
    });
    return false;
};

// 更新服务者
var fnUpdateGfid=function(){
    var arr=[];
    var id;
    $('#account_box').find('span').each(function(){
        id=$(this).attr('data-id');
        arr.push(id);
    });
    $('#dialog_gfid').val(we.implode(',', arr));
};
// 选择服务者
var fnSelectGfid=function(){
	var type_id=$('#dialog_type').val();
	var project_id=$('#dialog_project_id').attr("value");
	if(type_id<=0){
        we.msg('minus', '请先选择类别');
        return false;
    }
	// 选择服务者
    var $account_box=$('#account_box');
        $.dialog.data('gfid', 0);
        $.dialog.open('<?php echo $this->createUrl("select/qualification");?>&project_id='+project_id+'&type_id='+type_id,{
        id:'gfzhanghao',
		lock:true,opacity:0.3,
		width:'500px',
		height:'60%',
        title:'选择具体内容',		
        close: function () {
			if($.dialog.data('gfid')>0 && $('#account_item_'+$.dialog.data('gfid')).length==0){
                $account_box.append('<span id="account_item_'+$.dialog.data('gfid')+'" class="label-box" data-id="'+$.dialog.data('gfid')+'">'+$.dialog.data('qualification_gfaccount')+'<i onclick="fnDeleteGfid(this);"></i></span>');
                fnUpdateGfid();
            }
         }
       });
};
// 删除已选择服务者
var fnDeleteGfid=function(op){
    $(op).parent().remove();
    fnUpdateGfid();
};

// 重置目标帐号
var fnResetGfid=function(){
    $('#account_box').html('');
    $('#dialog_gfid').val('');
};

// 解除绑定操作
var fnDeleteInvite=function(invite_id){
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">解除原因</td>'+
            '<td><select id="dialog_type"><?php if(is_array($remove_type)) foreach($remove_type as $v){?><option value="<?php echo $v->id;?>"><?php echo $v->name;?></option><?php }?></select></td>'+
        '</tr>'+
        '<tr>'+
            '<td width="15%">详细说明</td>'+
            '<td><textarea id="dialog_invite_status_337_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'jiechu',
        lock:true,
        opacity:0.3,
        title:'解除绑定',
        content:html,
        button:[
            {
                name:'解除绑定',
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('qualificationClub/deleteInvite');?>&id='+invite_id,
                        data: {invite_id:invite_id,type:$('#dialog_type').val(), msg:$('#dialog_invite_status_337_msg').val()},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['jiechu'].close();
                                we.success(data.msg, data.redirect);
                            }else{
                                we.loading('hide');
                                we.msg('minus', data.msg);
                            }
                        }
                    });
                    return false;
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};

// 通过邀请操作
var fnPassInvite=function(invite_id, type){
    if(type==undefined){ type='yes'; }
    var dialogText='同意申请';
    if(type!='yes'){
        type='no';
        dialogText='拒绝申请';
    }
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">审核留言</td>'+
            '<td><textarea id="dialog_invite2_496_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'tongguoshenqing',
        lock:true,
        opacity:0.3,
        title:dialogText,
        content:html,
        button:[
            {
                name:dialogText,
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('qualificationClub/passInvite');?>&id='+invite_id,
                        data: {invite_id:invite_id, msg:$('#dialog_invite2_496_msg').val(), type:type},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['tongguoshenqing'].close();
                                we.success(data.msg, data.redirect);
                            }else{
                                we.loading('hide');
                                we.msg('minus', data.msg);
                            }
                        }
                    });
                    return false;
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};
// 是否同意退出操作
var fnIsdelInvite=function(invite_id, type){
    if(type==undefined){ type='yes'; }
    var dialogText='同意解除';
    if(type!='yes'){
        type='no';
        dialogText='拒绝解除';
    }
    var html='<div style="width:500px;">'+
    '<table class="box-detail-table showinfo">'+
        '<tr>'+
            '<td width="15%">审核留言</td>'+
            '<td><textarea id="dialog_invite_isdel_msg" class="input-text"></textarea></td>'+
        '</tr>'+
    '</table>'+
    '</div>';
    $.dialog({
        id:'tongyijiechu',
        lock:true,
        opacity:0.3,
        title:dialogText,
        content:html,
        button:[
            {
                name:dialogText,
                callback:function(){
                    we.loading('show');
                    $.ajax({
                        type: 'post',
                        url: '<?php echo $this->createUrl('qualificationClub/isdelInvite');?>&id='+invite_id,
                        data: {invite_id:invite_id, msg:$('#dialog_invite_isdel_msg').val(), type:type},
                        dataType: 'json',
                        success: function(data) {
                            if(data.status==1){
                                $.dialog.list['tongyijiechu'].close();
                                we.success(data.msg, data.redirect);
                            }else{
                                we.loading('hide');
                                we.msg('minus', data.msg);
                            }
                        }
                    });
                    return false;
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};
</script>
