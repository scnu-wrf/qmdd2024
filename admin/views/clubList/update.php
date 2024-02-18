<style>
    .upload_img a {
        width: 100px;
        height: 100px;
        display: inline-flex !important;
        align-items: center;
        justify-content: center;
        border: 1px solid #ccc;
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

    table tr td:nth-child(2n+1) {
        width: 150px;
    }
</style>
<div class="box">
    <div class="box-title c">
        <h1><span>当前界面：首页》得闲体育》GF官方单位》<?= empty($model->id) ? '添加' : '详情'; ?></span></h1>
        <span style="float:right;padding-right:15px;"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
    <div class="box-detail">
        <div class="box-detail-tab" style="border:none;margin-top:10px;">
            <ul class="c">
                <li class="current">信息认证</li>
                <?php
                if ($model->edit_state == 721 || ($model->edit_state != 1538 && $model->edit_state != 721 && !empty($model->enter_project_id)) || is_null($model->edit_state)) {
                    echo '<li>入驻项目</li>';
                }
                ?>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table width="100%" style="table-layout:auto;">
                    <?php echo $form->hiddenField($model, 'club_type', array('value' => 9)); ?>
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <input value="<?php echo @$_GET['id']; ?>" name="sign_id" type="hidden" />
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'club_code'); ?></td>
                        <td colspan="3">
                            <?php echo $model->club_code; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'company'); ?></td>
                        <td width="40%">
                            <?php
                            if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'company', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'company', array('class' => 'input-text', 'onChange' => 'companyOnchang(this)'));
                            }
                            ?>
                            <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>

                        </td>
                        <td width="10%"><?php echo $form->labelEx($model, 'company_type_id'); ?></td>
                        <td width="40%">
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1403), 'f_id', 'F_NAME'), array('prompt' => '请选择', "disabled" => "disabled"));
                            } else {
                                echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1403), 'f_id', 'F_NAME'), array('prompt' => '请选择'));
                            } ?>
                            <?php echo $form->error($model, 'company_type_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2"><?php echo $form->labelEx($model, 'club_address'); ?></span></td>
                        <td colspan="3">
                            <?php echo areaList($model->club_area_code); ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <?php if (!empty($model->id) && $model->state != 721) {
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
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'valid_until_start', array('class' => 'input-text', 'disabled' => 'disabled', 'style' => 'width:100px;', 'placeholder' => '开始时间'));
                            } else {
                                echo $form->textField($model, 'valid_until_start', array('class' => 'input-text', 'style' => 'width:100px;', 'placeholder' => '开始时间'));
                            } ?>
                            <?php echo $form->error($model, 'valid_until_start', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'valid_until'); ?></td>
                        <td>
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'disabled' => 'disabled', 'style' => 'width:100px;', 'placeholder' => '有效期'));
                            } else {
                                echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'style' => 'width:100px;', 'placeholder' => '有效期'));
                            } ?>
                            <?php echo $form->error($model, 'valid_until', $htmlOptions = array()); ?>
                            <br><span class="msg">*未填写默认为“长期有效”</span>
                        </td>
                    </tr>
                    <tr>
                        <!--此外为多国，链接club_list_pic表-->
                        <td><?php echo $form->labelEx($model, 'club_list_pic');
                            if (!empty($model->id)) $club_list_pic = ClubListPic::model()->findall('club_id=' . $model->id); ?></td>
                        <td colspan="3">
                            <div>
                                <?php
                                $v_id = '';
                                if (!empty($club_list_pic)) foreach ($club_list_pic as $d) {
                                    $v_id .= $d->club_aualifications_pic . ',';
                                };
                                echo $form->hiddenField($model, 'club_list_pic', array('class' => 'input-text', 'value' => rtrim($v_id, ',')));
                                ?>
                                <div class="upload_img fl" id="upload_pic_club_list_pic">
                                    <?php $basepath = BasePath::model()->getPath(187);
                                    $picprefix = '';
                                    if ($basepath != null) {
                                        $picprefix = $basepath->F_CODENAME;
                                    }
                                    if (!empty($club_list_pic)) {
                                        if (is_array($club_list_pic)) foreach ($club_list_pic as $v) { ?>
                                            <a class="picbox" data-savepath="<?php echo $v['club_aualifications_pic']; ?>" href="<?php echo $basepath->F_WWWPATH . $v['club_aualifications_pic']; ?>" target="_blank">
                                                <img src="<?php echo $basepath->F_WWWPATH . $v['club_aualifications_pic']; ?>" style="max-height:100px; max-width:100px;">
                                                <?php if (empty($model->id) || $model->state == 721) { ?>
                                                    <i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i>
                                                <?php } ?>
                                            </a>
                                        <?php } ?>
                                    <?php } ?>
                                </div>
                            </div>
                            <?php if (empty($model->id) || $model->state == 721) { ?>
                                <script>
                                    we.uploadpic('<?php echo get_class($model); ?>_club_list_pic', '<?php echo $picprefix; ?>', '', '', function(e1, e2) {
                                        fnClub_list_pic(e1.savename, e1.allpath);
                                    }, 5);
                                </script>
                            <?php } ?>
                            <?php echo $form->error($model, 'club_list_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table width="100%" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">联系人信息</td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'apply_gfaccount'); ?></td>
                        <td width="40%">
                            <?php echo $form->hiddenField($model, 'apply_club_gfid'); ?>
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
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'contact_phone', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'contact_phone', array('class' => 'input-text', 'maxlength' => '11'));
                            } ?>
                            <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'email'); ?></td>
                        <td>
                            <?php if (!empty($model->id) && $model->state != 721) {
                                echo $form->textField($model, 'email', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'email', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="table-title">
                        <td colspan="4">推荐单位</td>
                    </tr>
                    <tr>
                        <td width="10%"><?php echo $form->labelEx($model, 'recommend_clubcode'); ?></td>
                        <td width="40%">
                            <?php echo $form->hiddenField($model, 'recommend'); ?>
                            <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                                echo $form->textField($model, 'recommend_clubcode', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'recommend_clubcode', array('class' => 'input-text', 'onChange' => 'codeOnchang(this)'));
                            } ?>
                        </td>
                        <td width="10%"><?php echo $form->labelEx($model, 'recommend_clubname'); ?></td>
                        <td width="40%">
                            <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                                echo $form->textField($model, 'recommend_clubname', array('class' => 'input-text', 'disabled' => 'disabled', 'readonly' => "readonly"));
                            } else {
                                echo $form->textField($model, 'recommend_clubname', array('class' => 'input-text', 'readonly' => "readonly", "placeholder" => "请输入推荐单位账号"));
                            } ?>
                        </td>
                    </tr>
                </table>
                <table width="100%" style="table-layout: auto;">
                    <tr class="table-title">
                        <td colspan="4">公司法人/机构负责人信息</td>
                    </tr>
                    <tr>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_gfnick'); ?> </td>
                        <td style="width:40%">
                            <?php
                            if ($model->state == "" || $model->state == 721) {
                                echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text'));
                            } else {
                                echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text', 'disabled' => 'disabled'));
                            }
                            ?>
                            <?php echo $form->error($model, 'apply_club_gfnick', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_phone'); ?> </td>
                        <td style="width:40%">
                            <?php
                            if ($model->state == "" || $model->state == 721) {
                                echo $form->textField($model, 'apply_club_phone', array('class' => 'input-text', 'maxlength' => '11'));
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
                            if ($model->state == "" || $model->state == 721) {
                                echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text', 'maxlength' => '18'));
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
                            <?php if ($model->state == "" || $model->state == 721) { ?>
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
                            <?php if ($model->state == "" || $model->state == 721) { ?>
                                <script>
                                    we.uploadpic('<?php echo get_class($model); ?>_id_card_back', '<?php echo $picprefix; ?>');
                                </script>
                            <?php } ?>
                            <?php echo $form->error($model, 'id_card_back', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table>
                    <tr class="table-title">
                        <td colspan="4">银行账号信息</td>
                    </tr>
                    <tr>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'bank_name'); ?> </td>
                        <td style="width:40%">
                            <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                                echo $form->textField($model, 'bank_name', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'bank_name', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'bank_name', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:10%"><?php echo $form->labelEx($model, 'bank_branch_name'); ?> </td>
                        <td style="width:40%">
                            <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                                echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'bank_branch_name', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'bank_branch_name', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_account'); ?> </td>
                        <td colspan="3">
                            <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                                echo $form->textField($model, 'bank_account', array('class' => 'input-text', 'disabled' => 'disabled'));
                            } else {
                                echo $form->textField($model, 'bank_account', array('class' => 'input-text'));
                            } ?>
                            <?php echo $form->error($model, 'bank_account', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'bank_pic'); ?></td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'bank_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath = BasePath::model()->getPath(123);
                            $picprefix = '';
                            if ($basepath != null) {
                                $picprefix = $basepath->F_CODENAME;
                            } ?>
                            <?php if ($model->bank_pic != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_bank_pic"><a href="<?php echo $basepath->F_WWWPATH . $model->bank_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->bank_pic; ?>"></a></div><?php } ?>
            </div>
            <?php if ($model->edit_state == 373 || $model->edit_state == 721 || is_null($model->edit_state)) { ?>
                <script>
                    we.uploadpic('<?php echo get_class($model); ?>_bank_pic', '<?php echo $picprefix; ?>');
                </script>
            <?php } ?>
            <?php echo $form->error($model, 'bank_pic', $htmlOptions = array()); ?>

            </td>
            </tr>
            </table>
            <table>
                <tr class="table-title">
                    <td colspan="4">纳税资格信息</td>
                </tr>
                <tr>
                    <td style="width:10%"><?php echo $form->labelEx($model, 'taxpayer_type'); ?></td>
                    <td colspan="3">
                        <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                            echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'disabled' => 'disabled', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
                        } else {
                            echo $form->radioButtonList($model, 'taxpayer_type', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));
                        } ?>
                        <?php echo $form->error($model, 'taxpayer_type'); ?>
                    </td>
                </tr>
                <tr id="taxpayer_pic" <?php if (!empty($model->taxpayer_type) && $model->taxpayer_type != 649) echo 'style="display:none;"' ?>>
                    <td style="width:10%"><?php echo $form->labelEx($model, 'taxpayer_pic'); ?></td>
                    <td colspan="3">
                        <?php echo $form->hiddenField($model, 'taxpayer_pic', array('class' => 'input-text fl')); ?>
                        <?php $basepath = BasePath::model()->getPath(123);
                        $picprefix = '';
                        if ($basepath != null) {
                            $picprefix = $basepath->F_CODENAME;
                        } ?>
                        <?php if ($model->taxpayer_pic != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_taxpayer_pic"><a href="<?php echo $basepath->F_WWWPATH . $model->taxpayer_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->taxpayer_pic; ?>"></a></div><?php } ?>
        </div>
        <?php if ($model->edit_state == 373 || $model->edit_state == 721 || is_null($model->edit_state)) { ?>
            <script>
                we.uploadpic('<?php echo get_class($model); ?>_taxpayer_pic', '<?php echo $picprefix; ?>');
            </script>
        <?php } ?>
        <?php echo $form->error($model, 'taxpayer_pic', $htmlOptions = array()); ?>
        </td>
        </tr>
        </table>
        <table style="table-layout:auto;">
            <tr class="table-title">
                <td colspan="4">服务平台信息</td>
            </tr>
            <tr>
                <td style="width:10%"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                <td style="width:40%">
                    <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                        echo $form->textField($model, 'club_name', array('class' => 'input-text', 'onChange' => 'nameOnchang(this)', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'club_name', array('class' => 'input-text', 'onChange' => 'nameOnchang(this)'));
                    } ?>
                    <?php echo $form->error($model, 'club_name', $htmlOptions = array()); ?>
                </td>
                <td style="width:10%"><?php echo $form->labelEx($model, 'partnership_type'); ?></td>
                <td style="width:40%">
                    <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                        echo $form->dropDownList($model, 'partnership_type', Chtml::listData(ClubType::model()->findAll('left(f_ctcode,3)="U03" and length(f_ctcode)>3'), 'id', 'f_ctname'), array('prompt' => '请选择', 'disabled' => 'disabled'));
                    } else {
                        echo $form->dropDownList($model, 'partnership_type', Chtml::listData(ClubType::model()->findAll('left(f_ctcode,3)="U03" and length(f_ctcode)>3'), 'id', 'f_ctname'), array('prompt' => '请选择'));
                    } ?>
                    <?php echo $form->error($model, 'partnership_type', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td style="width:10%"><?php echo $form->labelEx($model, 'club_logo_pic'); ?></td>
                <td colspan="3">
                    <?php echo $form->hiddenField($model, 'club_logo_pic', array('class' => 'input-text fl')); ?>
                    <?php $basepath = BasePath::model()->getPath(123);
                    $picprefix = '';
                    if ($basepath != null) {
                        $picprefix = $basepath->F_CODENAME;
                    } ?>
                    <?php if ($model->club_logo_pic != '') { ?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model); ?>_club_logo_pic"><a href="<?php echo $basepath->F_WWWPATH . $model->club_logo_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH . $model->club_logo_pic; ?>"></a></div><?php } ?>
    </div>
    <?php if ($model->edit_state == 373 || $model->edit_state == 721 || is_null($model->edit_state)) { ?>
        <script>
            we.uploadpic('<?php echo get_class($model); ?>_club_logo_pic', '<?php echo $picprefix; ?>');
        </script>
    <?php } ?>
    <?php echo $form->error($model, 'club_logo_pic', $htmlOptions = array()); ?>

    </td>
    </tr>
    </table>
</div>
<div style="display:none;" class="box-detail-tab-item">
    <table>
        <tr>
            <td style="width:10%"><?php echo $form->labelEx($model, 'enter_project_id'); ?></td>
            <td colspan="3">
                <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                    echo $form->dropDownList($model, 'enter_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt' => '请选择', 'disabled' => 'disabled'));
                } else {
                    echo $form->dropDownList($model, 'enter_project_id', Chtml::listData(ProjectList::model()->getProject(), 'id', 'project_name'), array('prompt' => '请选择'));
                } ?>
                <?php echo $form->error($model, 'enter_project_id', $htmlOptions = array()); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'approve_state'); ?></td>
            <td colspan="3">
                <?php
                $vl = BaseCode::model()->getReturn('453');
                ?>
                <?php if ($model->edit_state != 373 && $model->edit_state != 721 && !is_null($model->edit_state)) {
                    echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array('disabled' => 'disabled'));
                } else {
                    echo $form->dropDownList($model, 'approve_state', Chtml::listData($vl, 'f_id', 'F_NAME'), array());
                } ?>
                <?php echo $form->error($model, 'approve_state', $htmlOptions = array()); ?>
            </td>
        </tr>
        <tr>
            <td><?php echo $form->labelEx($model, 'qualification_pics'); ?></td>
            <td colspan="3">
                <?php echo $form->hiddenField($model, 'qualification_pics', array('class' => 'input-text')); ?>

                <div class="upload_img fl" id="upload_pic_qualification_pics">
                    <?php $basepath = BasePath::model()->getPath(126);
                    $picprefix = '';
                    foreach ($qualification_pics as $v) if ($v) { ?>
                        <a class="picbox" data-savepath="<?php echo $v; ?>" href="<?php echo $basepath->F_WWWPATH . $v; ?>" target="_blank">
                            <img src="<?php echo $basepath->F_WWWPATH . $v; ?>" width="100">
                            <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>
                    <?php } ?>
                </div>
                <script>
                    we.uploadpic('<?php echo get_class($model); ?>_qualification_pics', '<?php echo $picprefix; ?>', '', '', function(e1, e2) {
                        fnscrollPic(e1.savename, e1.allpath);
                    }, 5);
                </script>
                <?php echo $form->error($model, 'qualification_pics', $htmlOptions = array()); ?>
            </td>
        </tr>
    </table>
