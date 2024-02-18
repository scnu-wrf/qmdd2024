<?php
    check_request('type',0);
    check_post('data_id',0);
    check_post('data_type',0);

    if($_REQUEST['type']==810){
        $model->game_type=810;
    }
    if($_REQUEST['type']==163){
        $model->game_type=163;
    }
    if(!empty($model->id)) {
        $gamedata=GameListData::model()->count('game_id='.$model->id);
    }
    $sh = $model->state;
    $disabled = ($sh==721 || $sh==373) ? '' : 'disabled';
    $arr=BaseCode::model()->getCode_id2();
?>
<style>.box-detail-tab li { width: 120px; }</style>
<script>
    var $d_club_type2= <?php echo json_encode($arr)?>;
</script>
<div class="box">
    <div id="t0" class="box-title c">
        <h1>当前界面：赛事 》赛事管理 》赛事修改 》<a class="nav-a">添加修改</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回上一层</a></span>
    </div><!--box-title end-->
    <div class="box-detail">
     <?php $form = $this->beginWidget('CActiveForm', get_form_list('baocun')); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
				<table class="table-title">
					<tr>
						<td>赛事信息</td>
					</tr>
				</table>
            	<table id="game_info" data-num="new">
					<colgroup>
						<col width="12%"></col>
						<col width="21.33%"></col>
						<col width="12%"></col>
						<col width="21.33%"></col>
						<col width="12%"></col>
						<col></col>
						<col width="12%"></col>
					</colgroup>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_code'); ?></td>
                        <td><?php echo empty($model->id)?'<span style="color:#7a7a7a">系统生成</span>':$model->game_code; ?></td>
                        <td><?php echo $form->labelEx($model, 'game_club_id'); ?></td>
                        <td colspan=4><span class="label-box"><?php echo empty($model->id)?get_session('club_name'):$model->game_club_name;?></span>
						<?php if(empty($model->id)){ 
							echo $form->hiddenField($model, 'game_club_id', array('class' => 'input-text','value'=>get_session('club_id')));
						}else{
							echo $form->hiddenField($model, 'game_club_id', array('class' => 'input-text'));
						}?>
						</td>
					</tr>
					<tr>
                        <td><?php echo $form->labelEx($model, 'game_title'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'game_title', array('class' => 'input-text'));
                                echo $form->error($model, 'game_title', $htmlOptions = array());
                            ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'game_level'); ?></td>
                        <td>
                            <?php
                                echo $form->dropDownList($model, 'game_type', Chtml::listData(BaseCode::model()->getCode_id(), 'f_id', 'F_NAME'),array('prompt'=>'请选择','onchange' =>'selectOnchangProject(this)','style'=>'display:none;')).'&nbsp;';
                                echo $form->dropDownList($model, 'game_level', Chtml::listData(BaseCode::model()->getCode_id2_all(), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>'disabled'));
                                echo $form->error($model, 'game_type', $htmlOptions = array());
                                echo $form->error($model, 'game_level', $htmlOptions = array());
                            ?>
                        </td>
						<td><?php echo $form->labelEx($model, 'game_area'); ?></td>
                        <td colspan=2>
                            <?php echo $form->dropDownList($model, 'game_area', Chtml::listData(BaseCode::model()->getCode(158,' order by F_CODE'), 'f_id', 'F_NAME'), array('prompt'=>'请选择','disabled'=>'disabled')); ?>
                            <?php echo $form->error($model, 'game_area', $htmlOptions = array()); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_time1'); ?></td>
                        <td>
							<?php echo $form->textField($model, 'game_time', array('class' => 'input-text','style'=>'width:95px;','readonly'=>'readonly')); ?> - <?php echo $form->textField($model, 'game_time_end', array('class' => 'input-text','style'=>'width:95px;','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model,'game_time',$htmlOptions = array()); ?>
                            <?php echo $form->error($model,'game_time_end',$htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'game_address'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'game_address', array('class' => 'input-text'));
                                echo $form->error($model,'game_address',$htmlOption = array());
                            ?>
                        </td>
                        <td><?php echo $form->labelEx($model,'navigatio_address'); ?></td>
                        <td colspan=2>
                            <?php
                                echo  $form->textField($model,'navigatio_address',array('class'=>'input-text')) ;
                                echo $form->hiddenField($model, 'Longitude');
                                echo $form->hiddenField($model, 'latitude');
                                echo $form->error($model,'navigatio_address',$htmlOption = array());
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'signup_time'); ?></td>
                        <td>
							<?php echo $form->textField($model, 'Signup_date', array('class' => 'input-text','style'=>'width:95px;','readonly'=>'readonly')); ?> - <?php echo $form->textField($model, 'Signup_date_end', array('class' => 'input-text','style'=>'width:95px;','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model,'Signup_date',$htmlOptions = array()); ?>
                            <?php echo $form->error($model,'Signup_date_end',$htmlOptions = array()); ?>
                        </td>
                        <td><?php echo $form->labelEx($model, 'local_men'); ?></td>
                        <td>
                            <?php
                                echo $form->textField($model, 'local_men', array('class' => 'input-text','maxlength'=>'11')) ;
                                echo $form->error($model, 'local_men', $htmlOptions = array());
                            ?>
                        </td>
                        <td width="12%"><?php echo $form->labelEx($model,'local_and_phone');?></td>
                        <td colspan=2>
                            <?php
                                echo  $form->textField($model, 'local_and_phone', array('class' => 'input-text','maxlength'=>'11')) ;
                                echo $form->error($model, 'local_and_phone', $htmlOptions = array());
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="12%"><?php echo $form->labelEx($model, 'effective_time'); ?></td>
                        <td>
                            <?php
                            echo $form->textField($model, 'effective_time',array('class'=>'input-text'));
                            echo $form->error($model, 'effective_time', $htmlOptions = array());
                            ?>
                        </td>
						<td width="12%"><?php echo $form->labelEx($model, 'game_online'); ?></td>
                        <td>
                            <?php echo $form->dropDownList($model, 'game_online', Chtml::listData(BaseCode::model()->getCode(647), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                            <?php echo $form->error($model, 'game_online', $htmlOptions = array()); ?>
                        </td>
						<td width="12%"><?php echo $form->labelEx($model, 'dispay_time'); ?></td>
                        <td colspan=2>
							<?php echo $form->textField($model, 'dispay_star_time', array('class' => 'input-text','style'=>'width:95px;','readonly'=>'readonly')); ?> - <?php echo $form->textField($model, 'dispay_end_time', array('class' => 'input-text','style'=>'width:95px;','readonly'=>'readonly')); ?>
                            <?php echo $form->error($model,'dispay_star_time',$htmlOptions = array()); ?>
                            <?php echo $form->error($model,'dispay_end_time',$htmlOptions = array()); ?>
                        </td>
                    </tr>
					<tr>
                        <td width="12%"><?php echo $form->labelEx($model, 'if_organizational'); ?></td>
                        <td colspan=6>
                            <?php echo $form->radioButtonList($model, 'if_organizational', Chtml::listData(array(array("id"=>"1","name"=>"有"),array("id"=>"0","name"=>"无")), 'id', 'name'), $htmlOptions = array('separator' => '', 'class' => 'input-check', 'template' => '<span class="check">{input}{label}</span>','onchange'=>'selectIf_organizational(this)')); ?>
							<?php echo $form->error($model, 'if_organizational'); ?>
                        </td>
                    </tr>
					<?php if(!empty($org)){?>
						<?php foreach($org as $k=>$v){?>
					<tr class="organizational">
						<td width="12%"><input type="hidden" class="input-text" name="org_table[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" /><input type="text" class="input-text" name="org_table[<?php echo $v->id;?>][organizational_type]" value="<?php echo $v->organizational_type;?>" placeholder="如: 主办单位" /></td>
						<td colspan=5>
							<input type="text" class="input-text" name="org_table[<?php echo $v->id;?>][organizational]" value="<?php echo $v->organizational;?>" placeholder="如: XX公司、XX协会" />
						</td>
						<td>
							<a class="btn" href="javascript:;" onclick="addOrganizational(this)">添加行</a> <a class="btn" href="javascript:;" onclick="delOrganizational(this)">删除</a>
						</td>
					</tr>
						<?php }?>
					<?php }?>
                </table>
				<table class="table-title mt15">
					<tr>
						<td>
							比赛项目信息<span class="required">*</span>
							<!--&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn" href="javascript:;" onclick="add_game_data();">添加</a>-->
						</td>
					</tr>
				</table>
				<table style="table-layout:auto;" data-num="new" id="game_data_table">
                    <tr>
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
					<?php if(!empty($game_data)){?>
						<?php foreach($game_data as $k=>$v){?>
					<tr num="<?php echo $v->id;?>">
						<td><?php echo $v->game_data_code;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" /><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_data_code]" value="<?php echo $v->game_data_code;?>" /></td>
						<td><?php echo $v->project_name;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][project_id]" value="<?php echo $v->project_id;?>" /></td>
						<td><?php echo $v->game_data_name;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_data_name]" value="<?php echo $v->game_data_name;?>" /></td>
						<td><?php echo $v->game_player_team_name;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_player_team]" value="<?php echo $v->game_player_team;?>" /></td>
						<td><?php echo $v->game_dg_level_name;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_dg_level]" value="<?php echo $v->game_dg_level;?>" /></td>
						<td><?php echo $v->game_sex_name;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_sex]" value="<?php echo $v->game_sex;?>" /></td>
						<td><?php echo birthday($v->game_group_end);?>-<?php echo birthday($v->game_group_star);?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_group_star]" value="<?php echo $v->game_group_star;?>" /><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_group_end]" value="<?php echo $v->game_group_end;?>" /></td>
						<td><?php echo $v->number_of_member;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][number_of_member]" value="<?php echo $v->number_of_member;?>" /></td>
						<td><?php echo $v->game_money;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_money]" value="<?php echo $v->game_money;?>" /></td>
						<td><?php echo $v->isSignOnline_name;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][isSignOnline]" value="<?php echo $v->isSignOnline;?>" /></td>
						<td><?php echo $v->game_mode_name;?><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_mode]" value="<?php echo $v->game_mode;?>" /><input type="hidden" class="input-text" name="game_data_table[<?php echo $v->id;?>][game_check_way]" value="<?php echo $v->game_check_way;?>" /></td>
						<td><a class="btn" href="javascript:;" onclick="edit_game_data(this)">编辑</a> <a class="btn" href="javascript:;" onclick="dele_game_data(this)">取消项目</a></td>
					</tr>'
						<?php }?>
					<?php }?>
				</table>
				<table class="table-title mt15">
					<tr>
						<td>
							竞赛规程<span class="required">*</span>
							<span style="color:#7a7a7a;font-size:smaller;">（竞赛规程/规则/须知）</span>
							<!--&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn" href="javascript:;" onclick="add_game_introduction();">添加</a>-->
						</td>
					</tr>
				</table>
				<table id="intro_table" data-num="new">
					<tr>
                        <td width="12%">标题</td>
                        <td>详情</td>
                        <td width="12%">操作</td>
                    </tr>
					<?php if(!empty($intro)){?>
						<?php foreach($intro as $k=>$v){?>
					<tr>
						<td><?php echo $v->intro_title;?><input type="hidden" class="input-text" name="intro_table[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" /><input type="hidden" class="input-text" name="intro_table[<?php echo $v->id;?>][intro_title]" value="<?php echo $v->intro_title;?>" /></td>
						<td><?php echo $v->intro_content_temp1;?><textarea name="intro_table[<?php echo $v->id;?>][intro_content_temp]" style="display:none;"><?php echo $v->intro_content_temp;?></textarea><input type="hidden" class="input-text" name="intro_table[<?php echo $v->id;?>][type]" value="0" /></td>
						<td><a class="btn" href="javascript:;" onclick="">编辑</a> <a class="btn" href="javascript:;" onclick="fnDeleteIntro(this);">删除</a></td>
					</tr>
						<?php }?>
					<?php }?>
				</table>
				<table class="table-title mt15">
					<tr>
						<td>赛事图片</td>
					</tr>
				</table>
				<table>
					<colgroup>
						<col width="12%"></col>
						<col></col>
						<col width="12%"></col>
						<col></col>
						<col width="12%"></col>
						<col></col>
					</colgroup>
                    <tr>
                        <td width="12%"><?php echo $form->labelEx($model, 'game_small_pic'); ?></td>
                        <td id="dpic_game_small_pic">
                            <?php
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
                        <td width="12%"><?php echo $form->labelEx($model, 'game_big_pic'); ?></td>
                        <td colspan="3">
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
                                        <i onclick="$(this).parent().remove();fnGamewebtop();return false;"></i>
                                    </a>
                                <?php }?>
                            </div>
                            <script>we.uploadpic('<?php echo get_class($model);?>_game_web_top','<?php echo $picprefix;?>','','',function(e1,e2){fnWebtop(e1.savename,e1.allpath);});</script>
                            <?php echo $form->error($model, 'game_web_top', $htmlOptions = array()); ?>
                            <span class="msg">注：图片格式为1366px*150px,宽x高,最多一张</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                        <td width="12%"><?php echo $form->labelEx($model, 'game_web_bg'); ?></td>
                        <td>
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
                            <script>we.uploadpic('<?php echo get_class($model);?>_game_web_bg','<?php echo $picprefix;?>','','',function(e1,e2){fnWebbg(e1.savename,e1.allpath);});</script>
                            <?php echo $form->error($model, 'game_web_bg', $htmlOptions = array()); ?>
                            <span class="msg">注：图片格式为1366px*768px,宽x高,最多一张</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                    </tr>
                    <tr id="web_bg" style="display:none;">
                        <td width="12%"><?php echo $form->labelEx($model, 'game_web_top_color'); ?></td>
                        <td>
                            <?php echo $form->colorField($model, 'game_web_top_color', array('type'=>'color ')); ?><br>
                            <?php echo $form->error($model, 'game_web_top_color', $htmlOptions = array()); ?>
                            <span class="msg">注：如果选择背景图片，那么背景颜色不会显示</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                        <td width="12%"><?php echo $form->labelEx($model, 'game_web_bg_color'); ?></td>
                        <td>
                            <?php echo $form->colorField($model, 'game_web_bg_color', array('type'=>'color ')); ?><br>
                            <?php echo $form->error($model, 'game_web_bg_color', $htmlOptions = array()); ?>
                            <span class="msg">注：如果选择背景图片，那么背景颜色不会显示</span><br>
                            <span class="msg">注：只在网页端赛事主页显示</span>
                        </td>
                    </tr>
				</table>
                <table class="mt15" style="table-layout:auto;">
                    <tr>
                        <td colspan="2">
                            <span>
                                <input type="checkbox" id="check-1" class="checkbox" value="" style="vertical-align: sub;">
                                <label for="check-1">请勾选</label>
                                <a href="<?php echo Yii::app()->request->baseUrl.'/admin/views/gameList/全民动动-赛事平台服务协议.pdf'; ?>" target="_block">阅读：《赛事服务协议》</a>
                            </span>
                        </td>
                    </tr>
                    <tr id="dis_sh">
                        <td width="12%">可执行操作</td>
                        <td>
                            <?php
                                echo show_shenhe_box(array('baocun'=>'保存'));
                            ?>
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
$(function(){
	$('#GameList_game_time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
	$('#GameList_game_time_end').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});

	$('#GameList_Signup_date').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
	$('#GameList_Signup_date_end').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});

	$('#GameList_dispay_star_time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
	$('#GameList_dispay_end_time').on('click', function(){WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm'});});
	$('#GameList_effective_time').on('click', function(){
		if($('#GameList_Signup_date_end').val()==''){
			we.msg('minus','<span class="red" style="font-weight:bold;">先填写报名结束时间</span>');
			$(this).val('');
		}
		else{
			WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'GameList_Signup_date_end\')}'});
		}
	});
	var $start_time=$('#start_date');
	var $end_time=$('#end_date');
	$start_time.on('click', function(){
		var end_input=$dp.$('end_date')
		WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
	});
	$end_time.on('click', function(){
		WdatePicker({startDate:'%y-%M-%D 00:00',dateFmt:'yyyy-MM-dd HH:mm',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
	});
	fnUpdatescrollPic();
});

// 滚动图片处理
var $game_big_pic=$('#GameList_game_big_pic');
var $upload_pic_GameList_game_big_pic=$('#upload_pic_GameList_game_big_pic');
var $upload_box_GameList_game_big_pic=$('#upload_box_GameList_game_big_pic');

// 添加或删除时，更新图片
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
// 上传完成时图片处理
var fnscrollPic=function(savename,allpath){
	$upload_pic_GameList_game_big_pic.append('<a class="picbox" data-savepath="'+
	savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnUpdatescrollPic();return false;"></i></a>');
	fnUpdatescrollPic();
};


// 滚动图片处理
var $game_web_top=$('#GameList_game_web_top');
var $upload_pic_GameList_game_web_top=$('#upload_pic_GameList_game_web_top');

// 添加或删除时，更新图片
var fnGamewebtop=function(){
	var arr2=[];
	$upload_pic_GameList_game_web_top.find('a').each(function(){
		arr2.push($(this).attr('data-savepath'));
	});
	$game_web_top.val(we.implode(',',arr2));
};
// 上传完成时图片处理
var fnWebtop=function(savename,allpath){
	$upload_pic_GameList_game_web_top.html('<a class="picbox" data-savepath="'+
	savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnGamewebtop();return false;"></i></a>');
	fnGamewebtop();
};

// 滚动图片处理
var $game_web_bg=$('#GameList_game_web_bg');
var $upload_pic_GameList_game_web_bg=$('#upload_pic_GameList_game_web_bg');

// 添加或删除时，更新图片
var fnGamewebbg=function(){
	var arr3=[];
	$upload_pic_GameList_game_web_bg.find('a').each(function(){
		arr3.push($(this).attr('data-savepath'));
	});
	$game_web_bg.val(we.implode(',',arr3));
};
// 上传完成时图片处理
var fnWebbg=function(savename,allpath){
	$upload_pic_GameList_game_web_bg.html('<a class="picbox" data-savepath="'+
	savename+'" href="'+allpath+'" target="_blank"><img src="'+allpath+'" width="100"><i onclick="$(this).parent().remove();fnGamewebbg();return false;"></i></a>');
	fnGamewebbg();
};

var sname='<?php echo $model->level_name; ?>';
selectOnchangProject('#GameList_game_type');
function selectOnchangProject(obj){
	var show_id=$(obj).val();
	// console.log(show_id);
	var code,c1,c2;
	var code1;
	var  p_html ='<option value="">请选择</option>';
	if (show_id>0) {
		for (j=0;j<$d_club_type2.length;j++) {
			if($d_club_type2[j]['fater_id']==show_id){
				code1=$d_club_type2[j]['F_TYPECODE'];
				code=code1.substr(0,8);
			}
		}
		for (j=0;j<$d_club_type2.length;j++) {
			c2=we.trim($d_club_type2[j]['F_NAME'],' ');
			code1=$d_club_type2[j]['F_TYPECODE'];
			code1=code1.substr(0,8);
			c1='';
			if (c2==sname){
				c1='selected';
			}
			if((code1==code) && ($d_club_type2[j]['fater_id']==show_id) ){
				p_html = p_html +'<option  value="'+$d_club_type2[j]['f_id']+  '"'+c1+' >';
				p_html = p_html +c2+'</option>';
			}
		}
	}
	$("#GameList_game_level").html(p_html);
	if(show_id==163){
		$('#dis_obj').show();
	}
	else{
		$('#dis_obj').hide();
	}
}

function selectwayReferee(obj){
	var way_id=$(obj).val();
	var p_html ='<option value>请选择</option>';
	if(way_id==641){
		p_html=p_html+'<option value="792">人工审核</option>';
	}
	else{
		p_html=p_html+'<option value="792">人工审核</option><option value="793">自动审核</option>';
	}
	$("#GameList_game_check_way").html(p_html);
}


$(function(){
	var $GameList_navigatio_address=$('#GameList_navigatio_address');
	var $GameList_longitude=$('#GameList_Longitude');
	var $GameList_latitude=$('#GameList_latitude');
	var $GameList_game_address=$('#GameList_game_address');
	$GameList_navigatio_address.on('click', function(){
		$.dialog.data('maparea_address', '');
		$.dialog.open('<?php echo $this->createUrl("select/mapArea");?>&Longitude='+$GameList_longitude.val()+'&latitude='+$GameList_latitude.val(),{
			id:'diqu',
			lock:true,
			opacity:0.3,
			title:'选择服务地区',
			width:'907px',
			height:'65%',
			close: function () {
				if($.dialog.data('maparea_address')!=''){
					if($GameList_game_address.val()==''){
						$GameList_game_address.val($.dialog.data('txtarea'));
					}
					$GameList_longitude.val($.dialog.data('maparea_lng'));
					$GameList_latitude.val($.dialog.data('maparea_lat'));
					$('#GameList_navigatio_address').val($.dialog.data('maparea_address'));
				}
			}
		});
	});
});

//从图库选择图片
var $Single=$('#GameList_game_small_pic');
$('#picture_select_btn').on('click', function(){
	var club_id=$('#GameList_game_club_id').val();
	$.dialog.data('app_icon', 0);
	$.dialog.open('<?php echo $this->createUrl("gfMaterial/materialPictureAll", array('type'=>252,'fd'=>118));?>&club_id='+club_id,{
		id:'picture',
		lock:true,
		opacity:0.3,
		title:'请选择素材',
		width:'100%',
		height:'90%',
		close: function () {
			if($.dialog.data('material_id')>0){
				$Single.val($.dialog.data('app_icon')).trigger('blur');
				$('#upload_pic_GameList_game_small_pic').html('<a href="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
				+'" target="_blank"> <img src="<?php echo $basepath->F_WWWPATH;?>'+art.dialog.data('app_icon')
				+'"  width="100"></a>');
			}
		}
	});
});

$(function(){
	if(<?php echo $model->id; ?> > 0){
		$('#check-1').attr('checked',true);
	}
	is_click();
});

$('#check-1').on('click',function(){
	is_click();
});

function is_click(){
	if($('#check-1').is(':checked')){
		$('.btn-blue').removeAttr('disabled');
		$('.btn-blue').css({'background-color':'#368EE0','border-color':'#368EE0','cursor':'default'});
	}
	else{
		$('.btn-blue').attr('disabled','disabled');
		$('.btn-blue').css({'background-color':'#ccc','border-color':'#ccc','cursor':'no-drop'});
	}
}

// function clickOpenWord(){
//     window.open("<?php echo Yii::app()->request->baseUrl.'/admin/views/gameList/全民动动-赛事平台服务协议.pdf'; ?>");
// }

var $intro_table=$("#intro_table")
function add_game_introduction(){
	$.dialog.data('intro_title','');
	$.dialog.data('intro_content_temp','');
	$.dialog.open('<?php echo $this->createUrl("add_game_introduction");?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'85%',height:'65%',
		title:'添加竞赛规程',
		close: function () {
			if($.dialog.data('intro_title')!=''){
				var num=$intro_table.attr('data-num')+1;
				$intro_table.attr('data-num',num);
				var intro_title=$.dialog.data('intro_title');
				var intro_content_temp=$.dialog.data('intro_content_temp');
				var txt='<tr><td>'+intro_title+'<input type="hidden" class="input-text" name="intro_table['+num+'][id]" value="null" /><input type="hidden" class="input-text" name="intro_table['+num+'][intro_title]" value="'+intro_title+'" /></td><td>'+intro_content_temp.replace(/<[^>]*>|/g,"")+'<textarea name="intro_table['+num+'][intro_content_temp]" style="display:none;">'+intro_content_temp+'</textarea><input type="hidden" class="input-text" name="intro_table['+num+'][type]" value="0" /></td><td><a class="btn" href="javascript:;" onclick="">预览</a> <a class="btn" href="javascript:;" onclick="fnDeleteIntro(this);">删除</a></td></tr>';
				$("#intro_table").append(txt);
			}
		}
	});
}
var fnDeleteIntro=function(op){
	$(op).parent().parent().remove();
};
function add_game_data(){
	$.dialog.data('id','');
	$.dialog.data('game_data_code','');
	$.dialog.data('project_id','');
	$.dialog.data('game_data_name','');
	$.dialog.data('game_player_team','');
	$.dialog.data('game_dg_level','');
	$.dialog.data('game_sex','');
	$.dialog.data('game_group_star','');
	$.dialog.data('game_group_end','');
	$.dialog.data('number_of_member','');
	$.dialog.data('game_money','0.00');
	$.dialog.data('isSignOnline','');
	$.dialog.data('game_mode','');
	$.dialog.data('game_check_way','');
	$.dialog.open('<?php echo $this->createUrl("GameListData/add_game_data");?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'65%',height:'65%',
		title:'添加比赛项目',
		close: function () {
			if($.dialog.data('game_data_name')!=''){
				var num=$("#game_data_table").attr('data-num')+1;
				$("#game_data_table").attr('data-num',num);
				var game_data_name=$.dialog.data('game_data_name');
				var project_id=$.dialog.data('project_id');
				var project_name=$.dialog.data('project_name');
				var game_player_team=$.dialog.data('game_player_team');
				var game_player_team_name=$.dialog.data('game_player_team_name');
				var game_dg_level=$.dialog.data('game_dg_level');
				var game_dg_level_name=$.dialog.data('game_dg_level_name')==""?"不限":$.dialog.data('game_dg_level_name');
				var game_sex=$.dialog.data('game_sex');
				var game_sex_name=$.dialog.data('game_sex_name');
				var game_group_star=$.dialog.data('game_group_star');
				var game_group_end=$.dialog.data('game_group_end');
				var number_of_member=$.dialog.data('number_of_member');
				var game_money=$.dialog.data('game_money');
				var isSignOnline=$.dialog.data('isSignOnline');
				var isSignOnline_name=$.dialog.data('isSignOnline_name');
				var game_mode=$.dialog.data('game_mode');
				var game_mode_name=$.dialog.data('game_mode_name');
				var game_check_way=$.dialog.data('game_check_way');
				
				var txt='<tr num="'+num+'">'+
					'<td><span class="msg">系统默认</span><input type="hidden" class="input-text" name="game_data_table['+num+'][id]" value="null" /><input type="hidden" class="input-text" name="game_data_table['+num+'][game_data_code]" value="" /></td>'+
					'<td>'+project_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][project_id]" value="'+project_id+'" /></td>'+
					'<td>'+game_data_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_data_name]" value="'+game_data_name+'" /></td>'+
					'<td>'+game_player_team_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_player_team]" value="'+game_player_team+'" /></td>'+
					'<td>'+game_dg_level_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_dg_level]" value="'+game_dg_level+'" /></td>'+
					'<td>'+game_sex_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_sex]" value="'+game_sex+'" /></td>'+
					'<td>'+jsGetAge(game_group_end)+'-'+jsGetAge(game_group_star)+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_group_star]" value="'+game_group_star+'" /><input type="hidden" class="input-text" name="game_data_table['+num+'][game_group_end]" value="'+game_group_end+'" /></td>'+
					'<td>'+number_of_member+'<input type="hidden" class="input-text" name="game_data_table['+num+'][number_of_member]" value="'+number_of_member+'" /></td>'+
					'<td>'+game_money+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_money]" value="'+game_money+'" /></td>'+
					'<td>'+isSignOnline_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][isSignOnline]" value="'+isSignOnline+'" /></td>'+
					'<td>'+game_mode_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_mode]" value="'+game_mode+'" /><input type="hidden" class="input-text" name="game_data_table['+num+'][game_check_way]" value="'+game_check_way+'" /></td>'+
					'<td><a class="btn" href="javascript:;" onclick="edit_game_data(this)">编辑</a> <a class="btn" href="javascript:;" onclick="dele_game_data(this)">删除</a></td>'+
				'</tr>';
				$("#game_data_table").append(txt);
			}
		}
	});
}
function edit_game_data(obj){
	$.dialog.data('num',$(obj).parents("tr").attr("num"));
	$.dialog.data('id',$(obj).parents("tr").children("td").eq(0).children(".input-text").eq(0).val());
	$.dialog.data('game_data_code',$(obj).parents("tr").children("td").eq(0).children(".input-text").eq(1).val());
	$.dialog.data('project_id',$(obj).parents("tr").children("td").eq(1).children(".input-text").val());
	$.dialog.data('game_data_name',$(obj).parents("tr").children("td").eq(2).children(".input-text").val());
	$.dialog.data('game_player_team',$(obj).parents("tr").children("td").eq(3).children(".input-text").val());
	$.dialog.data('game_dg_level',$(obj).parents("tr").children("td").eq(4).children(".input-text").val());
	$.dialog.data('game_sex',$(obj).parents("tr").children("td").eq(5).children(".input-text").val());
	$.dialog.data('game_group_star',$(obj).parents("tr").children("td").eq(6).children(".input-text").eq(0).val());
	$.dialog.data('game_group_end',$(obj).parents("tr").children("td").eq(6).children(".input-text").eq(1).val());
	$.dialog.data('number_of_member',$(obj).parents("tr").children("td").eq(7).children(".input-text").val());
	$.dialog.data('game_money',$(obj).parents("tr").children("td").eq(8).children(".input-text").val());
	$.dialog.data('isSignOnline',$(obj).parents("tr").children("td").eq(9).children(".input-text").val());
	$.dialog.data('game_mode',$(obj).parents("tr").children("td").eq(10).children(".input-text").eq(0).val());
	$.dialog.data('game_check_way',$(obj).parents("tr").children("td").eq(10).children(".input-text").eq(1).val());
	$.dialog.open('<?php echo $this->createUrl("GameListData/add_game_data");?>',{
		id:'fuwuzhe',lock:true,opacity:0.3,width:'65%',height:'65%',
		title:'添加比赛项目',
		close: function () {
			if($.dialog.data('game_data_name')!=''){
				var id=$.dialog.data('id');
				var num=$.dialog.data('num');
				$("#game_data_table").attr('data-num',num);
				var game_data_code=$.dialog.data('game_data_code');
				var game_data_name=$.dialog.data('game_data_name');
				var project_id=$.dialog.data('project_id');
				var project_name=$.dialog.data('project_name');
				var game_player_team=$.dialog.data('game_player_team');
				var game_player_team_name=$.dialog.data('game_player_team_name');
				var game_dg_level=$.dialog.data('game_dg_level');
				var game_dg_level_name=$.dialog.data('game_dg_level_name')==""?"不限":$.dialog.data('game_dg_level_name');
				var game_sex=$.dialog.data('game_sex');
				var game_sex_name=$.dialog.data('game_sex_name');
				var game_group_star=$.dialog.data('game_group_star');
				var game_group_end=$.dialog.data('game_group_end');
				var number_of_member=$.dialog.data('number_of_member');
				var game_money=$.dialog.data('game_money');
				var isSignOnline=$.dialog.data('isSignOnline');
				var isSignOnline_name=$.dialog.data('isSignOnline_name');
				var game_mode=$.dialog.data('game_mode');
				var game_mode_name=$.dialog.data('game_mode_name');
				var game_check_way=$.dialog.data('game_check_way');
				
				var txt='<tr num="'+num+'">'+
					'<td>'+game_data_code+'<input type="hidden" class="input-text" name="game_data_table['+num+'][id]" value="'+id+'" /><input type="hidden" class="input-text" name="game_data_table['+num+'][game_data_code]" value="'+game_data_code+'" /></td>'+
					'<td>'+project_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][project_id]" value="'+project_id+'" /></td>'+
					'<td>'+game_data_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_data_name]" value="'+game_data_name+'" /></td>'+
					'<td>'+game_player_team_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_player_team]" value="'+game_player_team+'" /></td>'+
					'<td>'+game_dg_level_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_dg_level]" value="'+game_dg_level+'" /></td>'+
					'<td>'+game_sex_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_sex]" value="'+game_sex+'" /></td>'+
					'<td>'+jsGetAge(game_group_end)+'-'+jsGetAge(game_group_star)+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_group_star]" value="'+game_group_star+'" /><input type="hidden" class="input-text" name="game_data_table['+num+'][game_group_end]" value="'+game_group_end+'" /></td>'+
					'<td>'+number_of_member+'<input type="hidden" class="input-text" name="game_data_table['+num+'][number_of_member]" value="'+number_of_member+'" /></td>'+
					'<td>'+game_money+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_money]" value="'+game_money+'" /></td>'+
					'<td>'+isSignOnline_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][isSignOnline]" value="'+isSignOnline+'" /></td>'+
					'<td>'+game_mode_name+'<input type="hidden" class="input-text" name="game_data_table['+num+'][game_mode]" value="'+game_mode+'" /><input type="hidden" class="input-text" name="game_data_table['+num+'][game_check_way]" value="'+game_check_way+'" /></td>'+
					'<td><a class="btn" href="javascript:;" onclick="edit_game_data(this)">编辑</a> <a class="btn" href="javascript:;" onclick="dele_game_data(this)">删除</a></td>'+
				'</tr>';
				$("#game_data_table").find('input[name="game_data_table['+num+'][id]"]').parents("tr").after(txt);
				$("#game_data_table").find('input[name="game_data_table['+num+'][id]"]').parents("tr").eq(1).remove();
			}
		}
	});
}
function dele_game_data(obj){
	$(obj).parents("tr").remove();
}
selectIf_organizational($('input[type="radio"][name="GameList[if_organizational]"]:checked'));
function selectIf_organizational(obj){
    var if_organizational=$(obj).val();
    if(if_organizational==1){
		if($('.organizational').length<=0){
			addOrganizational(obj);
		}
    } else{
        $('.organizational').remove();
    }
}
function addOrganizational(obj){
	var num=$("#game_info").attr("data-num")+1;
	$("#game_info").attr("data-num",num);
	var txt='<tr class="organizational">'+
		'<td width="12%"><input type="hidden" class="input-text" name="org_table['+num+'][id]" value="null" /><input type="text" class="input-text" name="org_table['+num+'][organizational_type]" value="" placeholder="如: 主办单位" /></td>'+
		'<td colspan=5>'+
			'<input type="text" class="input-text" name="org_table['+num+'][organizational]" value="" placeholder="如: XX公司、XX协会" />'+
		'</td>'+
		'<td>'+
			'<a class="btn" href="javascript:;" onclick="addOrganizational(this)">添加行</a> <a class="btn" href="javascript:;" onclick="delOrganizational(this)">删除</a>'+
		'</td>'+
	'</tr>';
	$("#game_info").append(txt);
}
function delOrganizational(obj){
	$(obj).parents(".organizational").remove();
	if($('.organizational').length<=0){
		$('input[type="radio"][name="GameList[if_organizational]"][value=0]').click();
	}
}
</script>