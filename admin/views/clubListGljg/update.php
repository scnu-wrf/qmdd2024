<?php
$action = $_GET['r'];
//echo $action.'<br>';
//$aa='inviteCardSet/';
//echo strlen($aa).'<br>';
$action2 = substr($action, 13, 1);

//echo $action2;


if (@$_GET['action'] == 'index_glbm') {
    $txt = '管理部门';
    $txt2 = '》详情';
} elseif (@$_GET['action'] == 'index_xmgs') {
    $txt = '项目公司';
    $txt2 = '》详情';
} elseif (@$_GET['action'] == 'index_can') {
    $txt = '管理机构注销';
    $txt2 = '》详情';
} elseif (@$_GET['action'] == '') {
    $txt = '添加机构';
    $txt2 = '';
}
?>


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
        <h1><span>当前界面：首页》管理机构》<?php echo $txt; ?><?php echo $txt2; ?></span></h1>
        <span style="float:right;padding-right:15px;"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>

    <div style="width; 98%; text-align:center; font-size:14px; font-weight:bold; margin-top:10px; ">单位信息</div>
    <div class="box-detail">
        <table class="mt15" id="t2" width="100%" style="table-layout:auto;">
            <?php echo $form->hiddenField($model, 'club_type', array('value' => 1086)); ?>
            <?php echo $form->hiddenField($model, 'partnership_type'); ?>


            <tr class="table-title">
                <td colspan="4">基本信息</td>
            </tr>
            <tr>
                <td width="18%">会员类型<span class="required">*</span></td>
                <td colspan="3">
                    <?php
                    if (!empty($model->id) && $model->state != 721) {
                        echo $form->dropDownList($model, 'member_code', Chtml::listData($sign_type, 'f_ctcode', 'f_ctname'), array('prompt' => '请选择', 'disabled' => 'disabled', 'onchange' => 'changeType(this);'));
                    } else {
                        echo $form->dropDownList($model, 'member_code', Chtml::listData($sign_type, 'f_ctcode', 'f_ctname'), array('prompt' => '请选择', 'onchange' => 'changeType(this);'));
                    }
                    ?>
                    <select <?php if (!empty($model->id) && $model->state != 721) {
                                echo 'disabled="disabled"';
                            } ?> name="ClubListGljg[member_code_second]" id="clind_type">
                        <option value="">请选择</option>
                    </select>
                    <?php echo $form->error($model, 'member_code', $htmlOptions = array()); ?>
                </td>

            </tr>
            <input value="<?php echo @$_GET['id']; ?>" name="sign_id" type="hidden" />
            <tr>
                <td><?php echo $form->labelEx($model, 'company'); ?></td>
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
                <td width="2%"><?php echo $form->labelEx($model, 'company_type_id'); ?></td>
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
                    <label style="margin-right:20px;">
                        <?php if (!empty($model->id) && $model->state != 721) {  ?>
                            <select name="province" disabled="disabled"></select><select name="city" disabled="disabled"></select><select name="area" disabled="disabled"></select>
                        <?php } else { ?>
                            <select name="province"></select><select name="city"></select><select name="area"></select>
                        <?php }  ?>
                        <script>
                            new PCAS("province", "city", "area", "<?php echo $province; ?>", "<?php echo $city; ?>", "<?php echo $area; ?>");
                        </script>
                    </label>
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
        <table id="t5" class="mt15" style="table-layout: auto;">
            <tr class="table-title">
                <td colspan="4">公司法人信息</td>
            </tr>
            <tr>
                <td style="width:10%"><?php echo $form->labelEx($model, 'apply_club_gfnick'); ?></td>
                <td>
                    <?php
                    if ($model->state == "" || $model->state == 721) {
                        echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text'));
                    } else {
                        echo $form->textField($model, 'apply_club_gfnick', array('class' => 'input-text', 'disabled' => 'disabled'));
                    }
                    ?>
                    <?php echo $form->error($model, 'apply_club_gfnick', $htmlOptions = array()); ?>
                </td>
                <td style="width:10%">
                    <?php echo $form->labelEx($model, 'apply_club_phone'); ?> </td>
                <td>
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
                        echo $form->textField($model, 'apply_club_id_card', array('class' => 'input-text', 'maxlength' => '18', 'onChange' => 'accountOnchang2(this)'));
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
        <table id="t1" width="100%" style="table-layout:auto; margin-top:20px;">
            <tr class="table-title">
                <td colspan="4">联系人信息</td>
            </tr>
            <tr>
                <td width="8%"><?php echo $form->labelEx($model, 'apply_gfaccount'); ?></td>
                <td width="40%">

                    <?php if (!empty($model->id) && $model->state != 721) {
                        echo $form->textField($model, 'apply_gfaccount', array('class' => 'input-text', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'apply_gfaccount', array('class' => 'input-text', 'onChange' => 'accountOnchang(this)'));
                    } ?>
                    <?php echo $form->error($model, 'apply_gfaccount', $htmlOptions = array()); ?>
                </td>
                <td width="12%"><?php echo $form->labelEx($model, 'apply_name'); ?></td>
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
        <table id="t1" width="100%" style="table-layout:auto; margin-top:20px;">
            <tr class="table-title">
                <td colspan="4">项目信息</td>
            </tr>
            <tr>
                <td>开通项目</td>
                <td>
                    <?php 
                        $project_value='';
                        foreach ($project_list as $h) {
                            $project_value=$h->project_id.',';
                        }
                        echo $form->hiddenField($model, 'project_list', array('value' => rtrim($project_value, ','))); 
                    ?>
                    <span id="project_box">
                        <?php foreach ($project_list as $v) { ?>
                            <span class="label-box" id="project_item_<?php echo $v->project_id; ?>" data-id="<?php echo $v->project_id; ?>">
                                <?php echo $v->project_name; ?>
                                <?php if (!empty($model->id) && $model->state != 721) { ?>
                                <?php } else { ?>
                                    <i onclick="fnDeleteProject(this);"></i>
                                <?php } ?>
                            </span>
                        <?php } ?>
                    </span>
                    <?php echo $form->hiddenField($model, 'remove_project_ids'); ?>
                    <?php if (empty($model->id) || $model->state == 721) { ?>
                        <input id="project_add_btn" class="btn" type="button" value="添加项目">
                    <?php }?>
                    <?php echo $form->error($model, 'project_list', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15" id="t7" width="100%" style="table-layout:auto;">
            <tr class="table-title">
                <td colspan="4">操作信息</td>
            </tr>
            <tr>
                <td>可执行操作</td>
                <td colspan="3">
                    <?php if (!empty($model->id) && $model->state != 721) { ?>
                        <?php if ($model->state == 371) {
                                if (@$_GET['action'] == 'index_no_exam') { } else {
                                    echo show_shenhe_box(array('quxiao' => '撤销申请')) . '<button class="btn" type="button" onclick="we.back();">取消</button>';
                                }
                                if (get_session('club_id') == 2450) {
                                    if (@$_GET['action'] == 'index_wait_exam') { } else {
                                        echo show_shenhe_box(array('tongguo' => '审核通过', 'butongguo' => '审核不通过')) . '<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }
                                } else {
                                    echo '<button onclick="submitType=' . "'chexiao'" . '" class="btn btn-blue" type="submit">撤销申请</button>&nbsp;';
                                }
                            } else {
                                echo $model->state_name;
                            }; ?>
                    <?php } else { ?>
                        <?php echo show_shenhe_box(array('baocun' => '保存', 'tongguo' => '审核通过')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    <?php } ?>
                </td>
            </tr>
        </table>
        <?php $this->endWidget(); ?>
    </div>
    <!--box-detail end-->
</div>
<!--box end-->
<script>

    //单位类型二级联动下拉菜单
    changeType($('#ClubListGljg_member_code'));

    function changeType(obj) {
        var show_id = $(obj).val();
        var p_html = '<option value="">请选择</option>';
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getType'); ?>',
            data: {
                code: show_id
            },
            dataType: 'json',
            success: function(data) {
                console.log(data)
                for (var i = 0; i < data.length; i++) {
                    p_html += '<option  value="' + data[i]['f_ctcode'] + '" data_id="' + data[i]['id'] + '"';
                    if (data[i]['f_ctcode'] == "<?php echo $model->member_code_second; ?>") {
                        p_html += 'selected';
                    }
                    p_html += '>' + data[i]['f_ctname'] + '</option>';
                }
                $("#clind_type").html(p_html);
            }
        });
    }
    $("#clind_type").on("change", function() {
        $("#ClubListGljg_partnership_type").val($("#clind_type option:selected").attr('data_id'));
    })


    // 添加项目
    var $project_box = $('#project_box');
    var project_list=[];
    $('#project_add_btn').on('click', function() {
        var club_id = $('#VideoLive_club_id').val();
        $.dialog.data('project_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/project"); ?>&club_id=' + club_id, {
            id: 'xiangmu',
            lock: true,
            opacity: 0.3,
            title: '选择具体内容',
            width: '500px',
            height: '60%',
            close: function() {
                if ($.dialog.data('project_id') == -1) {
                    var boxnum = $.dialog.data('project_title');
                    for (var j = 0; j < boxnum.length; j++) {
                        if ($('#project_item_' + boxnum[j].dataset.id).length == 0) {
                            var s1 = '<span class="label-box" id="project_item_' + boxnum[j].dataset.id + '" data-id="' + boxnum[j].dataset.id + '">';
                            s1 = s1 + boxnum[j].dataset.title + '<i onclick="fnDeleteProject(this);"></i></span>';
                            $project_box.append(s1);
                            project_list.push(boxnum[j].dataset.id);
                            fnUpdateProject();
                        }
                    }
                }
            }
        });
    });

    // 删除项目
    var $ClubListGljg_project_list = $('#ClubListGljg_project_list');
    var fnUpdateProject = function() {
        $ClubListGljg_project_list.val(project_list.join(','));
    };

    var remove_ids='';
    var fnDeleteProject = function(op) {
        removeByValue(project_list,$(op).parent().attr("data-id"))
        remove_ids+=$(op).parent().attr("data-id")+',';
        $("#ClubListGljg_remove_project_ids").val(remove_ids.substring(0, remove_ids.lastIndexOf(',')));
        $(op).parent().remove();
        fnUpdateProject();
    };

    //移除数组中的固定元素
    function removeByValue(arr, val) {
        for(var i=0; i<arr.length; i++) {
            if(arr[i] == val) {
                arr.splice(i, 1);
                break;
            }
        }
    }

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
                    $('#ClubListGljg_apply_club_gfid').val(data.gfid);
                } else {
                    $(obj).val('');
                    $('#ClubListGljg_apply_club_gfid').val(0);
                    we.msg('minus', data.msg);
                }
            }
        });
        // }
    }


    // 验证身份证
    function accountOnchang2(obj) {
        var changval = $(obj).val();
        //console.log(changval);
        // if (changval.length>=6) {
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('Check_id_card'); ?>&id_card=' + changval,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    $('#ClubListGljg_apply_club_gfid').val(data.gfid);
                } else {
                    $(obj).val('');
                    $('#ClubListGljg_apply_club_gfid').val(0);
                    we.msg('minus', data.msg);
                }
            }
        });
        // }
    }

    $('#ClubListGljg_valid_until_start').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D',
            dateFmt: 'yyyy-MM-dd'
        });
    });
    $('#ClubListGljg_valid_until').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D',
            dateFmt: 'yyyy-MM-dd'
        });
    });
    
// 滚动图片处理
var $club_list_pic=$('#ClubListGljg_club_list_pic');
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
</script>