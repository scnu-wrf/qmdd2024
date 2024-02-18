<style>
    .upload_img a {
        width: 100px;
        height: 100px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
        vertical-align: middle;
    }

    .upload_img a img {
        width: auto !important;
        height: auto !important;
        max-width: 100%;
        max-height: 100%;
    }

    table {
        table-layout: auto !important;
    }

    .progress li {
        width: calc(100% / 4);
    }
</style>
<?php
// if($model->state==2){
//     $left='calc((100% / 4) / 2)';
//     $right='calc(100% - (100% / 4) / 2)';
//     $float='calc(((100% / 4) / 2) - 2.5% - 5px)';
// }else
if ($model->state == 2 && $model->edit_state == 721) {
    $left = 'calc(50% - 25% / 2)';
    $right = 'calc(50% + 25% / 2)';
    $float = 'calc(50% - 25% / 2 - 2.5% - 5px)';
} elseif ($model->state == 2 && $model->edit_state == 371) {
    $left = 'calc(50% + 25% / 2)';
    $right = 'calc(50% - 25% / 2)';
    $float = 'calc(50% + 25% / 2 - 2.5% - 5px)';
} elseif ($model->state == 2 && $model->edit_state == 2) {
    $left = '100%';
    $right = '0';
    $float = 'calc(100% - (100% / 4) / 2 - 2.5% - 5px)';
} else {
    $left = 'calc(50% + 25% / 2)';
    $right = 'calc(50% - 25% / 2)';
    $float = 'calc(50% + 25% / 2 - 2.5% - 5px)';
}
// var_dump($_REQUEST);
?>
<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：首页》账号管理》供应商认证</span></h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
    <div class="box-detail">
        <div class="progress">
            <div class="progress_bar">
                <div class="progress_left" style="width:<?php echo $left; ?>;"></div>
                <div class="progress_right" style="width:<?php echo $right; ?>;"></div>
                <div class="progress_float" style="left:<?php echo $float; ?>"></div>
            </div>
            <ul>
                <li>意向审核</li>
                <li>提交信息认证</li>
                <li>信息认证审核</li>
                <li>信息认证完成</li>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table id="t3" width="100%" style="table-layout:auto;">
                    <?php echo $form->hiddenField($model, 'club_type', array('class' => 'input-text', 'value' => 380)); ?>
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
                        <td width="10%" style="width:10%"><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td width="40%">
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'company', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'company', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>
                        </td>
                        <td width="10%"><?php echo $form->labelEx($model, 'company_type_id'); ?></td>
                        <td width="40%">
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1089), 'f_id', 'F_NAME'), array('prompt' => '请选择', "disabled" => "disabled"));
                            } else {
                                echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1089), 'f_id', 'F_NAME'), array('prompt' => '请选择'));
                            } ?>
                            <?php echo $form->error($model, 'company_type_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2"><?php echo $form->labelEx($model, 'club_address'); ?></td>
                        <td colspan="3">
                            <label style="margin-right:20px;">

                                <?php if (!empty($model->id) && $model->state != 721) { ?>
                                    <select name="province" disabled="disabled"></select>
                                    <select name="city" disabled="disabled"></select>
                                    <select name="area" disabled="disabled"></select>
                                <?php } else { ?>
                                    <select name="province"></select><select name="city"></select><select name="area"></select>
                                <?php } ?>



                                <script>
                                    new PCAS("province", "city", "area", "<?php echo $province; ?>", "<?php echo $city; ?>", "<?php echo $area; ?>");
                                </script>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php if (!empty($model->id)) {
                                echo $form->textField($model, 'club_address', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'club_address', array('class' => 'input-text', 'placeholder' => '详细地址'));
                            } ?>
                            <?php echo $form->error($model, 'club_address', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'valid_until_start'); ?></td>
                        <td>
                            <?php if (!empty($model->id)) {
                                echo $form->textField($model, 'valid_until_start', array('class' => 'input-text', 'disabled' => 'disabled', 'style' => 'width:100px;', 'placeholder' => '开始时间'));
                            } else {
                                echo $form->textField($model, 'valid_until_start', array('class' => 'input-text', 'style' => 'width:100px;', 'placeholder' => '开始时间'));
                            } ?>
                            <?php echo $form->error($model, 'valid_until_start', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'valid_until'); ?></td>
                        <td>
                            <?php if (!empty($model->id)) {
                                echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'disabled' => 'disabled', 'style' => 'width:100px;', 'placeholder' => '有效期'));
                            } else {
                                echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'style' => 'width:100px;', 'placeholder' => '有效期'));
                            } ?>
                            <?php echo $form->error($model, 'valid_until', $htmlOptions = array()); ?>
                            <!--<br><span class="msg">*未填写默认为“长期有效”</span>-->
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'certificates'); ?> </td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'certificates', array('class' => 'input-text fl')); ?>
                            <?php $basepath = BasePath::model()->getPath(219);
                            $picprefix = '';
                            if ($basepath != null) {
                                $picprefix = $basepath->F_CODENAME;
                            } ?>
                            <?php if ($model->certificates != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_certificates"><a href="<?php echo $basepath->F_WWWPATH . $model->certificates; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->certificates; ?>" width="100"></a></div><?php } ?>
                            <?php if (empty($model->id) || $model->state == 721) { ?>
                                <script>
                                    we.uploadpic('<?php echo get_class($model); ?>_certificates', '<?php echo $picprefix; ?>');
                                </script>
                            <?php } ?>
                            <?php echo $form->error($model, 'certificates', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table width="100%" id="t2" class="mt15" style=" table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">联系人信息</td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'apply_gfaccount'); ?></td>
                        <td width="40%">

                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'apply_gfaccount', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'apply_gfaccount', array('class' => 'input-text', 'onChange' => 'accountOnchang(this)'));
                            } ?>
                            <?php echo $form->error($model, 'apply_gfaccount', $htmlOptions = array()); ?>
                        </td>
                        <td width="10%"><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                        <td width="40%">
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'apply_name', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'apply_name', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'apply_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'contact_phone'); ?></td>
                        <td>
                            <?php if (!empty($model->id)) {
                                echo $form->textField($model, 'contact_phone', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'contact_phone', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td>
                            <?php if (!empty($model->id)) {
                                echo $form->textField($model, 'email', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'email', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>

                <table id="t5" class="mt15" width="100%" style="table-layout: auto;">
                    <tr class="table-title">
                        <td colspan="4">公司法人/机构负责人信息</td>
                    </tr>
                    <tr>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_gfnick'); ?> </td>
                        <td>
                            <?php
                            if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                                echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text'));
                            } else {
                                echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }
                            ?>
                            <?php echo $form->error($model, 'apply_club_gfnick', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_phone'); ?> </td>
                        <td>


                            <?php
                            if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                                echo $form->textField($model, 'apply_club_phone', array('class' => 'input-text'));
                            } else {
                                echo $form->textField($model, 'apply_club_phone', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }
                            ?>
                            <?php echo $form->error($model, 'apply_club_phone', $htmlOptions = array()); ?>


                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_club_id_card'); ?> </td>
                        <td colspan="3">
                            <?php
                            if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                                echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text'));
                            } else {
                                echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }
                            ?>
                            <?php echo $form->error($model, 'apply_club_id_card', $htmlOptions = array()); ?>
                        </td>

                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'id_card_face'); ?> </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'id_card_face', array('class' => 'input-text fl')); ?>
                            <?php $basepath = BasePath::model()->getPath(214);
                            $picprefix = '';
                            if ($basepath != null) {
                                $picprefix = $basepath->F_CODENAME;
                            } ?>
                            <?php if ($model->id_card_face != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_id_card_face"><a href="<?php echo $basepath->F_WWWPATH . $model->id_card_face; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->id_card_face; ?>"></a></div><?php } ?>
                            <?php if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) { ?>
                                <script>
                                    we.uploadpic('<?php echo get_class($model); ?>_id_card_face', '<?php echo $picprefix; ?>');
                                </script>
                            <?php } ?>
                            <?php echo $form->error($model, 'id_card_face', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'id_card_back'); ?> </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'id_card_back', array('class' => 'input-text fl')); ?>
                            <?php $basepath = BasePath::model()->getPath(214);
                            $picprefix = '';
                            if ($basepath != null) {
                                $picprefix = $basepath->F_CODENAME;
                            } ?>
                            <?php if ($model->id_card_back != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_id_card_back"><a href="<?php echo $basepath->F_WWWPATH . $model->id_card_back; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->id_card_back; ?>"></a></div><?php } ?>
                            <?php if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) { ?>
                                <script>
                                    we.uploadpic('<?php echo get_class($model); ?>_id_card_back', '<?php echo $picprefix; ?>');
                                </script>
                            <?php } ?>
                            <?php echo $form->error($model, 'id_card_back', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table id="t4" width="100%" style="table-layout:auto; margin-top:10px;">
                    <tr class="table-title">
                        <td colspan="4">银行账号信息</td>
                    </tr>
                    <tr>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'bank_name'); ?> </td>
                        <td>
                            <?php
                            if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                                echo $form->textField($model, 'bank_name', array('class' => 'input-text'));
                            } else {
                                echo $form->textField($model, 'bank_name', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }
                            ?>
                            <?php echo $form->error($model, 'bank_name', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'bank_branch_name'); ?> </td>
                        <td>
                            <?php
                            if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                                echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text'));
                            } else {
                                echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }
                            ?>
                            <?php echo $form->error($model, 'bank_branch_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_account'); ?> </td>
                        <td colspan="3">
                            <?php
                            if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                                echo $form->textField($model, 'bank_account', array('class' => 'input-text'));
                            } else {
                                echo $form->textField($model, 'bank_account', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }
                            ?>
                            <?php echo $form->error($model, 'bank_account', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_pic'); ?> </td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'bank_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath = BasePath::model()->getPath(214);
                            $picprefix = '';
                            if ($basepath != null) {
                                $picprefix = $basepath->F_CODENAME;
                            } ?>
                            <?php if ($model->id_card_back != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_bank_pic"><a href="<?php echo $basepath->F_WWWPATH . $model->bank_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->bank_pic; ?>"></a></div><?php } ?>
                            <?php if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) { ?>
                                <script>
                                    we.uploadpic('<?php echo get_class($model); ?>_bank_pic', '<?php echo $picprefix; ?>');
                                </script>
                            <?php } ?>
                            <?php echo $form->error($model, 'bank_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>

                </table>
                <table id="t6" width="100%" style="table-layout:auto; margin-top:10px;">
                    <tr class="table-title">
                        <td colspan="4">纳税人资格信息</td>
                    </tr>

                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'taxpayer_type'); ?></td>
                        <td width="90%" colspan="3">
                            <?php
                            if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                                echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
                            } else {
                                echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'disabled' => 'disabled', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
                            }
                            ?>
                            <?php echo $form->error($model, 'taxpayer_type'); ?>
                        </td>
                    </tr>
                    <tr id="taxpayer_pic" <?php //if(empty($model->taxpayer_type)&&$model->taxpayer_type!=649)echo 'style="display:none;"'
                                            ?>>
                        <td><?php echo $form->labelEx($model, 'taxpayer_pic'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'taxpayer_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath = BasePath::model()->getPath(123);
                            $picprefix = '';
                            if ($basepath != null) {
                                $picprefix = $basepath->F_CODENAME;
                            } ?>
                            <?php if ($model->taxpayer_pic != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_taxpayer_pic"><a href="<?php echo $basepath->F_WWWPATH . $model->taxpayer_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->taxpayer_pic; ?>"></a></div><?php } ?>
            </div>
            <?php if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) { ?>
                <script>
                    we.uploadpic('<?php echo get_class($model); ?>_taxpayer_pic', '<?php echo $picprefix; ?>');
                </script>
            <?php } ?>
            <?php echo $form->error($model, 'taxpayer_pic', $htmlOptions = array()); ?>
            </td>
            </tr>
            </table>
            <table id="t6" width="100%" style="table-layout:auto; margin-top:10px;">
                <tr class="table-title">
                    <td colspan="4">商家资质</td>
                </tr>
                <tr>
                    <td width="10%"><?php echo $form->labelEx($model, 'qualification_pics'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'qualification_pics', array('class' => 'input-text')); ?>

                        <div class="upload_img fl" id="upload_pic_qualification_pics">
                            <?php $basepath = BasePath::model()->getPath(126);
                            $picprefix = '';
                            foreach ($qualification_pics as $v) if ($v) { ?>
                                <a class="picbox" data-savepath="<?php echo $v; ?>" href="<?php echo $basepath->F_WWWPATH . $v; ?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH . $v; ?>" width="100">
                                    <?php if ($model->edit_state == 1538 || $model->edit_state == 721 || is_null($model->edit_state)) { ?>
                                        <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i>
                                    <?php } ?>
                                </a>
                            <?php } ?>
                        </div>
                        <?php if ($model->edit_state == 1538 || $model->edit_state == 721 || is_null($model->edit_state)) { ?>
                            <script>
                                we.uploadpic('<?php echo get_class($model); ?>_qualification_pics', '<?php echo $picprefix; ?>', '', '', function(e1, e2) {
                                    fnscrollPic(e1.savename, e1.allpath);
                                }, 5);
                            </script>
                        <?php } ?>
                        <?php echo $form->error($model, 'qualification_pics', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table width="100%" id="t2" class="mt15" style=" table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">商家信息</td>
                </tr>
                <tr>
                    <td width="10%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                    <td width="40%">
                        <?php
                        if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374|| $model->edit_state == 1538) {
                            echo $form->textField($model, 'club_name', array('class' => 'input-text','onChange' => 'nameOnchang(this)'));
                        } else {
                            echo $form->textField($model, 'club_name', array('class' => 'input-text','onChange' => 'nameOnchang(this)', 'disabled' => 'disabled'));
                        }
                        ?>
                        <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                    </td>
                    <td style="width:10%;"><?php echo $form->labelEx($model, 'partnership_type'); ?></td>
                    <td width="40%">
                        <?php if ($model->edit_state != 1538 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                            echo $form->dropDownList($model, 'partnership_type', Chtml::listData(ClubServicerType::model()->findAll('type=1471'), 'member_second_id', 'member_second_name'), array('prompt' => '请选择', 'disabled' => 'disabled'));
                        } else {
                            echo $form->dropDownList($model, 'partnership_type', Chtml::listData(ClubServicerType::model()->findAll('type=1471'), 'member_second_id', 'member_second_name'), array('prompt' => '请选择'));
                        } ?>
                        <?php echo $form->error($model, 'partnership_type', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'club_logo_pic'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'club_logo_pic', array('class' => 'input-text fl')); ?>
                        <?php $basepath = BasePath::model()->getPath(214);
                        $picprefix = '';
                        if ($basepath != null) {
                            $picprefix = $basepath->F_CODENAME;
                        } ?>
                        <?php if ($model->club_logo_pic != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_club_logo_pic"><a href="<?php echo $basepath->F_WWWPATH . $model->club_logo_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->club_logo_pic; ?>"></a></div><?php } ?>
                        <?php if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) { ?>
                            <script>
                                we.uploadpic('<?php echo get_class($model); ?>_club_logo_pic', '<?php echo $picprefix; ?>');
                            </script>
                        <?php } ?>
                        <?php echo $form->error($model, 'club_logo_pic', $htmlOptions = array()); ?> 
                    </td>
                </tr>
            </table>
        </div>
        <table id="t8" class="mt15" width="100%" style=" table-layout:auto;">
            <tr class="table-title">
                <td colspan="4">操作信息</td>
            </tr>
            <tr>
                <td colspan="4">
                    <?php if ($model->edit_state == "" || $model->edit_state == 721 || $model->edit_state == 374 || $model->edit_state == 1538) {
                        echo $form->checkBox($model, 'is_read', array('value' => 649));
                    } else {
                        echo $form->checkBox($model, 'is_read', array('value' => 649, 'disabled' => 'disabled'));
                    }
                    ?>
                    <?php echo $form->labelEx($model, 'is_read'); ?>
                    <?php echo $form->error($model, 'is_read', $htmlOptions = array()); ?>《<a target="_Blank" href="https://gw.gfinter.net/?device_type=7&c=info&a=page_switch&category=rule&page=supplier_service_protocol" target="_blank">供应商服务协议</a>》
                </td>
            </tr>
            <tr>
                <td width='10%'><?php echo $form->labelEx($model, 'edit_state'); ?></td>
                <td colspan="3"><?php echo empty($model->edit_state) ? '待认证' : $model->edit_state_name; ?></td>
            </tr>
            <?php if($model->edit_state==2||$model->edit_state==373||$model->edit_state==1538){?>
            <tr>
                <td width='10%'><?php echo $form->labelEx($model, 'edit_reasons_for_failure'); ?></td>
                <td width="90%" colspan="3">
                    <?php echo $form->textArea($model, 'edit_reasons_for_failure', array('class' => 'input-text','readonly'=>true)); ?>
                    <?php echo $form->error($model, 'edit_reasons_for_failure', $htmlOptions = array()); ?>
                </td>
            </tr>
            <?php }?>
            <?php if (is_null($model->edit_state) || $model->edit_state == 721 || $model->edit_state == 371 || $model->edit_state == 374 || $model->edit_state == 1538) { ?>
                <tr>
                    <td width="10%">可执行操作</td>
                    <td width="90%" colspan="3">
                        <?php
                            if ($model->edit_state == 371) {
                                // echo '已提交,待管理员审核';
                                echo '<button id="quxiao" onclick="submitType=' . "'quxiao'" . '" class="btn btn-blue" type="submit"> 撤销申请</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                            } else if (empty($model->edit_state) || (!empty($model->edit_state) && $model->edit_state == 721)) {
                                echo '<button id="baocun" onclick="submitType=' . "'baocun'" . '" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType=' . "'shenhe'" . '" class="btn btn-blue" type="submit"> 提交审核</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                            } elseif ($model->edit_state == 2) {
                                echo '审核通过';
                            } elseif ($model->edit_state == 373) {
                                echo '审核未通过';
                            } elseif ($model->edit_state == 374) {
                                echo '<button id="baocun" onclick="submitType=' . "'baocun'" . '" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType=' . "'shenhe'" . '" class="btn btn-blue" type="submit"> 提交审核</button>';
                            } elseif ($model->edit_state == 1538) {
                                echo '<button id="baocun" onclick="submitType=' . "'baocun'" . '" class="btn btn-blue" type="submit"> 保存</button>&nbsp;<button id="shenhe" onclick="submitType=' . "'shenhe'" . '" class="btn btn-blue" type="submit"> 提交审核</button>&nbsp;<button class="btn" type="button" onclick="we.back();">取消</button>';
                            }
                            ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>
    <?php $this->endWidget(); ?>
</div>
<!--box-detail end-->
</div>
<!--box end-->
<script>
    we.tab('.box-detail-tab li', '.box-detail-tab-item', function(index) {
        return true;
    });

    $(function() {
        var $start_time = $('#ClubListGys_taxpayer_start_time');
        var $end_time = $('#ClubListGys_taxpayer_end_time');
        $start_time.on('click', function() {
            var end_input = $dp.$('ClubListGys_taxpayer_end_time')
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd',
                onpicked: function() {
                    end_input.click();
                },
            });
        });
        $end_time.on('click', function() {
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd'
            });
        });
    });


    // 验证名称是否被注册
    function nameOnchang(obj) {
        var changval = $(obj).val();
        // if (changval.length>=6) {
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('exist'); ?>&name=' + changval,
            dataType: 'json',
            success: function(data) {
                console.log(data)
                if (data.status == 0) {
                    $(obj).val('');
                    we.msg('minus', data.msg);
                }
            }
        });
        // }
    }


    // 滚动图片处理
    var $upload_pic_qualification_pics = $('#upload_pic_qualification_pics');
    var $upload_box_Cqualification_pics = $('#upload_box_qualification_pics');

    // 添加或删除时，更新图片
    var fnUpdatescrollPic = function() {
        var arr = [];
        var s1 = "";
        $upload_pic_qualification_pics.find('a').each(function() {
            s1 = $(this).attr('data-savepath');
            //console.log(s1);
            if (s1 != "") {
                arr.push($(this).attr('data-savepath'));
            }
        });
        $('#ClubListGys_qualification_pics').val(we.implode(',', arr));
        $upload_box_qualification_pics.show();
        if (arr.length >= 5) {
            $upload_box_qualification_pics.hide();
        }
    };
    // 上传完成时图片处理
    var fnscrollPic = function(savename, allpath) {
        $upload_pic_qualification_pics.append('<a class="picbox" data-savepath="' +
            savename + '" href="' + allpath + '" target="_blank"><img src="' + allpath + '" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
        fnUpdatescrollPic();
    };



    // 滚动图片处理
    var $club_list_pic = $('#ClubListGys_club_list_pic');
    var $upload_pic_club_list_pic = $('#upload_pic_club_list_pic');
    var $upload_box_club_list_pic = $('#upload_box_Club_list_pic');

    // 添加或删除时，更新图片
    var fnUpdateClub_list_pic = function() {
        var arr = [];
        console.log(123);
        $upload_pic_club_list_pic.find('a').each(function() {
            console.log($(this).attr('data-savepath'));
            arr.push($(this).attr('data-savepath'));
        });
        $club_list_pic.val(we.implode(',', arr));
        $upload_box_club_list_pic.show();
        if (arr.length >= 5) {
            $upload_box_club_list_pic.hide();
        }
    };

    $("#ClubListGys_taxpayer_type .input-check[type='radio']").on("change", function() {
        if ($(this).val() == 649) {
            $("#taxpayer_pic").show();
        } else {
            $("#taxpayer_pic").hide();
        }
    })

</script>