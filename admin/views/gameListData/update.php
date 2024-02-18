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
    if(!isset($_REQUEST['p_id'])){
        $_REQUEST['p_id']=1;
    }

    if(!empty($model->game_player_team==665)){
        $model->min_num_team=0;
        $model->max_num_team=0;
    }
    if(!empty($model->game_id)){
        $game_list=GameList::model()->find('id='.$model->game_id);
    }
    else {
        $game_list=GameList::model()->find('id='.$_REQUEST['game_id']);
    }
    $sh = $game_list->state;
    $disabled = '';//($sh==372) ?  'disabled' : '' ;
    $arr=ProjectList::model()->getProject_id2('IF_VISIBLE=649 AND project_type=2 and if_del=648');
    $arr1=ProjectListGame::model()->getProjectGame_id2();
    $arr2=BaseCode::model()->getCode_sex();
 ?>
<script>
    var $d_club_type2= <?php echo json_encode($arr)?>;
    var $d_game_list2= <?php echo json_encode($arr1)?>;
    var $d_game_sex= <?php echo json_encode($arr2)?>;
</script>
<div class="box">
    <?php if($_REQUEST['p_id']==1) {?>
    <div id="t0" class="box-title c">
        <h1>当前界面：赛事/排名 》赛事发布 》<?php echo $game_list->game_title; ?> 》竞赛项目列表 》<?php echo (empty($model->id)) ? '添加' : '/详情'; ?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameListData/index', array('game_id'=>$_REQUEST['game_id'],'title'=>$game_list->game_title,'type'=>$model->game_list->game_type));?>');">
                <i class="fa fa-reply"></i>返回上一层
            </a>
        </span>
    </div><!--box-title end-->
    <?php }?>
    <div id="t1" class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">竞赛项目信息</td>
                    </tr>
                    <tr style="display:none;">
                        <td><?php echo $form->labelEx($model, 'game_id'); ?></td>
                        <td colspan="3"><?php echo $form->textField($model, 'game_id', array('value'=>$model->game_list->id)); ?></td>
                    </tr>
                    <tr>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_data_code'); ?></td>
                        <td width="38%;"><?php echo $model->game_data_code;?></td>
                        <td width="12%;"><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td width="38%;">
                            <?php
                                $whe = 't.if_del in(0,648) and t.IF_VISIBLE=649 and t.project_type=1'; 
                                $whe .= ' and exists(select * from club_project cpj where '.get_where_club_project('cpj.club_id');
                                $whe .= ' and cpj.project_id=t.id and cpj.project_state=506 and cpj.auth_state=461 and cpj.state=372)';
                                $project = ProjectList::model()->findAll($whe);
                            ?>
                            <?php echo $form->dropDownList($model, 'project_id', Chtml::listData($project, 'id', 'project_name'),array('prompt'=>'请选择一级项目', 'onchange' =>'selectOnchangProject(this)','disabled'=>$disabled)); ?>
                            <?php echo $form->dropDownList($model, 'game_name_id', Chtml::listData(ProjectList::model()->findAll('IF_VISIBLE=649 AND project_type=2 and if_del=648'), 'id', 'project_name'), array('prompt'=>'请选择二级项目','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                            <!--<?php //echo $form->error($model, 'game_name_id', $htmlOptions = array()); ?>-->
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_data_name'); ?></td>
                        <td colspan="3">
                            <?php
                                if($model->id==''){
                                    echo $form->textField($model, 'game_data_name',array('class'=>'input-text'));
                                }
                                else{
                                    echo ($sh==721 || $sh==373) ? $form->textField($model, 'game_data_name',array('class'=>'input-text')) : $model->game_data_name;
                                }
                            ?>
                        </td>
                    </tr>
                    <?php echo $form->hiddenField($model, 'weight'); ?>
                    <tr>
                        <td><?php echo $form->labelEx($model,'game_item'); ?></td>
                        <td>
                            <?php $poj=ProjectListGame::model()->findAll('project_id='.$model->project_id); ?>
                            <?php echo $form->hiddenField($model, 'game_item_name', array('class'=>'input-text')); ?>
                            <select name="GameListData[game_item]" id="GameListData_game_item" onchange="selectGameItem(this)" <?php if($sh!=721) echo $disabled; ?>>
                                <option value>请选择</option>
                                <?php if(!empty($poj))foreach($poj as $h) { $selected=$h->id;?>
                                    <option value="<?php echo $h->id;?>" weight="<?php echo $h->game_weight;?>" gamemodel="<?php echo $h->game_model;?>" gamesex="<?php echo $h->game_sex;?>" <?php if($selected==$model->game_item){?>selected<?php }?>><?php echo $h->game_item;?></option>
                                <?php }?>
                            </select>
                            <?php echo $form->error($model, 'game_item', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_player_team'); ?></td>
                        <td>
                            <?php $model->game_player_team=empty($model->game_player_team)?0:$model->game_player_team;?>
                            <?php echo $form->dropDownList($model, 'game_player_team', Chtml::listData(BaseCode::model()->getCode(664), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchangPlayer(this)','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_player_team', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_sex'); ?></td>
                        <td>
                            <?php $model->game_sex=empty($model->game_sex)?0:$model->game_sex;?>
                            <?php echo $form->dropDownList($model, 'game_sex', Chtml::listData(BaseCode::model()->getCode(204), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_sex', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_age'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_age', Chtml::listData(BaseCode::model()->getCode(152), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'onchangeAge(this)','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_age', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr id="dis_age_name" style="display:none;"><!--如果为自定义参赛组别显示-->
                        <td><?php echo $form->labelEx($model, 'game_age_name') ?></td>
                        <td colspan="3">
                            <?php echo ($sh==721 || $sh==373) ? $form->textField($model, 'game_age_name', array('class' => 'input-text','placeholder'=>'请输入自定义名字')) : $model->game_age_name; ?>
                        </td>
                    </tr>
                    <tr id="dis_weight" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'weight_level'); ?></td>
                        <td colspan="3"><?php echo ($sh==721 || $sh==373) ? $form->textField($model, 'weight_min', array('class' => 'input-text','placeholder' => '请输入数值')) : $model->weight_min; ?></td>
                        <!-- <td><?php //echo $form->labelEx($model, 'weight_max'); ?></td>
                        <td>
                            <?php //echo ($sh==721 || $sh==373) ? $form->textField($model, 'weight_max', array('class' => 'input-text','placeholder' => '请输入最大值')) : $model->weight_max; ?>
                            <br><span class="msg">注：请输入赛事项目要求最高的体重数 如：50kg</span>
                            <?php //echo $form->error($model, 'weight_max', $htmlOptions = array()); ?>
                        </td> -->
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">竞赛项目设置</td>
                    </tr>
                    <tr>
                        <td style="width:12%;"><?php echo $form->labelEx($model, 'game_mode'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_mode', Chtml::listData(BaseCode::model()->getCode(660), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_mode', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_dg_level'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_dg_level', Chtml::listData(ServicerLevel::model()->findAll('type in(210,1472) and member_second_name<>"实名会员"  order by card_xh'), 'card_xh', 'card_name'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_dg_level', $htmlOptions = array()); ?>
                            <br><span class="msg">注：不选择为不限等级</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="width:12%;"><?php echo $form->labelEx($model, 'isSignOnline'); ?></td>
                        <td style="width:38%;">
                            <?php echo $form->dropDownList($model, 'isSignOnline', Chtml::listData(BaseCode::model()->getCode(640), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'isSignOnline', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:12%;"><?php echo $form->labelEx($model, 'game_check_way'); ?></td>
                        <td style="width:38%;">
                            <?php echo $form->dropDownList($model, 'game_check_way', Chtml::listData(BaseCode::model()->getCode(791), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_check_way', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_group_end'); ?></td>
                        <td>
                            <?php
                                echo  $form->textField($model, 'game_group_end', array('class' => 'input-text','placeholder' => '请选择可允许最小年龄','style'=>'width: 70%;'));
                                echo $form->error($model, 'game_group_end', $htmlOptions = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_group_star'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'game_group_star', array('class' => 'input-text','placeholder' => '请选择可允许最大年龄','style'=>'width: 70%;')) ;
                                echo $form->error($model, 'game_group_star', $htmlOptions = array());
                            ?>
                        </td>
                    </tr>
                    <tr style="display: none;">
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
                        <td><?php echo $form->labelEx($model, 'number_of_member_min'); ?> <span class="required">*</span></td>
                        <td>
                            <?php
                                echo  $form->textField($model, 'number_of_member_min', array('class' => 'input-text','placeholder' => '请输入最少人数','style'=>'width: 70%;'));
                                echo $form->error($model, 'number_of_member_min', $htmlOptions = array());
                            ?> 人
                        </td>
                        <td><?php echo $form->labelEx($model, 'number_of_member'); ?> <span class="required">*</span></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'number_of_member', array('class' => 'input-text','placeholder' => '请输入最多人数','style'=>'width: 70%;'));
                                echo $form->error($model, 'number_of_member', $htmlOptions = array());
                            ?> /人
                        </td>
                    </tr>
                    <tr id="dis_num_team" style="display:none;"><!--（队数）参赛方式为团队显示，为个人默认不显示-->
                        <td><?php echo $form->labelEx($model, 'min_num_team'); ?> <span class="required">*</span></td>
                        <td>
                            <?php
                                echo  $form->textField($model, 'min_num_team', array('class' => 'input-text','placeholder' => '请输入最少队数','style'=>'width: 70%;')) ;
                                echo $form->error($model, 'min_num_team', $htmlOptions = array());
                            ?> /队
                        </td>
                        <td><?php echo $form->labelEx($model, 'max_num_team'); ?> <span class="required">*</span></td>
                        <td>
                            <?php
                                echo  $form->textField($model, 'max_num_team', array('class' => 'input-text','placeholder' => '请输入最多队数','style'=>'width: 70%;')) ;
                                echo $form->error($model, 'max_num_team', $htmlOptions = array());
                            ?> /队
                        </td>
                    </tr>
                    <tr id="dis_team" style="display:none;"><!--（队伍人数）参赛方式为团队显示，为个人默认不显示，为混双默认不显示-->
                        <td><?php echo $form->labelEx($model, 'minimum_team'); ?> <span class="required">*</span></td>
                        <td>
                            <?php
                                echo  $form->textField($model, 'minimum_team', array('class' => 'input-text','placeholder' => '请输入最少人数','style'=>'width: 70%;')) ;
                                echo $form->error($model, 'minimum_team', $htmlOptions = array());
                            ?> /人
                        </td>
                        <td><?php echo $form->labelEx($model, 'team_member'); ?> <span class="required">*</span></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'team_member', array('class' => 'input-text','placeholder' => '请输入最多人数','style'=>'width: 70%;')) ;
                                echo $form->error($model, 'team_member', $htmlOptions = array());
                            ?> /人
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_physical_examination'); ?></td>
                        <td colspan="3">
                            <?php
                                echo $form->textField($model, 'game_physical_examination', array('class' => 'input-text','style'=>'width: 29.5%;
                                ')) ;
                                echo $form->error($model, 'game_physical_examination', $htmlOptions = array());
                            ?>
                            <br><span class="msg">注：请选择体检限制最早日期，早于该日期的报告不可用</span>
                        </td>
                    </tr>
                    <!--不可兼报项目开始-->
                    <tr>
                        <td>
                            <?php
                                echo $form->labelEx($model, 'F_exclusive_ID'); $model->id=empty($model->id) ?0 : $model->id; 
                                if(!empty($model->F_exclusive_ID)){
                                    // if(is_numeric($model->F_exclusive_ID) || !is_numeric($model->F_exclusive_ID)){
                                        $tid = rtrim($model->F_exclusive_ID,',');
                                        $project_list = GameListData::model()->findAll('id in('.$tid.')');
                                    // }
                                }
                            ?>
                        </td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'F_exclusive_ID', array('class' => 'input-text')); ?>
                            <span id="projectnot_box">
                                <?php if(!empty($project_list)){foreach($project_list as $v){?>
                                    <span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->game_data_name;?>
                                        <i onclick="fnDeleteProjectnot(this);"></i>
                                    </span>
                                <?php }}?>
                            </span>
                            <?php if($sh==721 || $sh==373){ echo '<input id="projectNOT_add_btn" class="btn" type="button" value="添加项目">'; } ?>
                            <?php echo $form->error($model, 'F_exclusive_ID', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">收费设置</td>
                    </tr>
                    <tr>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_money'); ?></td>
                        <td width="88%;">
                            <?php
                                echo $form->textField($model, 'game_money', array('class' => 'input-text','style'=>'width:29.5%;')) ;
                                echo $form->error($model, 'game_money', $htmlOptions = array());
                            ?> 元/人
                        </td>
                    </tr>
                </table>
                <table id="money" class="mt15" style="table-layout:auto;display:none;">
                    <tr class="table-title">
                        <td colspan="4">
                            <span>竞赛费用设置</span>
                            <input type="button" class="btn btn-blue" onclick="clickOrg();" style="float:right;margin-right:15px;" value="添加">
                        </td>
                    </tr>
                    <tr>
                        <td width="12%;">序号</td>
                        <td width="38%;">费用名称</td>
                        <td width="12%;">费用金额</td>
                        <td width="38%;">添加</td>
                    </tr>
                    <?php
                        $s_num = 1;
                        $data_money = GameListDataMoney::model()->findAll('game_data_id='.$model->id);
                        if(!empty($data_money))foreach($data_money as $dm){
                    ?>
                        <tr class="type_len">
                            <input type="hidden" name="money[<?php echo $s_num; ?>][id]" value="<?php echo $dm->id; ?>">
                            <td class="money_num"><?php echo $s_num; ?></td>
                            <td><input type="text" class="input-text" name="money[<?php echo $s_num; ?>][money_name]" value="<?php echo $dm->money_name; ?>"></td>
                            <td><input type="text" class="input-text" name="money[<?php echo $s_num; ?>][money]" value="<?php echo $dm->money; ?>"></td>
                            <td><a href="javascript:;" class="btn" onclick="clickDelete(this,<?php echo $s_num; ?>);">删除</a></td>
                        </tr>
                    <?php $s_num++; }?>
                </table>
                <table class="dis_btn mt15" style="table-layout:auto;">
                    <tr>
                        <td style="width:12%;">可执行操作</td>
                        <td style="width:88%;" colspan="3">
                            <div>
                                <?php if($_REQUEST['p_id']==1) { if(!($sh==372)) {?>
                                    <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                                    <?php echo show_shenhe_box(array('next'=>'下一步'));?>
                                    <button class="btn" type="reset">重置</button>
                                    <button class="btn" type="button" onclick="we.back();">取消</button>
                                <?php }}?>
                                <!-- <button class="btn" type="button" onclick="printpage();">打印</button> -->
                            </div>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
        //时间控制  
        $('#GameListData_game_group_star').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd'});  // ,mixDate:'#F{$dp.$D(\'GameListData_game_group_end\')}'
        });
        $('#GameListData_game_group_end').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd'});  // ,maxDate:'#F{$dp.$D(\'GameListData_game_group_star\')}'
        });

        $('#GameListData_signup_date').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});
        });
        $('#GameListData_signup_date_end').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});
        });

        $('#GameListData_game_physical_examination').on('click', function(){
            WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
        });
    })
    
    $('.btn-blue').on('click',function(){
        $player=$('#GameListData_game_player_team').val();
        $max_number=$('#GameListData_number_of_member').val();
        $max_num=$('#GameListData_max_num_team').val();
        $max_team=$('#GameListData_team_member').val();
        if($player==665 && ($max_number=='' || $max_number==0)){
            we.msg('minus','请输入最大参与人数');
            return false;
        }
        else if($player==666 && (($max_num=='' || $max_num==0) || ($max_team=='' || $max_team==0))){
            we.msg('minus','请输入最大队数与参与人数');
            return false;
        }
        else if($player==982 && ($max_num=='' || $max_num==0)){
            we.msg('minus','请输入最大队数');
            return false;
        }
    })

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
        var item_1=$('#GameListData_game_item_name').val();
        var item_2=$('#GameListData_game_item').val();
        if(item_2=='' && item_1==''){
            we.msg('minus','请先选择或输入比赛项目');
            $('#GameListData_game_player_team').val('');
            return false;
        }
        var show_id=$(obj).val();
        if(show_id==666){
            $('#dis_number').hide();
            $("#dis_num_team").show();
            $("#dis_team").show();
        }
        else if(show_id==982 || show_id==1452){
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

    function selectInsurance(obj){
        var show_id=$(obj).val();
        if(show_id==1002){
            $('.dis_insurance').show();
        }
        else{
            $('.dis_insurance').hide();
        }
    }

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
        // if(s8==235 || s8==236){
        //     $('#dis_weight').show();
        // }
        // else{
        //     $('#dis_weight').hide();
        // }
        // 自定义比赛项目
        if(s9!=''){
            $('#dis_game_item').hide();
        }
        else{
            $('#dis_game_item').show();
        }

        // 所有为“品势”的都隐藏公斤级
        // var option=$('#GameListData_game_item option:selected');
        // if(option.text()=='品势'){
        //     $('#dis_weight').hide();
        // }
        // else{
        //     $('#dis_weight').show();
        // }
        var weight=$('#GameListData_game_item option:selected').attr('weight');
        $('#GameListData_weight').val(weight);
        $('#dis_weight').hide();
        if(weight==649){
            $('#dis_weight').show();
        }
        
        // 参赛方式
        var show_id2=$('#GameListData_game_player_team').val();
        if(show_id2==666){
            $('#dis_number').hide();
            $("#dis_num_team").show();
            $("#dis_team").show();
        }
        else if(show_id2==982 || show_id2==1452){
            $("#dis_num_team").show();
            $("#dis_team").hide();
            $('#dis_number').hide();
        }
        else{
            $('#dis_number').show();
            $("#dis_num_team").hide();
            $("#dis_team").hide();
        }

        var insurance=$('#GameListData_insurance_set').val();
        if(insurance==1002){
            $('.dis_insurance').show();
        }
        else{
            $('.dis_insurance').hide();
        }
        
 
        // 不可兼报项目添加
        var num = 0;
        $('#projectNOT_add_btn').on('click', function(){
            var game_player_team = $('#GameListData_game_player_team').val();
            var game_sex = $('#GameListData_game_sex').val();
            var project_id=$('#GameListData_project_id').val();
            $.dialog.data('game_list_id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gameListData",array('game_id'=>$model->game_id,'id'=>$model->id));?>&project_id='+project_id+'&game_player_team='+game_player_team+'&game_sex='+game_sex,{
                id:'xiangmu',
                lock:true,
                opacity:0.3,
                title:'选择具体内容',
                width:'500px',
                height:'60%',
                close: function () {
                    // if($.dialog.data('game_list_id')>0){
                    //     if($('#project_item_'+$.dialog.data('game_list_id')).length==0){
                    //         $projectnot_box.append('<span class="label-box" id="project_item_'+$.dialog.data('game_list_id')+'" data-id="'+$.dialog.data('game_list_id')+'">'+$.dialog.data('game_list_title')+'<i onclick="fnDeleteProjectnot(this);"></i></span>');
                    //         fnUpdateProjectnot();
                    //     }
                    // }

                    
                    if($.dialog.data('id')==-1){
                        var boxnum=$.dialog.data('dispay_title');
                        for(var j=0;j<boxnum.length;j++) {
                            if($('#project_item_'+boxnum[j].dataset.id).length==0){
                                $projectnot_box.append('<span class="label-box" id="project_item_'+boxnum[j].dataset.id+'" data-id="'+boxnum[j].dataset.id+'">'+boxnum[j].dataset.title+'<i onclick="fnDeleteProjectnot(this);"></i></span>');
                                num++;
                                fnUpdateProjectnot();
                            }
                        }
                    }
                }
            });
        });
        
        $('#add_insurance').on('click', function(){
            $insurance_box = $('#insurance_box');
            $insurance_name = $('#insurance_name');
            $insurance_money = $('#insurance_money');
            $insurance_count = $('#insurance_count');
            $.dialog.data('id', 0);
            $.dialog.open('<?php echo $this->createUrl("select/gameListData_insurance");?>',{
                id:'shiyongleixing',
                lock:true,
                opacity:0.3,
                title:'请选择特定保险',
                width:'500px',
                height:'60%',
                close: function(){
                    if($.dialog.data('id')>0){
                        if($('#dispay_item_'+$.dialog.data('id')).length==0){
                            $insurance_box.html('<span class="label-box" data-id="'+$.dialog.data('id2')+'">'+$.dialog.data('game_code2')+'</span>');
                            $insurance_name.html('<span class="label-box" data-id="'+$.dialog.data('id2')+'" data-name2="'+$.dialog.data('game_name2')+'">'+$.dialog.data('game_name2')+'</span>');
                            $insurance_money.html('<span class="label-box" data-id="'+$.dialog.data('id2')+'" data-price="'+$.dialog.data('game_price')+'">'+$.dialog.data('game_price')+'</span>');
                            $insurance_count.html('<span class="label-box" data-id="'+$.dialog.data('id2')+'" data-count="'+$.dialog.data('game_count')+'">'+$.dialog.data('game_count')+'</span>');
                            $('#GameListData_insurance_code').val($.dialog.data('game_code2'));
                            $('#GameListData_insurance_id').val($.dialog.data('id2'));
                            $('#GameListData_insurance_title').val($.dialog.data('game_name2'));
                            $('#GameListData_sum_insured').val($.dialog.data('game_count'));
                            $('#GameListData_insurance').val($.dialog.data('game_price'));
                            $.dialog.close();
                        }
                    }
                }
            });
        });
    });

    var sname='<?php echo $model->game_project_name; ?>';
    selectOnchangProject('#GameListData_project_id');
    function selectOnchangProject(obj){
        var show_id=$(obj).val();
        var code,c1,c2;
        var code1;
        var p_html ='<option value="">请选择二级项目</option>';
        var g_html ='<option value="">请选择</option>';
        if (show_id>0) {
            for (j=0;j<$d_club_type2.length;j++) {
                if($d_club_type2[j]['fater_id']==show_id){
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
            
            var game_item = '<?php echo $model->game_item; ?>';
            for(i=0;i<$d_game_list2.length;i++){
                if($d_game_list2[i]['project_id']==show_id){
                    g_html = g_html +'<option value="'+$d_game_list2[i]['id']+'" weight="'+$d_game_list2[i]['game_weight']+'"';
                    if($d_game_list2[i]['id']==game_item){
                        g_html = g_html + 'selected';
                    }
                    g_html = g_html +' gamemodel="'+$d_game_list2[i]['game_model']+'" gamesex="'+$d_game_list2[i]['game_sex']+'">';
                    g_html = g_html +$d_game_list2[i]['game_item']+'</option>';
                }
            }
            $("#GameListData_game_item").html(g_html);
        }
        
        $('#dis_weight').hide();
    }

    // 自定义比赛项目
    var player=<?php echo $model->game_player_team; ?>;
    var sele_weight=<?php echo $model->game_sex; ?>;
    selectGameItem($('#GameListData_game_player_team'));
    function selectGameItem(obj){
        var show_id=$(obj).val();
        if(show_id!=''){
            $('#dis_game_item').hide();
        }
        else{
            $('#dis_game_item').show();
        }
    
        var weight=$('#GameListData_game_item option:selected').attr('weight');
        if(weight==648){
            $('#dis_weight').hide();
            $('#GameListData_weight').val(weight);
        }
        else if(weight==649){
            $('#dis_weight').show();
            $('#GameListData_weight').val(weight);
        }
        else{
            $('#dis_weight').hide();
            $('#GameListData_weight').val(weight);
        }

        var game_model=$('#GameListData_game_item option:selected').attr('gamemodel');
        var game_sex=$('#GameListData_game_item option:selected').attr('gamesex');
        var model=game_model.split(',');
        var p_html ='<option value>请选择</option>';
        var k_html ='<option value>请选择</option>';
        if(show_id>0){
            for(var i=0;i<model.length;i++){
                var name=model[i];
                if(name==665){name='单人'}
                else if(name==666){name='团体'}
                else if(name==982){name='混双'}
                else if(name==1452){name='双人'}
                if(player==model[i]){
                    p_html=p_html+'<option value="'+model[i]+'" selected="selected">'+name+'</option>';
                }
                else{
                    p_html=p_html+'<option value="'+model[i]+'">'+name+'</option>';
                }
            }
            $("#GameListData_game_player_team").html(p_html);

            for(var k=0;k<$d_game_sex.length;k++){
                if(game_sex==648){
                    k_html='<option value="220" selected>不限</option>';
                }
                else{
                    if(sele_weight==$d_game_sex[k]['f_id']){
                        k_html=k_html+'<option value="'+$d_game_sex[k]['f_id']+'" selected="selected">'+$d_game_sex[k]['F_NAME']+'</option>';
                    }
                    else{
                        k_html=k_html+'<option value="'+$d_game_sex[k]['f_id']+'">'+$d_game_sex[k]['F_NAME']+'</option>';
                    }
                }
            }
            $("#GameListData_game_sex").html(k_html);
        }
        var option=$('#GameListData_game_item option:selected');
        $('#GameListData_game_item_name').val(option.text());
    }

    function clickOrg(){
        var len = $('.type_len').length;
        var num = len+1;
        var s_html = 
            '<tr class="type_len">'+
                '<input type="hidden" name="money['+num+'][id]" value="null">'+
                '<td class="money_num">'+num+'</td>'+
                '<td><input class="input-text" name="money['+num+'][money_name]" type="text"></td>'+
                '<td><input class="input-text" name="money['+num+'][money]" type="text"></td>'+
                '<td><a href="javascript:;" class="btn" onclick="clickDelete(this,'+num+');">删除</a></td>'+
            '</tr>';
        $('#money').append(s_html);
    }

    function clickDelete(obj){
        $(obj).parent().parent().remove();
        var s = 1;
        $('.money_num').each(function(){
            $(this).html(s);
            s++;
        });
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
                .input-text {border:none;width:75%;}\
                .msg {display:none}\
                select {appearance:none;-webkit-appearance:none;border:none;}\
            </style>\
            </head>');
        newWin.document.write('<div><div class="box-detail">'+html+'</div></div>');
        newWin.print();
        newWin.close(); //关闭新产生的标签页
    }
</script>
