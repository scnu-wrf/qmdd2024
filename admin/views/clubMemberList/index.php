<?php

if ($_REQUEST['index'] == 1) {
    $txt = '邀请学员';
} elseif ($_REQUEST['index'] == 2) {
    $txt = '邀请学员》今日邀请';
} elseif ($_REQUEST['index'] == 3) {
    $txt = '学员审核';
} elseif ($_REQUEST['index'] == 4) {
    $txt = '学员审核》待审核';
} elseif ($_REQUEST['index'] == 5) {
    $txt = '学员列表';
} elseif ($_REQUEST['index'] == 6) {
    $txt = '学员解除';
} elseif ($_REQUEST['index'] == 7) {
    $txt = '审核未通过';
} elseif ($_REQUEST['index'] == 8) {
    $txt = '各单位学员查询';
}


if ($_REQUEST['index'] == 3) {
    $date_str = '审核时间';
} elseif ($_REQUEST['index'] == 1) {
    $date_str = '邀请时间';
} elseif ($_REQUEST['index'] == 4) {
    $date_str = '申请时间';
} elseif ($_REQUEST['index'] == 7) {
    $date_str = '操作时间';
} else {
    $date_str = '注册时间';
}
?>
<div id="mask" style="display:none;width: 100%; height: 100%; position: fixed; z-index: 2000; top: 0px; left: 0px; overflow: hidden;">
    <div class="" style="line-height: 30px;position: absolute;top: calc(50% - 15px);left: calc(50% - 115px);"><span>导入中...</span></div>
