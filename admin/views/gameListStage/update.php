<div class="box">
    <div id="t0" class="box-title c">
        <h1>当前界面：赛事 》赛事管理 》赛事列表 》赛程/成绩 》<a class="nav-a">添加赛段</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回列表</a></span>
    </div><!--box-title end-->
    <div id="t1" class="box-detail">
        <?php $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table>
                    <tr>
                        <td width="12%"><?php echo $form->labelEx($model, 'game_name'); ?></td>
                        <td colspan=6><?php echo $game_name;?><?php echo $form->hiddenField($model, 'game_id', array('class' => 'input-text', 'value'=>$game_id)); ?></td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'project_id'); ?></td>
                        <td colspan=6>						
                            <?php echo $form->dropDownList($model, 'project_id', Chtml::listData($project_list, 'project_id', 'project_name'), array('prompt'=>'请选择','onchange'=>'changeProjectid(this);')); ?>
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo $form->labelEx($model, 'game_data_id'); ?></td>
                        <td colspan=6>
							<select onchange="changeDataid(this);" name="GameListStage[game_data_id]" id="GameListStage_game_data_id">
								<option value="">请选择</option>
							</select>
                        </td>
                    </tr>
                    <tr>
                        <td>比赛方法</td>
                        <td colspan=6 id="game_mode_name"></td>
                    </tr>
                    <tr>
                        <td colspan=6>赛段设置</td>
						<td><input onclick="fnAddProgram();" class="btn" type="button" value="添加行"></td>
                    </tr>
				</table>
				<table style="table-layout:auto;" id="program_list" data-num="new">
                    <tr class="table-title">
                        <td width="12%"><?php echo $form->hiddenField($model, 'programs_list'); ?>赛段编码</td>
                        <td>赛段名称</td>
                        <td>赛制</td>
                        <td>总签位数</td>
                        <td>总组数</td>
                        <td>每组签位数</td>
                        <td>操作</td>
                    </tr>
					<?php if(!empty($programs)){?>
					<?php foreach($programs as $k=>$v){?>
					<tr>
                        <td><?php echo $v->stage_code;?></td>
                        <td><input type="hidden" class="input-text" name="programs_list[<?php echo $v->id;?>][id]" value="<?php echo $v->id;?>" /><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[<?php echo $v->id;?>][stage_name]" value="<?php echo $v->stage_name;?>"></td>
                        <td>
						<?php echo downList(array_merge(BaseCode::model()->getCode(985),BaseCode::model()->getCode(988)),'f_id','F_NAME','programs_list['.$v->id.'][game_format]','onchange="fnUpdateProgram();"',$v->game_format); ?></td>
                        <td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[<?php echo $v->id;?>][pick_amount]" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=this.value.replace(/\D/g,'')" placeholder="输入数字" value="<?php echo $v->pick_amount;?>"></td>
                        <td><input onchange="fnUpdateProgram();" class="input-text group_amount" name="programs_list[<?php echo $v->id;?>][group_amount]" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=this.value.replace(/\D/g,'')" placeholder="输入数字" value="<?php echo $v->group_amount;?>"></td>
                        <td><input onchange="fnUpdateProgram();" class="input-text pick_per_group" name="programs_list[<?php echo $v->id;?>][pick_per_group]" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=this.value.replace(/\D/g,'')" placeholder="输入数字" value="<?php echo $v->pick_per_group;?>"></td>
                        <td><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
                    </tr>
					<?php }?>
					<?php } else { ?>
                    <tr>
                        <td><span style="color:#7a7a7a;text-align:center;">系统生成</span></td>
                        <td><input type="hidden" class="input-text" name="programs_list[new][id]" value="null" /><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[new][stage_name]" value=""></td>
                        <td>
						<?php echo downList(array_merge(BaseCode::model()->getCode(985),BaseCode::model()->getCode(988)),'f_id','F_NAME','programs_list[new][game_format]','onchange="fnUpdateProgram();"'); ?></td>
                        <td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list[new][pick_amount]" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=this.value.replace(/\D/g,'')" placeholder="输入数字" value=""></td>
                        <td><input onchange="fnUpdateProgram();" class="input-text group_amount" name="programs_list[new][group_amount]" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=this.value.replace(/\D/g,'')" placeholder="输入数字" value=""></td>
                        <td><input onchange="fnUpdateProgram();" class="input-text pick_per_group" name="programs_list[new][pick_per_group]" onkeyup="this.value=this.value.replace(/\D/g,'')" onblur="this.value=this.value.replace(/\D/g,'')" placeholder="输入数字" value=""></td>
                        <td><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td>
                    </tr>
					<?php }?>
				</table>
				<?php echo $form->error($model, 'programs_list', $htmlOptions = array()); ?>
				<table>
                    <tr>
                        <td width="12%">操作</td>
                        <td colspan=6>
							<?php echo show_shenhe_box(array('baocun'=>'保存'));?>
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
	changeProjectid($("#GameListStage_project_id"));
    function changeProjectid(obj){
        var val = $(obj).val();
        var s_html = '<option value>请选择</option>';
        if(val > 0){
            var pr = '<?php echo $data_id; ?>';
            $.ajax({
                type: 'post',
                url: '<?php echo $this->createUrl('GameSignList/getDataByProject'); ?>&game_id=<?php echo $game_id;?>&project_id='+val,
                dataType: 'json',
                success: function(data) {
                    for(var i=0;i<data[0].length;i++){
                        s_html += '<option value="'+data[0][i]['id']+'" '+((data[0][i]['id']==pr) ? 'selected game_mode="'+data[0][i]['game_mode']+'" game_mode_name="'+data[0][i]['game_mode_name']+'">' : ' game_mode="'+data[0][i]['game_mode']+'" game_mode_name="'+data[0][i]['game_mode_name']+'">')+data[0][i]['game_data_name']+'</option>';
                    }
                    $('#GameListStage_game_data_id').html(s_html);
					changeDataid($('#GameListStage_game_data_id'));
                }
            });
        }
        else{
            $('#GameListStage_game_data_id').html(s_html);
        }
    }
	var game_mode = '';
	var game_mode_name = '';
	function changeDataid(obj){
		game_mode = $(obj).find("option:selected").attr("game_mode");
		game_mode_name = $(obj).find("option:selected").attr("game_mode_name");
		$("#game_mode_name").html(game_mode_name);
		if(game_mode==662){
			$(".group_amount").attr("disabled","disabled").val("");
			$(".pick_per_group").attr("disabled","disabled").val("");
		}
	}
	
	
