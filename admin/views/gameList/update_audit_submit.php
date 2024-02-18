<div class="box">
    <div id="t0" class="box-title c">
        <h1>当前界面：赛事 》赛事发布 》发布赛事 》<a class="nav-a">详情</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo get_cookie('_currentUrl_');?>');"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
    <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table>
					<colgroup>
						<col width="12%"></col>
						<col></col>
						<col width="12%"></col>
						<col></col>
						<col width="12%"></col>
						<col></col>
					</colgroup>
                    <tr class="table-title">
                        <td colspan=6>赛事信息</td>
                    </tr>
                    <tr>
                        <?php echo $form->error($model,'id'); ?>
                        <td><?php echo $form->labelEx($model, 'game_code'); ?></td>
                        <td><?php echo $model->game_code; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_club_id'); ?></td>
                        <td colspan=3><?php echo $model->game_club_name; ?></td>
					</tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'game_title'); ?></td>
                        <td><?php echo $model->game_title.$form->hiddenField($model,'game_title'); ?></td>
                        <td><?php echo $form->labelEx($model, 'game_level'); ?></td>
                        <td><?php echo $model->level_name; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_area'); ?></td>
                        <td><?php echo $model->area_name; ?></td>
                    </tr>
                    <tr>
                        <td>赛事时间</td>
                        <td><?php echo date("Y-m-d H:i",strtotime($model->game_time)); ?>-<?php echo date("Y-m-d H:i",strtotime($model->game_time_end)); ?></td>
                        <td><?php echo $form->labelEx($model, 'game_address'); ?></td>
                        <td><?php echo $model->game_address.$form->hiddenField($model,'game_address'); ?></td>
                        <td><?php echo $form->labelEx($model,'navigatio_address'); ?></td>
                        <td><?php echo $model->navigatio_address.$form->hiddenField($model,'navigatio_address'); ?></td>
                    </tr>
                    <tr>
                        <td>报名时间</td>
                        <td><?php echo date("Y-m-d H:i",strtotime($model->Signup_date)); ?>-<?php echo date("Y-m-d H:i",strtotime($model->Signup_date_end)); ?></td>
                        <td><?php echo $form->labelEx($model, 'local_men'); ?></td>
                        <td><?php echo $model->local_men.$form->hiddenField($model,'local_men'); ?></td>
                        <td><?php echo $form->labelEx($model, 'local_and_phone'); ?></td>
                        <td><?php echo $model->local_and_phone.$form->hiddenField($model,'local_and_phone'); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'effective_time'); ?></td>
                        <td><?php echo date("Y-m-d H:i",strtotime($model->effective_time)); ?></td>
                        <td><?php echo $form->labelEx($model, 'game_online'); ?></td>
                        <td><?php echo $model->online_name; ?></td>
                        <td>前端显示时间</td>
                        <td><?php echo date("Y-m-d H:i",strtotime($model->dispay_star_time)); ?>-<?php echo date("Y-m-d H:i",strtotime($model->dispay_end_time)); ?></td>
                    </tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'if_organizational'); ?></td>
                        <td colspan=5>
                            <?php echo $model->if_organizational==1?'有':'无'; ?>
                        </td>
                    </tr>
					<?php if(!empty($org)){?>
						<?php foreach($org as $k=>$v){?>
					<tr class="organizational">
						<td><?php echo $v->organizational_type;?></td>
						<td colspan=5><?php echo $v->organizational;?></td>
					</tr>
						<?php }?>
					<?php }?>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="12">比赛项目信息</td>
                    </tr>
                    <tr class="table-title">
                        <td>比赛项目编号</td>
                        <td>赛事项目</td>
                        <td>比赛项目</td>
                        <td>比赛方式</td>
                        <td>会员</td>
                        <td>性别</td>
                        <td>年龄（岁）</td>
                        <td>报名名额（个/队）</td>
                        <td>报名费（元）</td>
                        <td>报名方式</td>
                        <td>比赛方法</td>
                        <td>操作</td>
                    </tr>
                    <tbody>
                    <?php foreach($game_data as $v){ ?>
                        <tr>
                            <td><?php echo $v->game_data_code; ?></td>
                            <td><?php echo $v->project_name; ?></td>
                            <td><?php echo $v->game_data_name; ?></td>
                            <td><?php echo $v->game_player_team_name; ?></td>
                            <td><?php echo $v->game_dg_level_name; ?></td>
                            <td><?php echo $v->game_sex_name; ?></td>
                            <td><?php echo birthday($v->game_group_end);?>-<?php echo birthday($v->game_group_star);?></td>
                            <td><?php echo $v->number_of_member; ?></td>
                            <td><?php echo $v->game_money; ?></td>
                            <td><?php echo $v->isSignOnline_name; ?></td>
                            <td><?php echo $v->game_mode_name; ?></td>
                            <td><a href="javascript:;" class="btn" onclick="clickListData('<?php echo $v->id; ?>','<?php echo $v->game_data_name; ?>');">查看</a></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan="3">竞赛规程<span class="required">*</span><span style="color:#7a7a7a;font-size:smaller;">（竞赛规程/规则/须知）</span></td>
                    </tr>
                    <tr class="table-title">
                        <td width="12%">标题</td>
                        <td>详情</td>
                        <td width="12%">操作</th>
                    </tr>
                    <tbody>
                        <?php foreach($intro as $c) {?>
                            <tr>
                                <td><?php echo $c->intro_title; ?></td>
                                <td><?php echo $c->intro_content_temp1; ?></td>
                                <td><a href="javascript:;" class="btn" onclick="onIntroduction(<?php echo $c->id; ?>,0);">查看</a></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
                <table class="mt15">
					<colgroup>
						<col width="12%"></col>
						<col></col>
						<col width="12%"></col>
						<col></col>
						<col width="12%"></col>
						<col></col>
					</colgroup>
                    <tr class="table-title">
                        <td colspan=6>赛事图片</td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_small_pic'); ?></td>
                        <td id="dpic_game_small_pic">
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
                        <td><?php echo $form->labelEx($model, 'game_big_pic'); ?></td>
                        <td colspan=3>
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
                        <td><?php echo $form->labelEx($model, 'game_web_top'); ?></td>
                        <td>
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
                        <td><?php echo $form->labelEx($model, 'game_web_bg'); ?></td>
                        <td colspan=3>
                            <?php echo $form->hiddenField($model, 'game_web_bg', array('class' => 'input-text fl')); ?>
                            <div class="upload_img fl" id="upload_pic_GameList_game_web_bg">
                                <?php 
                                    $basepath=BasePath::model()->getPath(205);$picprefix='';
                                    if($basepath!=null){ $picprefix=$basepath->F_CODENAME; }
                                ?>
                                <?php if($model->game_web_bg!=''){?>
                                    <a class="picbox" data-savepath="<?php echo $model->game_web_bg;?>" href="<?php echo $basepath->F_WWWPATH.$model->game_web_bg;?>" target="_blank">
                                        <img src="<?php echo $basepath->F_WWWPATH.$model->game_web_bg;?>" width="100">
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
                        <td colspan=3>
                            <?php echo $form->colorField($model, 'game_web_bg_color', array('type'=>'color ')); ?><br>
                            <span class="msg">注：如果选择背景图片，那么背景颜色不会显示</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                    </tr>
                </table>
                <table class="mt15" style="table-layout:auto;">
                    <tr class="table-title">
                        <td colspan=2>操作信息</td>
                    </tr>
                    <tr>
                        <td width="12%"><?php echo $form->labelEx($model,'state'); ?></td>
                        <td><?php echo $model->state_name; ?></td>
                    </tr>
                    <tr>
                        <td width="12%">可执行操作</td>
                        <td>
							<?php echo show_shenhe_box(array('chexiao'=>'撤销'));?>
                            <button class="btn" type="button" onclick="we.back();">取消</button>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget();?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
    function onIntroduction(id,num){
        var title;
        switch (num) {
            case 1:
                title = '裁判员须知';
                break;
            case 2:
                title = '运动员须知';
                break;
            default:
                title = '查看竞赛规程';
        }
        var s_html = '<div id="show_trodu" style="overflow:auto;"></div>';
        $.dialog({
            id:'showtrodu',
            lock:true,
            opacity:0.3,
            width: '60%',
            height: '60%',
            title: title,
            content: s_html,
        });
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('showtrodu'); ?>&id='+id+'&num='+num,
            dataType: 'json',
            success: function(data){
                $('#show_trodu').html(data);
                $('#show_trodu').css('max-height','500px');
            }
        });
    }

    function clickListData(id,title){
        $.dialog.data('id', 0);
        $.dialog.open('<?php echo $this->createUrl('gameListData/update_notedit'); ?>&id='+id,{
            id:'list_data',
            lock:true,
            opacity:0.3,
            title:title,
            width:'80%',
            height:'80%',
            close: function () {}
        });
    }
</script>