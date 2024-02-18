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
    if(!empty($model->game_id)){
        $game_list=GameList::model()->find('id='.$model->game_id);
    }
    else {
        $game_list=GameList::model()->find('id='.$_REQUEST['game_id']);
    }
    $sh = $game_list->state;
    $disabled = '';//($sh==372) ?  'disabled' : '' ;
    $arr=ProjectList::model()->getProject_id2();
    $arr1=ProjectListGame::model()->getProjectGame_id2();
    $arr2=BaseCode::model()->getCode_sex();
 ?>
<script>
    var $d_club_type2= <?php echo json_encode($arr)?>;
    var $d_game_list2= <?php echo json_encode($arr1)?>;
    var $d_game_sex= <?php echo json_encode($arr2)?>;
</script>
<div class="box">
    <div id="t0" class="box-title c">
        <h1><i class="fa fa-table"></i><?php if($model->id=='') {?><?php echo $game_list->game_title.' /'; ?>赛事项目添加<?php }else{?><?php echo $model->game_name.' /赛事项目管理'; }?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameListData/index', array('game_id'=>$_REQUEST['game_id'],'title'=>$game_list->game_title,'type'=>$model->game_list->game_type));?>');">
                <i class="fa fa-reply"></i>返回项目列表
            </a>
        </span>
    </div><!--box-title end-->
    <div id="t1" class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table class="mt15" style="table-layout:auto;">
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
                            <?php echo $form->dropDownList($model, 'game_name_id', Chtml::listData(ProjectList::model()->findAll(), 'id', 'project_name'), array('prompt'=>'请选择二级项目','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'project_id', $htmlOptions = array()); ?>
                            <!--<?php //echo $form->error($model, 'game_name_id', $htmlOptions = array()); ?>-->
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
                            <br><span class="msg">注：如选择自定义请在“竞赛项目”重新填写组别</span>
                        </td>
                    </tr>
                    <tr id="dis_weight" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'weight_min'); ?></td>
                        <td>
                            <?php echo ($sh==721 || $sh==373) ? $form->textField($model, 'weight_min', array('class' => 'input-text','placeholder' => '请输入最小值')) : $model->weight_min; ?>
                            </br><span class="msg">注：请输入赛事项目要求最低的体重数 如：25kg</span>
                            <?php echo $form->error($model, 'weight_min', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'weight_max'); ?></td>
                        <td>
                            <?php echo ($sh==721 || $sh==373) ? $form->textField($model, 'weight_max', array('class' => 'input-text','placeholder' => '请输入最大值')) : $model->weight_max; ?>
                            </br><span class="msg">注：请输入赛事项目要求最高的体重数 如：50kg</span>
                            <?php echo $form->error($model, 'weight_max', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_data_name'); ?></td>
                        <td colspan="3">
                            <?php
                                if($model->id==''){
                                    echo $form->textField($model, 'game_data_name',array('class'=>'input-text','readonly'=>'readonly'));
                                }
                                else{
                                    echo ($sh==721 || $sh==373) ? $form->textField($model, 'game_data_name',array('class'=>'input-text')) : $model->game_data_name;
                                }
                            ?></br>
                            <?php
                                if($model->game_data_name==''){
                                    echo '<span class="msg">注：新建或为空时自动生成</span>';
                                }
                                else{
                                    echo '<span class="msg">注：以上属性更改后，需要在这里重新填写</span>';
                                }
                            ?>
                        </td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">竞赛项目设置</td>
                    </tr>
                    <tr>
                        <td style="width:12%;"><?php echo $form->labelEx($model, 'game_mode'); ?></td>
                        <td style="width:38%;">
                            <?php echo $form->dropDownList($model, 'game_mode', Chtml::listData(BaseCode::model()->getCode(660), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_mode', $htmlOptions = array()); ?>
                        </td>
                        <td style="width:12%;"><?php echo $form->labelEx($model, 'game_format'); ?></td>
                        <td style="width:38%;">
                            <?php echo $form->dropDownList($model, 'game_format', Chtml::listData(BaseCode::model()->getCode(984), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchangGameList(this)','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_format', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'isSignOnline'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'isSignOnline', Chtml::listData(BaseCode::model()->getCode(640), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'isSignOnline', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_check_way'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_check_way', Chtml::listData(BaseCode::model()->getCode(791), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_check_way', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_physical_examination'); ?></td>
                        <td>
                            <?php
                               echo $form->textField($model, 'game_physical_examination', array('class' => 'input-text')) ;
                                echo $form->error($model, 'game_physical_examination', $htmlOptions = array());
                            ?>
                            <br><span class="msg">注：请选择体检限制最早日期，早于该日期的报告不可用</span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_dg_level'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_dg_level', Chtml::listData(MemberCard::model()->getCode(210), 'f_id', 'card_name'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'game_dg_level', $htmlOptions = array()); ?>
                            <br><span class="msg">注：不选择为不限等级</span>
                        </td>
                    </tr>
                   
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_group_star'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'game_group_star', array('class' => 'input-text','placeholder' => '请选择可允许最大年龄','style'=>'width: 70%;')) ;
                                echo $form->error($model, 'game_group_star', $htmlOptions = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_group_end'); ?></td>
                        <td>
                            <?php
                                echo  $form->textField($model, 'game_group_end', array('class' => 'input-text','placeholder' => '请选择可允许最小年龄','style'=>'width: 70%;'));
                                echo $form->error($model, 'game_group_end', $htmlOptions = array());
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
                    <!--不可兼报项目开始-->
                    <tr>
                        <td>
                            <?php
                                echo $form->labelEx($model, 'F_exclusive_ID'); $model->id=empty($model->id) ?0 : $model->id; 
                                if(!empty($model->F_exclusive_ID)){
                                    // if(is_numeric($model->F_exclusive_ID) || !is_numeric($model->F_exclusive_ID)){
                                        $project_list = GameListData::model()->findAll('id in('.$model->F_exclusive_ID.')');
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
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_money'); ?></tdw>
                        <td width="88%;">
                            <?php
                                echo $form->textField($model, 'game_money', array('class' => 'input-text','style'=>'width:29.5%;')) ;
                                echo $form->error($model, 'game_money', $htmlOptions = array());
                            ?> 元/人
                        </td>
                        <!-- <td width="12%;"><?php //echo $form->labelEx($model, 'insurance_set'); ?></td>
                        <td width="38%;">
                            <?php //echo $form->dropDownList($model, 'insurance_set', Chtml::listData(BaseCode::model()->getCode(1001), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange'=>'selectInsurance(this)','disabled'=>$disabled)); ?>
                            <?php //echo $form->error($model, 'insurance_set', $htmlOptions = array()); ?>
                        </td> -->
                    </tr>
                </table>
                <table class="mt15 table-title dis_insurance" style="display:none;">
                    <tr>
                        <td colspan="4">特定保险信息</td>
                    </tr>
                </table>
                <table class="dis_insurance">
                    <?php
                        $game_insurance=GameListData::model()->find('game_id='.$model->game_id.' AND project_id='.$model->project_id.' AND insurance_set="1002" order by uDate');
                        $game_count=GameListData::model()->count('game_id='.$model->game_id.' AND project_id='.$model->project_id.' AND insurance_set="1002"');
                    ?>
                    <?php 
                        if(!empty($model->insurance_id)){
                            echo $form->hiddenField($model, 'insurance_id');
                            echo $form->hiddenField($model, 'insurance_code');
                            echo $form->hiddenField($model, 'insurance_title');
                            echo $form->hiddenField($model, 'insurance');
                            echo $form->hiddenField($model, 'sum_insured');
                        }
                        else if($game_count=1 && !empty($game_insurance))foreach($game_insurance as $g){
                            echo $form->hiddenField($g, 'insurance_id');
                            echo $form->hiddenField($g, 'insurance_code');
                            echo $form->hiddenField($g, 'insurance_title');
                            echo $form->hiddenField($g, 'insurance');
                            echo $form->hiddenField($g, 'sum_insured');
                        }
                        else{
                        echo $form->hiddenField($model, 'insurance_id',array('value'=>''));
                        echo $form->hiddenField($model, 'insurance_code',array('value'=>''));
                        echo $form->hiddenField($model, 'insurance_title',array('value'=>''));
                        echo $form->hiddenField($model, 'insurance',array('value'=>''));
                        echo $form->hiddenField($model, 'sum_insured',array('value'=>''));
                        }
                    ?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'insurance_code');?></td>
                        <td>
                            <span id="insurance_box">
                                <?php if(!empty($model->insurance_id)){?>
                                    <span class="label-box"><?php echo $model->insurance_code; ?></span>
                                <?php }else if($game_count=1 && !empty($game_insurance))foreach($game_insurance as $g){?>
                                    <span class="label-box"><?php echo $g->insurance_code; ?></span>
                                <?php }?>
                            </span>
                            <input id="add_insurance" class="btn" type="button" value="选择">
                        </td>
                        <td><?php echo $form->labelEx($model, 'insurance_title'); ?></td>
                        <td>
                            <span id="insurance_name">
                                <?php if(!empty($model->insurance_id)){?>
                                    <span class="label-box"><?php echo $model->insurance_title; ?></span>
                                <?php }else if($game_count=1 && !empty($game_insurance))foreach($game_insurance as $g){?>
                                    <span class="label-box"><?php echo $g->insurance_title; ?></span>
                                <?php }?>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'insurance'); ?></td>
                        <td>
                            <span id="insurance_money">
                                <?php if(!empty($model->insurance_id)){?>
                                    <span class="label-box"><?php echo $model->insurance; ?></span>
                                <?php }else if($game_count=1 && !empty($game_insurance))foreach($game_insurance as $g){?>
                                    <span class="label-box"><?php echo $g->insurance; ?></span>
                                <?php }?>
                            </span>元/人
                        </td>
                        <td><?php echo $form->labelEx($model, 'sum_insured'); ?></td>
                        <td>
                            <span id="insurance_count">
                                <?php if(!empty($model->insurance_id)){?>
                                    <span class="label-box"><?php echo $model->sum_insured; ?></span>
                                <?php }else if($game_count=1 && !empty($game_insurance))foreach($game_insurance as $g){?>
                                    <span class="label-box"><?php echo $g->sum_insured; ?></span>
                                <?php }?>
                            </span>元/人
                        </td>
                    </tr>
                </table>
             
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    <?php $this->endWidget();?>
  </div><!--box-detail end-->
</div><!--box end-->