// 添加删除更新节目
var $program_list=$('#program_list');
var $VideoLive_programs_list=$('#GameListStage_programs_list');
var fnAddProgram=function(){
    var num=$program_list.attr('data-num')+1;
	var $content=$('<tr><td><span style="color:#7a7a7a;text-align:center;">系统生成</span></td><td><input type="hidden" class="input-text" name="programs_list['+num+'][id]" value="null" /><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][stage_name]" value=""></td><td><?php echo downList(array_merge(BaseCode::model()->getCode(985),BaseCode::model()->getCode(988)),"f_id","F_NAME","programs_list['+num+'][game_format]","onchange=\'fnUpdateProgram();\'"); ?></td><td><input onchange="fnUpdateProgram();" class="input-text" name="programs_list['+num+'][pick_amount]" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onblur="this.value=this.value.replace(/\\D/g,\'\')" placeholder="输入数字" value=""></td><td><input onchange="fnUpdateProgram();" class="input-text group_amount" name="programs_list['+num+'][group_amount]" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onblur="this.value=this.value.replace(/\\D/g,\'\')" placeholder="输入数字" value=""'+(game_mode==662?' disabled':'')+'></td><td><input onchange="fnUpdateProgram();" class="input-text pick_per_group" name="programs_list['+num+'][pick_per_group]" onkeyup="this.value=this.value.replace(/\\D/g,\'\')" onblur="this.value=this.value.replace(/\\D/g,\'\')" placeholder="输入数字" value=""'+(game_mode==662?' disabled':'')+'></td><td><input onclick="fnDeleteProgram(this);" class="btn" type="button" value="删除"></td></tr>');
    $program_list.append($content);
    $program_list.attr('data-num',num);
	fnUpdateProgram();
};

var fnDeleteProgram=function(op){
    $(op).parent().parent().remove();
    fnUpdateProgram();
};
var fnUpdateProgram=function(){
    var isEmpty=true;
    $program_list.find('.up_title').each(function(k){
        if($(this).val()==''){
            isEmpty=true;
			return false;
        } else{
			isEmpty=false;
        }
    });
	if(!isEmpty){
		$program_list.find('.up_source').each(function(){
			if($(this).val()=='null'){
				isEmpty=true;
				return false;
			} else{
				isEmpty=false;
			}
		});
	}
    if(!isEmpty){
        $VideoLive_programs_list.val('1').trigger('blur');
    }else{
        $VideoLive_programs_list.val('').trigger('blur');
    }
};
</script>