</div>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：会员》学员管理》<?php echo $txt; ?></h1>
        <span style="float:right;padding-right:15px;">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-content">
        <div class="box-header" <?php if ($_REQUEST['index'] == 4 || $_REQUEST['index'] == 5 || $_REQUEST['index'] == 6 || $_REQUEST['index'] == 7 || $_REQUEST['index'] == 8) {
                                    echo 'style="display:none;"';
                                } ?>>
            <?php if ($_REQUEST['index'] == 3) { ?>
            <?php } elseif (get_session('club_id') <> 1 && get_session('club_id') <> NULL && $_REQUEST['index'] != 5) { ?>
                <a class="btn" href="javascript:;" onclick="fnAddClub();"><i class="fa fa-plus"></i>邀请</a>
            <?php } ?>

            <?php if ($_REQUEST['index'] == 1) { ?>
                <span class="exam"> <!-- onclick="on_exam();" -->
                    <p>今日邀请：<span style="color:red;font-weight: bold;"><?php echo $count1; ?></span></p>
                </span>
            <?php } elseif ($_REQUEST['index'] == 3) { ?>
                <span class="exam" onclick="on_exam2()">
                    <p>待审核：<span style="color:red;font-weight: bold;"><?php echo $count2; ?></span></p>
                </span>

            <?php } ?>

            <!-- <?php //if ($_REQUEST['index'] == 5) { ?>
                <button class="btn btn-blue" type="button" onclick="javascript:importfile()">导入</button>
                <a class="btn" href="javascript:;" type="button" onclick="javascript:excel();"><i class="fa fa-file-excel-o"></i>导出</a>
            <?php //} ?> -->
        </div>
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url; ?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r'); ?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type'); ?>">
                <input type="hidden" name="index" id="index" value="<?php echo Yii::app()->request->getParam('index'); ?>">

                <?php if ($_REQUEST['index'] == 8 || $_REQUEST['index'] == 5) { ?>
                    <label style="margin-right:10px;">
                        <span>注册时间：</span>
                        <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date'); ?>" placeholder="<?php echo date("Y-m-d", strtotime("-1 month")) ?>">
                        <span>-</span>
                        <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date'); ?>" placeholder="<?php echo date('Y-m-d'); ?>">
                    </label>

                <?php } elseif ($_REQUEST['index'] == 3) { ?>
                    <label style="margin-right:10px;">
                        <span>审核时间：</span>
                        <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date'); ?>" placeholder="<?php echo date("Y-m-d", strtotime("-1 month")) ?>">
                        <span>-</span>
                        <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date'); ?>" placeholder="<?php echo date('Y-m-d'); ?>">
                    </label>


                <?php } elseif ($_REQUEST['index'] == 6) { ?>
                    <label style="margin-right:10px;">
                        <span>正式解除时间：</span>
                        <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date'); ?>" placeholder="<?php echo date("Y-m-d", strtotime("-1 month")) ?>">
                        <span>-</span>
                        <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date'); ?>" placeholder="<?php echo date('Y-m-d'); ?>">
                    </label>
                <?php } elseif ($_REQUEST['index'] == 7) { ?>
                    <label style="margin-right:10px;">
                        <span>操作时间：</span>
                        <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date'); ?>" placeholder="<?php echo date("Y-m-d", strtotime("-1 month")) ?>">
                        <span>-</span>
                        <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date'); ?>" placeholder="<?php echo date('Y-m-d'); ?>">
                    </label>
                <?php } ?>
                <label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($member_project_id, 'project_id', 'project_name', 'member_project_id'); ?>
                </label>

                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入学员账号/姓名/单位名称" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords'); ?>">
                </label>
                <button id="click_submit" class="btn btn-blue" type="submit">查询</button>
                <input id="is_excel" type="hidden" name="is_excel" value="0">
            </form>
        </div>
        <!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('gf_account'); ?></th>
                        <th><?php echo $model->getAttributeLabel('zsxm'); ?></th>
                        <th><?php echo $model->getAttributeLabel('real_sex'); ?></th>
                        <th><?php echo $model->getAttributeLabel('member_project_id'); ?></th>
                        <th>龙虎等级</th>

                        <?php if ($_REQUEST['index'] == 8) { ?>
                            <th>绑定单位状态</th>
                            <th>绑定单位</th>
                        <?php } else { ?>
                            <th><?php echo $model->getAttributeLabel('club_status'); ?></th>
                        <?php } ?>
                        <?php if ($_REQUEST['index'] == 6) { ?>
                            <th>申请解除时间</th>
                            <th>正式解除时间</th>
                        <?php } else { ?>
                            <th><?php echo $date_str; ?></th>
                        <?php } ?>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath = BasePath::model()->getPath(130); ?>
                    <?php
                    $index = 1;
                    foreach ($arclist as $v) {
                        ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->gf_account; ?></td>
                            <td><?php echo $v->zsxm; ?></td>
                            <td><?php if($v->base_code_sex != null)echo $v->base_code_sex->F_NAME;?></td>
                            <td><?php if($v->project_list != null)echo $v->project_list->project_name;?></td>
                            <td><?php echo $v->project_level_name; ?></td>
                            <?php if ($_REQUEST['index'] == 1) { ?>
                                <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                                <td><?php echo $v->apply_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('show', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                                    <a href="javascript:;" onclick="to_revoke_apply(<?php echo $v->id; ?>)" class="btn">撤销</a>
                                </td>
                            <?php } elseif ($_REQUEST['index'] == 2) { ?>
                                <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                                <td><?php if (!is_null($v->club_member))echo $v->club_member->start_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('show', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>

                                    <a href="javascript:;" onclick="to_revoke_apply(<?php echo $v->id; ?>)" class="btn">撤销</a>
                                </td>
                            <?php } elseif ($_REQUEST['index'] == 3) { ?>
                                <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                                <td><?php if(!is_null($v->club_member))echo $v->club_member->start_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('show', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                                </td>
                            <?php } elseif ($_REQUEST['index'] == 4) { ?>
                                <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                                <td><?php if(!is_null($v->club_member))echo $v->club_member->member_level_register_time; ?> </td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                                </td>
                            <?php } elseif ($_REQUEST['index'] == 5) { ?>
                                <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                                <td><?php if (!is_null($v->club_member))echo $v->club_member->start_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                                    <?php if ($v->club_status == 337){ ?>
                                        <a href="javascript:;" onclick="to_relieve_apply(<?php echo $v->id; ?>)" class="btn">解除</a>
                                    <?php }elseif ($v->club_status == 497) { ?>
                                        <a href="javascript:;" onclick="to_revoke_relieve(<?php echo $v->id; ?>)" class="btn">撤销</a>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($_REQUEST['index'] == 6) { ?>
                                <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                                <td><?php if(!is_null($v->club_member))echo $v->club_member->unbund_time;?></td>
                                <td><?php if(!is_null($v->club_member))echo $v->club_member->end_time; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('update', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                                    <?php if ($v->club_status == 497) { ?>
                                        <a href="javascript:;" onclick="to_revoke_relieve(<?php echo $v->id; ?>)" class="btn">撤销</a>
                                    <?php } ?>
                                </td>
                            <?php } elseif ($_REQUEST['index'] == 7) { ?>
                                <td>
                                    <?php 
                                        if ($v->club_member->invite_initiator == 502 && $v->club_member->agree_club == 373) {
                                            echo '学员拒绝加入';
                                        } elseif ($v->club_member->invite_initiator == 210 && $v->club_member->agree_club == 373) {
                                            echo '单位拒绝加入';
                                        } elseif ($v->club_member->agree_club == 374) {
                                            echo '已撤销';
                                        }    
                                    ?>
                                </td>
                                <td><?php echo $v->udate; ?></td>
                                <td>
                                    <?php echo show_command('修改',$this->createUrl('show', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                                    
                                    <?php echo show_command('删除', '\'' . $v->id . '\''); ?>
                                </td>
                            <?php } elseif ($_REQUEST['index'] == 8) { ?>
                                <td><?php if(!is_null($v->base_code_status))echo $v->base_code_status->F_NAME;?></td>
                                <td><?php echo $v->club_name; ?></td>
                                <td><?php if(!is_null($v->club_member))echo $v->club_member->start_time; ?></td>
                                <td>
                                    <?php echo show_command('详情',$this->createUrl('update', array('id' => $v->id, 'member_gfid' => $v->member_gfid, 'index' => $_REQUEST['index']))); ?>
                                    <!-- <a href="javascript:;" onclick="to_revoke_relieve(<?php //echo $v->id; ?>)" class="btn">撤销</a> -->
                                </td>
                            <?php } ?>
                        </tr>
                    <?php $index++;} ?>
                </tbody>
            </table>
        </div>

        <div class="box-page c"><?php $this->page($pages); ?></div>

    </div>
</div>
<script>
    function on_exam() {
        $('#index').val(2);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }

    function on_exam2() {
        $('#index').val(4);
        $('.box-search select').html('<option value>请选择</option>');
        $('.box-search .input-text').val('');
        document.getElementById('click_submit').click();
    }

    //onKeyUp="show_msg();" oninput="accountOnchang(this)"  onpropertychange="accountOnchang(this)"
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id' => 'ID')); ?>';
    var addClubHtml = '<div style="width:500px;">' +
        '<table class="box-detail-table showinfo">' +
        '<tr>' +
        '<td style="width:15%;">目标账号</td>' +
        '<td><input id="dialog_gf_account" class="input-text" onKeyUp="show_msg();" type="text" value="" ><input id="member_gfid" type="hidden" value=""></td>' +
        '</tr>' +
        '<tr>' +
        '<td width="15%">加入项目</td>' +
        '<td><select id="dialog_project"><?php foreach ($project as $v) { ?><option value="<?php echo $v->project_id; ?>"><?php echo $v->project_name; ?></option><?php } ?></select></td>' +
        '</tr>' +
        '<tr>' +
        '<td>俱乐部</td>' +
        '<td><input id="dialog_club" type="hidden" value="<?php echo get_session('club_id'); ?>"><span id="club_box"><span class="label-box"><?php echo get_session('club_name'); ?></span></span></td>' +
        '</tr>' +
        '<tr>' +
        '<td>邀请附言</td>' +
        '<td><textarea id="dialog_msg" class="input-text" maxlength="50" placeholder="字符数限制为50"></textarea></td>' +
        '</tr>' +
        '</table>' +
        '</div>';
    //帐号验证
    function show_msg() {
        var s1 = $('#dialog_gf_account').val();
        var s2 = '<?php echo $this->createUrl("userlist/getUser"); ?>';
        if (s1.length > 5) {
            $.ajax({
                type: 'get',
                url: s2,
                data: {
                    gfaccount: s1
                },
                dataType: 'json',
                success: function(data) {
                    if (data.GF_ACCOUNT == s1 && data.passed == 2) {
                        $('#member_gfid').val(data.GF_ID);
                    } else {
                        we.msg('minus', '该帐号不存在或未实名登记');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(XMLHttpRequest);
                    console.log(textStatus);
                }
            });
        }
    }
    // 添加联盟单位
    var fnAddClub = function() {
        $.dialog({
            id: 'addlianmeng',
            lock: true,
            opacity: 0.3,
            title: '邀请学员',
            content: addClubHtml,
            button: [{
                    name: '发送邀请',
                    callback: function() {
                        return fnSendInvite();
                    },
                    focus: true
                },
                {
                    name: '取消',
                    callback: function() {
                        return true;
                    }
                }
            ]
        });
    };
    // 发送邀请
    var fnSendInvite = function() {
        var project_id = $('#dialog_project').val();
        var club_id = $('#dialog_club').val();
        var msg = $('#dialog_msg').val();
        var account = $('#dialog_gf_account').val();
        var member_gfid = $('#member_gfid').val();
        if (club_id == '') {
            we.msg('minus', '请先选择俱乐部');
            return false;
        }
        we.loading('show');
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('sendInvite'); ?>',
            data: {
                project_id: project_id,
                club_id: club_id,
                msg: msg,
                account: account,
                member_gfid: member_gfid
            },
            dataType: 'json',
            success: function(data) {
                if (data.status == 1) {
                    we.loading('hide');
                    $.dialog.list['addlianmeng'].close();
                    we.success(data.msg, data.redirect);
                } else {
                    we.loading('hide');
                    we.msg('minus', data.msg);
                }
            }
        });
        return false;
    };
    // 删除已选择单位
    var fnDeleteClub = function(op) {
        $(op).parent().remove();
        fnUpdateClub();
    };

    // 重置单位
    var fnResetClub = function() {
        $('#club_box').html('');
        $('#dialog_club').val('');
    };
    // 更新单位
    var fnUpdateClub = function() {
        var arr = [];
        var id;
        $('#club_box').find('span').each(function() {
            id = $(this).attr('data-id');
            arr.push(id);
        });
        $('#dialog_club').val(we.implode(',', arr));
    };
    // 选择单位、项目
    var fnSelectClub = function() {
        // 选择项目
        var project_id = $('#dialog_project').val();
        if (project_id <= 0) {
            we.msg('minus', '请先选择项目');
            return false;
        }
        // 选择单位
        var $club_box = $('#club_box');
        $.dialog.data('club_id', 0);
        $.dialog.open('<?php echo $this->createUrl("select/club", array('no_cooperation' => Yii::app()->session['club_id'])); ?>&project_id=' + project_id, {
            id: 'danwei',
            lock: true,
            opacity: 0.3,
            title: '选择具体内容',
            width: '500px',
            height: '60%',
            close: function() {
                //console.log($.dialog.data('club_id'));
                if ($.dialog.data('club_id') > 0 && $('#club_item_' + $.dialog.data('club_id')).length == 0) {
                    $club_box.html('<span id="club_item_' + $.dialog.data('club_id') + '" class="label-box" data-id="' + $.dialog.data('club_id') + '">' + $.dialog.data('club_title') + '</span>');
                    fnUpdateClub();
                }
            }
        });
    };



    function to_relieve_apply(id) {
        var can1 = function() {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('DeleteInvite'); ?>',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.success(data.msg, data.redirect);
                    } else {
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
        }

        $.fallr('show', {
            buttons: {
                button1: {
                    text: '是',
                    danger: true,
                    onclick: can1
                },
                button2: {
                    text: '否'
                }
            },
            content: '是否解除学员？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });

    }


    $("#batch_revoke").on("click", function() {
        var str = "";

        $(".check-item .input-check:checked").each(function() {
            str += $(this).attr('value') + ',';
        })
        if (str.length > 0) {
            str = str.substring(0, str.length - 1);
        } else {
            we.msg('minus', '你未选中记录');
            return false;
        }
        to_relieve_apply(str);
        //console.log(str);
    })



    function to_revoke_apply(invite_id) {
        var can1 = function() {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('CancelInvite'); ?>',
                data: {
                    invite_id: invite_id,

                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.success(data.msg, data.redirect);
                    } else {
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
        }

        $.fallr('show', {
            buttons: {
                button1: {
                    text: '是',
                    danger: true,
                    onclick: can1
                },
                button2: {
                    text: '否'
                }
            },
            content: '是否撤销邀请？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });

    }


    $("#batch_revoke").on("click", function() {
        var str = "";

        $(".check-item .input-check:checked").each(function() {
            str += $(this).attr('value') + ',';
        })
        if (str.length > 0) {
            str = str.substring(0, str.length - 1);
        } else {
            we.msg('minus', '你未选中记录');
            return false;
        }
        to_revoke_apply(str);
        //console.log(str);
    })



    function to_revoke_relieve(id) {
        var can1 = function() {
            $.ajax({
                type: 'get',
                url: '<?php echo $this->createUrl('revoke_relieve'); ?>',
                data: {
                    id: id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.success(data.msg, data.redirect);
                    } else {
                        we.msg('minus', data.msg);
                    }
                }
            });
            return false;
        }

        $.fallr('show', {
            buttons: {
                button1: {
                    text: '是',
                    danger: true,
                    onclick: can1
                },
                button2: {
                    text: '否'
                }
            },
            content: '是否撤销解除？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });

    }


    $("#batch_revoke").on("click", function() {
        var str = "";

        $(".check-item .input-check:checked").each(function() {
            str += $(this).attr('value') + ',';
        })
        if (str.length > 0) {
            str = str.substring(0, str.length - 1);
        } else {
            we.msg('minus', '你未选中记录');
            return false;
        }
        to_revoke_relieve(str);
        //console.log(str);
    })

    //时分秒：
    $(function() {
        var $start_time = $('#start_date');
        var $end_time = $('#end_date');
        $start_time.on('click', function() {
            var end_input = $dp.$('end_date')
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd',
                alwaysUseStartDate: false,
                onpicked: function() {
                    end_input.click();
                },
                maxDate: '#F{$dp.$D(\'end_date\')}'
            });
        });
        $end_time.on('click', function() {
            WdatePicker({
                startDate: '%y-%M-%D',
                dateFmt: 'yyyy-MM-dd',
                alwaysUseStartDate: false,
                minDate: '#F{$dp.$D(\'start_date\')}'
            });
        });
    });

    function excel() {
        $("#is_excel").val(1);
        $("#click_submit").click();
        $("#is_excel").val(0);
    }

    function importfile() {
        $.dialog.open('<?php echo $this->createUrl("upExcel"); ?>', {
            id: 'sensitive',
            lock: true,
            opacity: 0.3,
            title: '导入学员信息',
            width: '60%',
            height: '50%',
            close: function() {
                // window.location.reload(true);
            }
        });
    }
</script>
<!-- <script>
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
});
</script> -->