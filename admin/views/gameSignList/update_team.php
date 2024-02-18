<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
    }
    if(!isset($_REQUEST['team_id'])){
        $_REQUEST['team_id']=0;
    }
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }
    if(!empty($model->sign_game_data_id)) {
        $gamedata=GameListData::model()->find('id='.$model->sign_game_data_id);
    } else {
        $gamedata=GameListData::model()->find('id='.$_REQUEST['data_id']);
    }
    if(!empty($gamedata)) {
        $data_type=$gamedata->game_player_team;
    } else {
        $data_type=0;
    }
    $disabled = ($_REQUEST['p_id']==0) ? 'disabled' : '';
?>
    <div class="box">
        <div class="box-title c"><h1><i class="fa fa-table"></i><?php if(!empty($gamedata)) echo $gamedata->game_name; ?>-<?php if(!empty($gamedata)) echo $gamedata->game_data_name; ?>-成员详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameSignList/index_team', array('data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id'],'team_id'=>$_REQUEST['team_id'],'data_type'=>$data_type));?>');"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
        <div class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
            <?php if($model->sign_game_id!=null){?><?php echo $form->hiddenField($model, 'sign_game_id'); } else { if(!empty($gamedata)) { ?><?php echo $form->hiddenField($model, 'sign_game_id', array('value'=>$gamedata->game_id)); }}?>
            <?php if($model->project_list!=null){?><?php echo $form->hiddenfield($model, 'sign_project_id'); } else { if(!empty($gamedata)) {?><?php echo $form->hiddenfield($model, 'sign_project_id', array('value'=>$gamedata->project_id)); }} ?>
            <?php if($model->game_list_data!=null){?><?php echo $form->hiddenfield($model, 'sign_game_data_id'); } else {?><?php echo $form->hiddenfield($model, 'sign_game_data_id', array('value'=>$_REQUEST['data_id'])); } ?>
            <?php if($model->team_id!=null){?><?php echo $form->hiddenField($model, 'team_id'); } else { ?><?php echo $form->hiddenField($model, 'team_id', array('value'=>$_REQUEST['team_id'])); }?>
            <?php if(!empty($gamedata)) echo $form->hiddenField($model, 'money', array('value'=>$gamedata->game_money)); ?>
            <br/>
            <table>
                <tr class="table-title">
                	<td colspan="4">成员信息</td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sign_account'); ?></td>
                    <td>
                        <?php echo $form->hiddenField($model, 'sign_gfid', array('class' => 'input-text')); ?>
                        <?php echo $form->hiddenField($model, 'sign_name', array('class' => 'input-text')); ?>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'sign_account', array('class' => 'input-text','style'=>'width:60%;')) : $model->sign_account; ?>
                        <?php if($_REQUEST['p_id']!=0) {?>
                            <input type="button" class="btn btn" onclick="accountOnchang();" value="点击查询">
                        <?php }?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'game_man_type'); ?></td>
                    <td><?php echo $form->dropDownList($model, 'game_man_type', Chtml::listData(BaseCode::model()->getCode(992), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                    <?php echo $form->error($model, 'game_man_type', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sign_name'); ?></td>
                    <td id="gfname"><?php echo $model->sign_name; ?></td>
                    <td><?php echo $form->labelEx($model, 'sign_sname'); ?></td>
                    <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'sign_sname', array('class' => 'input-text')) : $model->sign_sname; ?>
                        <?php echo $form->error($model, 'sign_sname', $htmlOptions = array()); ?>
                        <div class="msg">注：用于大屏、电视字幕显示</div>
                    </td>
                </tr>
                <tr>
                    <td>出生日期</td>
                    <td><span id="birthday"><?php if(!empty($user)) echo $user->real_birthday; ?> </span></td>
                    <td><?php echo $form->labelEx($model, 'sign_sex'); ?></td>
                    <td><?php echo $form->hiddenField($model, 'sign_sex', array('class' => 'input-text')); ?>
                    <span id="sex"><?php if(!empty($model->usersex)) echo $model->usersex->F_NAME; ?></span></td>
                </tr>
                <tr>
                    <td>证件类型</td>
                    <td><span id="card_type"><?php if(!empty($user)) echo $user->id_card_type_name; ?> </span></td>
                    <td>证件号</td>
                    <td><span id="card_num"><?php if(!empty($user)) echo $user->id_card; ?> </span></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'sign_head_pic'); ?></td>
                    <td colspan="3">
                        <div>
                            <?php echo $form->hiddenField($model, 'sign_head_pic', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(191);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <div id="img_box">
                                <?php if($model->sign_head_pic!=''){?>
                                    <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_sign_head_pic">
                                        <a href="<?php echo $basepath->F_WWWPATH.$model->sign_head_pic;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$model->sign_head_pic;?>" width="100">
                                        </a>
                                    </div>
                                <?php }?>
                            </div> 
                        </div>
                        <?php if($_REQUEST['p_id']!=0){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_sign_head_pic', '<?php echo $picprefix;?>');</script>
                        <?php }?>
                        <?php echo $form->error($model, 'sign_head_pic', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'medical_checkup'); ?></td>
                    <td colspan="3">
                        <div>
							<?php echo $form->hiddenField($model, 'medical_checkup', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(191);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->medical_checkup!=''){?>
                                <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_medical_checkup">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->medical_checkup;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->medical_checkup;?>" width="100">
                                    </a>
                                </div>
                            <?php }?> 
                        </div>
                        <?php if($_REQUEST['p_id']!=0){?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_medical_checkup', '<?php echo $picprefix;?>');</script>
                        <?php }?>
                        <?php echo $form->error($model, 'medical_checkup', $htmlOptions = array()); ?>
                    </td>
                </tr>
                <tr>
                	<td><?php echo $form->labelEx($model, 'insurance_policy'); ?></td>
                    <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'insurance_policy', array('class' => 'input-text')) : $model->insurance_policy; ?></td>
                    <td><?php echo $form->labelEx($model, 'sign_game_contect'); ?></td>
                    <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'sign_game_contect', array('class' => 'input-text')) : $model->sign_game_contect; ?></td>
                </tr>
            </table>
         <div class="mt15">
            <table class="table-title">
                <tr>
                    <td>监护人信息（选填）</td>
                </tr>
            </table>
            <table>
                <tr>
                	<td><?php echo $form->labelEx($model, 'guardian'); ?></td>
                    <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'guardian', array('class' => 'input-text')) : $model->guardian; ?></td>
                    <td><?php echo $form->labelEx($model, 'guardian_contact_information'); ?></td>
                    <td><?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'guardian_contact_information', array('class' => 'input-text')) : $model->guardian_contact_information; ?></td>
                </tr>
                <tr>
                	<td>可执行操作</td>
                    <td  colspan="3">
                    	<?php if($_REQUEST['p_id']!=0) echo show_shenhe_box(array('baocun'=>'保存'));?>
                        <!-- <button class="btn" onclick="reset();" type="reset">重置</button> -->
                        <button class="btn" type="button" onclick="we.back('<?php echo $this->createUrl('gameSignList/index_team', array('data_id'=>$_REQUEST['data_id'],'game_id'=>$_REQUEST['game_id']));?>');">取消</button>
                    </td>
                </tr>
            </table>
        </div>
            <div class="mt15">
            <table class="showinfo">
                <tr>
                    <th style="width:20%;">操作人</th>
                    <th style="width:20%;">操作时间</th>
                    <th style="width:20%;">审核状态</th>
                    <th style="width:20%;">支付状态</th>
                </tr>
                <tr>
                    <td><?php echo get_session('club_name');?></td>
                    <td><?php echo $model->uDate; ?></td>
                    <td><?php echo $model->state_name; ?></td>
                    <td><?php echo $model->pay_name; ?></td>
                </tr>
            </table>
        </div>
            
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->