</div>
<table width="100%" style="table-layout:auto;">
    <tr class="table-title">
        <td colspan="4">操作信息</td>
    </tr>
    <tr>
        <td style="width:10%">可执行操作</td>
        <td colspan="3">
            <?php echo show_shenhe_box(array('baocun' => '保存', 'tongguo' => '审核通过')); ?>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </td>
    </tr>
    </tr>
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


    // 验证账号
    function accountOnchang(obj) {
        var changval = $(obj).val();
        console.log(changval);
        // if (changval.length>=6) {
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('validate'); ?>&gf_account=' + changval,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    $('#ClubList_apply_club_gfid').val(data.gfid);
                } else {
                    $(obj).val('');
                    $('#ClubList_apply_club_gfid').val(0);
                    we.msg('minus', data.msg);
                }
            }
        });
        // }
    }

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

    $("#ClubList_taxpayer_type .input-check[type='radio']").on("change", function() {
        if ($(this).val() == 649) {
            $("#taxpayer_pic").show();
        } else {
            $("#taxpayer_pic").hide();
        }
    })
    $('#ClubList_valid_until_start').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D',
            dateFmt: 'yyyy-MM-dd'
        });
    });
    $('#ClubList_valid_until').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D',
            dateFmt: 'yyyy-MM-dd'
        });
    });

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
        $('#ClubList_qualification_pics').val(we.implode(',', arr));
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
    var $club_list_pic = $('#ClubList_club_list_pic');
    var $upload_pic_club_list_pic = $('#upload_pic_club_list_pic');
    var $upload_box_club_list_pic = $('#upload_box_Club_list_pic');

    // 添加或删除时，更新图片
    var fnUpdateClub_list_pic = function() {
        var arr = [];
        $upload_pic_club_list_pic.find('a').each(function() {
            arr.push($(this).attr('data-savepath'));
        });
        $club_list_pic.val(we.implode(',', arr));
        $upload_box_club_list_pic.show();
        if (arr.length >= 5) {
            $upload_box_club_list_pic.hide();
        }
    };
    // 上传完成时图片处理
    var fnClub_list_pic = function(savename, allpath) {
        $upload_pic_club_list_pic.append('<a class="picbox" data-savepath="' +
            savename + '" href="' + allpath + '" target="_blank"><img src="' + allpath + '" width="100"><i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i></a>');
        fnUpdateClub_list_pic();
    };
</script>