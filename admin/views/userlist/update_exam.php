<?php
    if(!isset($_REQUEST['country'])){
        $_REQUEST['country'] = '';
    }
    if(!isset($_REQUEST['province'])){
        $_REQUEST['province'] = '';
    }
    if(strstr($_SERVER['HTTP_REFERER'], 'index_real_name')) {
        $is_passed = 1;
    }else {
        $is_passed = 0;
    }
?>
<div class="box">
    <div class="box-title c">
                <h1>
            <span>
                当前界面：会员 》会员管理 》<?php echo (strstr($_SERVER['HTTP_REFERER'], 'index_unregist')) ? '实名管理 》实名未通过列表》详情' : (($model->passed==371) ? '实名审核》待审核》详情' : '实名审核》会员详情'); ?>
            </span>
        </h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">实名信息</td>
                </tr>
                <!-- <tr>
                    <td style="width:10%"><?php // echo $form->labelEx($model, 'GF_ACCOUNT'); ?></td>
                    <td style="width:40%"><?php // echo $model->GF_ACCOUNT; ?></td>
                    <td style="width:10%"><?php // echo $form->labelEx($model, 'GF_NAME'); ?></td>
                    <td style="width:40%"><?php // echo $model->GF_NAME; ?></td>
                </tr> -->
                <tr>
                    <td><?php echo $form->labelEx($model,'ZSXM'); ?></td>
                    <td><?php echo $model->ZSXM; ?></td>
                    <td><?php echo $form->labelEx($model,'real_sex'); ?></td>
                    <td><?php echo $model->real_sex_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'real_birthday'); ?></td>
                    <td><?php echo $model->real_birthday; ?></td>
                    <td><?php echo $form->labelEx($model,'native'); ?></td>
                    <td><?php echo $model->native; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'id_card_type'); ?></td>
                    <td><?php echo $model->id_card_type_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'id_card'); ?></td>
                    <td><?php echo $model->id_card; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'id_card_validity_start'); ?></td>
                    <td colspan="3">
                        <?php
                            echo $model->id_card_validity_start;
                            echo ' - '.$model->id_card_validity_end;
                            // echo (!empty($model->id_card_validity_end)) ? ' - '.$model->id_card_validity_end : ' - 长期';
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'id_card_pic'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'id_card_pic', array('class' => 'input-text')); ?>
                        <?php $basepath=BasePath::model()->getPath(211);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->id_card_pic!=null){?>
                        <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->id_card_pic;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->id_card_pic;?>" width="100">
                            </a>
                        </div>
                        <?php }?>
                        <?php echo $form->error($model, 'id_card_pic', $htmlOptions = array()); ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'id_pic'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'id_pic', array('class' => 'input-text')); ?>
                        <?php $basepath=BasePath::model()->getPath(210);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <?php if($model->id_pic!=null){?>
                        <div class="upload_img fl" id="upload_pic_ClubServiceData_imgUrl">
                            <a href="<?php echo $basepath->F_WWWPATH.$model->id_pic;?>" target="_blank">
                                <img src="<?php echo $basepath->F_WWWPATH.$model->id_pic;?>" width="100">
                            </a>
                        </div>
                        <?php }?>
                        <?php echo $form->error($model, 'id_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <!-- <tr>
                    <td>审核状态</td>
                    <td colspan="3" style="color:red;">
                        <?php
                            // if($model->passed==373){
                            //     echo '<font style="color:red;">'.$model->passed_name.'</font>';
                            // }else{
                            //     echo '<font style="color:green;">'.$model->passed_name.'</font>';
                            // }
                        ?>
                    </td>
                </tr>
                <?php //if($model->passed==373){ ?>
                    <tr>
                        <td>未通过原因</td>
                        <td colspan="3" ><?php // echo $model->fail_auth_reason; ?></td>
                    </tr>
                <?php //}?>
                <?php //echo $form->hiddenField($model, 'fail_auth_reason', array('class' => 'input-text')); ?>
                <tr id="shenhe">
                    <td>操作</td>
                    <td colspan="3">
                        <?php
                            // if($model->passed==2||$model->passed==373){
                            //     echo show_shenhe_box(array('quxiao'=>'取消审核'));
                            // }
                            // else{
                            //     echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                            // }
                        ?>
                    </td>
                </tr> -->
            </table>
            <table class="mt15" id="t7" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">操作信息</td>
                </tr>
                <tr>
                    <td width="10%">状态</td>
                    <td colspan="3">
                        <?php if(!empty($model->passed)) $base=BaseCode::model()->find('f_id='.$model->passed);
                        if($is_passed == 1){
                            echo $model->passed_name;
                        }else if($model->passed != 136) {
                            echo empty($base) ? '' : $base->F_NAME;
                        }else {
                            echo $model->passed_name;
                        } ?>
                    </td>
                </tr>
                <?php if($model->passed!=136 && $is_passed == 0){?>
                    <tr>
                        <td width='10%'>备注</td>
                        <td width='90%' colspan="3">
                            <?php
                            if($model->passed==371) {
                                echo $form->textArea($model, 'fail_auth_reason', array('class' => 'input-text'));
                            }else {
                                echo $form->textArea($model, 'fail_auth_reason', array('class' => 'input-text', 'readonly'=>'readonly'));
                            } ?>
                            <?php echo $form->error($model, 'fail_auth_reason', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                <?php }?>
                <?php if($model->passed == 371) { ?>
                <tr>
                    <td width='10%'>操作</td>
                    <td width='90%' colspan="3">
                        <?php
                            // if($model->passed == 371){
                                echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                                echo '<button class="btn" type="button" onclick="we.back();">取消</button>';
                            // }
                            // else {
                            //     echo '<button id="shanchu" onclick="delete_user('.$model->GF_ID.', deleteUrl);" class="btn btn-blue" type="button"> 删除</button>';
                            // }
                        ?>
                    </td>
                </tr>
                <?php }else if(strstr($_SERVER['HTTP_REFERER'], 'index_unregist')) { ?>
                    <tr>
                    <td width='10%'>操作</td>
                    <td width='90%' colspan="3">
                        <?php
                            echo '<button class="btn" type="button" onclick="we.back();">取消</button>';
                        ?>
                    </td>
                </tr>
                <?php } ?>
                <!-- <?php //if($model->passed==2||$model->passed==373){?>
                    <tr>
                        <td rowspan="2">操作记录</td>
                        <td>操作人</td>
                        <td>操作时间</td>
                        <td>操作内容</td>
                    </tr>
                    <tr>
                        <td><?php //echo $model->admin_gfname; ?></td>
                        <td><?php //echo $model->uDate; ?></td>
                        <td><?php //echo $model->passed_name; ?></td>
                    </tr>
                <?php //}?> -->
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var screen = document.documentElement.clientWidth;
    var sc = screen-100;
    var add_html =
        '<div id="add_format" class="box-detail" style="width:'+sc+'px;">'+
            '<form id="add_form" name="add_form">'+
                '<table id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                    '<tr>'+
                        '<td style="width:30%;"><?php echo $form->labelEx($model,'cult'); ?></td>'+
                        '<td>'+
                            '<?php echo $form->textArea($model, 'cult', array('class' => 'input-text')); ?>'+
                            '<?php echo $form->error($model, 'cult', $htmlOptions = array()); ?>'+
                        '</td>'+
                    '</tr>'+
                '</table>'+
            '</form>'+
        '</div>';

    $("#butongguo").on('click',function(){
       if(!$("#userlist_cult").val()){
            $.dialog({
                id:'tianjia',
                lock:true,
                opacity:0.3,
                height: '60%',
                // width:'80%',
                title:'未通过原因',
                content:add_html,
                button:[
                    {
                        name:'确定',

                        callback:function(){
                            return fn_add_tr();
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
            $('.aui_main').css('height','auto');
            return false;
       }
    })
    function fn_add_tr(){
        if($("#userlist_cult").val()==''){
            we.msg('minus', '请填写未通过原因');
            return false;
        }else{
            $("#userlist_fail_auth_reason").val($("#userlist_cult").val());
            $("#butongguo").trigger("click");
        }
    }

    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    function delete_user(id, url){
        we.overlay('show');
        var fnDelete = function() {
            url = url.replace(/ID/, id);
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.msg('check', data.msg, function() {
                            we.loading('hide');
                            we.back();
                        });
                    } else {
                        we.msg('error', data.msg, function() {
                            we.loading('hide');
                        });
                    }
                }
            });
        };
        $.fallr('show', {
            buttons: {
                button1: {text: '删除', danger: true, onclick: fnDelete},
                button2: {text: '取消'}
            },
            content: '确定删除？',
            icon: 'trash',
            afterHide: function() {
                we.loading('hide');
            }
        });
    }
</script>