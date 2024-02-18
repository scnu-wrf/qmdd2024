<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>号码详情</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
        <div class="box-detail-bd">
            <div style="display:block;" class="box-detail-tab-item">
                <table id="num_tab">
					<tr>
						<td colspan="2">GF号码</td>
						<td colspan="10">数量：<?php echo $model->total_count;?>个</td>
					</tr>
					<?php 
						$mode_list=GfIdelUserVipmode::model()->findAll();
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
					?>
					<tr>
						<td colspan="2">主号段</td>
						<td colspan="10">次号段</td>
					</tr>
				</table>
            </div><!--box-detail-tab-item end-->
        </div><!--box-detail-bd end-->
        <?php $this->endWidget(); ?>
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
</script>