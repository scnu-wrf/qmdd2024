<style>
	::-webkit-scrollbar  
	{  
		width: 1px;  
		height: 1px;  
		background-color: #F5F5F5;  
	}  
	::-webkit-scrollbar-track  
	{  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		background-color: #F5F5F5;  
	}  
	::-webkit-scrollbar-thumb  
	{  
		-moz-border-radius: 10px;  
		-webkit-border-radius: 10px;  
		-o-border-radius: 10px;  
		-ms-border-radius: 10px;  
		border-radius: 10px;  
		-moz-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		-o-box-shadow:inset 0 0 6px rgba(0,0,0,0); 
		-ms-box-shadow: inset 0 0 6px rgba(0,0,0,0); 
		box-shadow: inset 0 0 6px rgba(0,0,0,0);  
		background-color: #ccc;  
	}
</style>
<table id="iframe_gridtable" class="gridtable" style="width: 100%;border-spacing: 5px;">
	<?php $gf_brow_data=GfBrowData::model()->findAll();?>
	<?php foreach ($talkRecord as $k=>$v){?>
		<?php $m_message=json_decode(base64_decode($v["m_message"])); ?>
		<tr id="tr_<?php echo $v["id"]; ?>">
			<td style="width:15%;padding: 5px 0;"><img src="<?php echo $m_message->gficon; ?>" style="width: 30px;height: 30px;border-radius: 50%;" title="<?php echo $m_message->gfnich; ?>"></td>
			<td style="width:50%;padding: 5px 0;">
				<?php if($v["m_type"]==31){
					echo $m_message->content;
				}else if($v["m_type"]==38){
					$brow_pic="";
					foreach($gf_brow_data as $m=>$n){
						if($m_message->content==$n->id){
							$brow_pic=BasePath::model()->get_www_path().(empty($n->brow_img)?$n->brow_cover_map:$n->brow_img);
							break;
						}
					}
					if(empty($brow_pic)){
						echo "表情已删除";
					}else{
						echo '<img src="'.$brow_pic.'" style="width: 40px;height: 40px;">';
					}
				}else if($v["m_type"]==39){
					echo '<a href="'.$m_message->content.'" target="_blank"><img src="'.$m_message->content.'" style="width: 50px;height: 50px;"></a>';
				}?>
			</td>
			<td style="width:35%;text-align:center;"><?php echo date("Y/m/d H:i",strtotime($v["s_time"]));?></td>
		</tr>
	<?php }?>
</table>
<script>
    $(function(){
        var rewardHeight = document.getElementById('iframe_gridtable').clientHeight;
        document.documentElement.scrollTop = rewardHeight;
        setInterval(function() {
            $.ajax({
                type: 'post',
                url: "<?php echo $this->createUrl('talk_comment',array('id'=>$t_id)); ?>",
                dataType: 'json',
                success: function(data){
                    var s_html = '';
                    for(var i=0;i<data.length;i++){
                        if($('#tr_'+data[i]['id']).length==0){
							var m_message=$.parseJSON(new Base64().decode(data[i]['m_message']));
                            s_html += 
                                '<tr id="tr_'+data[i]['id']+'">'+
                                    '<td style="width:15%;padding: 5px 0;"><img src="'+m_message.gficon+'" style="width: 30px;height: 30px;border-radius: 50%;" title="'+m_message.gfnich+'"></td>'+
                                    '<td style="width:50%;padding: 5px 0;">';
									if(data[i]['m_type']==31){
										s_html+=m_message.content;
									}else if(data[i]['m_type']==38){
										var brow_pic="";
										<?php foreach($gf_brow_data as $m=>$n){?>
											if(m_message.content==<?php echo $n->id;?>){
												brow_pic='<?php echo BasePath::model()->get_www_path().(empty($n->brow_img)?$n->brow_cover_map:$n->brow_img);?>';
											}
										<?php }?>
										if(brow_pic==""){
											s_html+="表情已删除";
										}else{
											s_html+='<img src="'+brow_pic+'" style="width: 40px;height: 40px;">';
										}
									}else if(data[i]['m_type']==39){
										s_html+='<a href="'+m_message.content+'" target="_blank"><img src="'+m_message.content+'" style="width: 50px;height: 50px;"></a>';
									}
									s_html+='</td>'+
                                    '<td style="width:35%;text-align:center;">'+new Date(data[i]['s_time']).format("yyyy/MM/dd hh:mm")+'</td>'+
                                '</tr>';
                        }
                    }
                    if(s_html!=''){
                        $('#iframe_gridtable').append(s_html);
                        document.documentElement.scrollTop = rewardHeight;
                    }
                }
            });
        }, 5000);
    });
</script>
<script>
Date.prototype.format = function(format){
	if(isNaN(this.getMonth())){
		return '';
	}
	if(!format){
		format = 'yyyy-MM-dd hh:mm:ss';
	}
	var o = {
		//month
		"M+" : this.getMonth() + 1,
		//day
		"d+" : this.getDate(),
		//hour
		"h+" : this.getHours(),
		//minute
		"m+" : this.getMinutes(),
		//second
		"s+" : this.getSeconds(),
		//quarter
		"q+" : Math.floor((this.getMonth() + 3) / 3),
		//millisecond
		"s" : this.getMilliseconds()
	};
	if(/(y+)/.test(format)){
		format = format.replace(RegExp.$1,(this.getFullYear() + "").substr(4 - RegExp.$1.length));
	}
	for(var k in o){
		if(new RegExp("(" + k + ")").test(format)){
			format = format.replace(RegExp.$1,RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
		}
	}
	return format;
};
</script>