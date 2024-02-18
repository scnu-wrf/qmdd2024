<?php
    if(!empty($model->dispay_start_time=='0000-00-00 00:00:00')){
        $model->dispay_start_time='';
    }
    if(!empty($model->dispay_end_time=='0000-00-00 00:00:00')){
        $model->dispay_end_time='';
    }
    if(!empty($model->train_buy_start=='0000-00-00 00:00:00')){
        $model->train_buy_start='';
    }
    if(!empty($model->train_buy_end=='0000-00-00 00:00:00')){
        $model->train_buy_end='';
    }
    if(!empty($model->train_start=='0000-00-00')){
        $model->train_start='';
    }
    if(!empty($model->train_end=='0000-00-00')){
        $model->train_end='';
    }
    if(!empty($list_data)){
        foreach($list_data as $d){
            if(!empty($d->train_time=='0000-00-00')){
                $d->train_time='';
            }
            if(!empty($d->train_time_end=='0000-00-00')){
                $d->train_time_end='';
            }
            if(!empty($d->min_age=='0000-00-00')){
                $d->min_age='';
            }
            if(!empty($d->max_age=='0000-00-00')){
                $d->max_age='';
            }
        }
    }
    $disabled = !empty($_REQUEST['disabled'])&&$model->train_state!=721 ? 'disabled' : ''; 
    $genggai = !empty($_REQUEST['genggai']) ? true : false;
