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
	a {
		cursor: pointer;
	}
</style>
<table id="iframe_gridtable" class="gridtable" style="width: 100%;border-spacing: 5px;">
<?php foreach($talkSensitive as $k=>$v){?>
<?php $m_message=json_decode(base64_decode($v["m_message"])); ?>
	<tr data-id="<?php echo $v["id"]; ?>">
		<td style="width:30%;padding:3px;"><?php echo $m_message->gfnich;?></td>
		<td style="width:30%;padding:3px;"><?php echo $m_message->content;?></td>
		<td style="width:40%;padding:3px;">聊天<div style="float: right;"><a onclick="updateSensitiveState(<?php echo $v["id"]; ?>,372,<?php echo $v["live_program_id"]; ?>,'<?php echo $v["m_message"];?>',<?php echo $v["s_gfid"]; ?>,<?php echo $v["s_gfaccount"]; ?>,'<?php echo $v["live_im_key"]; ?>')">通过</a>/<a onclick="updateSensitiveState(<?php echo $v["id"]; ?>,373)">不通过</a></div></td>
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
                url: "<?php echo $this->createUrl('sensitive_comment',array('id'=>$t_id)); ?>",
                dataType: 'json',
                success: function(data){
                    var s_html = '';
                    for(var i=0;i<data.length;i++){
                        if($('tr[data-id="'+data[i]['id']+'"]').length==0){
							var m_message=$.parseJSON(new Base64().decode(data[i]['m_message']));
                            s_html += '<tr data-id="'+data[i]['id']+'">'+
								'<td style="width:30%;padding:3px;">'+m_message.gfnich+'</td>'+
								'<td style="width:30%;padding:3px;">'+m_message.content+'</td>'+
								'<td style="width:40%;padding:3px;">聊天<div style="float: right;"><a class="pass" onclick="updateSensitiveState('+data[i]['id']+',372,'+data[i]['live_program_id']+',\''+m_message.content+'\','+data[i]['s_gfid']+','+data[i]['s_gfaccount']+',\''+data[i]['live_im_key']+'\')">通过</a>/<a onclick="updateSensitiveState('+data[i]['id']+',373)">不通过</a></div></td>'+
							'</tr>'
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
<script type="text/javascript" src="../../js/mqttws31.js"></script>
<script type="text/javascript" src="../../js/notify.js"></script>
<script type="text/javascript" src="../../js/crypto-js.js"></script>
<script type="text/javascript" src="../../js/base64_1.js"></script>
<script>
var client_l;
	function updateSensitiveState(id,state,live_program_id,content,s_gfid,s_gfaccount,live_im_key){
       	$.ajax({
			type: "get",
			url:'<?php echo $this->createUrl("VideoLive/UpdateSensitiveState");?>',
            data:{id:id,state:state,admin_id:"<?php echo $_SESSION['admin_id'];?>",admin_name:"<?php echo $_SESSION['admin_name'];?>"},
			dataType:"json",
			error: function(request) {
				parent.we.msg('minus','审核失败');
			},
			success: function(data) {
				if(data.error==0){
					parent.we.msg('minus','审核成功');
					$("tr[data-id='"+id+"']").remove();
					$("#to_be_audited_count",parent.document).html(parseInt($("#to_be_audited_count",parent.document).html())-1);
					if(state==372){
						var time = new Date().getTime().toString();
						ClientId="C_"+time;
						r_topic="SLP"+live_program_id;
						s_topic="SLP"+live_program_id;
						client_l = new Websocket();
						var sendBytes={};
						var packType=20;
						sendBytes.packType=intToByte(packType,4);
						var s_g=20;
						sendBytes.s_g=intToByte(s_g,4);
						var buf_timesmap=time;
						sendBytes.buf_timesmap=stringToByte(buf_timesmap);
						var lparam_len=id.toString().length;
						sendBytes.lparam_len=intToByte(lparam_len,4);
						var lparam=id.toString();
						sendBytes.lparam=stringToByte(lparam);
						var r_gfid=live_program_id;
						sendBytes.r_gfid=intToByte(r_gfid,4);
						var r_gfaccount=0;
						sendBytes.r_gfaccount=intToByte(r_gfaccount,4);
						sendBytes.s_gfid=intToByte(s_gfid,4);
						sendBytes.s_gfaccount=intToByte(s_gfaccount,4);
						var msg_type=31;
						sendBytes.msg_type=intToByte(msg_type,4);
						var msg_id_len=id.toString().length;
						sendBytes.msg_id_len=intToByte(msg_id_len,4);
						var msg_id=id.toString();
						sendBytes.msg_id=stringToByte(msg_id);
						var device_type=7;
						sendBytes.device_type=intToByte(device_type,4);
						var msg_content=AES_encode(content,live_im_key.slice(0,16),live_im_key.slice(-16));
						sendBytes.msg_content=stringToByte(msg_content);
						var msg_len=msg_content.length;
						sendBytes.msg_len=intToByte(msg_len,4);
						var buf_len=61+msg_id_len+msg_len+lparam_len;//包长度
						sendBytes.buf_len=intToByte(buf_len,4);
						var array=sendBytes.packType
						.concat(sendBytes.s_g)
						.concat(sendBytes.buf_len)
						.concat(sendBytes.buf_timesmap)
						.concat(sendBytes.lparam_len)
						.concat(sendBytes.lparam)
						.concat(sendBytes.r_gfid)
						.concat(sendBytes.r_gfaccount)
						.concat(sendBytes.s_gfid)
						.concat(sendBytes.s_gfaccount)
						.concat(sendBytes.msg_type)
						.concat(sendBytes.msg_len)
						.concat(sendBytes.msg_id_len)
						.concat(sendBytes.msg_id)
						.concat(sendBytes.device_type)
						.concat(sendBytes.msg_content);
						client_l.connect(function(){});
						setTimeout(function(){
							client_l.sendMessage(array);
						},1000);
					}
				}else{
					parent.we.msg('minus','审核失败');
				}
            }
		});
   	}
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

//AES加密
function AES_encode(str,key,iv){
	var b=CryptoJS.enc.Utf8.parse(key);
	var a=CryptoJS.enc.Utf8.parse(iv);
	srcs=CryptoJS.enc.Utf8.parse(str);
	var c=CryptoJS.AES.encrypt(srcs,b,{iv:a,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.Pkcs7});
	return c.ciphertext.toString().toUpperCase();
}
//AES解密
function AES_decode(str,key,iv){
	var c=CryptoJS.enc.Utf8.parse(key);
	var b=CryptoJS.enc.Utf8.parse(iv);
	var g=CryptoJS.enc.Hex.parse(str);
	var d=CryptoJS.enc.Base64.stringify(g);
	var a=CryptoJS.AES.decrypt(d,c,{iv:b,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.Pkcs7});
	var f=a.toString(CryptoJS.enc.Utf8);
	return f.toString();
}
</script>