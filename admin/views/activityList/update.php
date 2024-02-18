<?php
    if(!empty($model->dispay_star_time=='0000-00-00 00:00:00')){
        $model->dispay_star_time='';
    }
    if(!empty($model->dispay_end_time=='0000-00-00 00:00:00')){
        $model->dispay_end_time='';
    }
    if(!empty($model->sign_up_date=='0000-00-00 00:00:00')){
        $model->sign_up_date='';
    }
    if(!empty($model->sign_up_date_end=='0000-00-00 00:00:00')){
        $model->sign_up_date_end='';
    }
    if(!empty($model->effective_time=='0000-00-00 00:00:00')){
        $model->effective_time='';
    }
    if(!empty($model->activity_time=='0000-00-00')){
        $model->activity_time='';
    }
    if(!empty($model->activity_time_end=='0000-00-00')){
        $model->activity_time_end='';
    }
    if(!empty($list_data)){
        foreach($list_data as $d){
            if(!empty($d->activity_time=='0000-00-00')){
                $d->activity_time='';
            }
            if(!empty($d->activity_time_end=='0000-00-00')){
                $d->activity_time_end='';
            }
            if(!empty($d->min_age=='0000-00-00')){
                $d->min_age='';
            }
            if(!empty($d->max_age=='0000-00-00')){
                $d->max_age='';
            }
        }
    }
    $sh = $model->state;
    $disabled = !empty($_REQUEST['disabled'])&&$model->state!=721 ? 'disabled' : ''; 
    $genggai = !empty($_REQUEST['genggai']) ? true : false;
