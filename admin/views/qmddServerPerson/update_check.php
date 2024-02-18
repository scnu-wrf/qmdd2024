<?php
    if(!isset($_REQUEST['rn'])){
        $_REQUEST['rn'] = 0;
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：动动约 》服务者登记 》登记服务者 》详情</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15" style="table-layout:auto;">
                    <?php echo $form->hiddenField($model, 'club_id', array('class' => 'input-text', 'value'=>empty($model->id) ? get_session('club_id') : $model->club_id)); ?>
                    <?php echo $form->hiddenField($model, 'qualification_code_project'); ?>
                    <?php echo $form->hiddenField($model, 'qualification_code_type'); ?>
                    <?php echo $form->hiddenField($model, 'qualification_code_year'); ?>
                    <?php echo $form->hiddenField($model, 'qualification_code_num'); ?>
                    <?php echo $form->hiddenField($model, 'qualification_identity_num'); ?>
                    <?php echo $form->hiddenField($model, 'qualification_title'); ?>
                    <?php echo $form->hiddenField($model, 'achi_h_ratio'); ?>
                    <?php echo $form->hiddenField($model, 'qualification_score'); ?>
                    <?php echo $form->hiddenField($model, 'gfid'); ?>
                    <?php echo $form->hiddenField($model, 'email'); ?>
                    <?php echo $form->hiddenField($model, 'start_date'); ?>
                    <?php echo $form->hiddenField($model, 'end_date'); ?>
                    <tr class="table-title">
                        <td colspan="4">登记服务者</td>
                    </tr>
                    <tr>
                        <td style="width: 15%;"><?php echo $form->labelEx($model,'qualification_type_id'); ?></td>
                        <td style="width:35%;">
                            <?php echo $model->qualification_type; ?>
                        </td>
                        <td style="width:15%;"><?php echo $form->labelEx($model,'qcode'); ?></td>
                        <td style="width:35%;"><span id="qcode"><?php echo $model->qcode; ?></span></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'person_id'); ?></td>
                        <td><?php echo $model->qualification_name; ?></td>
                        <td><?php echo $form->labelEx($model,'qualification_project_id'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model,'qualification_project_id'); ?>
                            <span id="qualification_project_name"><?php echo $model->qualification_project_name; ?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'qualification_title'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model,'qualification_title'); ?>
                            <span id="qualification_level_name"><?php echo $model->qualification_title;?></span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'qualification_level'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model,'qualification_level'); ?>
                            <?php echo $form->hiddenField($model,'qualification_level_name'); ?>
                            <span id="qualification_level_name"><?php echo $model->qualification_level_name;?></span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'servic_site_name'); ?></td>
                        <td colspan="3"><?php echo $model->servic_site_name;?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'head_pic'); ?><br><span class="msg">1张<br>图片格式530*530<br>文件大小≤2M</span></td>
                        <td>
                            <?php $basepath=BasePath::model()->getPath(267);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <div id="img_box"><?php if($model->head_pic!=''){?><div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_head_pic"><a href="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$model->head_pic;?>" style="max-width:100px; max-height:100px;"></a></div><?php }?>
                            </div>
                        </td>
                        <td><?php echo $form->labelEx($model, 'qualification_image'); ?><br><span class="msg">5张<br>图片格式1080*1080<br>文件大小≤2M</span></td>
                        <td colspan="3">
                            <?php $basepath=BasePath::model()->getPath(268);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <div class="upload_img fl" id="upload_pic_qualification_image">
                                <?php
                                foreach($qualification_image as $v) if($v) {?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v;?>" style="max-width:100px; max-height:100px;"></a>
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="4">
                           <span style="display: block; float: left; width: 95%;">服务者介绍</span>
                        </td>
                    </tr>
                    <tr>
                        <?php echo $form->hiddenField($model, 'introduct_temp',array('class' => 'input-text')); if($model->introduct_temp != '') { ?>
                        <td colspan="4" id="introduct_temp_td">
                            <div id="introduct_temp_content"><?php echo $model->introduct_temp; ?></div><a type="btn" id="showIntroduct">...显示</a>
                        </td>
                        <td colspan="4" id="introduct_temp_td1" style="display: none;">
                            <div><?php echo $model->introduct_temp.'<a type="btn" id="hiddenIntroduct">收起</a>'; ?></div>
                        </td>
                        <?php }else { echo '<td colspan="4"></td>'; } ?>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'check_state1'); ?></td>
                    <td colspan="3"><?php echo $model->check_state_name; ?></td>
                </tr>
                <?php if(($model->check_state==371 && $_REQUEST['rn']==0) || $model->check_state==373) {?>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                    <td colspan="3">
                        <?php echo ($model->check_state!=371) ? $model->reasons_failure : $form->textArea($model, 'reasons_failure', array('class' => 'input-text' )); ?>
                    </td>
                </tr>
                <?php }?>
                <?php if($model->check_state==371 || $model->check_state==373) {?>
                <tr>
                    <td style="width:15%;">操作</td>
                    <td colspan="3">
                        <!-- show_shenhe_box方法已失效 -->
                        <input type="hidden" id="submitType" name="submitType" value="baocun">
                        <?php
                            if($model->check_state==371 && $_REQUEST['rn']==0){
                                // echo show_shenhe_box(array('tongguo'=>'审核通过','tuihui'=>'退回修改','butongguo'=>'审核未通过'));
                                echo '<button class="btn btn-blue" onclick="$(\'#submitType\').val(\'tongguo\');" type="submit" id="exam_pass">审核通过</button>&nbsp;';
                                echo '<button class="btn btn-blue" onclick="$(\'#submitType\').val(\'tuihui\');" type="submit" id="rollback">退回修改</button>&nbsp;';
                                echo '<button class="btn btn-blue" onclick="$(\'#submitType\').val(\'butongguo\');" type="submit" id="exam_fail">审核未通过</button>';
                            }
                            elseif($model->check_state!=371){
                                echo '<a class="btn" href="javascript:;" onclick="clickDelete('.$model->id.')">删除</a>';
                                // echo '<a class="btn" href="javascript:;" onclick="we.dele(\''.$model->id.'\', deleteUrl);">删除</a>';
                            }
                            if($_REQUEST['rn']==1 && $model->check_state!=373){ ?>
                                <!-- echo show_shenhe_box(array('baocun'=>'撤销申请'));
                                // echo '<button id="baocun" onclick="submitType=\'baocun\'" class="btn btn-blue" type="submit">撤销申请</button>';
                                echo ''; -->
                                <button class="btn btn-blue" onclick="$('#submitType').val('baocun');" type="submit" id="undo">撤销申请</button>
                            <?php }
                        ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
                <?php }?>
            </table>
            <!-- <table class="showinfo">
                <tr>
                    <th style="width:15%;">操作时间</th>
                    <th style="width:15%;">操作人</th>
                    <th style="width:15%;">审核状态</th>
                    <th>操作备注</th>
                </tr>
                <tr>
                    <td><?php //echo $model->state_time; ?></td>
                    <td><?php //echo $model->process_preson_nick; ?></td>
                    <td><?php //echo $model->check_state_name; ?></td>
                    <td><?php //echo $model->reasons_failure; ?></td>
                </tr>
            </!-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    ///模拟界面切换
    // we.tab('.box-detail-tab li','.box-detail-tab-item',function(index){
    //     if(index==3){

    //     }
    //     return true;
    // });

    // 文字折叠效果
    function showIntroduct() {
        document.getElementById("introduct_temp_str2").style.display="block";
        document.getElementById("introduct_temp_btn").innerHTML="收起";
        document.getElementById("introduct_temp_btn").href="javascript:hiddenIntroduct();";
    }
    function hiddenIntroduct() {
        document.getElementById("introduct_temp_str2").style.display="none";
        document.getElementById("introduct_temp_btn").innerHTML="查看";
        document.getElementById("introduct_temp_btn").href="javascript:showIntroduct();";
    }

    $(function(){
        setTimeout(function(){ UE.getEditor('editor_QmddServerPerson_introduct_temp').setDisabled('fullscreen'); }, 500);
    });

    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID','ustate'=>1));?>';

    function clickDelete(id){
        var url = '<?php echo $this->createUrl('delete',array('ustate'=>1)); ?>&id='+id;
        var fnDelete = function() {
            $.ajax({
                type: 'get',
                url: url,
                dataType: 'json',
                success: function(data) {
                    if (data.status == 1) {
                        we.success(data.msg, data.redirect);
                    } else {
                        we.error(d.msg, d.redirect);
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

    // 操作提示zero123020
    $("#rollback").click(function() {
        we.msg('check', '操作成功');
    });
    $("#undo").click(function() {
        we.msg('check', '操作成功');
    });
    $("#exam_pass").click(function() {
        we.msg('check', '已审核');
    });
    $("#exam_fail").click(function() {
        we.msg('check', '已审核');
    });
</script>

