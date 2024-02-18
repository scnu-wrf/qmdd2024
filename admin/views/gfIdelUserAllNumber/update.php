<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>号码生成</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
	<div class="box-detail">
		<table>
			<tr>
				<td colspan="4">号码生成（一次至多生成2000个号码）</td>
			</tr>
			<tr>
				<td>号码位数</td>
				<td colspan="3"><input class="input-text" id="num_length" oninput="value=value.replace(/[^\d]/g,'')" value="6"></td>
			</tr>
			<tr>
				<td>主号段（四位数或用1000-1009格式的范围表示）</td>
				<td colspan="3"><input class="input-text" id="primary_num" value="1000" maxlength=9 oninput="value=value.replace(/[^\d\-]+$/,'')"></td>
			</tr>
			<tr>
				<td>次号段</td>
				<td><input class="input-text" id="secondary_num_1" oninput="value=value.replace(/[^\d]+$/,'')"></td>
				<td>至</td>
				<td><input class="input-text" id="secondary_num_2" oninput="value=value.replace(/[^\d]+$/,'')"></td>
			</tr>
			<tr>
				<td>号码范围</td>
				<td id="num_range_1"></td>
				<td>至</td>
				<td id="num_range_2"></td>
			</tr>
		</table>
		<br>
		<br>
		<br>
		<div id="num_tab">
			
		</div>
		<div class="box-detail-bd">
			<div id="data_box">
			</div>
			<table class="mt15">
				<tr>
					<td>可执行操作：</td>
					<td colspan="3">
						<button id="show_num" class="btn btn-blue" onclick="return false;">显示</button>
						<button id="baocun" class="btn btn-blue" onclick="return false;">确认生成</button>
					</td>
				</tr>
			</table>
		</div>
		<div id="mask" style="position:fixed;width:100%;height:100%;top:0;background:rgba(0,0,0,0.4);text-align:center;color: #fff;line-height: 500px;display:none;">请稍等。。。</div>
	</div><!--box-table end-->