?>
<div class="box">
    <div id="t0" class="box-title c">
        <h1>当前界面：培训/活动 》活动发布 》发布 》<?php echo (empty($model->id)) ? '添加' : '/详情'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list2('baocun')); ?>
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>活动介绍</li>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table id="t1" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'activity_code'); ?></td>
                        <td width="40%;"><?php echo $model->activity_code; ?></td>
                        <td width="10%;"><?php echo $form->labelEx($model, 'activity_club_name'); ?></td>
                        <td width="40%;">
                            <?php
                                if(empty($model->id)){
                                    $activity_club_id=get_session('club_id');
                                    $activity_club_code=get_session('club_code');
                                    $activity_club_name=get_session('club_name');
                                }else{
                                    $activity_club_id=$model->activity_club_id;
                                    $activity_club_code=$model->activity_club_code;
                                    $activity_club_name=$model->activity_club_name;
                                }
                                echo $form->hiddenField($model, 'activity_club_id', array('class' => 'input-text','value'=>$activity_club_id));
                                echo $form->hiddenField($model, 'activity_club_code', array('class' => 'input-text','value'=>$activity_club_code));
                                echo $form->hiddenField($model, 'activity_club_name', array('class' => 'input-text','value'=>$activity_club_name));
                                echo $activity_club_name;
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'activity_title'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'activity_title', array('class' => 'input-text','disabled'=>$disabled));
                                echo $form->error($model, 'activity_title', $htmlOptions = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'activity_online'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'activity_online', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>$disabled)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'activity_address'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'activity_address', array('class' => 'input-text','disabled'=>$disabled));
                                echo $form->error($model,'activity_address',$htmlOption = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model,'navigatio_address'); ?></td>
                        <td>
                            <?php
                                echo  $form->textField($model,'navigatio_address',array('class'=>'input-text','disabled'=>$disabled)) ;
                                echo $form->hiddenField($model, 'Longitude');
                                echo $form->hiddenField($model, 'latitude');
                                echo $form->error($model,'navigatio_address',$htmlOption = array());
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'way_referee'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'way_referee', Chtml::listData(BaseCode::model()->getCode(1507), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>'));?>
                            <?php echo $form->error($model, 'way_referee', $htmlOptions = array()); ?>
                        </td>
                        <td>
                            <?php echo $form->labelEx($model, 'sign_up_date'); ?>
                            <?php echo $form->labelEx($model, 'sign_up_date_end', array('style'=>'display:none;')); ?>
                        </td>
                        <td>
                            <?php 
                                if($genggai==1&&$model->sign_up_date<date('Y-m-d H:i:s')){
                                    echo $form->textField($model, 'sign_up_date', array('class' => 'input-text','disabled'=>'disabled','style'=>'width:150px;','placeholder'=>'报名开始时间')) ; 
                                }else{
                                    echo $form->textField($model, 'sign_up_date', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'报名开始时间')) ; 
                                }
                            ?>
                            -
                            <?php 
                                if($genggai==1&&$model->sign_up_date_end<date('Y-m-d H:i:s')){
                                    echo $form->textField($model, 'sign_up_date_end', array('class' => 'input-text','disabled'=>'disabled','style'=>'width:150px;','placeholder'=>'报名截止时间')) ; 
                                }else{
                                    echo $form->textField($model, 'sign_up_date_end', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'报名截止时间')) ;
                                }
                            ?>
                            <?php echo $form->error($model, 'sign_up_date', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'sign_up_date_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'activity_time'); ?>
                            <?php echo $form->labelEx($model, 'activity_time_end', array('style'=>'display:none;')); ?>
                        </td>
                        <td>
                            <?php 
                                if($genggai==1&&$model->activity_time<date('Y-m-d H:i:s')){
                                    echo $form->textField($model, 'activity_time', array('class' => 'input-text','disabled'=>'disabled','style'=>'width:150px;','placeholder'=>'活动开始时间')) ; 
                                }else{
                                    echo $form->textField($model, 'activity_time', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'活动开始时间')) ; 
                                }
                            ?>
                            -
                            <?php echo $form->textField($model, 'activity_time_end', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'活动截止时间')) ; ?>
                            <?php echo $form->error($model, 'activity_time', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'activity_time_end', $htmlOptions = array()); ?>
                        </td>
                        <td>
                            <?php echo $form->labelEx($model, 'dispay_star_time'); ?>
                            <?php echo $form->labelEx($model, 'dispay_end_time', array('style'=>'display:none;')); ?>
                        </td>
                        <td>
                            <?php echo  $form->textField($model, 'dispay_star_time', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'显示开始时间')) ; ?>
                            -
                            <?php echo $form->textField($model, 'dispay_end_time', array('class' => 'input-text','disabled'=>$disabled,'style'=>'width:150px;','placeholder'=>'显示截止时间')) ; ?>
                            <?php echo $form->error($model, 'dispay_star_time', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'dispay_end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'local_men'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'local_men', array('class' => 'input-text','disabled'=>$disabled)) ;
                                echo $form->error($model, 'local_men', $htmlOptions = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model,'local_and_phone');?></td>
                        <td>
                            <?php
                                echo  $form->textField($model, 'local_and_phone', array('class' => 'input-text','disabled'=>$disabled)) ;
                                echo $form->error($model, 'local_and_phone', $htmlOptions = array());
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'organizational'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textarea($model,'organizational',array('class'=>'input-text','disabled'=>$disabled)); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'activity_small_pic'); ?></td>
                        <td id="dpic_activity_small_pic">
                            <?php
                                echo $form->hiddenField($model, 'activity_small_pic', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(293);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->activity_small_pic!=''){
                            ?>
                            <div class="upload_img fl" id="upload_pic_ActivityList_activity_small_pic">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->activity_small_pic;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->activity_small_pic;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php if($disabled==''){ ?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_activity_small_pic','<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'activity_small_pic', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'activity_big_pic'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'activity_big_pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_ActivityList_activity_big_pic">
                                <?php 
                                    $basepath=BasePath::model()->getPath(294);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                    if(!empty($activity_big_pic))foreach($activity_big_pic as $v) {
                                ?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="50">
                                    <?php if($disabled==''){ ?>
                                        <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i>
                                    <?php }?>
                                </a>
                                <?php }?>
                            </div>
                            <?php if($disabled==''){ ?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_activity_big_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);});</script>
                            <?php }?>
                            <?php echo $form->error($model, 'activity_big_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <div class="mt15" id="activity_data">
                    <?php if($disabled==''){ ?>
                        <div style="text-align: right;padding-right: 50px;">
                            <span><input type="button" class="btn" onclick="add_tag();" value="添加"></span>
                        </div>
                    <?php }?>
                    
                    <?php 
                        if(!empty($list_data)){
                            $num=0;
                            foreach($list_data as $d){
                    ?>
                        <table class="mt15 activity_data" data_index="<?= $num;?>" style="table-layout:auto;">
                            <tr class="table-title">
                                <td colspan="3">活动信息</td>
                                <input class="input-text" name="add_tag[<?= $num;?>][data_id]" type="hidden" value="<?= $d->id?>" <?= $disabled!=''?'disabled':'';?>>
                                <td style="text-align:right;">
                                    <?php if($disabled==''){?>
                                        <a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>
                                    <?php }?>
                                </td>
                            </tr>
                            <tr>
                                <td>项目</td>
                                <td>
                                    <select name="add_tag[<?= $num;?>][project_id]" id="project_id_<?= $num;?>" <?= $disabled!=''?'disabled':'';?>>
                                        <option value="">请选择</option>
                                        <?php 
                                            $text='';
                                            if(isset($project))foreach($project as $j){
                                                $text.='<option value="'.$j['project_id'].'" ';
                                                if($j['project_id']==$d->project_id){
                                                    $text.='selected';
                                                }
                                                $text.='>'.$j['project_name'].'</option>';
                                            }
                                            echo $text;
                                        ?>
                                    </select>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                                <td>活动时间 <span class="required">*</span></td>
                                <td>
                                    <input style="width:150px" name="add_tag[<?= $num;?>][activity_time]" id="time<?= $num;?>" class="input-text time" value="<?= $d->activity_time;?>" placeholder='开始时间' <?= $disabled!=''?'disabled':'';?>>
                                    -
                                    <input style="width:150px" name="add_tag[<?= $num;?>][activity_time_end]" id="time_end<?= $num;?>" class="input-text time_end" value="<?= $d->activity_time_end;?>" placeholder='结束时间' <?= $disabled!=''?'disabled':'';?>>
                                    <div class="errorMessage" id="time<?= $num;?>_em_" style="display:none"></div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%;">活动内容 <span class="required">*</span></td>
                                <td style="width:40%;">
                                    <input name="add_tag[<?= $num;?>][activity_content]" id="activity_content_<?= $num;?>" class="input-text" value="<?= $d->activity_content;?>" <?= $disabled!=''?'disabled':'';?>>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                                <td style="width:10%;">可报名人数 <span class="required">*</span></td>
                                <td style="width:40%;">
                                    <input name="add_tag[<?= $num;?>][apply_number]" id="apply_number_<?= $num;?>" class="input-text" value="<?= $d->apply_number;?>" onchange="isRealNum(this)" <?= $disabled!=''?'disabled':'';?>>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>活动费用（元） <span class="required">*</span></td>
                                <td>
                                    <input name="add_tag[<?= $num;?>][activity_money]" id="activity_money_<?= $num;?>" class="input-text mony" value="<?= $d->activity_money;?>" <?= $disabled!=''?'disabled':'';?>>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                                <td>报名审核方式 <span class="required">*</span></td>
                                <td>
                                    <input id="ActivityListData_apply_check_way_<?= $num?>" type="hidden" value="" name="add_tag[<?= $num?>][apply_check_way]" <?= $disabled!=''?'disabled':'';?>>
                                    <?php 
                                        $text1='';
                                        if(isset($check_way))foreach($check_way as $y){
                                            $text1.='<span class="check">';
                                            $text1.='<input class="input-check" id="ActivityListData_apply_check_way_'.$y['f_id'].'_'.$num.'" value="'.$y['f_id'].'" type="radio" name="add_tag['.$num.'][apply_check_way]" ';
                                            if($disabled!=''){
                                                $text1.='disabled ';
                                            }
                                            if($y['f_id']==$d->apply_check_way){
                                                $text1.='checked';
                                            }
                                            $text1.='>';
                                            $text1.='<label for="ActivityListData_apply_check_way_'.$y['f_id'].'_'.$num.'">'.$y['F_NAME'].'</label>';
                                            $text1.='</span>';
                                        }
                                        echo $text1;
                                    ?>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>报名年龄要求 <span class="required">*</span></td>
                                <td colspan="3">
                                    <input id="min_age<?= $num;?>" style="width:100px" name="add_tag[<?= $num;?>][min_age]" class="input-text min_age" value="<?= $d->min_age;?>" placeholder='最小年龄出生日期' <?= $disabled!=''?'disabled':'';?> readonly>&nbsp;<span><?php echo '('.$model->getAge(strtotime($d->min_age)).'周岁)';?></span>
                                    -
                                    <input id="max_age<?= $num;?>" style="width:100px" name="add_tag[<?= $num;?>][max_age]" class="input-text max_age" value="<?= $d->max_age;?>" placeholder='最大年龄出生日期' <?= $disabled!=''?'disabled':'';?> readonly>&nbsp;<span><?php echo '('.$model->getAge(strtotime($d->max_age)).'周岁)';?></span>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                        </table>
                    <?php $num++;}}else{?>
                        <table class="mt15 activity_data" data_index="0" style="table-layout:auto;">
                            <tr class="table-title">
                                <td colspan="3">活动信息</td>
                                <input class="input-text" name="add_tag[0][data_id]" type="hidden" value="-1">
                                <td style="text-align:right;">
                                    <a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%;">项目</td>
                                <td style="width:40%;">
                                    <select name="add_tag[0][project_id]" id="project_id_0">
                                        <option value="">请选择</option>
                                        <?php 
                                            $text='';
                                            if(isset($project))foreach($project as $j){
                                                $text.='<option value="'.$j['project_id'].'" >'.$j['project_name'].'</option>';
                                            }
                                            echo $text;
                                        ?>
                                    </select>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                                <td style="width:10%;">活动时间 <span class="required">*</span></td>
                                <td style="width:40%;">
                                    <input style="width:150px" name="add_tag[0][activity_time]" id="time0" class="input-text time" placeholder='开始时间' <?= $disabled!=''?'disabled':'';?>>
                                    -
                                    <input style="width:150px" name="add_tag[0][activity_time_end]" id="time_end0" class="input-text time_end" placeholder='结束时间' <?= $disabled!=''?'disabled':'';?>>
                                    <div class="errorMessage" id="time0_em_" style="display:none"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>活动内容 <span class="required">*</span></td>
                                <td>
                                    <input name="add_tag[0][activity_content]" id="activity_content_0" class="input-text">
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                                <td>可报名人数 <span class="required">*</span></td>
                                <td>
                                    <input name="add_tag[0][apply_number]" id="apply_number_0" class="input-text" onchange="isRealNum(this)">
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>活动费用（元） <span class="required">*</span></td>
                                <td>
                                    <input name="add_tag[0][activity_money]" id="activity_money_0" class="input-text mony" >
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                                <td>报名审核方式 <span class="required">*</span></td>
                                <td>
                                    <input id="ActivityListData_apply_check_way_0" type="hidden" value="" name="add_tag[0][apply_check_way]">
                                    <?php 
                                        $text1='';
                                        if(isset($check_way))foreach($check_way as $y){
                                            $text1.='<span class="check">';
                                            $text1.='<input class="input-check" id="ActivityListData_apply_check_way_'.$y['f_id'].'_0" value="'.$y['f_id'].'" type="radio" name="add_tag[0][apply_check_way]" >';
                                            $text1.='<label for="ActivityListData_apply_check_way_'.$y['f_id'].'_0">'.$y['F_NAME'].'</label>';
                                            $text1.='</span>';
                                        }
                                        echo $text1;
                                    ?>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                            <tr>
                                <td>报名年龄要求 <span class="required">*</span></td>
                                <td colspan="3">
                                    <input id="min_age0" style="width:100px" name="add_tag[0][min_age]" class="input-text min_age" placeholder='最小年龄出生日期' readonly>&nbsp;<span></span>
                                    -
                                    <input id="max_age0" style="width:100px" name="add_tag[0][max_age]" class="input-text max_age" placeholder='最大年龄出生日期' readonly>&nbsp;<span></span>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                        </table>
                    <?php }?>
                </div>
                <?php echo $form->hiddenField($model, 'remove_data_ids');?>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td>
                            <?php echo $form->hiddenField($model, 'explain_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_explain_temp', '<?php echo get_class($model);?>[explain_temp]');</script>
                            <?php echo $form->error($model, 'explain_temp', $htmlOptions = array()); ?>

                            <?php echo $form->hiddenField($model, 'explain_temp', array('class' => 'input-text')); ?>
                            <script>we.editor('<?php echo get_class($model);?>_explain_temp', '<?php echo get_class($model);?>[explain_temp]');</script>
                            <?php echo $form->error($model, 'explain_temp', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
            <table class="mt15">
                <?php if($model->state!=721){?>
                    <tr>
                        <td width='10%'>审核状态</td>
                        <td width='40%'>
                            <?php echo $model->state_name; ?>
                        </td>
                        <td width='10%'><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                        <td width='40%'>
                            <?php echo $form->textArea($model, 'reasons_failure', array('class' => 'input-text' ,'disabled'=>$model->state==371?false:true)); ?>
                            <?php echo $form->error($model, 'reasons_failure', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                <?php }?>
                <tr>
                    <td width="10%;">可执行操作</td>
                    <td colspan="3" class="sub_box">
                        <?php if($genggai==1){?>
                            <button id="genggai" onclick="submitType='genggai'" class="btn btn-blue" type="submit">保存更改</button>
                        <?php }else{?>
                            <?php if($model->state==721){?>
                                <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                                <button id="xiabu" class="btn btn-blue" onclick="submitType='xiabu'" type="submit" >下一步</button>
                                <button id="shenhe" onclick="submitType='shenhe'" class="btn btn-blue" type="submit" style="display:none;"> 提交审核</button>
                            <?php }elseif($model->state==371){?>
                                <?php if(!empty($_REQUEST['index'])&&$_REQUEST['index']=='submit'){?>
                                    <button id="quxiao" onclick="submitType='quxiao'" class="btn btn-blue" type="submit">撤销</button>
                                <?php }else{?>
                                    <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
                                <?php }?>
                            <?php }elseif($model->state==373){?>
                                <button id="cxbj" onclick="submitType='cxbj'" class="btn btn-blue" type="submit" >重新编辑</button>
                            <?php }else{?>
                                <?php echo $model->state_name; ?>
                            <?php }?>
                        <?php }?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<?php
function get_form_list2($submit='=='){
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if($("#ActivityList_activity_time").val()<$("#ActivityList_sign_up_date_end").val().substring(0, 10)){
                        hasError=true;
                        data.ActivityList_activity_time=["活动开始时间必须大于报名截止时间"];
                        $("#ActivityList_activity_time_em_").html("活动开始时间必须大于报名截止时间").show();
                    }
                    $(".time").each(function(){
                        var th=$(this);
                        if($(this).val()<$("#ActivityList_activity_time").val()){
                            hasError=true;
                            data.time=["活动时间必须在活动开始与截止时间范围内"];
                            th.parent().find(".errorMessage").html("活动时间必须在活动开始与截止时间范围内").show();
                        }
                    })
                    $(".time_end").each(function(){
                        var th=$(this);
                        if($(this).val()>$("#ActivityList_activity_time_end").val()){
                            hasError=true;
                            data.time_end=["活动时间必须在活动开始与截止时间范围内"];
                            th.parent().find(".errorMessage").html("活动时间必须在活动开始与截止时间范围内").show();
                        }
                    })
                    $(".activity_data").each(function(){
                        var tl=$(this);
                        $(this).find("input").each(function(){
                            var th=$(this);
                            if(th.is(":visible")){
                                var attr_id=th.attr("id");
                                attr_id = attr_id.substring(0, attr_id.length - tl.attr("data_index").length);
                                if(th.val()==""){
                                    hasError=true;
                                    var text=th.parents("td").prev().text();
                                    text=text.substring(0,text.length-1);
                                    data[attr_id]=[text+"不能为空"];
                                    th.parents("td").find(".errorMessage").html(text+"不能为空").show();
                                }else{
                                    th.parents("td").find(".errorMessage").html("").hide();
                                }
                            }
                        })
                        var radio792=$("#ActivityListData_apply_check_way_792_"+tl.attr("data_index")+":checked").val();
                        var radio793=$("#ActivityListData_apply_check_way_793_"+tl.attr("data_index")+":checked").val();
                        if(!radio792&&!radio793){
                            hasError=true;
                            var text=$("#ActivityListData_apply_check_way_"+tl.attr("data_index")).parents("td").prev().text();
                            text=text.substring(0,text.length-1);
                            data["ActivityListData_apply_check_way_"]=[text+"不能为空"];
                            $("#ActivityListData_apply_check_way_"+tl.attr("data_index")).parents("td").find(".errorMessage").html(text+"不能为空").show();
                        }else{
                            $("#ActivityListData_apply_check_way_"+tl.attr("data_index")).parents("td").find(".errorMessage").html("").hide();
                        }
                    })

                    if(!hasError||(submitType=="'.$submit.'")){
                        if(sType=="xiabu"){
                            $(".box-detail-tab li").eq(1).click();
                        }else{   
                            we.overlay("show");
                            $.ajax({
                                type:"post",
                                url:form.attr("action"),
                                data:form.serialize()+"&submitType="+submitType,
                                dataType:"json",
                                success:function(d){
                                    if(d.status==1){
                                        we.success(d.msg, d.redirect);
                                    }else{
                                        we.error(d.msg, d.redirect);
                                    }
                                }
                            });
                        }
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
            )
        );
  }
?>
<script>
    $(function(){
        if($("#upload_pic_ActivityList_activity_big_pic .picbox").length>=5){
            $("#upload_box_ActivityList_activity_big_pic").hide();
        }
        
        var sType='';
        var disabled= <?php echo json_encode($disabled)?>;
        if(disabled!=''){
            setTimeout(function(){ UE.getEditor('editor_ActivityList_explain_temp').setDisabled('fullscreen'); }, 500);
        }
    })
    $(".box-detail-tab li").on("click",function(){
        if($(this).hasClass('current')){
            return false;
        }
        $("*").removeClass('current');
        $(this).addClass('current');
        $(".box-detail-tab-item").hide();
        $(".box-detail-tab-item").eq($(this).index()).show();
        if($(this).index()==1){
            $("#xiabu").hide();
            $("#shenhe").show();
        }else{
            $("#xiabu").show();
            $("#shenhe").hide();
        }
    })
    $(document).on("click",".btn-blue",function(){
        sType=$(this).attr("id");
    })
    
    // 选择显示开始时间
    $('#ActivityList_dispay_star_time').on('click', function() {
        var end_input=$dp.$('ActivityList_dispay_end_time')
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ActivityList_dispay_end_time\')}'});
    });
    // 选择显示截止时间
    $('#ActivityList_dispay_end_time').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ActivityList_dispay_star_time\')}'});
    });

    // 选择报名开始时间
    $('#ActivityList_sign_up_date').on('click', function() {
        var end_input=$dp.$('ActivityList_sign_up_date_end')
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ActivityList_sign_up_date_end\')}'});
    });
    // 选择报名截止时间
    $('#ActivityList_sign_up_date_end').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ActivityList_sign_up_date\')}'});
    });

    // 选择活动开始时间
    $('#ActivityList_activity_time').on('click', function() {
        var end_input=$dp.$('ActivityList_activity_time_end')
        WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ActivityList_activity_time_end\')}'});
    });
    // 选择活动截止时间
    $('#ActivityList_activity_time_end').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ActivityList_activity_time\')}'});
    });
    
    // $(document).on('click', '.age', function(){
    //     var th=$(this);
    //     WdatePicker({
    //         startDate:'%y-%M-%D',
    //         dateFmt:'yyyy-MM-dd',
    //         onpicked:function(){
    //             th.next('span').html(getAge(th.val())+'周岁');
    //         }
    //     });
    // });
    // 选择最小出生日期
    $(document).on('click', '.min_age', function(){
        var th=$(this);
        var index=$(this).parents('.activity_data').attr('data_index');
        var end_input=$dp.$('max_age'+index+'')
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){th.next('span').html('('+getAge(th.val())+'周岁'+')');end_input.click();},minDate:'#F{$dp.$D(\'max_age'+index+'\')}'});
    });

    // 选择最大出生日期
    $(document).on('click', '.max_age', function(){
        var th=$(this);
        var index=$(this).parents('.activity_data').attr('data_index');
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){th.next('span').html('('+getAge(th.val())+'周岁'+')');},maxDate:'#F{$dp.$D(\'min_age'+index+'\')}'});
    });

    $(document).on('click', '.time', function(){
        var index=$(this).parents('.activity_data').attr('data_index');
        var end_input=$dp.$('time_end'+index+'')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'time_end'+index+'\')}'});
    });
    $(document).on('click', '.time_end', function(){
        var index=$(this).parents('.activity_data').attr('data_index');
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'time'+index+'\')}'});
    });
    function getAge(dateString) {
        //创建系统日期
        var today = new Date();
        //把出生日期转换成日期
        var birthDate = new Date(dateString);
        //分别获取到年份后相减
        var age = today.getFullYear() - birthDate.getFullYear();
        //获取到月份后相减
        var m = today.getMonth() - birthDate.getMonth();
        //如果月份的结果小于0，或者日期相减的结果是小于0，年龄减去1
        if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())){
            age--;
        }
        //计算完成返回结果
        return age;
    }

    // 滚动图片处理
    var $activity_big_pic=$('#ActivityList_activity_big_pic');
    var $upload_pic_ActivityList_activity_big_pic=$('#upload_pic_ActivityList_activity_big_pic');
    var $upload_box_ActivityList_activity_big_pic=$('#upload_box_ActivityList_activity_big_pic');

    // 添加或删除时，更新图片
    var fnUpdatescrollPic=function(){
        var arr1=[];
        $upload_pic_ActivityList_activity_big_pic.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $activity_big_pic.val(we.implode(',',arr1));
        $upload_box_ActivityList_activity_big_pic.show();
        if(arr1.length>=5) {
            $upload_box_ActivityList_activity_big_pic.hide();
        }
        // $("#uploadifive-upload_ActivityList_activity_big_pic-queue").empty();
    };
    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        $upload_pic_ActivityList_activity_big_pic.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
        
        fnUpdatescrollPic();
    };
    
    var $ActivityList_navigatio_address=$('#ActivityList_navigatio_address');
    var $longitude=$('#ActivityList_Longitude');
    var $latitude=$('#ActivityList_latitude');
    var $ActivityList_activity_address=$('#ActivityList_activity_address');
    $ActivityList_navigatio_address.on('click', function(){
        $.dialog.data('maparea_address', '');
        $.dialog.open('<?php echo $this->createUrl("select/mapArea");?>&Longitude='+$longitude.val()+'&latitude='+$latitude.val(),{
            id:'diqu',
            lock:true,
            opacity:0.3,
            title:'选择服务地区',
            width:'907px',
            // height:'65%',
            close: function () {
                if($.dialog.data('maparea_address')!=''){
                    if($ActivityList_activity_address.val()==''){
                        $ActivityList_activity_address.val($.dialog.data('txtarea'));
                    }
                    $longitude.val($.dialog.data('maparea_lng'));
                    $latitude.val($.dialog.data('maparea_lat'));
                    $('#ActivityList_navigatio_address').val($.dialog.data('maparea_address'));
                }
            }
        });
    });
    
    var project_data= <?php echo json_encode($project)?>;
    var check_way= <?php echo json_encode($check_way)?>;
    function add_tag(){
        var num=parseInt($(".activity_data").last().attr('data_index'))+1;
        num=isNaN(num)?0:num;
        var html = 
            '<table class="mt15 activity_data" data_index="'+num+'" style="table-layout:auto;">'+
                '<tr class="table-title">'+
                    '<td colspan="3">活动信息</td>'+
                    '<input class="input-text" name="add_tag['+num+'][data_id]" type="hidden" value="-1">'+
                    '<td style="text-align:right;"><a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a></td>'+
                '</tr>'+
                '<tr>'+
                    '<td>项目</td>'+
                    '<td>'+
                    '<select name="add_tag['+num+'][project_id]" id="project_id_'+num+'">'+
                        '<option value="">请选择</option>';
                        $.each(project_data,function(k,info){
                            html += '<option value="'+info.project_id+'">'+info.project_name+'</option>';
                        })
                        html += '</select>'+
                        '<div class="errorMessage" style="display:none"></div>'+
                    '</td>'+
                    '<td>活动时间 <span class="required">*</span></td>'+
                    '<td>'+
                        '<input style="width:150px" name="add_tag['+num+'][activity_time]" id="time'+num+'" class="input-text time" placeholder="开始时间">'+
                        '-'+
                        '<input style="width:150px" name="add_tag['+num+'][activity_time_end]" id="time_end'+num+'" class="input-text time_end" placeholder="结束时间">'+
                        '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td style="width:10%;">活动内容 <span class="required">*</span></td>'+
                    '<td style="width:40%;">'+
                        '<input name="add_tag['+num+'][activity_content]" class="input-text" id="activity_content_'+num+'">'+
                        '<div class="errorMessage" style="display:none"></div>'+
                    '</td>'+
                    '<td style="width:10%;">可报名人数 <span class="required">*</span></td>'+
                    '<td style="width:40%;">'+
                        '<input name="add_tag['+num+'][apply_number]" class="input-text" id="apply_number_'+num+'" onchange="isRealNum(this)">'+
                        '<div class="errorMessage" style="display:none"></div>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>活动费用（元） <span class="required">*</span></td>'+
                    '<td>'+
                        '<input name="add_tag['+num+'][activity_money]" id="activity_money_'+num+'" class="input-text mony">'+
                        '<div class="errorMessage" style="display:none"></div>'+
                    '</td>'+
                    '<td>报名审核方式 <span class="required">*</span></td>'+
                    '<td>'+
                        '<input id="ActivityListData_apply_check_way_'+num+'" type="hidden" value="" name="add_tag['+num+'][apply_check_way]">';
                        $.each(check_way,function(k,info){
                            html += '<span class="check">';
                            html += '<input class="input-check" id="ActivityListData_apply_check_way_'+info.f_id+'_'+num+'" value="'+info.f_id+'" type="radio" name="add_tag['+num+'][apply_check_way]">';
                            html += '<label for="ActivityListData_apply_check_way_'+info.f_id+'_'+num+'">'+info.F_NAME+'</label>';
                            html += '</span>';
                        })
                        html += '<div class="errorMessage" style="display:none"></div>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td>报名年龄要求 <span class="required">*</span></td>'+
                    '<td colspan="3">'+
                        '<input id="min_age'+num+'" style="width:100px" name="add_tag['+num+'][min_age]" class="input-text min_age" placeholder="最小年龄出生日期" readonly>&nbsp;<span></span>'+
                        '-'+
                        '<input id="max_age'+num+'" style="width:100px" name="add_tag['+num+'][max_age]" class="input-text max_age" placeholder="最大年龄出生日期" readonly>&nbsp;<span></span>'+
                        '<div class="errorMessage" style="display:none"></div>'+
                    '</td>'+
                '</tr>'+
            '</table>';
        num++;
        $('#activity_data').append(html);
    }

    var remove_arr=[];
    function delete_data(obj){
        var removeValue=$(obj).parent().prev().attr("value");
        if(removeValue>0){
            remove_arr.push(removeValue);
        }
        $("#ActivityList_remove_data_ids").val(remove_arr.join(','))
        $(obj).parents('.activity_data').remove();
    }
    function isRealNum(obj){
        // isNaN()函数 把空串 空格 以及NUll 按照0来处理 所以先去除
        val=$(obj).val();
        if(val === "" || val ==null){
            return false;
        }
        if(isNaN(val)){
            $(obj).val('');
            $(obj).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            we.msg('minus','只能输入数字');
        }else if(val<=0){
            $(obj).val('');
            $(obj).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            we.msg('minus','报名人数必须大于0');
        }else{
            $(obj).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    } 

    $(document).on('blur','.mony',function(){
        var c=$(this);
        var reg = /^[0-9]+([.]{1}[0-9]{1,2})?$/;
        if(!reg.test(c.val())){
            var temp_amount=c.val().replace(reg,'');
            we.msg('minus',"\u53ea\u80fd\u586b\u6570\u5b57\uff0c\u4e14\u6700\u591a\u4e24\u4f4d\u5c0f\u6570\u70b9");
            $(this).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            $(this).val(temp_amount.replace(/[^\d\.]/g,''));
        }else{
            $(this).css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
        }
    });

    // $("#cxbj").on("click",function(){
    //     var content='';
    //     content+='<button id="baocun" onclick="submitType='+'baocun'+'" class="btn btn-blue" type="submit">保存</button>&nbsp;';                              
    //     content+='<button id="xiabu" class="btn btn-blue" onclick="submitType='+'xiabu'+'" type="submit">下一步</button>';
    //     content+='<button id="shenhe" onclick="submitType='+'shenhe'+'" class="btn btn-blue" type="submit" style="display:none;"> 提交审核</button>';
    //     content+='<button class="btn" type="button" onclick="we.back();">取消</button>';
    //     $(".sub_box").html(content);
    //     return false;
    // })
    
    var is_click=false;
    $("#genggai").on("click",function(){
        if(!is_click){
            var can1 = function(){
                is_click=true;
                $("#genggai").click();
            }
            $.fallr('show', {
                buttons: {
                    button1: {text: '确定', danger: true, onclick: can1},
                    button2: {text: '取消'}
                },
                content: '是否确定',
                // icon: 'trash',
                afterHide: function() {
                    we.loading('hide');
                }
            });
            return false;
        }
        is_click=false;
    })
</script>