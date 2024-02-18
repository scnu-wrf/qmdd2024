<?php
    //include_once $qmdd_init_file;
    if(!isset($_REQUEST['data_id'])){
        $_REQUEST['data_id']=0;
    }
    if(!isset($_REQUEST['game_id'])){
        $_REQUEST['game_id']=0;
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
?>  
<div class="box">
    <div class="box-title c">
        <h1>当前界面：赛事/排名 》 赛事报名 》 报名申请 》 详情</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a>
        </span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <table style="table-layout:auto;">
                <tr class="table-title">
                	<td colspan="4">赛事信息</td>
                </tr>
                <?php if(!empty($gamedata)) echo $form->hiddenField($model, 'money', array('value'=>$gamedata->game_money)); ?>
                <?php echo $form->hiddenField($model, 'data_type', array('class' => 'input-text','value'=>$data_type)); ?>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'order_num'); ?></td>
                    <td style="width:35%;"><?php echo $model->order_num; ?></td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'game_id'); ?></td>
                    <td style="width:35%;">
                        <?php
                            echo $form->hiddenField($model,'game_id');
                            echo $model->game_name;
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
                            echo $model->sign_game_data_name;
                        ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model,'uptype'); ?></td>
                    <td id="uptype" colspan="3"><?php echo $gamedata->game_player_team_name; ?></td>
                </tr>
            </table>
            <table class="mt15" style="table-layout:auto;">
            	 <tr class="table-title">
                	<td colspan="4">成员信息-团队</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'name'); ?></td>
                    <td style="width:35%;">
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'name', array('class' => 'input-text')) : $model->name; ?>
                        <?php echo $form->error($model, 'name', $htmlOptions = array()); ?>
                    </td>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'tvname'); ?></td>
                    <td style="width:35%;">
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'tvname', array('class' => 'input-text')) : $model->tvname; ?>
                        <div class="msg">注：用于大屏、电视字幕显示</div>
                    </td>
                </tr>
                <?php if($gamedata->game_player_team!=982 && $gamedata->game_player_team!=1452) {?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'coach_name'); ?></td>
                    <td>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'coach_name', array('class' => 'input-text')) : $model->coach_name; ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'coach_phone'); ?></td>
                    <td>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'coach_phone', array('class' => 'input-text')) : $model->coach_phone; ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'tour_leader_name'); ?></td>
                    <td>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'tour_leader_name', array('class' => 'input-text')) : $model->tour_leader_name; ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'tour_leader_phone'); ?></td>
                    <td>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'tour_leader_phone', array('class' => 'input-text')) : $model->tour_leader_phone; ?>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($model, 'team_doctor_name'); ?></td>
                    <td>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'team_doctor_name', array('class' => 'input-text')) : $model->team_doctor_name; ?>
                    </td>
                    <td><?php echo $form->labelEx($model, 'team_doctor_phone'); ?></td>
                    <td>
                        <?php echo ($_REQUEST['p_id']!=0) ? $form->textField($model, 'team_doctor_phone', array('class' => 'input-text')) : $model->team_doctor_phone; ?>
                    </td>
                </tr>
                <?php }?>
                <tr>
                    <td><?php echo $form->labelEx($model, 'logo'); ?></td>
                 	<td colspan="3">
                    	<div>
                            <?php echo $form->hiddenField($model, 'logo', array('class' => 'input-text fl')); ?>
                            <?php $basepath=BasePath::model()->getPath(182);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                            <?php if($model->logo!=''){?>
                                <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_logo">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100" height="100">
                                    </a>
                                </div>
                            <?php }?> 
                        </div>
                        <?php if($_REQUEST['p_id']!=0) {?>
                            <script>we.uploadpic('<?php echo get_class($model);?>_logo', '<?php echo $picprefix;?>');</script>
                        <?php }?>
                        <?php echo $form->error($model, 'logo', $htmlOptions = array()); ?>
                    </td>
                </tr>
            </table>
            <table class="mt15">
                <tr class="table-title">
                    <td colspan="4">创建团队者信息（参赛选手的第一录入的选手为创建者）</td>
                </tr>
                <?php
                    $account = GfUser1::model()->find('GF_ACCOUNT="'.$model->create_account.'"');
                    if(!empty($model->create_account)){
                        $level = ClubMemberList::model()->find('gf_account='.$model->create_account.' and member_project_id='.$model->sign_project_id.' and club_status=337');
                    }
                ?>
                <tr>
                    <td><?php echo $form->labelEx($account, 'GF_ACCOUNT'); ?></td>
                    <td><?php echo $model->create_account; ?></td>
                    <td><?php echo $form->labelEx($account, 'GF_ACCOUNT'); ?></td>
                    <td><?php echo $model->create_account; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($account, 'ZSXM'); ?></td>
                    <td><?php echo $account->ZSXM; ?></td>
                    <td><?php echo $form->labelEx($model,'dg_level'); ?></td>
                    <td><?php if(!empty($level))echo $level->project_level_name; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($account, 'real_sex_name'); ?></td>
                    <td><?php echo $account->real_sex_name; ?></td>
                    <td><?php echo $form->labelEx($account, 'PHONE'); ?></td>
                    <td><?php echo $account->PHONE; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($account, 'real_birthday'); ?></td>
                    <td><?php echo $account->real_birthday; ?></td>
                    <td><?php echo $form->labelEx($account, 'id_card'); ?></td>
                    <td><?php echo $account->id_card; ?></td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($account, 'id_card_pic'); ?></td>
                    <td>
                        <?php $basepath=BasePath::model()->getPath(211);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <div>
                            <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_card_pic">
                                <a href="<?php echo $basepath->F_WWWPATH.$account->id_card_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$account->id_card_pic;?>" width="100">
                                </a>
                            </div>
                        </div>
                    </td>
                    <td><?php echo $form->labelEx($account, 'id_pic'); ?></td>
                    <td>
                        <?php $basepath=BasePath::model()->getPath(210);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }?>
                        <div>
                            <div class="upload_img fl" id="upload_pic_<?php echo get_class($model);?>_id_pic">
                                <a href="<?php echo $basepath->F_WWWPATH.$account->id_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$account->id_pic;?>" width="100">
                                </a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->labelEx($account, 'IDNAME'); ?></td>
                    <td>
                        <?php
                            $basepath=BasePath::model()->getPath(191);$picprefix='';if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                        ?>
                        <div id="img_box">
                            <?php if($account->IDNAME!=''){?>
                                <div class="upload_img fl" id="upload_pic_<?php echo get_class($account);?>_IDNAME">
                                    <a href="<?php echo $basepath->F_WWWPATH.$account->IDNAME;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$account->IDNAME;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                        </div>
                    </td>
                    <td><?php echo $form->labelEx($account, 'athlete_rank'); ?></td>
                    <td><?php echo $account->athlete_rank; ?></td>
                </tr>
            </table>
            <table id="add_form" class="mt15">
                <tr class="table-title">
                    <td colspan="8">团队成员信息 <a href="javascript:;" class="btn" onclick="add_tr();">添加行</a></td>
                </tr>
                <?php
                    $sign1 = new GameSignList;
                    $sign = GameSignList::model()->findAll('team_id='.$model->id.' ');
                ?>
                <tr>
                    <td>序号</td>
                    <td><?php echo $sign1->getAttributeLabel('sign_account'); ?></td>
                    <td><?php echo $sign1->getAttributeLabel('sign_name'); ?></td>
                    <td><?php echo $sign1->getAttributeLabel('sign_sname'); ?></td>
                    <td><?php echo $sign1->getAttributeLabel('athlete_rank'); ?></td>
                    <td><?php echo $sign1->getAttributeLabel('health_date'); ?></td>
                    <td><?php echo $sign1->getAttributeLabel('game_man_name'); ?></td>
                    <td>操作</td>
                </tr>
                <?php $index = 1; if(!empty($sign))foreach($sign as $si) {?>
                    <tr class="tr_len">
                        <input type="hidden" class="sid" name="sign_id[<?php echo $index; ?>][id]" value="<?php echo $si->id; ?>">
                        <td class="sum_n"><?php echo $index; ?></td>
                        <td><?php echo $si->sign_account; ?></td>
                        <td><?php echo $si->sign_name; ?></td>
                        <td><?php echo $si->sign_sname; ?></td>
                        <td><?php if(!empty($si->athlete_rank)) echo $si->member_card->card_name; ?></td>
                        <td><?php if($si->health_date != '0000-00-00 00:00:00')echo $si->health_date; ?></td>
                        <td><?php echo $si->game_man_name; ?></td>
                        <td>
                            <?php if($model->state==721) {?>
                                <a href="javascript:;" class="btn" onclick="clickOpenWindow(<?php echo $si->id; ?>);">修改</a>
                                <?php if($model->create_account!=$si->sign_account) {?>
                                    <a href="javascript:;" class="btn" onclick="clickDelete(this,0);">删除</a>
                                <?php }?>
                                <a href="javascript:;" class="btn" onclick="add_tr();">添加行</a>
                            <?php }else{?>
                                <a href="javascript:;" class="btn" onclick="clickOpenWindow(<?php echo $si->id; ?>);">查看</a>
                            <?php }?>
                        </td>
                    </tr>
                <?php $index++; }?>
            </table>
            <table class="mt15" style="table-layout:auto;">
                <tr class="table-title">
                    <td colspan="4">审核信息</td>
                </tr>
                <tr>
                    <td style="width:15%;"><?php echo $form->labelEx($model, 'state'); ?></td>
                    <td style="width:35%;"><?php echo $model->state_name; ?></td>
                    <td style="width:15%;">可执行操作</td>
                    <td style="width:35%;" colspan="">
                        <?php
                            if($model->state==371 && !empty($model->id)){
                                echo $form->hiddenField($model,'check_team',array('value'=>'1'));
                                echo '<label class="check" style="-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;">
                                        <input id="check_click" name="check_click" class="input-check" type="checkbox" checked="checked">审核同时发送缴费通知
                                    </label>';
                                echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过'));
                            }
                            else if($model->state==721 || empty($model->id)){
                                echo show_shenhe_box(array('baocun'=>'保存','shenhe'=>'提交审核'));
                            }
                            else if($model->state==372){
                                echo show_shenhe_box(array('quxiao'=>'撤销审核'));
                            }
                        ?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    function clickOpenWindow(id){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl('gameSignList/update',array('p_id'=>$_REQUEST['p_id'],'dis'=>($model->state==721) ? 1 : 2)); ?>&id='+id,{
            id:'tianjia',
            lock:true,
            opacity:0.3,
            title:'选手信息详情',
            width:'90%',
            height:'90%',
            close: function () {}
        });
    }

    $('body').on('click','.time', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });

    function clickDelete(op,n){
        $(op).parent().parent().remove();
        var s = 1;
        $('.tr_len').each(function(){
            $(this).find('.sum_n').html(s);
            // if(n==1){
                $(this).find('.game_man_name').attr('name','add_form['+s+'][game_man_name]');
                $(this).find('.sign_account').attr('name','add_form['+s+'][sign_account]');
                $(this).find('.name').attr('id','name_'+s);
                $(this).find('.level').attr({'id':'level_'+s,'name':'add_form['+s+'][athlete_rank]'});
                $(this).find('.sign_sname').attr('name','add_form['+s+'][sign_sname]');
                $(this).find('.athlete_rank').attr({'id':'athlete_rank_'+s});
                $(this).find('.health_date').attr('name','add_form['+s+'][health_date]');
            // }
            // else{
                $(this).find('.sid').attr('name','sign_id['+s+'][id]');
            // }
            s++;
        });
    }

    function add_tr(){
        var num = $('.tr_len').length;
        num++;
        var s_html = 
            '<tr class="tr_len">'+
                '<td class="sum_n">'+num+'</td>'+
                '<td><input type="text" class="input-text onkeyup sign_account" name="add_form['+num+'][sign_account]" oninput="oninputQuery(this,'+num+');" onpropertychange="oninputQuery(this,'+num+');"></td>'+
                '<td><input type="text" class="input-text name" id="name_'+num+'"></td>'+
                '<td><input type="text" class="input-text sign_sname" name="add_form['+num+'][sign_sname]"></td>'+
                '<td><input type="hidden" class="level" id="level_'+num+'" name="add_form['+num+'][athlete_rank]"><input type="text" class="input-text athlete_rank" id="athlete_rank_'+num+'"></td>'+
                '<td><input type="text" class="input-text time health_date" name="add_form['+num+'][health_date]"></td>'+
                '<td><input type="text" class="input-text game_man_name" name="add_form['+num+'][game_man_name]"></td>'+
                '<td>'+
                    '<a href="javascript:;" class="btn" onclick="clickDelete(this,1);">删除</a>&nbsp;'+
                    '<a href="javascript:;" class="btn" onclick="add_tr();">添加行</a>'+
                '</td>'+
            '</tr>';
        $('#add_form').append(s_html);
    }
    
    function oninputQuery(obj,n){
        var changval = $(obj).val();
        if(changval.length==5 || changval.length==6){
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('validate',array('game_id'=>$_REQUEST['game_id'],'data_id'=>$_REQUEST['data_id']));?>&gf_account='+changval,
                dataType: 'json',
                success: function(data) {
                    if(data.status==1){
                        $('#name_'+n).val(data.ZSXM);
                        $('#athlete_rank_'+n).val(data.level);
                        $('#level_'+n).val(data.level_id);
                    }
                    else{
                        if(changval.length==6){
                            $(obj).val('');
                        }
                        we.msg('minus', data.msg);
                    }
                }
            });
        }
    }

    $('body').on('click','#check_click',function(){
        var box = ($(this).is(':checked')==true) ? 1 : 0;
        $('#GameTeamTable_check_team').val(box);
    })
</script>