</div><!--box end-->
<script>
var pageSize=10;
$("#show_num").click(function(){
	show_num();
})
function show_num(){
	var all_num_arr=[];
	var content='';
	var num_length=$("#num_length").val();
	if(num_length<=4){
		alert("号码位数须大于4");
		return false;
	}
	if($("#primary_num").val()==""){
		alert("请输入主号段");
		return false;
	}
	if(/^(\d{4})\-(?!\1)(\d{4})$/.test($("#primary_num").val())){//“1000-1009”格式
		var a1=parseInt($("#primary_num").val().split("-")[0]);
		var a2=parseInt($("#primary_num").val().split("-")[1]);
		var primary_num_arr=[];
		for(var i=a1;i<=a2;i++){
			primary_num_arr.push(i.toString());
		}
		$.each(primary_num_arr,function(m,n){
			var primary_num=n;
			var secondary_num_1="";
			var secondary_num_2="";
			if($("#secondary_num_1").val().length!=num_length-primary_num.length){
				secondary_num_1=new Array(num_length-primary_num.length + 1).join("0");
				$("#secondary_num_1").val(secondary_num_1);
			}else{
				secondary_num_1=$("#secondary_num_1").val();
			}
			if($("#secondary_num_2").val().length!=num_length-primary_num.length){
				secondary_num_2=new Array(num_length-primary_num.length + 1).join("9");
				$("#secondary_num_2").val(secondary_num_2);
			}else{
				secondary_num_2=$("#secondary_num_2").val();
			}
			var num_range_1=primary_num+secondary_num_1;
			var num_range_2=primary_num+secondary_num_2;
			if(m==0){
				$("#num_range_1").html(num_range_1);
			}
			$("#num_range_2").html(num_range_2);
			var secondary_num_arr=[];
			for(var i=num_range_1;i<=num_range_2;i++){
				secondary_num_arr.push(i)
			}
			if(m==0){
				content+='<table><tr><td colspan="2">GF号码</td><td colspan="10" id="total_num"></td></tr><tr><td colspan="2">主号段</td><td colspan="10">次号段</td></tr>';
			}
			$.each(secondary_num_arr,function(k){
				if(k%pageSize==0){
					content+="<tr>"+
					"<td colspan='2'>"+primary_num+"</td>";
				}
				content+="<td>"+(Array(num_length-primary_num.length).join(0)+secondary_num_arr[k]).slice(-(num_length-primary_num.length))+"</td>"
				if((k%pageSize)==(pageSize-1)){
					content+="</tr>";
				}
				all_num_arr.push(primary_num+(Array(num_length-primary_num.length).join(0)+secondary_num_arr[k]).slice(-(num_length-primary_num.length)));
			});
			if(m==(primary_num_arr.length-1)){
				content+='</table>';
			}
		})
		$("#num_tab").html(content);
		$("#total_num").html("数量："+all_num_arr.length);
		var data_content='<div class="data_content"><input type="hidden" class="all_num_val" value="'+all_num_arr.join()+'"><input type="hidden" class="number_length" value="'+num_length+'"></div>';
		$("#data_box").html(data_content);
	}else{
		if(/^\d{4}$/.test($("#primary_num").val())){
			var primary_num_arr=$("#primary_num").val().split(",");
			$.each(primary_num_arr,function(m,n){
				var primary_num=n;
				var secondary_num_1="";
				var secondary_num_2="";
				if($("#secondary_num_1").val().length!=num_length-primary_num.length){
					secondary_num_1=new Array(num_length-primary_num.length + 1).join("0");
					$("#secondary_num_1").val(secondary_num_1);
				}else{
					secondary_num_1=$("#secondary_num_1").val();
				}
				if($("#secondary_num_2").val().length!=num_length-primary_num.length){
					secondary_num_2=new Array(num_length-primary_num.length + 1).join("9");
					$("#secondary_num_2").val(secondary_num_2);
				}else{
					secondary_num_2=$("#secondary_num_2").val();
				}
				var num_range_1=primary_num+secondary_num_1;
				var num_range_2=primary_num+secondary_num_2;
				if(m==0){
					$("#num_range_1").html(num_range_1);
				}
				$("#num_range_2").html(num_range_2);
				var secondary_num_arr=[];
				for(var i=num_range_1;i<=num_range_2;i++){
					secondary_num_arr.push(i)
				}
				if(m==0){
					content+='<table><tr><td colspan="2">GF号码</td><td colspan="10" id="total_num"></td></tr><tr><td colspan="2">主号段</td><td colspan="10">次号段</td></tr>';
				}
				$.each(secondary_num_arr,function(k){
					if(k%pageSize==0){
						content+="<tr>"+
						"<td colspan='2'>"+primary_num+"</td>";
					}
					content+="<td>"+(Array(num_length-primary_num.length).join(0)+secondary_num_arr[k]).slice(-(num_length-primary_num.length))+"</td>"
					if((k%pageSize)==(pageSize-1)){
						content+="</tr>";
					}
					all_num_arr.push(primary_num+(Array(num_length-primary_num.length).join(0)+secondary_num_arr[k]).slice(-(num_length-primary_num.length)));
				});
				if(m==(primary_num_arr.length-1)){
					content+='</table>';
				}
			})
			$("#num_tab").html(content);
			$("#total_num").html("数量："+all_num_arr.length);
			var data_content='<div class="data_content"><input type="hidden" class="all_num_val" value="'+all_num_arr.join()+'"><input type="hidden" class="number_length" value="'+num_length+'"></div>';
			$("#data_box").html(data_content);
		}else{
			alert("主号段须为4位数");
			return false;
		}
	}
	if(all_num_arr.length>2000){
		alert("一次至多生成2000个号码");
		return false;
	}
	return true;
}
$("#baocun").on("click",function(){
	if(show_num()){
		var all_num_val=$(".all_num_val").val();
		var number_length=$(".number_length").val();
		baocun(all_num_val,number_length);
	}
})
function baocun(all_num_val,number_length){
	var url="<?php echo $this->createUrl('create');?>";
	$.ajax({
		url: url,
		type: 'post',
		data: {all_num_val:all_num_val,number_length:number_length},
		dataType: 'json',
		beforeSend:function(){
			we.overlay("show");
		},
		success: function (d) {
			if(d.status==1){
				we.success(d.msg, d.redirect);
			}else{
				we.error(d.msg, d.redirect);
				return false;
			}
		}
	})
}
</script>