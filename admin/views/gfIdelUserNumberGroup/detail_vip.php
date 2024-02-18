<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>VIP号码详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table id="num_tab">
					<?php 
						$mode_list=GfIdelUserVipmode::model()->findAll('f_len='.$model->number_length .' order by f_lvevl');
						$viplev_list=GfIdelUserNumberLevel::model()->findAll();
						$all_number_list=GfIdelUserAllNumber::model()->findAll('group_id='.$model->id);
						foreach($all_number_list as $k=>$v){
							$all_num[$k]["account"]=$v["account"];
							$all_num[$k]["id"]=$v["id"];
							$all_num[$k]["f_vip"]=$v["f_vip"];
							$all_num[$k]["is_use"]=$v["is_use"];
							$all_num[$k]["f_vlevel"]=$v["f_vlevel"];
							if($v["f_vip"]==1){
								foreach($viplev_list as $m=>$n){
									if($n["id"]==$v["f_vlevel"]){
										$all_num[$k]["level_name"]=$n["level_name"];
									}
								}
							}else{
								$all_num[$k]["level_name"]="";
							}
						}
						foreach($mode_list as $k=>$v){
							$selected_mode[$k]["mode_id"]=$v["id"];
							$selected_mode[$k]["mode_name"]=$v["f_mode"];
							$selected_mode[$k]["mode_rule"]=base64_encode($v["f_rule"]);
							foreach($viplev_list as $m=>$n){
								if($n["id"]==$v["f_lvevl"]){
									$selected_mode[$k]["level_id"]=$n["id"];
									$selected_mode[$k]["level_name"]=$n["level_name"];
									break;
								}
							}
						}
					?>
					<tr>
						<td>号码星级</td>
						<td>类型</td>
						<td colspan=10>号码数量：<?php echo $model->vip_count;?>个（灰色底为已注册）</td>
					</tr>
				</table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
	var all_num_arr=$.parseJSON('<?php echo json_encode($all_num)?>');
	var selected_mode=$.parseJSON('<?php echo json_encode($selected_mode)?>');
	var match_arr=[];
	$(function(){
		var content="";
		$(".new_tr").remove();
		var content="";
		$(".new_mode_tr").remove();
		$.each(selected_mode,function(k,v){
			var match_obj={};
			match_obj["level_id"]=v.level_id;
			match_obj["level_name"]=v.level_name;
			match_obj["mode_id"]=v.mode_id;
			match_obj["mode_name"]=v.mode_name;
			var Reg=eval(new Base64().decode(v["mode_rule"]));
			var match_number=[];
			$.each(all_num_arr,function(m,n){
				if(Reg.test(n["account"])){
					var match_number_o={};
					match_number_o["account"]=n["account"];
					match_number_o["id"]=n["id"];
					match_number_o["is_use"]=n["is_use"];
					match_number.push(match_number_o);
				}
			})
			if(match_number.length>0){
				match_obj["match_number"]=match_number;
				match_arr.push(match_obj);
				content+='<tr class="new_mode_tr"><td>'+v.level_name+'</td>'+
				'<td>'+v.mode_name+'</td>';
				content+='<td colspan="10">';
				$.each(match_number,function(m,n){
					content+='<span style="margin: 0 5px;display: inline-block;'+(n.is_use==1?'background:#ddd':'')+'">'+n.account+'</span>';
				})
				content+='</td>';
			}
		})
		$("#num_tab").append(content);
	})
</script>