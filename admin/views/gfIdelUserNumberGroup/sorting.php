<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>号码分类</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table id="num_tab">
					<tr>
						<td colspan="12">号码区间：<?php echo $model->number_range_start;?>-<?php echo $model->number_range_end;?></td>
					</tr>
					<tr>
						<td colspan="2">号码列表</td>
						<td colspan="3">普通号：<?php echo $model->nomal_count;?>个</td>
						<td colspan="7">VIP号：<?php echo $model->vip_count;?>个</td>
					</tr>
					<tr>
						<td colspan="2">主号段</td>
						<td colspan="10">次号段</td>
					</tr>
				</table>
				<table class="table-title">
					<tr>
						<td>添加VIP号</td>
					</tr>
				</table>
				<table>
					<tr>
						<td>号码星级</td>
						<td colspan='10'>类型</td>
					</tr>
					<?php 
						$mode_list=GfIdelUserVipmode::model()->findAll('f_len='.$model->number_length .' order by f_lvevl');
						$viplev_list=GfIdelUserNumberLevel::model()->findAll();
						$all_number_list=GfIdelUserAllNumber::model()->findAll('group_id='.$model->id);
						foreach($all_number_list as $k=>$v){
							$all_num[$k]["account"]=$v["account"];
							$all_num[$k]["id"]=$v["id"];
							$all_num[$k]["f_vip"]=$v["f_vip"];
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
						foreach($viplev_list as $m=>$n){
					?>
					<tr>
						<td value="<?php echo $n["id"] ?>"><?php echo $n["level_name"] ?></td>
						<td colspan='10'>
					<?php
							foreach($mode_list as $k=>$v){
								if($v['f_lvevl']==$n['id']){
					?>
						<input class="input-check" style="display:inline-block;width:20px;" id="GfIdelUserNumberGroup_f_mode_<?php echo $v["id"] ?>" value="<?php echo $v["id"] ?>" type="checkbox" data-rule="<?php echo $v["f_rule"] ?>" checked><label for="GfIdelUserNumberGroup_f_mode_<?php echo $v["id"] ?>"><?php echo $v["f_name"] ?></label>
						<?php }}?>
						</td>
					</tr>
					<?php } ?>
				</table>
				<button id="show_num" class="btn btn-blue" onclick="return false;">显示选号</button>
				<table class="table-title">
					<tr>
						<td>VIP号列表</td>
					</tr>
				</table>
				<table id="number_list">
					<tr>
						<td>号码星级</td>
						<td>类型</td>
						<td colspan="10">号码</td>
						<td colspan="2">是否添加</td>
					</tr>
					<!--<tr>
						<td>V1</td>
						<td>AAAAAA</td>
						<td colspan="10"></td>
						<td colspan="2"></td>
					</tr>-->
				</table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
		<div id="operate" class="mt15" style="text-align:center;">
			<button id="baocun" class="btn btn-blue">确认分类</button>
            <button class="btn" type="button" onclick="we.back();">取消</button>
        </div>
    </div><!--box-detail end-->
</div><!--box end-->
<script>
	var pageSize=10;
	var all_num_arr=$.parseJSON('<?php echo json_encode($all_num)?>');
	$(function(){
		var num_length=<?php echo $model->number_length;?>;
		var number_range_start='<?php echo $model->number_range_start;?>';
		var content="";
		$(".new_tr").remove();
		$.each(all_num_arr,function(k,v){
			if(k%pageSize==0){
				content+="<tr class='new_tr'>"+
				"<td colspan='2'>"+v["account"].substr(0,4)+"</td>";
			}
			if(v["f_vip"]==1){
				content+='<td style="position:relative;background:pink;">'+v["account"].substr(4)+'<span style="position:absolute;color:red;font-size:smaller;top: 0;right: 5px;">'+v["level_name"]+'</span></td>';
			}else{
				content+="<td>"+v["account"].substr(4)+"</td>";
			}
			if((k%pageSize)==(pageSize-1)){
				content+="</tr>";
			}
		});
		$("#num_tab").append(content);
	})
	var selected_mode=[];
	var match_arr=[];
	$('#show_num').click(function(){
		if(!show_num()){
			alert("无匹配的号码");
		}
	})
	function show_num(){
		selected_mode=[];
		match_arr=[];
		$(".input-check").each(function(k){
			if($(".input-check").eq(k).is(":checked")){
				var mode={};
				mode["level_id"]=$(".input-check").eq(k).parent('td').prev('td').attr('value');
				mode["level_name"]=$(".input-check").eq(k).parent('td').prev('td').html();
				mode["mode_id"]=$(".input-check").eq(k).val();
				mode["mode_name"]=$(".input-check").eq(k).next('label').html();
				mode["mode_rule"]=$(".input-check").eq(k).attr('data-rule');
				selected_mode.push(mode);
			}
		});
		var content="";
		$(".new_mode_tr").remove();
		$.each(selected_mode,function(k,v){
			var match_obj={};
			match_obj["level_id"]=v.level_id;
			match_obj["level_name"]=v.level_name;
			match_obj["mode_id"]=v.mode_id;
			match_obj["mode_name"]=v.mode_name;
			var Reg=eval(v.mode_rule);
			var match_number=[];
			$.each(all_num_arr,function(m,n){
				if(Reg.test(n["account"])){
					var match_number_o={};
					match_number_o["account"]=n["account"];
					match_number_o["id"]=n["id"];
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
				content+='<td colspan="2"><div style="cursor: pointer;"><img src="https://www.gfinter.net/GF/resources/images/admin/center/member_a22__r1_c1.png" style="display: inline;"><img src="https://www.gfinter.net/GF/resources/images/admin/center/member_a22__r1_c3.png" style="display: none;"></div></td></tr>';
			}
		})
		if(match_arr.length==0){
			return false;
		}else{
			$("#number_list").append(content);
			// $("#number_list td img").click(function(){
				// $(this).parents("td").children().children("img").toggle();
			// })
			return true;
		}
	}
	$("#baocun").on("click",function(){
		if(show_num()){
			if(match_arr.length==0){
				if(confirm("无匹配的号码，是否标为已分类？")){
					Is_category();
				}
			}else{
				baocun(JSON.stringify(match_arr));
			}
		}
	})
	function baocun(match_arr){
		var url="<?php echo $this->createUrl('saveSorting');?>";
		$.ajax({
			url: url,
			type: 'post',
			data: {match_arr:match_arr,group_id:'<?php echo $model->id;?>'},
			dataType: 'json',
			beforeSend:function(){
				we.overlay("show");
			},
			success: function (d) {
				if(d.status==1){
					we.success(d.msg, d.redirect);
				}else{
					we.error(d.msg, d.redirect);
				}
			}
		})
	}
	function Is_category(){
		var url="<?php echo $this->createUrl('is_category');?>&group_id=<?php echo $model->id;?>&ret=1";
		$.ajax({
			url: url,
			type: 'get',
			dataType: 'json',
			beforeSend:function(){
				we.overlay("show");
			},
			success: function (d) {
				if(d.status==1){
					we.success(d.msg, d.redirect);
				}else{
					we.error(d.msg, d.redirect);
				}
			}
		})
	}
</script>