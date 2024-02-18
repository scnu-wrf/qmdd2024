<?php
$_REQUEST['action']=empty($_REQUEST['action'])?'':$_REQUEST['action'];
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
        <h1>
            <span>当前界面：供应商》
                <?php
                if (@$_GET['action'] == 'index_apply') {
                    echo '意向入驻管理》添加入驻》添加';
                } else if (@$_GET['action'] == 'index_wait_exam') {
                    echo '意向入驻管理》添加待审核';
                } else if (@$_GET['action'] == 'index_exam') {
                    echo '意向入驻管理》意向入驻审核';
                } else if (@$_GET['action'] == 'index_join') {
                    echo '意向入驻管理》意向入驻列表';
                } else if (@$_GET['action'] == 'index_cancel_nopass') {
                    echo '意向入驻管理》审核未通过列表';
                } else if (@$_GET['action'] == 'index_no_exam') {
                    echo '意向入驻管理》意向入驻审核》待审核';
                } else if (@$_GET['action'] == '') {
                    echo '意向入驻申请';
                }
                ?>
            </span>
        </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div>
    <!--box-title end-->
    <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
    <div class="box-detail">
        <table class="mt15" id="t2" width="100%" style="table-layout:auto;">
            <?php echo $form->hiddenField($model, 'club_type', array('class' => 'input-text', 'value' => 380)); ?>
            <?php echo $form->hiddenField($model, 'logon_way', array('value' => 1375)); ?>
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
                <td><?php echo $form->labelEx($model, 'company'); ?></td>
                <td>
                    <?php
                    if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->textField($model, 'company', array('class' => 'input-text', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'company', array('class' => 'input-text', 'onChange' => 'companyOnchang(this)'));
                    }
                    ?>
                    <?php echo $form->error($model, 'company', $htmlOptions = array()); ?>

                </td>
                <td><?php echo $form->labelEx($model, 'company_type_id'); ?></td>
                <td>
                    <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1089), 'f_id', 'F_NAME'), array('prompt' => '请选择', "disabled" => "disabled"));
                    } else {
                        echo $form->dropDownList($model, 'company_type_id', Chtml::listData(BaseCode::model()->getCode(1089), 'f_id', 'F_NAME'), array('prompt' => '请选择'));
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
                    <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->textField($model, 'club_address', array('class' => 'input-text', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'club_address', array('class' => 'input-text', 'placeholder' => '详细地址'));
                    } ?>
                    <?php echo $form->error($model, 'club_address', $htmlOptions = array()); ?>
                </td>
            </tr>
            <tr>
                <td>营业期限</td>
                <td>

                    <?php

                    if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->textField($model, 'valid_until_start', array('class' => 'input-text', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'valid_until_start', array('class' => 'input-text'));
                    }

                    ?>
                    <?php echo $form->error($model, 'valid_until_start', $htmlOptions = array()); ?>

                </td>
                <td>至</td>
                <td>
                    <?php
                    if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'valid_until', array('class' => 'input-text', 'placeholder' => '不填写则为长期'));
                    }
                    ?>
                    <?php echo $form->error($model, 'valid_until', $htmlOptions = array()); ?>
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
                        <?php if(empty($model->id)||$model->state==721 || $model->state == 1538){?>
                            <i onclick="$(this).parent().remove();fnUpdateClub_list_pic();return false;"></i>
                        <?php }?>
                        </a>
                        <?php }?>
                        <?php }?>
                    </div>
                </div>
                <?php if(empty($model->id)||$model->state==721 || $model->state == 1538){?>
                <script>
                    we.uploadpic('<?php echo get_class($model);?>_club_list_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnClub_list_pic(e1.savename,e1.allpath);},5);
                </script>
                <?php }?>
                <?php echo $form->error($model, 'club_list_pic', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table id="t1" width="100%" style="table-layout:auto; margin-top:20px;">
            <tr class="table-title">
                <td colspan="4">联系人信息</td>
            </tr>
            <tr>
                <td><?php echo $form->labelEx($model, 'apply_gfaccount'); ?></td>
                <td>
                    <?php echo $form->hiddenField($model, 'apply_club_gfid'); ?>
                    <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->textField($model, 'apply_gfaccount', array('class' => 'input-text','disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'apply_gfaccount', array('class' => 'input-text','onChange' => 'accountOnchang(this)'));
                    } ?>
                    <?php echo $form->error($model, 'apply_gfaccount', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'apply_name'); ?></td>
                <td>
                    <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
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
                    <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->textField($model, 'contact_phone', array('class' => 'input-text', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'contact_phone', array('class' => 'input-text'));
                    } ?>
                    <?php echo $form->error($model, 'contact_phone', $htmlOptions = array()); ?>
                </td>
                <td><?php echo $form->labelEx($model, 'email'); ?></td>
                <td>
                    <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) {
                        echo $form->textField($model, 'email', array('class' => 'input-text', 'disabled' => 'disabled'));
                    } else {
                        echo $form->textField($model, 'email', array('class' => 'input-text'));
                    } ?>
                    <?php echo $form->error($model, 'email', $htmlOptions = array()); ?>
                </td>
            </tr>
        </table>
        <table class="mt15" id="t7" width="100%" style="table-layout:auto;">
            <tr class="table-title">
                <td colspan="4">操作信息</td>
            </tr>
            <?php if($_REQUEST['action']!='index_apply'){?>
                <tr>
                    <td width='10%'><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td colspan="3"><?php echo $model->state_name; ?></td>
                </tr>
            <?php }?>
            <?php if((($_REQUEST['action']=='index_no_exam'&&$model->state==371)||$model->state==2||$model->state==373||$model->state==1538)&&($_REQUEST['action']!='index_apply')){?>
                <tr>
                    <td width='10%'><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                    <td width='90%' colspan="3">
                        <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text','readonly'=>(!empty($_REQUEST['action'])&&$_REQUEST['action']!='index_no_exam'?true:false))); ?>
                        <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                    </td>
                </tr>
            <?php }?>
            <?php if($_REQUEST['action']=='index_apply'||$_REQUEST['action']=='index_wait_exam'||$_REQUEST['action'] == 'index_no_exam'){?>
            <tr>
                <td width="10%">可执行操作</td>
                <td colspan="3">
                    <?php if (!empty($model->id) && $model->state != 721 && $model->state != 1538) { ?>
                        <?php
                            if ($_REQUEST['action'] == 'index_wait_exam') {
                                if ($model->state == 371) {
                                    if($model->logon_way==1375){
                                        echo show_shenhe_box(array('quxiao' => '撤销申请')) . '<button class="btn" type="button" onclick="we.back();">取消</button>';
                                    }else{
                                        echo $model->state_name;
                                    }
                                } else {
                                    echo $model->state_name;
                                };
                            } else if ($_REQUEST['action'] == 'index_no_exam') {
                                echo show_shenhe_box(array('tongguo' => '审核通过','tuihui'=>'退回修改','butongguo' => '审核不通过')) . '<button class="btn" type="button" onclick="we.back();">取消</button>';
                            } ?>
                    <?php } else { ?>
                        <?php echo show_shenhe_box(array('baocun' => '保存', 'shenhe' => '提交审核')); ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </table>
        <?php $this->endWidget(); ?>
    </div>
    <!--box-detail end-->
</div>
<!--box end-->
<script>
    var club_id = 0;
    we.tab('.box-detail-tab li', '.box-detail-tab-item', function(index) {
        if (index == 3) {}
        return true;
    });

    $('#ClubListGys_valid_until,#ClubListGys_valid_until_start').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D',
            dateFmt: 'yyyy-MM-dd'
        });
    });

    // 滚动图片处理
    var $club_list_pic = $('#ClubListGys_club_list_pic');
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

    // 删除分类
    var $classify_box = $('#classify_box');
    var $ClubList_management_category = $('#ClubList_management_category');
    var fnUpdateClassify = function() {
        var arr = [];
        var id;
        $classify_box.find('span').each(function() {
            id = $(this).attr('data-id');
            arr.push(id);
        });
        $ClubList_management_category.val(we.implode(',', arr));
    };

    var fnDeleteClassify = function(op) {
        $(op).parent().remove();
        fnUpdateClassify();
    };
    $(function() {
        $('#t7 .btn-blue').eq(1).on('click', function() {

        })


        // 添加分类
        var $classify_add_btn = $('#classify_add_btn');
        $classify_add_btn.on('click', function() {
            $.dialog.data('classify_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/manage_type"); ?>', {
                id: 'xiangmu',
                lock: true,
                opacity: 0.3,
                title: '选择具体内容',
                width: '500px',
                height: '60%',
                close: function() {
                    if ($.dialog.data('classify_id') > 0) {
                        if ($('#classify_item_' + $.dialog.data('classify_id')).length == 0) {
                            $classify_box.append('<span class="label-box" id="classify_item_' + $.dialog.data('classify_id') + '" data-id="' + $.dialog.data('classify_id') + '">' + $.dialog.data('classify_title') + '<i onclick="fnDeleteClassify(this);"></i></span>');
                            fnUpdateClassify();
                        }
                    }
                }
            });
        });

        // 选择服务地区
        // var $ClubList_club_address=$('#ClubListGys_club_address');
        // var $ClubList_Longitude=$('#ClubList_Longitude');
        // var $ClubList_latitude=$('#ClubList_latitude');
        // $ClubList_club_address.on('click', function(){
        //     $.dialog.data('maparea_address', '');
        //     $.dialog.open('<?php echo $this->createUrl("select/mapArea"); ?>',{
        //         id:'diqu',
        //         lock:true,
        //         opacity:0.3,
        //         title:'选择服务地区',
        //         width:'907px',
        //         height:'504px',
        //         close: function () {;
        //             if($.dialog.data('maparea_address')!=''){
        //                 $('#ClubList_club_address').val($.dialog.data('maparea_address'));
        //                 $ClubList_Longitude.val($.dialog.data('maparea_lng'));
        //                 $ClubList_latitude.val($.dialog.data('maparea_lat'));
        // 				$('#ClubList_club_area_country').val($.dialog.data('country'));
        // 				$('#ClubListGys_club_area_province').val($.dialog.data('province'));
        // 				$('#ClubListGys_club_area_city').val($.dialog.data('city'));
        // 				$('#ClubListGys_club_area_district').val($.dialog.data('district'));
        // 				$('#ClubList_club_area_street').val($.dialog.data('street'));
        //             }
        //         }
        //     });
        // });

        // 选择单位
        var $club_box = $('#club_box');
        var $ClubList_club_id = $('#ClubList_recommend');
        $('#club_select_btn').on('click', function() {
            $.dialog.data('club_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/club"); ?>', {
                id: 'danwei',
                lock: true,
                opacity: 0.3,
                title: '选择具体内容',
                width: '500px',
                height: '60%',
                close: function() {
                    //console.log($.dialog.data('club_id'));
                    if ($.dialog.data('club_id') > 0) {
                        club_id = $.dialog.data('club_id');
                        $ClubList_club_id.val($.dialog.data('club_id')).trigger('blur');
                        $club_box.html('<span class="label-box">' + $.dialog.data('club_title') + '</span>');
                    }
                }
            });
        });


    });
    //单位类型二级联动下拉菜单
    function selectOnchang(obj) {
        var show_id = $(obj).val();
        var p_html = '<option value="">请选择</option>';
        if (show_id > 0) {
            for (j = 0; j < $d_club_type2.length; j++)
                if ($d_club_type2[j]['fater_id'] == show_id) {
                    p_html = p_html + '<option value="' + $d_club_type2[j]['f_id'] + '">';
                    p_html = p_html + $d_club_type2[j]['F_NAME'] + '</option>';
                }
        }
        $("#ClubList_partnership_type").html(p_html);
    }

    // 验证账号
    function accountOnchang(obj) {
        var changval = $(obj).val();
        // if (changval.length>=6) {
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('validate'); ?>&gf_account=' + changval,
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    $('#ClubListGys_apply_club_gfid').val(data.gfid);
                } else {
                    $(obj).val('');
                    $('#ClubListGys_apply_club_gfid').val(0);
                    we.msg('minus', data.msg);
                }
            }
        });
        // }
    }

    $('#ClubQualificationPerson_qualification_time').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D 00:00:00',
            dateFmt: 'yyyy-MM-dd HH:mm:ss'
        });
    });

    $('#ClubListGys_valid_until_start').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D',
            dateFmt: 'yyyy-MM-dd'
        });
    });
    $('#ClubListGys_valid_until').on('click', function() {
        WdatePicker({
            startDate: '%y-%M-%D',
            dateFmt: 'yyyy-MM-dd'
        });
    });
</script>