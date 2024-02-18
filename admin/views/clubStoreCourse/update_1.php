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
    $cr='service_type=1537 and service_id='.$model->service_id.' and id<>'.$model->id.' and change_time<"'.$model->change_time.'" and change_time order by change_time DESC';
    $up=ClubChangeList::model()->find($cr);
?>
<div class="box">
    <div id="t0" class="box-title c">
        <h1>当前界面：培训/活动》课程管理》信息更改》详情</h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="current">基本信息</li>
                <li>课程介绍</li>
            </ul>
        </div>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table id="t1" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">基本信息</td>
                    </tr>
                    <tr>
                        <td class="<?= $up->type_id!=$model->type_id||$up->type2_id!=$model->type2_id?'red':''?>" width="10%;">
                            类型/类别
                        </td>
                        <td class="<?= $up->type_id!=$model->type_id||$up->type2_id!=$model->type2_id?'red':''?>" colspan="3">
                            <?php echo '<span class="label-box">'.$model->type_name.'/'.$model->type2_name.'</span>';?>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%;"><?php echo $form->labelEx($model, 'code'); ?></td>
                        <td width="40%;"><?php echo $model->code; ?></td>
                        <td width="10%;"><?php echo $form->labelEx($model, 'club_name'); ?></td>
                        <td width="40%;"><?php echo $model->club_name;?></td>
                    </tr>
                    <tr>
                        <td class="<?= $up->title!=$model->title?'red':''?>">
                            <?php echo $form->labelEx($model, 'title'); ?>
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
                        <td class="<?= $up->dispay_start_time!=$model->dispay_start_time||$up->dispay_end_time!=$model->dispay_end_time?'red':''?>">
                            <?php echo $form->labelEx($model, 'dispay_start_time'); ?>
                        </td>
                        <td class="<?= $up->dispay_start_time!=$model->dispay_start_time||$up->dispay_end_time!=$model->dispay_end_time?'red':''?>" colspan="3">
                            <?php echo $model->dispay_start_time.'-'.$model->dispay_end_time; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->logo!=$model->logo?'red':''?>">
                            <?php echo $form->labelEx($model, 'logo'); ?>
                        </td>
                        <td class="<?= $up->logo!=$model->logo?'red':''?>" >
                            <?php
                                echo $form->hiddenField($model, 'logo', array('class' => 'input-text fl'));
                                $basepath=BasePath::model()->getPath(298);$picprefix='';
                                if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                if($model->logo!=''){
                            ?>
                            <div class="upload_img fl" >
                                <a href="<?php echo $basepath->F_WWWPATH.$model->logo;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$model->logo;?>" width="100">
                                </a>
                            </div>
                            <?php }?>
                        </td>
                        <td class="<?= $up->pic!=$model->pic?'red':''?>">
                            <?php echo $form->labelEx($model, 'pic'); ?>
                        </td>
                        <td class="<?= $up->pic!=$model->pic?'red':''?>">
                            <?php echo $form->hiddenField($model, 'pic', array('class' => 'input-text')); ?>
                            <div class="upload_img fl">
                                <?php 
                                    $basepath=BasePath::model()->getPath(299);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                    if(!empty($pic))foreach($pic as $v) {
                                ?>
                                <a class="picbox" data-savepath="<?php echo $v;?>" href="<?php echo $basepath->F_WWWPATH.$v;?>" target="_blank">
                                    <img src="<?php echo $basepath->F_WWWPATH.$v;?>" width="50">
                                </a>
                                <?php }?>
                            </div>
                        </td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="4">课程信息</td>
                    </tr>
                    <tr>
                        <td class="<?= $up->project_id!=$model->project_id?'red':''?>">
                            <?php echo $form->labelEx($model, 'project_id'); ?>
                        </td>
                        <td class="<?= $up->project_id!=$model->project_id?'red':''?>" colspan="3">
                            <?php echo $model->project_name; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->grade!=$model->grade?'red':''?>" style="width:10%;">
                            <?php echo $form->labelEx($model, 'grade'); ?>
                        </td>
                        <td class="<?= $up->grade!=$model->grade?'red':''?>" style="width:40%;">
                            <?php echo $model->grade_name; ?>
                        </td>
                        <td class="<?= $up->money!=$model->money?'red':''?>" style="width:10%;">
                            <?php echo $form->labelEx($model, 'money'); ?>
                        </td>
                        <td class="<?= $up->money!=$model->money?'red':''?>" style="width:40%;">
                            <?php echo $model->money; ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="<?= $up->buy_start!=$model->buy_start||$up->buy_start!=$model->buy_start?'red':''?>">
                            销售时间
                        </td>
                        <td class="<?= $up->buy_start!=$model->buy_start||$up->buy_start!=$model->buy_start?'red':''?>" colspan="3">
                            <?php echo $model->buy_start; ?>
                            -
                            <?php echo $model->buy_end; ?>
                        </td>
                    </tr>
                </table>
                <div class="mt15">
                    <table class="mt15" id="course_data">
                        <tr class="table-title">
                            <td colspan="5">课程列表</td>
                        </tr>
                        <tr>
                            <td>序号</td>
                            <td>课程缩略图</td>
                            <td>视频标题</td>
                            <td>视频时长</td>
                            <td>视频内容</td>
                        </tr>
                        <?php $basepath=BasePath::model()->getPath(301);$picprefix1='';if($basepath!=null){ $picprefix1=$basepath->F_CODENAME;}?>
                        <?php 
                            if(!empty($list_data)){
                                $num=0;
                                foreach($list_data as $d){
                                    $ud=ClubChangeData::model()->find('change_id='.$up->id.' and data_id='.$d->data_id);
                        ?>
                        <tr class="course_data" data_index="<?= $num;?>" >
                            <td><?php echo $num+1;?></td>
                            <td>
                                <?php if(!empty($d->video_pic)){?>
                                    <div class="upload_img fl" id="upload_pic_add_tag_video_pic_<?= $num;?>">
                                        <a class="picbox" data-savepath="<?php echo $d->video_pic;?>" href="<?php echo $basepath->F_WWWPATH.$d->video_pic;?>" target="_blank">
                                            <img src="<?php echo $basepath->F_WWWPATH.$d->video_pic;?>" width="100">
                                        </a>
                                    </div>
                                <?php }?>
                            </td>
                            <td class="<?= !empty($ud)&&$ud->video_title<>$d->video_title?'red':'';?>">
                                <?php echo $d->video_title; ?>
                            </td>
                            <td class="<?= !empty($ud)&&$ud->video_duration<>$d->video_duration?'red':'';?>">
                                <?php echo $d->video_duration; ?>
                            </td>
                            <td class="<?= !empty($ud)&&$ud->video_id<>$d->video_id?'red':'';?>">
                                <div class="c">
                                    <span id="video_box_<?= $num;?>" class="fl">
                                        <?php 
                                            if(!empty($d->video_id)){
                                                $gf_material=GfMaterial::model()->find('id='.$d->video_id);
                                        ?>
                                            <span class="label-box">
                                            <a href="<?php if(!empty($gf_material))echo $gf_material->v_file_path.$gf_material->v_name;?>" target="_blank">
                                                <?php if(!empty($gf_material))echo $gf_material->v_name;?>
                                            </a>
                                            </span>
                                        <?php }?>
                                    </span>
                                </div>
                            </td>
                        </tr>
                        <?php $num++;}}?>
                    </table>
                </div>
            </div><!--box-detail-tab-item end-->
            <div style="display:none;" class="box-detail-tab-item">
                <!--课程描述开始-->
                <?php echo $form->hiddenField($model, 'description_temp', array('class' => 'input-text')); ?>
                <script>
                    we.editor('<?php echo get_class($model); ?>_description_temp', '<?php echo get_class($model); ?>[description_temp]');
                </script>
                <?php echo $form->error($model, 'description_temp', $htmlOptions = array()); ?>

            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    $(function(){
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
