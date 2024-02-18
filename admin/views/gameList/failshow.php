<?php
   check_request('type',0);
   check_post('data_id',0);
   check_post('data_type',0);

    if(!empty($model->id)) {
        $gamedata=GameListData::model()->count('game_id='.$model->id);
    }
    $sh = $model->state;
    $disabled = ($sh==721 || $sh==373) ? '' : 'disabled';
    $arr=BaseCode::model()->getCode_id2();
?>
<script> // html5中默认的script是javascript,故不需要特别指定script language 
    var $d_club_type2= <?php echo json_encode($arr)?>;
</script>
<div class="box">
    <div id="t0" class="box-title c">
        <h1><i class="fa fa-table"></i></i><?php if($model->id=='') {?>基本信息<?php }else{?><?php echo $model->game_title.' /基本信息'; }?></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gameList/faillist');?>');"><i class="fa fa-reply"></i>返回审核未过列表</a></span>
    </div><!--box-title end-->
    <div class="box-detail" style="padding-top:15px;">
     <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <?php if($model->id!=''){?>
            <div class="box-detail-tab">
                <ul class="c">
                    <?php $action=Yii::app()->controller->getAction()->id;?>
                    <li class="current">基本信息</a></li>
                    <li><a href="<?php echo $this->createUrl('gameListData/index',array('game_id'=>$model->id,'title'=>$model->game_title,'type'=>$model->game_type));?>">竞赛项目</a></li>
                    <li><a href="<?php echo $this->createUrl('gameIntroduction/index',array('game_id'=>$model->id,'title'=>$model->game_title,'type'=>$model->game_type));?>">竞赛规程</a></li>
                </ul>
            </div><!--box-detail-tab end-->
        <?php }?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table id="t1" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_code'); ?></td>
                        <td colspan="3"><?php echo $model->game_code; ?></td>
                    </tr>
                    <tr>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_title'); ?></td>
                        <td width="38%">
                            <?php
                                echo  $model->game_title.$form->hiddenField($model,'game_title');
                            ?>
                        </td>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_club_id'); ?></td>
                        <td>
                            <span id="club_box">
                            <span>
                                <?php echo $model->game_club_name;?>
                                <?php echo $form->hiddenField($model, 'game_club_id', array('class' => 'input-text')); ?>
                            </span>
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_level'); ?></td>
                        <td><?php echo $model->base_game_type->F_NAME.'&nbsp;&nbsp;&nbsp;'.$model->level_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_area'); ?></td>
                        <td><?php echo $model->area_name; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'local_men'); ?></td>
                        <td><?php echo $model->local_men.$form->hiddenField($model,'local_men');?></td>
                        <td><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                        <td><?php echo $model->local_and_phone.$form->hiddenField($model,'local_and_phone'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_address'); ?></td>
                        <td><?php echo $model->game_address.$form->hiddenField($model,'game_address'); ?></td>
                        <td><?php echo $form->labelEx($model,'navigatio_address'); ?></td>
                        <td>
                            <?php
                                echo $model->navigatio_address.$form->hiddenField($model,'navigatio_address');
                                echo $form->hiddenField($model, 'Longitude');
                                echo $form->hiddenField($model, 'latitude');
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_small_pic'); ?></td>
                        <td colspan="3" id="dpic_game_small_pic">
                            <?php
                                echo $form->hiddenField($model, 'game_small_pic', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(118);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->game_small_pic!=''){
                            ?>
                                <div class="upload_img fl" id="upload_pic_GameList_game_small_pic">
                                    <a href="<?php echo $basepath->F_WWWPATH.$model->game_small_pic;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->game_small_pic;?>" width="100">
                                    </a>
                                </div>
                            <?php }?>
                            
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <?php echo $form->labelEx($model, 'game_big_pic'); ?>
                        </td>
                        <td colspan="3">
                            <?php echo $form->hiddenField($model, 'game_big_pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_GameList_game_big_pic">
                                <?php 
                                    $basepath=BasePath::model()->getPath(207);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                    if(!empty($game_big_pic))foreach($game_big_pic as $v) { 
                                ?>
                                    <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                                    </a>
                                <?php }?>
                            </div>
                           
                        </td>
                    </tr>
                    <tr id="web_top" style="display:none;">
                        <td width="12%"><?php echo $form->labelEx($model, 'game_web_top'); ?></td>
                        <td width="38%">
                            <?php echo $form->hiddenField($model, 'game_web_top', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_GameList_game_web_top">
                                <?php 
                                    $basepath=BasePath::model()->getPath(206);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                ?>
                                <?php if($model->game_web_top!=''){?>
                                    <a class="picbox" data-savepath="<?php echo $model->game_web_top;?>" href="<?php echo $basepath->F_WWWPATH.$model->game_web_top;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->game_web_top;?>" width="100">
                                    </a>
                                <?php }?>
                            </div>
                           
                        </td>
                        <td width="12%"><?php echo $form->labelEx($model, 'game_web_bg'); ?></td>
                        <td width="38%">
                            <?php echo $form->hiddenField($model, 'game_web_bg', array('class' => 'input-text fl')); ?>
                            <div class="upload_img fl" id="upload_pic_GameList_game_web_bg">
                                <?php 
                                    $basepath=BasePath::model()->getPath(205);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                ?>
                                <?php if($model->game_web_bg!=''){?>
                                    <a class="picbox" data-savepath="<?php echo $model->game_web_bg;?>" href="<?php echo $basepath->F_WWWPATH.$model->game_web_bg;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->game_web_bg;?>" width="100">
                                        <i onclick="$(this).parent().remove();fnGamewebbg();return false;"></i>
                                    </a>
                                <?php }?>
                            </div>
                        
                        </td>
                    </tr>
                    <tr id="web_bg" style="display:none;">
                        <td><?php echo $form->labelEx($model, 'game_web_top_color'); ?></td>
                        <td>
                            <?php echo $form->colorField($model, 'game_web_top_color', array('type'=>'color ')); ?><br>
                            <span class="msg">注：如果选择背景图片，那么背景颜色不会显示</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_web_bg_color'); ?></td>
                        <td>
                            <?php echo $form->colorField($model, 'game_web_bg_color', array('type'=>'color ')); ?><br>
                            <span class="msg">注：如果选择背景图片，那么背景颜色不会显示</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                    </tr>
                </table>
                <table id="t2" class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">赛事设置</td>
                    </tr>
                    <tr>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_apply_way_referee'); ?></td>
                        <td width="38%"><?php echo $model->base_apply_way->F_NAME; ?></td>
                        <td width="12%;"><?php echo $form->labelEx($model, 'game_check_way'); ?></td>
                        <td width="38%"><?php echo $model->base_check_way->F_NAME; ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'if_game_live'); ?></td>
                        <td>
                            <?php echo $model->base_game_live->F_NAME; ?>
                            <br><span class="msg">*选择【是】即展示前端，【否】则不展示前端</span>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_online'); ?></td>
                        <td>
                            <?php echo $model->online_name; ?>
                            <!--<br><span class="msg">*选【是】时则可填写，选【否】时可不填写</span>-->
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'Signup_date'); ?></td>
                        <td>
                            <?php echo  $model->Signup_date.$form->hiddenField($model,'Signup_date'); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'Signup_date_end'); ?></td>
                        <td>
                            <?php echo  $model->Signup_date_end.$form->hiddenField($model,'Signup_date_end'); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_time'); ?></td>
                        <td>
                            <?php echo $model->game_time.$form->hiddenField($model,'game_time'); ?>
            
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_time_end'); ?></td>
                        <td>
                            <?php echo  $model->game_time_end.$form->hiddenField($model,'game_time_end'); ?>
                          
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'dispay_star_time'); ?></td>
                        <td>
                            <?php echo  $model->dispay_star_time.$form->hiddenField($model,'dispay_star_time'); ?>
                          
                        </td>
                        <td><?php echo $form->labelEx($model, 'dispay_end_time'); ?></td>
                        <td id="dt_dispay_end_time">
                            <?php echo  $model->dispay_end_time.$form->hiddenField($model,'dispay_end_time'); ?>
                        </td> 
                    </tr>
                </table>
                <?php if(get_session('club_id')==2450) {?>
                    <table class="mt15" style="table-layout:auto;">
                        <tr id="t3" class="table-title">
                            <td colspan="4">其它服务</td>
                        </tr>
                        <tr id="t5" style="display:none;">
                            <td style="padding:10px;"><?php echo $form->labelEx($model, 'club_list'); ?></td>
                            <td colspan="3">
                                <?php
                                    $model->id=empty($model->id) ? 0 : $model->id;
                                    $club_list = GameListRecommend::model()->findAll('game_id='.$model->id);
                                    echo $form->hiddenField($model, 'club_list', array('class' => 'input-text'));
                                ?>
                                <span id="club_list_box">
                                    <?php 
                                        if(!empty($club_list)){ foreach ($club_list as $v) {
                                            echo '<span class="label-box" id="club_item_'.$v->recommend_clubid.'" data-id="'.$v->recommend_clubid.'">';
                                            echo $v->club_list->club_name;
                                        
                                            echo '</span>';
                                        }}
                                    ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                <?php }?>
                <table id="t7" class="mt15" style="table-layout:auto;">
                    <tr class="table-title"><td colspan="4">审核信息</td></tr>
                    <tr>
                        <td width="12%;"><?php echo $form->labelEx($model, 'state'); ?></td>
                        <td width="38%;"><?php echo $model->state_name;?></td>
                        <td width="12%;"><?php echo $form->labelEx($model, 'reasons_failure'); ?></td>
                        <td width="38%;"><?php echo $model->reasons_failure; ?></td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    var $game_big_pic=$('#GameList_game_big_pic');
    var $upload_pic_GameList_game_big_pic=$('#upload_pic_GameList_game_big_pic');
    var $upload_box_GameList_game_big_pic=$('#upload_box_GameList_game_big_pic');
    var fnUpdatescrollPic=function(){
        var arr1=[];
        $upload_pic_GameList_game_big_pic.find('a').each(function(){
            arr1.push($(this).attr('data-savepath'));
        });
        $game_big_pic.val(we.implode(',',arr1));
        $upload_box_GameList_game_big_pic.show();
        if(arr1.length>=5) {
            $upload_box_GameList_game_big_pic.hide();
        }
    };
</script>