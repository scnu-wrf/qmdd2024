<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['project_id'])){
        $_REQUEST['project_id']=0;
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    if(!isset($_REQUEST['sid'])){
        $_REQUEST['sid']=0;
    }
    // 从团队跳转过来不需要返回按钮
    if(!isset($_REQUEST['dis'])){
        $_REQUEST['dis']=0;
    }
    if(!empty($model->sign_game_data_id)) {
        $gamedata=GameListData::model()->find('id='.$model->sign_game_data_id);
    } else {
        $gamedata=GameListData::model()->find('id='.$_REQUEST['data_id']);
    }
?>
<div class="box">
    <?php if($_REQUEST['dis']==0) {?>
        <div class="box-title c">
            <h1>当前界面：赛事/排名 》 赛事报名 》 报名申请 》<?php echo ($_REQUEST['sid']==1) ? '待审核 》' : ''; ?> 详情</h1>
            <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
        </div><!--box-title end-->
    <?php }?>
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <input type="hidden" name="data_id" value="<?php echo $_REQUEST["data_id"];?>">
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">赛事信息</td>
                </tr>
                <?php
                    if(!empty($gamedata)) echo $form->hiddenField($model, 'money', array('value'=>$gamedata->game_money));
                    echo $form->hiddenField($model,'dis',array('value'=>$_REQUEST['dis']));
                ?>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td style="width:35%;"><?php echo $model->order_num; ?></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'sign_game_id'); ?></td>
                    <td style="width:35%;">
                        <?php
                            echo $form->hiddenField($model,'sign_game_id');
                            echo $model->sign_game_name;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sign_project_id'); ?></td>
                    <td>
                        <?php
                            echo $form->hiddenField($model,'sign_project_id');
                            echo $model->sign_project_name;
                        ?>
                    </td>
                	<td><?php echo $form->labelEx($model, 'sign_game_data_id'); ?></td>
                    <td>
                        <?php
                            echo $form->hiddenField($model,'sign_game_data_id');
                            echo $model->games_desc;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'uptype'); ?></td>
                    <td id="uptype"><?php echo $gamedata->game_player_team_name; ?></td>
                    <td><?php echo $form->labelEx($model,'game_money2'); ?></td>
                    <td><?php echo $model->game_money; ?></td>
                </tr>
            </table>
            <br/>
            <table style="table-layout:auto;">
            	<tr class="table-title">
                	<td colspan="4">选手信息-个人</td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model, 'sign_account'); ?></td>
                    <td width="35%">
                        <?php echo $form->hiddenField($model, 'sign_gfid'); ?>
                        <?php echo $form->hiddenField($model, 'sign_account'); ?>
                        <?php echo $form->hiddenField($model, 'sign_name'); ?>
                        <?php //echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'sign_account', array('class' => 'input-text','maxlength'=>'6','oninput' =>'accountOnchang(this)','onpropertychange' =>'accountOnchang(this)')) : $model->sign_account; ?>
                        <?php echo $model->sign_account; ?>
                    </td>
                    <td width="15%"><?php echo $form->labelEx($model, 'sign_sname'); ?></td>
                    <td width="35%">
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'sign_sname', array('class' => 'input-text')) : $model->sign_sname; ?>
                        <?php echo $form->error($model, 'sign_sname', $htmlOptions = array()); ?>
                        <div class="msg">注：用于大屏、电视字幕显示</div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sign_name'); ?></td>
                    <td id="gfname"><?php echo $model->sign_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'dg_level'); ?></td>
                    <td><?php if(!empty($model->sign_gfid) && !empty($model->club_member_level))echo $model->club_member_level->project_level_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sign_sex'); ?></td>
                    <td><?php if(!empty($model->sign_sex))echo $model->usersex->F_NAME; ?></td>
                    <td><?php echo $form->labelEx($model, 'sign_game_contect'); ?></td>
                    <td>
                        <?php
                            echo ($_REQUEST['p_id']!=0) ? 
                                $form->textField($model, 'sign_game_contect', array('class' => 'input-text')) : 
                                $model->sign_game_contect.$form->hiddenField($model, 'sign_game_contect');
                        ?>
                        </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'date_birth'); ?></td>
                    <td><span id="birthday"><?php if(!empty($user)) echo $user->real_birthday; ?> </span></td>
                    <td><?php echo $form->labelEx($model,'card_num'); ?></td>
                    <td><span id="card_num"><?php if(!empty($user)) echo $user->id_card; ?></span></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'id_card_pic'); ?></td>
                    <td>
                        <?php $basepath=BasePath::model()->getPath(211);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <div>
                            <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_pic">
                                <a href="<?php echo $basepath->F_WWWPATH.$user->id_card_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$user->id_card_pic;?>" width="100">
                                </a>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $form->labelEx($model, 'id_pic'); ?></td>
                    <td>
                        <?php $basepath=BasePath::model()->getPath(210);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <div>
                            <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card">
                                <a href="<?php echo $basepath->F_WWWPATH.$user->id_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$user->id_pic;?>" width="100">
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sign_head_pic'); ?></td>
                    <td colspan="3">
                        <?php
                            echo $form->hiddenField($model,'sign_head_pic');
                            $basepath=BasePath::model()->getPath(191);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                        ?>
                        <div id="img_box">
                            <?php if($model->sign_head_pic!=''){?>
                                <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_sign_head_pic">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->sign_head_pic;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->sign_head_pic;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                        </div>
                        <?php if($_REQUEST['p_id']!=0) {?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_sign_head_pic', '<?php echo $picprefix;?>');</script>
                        <?php }?>
                        <?php echo $form->error($model, 'sign_head_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'health_date'); ?></td>
                    <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'health_date',array('class'=>'input-text time')) : $model->health_date; ?></td>
                    <td><?php echo $form->labelEx($model, 'medical_checkup'); ?></td>
                    <td>
                        <?php
                            echo $form->hiddenField($model, 'medical_checkup', array('class' => 'input-text fl'));
                            $basepath=BasePath::model()->getPath(191);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                            if($model->medical_checkup!=''){
                        ?>
                            <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_medical_checkup">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->medical_checkup;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->medical_checkup;?>" width="100">
                                </a>
                            </div>
                        <?php }?>
                        <?php if($_REQUEST['p_id']!=0) {?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_medical_checkup', '<?php echo $picprefix;?>');</script>
                        <?php }?>
                    <?php echo $form->error($model, 'medical_checkup', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <br/>
            <table style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">监护人信息（选填）</td>
                </tr>
                <tr>
                	<td width="15%"><?php echo $form->labelEx($model, 'guardian'); ?></td>
                    <td width="35%"><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'guardian', array('class' => 'input-text')) : $model->guardian; ?></td>
                    <td width="15%"><?php echo $form->labelEx($model,'guardian_relationship'); ?></td>
                    <td width="35%"><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model,'guardian_relationship',array('class'=>'input-text')) : $model->guardian_relationship; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'guardian_contact_information'); ?></td>
                    <td colspan="3"><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'guardian_contact_information', array('class' => 'input-text')) : $model->guardian_contact_information; ?></td>
                </tr>
            </table>
            <?php if($_REQUEST['dis']!=2) {?>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">操作信息</td>
                </tr>
                <tr>
                    <td width="15%"><?php echo $form->labelEx($model,'state') ?></td>
                    <td width="35%"><?php echo $model->state_name; ?></td>
                	<td width="15%">可执行操作</td>
                    <td width="35%">
                        <?php if($model->agree_state!=374 && $_REQUEST['sid']==0) {?>
                            <?php
                                // echo show_shenhe_box(array('baocun'=>'保存','tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                                if($model->state==721){
                                    echo show_shenhe_box(array('baocun'=>'保存'));
                                    if($_REQUEST['dis']==0){
                                        echo show_shenhe_box(array('shenhe'=>'提交审核'));
                                    }
                                }
                                else if($model->state==371){
                                    echo $form->hiddenField($model,'check_team',array('value'=>'1'));
                                    echo '<label class="check" style="-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;">
                                            <input id="check_click" name="check_click" class="input-check" type="checkbox" checked="checked">审核同时发送缴费通知
                                        </label>';
                                    echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                                }
                                else if($model->state==372){
                                    echo show_shenhe_box(array('quxiao'=>'撤销审核'));
                                }
                            ?>
                            <!-- <button class="btn" type="button" onclick="we.back();">取消</button> -->
                        <?php }?>
                    </td>
                </tr>
            </table>
            <?php }?>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        $('.time').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    });

    function accountOnchang(obj){
        var changval=$(obj).val();
        var game_id = $('#GameSignList_sign_game_id').val();
        var data_id = $('#GameSignList_sign_game_data_id').val()
        if(changval.length==5 || changval.length==6){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval,
                data: {gf_account:changval,game_id:game_id, data_id:data_id},
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    // if(data.status==1){
                    //     $('#GameSignList_sign_game_contect').val(data.contect);
                    //     $('#GameSignList_sign_gfid').val(data.gfid);
                    //     $('#GameSignList_sign_name').val(data.real_name);
                    //     $('#GameSignList_sign_sex').val(data.sex);
                    //     $('#GameSignList_sign_head_pic').val(data.head_pic);
                    //     $('#sex').text(data.sex_name);
                    //     $('#birthday').text(data.birthday);
                    //     $('#gfname').text(data.real_name);
                    //     $('#card_type').text(data.card_type);
                    //     $('#card_num').text(data.card_num);
                    //     $('#img_box').html(
                    //         '<div class="upload_img fl" id="upload_pic_<?php //echo get_class($model);?>_sign_head_pic">'+
                    //             '<a href="<?php //echo $basepath->F_WWWPATH;?>'+data.head_pic+'" target="_blank">'+
                    //                 '<img src="<?php //echo $basepath->F_WWWPATH;?>'+data.head_pic+'" width="100">'+
                    //             '</a>'+
                    //         '</div>'
                    //     );
                    // }else{
                    //     $(obj).val('');
                    //     we.msg('minus', data.msg);
                    // }
                }
            });
        }
    }

    function changeGameid(obj){
        var obj = $(obj).val();
        var s_html = '<option value>请选择</option>';
        var k_html = '<option value>请选择</option>';
        if(obj > 0){
            var pr = '<?php echo $_REQUEST['data_id']; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('data_id'); ?>&game_id='+obj,
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    for(var i=0;i<data[0].length;i++){
                        s_html += '<option value="'+data[0][i]['id']+'" '+((data[0][i]['id']==pr) ? 'selected>' : '>')+data[0][i]['game_data_name']+'</option>';
                    }
                    $('#GameSignList_sign_game_data_id').html(s_html);
                    for(var j=0;j<data[1].length;j++){
                        k_html += '<option value="'+data[1][j]['project_id']+'" '+((data[1][j]['project_id']==pr) ? 'selected>' : '>')+data[1][j]['project_name']+'</option>';
                    }
                    $('#GameSignList_sign_project_id').html(k_html);
                }
            });
        }
        else{
            $('#GameSignList_sign_project_id').html(s_html);
            $('#GameSignList_sign_game_data_id').html(k_html);
        }
    }

    changeDataid($('#GameSignList_sign_game_data_id'));
    function changeDataid(obj){
        var obj = $(obj).val();
        if(obj>0){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('changeDataid'); ?>&data_id='+obj,
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    $('#uptype').html(data.name);
                }
            });
        }
    }

    $('body').on('click','#check_click',function(){
        var box = ($(this).is(':checked')==true) ? 1 : 0;
        $('#GameSignList_check_team').val(box);
    })
</script>