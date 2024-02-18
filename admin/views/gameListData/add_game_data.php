<?php 
$arr=ProjectList::model()->getProject_id2('IF_VISIBLE=649 AND project_type=2 and if_del=648');
$arr1=ProjectListGame::model()->getProjectGame_id2();
?>
<div class="box">
    <div class="box-detail">
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
            	<table border="0" cellspacing="1" cellpadding="0" class="product_publish_content">
                    <tr>
                        <td width="30%"><?php echo CHtml::activeLabelEx($model, 'project_id'); ?> <span class="required">*</span></td>
                        <td>
							<?php
                                $whe = 't.if_del in(0,648) and t.IF_VISIBLE=649 and t.project_type=1'; 
                                $whe .= ' and exists(select * from club_project cpj where '.get_where_club_project('cpj.club_id');
                                $whe .= ' and cpj.project_id=t.id and cpj.project_state=506 and cpj.auth_state=461 and cpj.state=372)';
                                $project = ProjectList::model()->findAll($whe);
                            ?>
                            <?php echo CHtml::activeDropDownList($model, 'project_id', CHtml::listData($project, 'id', 'project_name'),array('prompt'=>'请选择', 'onchange' =>'selectOnchangProject(this)')); ?>
						</td>
                    </tr>
                    <tr class="table-title">
                        <td colspan="2">比赛项目信息</td>
                    </tr>
					<tr>
						<td><?php echo CHtml::activeLabelEx($model, 'game_data_code'); ?></td>
						<td id="GameListData_game_data_code"></td>
					</tr>
					<tr>
						<td><?php echo CHtml::activeLabelEx($model, 'game_data_name'); ?> <span class="required">*</span></td>
						<td>
							<?php
                                if($model->id==''){
                                    echo CHtml::activeTextField($model, 'game_data_name',array('class'=>'input-text'));
                                }
                                else{
                                    echo ($sh==721 || $sh==373) ? CHtml::activeTextField($model, 'game_data_name',array('class'=>'input-text')) : $model->game_data_name;
                                }
                            ?>
						</td>
					</tr>
					<tr>
						<td><?php echo CHtml::activeLabelEx($model, 'game_player_team'); ?> <span class="required">*</span></td>
                        <td>
                            <?php $model->game_player_team=empty($model->game_player_team)?0:$model->game_player_team;?>
                            <?php echo CHtml::activeDropDownList($model, 'game_player_team', CHtml::listData(BaseCode::model()->getCode(664), 'f_id', 'F_NAME'), array('prompt'=>'请选择','onchange' =>'selectOnchangPlayer(this)')); ?>
                        </td>
					</tr>
					<tr>
						<td><?php echo CHtml::activeLabelEx($model, 'game_mode'); ?> <span class="required">*</span></td>
                        <td>
                            <?php echo CHtml::activeDropDownList($model, 'game_mode', Chtml::listData(BaseCode::model()->getCode(660), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        </td>
					</tr>
					<tr>
						<td><?php echo CHtml::activeLabelEx($model, 'game_dg_level'); ?></td>
                        <td>
							<?php echo CHtml::activeCheckBoxList($model, 'game_dg_level', Chtml::listData(ServicerLevel::model()->findAll('type in(1472)  order by card_xh'), 'card_xh', 'card_name'),
						  $htmlOptions = array('separator' => '', 'class' => 'input-check', 'style'=>"display:inline-block;width:20px;", 'template' => '<span class="check">{input}{label}</span>')); ?><br><span class="msg">可多选/不选择为不限等级</span>
                        </td>
					</tr>
					<tr>
						<td><?php echo CHtml::activeLabelEx($model, 'game_sex'); ?> <span class="required">*</span></td>
                        <td>
                            <?php $model->game_sex=empty($model->game_sex)?0:$model->game_sex;?>
                            <?php echo CHtml::activeDropDownList($model, 'game_sex', Chtml::listData(BaseCode::model()->getCode(204), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        </td>
					</tr>
					<tr>
						<td>参赛年龄 <span class="required">*</span></td>
                        <td>
                            <?php
                                echo  CHtml::activeTextField($model, 'game_group_end', array('class' => 'input-text','placeholder' => '最晚出生日期','style'=>'width: 120px;'));
                            ?> - <?php
                                echo  CHtml::activeTextField($model, 'game_group_star', array('class' => 'input-text','placeholder' => '最早出生日期','style'=>'width: 120px;'));
                            ?>
                        </td>
					</tr>
                    <tr class="table-title">
                        <td colspan="2">报名信息</td>
                    </tr>
					<tr>
                        <td><?php echo CHtml::activeLabelEx($model, 'number_of_member'); ?> <span class="required">*</span></td>
                        <td>
                            <?php
                                echo CHtml::activeTextField($model, 'number_of_member', array('class' => 'input-text','placeholder' => '输入最高可报数量'));
                            ?>
                        </td>
					</tr>
					<tr id="dis_num_team" style="display:none;">
						<td>每队人数限制 <span class="required">*</span></td>
                        <td>
                            最少<?php echo  CHtml::activeTextField($model, 'game_group_end', array('class' => 'input-text','style'=>'width: 20px;')); ?>人/队 - 最多<?php echo  CHtml::activeTextField($model, 'game_group_star', array('class' => 'input-text','style'=>'width: 20px;'));?>人/队
                        </td>
					</tr>
					<tr>
						
                        <td width="12%;"><?php echo CHtml::activeLabelEx($model, 'game_money'); ?> <span class="required">*</span></td>
                        <td width="88%;">
                            <?php
                                echo CHtml::activeTextField($model, 'game_money', array('class' => 'input-text','style'=>'width:29.5%;')) ;
                            ?> 人/组/队<span class="msg">个人按人收费、双人按组收费、团队按队收费</span>
                        </td>
					</tr>
					<tr>
						<td style="width:12%;"><?php echo CHtml::activeLabelEx($model, 'isSignOnline'); ?> <span class="required">*</span></td>
                        <td style="width:38%;">
                            <?php echo CHtml::activeDropDownList($model, 'isSignOnline', Chtml::listData(BaseCode::model()->getCode(640), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        </td>
					</tr>
					<tr>
						<td style="width:12%;"><?php echo CHtml::activeLabelEx($model, 'game_check_way'); ?> <span class="required">*</span></td>
                        <td style="width:38%;">
                            <?php echo CHtml::activeDropDownList($model, 'game_check_way', Chtml::listData(BaseCode::model()->getCode(791), 'f_id', 'F_NAME'), array('prompt'=>'请选择')); ?>
                        </td>
					</tr>
					<tr>
                        <td>
                            <?php
                                echo CHtml::activeLabelEx($model, 'F_exclusive_ID'); $model->id=empty($model->id) ?0 : $model->id; 
                                if(!empty($model->F_exclusive_ID)){
                                    // if(is_numeric($model->F_exclusive_ID) || !is_numeric($model->F_exclusive_ID)){
                                        $tid = rtrim($model->F_exclusive_ID,',');
                                        $project_list = GameListData::model()->findAll('id in('.$tid.')');
                                    // }
                                }
                            ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeHiddenField($model, 'F_exclusive_ID', array('class' => 'input-text')); ?>
                            <span id="projectnot_box">
                                <?php if(!empty($project_list)){foreach($project_list as $v){?>
                                    <span class="label-box" id="project_item_<?php echo $v->id;?>" data-id="<?php echo $v->id;?>"><?php echo $v->game_data_name;?>
                                        <i onclick="fnDeleteProjectnot(this);"></i>
                                    </span>
                                <?php }}?>
                            </span>
                            <?php echo '<input id="projectNOT_add_btn" class="btn" type="button" value="添加项目">'; ?>
                        </td>
                    </tr>
                </table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
    </div><!--box-detail end-->
</div><!--box end-->
<script>
	var $d_game_list2= <?php echo json_encode($arr1)?>;
	var sname='<?php echo $model->game_project_name; ?>';
    selectOnchangProject('#GameListData_project_id');
    function selectOnchangProject(obj){
        var show_id=$(obj).val();
        var code,c1,c2;
        var code1;
        var g_html ='<option value="">请选择</option>';
        if (show_id>0) {
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
            $("#dis_num_team").hide();
            $("#dis_team").hide();
            $('#dis_number').hide();
        }
        else{
            $('#dis_number').hide();
            $("#dis_num_team").hide();
            $("#dis_team").hide();
        }
    };
	
	$('#GameListData_game_group_star').on('click', function(){
		WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd'});  // ,mixDate:'#F{$dp.$D(\'GameListData_game_group_end\')}'
	});
	$('#GameListData_game_group_end').on('click', function(){
		WdatePicker({startDate:'%y-%M-%D ',dateFmt:'yyyy-MM-dd'});  // ,maxDate:'#F{$dp.$D(\'GameListData_game_group_star\')}'
	});
	
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
	$("#GameListData_project_id").val($.dialog.data('project_id'));
	$("#GameListData_game_data_code").html($.dialog.data('game_data_code'));
	$("#GameListData_game_data_name").val($.dialog.data('game_data_name'));
	$("#GameListData_game_player_team").val($.dialog.data('game_player_team'));
	if($.dialog.data('game_dg_level')!=""){
		$.each($.dialog.data('game_dg_level').split(','),function(k,v){
			$("#GameListData_game_dg_level").find('input[value="'+v+'"]').click();
		})
	}
	$("#GameListData_game_sex").val($.dialog.data('game_sex'));
	$("#GameListData_game_group_star").val($.dialog.data('game_group_star'));
	$("#GameListData_game_group_end").val($.dialog.data('game_group_end'));
	$("#GameListData_number_of_member").val($.dialog.data('number_of_member'));
	$("#GameListData_game_money").val($.dialog.data('game_money'));
	$("#GameListData_isSignOnline").val($.dialog.data('isSignOnline'));
	$("#GameListData_game_mode").val($.dialog.data('game_mode'));
	$("#GameListData_game_check_way").val($.dialog.data('game_check_way'));
	
    api = $.dialog.open.api;	// 			art.dialog.open扩展方法
    if (!api) return;
    // 操作对话框
    api.button(
		{
			name:'保存',
			callback:function(){
				return add_chose();
			},
			focus:true
		},
		{
			name:'取消',
			callback:function(){
				$.dialog.data('game_data_name','');
				return true;
			}
		}
    );
});
function add_chose(){
	var project_id=$("#GameListData_project_id").val();
	var project_name=$("#GameListData_project_id>option:selected").text();
	var game_data_name=$("#GameListData_game_data_name").val();
	var game_player_team=$("#GameListData_game_player_team").val();
	var game_player_team_name=$("#GameListData_game_player_team>option:selected").text();
	var game_dg_level=[];
	var game_dg_level_name=[];
	$.each($("#GameListData_game_dg_level").find('input[type="checkbox"]:checked'),function(k){
		game_dg_level.push($("#GameListData_game_dg_level").find('input[type="checkbox"]:checked').eq(k).val());
		game_dg_level_name.push($("#GameListData_game_dg_level").find('input[type="checkbox"]:checked').eq(k).next().html());
	})
	var game_sex=$("#GameListData_game_sex").val();
	var game_sex_name=$("#GameListData_game_sex>option:selected").text();
	var game_group_star=$("#GameListData_game_group_star").val();
	var game_group_end=$("#GameListData_game_group_end").val();
	var number_of_member=$("#GameListData_number_of_member").val();
	var game_money=$("#GameListData_game_money").val();
	var isSignOnline=$("#GameListData_isSignOnline").val();
	var isSignOnline_name=$("#GameListData_isSignOnline>option:selected").text();
	var game_mode=$("#GameListData_game_mode").val();
	var game_mode_name=$("#GameListData_game_mode>option:selected").text();
	var game_check_way=$("#GameListData_game_check_way").val();
	if(project_id==""){
		we.msg('error', '请选择赛事项目', function() {
            we.loading('hide');
        });
        return false;
	}
	if(game_data_name==""){
		we.msg('error', '请填写比赛项目', function() {
            we.loading('hide');
        });
        return false;
	}
	if(game_player_team==""){
		we.msg('error', '请选择比赛方式', function() {
            we.loading('hide');
        });
        return false;
	}
	if(game_mode==""){
		we.msg('error', '请选择比赛方法', function() {
            we.loading('hide');
        });
        return false;
	}
	if(game_group_star==""){
		we.msg('error', '请填写最早出生日期', function() {
            we.loading('hide');
        });
        return false;
	}
	if(game_group_end==""){
		we.msg('error', '请填写最晚出生日期', function() {
            we.loading('hide');
        });
        return false;
	}
	if(number_of_member==""){
		we.msg('error', '请填写报名名额', function() {
            we.loading('hide');
        });
        return false;
	}
	if(game_money==""){
		we.msg('error', '请填写报名费用', function() {
            we.loading('hide');
        });
        return false;
	}
	if(isSignOnline==""){
		we.msg('error', '请选择报名方式', function() {
            we.loading('hide');
        });
        return false;
	}
	if(game_check_way==""){
		we.msg('error', '请选择报名审核方式', function() {
            we.loading('hide');
        });
        return false;
	}
	$.dialog.data('project_id', project_id);
	$.dialog.data('project_name', project_name);
	$.dialog.data('game_data_name', game_data_name);
	$.dialog.data('game_player_team', game_player_team);
	$.dialog.data('game_player_team_name', game_player_team_name);
	$.dialog.data('game_dg_level', game_dg_level.join());
	$.dialog.data('game_dg_level_name', game_dg_level_name.join());
	$.dialog.data('game_sex', game_sex);
	$.dialog.data('game_sex_name', game_sex_name);
	$.dialog.data('game_group_star', game_group_star);
	$.dialog.data('game_group_end', game_group_end);
	$.dialog.data('number_of_member', number_of_member);
	$.dialog.data('game_money', game_money);
	$.dialog.data('isSignOnline', isSignOnline);
	$.dialog.data('isSignOnline_name', isSignOnline_name);
	$.dialog.data('game_mode', game_mode);
	$.dialog.data('game_mode_name', game_mode_name);
	$.dialog.data('game_check_way', game_check_way);
	$.dialog.close();
 };
</script>
