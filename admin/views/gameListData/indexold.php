<?php 
    if(empty($_REQUEST['game_id'])){
        $model->game_id=0;
    }else{
        $model->game_id=$_REQUEST['game_id'];
    }
    if(!isset($_REQUEST['title'])){
        $_REQUEST['title']=0;
    }
    if(!isset($_REQUEST['id'])){
        $_REQUEST['id']=0;
    }
    if(!empty($model->game_player_team==665)){
        $model->min_num_team=0;
        $model->max_num_team=0;
    }
    $arr=ProjectList::model()->getProject_id2();
    $arr1=ProjectListGame::model()->getProjectGame_id2();
    if(!empty($model->game_id)){
        $game_list=GameList::model()->find('id='.$model->game_id);
    }
    else {
        $game_list=GameList::model()->find('id='.$_REQUEST['game_id']);
    }
 ?>
<script> // html5中默认的script是javascript,故不需要特别指定script language 
    var $d_club_type2= <?php echo json_encode($arr)?>;
    var $d_game_list2= <?php echo json_encode($arr1)?>;
</script>
<div class="box">
    <div id="t0" class="box-title c">
        <?php if($_REQUEST['type'] == 810) {?>
            <h1><i class="fa fa-table"></i><?php if($model->id=='') {?><?php echo $game_list->game_title.' /'; ?>赛事活动添加<?php }else{?><?php echo $model->game_name.' /赛事活动管理'; }?></h1>
        <?php }else if($_REQUEST['type'] == 163){?>
            <h1><i class="fa fa-table"></i><?php if($model->id=='') {?><?php echo $game_list->game_title.' /'; ?>赛事项目添加<?php }else{?><?php echo $model->game_name.' /赛事项目管理'; }?></h1>
        <?php }?>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameListData/index', array('game_id'=>$_REQUEST['game_id'],'title'=>$game_list->game_title,'type'=>$model->game_list->game_type));?>');"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div id="t1" class="box-detail">
        <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="4">竞赛项目信息</td>
                    </tr>
                </table>
                <table>
                    <tr style="display:none;">
                        <td><?php echo $form->labelEx($model, 'game_id'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'game_id', array('value'=>$model->game_list->id)); ?></td>
                    </tr>
                    <tr>
                        <td style="width:20%;"><?php echo $form->labelEx($model, 'game_data_code'); ?></td>
                        <td style="width:30%;"><?php echo $model->game_data_code;?></td>
                        <td style="width:20%;"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td style="width:30%;">
                            <?php
                                $whe = 't.if_del in(0,648) and t.IF_VISIBLE=649 and t.project_type=1'; 
                                $whe .= ' and exists(select * from club_project cpj where '.get_where_club_project('cpj.club_id');
                                $whe .= ' and cpj.project_id=t.id and cpj.project_state=506 and cpj.auth_state=461 and cpj.state=372)';
                                $project = ProjectList::model()->findAll($whe);
                            ?>
                            <?php echo $form->dropDownList($model, 'project_id', Chtml::listData($project, 'id', 'project_name'),array('prompt'=>'请选择', 'onchange' =>'selectOnchangProject(this)')); ?>
                            <?php echo $form->dropDownList($model, 'game_name_id', Chtml::listData(ProjectList::model()->getProject_id2_all(), 'id', 'project_name'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'game_name_id', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model,'game_item'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_item', Chtml::listData(ProjectListGame::model()->findAll('project_id='.$model->project_id),'id','game_item'),array('prompt'=>'请选择', 'onchange'=>'selectGameItem(this)')); ?>
                            <?php echo $form->error($model, 'game_item', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_player_team'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_player_team', Chtml::listData(BaseCode::model()->getCode(664), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchangPlayer(this)')); ?>
                            <?php echo $form->error($model, 'game_player_team', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="dis_game_item">
                        <td>自定义比赛项目</td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'game_item_name', array('class'=>'input-text')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_sex'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_sex', Chtml::listData(BaseCode::model()->getCode(204), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'game_sex', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_age'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_age', Chtml::listData(BaseCode::model()->getCode(152), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'onchangeAge(this)')); ?>
                            <?php echo $form->error($model, 'game_age', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="dis_age_name" style="display:none;"><!--如果为自定义参赛组别显示-->
                        <td><?php echo $form->labelEx($model, 'game_age_name') ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'game_age_name', array('class' => 'input-text','placeholder'=>'请输入自定义名字')); ?>
                            <br><span style='color:#888;'>注：如选择自定义请在“竞赛项目”重新填写组别</span>
                        </td>
                    </tr>
                    <tr id="dis_weight">
                        <td><?php echo $form->labelEx($model, 'weight_min'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'weight_min', array('class' => 'input-text','placeholder' => '请输入最小值')); ?>
                            </br><span style='color:#888;'>注：请输入赛事项目要求最低的体重数 如：25kg</span>
                            <?php echo $form->error($model, 'weight_min', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'weight_max'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'weight_max', array('class' => 'input-text','placeholder' => '请输入最大值')); ?>
                            </br><span style='color:#888;'>注：请输入赛事项目要求最高的体重数 如：50kg</span>
                            <?php echo $form->error($model, 'weight_max', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_data_name'); ?></td>
                        <td colspan="3">
                            <?php if($model->id=='') {echo $form->textField($model, 'game_data_name',array('class'=>'input-text','readonly'=>'readonly'));}else{echo $form->textField($model, 'game_data_name',array('class'=>'input-text'));}?>
                            </br><?php if($model->game_data_name==''){ ?><span style='color:#888;'>注：自动生成，可不填</span><?php }?>
                            <span class="msg">注：以上属性更改后，需要在这里重新填写</span>
                        </td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="4">竞赛项目设置</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td style="width:20%;"><?php echo $form->labelEx($model, 'game_mode'); ?></td>
                        <td style="width:30%;">
                            <?php echo $form->dropDownList($model, 'game_mode', Chtml::listData(BaseCode::model()->getCode(660), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'game_mode', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:20%;"><?php echo $form->labelEx($model, 'game_format'); ?></td>
                        <td style="width:30%;">
                            <?php echo $form->dropDownList($model, 'game_format', Chtml::listData(BaseCode::model()->getCode(984), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchangGameList(this)')); ?>
                            <?php echo $form->error($model, 'game_format', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'isSignOnline'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'isSignOnline', Chtml::listData(BaseCode::model()->getCode(640), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'isSignOnline', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_check_way'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_check_way', Chtml::listData(BaseCode::model()->getCode(791), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_physical_examination'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'game_physical_examination', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'game_physical_examination', $htmlOptions = array()); ?>
                            <br><span class="msg">注：请选择体检限制最早日期，早于该日期的报告不可用</span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_dg_level'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_dg_level', Chtml::listData(MemberCard::model()->getCode(210), 'f_id', 'card_name'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'game_dg_level', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <!--<tr>-->
                        <!--兼报项目开始-->
                        <!--<td>/*同时兼报项目功能暂时注释保留在代码中，前端不显示不控制该功能为必填*/
                            <?php echo $form->labelEx($model, 'F_SAMEGAME_ID');  $model->id=empty($model->id) ?0 : $model->id; 
                                if(!empty($model->F_SAMEGAME_ID)){ $project_list = GameListData::model()->findAll('id in('.$model->F_SAMEGAME_ID.')'); }
                            ?>
                        </td>
                        <td>
                            <?php echo $form->hiddenField($model, 'F_SAMEGAME_ID', array('class' => 'input-text')); ?>
                                <span id="project_box"><?php if(!empty($project_list)){ foreach($project_list as $v){?>
                                    <span class="label-box" id="projectnot_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->game_data_name;?>
                                        <i onclick="fnDeleteProject(this);"></i>
                                    </span><?php }}?>
                                </span>
                                <input id="project_add_btn" class="btn" type="button" value="添加项目">
                            <?php echo $form->error($model, 'F_SAMEGAME_ID', $htmlOptions = array()); ?>
                        </td>-->
                    <!--</tr>-->
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_group_star'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'game_group_star', array('class' => 'input-text','placeholder' => '请选择可允许最大年龄')); ?>
                            <?php echo $form->error($model, 'game_group_star', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_group_end'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'game_group_end', array('class' => 'input-text','placeholder' => '请选择可允许最小年龄')); ?>
                            <?php echo $form->error($model, 'game_group_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr style='display: none;'>
                        <td><?php echo $form->labelEx($model, 'signup_date'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'signup_date', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'signup_date', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'signup_date_end'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'signup_date_end', array('class' => 'input-text')); ?>
                            <?php echo $form->error($model, 'signup_date_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="dis_number" style="display:none;"><!--人数-->
                        <td><?php echo $form->labelEx($model, 'number_of_member_min'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'number_of_member_min', array('class' => 'input-text','placeholder' => '请输入最少人数')); ?>人
                            <?php echo $form->error($model, 'number_of_member_min', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'number_of_member'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'number_of_member', array('class' => 'input-text','placeholder' => '请输入最多人数')); ?>人
                            <?php echo $form->error($model, 'number_of_member', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="dis_num_team" style="display:none;"><!--（队数）参赛方式为团队显示，为个人默认不显示-->
                        <td><?php echo $form->labelEx($model, 'min_num_team'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'min_num_team', array('class' => 'input-text','placeholder' => '请输入最少队数')); ?>队
                            <?php echo $form->error($model, 'min_num_team', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'max_num_team'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'max_num_team', array('class' => 'input-text','placeholder' => '请输入最多队数')); ?>队
                            <?php echo $form->error($model, 'max_num_team', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="dis_team" style="display:none;"><!--（队伍人数）参赛方式为团队显示，为个人默认不显示，为混双默认不显示-->
                        <td><?php echo $form->labelEx($model, 'minimum_team'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'minimum_team', array('class' => 'input-text','placeholder' => '请输入最少人数')); ?>人
                            <?php echo $form->error($model, 'minimum_team', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'team_member'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'team_member', array('class' => 'input-text','placeholder' => '请输入最多人数')); ?>人
                            <?php echo $form->error($model, 'team_member', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                        <!--不可兼报项目开始-->
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'F_exclusive_ID'); $model->id=empty($model->id) ?0 : $model->id; 
                                if(!empty($model->F_exclusive_ID)){ $project_list = GameListData::model()->findAll('id in('.$model->F_exclusive_ID.')'); }
                            ?>
                        </td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'F_exclusive_ID', array('class' => 'input-text')); ?>
                            <span id="projectnot_box">
                                <?php 
                                    if(!empty($project_list)){foreach($project_list as $v){?>
                                    <span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->game_data_name;?>
                                        <i onclick="fnDeleteProjectnot(this);"></i>
                                    </span>
                                <?php }}?>
                            </span>
                            <input id="projectNOT_add_btn" class="btn" type="button" value="添加项目">
                            <?php echo $form->error($model, 'F_exclusive_ID', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table class="mt15">
                    <tr class="table-title">
                        <td colspan="4">收费设置</td>
                    </tr>
                </table>
                <table>
                    <tr>
                        <td width="20%;"><?php echo $form->labelEx($model, 'game_money'); ?></td>
                        <td width="30%;">
                            <?php echo $form->textField($model, 'game_money', array('class' => 'input-text')); ?>元/人
                            <?php echo $form->error($model, 'game_money', $htmlOptions = array()); ?>
                        </td>
                        <td width="20%;"><?php echo $form->labelEx($model, 'insurance_set'); ?></td>
                        <td width="30%;">
                            <?php echo $form->dropDownList($model, 'insurance_set', Chtml::listData(BaseCode::model()->getCode(1001), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectInsurance(this)')); ?>
                            <?php echo $form->error($model, 'insurance_set', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <div id="dis_insurance" style="display:none; margin-top:15px;">
                    <table>
                        <tr class="table-title">
                            <td colspan="4">特定保险信息</td>
                        </tr>
                    </table>
                    <table>
                        <tr>
                            <td width="20%;">
                                <?php echo $form->labelEx($model, 'insurance_code');  $model->id=empty($model->id) ?0 : $model->id; 
                                    if(!empty($model->insurance_code)){ /*$project_list = GameListData::model()->findAll('id in('.$model->F_SAMEGAME_ID.')'); */}
                                ?>
                            </td>
                            <td width="30%;">
                                <!--<span id="insurance_box">
                                    <?php if(!empty($project_list)){ foreach($project_list as $v){?>
                                    <span class="label-box" id="insurance_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->game_data_name;?>
                                        <i onclick="fnDeleteInsurance(this);"></i>
                                    </span><?php }}?>
                                </span>-->
                                <input id="add_insurance" class="btn" type="button" value="选择">
                            </td>
                            <td width="20%;"><?php echo $form->labelEx($model, 'insurance_title'); ?></td>
                            <td width="30%;"><?php echo $model->insurance_title; ?></td>
                        </tr>
                        <tr>
                            <td width="20%;"><?php echo $form->labelEx($model, 'insurance'); ?></td>
                            <td width="30%;"><?php echo $model->insurance; ?>元/人</td>
                            <td width="20%;"><?php echo $form->labelEx($model, 'sum_insured'); ?></td>
                            <td width="30%;"><?php echo $model->sum_insured; ?>元/人</td>
                        </tr>
                    </table>
                </div>
                <table class="dis_btn">
                    <tr>
                        <td colspan="4">
                            <div align="center">
                                <?php if($game_list->state!=372) {?>
                                    <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                                    <button class="btn" type="reset">重置</button>
                                <?php }?>
                                <button class="btn" type="button" onclick="we.back();">取消</button>
                                <button class="btn" type="button" onclick="printpage();">打印</button>
                            </div>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
<div id="dialog2" title="百度地图" style="display: none;"></div>
<script>
    //时间控制  
    $('#GameListData_game_group_star').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd '});});
    $('#GameListData_game_group_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd '});});

    $('#GameListData_signup_date').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
    $('#GameListData_signup_date_end').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});

    $('#GameListData_game_physical_examination').on('click', function(){
    WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});});

    // 参赛组别
    function onchangeAge(obj){
        var show_id=$(obj).val();
        if(show_id==222){
            $('#dis_age_name').show();
            $('#GameListData_game_age_name').val('');
        }
        else{
            $('#dis_age_name').hide();
        }
    }

    // 参赛方式
    function selectOnchangPlayer(obj){
        var show_id=$(obj).val();
        if(show_id==666){
            $('#dis_number').hide();
            $("#dis_num_team").show();
            $("#dis_team").show();
        }
        else if(show_id==982){
            $("#dis_num_team").show();
            $("#dis_team").hide();
            $('#dis_number').hide();
        }
        else{
            $('#dis_number').show();
            $("#dis_num_team").hide();
            $("#dis_team").hide();
        }
    };

    // 自定义比赛项目
    function selectGameItem(obj){
        var show_id=$(obj).val();
        var show_id1=$('#GameListData_game_item').val();
        if(show_id!=''){
            $('#dis_game_item').hide();
        }
        else{
            $('#dis_game_item').show();
        }
        var option=$('#GameListData_game_item option:selected');
        if(option.text()=='品势'){
            $('#dis_weight').hide();
        }
        else{
            $('#dis_weight').show();
        }
    }

    // //积分录入方式
    // function selectOnchang(obj){
    //     var show_id=$(obj).val();
    //     if(show_id==644){
    //         $("#show_role_line").show();
    //     }
    //     else{
    //         $("#show_role_line").hide();
    //     }
    //     if(show_id==645){
    //         $("#show_ranking_line").show();
    //     }
    //     else{
    //         $("#show_ranking_line").hide();
    //     }
    //     if(show_id==646){
    //         $("#show_win_line").show();
    //     }
    //     else{
    //         $("#show_win_line").hide();
    //     }
    // };

    function selectInsurance(obj){
        var show_id=$(obj).val();
        if(show_id==1002){
            $('#dis_insurance').show();
        }
        else{
            $('#dis_insurance').hide();
        }
    }

    $('#add_insurance').on('click',function(){
        alert('还没有这个功能');
    })

    // var project_id=0;
    // // 删除兼报项目
    // var $project_box=$('#project_box');
    // var $GameListData_F_SAMEGAME_ID=$('#GameListData_F_SAMEGAME_ID');
    // var fnUpdateProject=function(){
    //     var arr=[];
    //     var id;
    //     $project_box.find('span').each(function(){
    //         id=$(this).attr('data-id');
    //         arr.push(id);
    //     });
    //     $GameListData_F_SAMEGAME_ID.val(we.implode(',', arr));
    // };
    
    // var fnDeleteProject=function(op){
    //     $(op).parent().remove();
    //     fnUpdateProject();
    // };
    
    var project_id=0;
    // 删除不可兼报项目
    var $projectnot_box=$('#projectnot_box');
    var $GameListData_F_exclusive_ID=$('#GameListData_F_exclusive_ID');
    var fnUpdateProjectnot=function(){
        var arr=[];
        var id;
        $projectnot_box.find('span').each(function(){
            id=$(this).attr('data-id');
            arr.push(id);
        });
        $GameListData_F_exclusive_ID.val(we.implode(',', arr));
    };
    
    var fnDeleteProjectnot=function(op){
        $(op).parent().remove();
        fnUpdateProjectnot();
    };  
    // 得分添加删除更新
    // var $program_list=$('#program_list');
    // var $game_list_ranking=$('#game_list_ranking');
    // var fnAddProgram=function(){
    //     var num=$program_list.attr('data-num')+1;
    //     $program_list.append('<div>'+
    //         '<input name="开始名次" type="text" value="" placeholder="请输入开始名次" />&nbsp;-&nbsp;<input name="结束名次" type="text" value=""  placeholder="请输入结束名次"/>&nbsp;，&nbsp;<input name="分会" type="text" value="" placeholder="请输入分值" />分'+
    //         '<input onclick="fnAddProgram();" class="btn" type="button" value="添加行"><input onclick="fnDeleteProgram(this);" style="margin-left:10px;" class="btn" type="button" value="删除行">'+
    //         '</div>');
    //     $program_list.attr('data-num',num);
    // };
    // var fnDeleteProgram=function(op){
    //     $(op).parent().parent().remove();
    // };
    // var fnUpdateProgram=function(){
    //     var isEmpty=true;
    //     $program_list.find('.input-text').each(function(){
    //         if($(this).val()!=''){
    //             isEmpty=false;
    //             //return false;
    //         }
    //     });
    //     if(!isEmpty){
    //         $game_list_ranking.val('1').trigger('blur');
    //     }else{
    //         $game_list_ranking.val('').trigger('blur');
    //     }
    // };

    $(function(){
        // 参赛组别
        var show_id1=$('#GameListData_game_age').val();
        if(show_id1==222){
            $('#dis_age_name').show();
        }
        else{
            $('#dis_age_name').hide();
        }

        var s8=$('#GameListData_project_id').val();
        var s9=$('#GameListData_game_item').val();
        if(s8==235 || s8==236){
            $('#dis_weight').show();
        }
        else{
            $('#dis_weight').hide();
        }
        // 自定义比赛项目
        if(s9!=''){
            $('#dis_game_item').hide();
        }
        else{
            $('#dis_game_item').show();
        }

        // 所有为“品势”的都隐藏公斤级
        var option=$('#GameListData_game_item option:selected');
        if(option.text()=='品势'){
            $('#dis_weight').hide();
        }
        else{
            $('#dis_weight').show();
        }

        // 参赛方式
        var show_id2=$('#GameListData_game_player_team').val();
        if(show_id2==666){
            $('#dis_number').hide();
            $("#dis_num_team").show();
            $("#dis_team").show();
        }
        else if(show_id2==982){
            $("#dis_num_team").show();
            $("#dis_team").hide();
            $('#dis_number').hide();
        }
        else{
            $('#dis_number').show();
            $("#dis_num_team").hide();
            $("#dis_team").hide();
        }

        // 选择赛事
        // 选择服务地区
        var $GameList_game_address=$('#GameList_game_address');
        var $GameList_longitude=$('#GameList_Longitude');
        var $GameList_latitude=$('#GameList_latitude');
        $GameList_game_address.on('click', function(){
            $.dialog.data('maparea_address', '');
            $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>',{
                id:'diqu',
                lock:true,
                opacity:0.3,
                title:'选择服务地区',
                width:'907px',
                height:'504px',
                close: function () {;
                    if($.dialog.data('maparea_address')!=''){
                        $GameList_game_address.val($.dialog.data('maparea_address'));
                        $GameList_longitude.val($.dialog.data('maparea_lng'));
                        $GameList_latitude.val($.dialog.data('maparea_lat'));
                    }
                }
            });
        });
        
        // // 兼报项目添加
        // $('#project_add_btn').on('click', function(){
		// 	var project_id=$('#GameListData_project_id').val();
        //     $.dialog.data('game_list_id', 0);
        //     $.dialog.open('<?php echo $this->createUrl("select/gameListData",array('game_id'=>$model->game_id));?>&project_id='+project_id,{
        //         id:'xiangmu',
        //         lock:true,
        //         opacity:0.3,
        //         title:'选择具体内容',
        //         width:'500px',
        //         height:'60%',
        //         close: function () {
        //             if($.dialog.data('game_list_id')>0){
        //                 if($('#project_item_'+$.dialog.data('game_list_id')).length==0){
        //                 $project_box.append('<span class="label-box" id="project_item_'+$.dialog.data('game_list_id')+'" data-id="'+$.dialog.data('game_list_id')+'">'+$.dialog.data('game_list_title')+'<i onclick="fnDeleteProject(this);"></i></span>');
        //                 fnUpdateProject();
        //                 }
        //             }
        //         }
        //     });
        // });

        // 不可兼报项目添加
        $('#projectNOT_add_btn').on('click', function(){
            var project_id=$('#GameListData_project_id').val();
            $.dialog.data('game_list_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gameListData",array('game_id'=>$model->game_id,'id'=>$model->id));?>&project_id='+project_id,{
                id:'xiangmu',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    if($.dialog.data('game_list_id')>0){
                        if($('#project_item_'+$.dialog.data('game_list_id')).length==0){
                            $projectnot_box.append('<span class="label-box" id="project_item_'+$.dialog.data('game_list_id')+'" data-id="'+$.dialog.data('game_list_id')+'">'+$.dialog.data('game_list_title')+'<i onclick="fnDeleteProjectnot(this);"></i></span>');
                            fnUpdateProjectnot();
                        }
                    }
                }
            });
        });
    });

    var sname='<?php echo $model->game_project_name; ?>';
    // selectOnchangProject('#GameListData_project_id');
    function selectOnchangProject(obj){
        var show_id=$(obj).val();
        var code,c1,c2;
        var code1;
        var p_html ='<option value="">请选择</option>';
        var g_html ='<option value="">请选择</option>';
        if (show_id>0) {
            for (j=0;j<$d_club_type2.length;j++) {
                if($d_club_type2[j]['id']==show_id){
                    code1=$d_club_type2[j]['CODE'];
                    code=code1.substr(0,2);
                }
                c2=we.trim($d_club_type2[j]['project_name'],' ');
                code1=$d_club_type2[j]['CODE'];
                code1=code1.substr(0,2);
                c1='';
                if (c2==sname){
                    c1='selected';
                }
                if((code1==code) && ($d_club_type2[j]['project_type']==2) ){
                    p_html = p_html +'<option value="'+$d_club_type2[j]['id']+'"'+c1+'>';
                    p_html = p_html +c2+'</option>';
                }
            }
            $("#GameListData_game_name_id").html(p_html);
            
            for(i=0;i<$d_game_list2.length;i++)
                if($d_game_list2[i]['project_id']==show_id){
                    g_html = g_html +'<option value="'+$d_game_list2[i]['id']+'">';
                    g_html = g_html +$d_game_list2[i]['game_item']+'</option>';
                }
            $("#GameListData_game_item").html(g_html);
        }
        
        if(show_id==235 || show_id==236){
            $('#dis_weight').show();
        }
        else{
            $('#dis_weight').hide();
        }
    }
</script>
<script>
    function printpage(){
        var html='';
        for(var i=0;i<2;i++){
            html += '<table>'+$("#t"+i).html()+"</table>";
            if(i==1 || i==2);
        }
        
        var newWin = window.open('', '', '');
        newWin.document.write('<head>\
            <style>\
                .box-detail table, .box-detail-table{\
                    table-layout:fixed;\
                    width:100%;\
                    border-spacing:1px;\
                    border-collapse:collapse;\
                    background:#ccc;}\
                .box-detail td, .box-detail-table td{\
                    padding:10px;\
                    background:#fff;\
                    border: 1px solid black;\
                    text-align:left;}\
                .box-detail table.table-title{\
                    border-collapse:collapse;\
                    border-top:1px #ccc solid;\
                    border-right:1px #ccc solid;\
                    border-left:1px #ccc solid;}\
                .table-title td{background:#efefef;}\
                .box-detail-table td{text-align:left;}\
                .btn {display:none;}\
                .dis_btn {display:none;}\
                .mt15 {margin-top:15px;}\
                .input-text {border:none;}\
                .msg {display:none}\
                select {appearance:none;-webkit-appearance:none;border:none;}\
            </style>\
            </head>');
        newWin.document.write('<div><div class="box-detail">'+html+'</div></div>');
        newWin.print();
        newWin.close(); //关闭新产生的标签页
    }
</script>