?>
<?php
    $_REQUEST['train_type1_id']=empty($_REQUEST['train_type1_id'])?$model->train_type1_id:$_REQUEST['train_type1_id'];
    $t_type=ClubStoreType::model()->find('id='.$_REQUEST['train_type1_id']);
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训发布 》发布 》<?php echo (empty($model->id)) ? '添加' : '详情'; ?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list2('baocun')); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>培训介绍</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'train_type1_id'); ?></td>
                        <td width="40%" colspan="3">
                            <?php 
                                echo $form->hiddenField($model, 'train_type1_id',array('value' => $_REQUEST['train_type1_id'])); 
                                echo '<span class="label-box">'.$t_type->type.'</span>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'train_code'); ?></td>
                        <td width="40%"><?php echo $model->train_code; ?></td>
                        <td width="10%;"><?php echo $form->labelEx($model, 'train_clubid'); ?></td>
                        <td width="40%">
                            <?php
                                if(empty($model->id)){
                                    $train_clubid=get_session('club_id');
                                    $train_club_code=get_session('club_code');
                                    $train_clubname=get_session('club_name');
                                }else{
                                    $train_clubid=$model->train_clubid;
                                    $train_club_code=$model->train_club_code;
                                    $train_clubname=$model->train_clubname;
                                }
                                echo $form->hiddenField($model, 'train_clubid', array('class' => 'input-text','value'=>$train_clubid));
                                echo $form->hiddenField($model, 'train_club_code', array('class' => 'input-text','value'=>$train_club_code));
                                echo $form->hiddenField($model, 'train_clubname', array('class' => 'input-text','value'=>$train_clubname));
                                echo '<span id="club_box"><span class="label-box">'.$train_clubname.'</span></span>';
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_title'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'train_title', array('class' => 'input-text','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'train_title', $htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'if_train_live'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'if_train_live', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt' => '请选择','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'if_train_live', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'apply_way'); ?></td>
                        <td>
                            <?php echo $form->radioButtonList($model, 'apply_way', Chtml::listData(BaseCode::model()->getCode(1507), 'f_id', 'F_NAME'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','disabled'=>$disabled));?>
                            <?php echo $form->error($model, 'apply_way', $htmlOptions = array()); ?>
                        </td>
                        <td>
                            <?php echo $form->labelEx($model, 'train_buy_start'); ?>
                            <?php echo $form->labelEx($model, 'train_buy_end', array('style'=>'display:none;')); ?>
                        </td>
                        <td>
                            <?php 
                                if($genggai==1&&$model->train_buy_start<date('Y-m-d H:i:s')){
                                    echo $form->textField($model, 'train_buy_start', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'报名开始时间','disabled'=>'disabled'));
                                }else{
                                    echo $form->textField($model, 'train_buy_start', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'报名开始时间','disabled'=>$disabled));
                                }
                             ?>
                            -
                            <?php 
                                if($genggai==1&&$model->train_buy_end<date('Y-m-d H:i:s')){
                                    echo $form->textField($model, 'train_buy_end', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'报名截止时间','disabled'=>'disabled')); 
                                }else{
                                    echo $form->textField($model, 'train_buy_end', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'报名截止时间','disabled'=>$disabled)); 
                                }
                            ?>
                            <?php echo $form->error($model, 'train_buy_start', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'train_buy_end', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'train_start'); ?>
                            <?php echo $form->labelEx($model, 'train_end', array('style'=>'display:none;')); ?>
                        </td>
                        <td>
                            <?php 
                                if($genggai==1&&$model->train_start<date('Y-m-d H:i:s')){
                                    echo $form->textField($model, 'train_start', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'培训开始时间','disabled'=>'disabled')); 
                                }else{
                                    echo $form->textField($model, 'train_start', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'培训开始时间','disabled'=>$disabled));  
                                }
                            ?>
                            -
                            <?php 
                                echo $form->textField($model, 'train_end', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'培训截止时间','disabled'=>$disabled)); 
                            ?>
                            <?php echo $form->error($model, 'train_start', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'train_end', $htmlOptions = array()); ?>
                        </td>
                        <td>
                            <?php echo $form->labelEx($model, 'dispay_start_time'); ?>
                            <?php echo $form->labelEx($model, 'dispay_end_time', array('style'=>'display:none;')); ?>
                        </td>
                        <td>
                            <?php echo $form->textField($model, 'dispay_start_time', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'显示开始时间','disabled'=>$disabled)); ?>
                            -
                            <?php echo $form->textField($model, 'dispay_end_time', array('class' => 'input-text','style'=>'width:150px;','placeholder'=>'显示截止时间','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'dispay_start_time', $htmlOptions = array()); ?>
                            <?php echo $form->error($model, 'dispay_end_time', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_area'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'train_area', array('class' => 'input-text','disabled'=>$disabled));
                                echo $form->error($model,'train_area',$htmlOption = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'train_address'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textField($model, 'train_address', array('class' => 'input-text','disabled'=>$disabled)); ?>
                            <?php echo $form->hiddenField($model, 'longitude'); ?>
                            <?php echo $form->hiddenField($model, 'latitude'); ?>
                            <?php echo $form->error($model, 'train_address', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_men'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'train_men', array('class' => 'input-text','disabled'=>$disabled)) ;
                                echo $form->error($model, 'train_men', $htmlOptions = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'train_phone'); ?></td>
                        <td>
                            <?php echo $form->textField($model, 'train_phone', array('class' => 'input-text','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'train_phone', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <?php if($t_type->f_id==1504){?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'organizational'); ?></td>
                        <td colspan="3">
                            <?php echo $form->textarea($model,'organizational',array('class'=>'input-text','disabled'=>$disabled)); ?>
                            <?php echo $form->error($model, 'organizational', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <?php }?>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'train_logo'); ?></td>
                        <td id="dpic_train_logo">
                            <?php
                                echo $form->hiddenField($model, 'train_logo', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(133);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->train_logo!=''){
                            ?>
                            <div class="upload_img fl" id="upload_pic_ClubStoreTrain_train_logo">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->train_logo;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->train_logo;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                            <?php if($disabled==''){ ?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_train_logo','<?php echo $picprefix;?>');</script>
                            <?php }?>
                            <?php echo $form->error($model, 'train_logo', $htmlOptions = array()); ?>
                        </td>

                        <td><?php echo $form->labelEx($model, 'train_pic'); ?></td>
                        <td>
                            <?php echo $form->hiddenField($model, 'train_pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_ClubStoreTrain_train_pic">
                                <?php 
                                    $basepath=BasePath::model()->getPath(223);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                    if(!empty($train_pic))foreach($train_pic as $v) {
                                ?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                                    <?php if($disabled==''){ ?>
                                        <i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i>
                                    <?php }?>
                                </a>
                                <?php }?>
                            </div>
                            <?php if($disabled==''){ ?>
                                <script>we.uploadpic('<?php echo get_class($model);?>_train_pic','<?php echo $picprefix;?>','','',function(e1,e2){fnscrollPic(e1.savename,e1.allpath);});</script>
                            <?php }?>
                            <?php echo $form->error($model, 'train_pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <div class="mt15" id="train_data">
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
                    <table class="mt15 train_data" data_index="<?= $num;?>" style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="3">培训信息</td>
                            <input class="input-text" name="add_tag[<?= $num;?>][data_id]" type="hidden" value="<?= $d->id?>" <?= $disabled!=''?'disabled':'';?>>
                            <td>
                                <?php if($disabled==''){?>
                                    <a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>
                                <?php }?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width:10%;">类别 <span class="required">*</span></td>
                            <td style="width:40%;">
                                <select name="add_tag[<?= $num;?>][type_id]" id="type_id_<?= $num;?>" <?= $disabled!=''?'disabled':'';?>>
                                    <option value="">请选择</option>
                                    <?php 
                                        $text='';
                                        if(isset($train_type))foreach($train_type as $j){
                                            $text.='<option value="'.$j['id'].'" ';
                                            if($j['id']==$d->type_id){
                                                $text.='selected';
                                            }
                                            $text.='>'.$j['classify'].'</option>';
                                        }
                                        echo $text;
                                    ?>
                                </select>
                                <div class="errorMessage" style="display:none"></div>
                            </td>
                            <td style="width:10%;">项目</td>
                            <td style="width:40%;">
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
                        </tr>
                        <tr>
                            <td>培训内容 <span class="required">*</span></td>
                            <td><input name="add_tag[<?= $num;?>][train_content]" id="train_content_<?= $num;?>" class="input-text" value="<?= $d->train_content;?>" <?= $disabled!=''?'disabled':'';?>><div class="errorMessage" style="display:none"></div></td>
                            <td>可报名人数 <span class="required">*</span></td>
                            <td><input name="add_tag[<?= $num;?>][apply_number]" id="apply_number_<?= $num;?>" class="input-text" value="<?= $d->apply_number;?>" <?= $disabled!=''?'disabled':'';?> onchange="isRealNum(this)"><div class="errorMessage" style="display:none"></div></td>
                        </tr>
                        <tr>
                            <td>培训费用（元） <span class="required">*</span></td>
                            <td><input name="add_tag[<?= $num;?>][train_money]" id="train_money_<?= $num;?>" class="input-text mony" value="<?= $d->train_money;?>" <?= $disabled!=''?'disabled':'';?>><div class="errorMessage" style="display:none"></div></td>
                            <td><?php echo $t_type->f_id==1504?'报名审核方式':'培训周期' ?> <span class="required">*</span></td>
                            <td>
                                <?php if($t_type->f_id==1504){?>
                                    <input id="ClubTrainData_apply_check_way_<?= $num;?>" type="hidden" value="" <?= $disabled!=''?'disabled':'';?> name="add_tag[<?= $num;?>][apply_check_way]">
                                    <?php 
                                        $text1='';
                                        if(isset($check_way))foreach($check_way as $y){
                                            $text1.='<span class="check">';
                                            $text1.='<input class="input-check" id="ClubTrainData_apply_check_way_'.$y['f_id'].'_'.$num.'" value="'.$y['f_id'].'" type="radio" name="add_tag['.$num.'][apply_check_way]" ';
                                            if($disabled!=''){
                                                $text1.='disabled ';
                                            }
                                            if($y['f_id']==$d->apply_check_way){
                                                $text1.='checked';
                                            }
                                            $text1.='>';
                                            $text1.='<label for="ClubTrainData_apply_check_way_'.$y['f_id'].'_'.$num.'">'.$y['F_NAME'].'</label>';
                                            $text1.='</span>';
                                        }
                                        echo $text1;
                                    ?>
                                <?php }else{?>
                                    <input id="ClubTrainData_apply_check_way_<?= $num;?>" type="hidden" value="793" name="add_tag[<?= $num;?>][apply_check_way]" <?= $disabled!=''?'disabled':'';?>>
                                    <input name="add_tag[<?= $num;?>][period]" id="period_<?= $num?>" class="input-text" value="<?= $d->period;?>" <?= $disabled!=''?'disabled':'';?>>
                                <?php }?>
                                <div class="errorMessage" style="display:none"></div>
                            </td>
                        </tr>
                        <tr>
                            <?php if($t_type->f_id==1504){?>
                                <td>培训时间 <span class="required">*</span></td>
                                <td>
                                    <input style="width:150px" name="add_tag[<?= $num;?>][train_time]" id="time<?= $num;?>" class="input-text time" value="<?= $d->train_time;?>" placeholder='开始时间' <?= $disabled!=''?'disabled':'';?>>
                                    -
                                    <input style="width:150px" name="add_tag[<?= $num;?>][train_time_end]" id="time_end<?= $num;?>" class="input-text time_end" value="<?= $d->train_time_end;?>" placeholder='结束时间' <?= $disabled!=''?'disabled':'';?>>
                                    <div class="errorMessage" id="time<?= $num;?>_em_" style="display:none"></div>
                                </td>
                            <?php }?>
                            <td>报名年龄要求</td>
                            <td <?php echo $t_type->f_id!=1504?'colspan="3"':'' ?>>
                                <input style="width:100px" id="min_age<?= $num;?>" name="add_tag[<?= $num;?>][min_age]" class="input-text min_age" value="<?= $d->min_age;?>" placeholder='最小年龄出生日期' <?= $disabled!=''?'disabled':'';?> readonly>&nbsp;<span><?php echo '('.$model->getAge(strtotime($d->min_age)).'周岁)';?></span>
                                -
                                <input style="width:100px" id="max_age0" name="add_tag[<?= $num;?>][max_age]" class="input-text max_age" value="<?= $d->max_age;?>" placeholder='最大年龄出生日期' <?= $disabled!=''?'disabled':'';?> readonly>&nbsp;<span><?php echo '('.$model->getAge(strtotime($d->max_age)).'周岁)';?></span>
                                <div class="errorMessage" style="display:none"></div>
                            </td>
                        </tr>
                        <?php if($t_type->f_id==1504){?>
                            <tr>
                                <td >报名资质要求</td>
                                <td colspan="3">
                                    <select id="train_identity_type<?= $num;?>" name="add_tag[<?= $num;?>][train_identity_type]" onchange="get_rank(this)" <?= $disabled!=''?'disabled':'';?>>
                                        <option value="">请选择</option>
                                        <?php 
                                            $text='';
                                            if(isset($store_rank))foreach($store_rank as $j){
                                                $text.='<option value="'.$j['id'].'" ';
                                                if($j['id']==$d->train_identity_type){
                                                    $text.='selected';
                                                }
                                                $text.='>'.$j['type_name'].'</option>';
                                            }
                                            echo $text;
                                        ?>
                                    </select>
                                    <select id="train_identity_rank<?= $num;?>" name="add_tag[<?= $num;?>][train_identity_rank]" <?= $disabled!=''?'disabled':'';?>>
                                        <option value="">请选择</option>
                                        <?php 
                                            $text='';
                                            if(!empty($d->train_identity_type)){
                                                $rank_arr=ClubStoreRank::model()->getFater($d->train_identity_type);
                                            }
                                            if(isset($rank_arr))foreach($rank_arr as $r){
                                                $text.='<option value="'.$r['id'].'" ';
                                                if($r['id']==$d->train_identity_rank){
                                                    $text.='selected';
                                                }
                                                $text.='>'.$r['rank_name'].'</option>';
                                            }
                                            echo $text;
                                        ?>
                                    </select>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                        <?php }?>
                    </table>
                    <?php $num++;}}else{?>
                        <table class="mt15 train_data" data_index="0" style="table-layout:auto;">
                            <tr class="table-title">
                                <td width="10%;" colspan="3">培训信息</td>
                                <input class="input-text" name="add_tag[0][data_id]" type="hidden" value="-1">
                                <td width="40%;">
                                    <a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:10%;">类别 <span class="required">*</span></td>
                                <td style="width:40%;">
                                    <select name="add_tag[0][type_id]" id="type_id_0">
                                        <option value="">请选择</option>
                                        <?php 
                                            $text='';
                                            if(isset($train_type))foreach($train_type as $j){
                                                $text.='<option value="'.$j['id'].'" >'.$j['classify'].'</option>';
                                            }
                                            echo $text;
                                        ?>
                                    </select>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
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
                            </tr>
                            <tr>
                                <td>培训内容 <span class="required">*</span></td>
                                <td><input name="add_tag[0][train_content]" id="train_content_0" class="input-text" ><div class="errorMessage" style="display:none"></div></td>
                                <td>可报名人数 <span class="required">*</span></td>
                                <td><input name="add_tag[0][apply_number]" id="apply_number_0" class="input-text" onchange="isRealNum(this)"><div class="errorMessage" style="display:none"></div></td>
                            </tr>
                            <tr>
                                <td>培训费用（元） <span class="required">*</span></td>
                                <td><input name="add_tag[0][train_money]" id="train_money_0" class="input-text mony" ><div class="errorMessage" style="display:none"></div></td>
                                <td><?php echo $t_type->f_id==1504?'报名审核方式':'培训周期' ?> <span class="required">*</span></td>
                                <td>
                                    <?php if($t_type->f_id==1504){?>
                                        <input id="ClubTrainData_apply_check_way_0" type="hidden" value="" name="add_tag[0][apply_check_way]">
                                        <?php 
                                            $text1='';
                                            if(isset($check_way))foreach($check_way as $y){
                                                $text1.='<span class="check">';
                                                $text1.='<input class="input-check" id="ClubTrainData_apply_check_way_'.$y['f_id'].'_0" value="'.$y['f_id'].'" type="radio" name="add_tag[0][apply_check_way]" >';
                                                $text1.='<label for="ClubTrainData_apply_check_way_'.$y['f_id'].'_0">'.$y['F_NAME'].'</label>';
                                                $text1.='</span>';
                                            }
                                            echo $text1;
                                        ?>
                                    <?php }else{?>
                                        <input id="ClubTrainData_apply_check_way_0" type="hidden" value="793" name="add_tag[0][apply_check_way]">
                                        <input name="add_tag[0][period]" id="period_0" class="input-text" >
                                    <?php }?>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                            <tr>
                                <?php if($t_type->f_id==1504){?>
                                    <td>培训时间 <span class="required">*</span></td>
                                    <td>
                                        <input style="width:150px" name="add_tag[0][train_time]" id="time0" class="input-text time" placeholder='开始时间' >
                                        -
                                        <input style="width:150px" name="add_tag[0][train_time_end]" id="time_end0" class="input-text time_end" placeholder='结束时间' >
                                        <div class="errorMessage" id="time0_em_" style="display:none"></div>
                                    </td>
                                <?php }?>
                                <td>报名年龄要求 <span class="required">*</span></td>
                                <td <?php echo $t_type->f_id!=1504?'colspan="3"':'' ?>>
                                    <input style="width:100px" id="min_age0" name="add_tag[0][min_age]" class="input-text min_age" placeholder='最小年龄出生日期' readonly>&nbsp;<span></span>
                                    -
                                    <input style="width:100px" id="max_age0" name="add_tag[0][max_age]" class="input-text max_age" placeholder='最大年龄出生日期' readonly>&nbsp;<span></span>
                                    <div class="errorMessage" style="display:none"></div>
                                </td>
                            </tr>
                            <?php if($t_type->f_id==1504){?>
                                <tr>
                                    <td >报名资质要求 </td>
                                    <td colspan="3">
                                        <select id="train_identity_type0" name="add_tag[0][train_identity_type]" onchange="get_rank(this)">
                                            <option value="">请选择</option>
                                            <?php 
                                                $text='';
                                                if(isset($store_rank))foreach($store_rank as $j){
                                                    $text.='<option value="'.$j['id'].'" >'.$j['type_name'].'</option>';
                                                }
                                                echo $text;
                                            ?>
                                        </select>
                                        <select id="train_identity_rank0" name="add_tag[0][train_identity_rank]">
                                            <option value="">请选择</option>
                                        </select>
                                        <div class="errorMessage" style="display:none"></div>
                                    </td>
                                </tr>
                            <?php }?>
                        </table>
                    <?php }?>
                </div>
                <?php echo $form->hiddenField($model, 'remove_data_ids');?>
            </div><!--box-detail-tab-item end-->

            <div style="display:none;" class="box-detail-tab-item">
                <!--培训描述开始-->
                <?php echo $form->hiddenField($model, 'train_description_temp', array('class' => 'input-text')); ?>
                <script>
                    we.editor('<?php echo get_class($model); ?>_train_description_temp', '<?php echo get_class($model); ?>[train_description_temp]');
                </script>
                <?php echo $form->error($model, 'train_description_temp', $htmlOptions = array()); ?>

            </div><!--box-detail-tab-item end-->
            <table class="mt15">
                <tr>
                    <?php if($model->train_state!=721){?>
                        <tr>
                            <td width='10%'>审核状态</td>
                            <td width='40%'>
                                <?php echo $model->train_state_name; ?>
                            </td>
                            <td width='10%'><?php echo $form->labelEx($model, 'reasons_for_failure'); ?></td>
                            <td width='40%'>
                                <?php echo $form->textArea($model, 'reasons_for_failure', array('class' => 'input-text' ,'disabled'=>$model->train_state==371?false:true)); ?>
                                <?php echo $form->error($model, 'reasons_for_failure', $htmlOptions = array()); ?>
                            </td>
                        </tr>
                    <?php }?>
                    <td width="10%;">可执行操作</td>
                    <td colspan="3" class="sub_box">
                        <?php if($genggai==1){?>
                            <button id="genggai" onclick="submitType='genggai'" class="btn btn-blue" type="submit">保存更改</button>
                        <?php }else{?>
                            <?php if($model->train_state==721){?>
                                <?php echo show_shenhe_box(array('baocun'=>'保存'));?>
                                <button id="xiabu" class="btn btn-blue" onclick="submitType='xiabu'" type="submit" >下一步</button>
                                <button id="shenhe" onclick="submitType='shenhe'" class="btn btn-blue" type="submit" style="display:none;"> 提交审核</button>
                            <?php }elseif($model->train_state==371){?>
                                <?php if(!empty($_REQUEST['index'])&&$_REQUEST['index']=='submit'){?>
                                    <button id="quxiao" onclick="submitType='quxiao'" class="btn btn-blue" type="submit">撤销</button>
                                <?php }else{?>
                                    <?php echo show_shenhe_box(array('tongguo'=>'审核通过','butongguo'=>'审核不通过')); ?>
                                <?php }?>
                            <?php }elseif($model->train_state==373){?>
                                <button id="cxbj" onclick="submitType='cxbj'" class="btn btn-blue" type="submit" >重新编辑</button>
                            <?php }else{?>
                                <?php echo $model->train_state_name; ?>
                            <?php }?>
                        <?php }?>
                        <button class="btn" type="button" onclick="we.back();">取消</button>
                    </td>
                </tr>
            </table>
        </div><!--box-detail-bd end-->
    </div>
    <?php $this->endWidget(); ?>
</div>
<!--box-table end-->
</div>
<!--box-content end-->

<?php
function get_form_list2($submit='=='){
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    $(".time").each(function(){
                        var attr_id=$(this).attr("id");
                        var th=$(this);
                        if($(this).val()<$("#ClubStoreTrain_train_start").val()){
                            hasError=true;
                            data.attr_id=["培训时间必须在培训开始与截止时间范围内"];
                            th.parent().find(".errorMessage").html("培训时间必须在培训开始与截止时间范围内").show();
                        }
                    })
                    $(".time_end").each(function(){
                        var attr_id=$(this).attr("id");
                        var th=$(this);
                        if($(this).val()>$("#ClubStoreTrain_train_end").val()){
                            hasError=true;
                            data.attr_id=["培训时间必须在培训开始与截止时间范围内"];
                            th.parent().find(".errorMessage").html("培训时间必须在培训开始与截止时间范围内").show();
                        }
                    })
                    $(".train_data").each(function(){
                        var tl=$(this);
                        $(this).find("input").each(function(){
                            var th=$(this);
                            if(th.is(":visible")){
                                var attr_id=th.attr("id");
                                attr_id = attr_id.substring(0, attr_id.length - tl.attr("data_index").length);
                                if(th.val()==""){
                                    console.log(th.val())
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
                        var radio792=$("#ClubTrainData_apply_check_way_792_"+tl.attr("data_index")+":checked").val();
                        var radio793=$("#ClubTrainData_apply_check_way_793_"+tl.attr("data_index")+":checked").val();
                        if(base_type==1504){
                            if(!radio792&&!radio793){
                                hasError=true;
                                var text=$("#ClubTrainData_apply_check_way_"+tl.attr("data_index")).parents("td").prev().text();
                                text=text.substring(0,text.length-1);
                                data["ClubTrainData_apply_check_way_"]=[text+"不能为空"];
                                $("#ClubTrainData_apply_check_way_"+tl.attr("data_index")).parents("td").find(".errorMessage").html(text+"不能为空").show();
                            }else{
                                $("#ClubTrainData_apply_check_way_"+tl.attr("data_index")).parents("td").find(".errorMessage").html("").hide();
                            }
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
    $(function() {
        if($("#upload_pic_ClubStoreTrain_train_pic .picbox").length>=5){
            $("#upload_box_ClubStoreTrain_train_pic").hide();
        }
        var sType='';
        var disabled= <?php echo json_encode($disabled)?>;
        if(disabled!=''){
            setTimeout(function(){ UE.getEditor('editor_ClubStoreTrain_train_description_temp').setDisabled('fullscreen'); }, 500);
        }
    })

    //从图库选择图片
    var $Single = $('#ClubStoreTrain_train_logo');
    $('#picture_select_btn').on('click', function() {
        var club_id = $('#ClubStoreTrain_train_clubid').val();
        $.dialog.data('app_icon', 0);
        $.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type' => 252, 'fd' => 49)); ?>&club_id=' + club_id, {
            id: 'picture',
            lock: true,
            opacity: 0.3,
            title: '请选择素材',
            width: '100%',
            height: '90%',
            close: function() {
                if ($.dialog.data('material_id') > 0) {
                    $Single.val($.dialog.data('app_icon')).trigger('blur');

                    $('#upload_pic_ClubStoreTrain_train_logo').html('<a href="<?php echo $basepath->F_WWWPATH; ?>' + art.dialog.data('app_icon') +
                        '" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH; ?>' + art.dialog.data('app_icon') +
                        '"  width="100"></a>');
                }

            }
        });
    });

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
    $('#ClubStoreTrain_dispay_start_time').on('click', function() {
        var end_input=$dp.$('ClubStoreTrain_dispay_end_time')
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ClubStoreTrain_dispay_end_time\')}'});
    });
    // 选择显示截止时间
    $('#ClubStoreTrain_dispay_end_time').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ClubStoreTrain_dispay_start_time\')}'});
    });

    // 选择报名开始时间
    $('#ClubStoreTrain_train_buy_start').on('click', function() {
        var end_input=$dp.$('ClubStoreTrain_train_buy_end')
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ClubStoreTrain_train_buy_end\')}'});
    });
    // 选择报名截止时间
    $('#ClubStoreTrain_train_buy_end').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D 00:00:00 ',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ClubStoreTrain_train_buy_start\')}'});
    });

    // 选择培训开始时间
    $('#ClubStoreTrain_train_start').on('click', function() {
        var end_input=$dp.$('ClubStoreTrain_train_end')
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'ClubStoreTrain_train_end\')}'});
    });
    // 选择培训截止时间
    $('#ClubStoreTrain_train_end').on('click', function() {
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'ClubStoreTrain_train_start\')}'});
    });

    // 选择最小出生日期
    $(document).on('click', '.min_age', function(){
        var th=$(this);
        var index=$(this).parents('.train_data').attr('data_index');
        var end_input=$dp.$('max_age'+index+'')
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){th.next('span').html('('+getAge(th.val())+'周岁'+')');end_input.click();},minDate:'#F{$dp.$D(\'max_age'+index+'\')}'});
    });

    // 选择最大出生日期
    $(document).on('click', '.max_age', function(){
        var th=$(this);
        var index=$(this).parents('.train_data').attr('data_index');
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){th.next('span').html('('+getAge(th.val())+'周岁'+')');},maxDate:'#F{$dp.$D(\'min_age'+index+'\')}'});
    });

    // 选择培训内容开始时间
    $(document).on('click', '.time', function(){
        var index=$(this).parents('.train_data').attr('data_index');
        var end_input=$dp.$('time_end'+index+'')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'time_end'+index+'\')}'});
    });
    // 选择培训内容结束时间
    $(document).on('click', '.time_end', function(){
        var index=$(this).parents('.train_data').attr('data_index');
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
    var $train_pic=$('#ClubStoreTrain_train_pic');
    var $upload_pic_ClubStoreTrain_train_pic=$('#upload_pic_ClubStoreTrain_train_pic');
    var $upload_box_ClubStoreTrain_train_pic=$('#upload_box_ClubStoreTrain_train_pic');

    // 添加或删除时，更新图片
    var fnUpdatescrollPic=function(){
        var arr1=[];
        $upload_pic_ClubStoreTrain_train_pic.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $train_pic.val(we.implode(',',arr1));
        $upload_box_ClubStoreTrain_train_pic.show();
        if(arr1.length>=5) {
            $upload_box_ClubStoreTrain_train_pic.hide();
        }
    };
    // 上传完成时图片处理
    var fnscrollPic=function(savename,allpath){
        $upload_pic_ClubStoreTrain_train_pic.append('<a class="picbox" data-savepath="'+
        savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
        fnUpdatescrollPic();
    };


    // 选择服务地区
    var $ClubStoreTrain_train_address = $('#ClubStoreTrain_train_address');
    var $ClubStoreTrain_longitude = $('#ClubStoreTrain_longitude');
    var $ClubStoreTrain_latitude = $('#ClubStoreTrain_latitude');
    $ClubStoreTrain_train_address.on('click', function() {
        $.dialog.data('maparea_address', '');
        $.dialog.open('<?php echo $this->createUrl("select/mapArea"); ?>', {
            id: 'diqu',
            lock: true,
            opacity: 0.3,
            title: '选择服务地区',
            width: '907px',
            // height: '504px',
            close: function() {
                ;
                if ($.dialog.data('maparea_address') != '') {
                    console.log($.dialog.data('maparea_lng'))
                    $ClubStoreTrain_train_address.val($.dialog.data('maparea_address'));
                    $ClubStoreTrain_longitude.val($.dialog.data('maparea_lng'));
                    $ClubStoreTrain_latitude.val($.dialog.data('maparea_lat'));
                }
            }
        });
    });

    var train_type= <?php echo json_encode($train_type)?>;
    var store_rank= <?php echo json_encode($store_rank)?>;
    var project_data= <?php echo json_encode($project)?>;
    var check_way= <?php echo json_encode($check_way)?>;
    var base_type= <?php echo json_encode($t_type->f_id)?>;
    function add_tag(){
        var num=parseInt($(".train_data").last().attr('data_index'))+1;
        num=isNaN(num)?0:num;
        var html = 
            '<table class="mt15 train_data" data_index="'+num+'" style="table-layout:auto;">'+
                '<tr class="table-title">'+
                    '<td colspan="3">培训信息</td>'+
                    '<input class="input-text" name="add_tag['+num+'][data_id]" type="hidden" value="-1">'+
                    '<td><a class="btn" href="javascript:;" type="button" title="删除" onclick="delete_data(this);">删除</a></td>'+
                '</tr>'+
                '<tr>'+
                    '<td>类别 <span class="required">*</span></td>'+
                    '<td>'+
                    '<select name="add_tag['+num+'][type_id]" id="type_id_'+num+'">'+
                        '<option value="">请选择</option>';
                        $.each(train_type,function(k,info){
                            html += '<option value="'+info.id+'">'+info.classify+'</option>';
                        })
                        html += '</select>'+
                        '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                    '</td>'+
                    '<td>项目</td>'+
                    '<td>'+
                    '<select name="add_tag['+num+'][project_id]" id="project_id_'+num+'">'+
                        '<option value="">请选择</option>';
                        $.each(project_data,function(k,info){
                            html += '<option value="'+info.project_id+'">'+info.project_name+'</option>';
                        })
                        html += '</select>'+
                        '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                    '</td>'+
                '</tr>'+
                '<tr>'+
                    '<td style="width:10%;">培训内容 <span class="required">*</span></td>'+
                    '<td style="width:40%;"><input name="add_tag['+num+'][train_content]" id="train_content_'+num+'" class="input-text"><div class="errorMessage" id="time'+num+'_em_" style="display:none"></div></td>'+
                    '<td style="width:10%;">可报名人数 <span class="required">*</span></td>'+
                    '<td style="width:40%;"><input name="add_tag['+num+'][apply_number]" id="apply_number_'+num+'" class="input-text" onchange="isRealNum(this)"><div class="errorMessage" id="time'+num+'_em_" style="display:none"></div></td>'+
                '</tr>'+
                '<tr>'+
                    '<td>培训费用（元） <span class="required">*</span></td>'+
                    '<td><input name="add_tag['+num+'][train_money]" id="train_money_'+num+'" class="input-text mony"><div class="errorMessage" id="time'+num+'_em_" style="display:none"></div></td>'+
                    '<td>'+(base_type==1504?'报名审核方式':'培训周期')+' <span class="required">*</span></td>'+
                    '<td>';
                        if(base_type==1504){
                            html += '<input id="ClubTrainData_apply_check_way_'+num+'" type="hidden" value="" name="add_tag['+num+'][apply_check_way]">';
                            $.each(check_way,function(k,info){
                                html += '<span class="check">';
                                html += '<input class="input-check" id="ClubTrainData_apply_check_way_'+info.f_id+'_'+num+'" value="'+info.f_id+'" type="radio" name="add_tag['+num+'][apply_check_way]">';
                                html += '<label for="ClubTrainData_apply_check_way_'+info.f_id+'_'+num+'">'+info.F_NAME+'</label>';
                                html += '</span>';
                            })
                        }else{
                            html += '<input id="ClubTrainData_apply_check_way_'+num+'" type="hidden" value="793" name="add_tag['+num+'][apply_check_way]">';
                            html += '<input name="add_tag['+num+'][period]" id="period_'+num+'" class="input-text">';
                        }
                    html += '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                    '</td>'+
                '</tr>'+
                '<tr>';
                    if(base_type==1504){
                        html += '<td>培训时间 <span class="required">*</span></td>'+
                        '<td>'+
                            '<input style="width:150px" name="add_tag['+num+'][train_time]" id="time'+num+'" class="input-text time" placeholder="开始时间">'+
                            '-'+
                            '<input style="width:150px" name="add_tag['+num+'][train_time_end]" id="time_end'+num+'" class="input-text time_end" placeholder="结束时间">'+
                            '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                            '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                        '</td>';
                    }
                    html += '<td>报名年龄要求 <span class="required">*</span></td>'+
                    '<td '+(base_type!=1504?'colspan="3"':'')+'>'+
                        '<input id="min_age'+num+'" style="width:100px" name="add_tag['+num+'][min_age]" class="input-text min_age" placeholder="最小年龄出生日期" readonly>&nbsp;<span></span>'+
                        '-'+
                        '<input id="max_age'+num+'" style="width:100px" name="add_tag['+num+'][max_age]" class="input-text max_age" placeholder="最大年龄出生日期" readonly>&nbsp;<span></span>'+
                        '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                    '</td>'+
                '</tr>';
                
                if(base_type==1504){
                    html += '<tr>'+
                        '<td>报名资质要求 </td>'+
                        '<td colspan="3">'+
                            '<select name="add_tag['+num+'][train_identity_type]" onchange="get_rank(this)">'+
                                '<option value="">请选择</option>';
                                $.each(store_rank,function(k,info){
                                    html += '<option value="'+info.id+'">'+info.type_name+'</option>';
                                })
                            html += '</select>'+
                            '<select id="train_identity_rank'+num+'" name="add_tag['+num+'][train_identity_rank]">'+
                                '<option value="">请选择</option>'+
                            '</select>'+
                            '<div class="errorMessage" id="time'+num+'_em_" style="display:none"></div>'+
                        '</td>'+
                    '</tr>';
                }
            html += '</table>';
        num++;
        $('#train_data').append(html);
    }

    var remove_arr=[];
    function delete_data(obj){
        var removeValue=$(obj).parent().prev().attr("value");
        if(removeValue>0){
            remove_arr.push(removeValue);
        }
        $("#ClubStoreTrain_remove_data_ids").val(remove_arr.join(','))
        $(obj).parents('.train_data').remove();
    }
    function isRealNum(obj){
        // isNaN()函数 把空串 空格 以及NUll 按照0来处理 所以先去除
        val=$(obj).val();
        if(val === "" || val ==null){
            return false;
        }
        if(isNaN(val)){
            $(obj).val('');
            $(obj).css({'border-color':'#f00','box-shadow':'0px 0px 3px #f00;'});
            we.msg('minus','只能输入数字');
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

    function get_rank(obj){
        var show_id = $(obj).val();
        var data_index=$(obj).parents('.train_data').attr('data_index');
        var content='<option value="">请选择</option>';
        $("#train_identity_rank"+data_index+"").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getRank'); ?>&id='+show_id,
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" >'+info.rank_name+'</option>'
                })
                $("#train_identity_rank"+data_index+"").html(content);
            }
        });
    }
    
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