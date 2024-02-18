<?php
    if(!empty($model->dispay_start_time=='0000-00-00 00:00:00')){
        $model->dispay_start_time='';
    }
    if(!empty($model->dispay_end_time=='0000-00-00 00:00:00')){
        $model->dispay_end_time='';
    }
    if(!empty($model->buy_start=='0000-00-00 00:00:00')){
        $model->buy_start='';
    }
    if(!empty($model->buy_end=='0000-00-00 00:00:00')){
        $model->buy_end='';
    }
    if(!empty($model->start_time=='0000-00-00')){
        $model->start_time='';
    }
    if(!empty($model->end_time=='0000-00-00')){
        $model->end_time='';
    }
    if(!empty($list_data)){
        foreach($list_data as $d){
            if(!empty($d->start_time=='0000-00-00')){
                $d->start_time='';
            }
            if(!empty($d->end_time=='0000-00-00')){
                $d->end_time='';
            }
            if(!empty($d->min_age=='0000-00-00')){
                $d->min_age='';
            }
            if(!empty($d->max_age=='0000-00-00')){
                $d->max_age='';
            }
        }
    }
    $cr='service_type=354 and service_id='.$model->service_id.' and id<>'.$model->id.' and change_time<"'.$model->change_time.'" and change_time order by change_time DESC';
    $up=ClubChangeList::model()->find($cr);
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》活动管理》活动信息更改》详情</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div>
    <!--box-title end-->
    <div class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-tab">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>活动介绍</li>
            </ul>
        </div><!--box-detail-tab end-->
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td width="40%"><?php echo $model->code; ?></td>
                        <td width="10%;"><?php echo $form->labelEx($model, 'club_id'); ?></td>
                        <td width="40%">
                            <?php echo '<span id="club_box"><span class="label-box">'.$model->club_name.'</span></span>'; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->title!=$model->title?'red':''?>">
                            <?php echo '活动'.$form->labelEx($model, 'title'); ?>
                        </td>
                        <td class="<?= $up->title!=$model->title?'red':''?>">
                            <?php echo $model->title; ?>
                        </td>
                        <td class="<?= $up->if_live!=$model->if_live?'red':''?>">
                            <?php echo $form->labelEx($model, 'if_live'); ?>
                        </td>
                        <td class="<?= $up->if_live!=$model->if_live?'red':''?>">
                            <?php if(!is_null($model->online))echo $model->online->F_NAME; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->address!=$model->address?'red':''?>">活动地点</td>
                        <td class="<?= $up->address!=$model->address?'red':''?>">
                            <?php echo $model->address?>
                        </td>
                        <td class="<?= $up->GPS!=$model->GPS?'red':''?>">
                            <?php echo $form->labelEx($model, 'GPS'); ?>
                        </td>
                        <td class="<?= $up->GPS!=$model->GPS?'red':''?>">
                            <?php echo $model->GPS ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->dispay_start_time!=$model->dispay_start_time||$up->dispay_end_time!=$model->dispay_end_time?'red':''?>">前端显示时间</td>
                        <td class="<?= $up->dispay_start_time!=$model->dispay_start_time||$up->dispay_end_time!=$model->dispay_end_time?'red':''?>">
                            <?php echo $model->dispay_start_time.'-'.$model->dispay_end_time; ?>
                        </td>
                        <td class="<?= $up->buy_start!=$model->buy_start||$up->buy_end!=$model->buy_end?'red':''?>">报名时间</td>
                        <td class="<?= $up->buy_start!=$model->buy_start||$up->buy_end!=$model->buy_end?'red':''?>">
                            <?php echo $model->buy_start.'-'.$model->buy_end; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->apply_way!=$model->apply_way?'red':''?>">
                            <?php echo $form->labelEx($model, 'apply_way'); ?>
                        </td>
                        <td class="<?= $up->apply_way!=$model->apply_way?'red':''?>">
                            <?php if(!is_null($model->way))echo $model->way->F_NAME; ?>
                        </td>
                        <td <?= $up->start_time!=$model->start_time||$up->end_time!=$model->end_time?'red':''?>>活动时间</td>
                        <td <?= $up->start_time!=$model->start_time||$up->end_time!=$model->end_time?'red':''?>>
                            <?php echo $model->start_time.'-'.$model->end_time; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->men!=$model->men?'red':''?>">
                            <?php echo $form->labelEx($model, 'men'); ?>
                        </td>
                        <td class="<?= $up->men!=$model->men?'red':''?>">
                            <?php echo $model->men ?>
                        </td>
                        <td class="<?= $up->phone!=$model->phone?'red':''?>">
                            <?php echo $form->labelEx($model, 'phone'); ?>
                        </td>
                        <td class="<?= $up->phone!=$model->phone?'red':''?>">
                            <?php echo $model->phone ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->organizational!=$model->organizational?'red':''?>">
                            <?php echo $form->labelEx($model, 'organizational'); ?>
                        </td>
                        <td class="<?= $up->organizational!=$model->organizational?'red':''?>" colspan="3">
                            <?php echo $model->organizational ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->logo!=$model->logo?'red':''?>"><?php echo $form->labelEx($model, 'logo'); ?></td>
                        <td class="<?= $up->logo!=$model->logo?'red':''?>" id="dpic_logo">
                            <?php
                                echo $form->hiddenField($model, 'logo', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(295);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->logo!=''){
                            ?>
                            <div class="upload_img fl" id="upload_pic_ClubChangeList_logo">
                                <a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                        </td>
                        <td class="<?= $up->pic!=$model->pic?'red':''?>"><?php echo $form->labelEx($model, 'pic'); ?></td>
                        <td class="<?= $up->pic!=$model->pic?'red':''?>">
                            <?php echo $form->hiddenField($model, 'pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl" id="upload_pic_ClubChangeList_pic">
                                <?php 
                                    $basepath=BasePath::model()->getPath(296);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                    if(!empty($pic))foreach($pic as $v) {
                                ?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="100">
                                </a>
                                <?php }?>
                            </div>
                            <?php echo $form->error($model, 'pic', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                </table>
                <div class="mt15" id="train_data">
                    <?php 
                        if(!empty($list_data)){
                            $num=0;
                            foreach($list_data as $d){
                                $ud=ClubChangeData::model()->find('change_id='.$up->id.' and data_id='.$d->data_id);
                    ?>
                    <table class="mt15 train_data <?= empty($ud)?'red':'';?>" data_index="<?= $num;?>" style="table-layout:auto;">
                        <tr class="table-title">
                            <td colspan="4">活动信息</td>
                        </tr>
                        <tr>
                            <td class="<?= !empty($ud)&&$ud->project_id<>$d->project_id?'red':'';?>" style="width:10%;">项目</td>
                            <td class="<?= !empty($ud)&&$ud->project_id<>$d->project_id?'red':'';?>" style="width:40%;">
                                <?php echo $d->project_name; ?>
                            </td>
                            <td class="<?= !empty($ud)&&($ud->start_time<>$d->start_time||$ud->end_time<>$d->end_time)?'red':'';?>">活动时间</td>
                            <td class="<?= !empty($ud)&&($ud->start_time<>$d->start_time||$ud->end_time<>$d->end_time)?'red':'';?>"><?php echo $d->start_time.'-'.$d->end_time;?></td>
                        </tr>
                        <tr>
                            <td class="<?= !empty($ud)&&$ud->content<>$d->content?'red':'';?>">活动内容</td>
                            <td class="<?= !empty($ud)&&$ud->content<>$d->content?'red':'';?>"><?= $d->content;?></td>
                            <td class="<?= !empty($ud)&&$ud->apply_number<>$d->apply_number?'red':'';?>">可报名人数</td>
                            <td class="<?= !empty($ud)&&$ud->apply_number<>$d->apply_number?'red':'';?>"><?= $d->apply_number;?></td>
                        </tr>
                        <tr>
                            <td class="<?= !empty($ud)&&$ud->money<>$d->money?'red':'';?>">活动费用（元）</td>
                            <td class="<?= !empty($ud)&&$ud->money<>$d->money?'red':'';?>"><?= $d->money;?></td>
                            <td class="<?= !empty($ud)&&$ud->apply_check_way<>$d->apply_check_way?'red':'';?>">报名审核方式</td>
                            <td class="<?= !empty($ud)&&$ud->apply_check_way<>$d->apply_check_way?'red':'';?>">
                                <?php echo $d->check_way->F_NAME; ?>
                            </td>
                        </tr>
                        <tr>
                            <td class="<?= !empty($ud)&&($ud->min_age<>$d->min_age||$ud->max_age<>$d->max_age)?'red':'';?>">报名年龄要求</td>
                            <td class="<?= !empty($ud)&&($ud->min_age<>$d->min_age||$ud->max_age<>$d->max_age)?'red':'';?>" colspan="3">
                                <?php echo $d->min_age.'('.$model->getAge(strtotime($d->min_age)).'周岁)-'.$d->max_age.'('.$model->getAge(strtotime($d->max_age)).'周岁)';?>
                            </td>
                        </tr>
                    </table>
                    <?php $num++;}}?>
                </div>
            </div><!--box-detail-tab-item end-->

            <div style="display:none;" class="box-detail-tab-item">
                <!--活动描述开始-->
                <?php echo $form->hiddenField($model, 'description_temp', array('class' => 'input-text')); ?>
                <script>
                    we.editor('<?php echo get_class($model); ?>_description_temp', '<?php echo get_class($model); ?>[description_temp]');
                </script>
                <?php echo $form->error($model, 'description_temp', $htmlOptions = array()); ?>

            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    </div>
    <?php $this->endWidget(); ?>
</div><!--box-table end-->
</div><!--box-content end-->
<script>
    $(function() {
        setTimeout(function(){ UE.getEditor('editor_ClubChangeList_description_temp').setDisabled('fullscreen'); }, 500);
    })
    $(".box-detail-tab li").on("click",function(){
        if($(this).hasClass('current')){
            return false;
        }
        $("*").removeClass('current');
        $(this).addClass('current');
        $(".box-detail-tab-item").hide();
        $(".box-detail-tab-item").eq($(this).index()).show();
    })
</script>