<script>
    function accountOnchang(obj){
        // var changval=$(obj).val();
        var changval=$('#GameSignList_sign_account').val();
        var type=$('#GameSignList_game_man_type').val();
        if (changval.length>=6 && type==997) {
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate');?>&gf_account='+changval,
                data: {gf_account:changval,game_id:$('#GameSignList_sign_game_id').val(), data_id:$('#GameSignList_sign_game_data_id').val()},
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        $('#GameSignList_sign_game_contect').val(data.contect);
                        $('#GameSignList_sign_gfid').val(data.gfid);
                        $('#GameSignList_sign_name').val(data.real_name);
                        $('#GameSignList_sign_sex').val(data.sex);
                        $('#GameSignList_sign_head_pic').val(data.head_pic);
                        $('#sex').text(data.sex_name);
                        $('#birthday').text(data.birthday);
                        $('#gfname').text(data.real_name);
                        $('#card_type').text(data.card_type);
                        $('#card_num').text(data.card_num);
                        $('#img_box').html('<div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_medical_checkup"><a href="<?php echo $basepath->F_WWWPATH;?>'+data.head_pic+'" target="_blank"><img src="<?php echo $basepath->F_WWWPATH;?>'+data.head_pic+'" width="100"></a></div>');
                    }else{
                        $(obj).val('');
                        we.msg('minus', data.msg);
                    }
                }
            });
        }
    }
</script>