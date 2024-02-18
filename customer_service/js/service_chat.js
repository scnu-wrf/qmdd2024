
var sender;
var R_gfId;//接收者GF_ID
var R_gfAccount;//接收者GF_ACCOUNT
var client;
var cs_id=0;
var right_index=0;
var io_public="/gw/main.php?device_type=7&c=io&a=io_public";
var io_customer_service="/gw/main.php?device_type=7&c=io&a=io_customer_service";
var io_gfim="/gw/main.php?device_type=7&c=io&a=io_gfim"
$(function(){
	if(sessionStorage.getItem("visit_id")==null){
		get_rsa_key();
	}else{
		visit_id=sessionStorage.getItem("visit_id");
		login_sign_key=sessionStorage.getItem("login_sign_key");
		msg_key=sessionStorage.getItem("msg_key");
		visitId=visit_id;
		loginSignKey=login_sign_key;
		msgKey=msg_key;
		init();
	}
	right_index=sessionStorage.getItem("right_index");
	gfId=admin_gfid;
	gfAccount=admin_gfaccount;
	gfName=admin_name;
	r_topic='SACS'+adminid;//订阅主题
	client = new Websocket();
	client.connect(messageArrived);
});
var rsa_key='';
var aes_key='';
var jsencrypt = new JSEncrypt();
function get_rsa_key(){
	var time_stamp=nowTimeStamp.getTime();
	var map=new Map();
	map.put("action","get_rsa_key");
	$.ajaxloading({
		url:io_public,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e)
			if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
			rsa_key=new Base64().decode(e.key);
			aes_key=md5(time_stamp);
			jsencrypt.setPublicKey(rsa_key);
			customerServiceLogin();
		}
	})
}

var visitId='';
var loginSignKey='';
var msgKey='';
//客服登录记录
var visit_id='';
var login_sign_key='';
var msg_key='';
function customerServiceLogin(){
	var time_stamp=nowTimeStamp.getTime();
	var map=new Map();
	map.put("ts",time_stamp);
	map.put("adminid",adminid);
	map.put("action","customer_service_login");
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
			var datas=e.datas;
			visit_id=datas.id;
			login_sign_key=datas.login_sign_key;
			msg_key=e.msg_key;
			visitId=visit_id;
			loginSignKey=login_sign_key;
			msgKey=msg_key;
			sessionStorage.setItem("visit_id", visit_id);
			sessionStorage.setItem("login_sign_key", login_sign_key);
			sessionStorage.setItem("msg_key", msg_key);
			init();
		}
	})
}
function init(){
	$("#pic-select-form input[name='gfid']").val(visit_id);
	get_not_close_consulting_by_admin();
	getAdminInfo();//获取客服账号信息
	getFastReplyGroupList();//获取快捷语分组列表
	getFastReplyList(-1);//获取所有分组的快捷语列表
	getProblemTypeList();
	getKnowledgeBaseList();
	getAllFastReplyList();
	getServiceWaitList(1)
	get_gf_brow_list();
	$(".query_nav span").eq(right_index).trigger("click");
}
var gf_gif={};
var brow_list=[];
function get_gf_brow_list(){
	var time_stamp=nowTimeStamp.getTime();
	var map=new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_gf_brow_list');
	$.ajaxloading({
		url:io_public,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			console.log(e)
			brow_list=e.datas;
			var content='';
			$.each(brow_list,function(k,v){
				$.each(v.brow_data,function(m,n){
					if(v.brow_type==1){
						gf_gif[n.id]='<img title="'+n.brow_img_label+'" value="'+n.id+'" src="'+n.brow_img+'" style="width:40px;height:40px;">';
					}else{
						gf_gif[n.id]='<img title="'+n.brow_img_label+'" value="'+n.id+'" src="'+n.brow_img+'" style="width:20px;height:20px;">';
					}
					
				})
			})
			for(i in gf_gif){
				$(".emotion_box").append(gf_gif[i])
			}
		}
	})
}
//获取未关闭咨询窗口
function get_not_close_consulting_by_admin(){
	var time_stamp=nowTimeStamp.getTime();
	var map=new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_not_close_consulting_by_admin');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
			$.each(e.datas,function(k,info){
				gfids.push(info.s_gfid);
				csIds.push(info.cs_id);
				$(".client_list").append('<div class="client" cs_id="'+info.cs_id+'" R_gfId="'+info.s_gfid+'" R_gfAccount="'+info.s_gf_account+'"><span class="gf_account">'+(info.s_gf_account==0?'匿名用户':info.s_gf_account)+'</span></div>');
				$('.serv_input').before('<div class="serv_content" cs_id="'+info.cs_id+'" r_gfid="'+info.s_gfid+'" style="display:none"></div>');
			});
			$(".serv_left_tit div").html("会话中("+$(".client").length+")");
		}
	})
}
//获取客服账号信息
var access;
var greet;
function getAdminInfo(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_admin_info');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var data=e.datas;
			var is_on_line=data[0].is_on_line;
			var content="";
			$("#service_head").attr("src",data[0].admin_gftx);
			$("#service_name").text(data[0].admin_gfnick);
			$("#club_name span").text(data[0].club_name);
			$("#admin_gfaccount span").text(data[0].admin_gfaccount);
			if(is_on_line==0){
				content+='<span class="service_name">'+
				'<span class="of"></span> <span id="admin_name" title="'+data[0].admin_gfnick+'">'+data[0].admin_gfnick+'</span> <div class="triangle_down"></div>'+
				'<div class="serv_list">'+
				'<div class="online if_on" id="on" onclick="changeAdminOnlineState(1)"><span class="on"></span> <span>在线</span></div>'+
				'<div class="offline if_on" id="of" onclick="changeAdminOnlineState(0)"><span class="of"></span> <span>离线</span></div>'+
				'<div class="serv_end"><span class="close"></span> <span>退出</span></div>'+
				'</div></span>'
			}else{
				content+='<span class="service_name">'+
				'<span class="on"></span> <span id="admin_name" title="'+data[0].admin_gfnick+'">'+data[0].admin_gfnick+'</span> <div class="triangle_down"></div>'+
				'<div class="serv_list">'+
				'<div class="online if_on" id="on" onclick="changeAdminOnlineState(1)"><span class="on"></span> <span>在线</span></div>'+
				'<div class="offline if_on" id="of" onclick="changeAdminOnlineState(0)"><span class="of"></span> <span>离线</span></div>'+
				'<div class="serv_end"><span class="close"></span> <span>退出</span></div>'+
				'</div></span>'
			}
			$(".service_name").remove();
			$(".serv_tit").prepend(content);
			
			$('*').removeClass("check");
			access=data[0].if_auto_access;
			$('.access[value="'+access+'"]').addClass("check");
			$("#join_member").val(data[0].max_access)
			if(access==0)
				$(".join_member_box").hide();
			else
				$(".join_member_box").show();
			greet=data[0].if_auto_greet;
			$('.greet[value="'+greet+'"]').addClass("check");
			$("#greetings_box").val(data[0].to_greet)
			if(greet==0)
				$("#greetings_box").hide();
			else
				$("#greetings_box").show();
		}
	});
}
function getFastReplyGroupList(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_fast_reply_group_list');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var data=e.datas;
			var content="";
			var text="";
			var option="";
			$.each(data,function(k,info){
				content+='<li class="group_name" value="'+info.id+'" title="'+info.group_name+'">'+info.group_name+'</li>';
				text+='<div class="group_data"><span title="'+info.group_name+'">'+info.group_name+'</span><img class="remove_group" src="customer_service/images/customer_service2_r12_r3_c5.png" value="'+info.id+'"></div>';
				option+='<option value="'+info.id+'">'+info.group_name+'</option>'
			});
			$(".group_name").remove();
			$(".group_all").append(content);
			$(".group_data_count").html(text);
			$(".add_expr_text input").val('')
			$(".add_expr_sele select").html(option);
		}
	})
}
var page = 1;
var pageSize = 8;
var totalCount = 0;
var pageMax = 0;
var groupId = -1;
function getFastReplyList(groupId){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.group_id=groupId;
	enparams.page=page;
	enparams.pageSize=pageSize;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_fast_reply_list');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var data=e.datas;
			var content="";
			var text="";
	        totalCount=e.totalCount;
	        pageMax = Math.ceil(totalCount/pageSize);
	        for(var i=0;i<pageMax;i++){
	        	if(i==0)
	        		text+='<li value="'+(i+1)+'" style="border-top:none">'+(i+1)+'</li>';
	        	else
	        		text+='<li value="'+(i+1)+'">'+(i+1)+'</li>';
	        }
	        $(".page_num ul").html(text);
	        //选择页码
	        $(document).on("click",".page_num li",function(){
	        	$(".page_num input").val($(this).attr("value")).trigger("change");
	        })
	        if(e.error==0){
				if(totalCount==0){
					content+='<tr align="center"><td>暂无数据</td></tr>'
				}else{
					$.each(data,function(k,info){
						content+='<tr value="'+info.id+'">'
						content+='<td width="20%" style="text-indent:1.4em;">'
						content+='<label>'
						content+='<input type="checkbox" onclick="setSelect('+k+',event)">'
						content+='<div class="reply_check"></div>'
						content+='</label>&nbsp;&nbsp;'+info.group_name+''
						content+='</td>'
						content+='<td width="65%"><input class="reply_content" type="text" value="'+info.content+'" readonly></td>'
						content+='<td width="15%" align="center">'
						content+='<img class="amend_shortcut" src="customer_service/images/customer_service2_r12_r3_c1.png"> '
						content+='<img class="delete_shortcut" src="customer_service/images/customer_service2_r12_r3_c5.png">'
						content+='</td>'
						content+='</tr>'
					})
				}
				$(".reply_table_bg table").empty();
				$(".reply_table_bg table").prepend(content);
	        }else{
	        	$.MsgBox.Alert("温馨提示",e.msg);
	        }
		}
	})
}
//问题分类列表
function getProblemTypeList(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_problem_type_list');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var content='';
			var data=e.datas;
			if(e.error==0){
				$.each(data,function(k,info){
					content+='<option value="'+info.f_id+'">'+info.F_NAME+'</option>'
				})
				$(".consult_type").html(content);
				var text=$('.consult_type option[value="'+userinfo.problem_type+'"]').attr("selected",true);
				$('.consult_type').val(text.val());
			}
		}
	})
}
//获取知识库列表
var knowledge_keyword='';
function getKnowledgeBaseList(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.keyword=knowledge_keyword;
	enparams.club_id=club_id;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_knowledge_base_list');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var content='';
			var data=e.datas;
			if(e.error==0){
				$.each(data,function(k,info){
					content+='<div class="knowle_item">'
					content+='<div class="knowle_title"><div class="triangle-right"></div>'+info.knowledge_type_name+'</div>'
					$.each(info.knowledge_type_data,function(m,n){
						content+='<div class="knowle_choice" value="'+n.id+'">'
						content+='<p class="text_top">'+n.problem_title+'</p>'
						content+='<textarea class="input">'+n.reply_content+'</textarea>'
						content+='<p class="text_op"><span class="copy_text">复制</span><span class="sent_text">发送</span></p>'
						content+='</div>'
					})
					content+='</div>'
				})
				$(".knowle_list").html(content);
			}
		}
	})
}
//所有分组的快捷语列表
var reply_keyword='';
function getAllFastReplyList(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.keyword=reply_keyword;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_all_fast_reply_list');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var content='';
			var data=e.datas;
			if(e.error==0){
				$.each(data,function(k,info){
					content+='<div class="reply_item">'
					content+='<div class="reply_title"><div class="triangle-right"></div>'+info.group_name+'</div>'
					$.each(info.group_data,function(m,n){
						content+='<div class="reply_choice" value="'+n.id+'">'
						content+='<p class="text_top">'+n.content+'</p>'
						content+='<textarea class="input">'+n.content+'</textarea>'
						content+='<p class="text_op"><span class="copy_text">复制</span><span class="sent_text">发送</span></p>'
						content+='</div>'
					})
					content+='</div>'
				})
				$(".reply_list").html(content);
			}
		}
	})
}
//获取待接入/已过期咨询列表
var awaitPage=1;
var awaitPageSize=4;
var awaittotalCount = 0;
var awaitpageMax = 0;
function getServiceWaitList(state){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.access_state=state;
	enparams.club_id=club_id;
	enparams.page=awaitPage;
	enparams.pageSize=awaitPageSize;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_service_wait_list');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var data=e.datas;
			var content='';
			var text="";
			awaittotalCount=e.totalCount;
			awaitpageMax = Math.ceil(awaittotalCount/awaitPageSize);
	        for(var i=0;i<awaitpageMax;i++){
	        	if(i==0)
	        		text+='<li value="'+(i+1)+'" style="border-top:none">'+(i+1)+'</li>';
	        	else
	        		text+='<li value="'+(i+1)+'">'+(i+1)+'</li>';
	        }
	        $(".join_page_num ul").html(text);
	        //选择页码
	        $(document).on("click",".join_page_num li",function(){
	        	$(".join_page_num input").val($(this).attr("value")).trigger("change");
	        })
	        
			if(state==1){
				$(".ap_count").html(awaittotalCount);
				$(".join_title .join_name").html("待接入（"+data.length+"）");
			}
//			var date1 = new Date().getTime();  //当前时间的毫秒数   

			if(awaittotalCount==0){
				content+='<tr align="center"><td>暂无数据</td></tr>'
			}else{
				$.each(data,function(k,info){
				    var date2 = new Date(info.s_time).getTime()+24*60*60*1000    //过期时间的毫秒数
				    var date3 = date2 - time_stamp;   //时间差的毫秒数       
				    var leave=date3%(24*3600*1000)    //计算天数后剩余的毫秒数  
				    var hours=Math.ceil(leave/(3600*1000))  //计算出相差小时数  
					content+='<tr>'
					content+='<td width="40%" style="text-indent: 1.5em;"><p>'+info.s_gf_account+'</p><p class="col" style="width:360px">'+new Base64().decode(info.m_message)+'</p></td>'
					if(state==1){
						content+='<td width="calc(60% - 110)/2"><p>'+new Date(info.s_time).format("hh:mm:ss")+'</p><p class="col">'+hours+'小时后过期</p></td>'
					}else{
						content+='<td width="calc(60% - 110)/2"><p>'+new Date(info.s_time).format("hh:mm:ss")+'</p><p class="col">已过期</p></td>'
					}
					content+='<td width="calc(60% - 110)/2"><p>'+info.admin_gfnick+'</p><p class="col">'+new Date(info.m_time).format("yyyy/MM/dd hh:mm:ss")+'</p></td>'
					if(state==1){
						content+='<td width="110px" style="text-align:center"><span class="automate" onclick="accessCustomerService('+info.cs_id+')">接入</span></td>'
					}else{
						content+='<td width="110px" style="text-align:center"><span class="automate" style="background-color:#999;">已过期</span></td>'
					}
					content+='</tr>'
				})
			}
			$(".join_table_bg table").html(content);
		}
	})
}

var gfids=[];
var csIds=[];
function messageArrived(message){
	// console.log("onMessageArrived: " + message.payloadString);
	message.arrived_at = (new Date()).format("yyyy-MM-dd hh:mm:ss");
	try {
		message.msgString = message.payloadString;
	} catch (e) {
		message.msgString = "Binary message(" +  message.payloadBytes.length + ")";
	}
	client.vmWS.data.receiveMsgs.push(message);
	payloadBytes={};//消息结构[69+ msg_id_len +msg_len+(4+ cs_id_len 仅packType=0x0012咨询客服含有 )]
	payloadBytes.packType=byteToInt(message.payloadBytes.slice(0,4),0);//int[4]包类型（0x0010）
	payloadBytes.m_CheckCode=byteToInt(message.payloadBytes.slice(4,8),0);//int[4]0(当packType =0x0010／0x0011时，0-个人，1-群；客服 0x0012时，0-s_gfid为gfid即发送方为用户，r_gfid为club_id；1-s_gfid为club_id即发送方为客服，r_gfid为gfid，未登录的gfid为0)
	payloadBytes.buf_len=byteToInt(message.payloadBytes.slice(8,12),0);//int[4] 包长度
	payloadBytes.buf_timesmap=parseInt(byteToString(message.payloadBytes.slice(12,25)));//string[13] 包时间戳 13位,位数不够前面补0 
	payloadBytes.lparam_len=byteToInt(message.payloadBytes.slice(25,29),0);//int[4] lparam的长度
	var lparam_len=payloadBytes.lparam_len;
	payloadBytes.lparam=byteToString(message.payloadBytes.slice(29,29+lparam_len));//string[lparam_len] 发送方预留(本地消息id) 
	payloadBytes.r_gfid=byteToInt(message.payloadBytes.slice(29+lparam_len,33+lparam_len),0);//int[4] 接收方（packType =0x0012时，m_CheckCode=0，r_gfid为club_id，；=1，r_gfid为gfid）
	payloadBytes.r_gfaccount=byteToInt(message.payloadBytes.slice(33+lparam_len,37+lparam_len),0);// int [4] 接收方
	payloadBytes.s_gfid=byteToInt(message.payloadBytes.slice(37+lparam_len,41+lparam_len),0);//int[4] 发送方（packType =0x0012，m_CheckCode=0，，s_gfid为gfid；=1，r_gfid为club_id）
	payloadBytes.s_gfaccount=byteToInt(message.payloadBytes.slice(41+lparam_len,45+lparam_len),0);//int [4] 发送方
	payloadBytes.msg_type=byteToInt(message.payloadBytes.slice(45+lparam_len,49+lparam_len),0);//int [4] 消息类型
	payloadBytes.msg_len=byteToInt(message.payloadBytes.slice(49+lparam_len,53+lparam_len),0);//int[4] 消息长度
	payloadBytes.msg_id_len=byteToInt(message.payloadBytes.slice(53+lparam_len,57+lparam_len),0);//int[4] 消息id长度（方便后期分表后id扩展）
	var msg_id_len=payloadBytes.msg_id_len;
	payloadBytes.msg_id=byteToString(message.payloadBytes.slice(57+lparam_len,57+lparam_len+msg_id_len));//string[msg_id_len] 消息ID
	payloadBytes.device_type=byteToInt(message.payloadBytes.slice(57+lparam_len+msg_id_len,61+lparam_len+msg_id_len),0);//int [4] 客户端类型
	var msg_len=payloadBytes.msg_len;
	payloadBytes.msg_content=byteToString(message.payloadBytes.slice(61+lparam_len+msg_id_len,61+lparam_len+msg_id_len+msg_len));//string加密消息内容（经过AES加密）
	payloadBytes.file_type=byteToString(message.payloadBytes.slice(61+lparam_len+msg_id_len+msg_len,65+lparam_len+msg_id_len+msg_len));//string[4] 文件类型
	payloadBytes.sound_len=byteToInt(message.payloadBytes.slice(65+lparam_len+msg_id_len+msg_len,69+lparam_len+msg_id_len+msg_len),0);//int[4] 语音消息长度
	payloadBytes.cs_id_len=byteToInt(message.payloadBytes.slice(69+lparam_len+msg_id_len+msg_len,73+lparam_len+msg_id_len+msg_len),0);//int[4] 客服咨询id长度（方便后期分表后id扩展）
	var cs_id_len=payloadBytes.cs_id_len;
	payloadBytes.customer_service_id=byteToString(message.payloadBytes.slice(73+lparam_len+msg_id_len+msg_len,73+lparam_len+msg_id_len+msg_len+cs_id_len));//string[cs_id_len] 客服咨询ID
	console.log(payloadBytes)
	if(msg_len>0){
		var msg_type=payloadBytes.msg_type;
		if(payloadBytes.customer_service_id==''){//1000通知，使用unregistered_tourists返回的msg_key解密
			var appClient=$.parseJSON(AES_decode(payloadBytes.msg_content,msg_key.slice(0,16),msg_key.slice(16)))
			console.log(appClient)
			if(appClient.id==8){//通知客服：接入用户信息
				if($(".serv_content:visible").length==0){
					$(".serv_content").eq(0).show();
					$(".serv_center_tit").css("visibility","hidden");
				}
				var an_cs_id=appClient.cs_id;
				typeof an_cs_id != 'string' ? an_cs_id = an_cs_id.toString() : an_cs_id = an_cs_id;
				if(csIds.indexOf(an_cs_id)<=-1){
					$(".client_list").prepend('<div class="client" cs_id="'+an_cs_id+'" r_gfid="'+appClient.gfid+'" r_gfaccount="'+appClient.gfaccount+'"><span class="gf_account">'+(appClient.gfaccount==0?'匿名用户':appClient.gfaccount)+'</span></div>');
					$('.serv_input').before('<div class="serv_content" cs_id="'+an_cs_id+'" r_gfid="'+appClient.gfid+'" style="display:none"></div>');
					$(".serv_left_tit div").html("会话中（"+$(".client").length+"）");
					if($(".greet[value='1']").hasClass("check")){
						setTimeout(function(){automaticMessageSending(appClient.cs_id,appClient.gfid,appClient.gfaccount);},1000);//自动发送消息
					}
					csIds.push(an_cs_id);
					gfids.push(appClient.gfid);
				}
			}
			if(appClient.id==10){//通知客服：更新咨询列表
				getServiceWaitList(1);
			}
			if(appClient.id==12){
				$(".serv_content[cs_id='"+appClient.cs_id+"']").append('<p class="chat_hint"><img src="customer_service/images/customer_service2_r2_r4_c3.png">  会话已结束，你可以选择<a onclick="accessCustomerService('+appClient.cs_id+')">重新接入</a></p>');
				var chatcontent=$(".serv_content[cs_id='"+appClient.cs_id+"']").get(0);//聊天记录显示框
			    chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
			    $(".message img").load(function(){
					chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
				})
			}
		}else{
			get_consultation_service_info(payloadBytes.customer_service_id);
			if(cs_id==payloadBytes.customer_service_id){
				if(payloadBytes.m_CheckCode==1){//客服发送的
					
				}else{//用户发送的
					var content='<div class="serv_mess message" value="'+payloadBytes.msg_id+'"><div class="serv_mess_time">'+new Date(payloadBytes.buf_timesmap).format("hh:mm:ss")+'</div><div class="serv_mess_content">';
					var txt=''
					if(msg_type==1){//文字
						txt=new Base64().decode(AES_decode(payloadBytes.msg_content,aesKey.slice(0,16),aesKey.slice(16))).replace(reg_nbsp,"&nbsp;").replace(reg_n,"<br>")
					}else if(msg_type==17){//图片
						txt='<img src="'+AES_decode(payloadBytes.msg_content,aesKey.slice(0,16),aesKey.slice(16))+'" style="max-width: 148px;">';
					}else if(msg_type==3){//表情
						txt=gf_gif[AES_decode(payloadBytes.msg_content,aesKey.slice(0,16),aesKey.slice(16))];
					}
					console.log(txt);
					content+=txt;
					content+='</div></div>';
					$(".serv_content[cs_id='"+cs_id+"']").append(content);
				    if($(".client_list").find('.client[cs_id="'+cs_id+'"]').find(".news").length>0){
						var news_num=parseInt($(".client_list").find('.client[cs_id="'+cs_id+'"]').find(".news").text());
						$(".client_list").find('.client[cs_id="'+cs_id+'"]').find(".news").text(news_num+1);
					}else{
						$(".client_list").find('.client[cs_id="'+cs_id+'"]').append('<span class="news">1</span>')
					}
				}
				var chatcontent=$(".serv_content[cs_id='"+cs_id+"']").get(0);//聊天记录显示框
			    chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
			    $(".message img").load(function(){
					chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
				})
			}else{
				if($(".client_list").find('.client[cs_id="'+payloadBytes.customer_service_id+'"]').length>0){
					if($(".client_list").find('.client[cs_id="'+payloadBytes.customer_service_id+'"]').find(".news").length>0){
						var news_num=parseInt($(".client_list").find('.client[cs_id="'+payloadBytes.customer_service_id+'"]').find(".news").text());
						$(".client_list").find('.client[cs_id="'+payloadBytes.customer_service_id+'"]').find(".news").text(news_num+1);
					}else{
						$(".client_list").find('.client[cs_id="'+payloadBytes.customer_service_id+'"]').append('<span class="news">1</span>')
					}
				}else{
					$(".client_list").append('<div class="client" cs_id="'+payloadBytes.customer_service_id+'" R_gfId="'+payloadBytes.s_gfid+'" R_gfAccount="'+payloadBytes.s_gfaccount+'"><span class="gf_account">'+(payloadBytes.s_gfaccount==0?'匿名用户':payloadBytes.s_gfaccount)+'</span><span class="news">1</span></div>');
					$('.serv_input').before('<div class="serv_content" cs_id="'+payloadBytes.customer_service_id+'" r_gfid="'+payloadBytes.s_gfid+'" style="display:none"></div>');
					$(".serv_left_tit div").html("会话中（"+$(".client").length+"）")
				}
			}
			//桌面提示
			if(msg_type==1){//文字
				notify(new Base64().decode(AES_decode(payloadBytes.msg_content,aesKey.slice(0,16),aesKey.slice(16))));
			}else if(msg_type==17){//图片
				notify('[图片]');
			}else if(msg_type==3){//表情
				notify('[表情]');
			}
		}
	}
}
$(document).on("click",".close_user",function(){
	$.MsgBox.Confirm("温馨提示","是否结束此会话？",function(){
		closeConsultation();
	});
})
function closeConsultation(){
	var target=$(this);
	var time_stamp=nowTimeStamp.getTime();
	var map=new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.cs_id=cs_id;
	console.log(enparams)
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'close_consultation');
	console.log(map)
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
			$(".the_client").remove();
			$(".serv_content[cs_id='"+cs_id+"']").remove();
			$(".widget").remove();
			$(".serv_center_tit").css("visibility","hidden");
			$(".serv_left_tit div").html("会话中（"+$(".client").length+"）")
			$(".serv_content").eq(0).show();
			if($(".the_client").length==0){
				cs_id=0;
			};
			$(".serv_num").html('');
			$(".serv_name").html('');
			$(".gf_phone").html('');
			$(".gf_mail").html('');
			$(".serv_info").html('');
			$(".serv_client").html('');
			var text=$('.consult_type option[value="'+userinfo.problem_type+'"]').attr("selected",true);
			$('.consult_type').val('');
			$(".mess_remark textarea").val('');
		}
	});
}
//根据咨询ID获取客服信息
var aesKey='';
var userinfo={};
function get_consultation_service_info(cs_id){
	var time_stamp=nowTimeStamp.getTime();
	var map=new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.cs_id=cs_id;
	enparams.backend=1;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_consultation_service_info');
	ajaxJsonReturn(map,io_customer_service,"post",false,"",function(e){
		e=$.parseJSON(e);
		e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
		if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
		aesKey=e.datas[0].aes_key;
		userinfo.code=e.datas[0].code;
		userinfo.s_gfname=e.datas[0].s_gfname;
		userinfo.s_gf_phone=e.datas[0].s_gf_phone;
		userinfo.s_gf_mail=e.datas[0].s_gf_mail;
		userinfo.s_ip_address=e.datas[0].s_ip_address;
		userinfo.s_region=e.datas[0].s_region;
		userinfo.client_type_name=e.datas[0].client_type_name;
		userinfo.problem_type=e.datas[0].problem_type;
		userinfo.remarks=e.datas[0].remarks;
	});
}
$(document).on("click",function(){
	for(var i=0;i<$(".the_client .news").text();i++){
//		readed_single_message($(".serv_content[cs_id='"+cs_id+"']").find(".serv_mess").eq(-1-i).attr("value"),R_gfId,gfId);
	}
	$(".the_client .news").remove();
})
$(document).on("click",".client_list .client",function(){
	if(!$(this).is(".the_client")){
		$(".widget").html($(this).children(".gf_account").text());
		$(".client_list .client").removeClass("the_client");
		$(this).addClass("the_client");
		cs_id=$(".the_client").attr("cs_id");
		R_gfId=$(".the_client").attr("R_gfId");
		R_gfAccount=$(".the_client").attr("R_gfAccount");
		$(this).children(".news").remove();
		$(".serv_content").hide();
		if(cs_id!=0){
			$(".widget").remove();
			$(".serv_center_tit").prepend('<span class="widget">'+(R_gfAccount==0?'匿名用户':R_gfAccount)+'</span>').css("visibility","visible");
			$(".serv_content[cs_id='"+cs_id+"']").empty();
			msg_pageNo=1;
			msg_date=new Date().format("yyyy-MM-dd");
			get_customer_msg_history();
			get_consultation_service_info(cs_id);
			$(".serv_num").html(userinfo.code);
			$(".serv_name").html(userinfo.s_gfname);
			$(".gf_phone").html(userinfo.s_gf_phone);
			$(".gf_mail").html(userinfo.s_gf_mail);
			$(".serv_info").html(userinfo.s_ip_address+userinfo.s_region);
			$(".serv_client").html(userinfo.client_type_name);
			var text=$('.consult_type option[value="'+userinfo.problem_type+'"]').attr("selected",true);
			$('.consult_type').val(text.val());
			$(".mess_remark textarea").val(userinfo.remarks);
		}
		$(".serv_content[cs_id='"+cs_id+"']").show();
	}
})
/*更新消息状态为已读*/
function readed_single_message(id,source_gfid,target_gfid){
	var map=new Map();
	map.put("id",id);//消息ID
	map.put("source_gfid",source_gfid);//发送者ID
	map.put("target_gfid",target_gfid);//接收者ID，当S_G==1时，该值为群ID
	map.put("S_G",0);//0单聊，1群聊
	map.put("rec_gfid","");//群聊时用,接收人GFID
	map.put("clientType ",1);//终端类型1、PC 2、MAC 3、IPHONE 4、IPAD 5、APHONE 6、APAD 7、其它
	map.put("action",'readed_single_message');
	ajaxJsonReturn(map, io_gfim, "post", true, "", function(e){
		e=$.parseJSON(e);
		if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
	});
}
//离线消息（带分页）
var msg_pageNo=1;
var msg_pageSize=20;
var msg_date=new Date().format("yyyy-MM-dd");
function get_customer_msg_history(){
	var map=new Map();
	var time_stamp=nowTimeStamp.getTime();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.cs_id=cs_id;
	enparams.page=msg_pageNo;
	enparams.pageSize=msg_pageSize;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_customer_msg_history');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
			var content='';
			$.each(e.datas,function(k,info){
				var this_date=new Date(info.S_TIME).format("yyyy-MM-dd");
				if(msg_date!=this_date){
					$(".serv_content[cs_id='"+cs_id+"']").prepend('<div style="text-align: center;color: #fff;background: #d1d1d1;width: 100px;margin: 0 auto;margin-bottom: 20px;">'+msg_date+'</div>');
					msg_date=this_date;
				}
				var M_TYPE=info.M_TYPE;
				if(info.isCustomerSend==1){//客服发送的
					var str='<div class="client_mess message" value="'+info.ID+'"><div class="client_mess_time">'+new Date(info.S_TIME).format("hh:mm:ss")+'</div><div class="client_mess_content">';
					if(M_TYPE==1){//文字
						str+=new Base64().decode(new Base64().decode(info.M_MESSAGE)).replace(reg_nbsp,"&nbsp;").replace(reg_n,"<br>")
					}else if(M_TYPE==17){//图片
						str+='<img src="'+new Base64().decode(info.M_MESSAGE)+'" style="max-width: 148px;">';
					}else if(M_TYPE==3){//表情
						str+=gf_gif[new Base64().decode(info.M_MESSAGE)];
					}
					str+='</div></div>';
					$(".serv_content[cs_id='"+cs_id+"']").prepend(str);
				}else{//用户发送的
					var content='<div class="serv_mess message" value="'+info.ID+'"><div class="serv_mess_time">'+new Date(info.S_TIME).format("hh:mm:ss")+'</div><div class="serv_mess_content">';
					if(M_TYPE==1){//文字
						content+=new Base64().decode(new Base64().decode(info.M_MESSAGE)).replace(reg_nbsp,"&nbsp;").replace(reg_n,"<br>")
					}else if(M_TYPE==17){//图片
						content+='<img src="'+new Base64().decode(info.M_MESSAGE)+'" style="max-width: 148px;">';
					}else if(M_TYPE==3){//表情
						content+=gf_gif[new Base64().decode(info.M_MESSAGE)];
					}
					content+='</div></div>';
					$(".serv_content[cs_id='"+cs_id+"']").prepend(content);
//					if(info.IS_READ==0){
//						readed_single_message(info.ID,info.S_GF_ID,info.R_GF_ID);
//					}
				}
			})
			if(e.datas.length==msg_pageSize){
				$("#more_history").remove();
				$(".serv_content[cs_id='"+cs_id+"']").prepend('<div style="color: #108ee9;position: absolute;width: 90px;text-align: center;top: 5px;left: 50%;margin-left: -40px;cursor: pointer;z-index: 1;font-size: 14px;" id="more_history">查看更多消息</div>');
			}else{
				$("#more_history").remove();
			}
			var chatcontent=$(".serv_content[cs_id='"+cs_id+"']").get(0);//聊天记录显示框
			if(msg_pageNo==1){
				chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
				$(".message img").load(function(){
					chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
				})
			}else{
				var value=$(".serv_content[cs_id='"+cs_id+"'] .message").eq(e.datas.length).attr("value");
				var obj=$('.serv_content[cs_id="'+cs_id+'"] .message[value="'+value+'"]').get(0);
				chatcontent.scrollTop=obj.offsetTop;
				$(".message img").load(function(){
					chatcontent.scrollTop=obj.offsetTop;
				})
			}
		}
	})
}
$(document).on("click","#more_history",function(){
	msg_pageNo++;
	get_customer_msg_history();
})
/* 点击发送按钮执行，提交表单，把输入框清空，消息显示框显示到最底部 */
function sendok(content,m_type) {
	if(cs_id==0){
		$.MsgBox.Alert("温馨提示","请选择聊天对象");
		return false;
	}
	var text=$.trim(content);
	if(content==""){
		$.MsgBox.Alert("温馨提示","消息不能为空");
	}else{
		var map=new Map();
		map.put("visit_id",visit_id);
		var time_stamp=nowTimeStamp.getTime();//时间戳
		map.put("ts",time_stamp);
		var data={};
		data.ts=time_stamp;//请求访问时间戳
		data.s_gfid=club_id;//发送者GF_ID    当S_G  =5&isCustomerSend=1 为club_id
		data.s_gfaccount=admin_gfaccount;//发送者GFACCOUNT
		data.r_gfid=R_gfId;//接收者GF_ID    当S_G  =5&isCustomerSend=0 为club_id
		data.r_gfaccount=R_gfAccount;//接收者GF_ACCOUNT,当S_G=1为接收者GF账号，S_G=1为0，S_G=5 为客服的GF账号
		data.device=7;//发送者终端类型1PC 2MAC 3IPHONE 4IPAD 5APHONE  6APAD 7其它
		data.m_type=m_type;//离线消息类型 //1文字 2语音 3本地表情 4小图片（表情）5,源请求添加目标为好友 6源回复目标同意其添加成为其好友 7源请求删除目标好友 16语音 17图片 18定位 19视频 20视频 23分享链接（分享给好友、群）308 修改密码
		data.f_type='txt';//txt，或者上传的文件类型
		data.s_len=0;//如果是语音消息，这里就写成语音时长
		data.s_g=5;//单聊0，群聊1（群聊时R_GF_ID为群ID），客服5（客服咨询时需要传入isCustomerSend，service_id）
		if(m_type==1||m_type==18||m_type==21){
			data.content=new Base64().encode(text);//消息内容，当m_type=1\18\21 需要base64编码
		}else{
			data.content=text;//消息内容，当m_type=1\18\21 需要base64编码
		}
		data.isCustomerSend=1;//是否是客服回复信息 0-用户发送，1-客服发送，当S_G=5时传入
		data.service_id=cs_id;//用户咨询ID，当S_G=5时传入
		console.log(data)
		data=AES_encode(JSON.stringify(data),login_sign_key.slice(0,16),login_sign_key.slice(16));
		map.put("data",data);
		console.log(map)
		$.ajaxloading({
			url:send_msg_url,
			data:map.toJSON(),
			type:"post",
			success:function(e){
				e=$.parseJSON(e);
				if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
			    var str='<div class="client_mess message" value="'+e.id+'"><div class="client_mess_time">'+new Date(time_stamp).format("hh:mm:ss")+'</div><div class="client_mess_content">';
				if(m_type==1){//文字
					str+=text.replace(reg_nbsp,"&nbsp;").replace(reg_n,"<br>")
				}else if(m_type==17){//图片
					str+='<img src="'+text+'" style="max-width: 148px;">';
				}else if(m_type==3){//表情
					str+=gf_gif[text];
				}
				str+='</div></div>';
				$(".serv_content[cs_id='"+cs_id+"']").append(str);
			    //把输入框的内容清空
			    $("#msginput textarea").val("");
			    var chatcontent=$(".serv_content[cs_id='"+cs_id+"']").get(0);//聊天记录显示框
			    chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
			    $(".message img").load(function(){
					chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
				})
			}
		})
	}
}
$("#emotion").click(function(){
	$(".emotion_box").toggle();
})
$(document).click(function(e){
	if(!$(e.target).isChildAndSelfOf('#emotion img')){
		$(".emotion_box").hide()
	}
})
$("#pic-select").click(function(){
	$("#pic-select-form input[type='file']").trigger("click");
})
$(document).on("change","#pic-select-form input[type='file']",function(){
	var img_file=$(this);
	var formdata = new FormData(img_file.parent("form")[0]);
	$.ajax({
        url: '/FileUploader/fileUpload',
        type: 'POST',
        data: formdata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {
        	if(img_file.val()==""){
        		return false;
        	}
        	showmask();
        },
        success: function (e) {
        	e=$.parseJSON(e);
            if (e.code == 0) {
            	sendok(e.fileUrl+e.filename,17);
            } else {
            	$.MsgBox.Alert("温馨提示","图片发送失败！");
            }
			img_file.after('<input type="file" accept="image/png,image/jpeg" name="'+img_file.attr('name')+'">').remove();
        },
        complete:function(){
            hidemask();
        }
    });
})
$("#sendbtn").on("click",function(){
	sendok($("#msginput textarea").val(),1);
})
$(document).on("click",".emotion_box img",function(){
	sendok($(this).attr("value"),3);
})
$(document).on("click",".serv_end",function(){
	window.opener=null;
	window.open('','_self');
	window.close();
})
//自动发送消息
function automaticMessageSending(csid,gfid,account){
	var map=new Map();
	map.put("visit_id",visit_id);
	var time_stamp=nowTimeStamp.getTime();//时间戳
	map.put("ts",time_stamp);
	var data={};
	data.ts=time_stamp;//请求访问时间戳
	data.s_gfid=club_id;//发送者GF_ID    当S_G  =5&isCustomerSend=1 为club_id
	data.s_gfaccount=admin_gfaccount;//发送者GFACCOUNT
	data.r_gfid=gfid;//接收者GF_ID    当S_G  =5&isCustomerSend=0 为club_id
	data.r_gfaccount=account;//接收者GF_ACCOUNT,当S_G=1为接收者GF账号，S_G=1为0，S_G=5 为客服的GF账号
	data.device=7;//发送者终端类型1PC 2MAC 3IPHONE 4IPAD 5APHONE  6APAD 7其它
	data.m_type=1;//离线消息类型 //1文字 2语音 3本地表情 4小图片（表情）5,源请求添加目标为好友 6源回复目标同意其添加成为其好友 7源请求删除目标好友 16语音 17图片 18定位 19视频 20视频 23分享链接（分享给好友、群）308 修改密码
	data.f_type='txt';//txt，或者上传的文件类型
	data.s_len=0;//如果是语音消息，这里就写成语音时长
	data.s_g=5;//单聊0，群聊1（群聊时R_GF_ID为群ID），客服5（客服咨询时需要传入isCustomerSend，service_id）
	data.content=new Base64().encode($("#greetings_box").val());//消息内容，当m_type=1\18\21 需要base64编码
	data.isCustomerSend=1;//是否是客服回复信息 0-用户发送，1-客服发送，当S_G=5时传入
	data.service_id=csid;//用户咨询ID，当S_G=5时传入
	data=AES_encode(JSON.stringify(data),login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("data",data);
	ajaxJsonReturn(map, send_msg_url, "post", true, "", function(e){
		e=$.parseJSON(e);
		if(e.error!=0){$.MsgBox.Alert("温馨提示",e.msg);return false;}
		var str='<div class="client_mess message" value="'+e.id+'"><div class="client_mess_time">'+new Date(time_stamp).format("hh:mm:ss")+'</div><div class="client_mess_content">';
		str+=$("#greetings_box").val().replace(reg_nbsp,"&nbsp;").replace(reg_n,"<br>")
		str+='</div></div>';
		$(".serv_content[cs_id='"+csid+"']").append(str);
		var chatcontent=$(".serv_content[cs_id='"+csid+"']").get(0);//聊天记录显示框
		chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
		$(".message img").load(function(){
			chatcontent.scrollTop = chatcontent.scrollHeight;//设置显示框显示在最底部
		})
	});
}
$(window).on('beforeunload',function(){
	return '是否确认离开';
}); 
//关闭窗口客服为不在线状态
window.onunload =function() {
	changeAdminOnlineState(0);
}
	

$(".access").click(function(){
	access=$(this).attr("value")
	setAdminAutoAccess()
})
$(".greet").click(function(){
	greet=$(this).attr("value")
	setAdminAutoAccess()
})
var max_access;
$("#join_member").change(function(){
	max_access=$(this).val();
	setAdminAutoAccess();
})
var to_greet;
$("#greetings_box").change(function(){
	to_greet=$(this).val();
	setAdminAutoAccess();
})
//客服接入设置
function setAdminAutoAccess(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.if_auto_access=access;
	enparams.max_access=$("#join_member").val();
	enparams.if_auto_greet=greet;
	enparams.to_greet=$("#greetings_box").val();
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'set_admin_auto_access');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				getAdminInfo()
				$.MsgBox.Alert("温馨提示",'修改成功');
			}else{
				$.MsgBox.Alert("温馨提示",e.msg);
			}
		}
	});
}
//修改客服在线状态
function changeAdminOnlineState(is_on_line){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.is_on_line=is_on_line;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'change_admin_online_state');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		async:false,
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				getAdminInfo();
			}else{
				$.MsgBox.Alert("温馨提示",e.msg);
				return false;
			}
		}
	});
}

var index=0;
$("#settings").click(function(){
	$(".set_nav li").eq(index).trigger("click")
	$(".service_set_box").slideDown("slow");
});
$(".set_nav li").click(function(){
	$("*").removeClass("set_bar");
	$(this).addClass("set_bar");
	index=$(this).index();
	$(".set_box").hide();
	if($(this).attr("id")=="join_set"){
		$(".join_set").show();
	}else if($(this).attr("id")=="shortcut_reply"){
		$(".shortcut_reply").show();
	}else{
		$(".account_info").show();
	}
})
$(".add_grou").click(function(){
	$(".add_expr_box").show();
})
$('.add_expr_btn span').click(function(){
	var group_name=$.trim($(".add_expr_text input").val());
	if(group_name==''){
		$.MsgBox.Alert("温馨提示","分组名称不能为空");
		return false;
	}
	editFastReplyGroup(group_name);
	$(this).parents('.add_expr_box').hide();
})
function editFastReplyGroup(group_name){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.group_id=-1;
	enparams.group_name=group_name;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'edit_fast_reply_group');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				getFastReplyGroupList();
			}
		}
	})
}
$(".group_toggle").click(function(){
    $(this).toggleClass("border").children("span").toggleClass("switch_down switch_bottom");
	$(".group_all").toggle();
})
$(".manage_grou").click(function(){
	$(".group_sup_box").show();
})
$(document).on("click",".remove_group",function(){
	$.MsgBox.Confirm("温馨提示","是否删除分组？",function(){
		delFastReplyGroup($(this).attr("value"));
	});
})
function delFastReplyGroup(group_id){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.group_id=group_id;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'del_fast_reply_group');
	console.log(map)
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				$.MsgBox.Alert("温馨提示",'删除成功');
				getFastReplyGroupList();
				if(groupId!=group_id){
					getFastReplyList(groupId);
					getAllFastReplyList();
				}else{
					$(".group_all li[value='-1']").trigger("click");
				}
			}else{
				$.MsgBox.Alert("温馨提示",e.msg)
			}
		}
	})
}
$(".sub_save span").click(function(){
	$(".group_sup_box").hide();
})
$(".add_expr").click(function(){
	$(".add_expr_box2").show();
})
$(".add_expr_btn2 span").click(function(){
	if($(".add_expr_sele select").val()==null){
		$.MsgBox.Alert("温馨提示","暂无分组，请新建分组");
		return false;
	};
	if($.trim($(".add_expr_textarea textarea").val())==''){
		$.MsgBox.Alert("温馨提示","常用语不能为空");
		return false;
	};
	editFastReply($(".add_expr_sele select").val(),$.trim($(".add_expr_textarea textarea").val()),-1);
	$(this).parents('.add_expr_box2').hide();
	$(this).parents('.add_expr_box2').find("textarea").val('');
})
function editFastReply(group_id,content,id){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.admin_id=adminid;
	enparams.id=id;
	enparams.group_id=group_id;
	enparams.content=content;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'edit_fast_reply');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				getFastReplyList(groupId);
				getAllFastReplyList();
			}else{
				$.MsgBox.Alert("温馨提示",e.msg)
			}
		}
	})
}
//点击上一页
$(".last_page").click(function () {
    if (page>1) {
    	page--;
    	$(".page_num > input").val(page).trigger("change");
    }
})
//点击下一页
$(".next_page").click(function () {
    if (page < pageMax) {
    	page++;
        $(".page_num > input").val(page).trigger("change");
    }
});
//下拉页码
$(".page_num div").on("click",function(){
	$(".page_num ul").toggle();
})
$(document).click(function(e){
	if(!$(e.target).isChildAndSelfOf(".page_num div")){
		$(".page_num ul").hide();
	}
})
//页码变化
$(".page_num input").change(function(){
	page=$(this).val();
	getFastReplyList(groupId);
	$("body").scrollTop(0);
})
//初始化页码
function clear_page() {
    page = 1;
    $(".page_num input").val(page).trigger("change");
}
$(document).on("click",".group_all li",function(){
	groupId=$(this).attr("value");
	getFastReplyList(groupId);
	$(this).parent().hide().prev().removeClass("border").html($(this).text()+'&nbsp;&nbsp;<span class="switch_down"></span>');
	clear_page();
})
$(document).on("click",".amend_shortcut",function(){
    var comment = $(this).parent().prev().children(".reply_content").val();
    $(this).parent().prev().children(".reply_content").removeAttr("readonly").val(comment).focus();
})
$(document).on("click",".delete_shortcut",function(){
	var id=$(this).parent().parent().attr("value");
	$.MsgBox.Confirm("温馨提示","是否删除快捷语？",function(){
		delFastReply(id)
	});
})
function delFastReply(Id){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	if(typeof Id=='object')
		enparams.id=Id.join(',');
	else
		enparams.id=Id;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'del_fast_reply');
	console.log(map)
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				getFastReplyList(groupId);
				getAllFastReplyList();
			}else{
				$.MsgBox.Alert("温馨提示",e.msg)
			}
		}
	})
}
var replyId=[];
function replyList(event){
	replyId=[];
	if($(event.target).prop("checked")){
		$(".reply_table_bg tr").each(function(){
			replyId.push($(this).attr("value"));
		})
		$(".reply_table_bg").find("input[type='checkbox']").prop("checked",true);
	}else{
		replyId=[];
		$(".reply_table_bg").find("input[type='checkbox']").prop("checked",false);
	}
}
function setSelect(i,event) {
	if($(".reply_table_bg").find("input[type='checkbox']").eq(i).prop("checked")){
		replyId.push($(event.target).parents("tr").attr("value"));
	}else{
		$("#check_all[type='checkbox']").prop("checked",false);
		removeByValue(replyId,$(event.target).parents("tr").attr("value"));
	}
}
$(".remove_reply_all").click(function(){
	$.MsgBox.Confirm("温馨提示","是否删除分组？",function(){
		delFastReply(replyId);
		replyId=[];
	});
})
$(".back").click(function(){
	$(this).parent().hide();
	$(this).parent().find("textarea").val('');
	$(this).parent().find("input").val('');
	serviceId='';
	admin_group_id='';
})
$(".set_back").click(function(){
	$(".service_set_box").slideUp("slow");
});
$(".reply_submit").click(function(){
	reply_keyword=$(this).prev().val();
	getAllFastReplyList();
})
$(document).on("click",".reply_title",function(){
	$("*").removeClass("checked_text");
	$(".text_op").hide();
	if($(this).siblings(".reply_choice").is(":hidden")){
		$("*").find(".reply_choice").hide();
		$("*").find(".reply_title").children("div").removeClass("triangle_down").addClass("triangle-right");
		$(this).children("div").removeClass("triangle-right").addClass("triangle_down");
		$(this).siblings(".reply_choice").show();
	}else{
		$(this).children("div").removeClass("triangle_down").addClass("triangle-right");
		$(this).siblings(".reply_choice").hide();
	}
})
$(document).on("click",".reply_choice",function(){
	$("*").removeClass("checked_text");
	$(this).addClass("checked_text");
	$(".text_op").hide();
	$(this).children(".text_op").show();
})
$(document).on('click',".copy_text",function(){
    var input = $(this).parent().prev();
    input.select(); // 选中文本
    document.execCommand("copy"); // 执行浏览器复制命令
    $.MsgBox.Alert("温馨提示","复制成功");
});
$(document).on("click",".sent_text",function(){
	sendok($(this).parent().prev().val(),1);
})

$('.query_nav span').click(function(){
	$(this).addClass('thead_user');
	$(this).siblings().removeClass('thead_user');
    sessionStorage.setItem("right_index", $(this).index());
	if($(this).attr('id')=='myuserinfo_id'){
		$(this).parent().siblings('.myuserinfo').show().siblings().not('.query_nav').hide();
	}
	if($(this).attr('id')=='myknowle_id'){
		$(this).parent().siblings('.myknowle').show().siblings().not('.query_nav').hide();
	}
	if($(this).attr('id')=='myreply_id'){
		$(this).parent().siblings('.myreply').show().siblings().not('.query_nav').hide();
	}
})

var admin_keyword='';
var admin_index=0;
$(document).on("click",".serv_convert",function(){
	$(".seek_header_nav span").eq(admin_index).trigger("click");
	$('.seek_job').show();
})
$(".search_submit").click(function(){
	admin_keyword=$(this).prev().val();
	getOtherOnlineAdmin()
})
//可转接客服列表（其他在线客服列表）
function getOtherOnlineAdmin(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.cs_id=cs_id;
	enparams.keyword=admin_keyword;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_other_online_admin');
	console.log(map)
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var content='';
			var data=e.datas;
			if(e.error==0){
				$.each(data,function(k,info){
					content+='<div class="search" value="'+info.admin_id+'">'
					content+='<img src="customer_service/images/customer_service_r3_c1.png" class="job_img">'
					content+='<span class="job_num">'+info.admin_gfaccount+'</span>'
					content+='<span class="job_name">'+info.admin_gfnick+'</span>'
					content+='</div>'
				})
				$(".search_list").html(content);
				admin_keyword='';
			}
		}
	})
}
$(document).on("click",".search",function(){
	serviceId=$(this).attr("value");
	$("*").removeClass("the_search");
	$(this).addClass("the_search");
})
//客服组列表
function getAdminGroupList(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.cs_id=cs_id;
	enparams.keyword=admin_keyword;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'get_admin_group_list');
	console.log(map)
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var content='';
			var data=e.datas;
			if(e.error==0){
				$.each(data,function(k,info){
					content+='<div class="group" value="'+info.f_id+'" >'
					content+='<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">'
					content+='<span class="job_num" title="'+info.f_rname+'">'+info.f_rname+'</span>'
					content+='</div>'
				})
				$(".search_list2").html(content);
				admin_keyword='';
			}
		}
	})
}
$(document).on("click",".group",function(){
	admin_group_id=$(this).attr("value");
	$("*").removeClass("the_search");
	$(this).addClass("the_search");
})
$(".search_submit2").click(function(){
	admin_keyword=$(this).prev().val();
	getAdminGroupList()
})
var serviceId='';
var admin_group_id='';
function customerServiceTransfer(type){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.cs_id=cs_id;
	enparams.type=type;
	if(type==0){
		enparams.admin_id=serviceId;
		enparams.remarks=$(".search_remark textarea").val();
	}else{
		enparams.admin_group_id=admin_group_id;
		enparams.remarks=$(".search_remark2 textarea").val();
	}
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'customer_service_transfer');
	console.log(map)
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				$.MsgBox.Alert("温馨提示",e.msg);
				$(".seek_job").hide();
				serviceId='';
				admin_group_id='';
			}else{
				$.MsgBox.Alert("温馨提示",e.msg);
			}
		}
	})
}
$('.seek_header_nav span').click(function(){
	$(this).addClass('thead_user').siblings().removeClass('thead_user');
	admin_index=$(this).index();
	if($(this).hasClass('serv_pers_list')){
		getOtherOnlineAdmin();
		$(".seek_data").show();
		$(".seek_data2").hide();
	}else{
		getAdminGroupList();
		$(".seek_data2").show();
		$(".seek_data").hide();
	}
})
$(".seek_submit").click(function(){
	knowledge_keyword=$(this).prev().val();
	getKnowledgeBaseList();
})
$(document).on("click",".knowle_title",function(){
	$("*").removeClass("checked_text");
	$(".text_op").hide();
	if($(this).siblings(".knowle_choice").is(":hidden")){
		$("*").find(".knowle_choice").hide();
		$("*").find(".knowle_title").children("div").removeClass("triangle_down").addClass("triangle-right");
		$(this).children("div").removeClass("triangle-right").addClass("triangle_down");
		$(this).siblings(".knowle_choice").show();
	}else{
		$(this).children("div").removeClass("triangle_down").addClass("triangle-right");
		$(this).siblings(".knowle_choice").hide();
	}
})
$(document).on("click",".knowle_choice",function(){
	$("*").removeClass("checked_text");
	$(this).addClass("checked_text");
	$(".text_op").hide();
	$(this).children(".text_op").show();
})
//修改咨询问题分类
$(".consult_type").change(function(){
	if(cs_id>0){
		var time_stamp=nowTimeStamp.getTime();
		var map = new Map();
		map.put("visit_id",visit_id);
		var enparams={};
		enparams.ts=time_stamp;
		enparams.cs_id=cs_id;
		enparams.problem_type=$(".consult_type option:selected").attr('value');
		enparams=new Base64().encode(JSON.stringify(enparams));
		enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
		map.put("enparams",enparams);
		map.put("action",'change_problem_type');
		$.ajaxloading({
			url:io_customer_service,
			data:map.toJSON(),
			type:"post",
			success:function(e){
				e=$.parseJSON(e);
				e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
				if(e.error==0){
					$.MsgBox.Alert("温馨提示",e.msg);
				}else{
					$.MsgBox.Alert("温馨提示",e.msg);
				}
			}
		})
	}
})
//修改咨询备注信息
$(".mess_remark textarea").change(function(){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.cs_id=cs_id;
	enparams.remarks=$(".mess_remark textarea").val();
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'edit_service_remarks');
	console.log(map)
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			if(e.error==0){
				$.MsgBox.Alert("温馨提示",e.msg);
			}else{
				$.MsgBox.Alert("温馨提示",e.msg);
			}
		}
	})
})

$(".ap_box p").click(function(){
	$(".service_join_box").slideDown("slow");
})
$(".join_nav li").click(function(){
	$("*").removeClass("bar");
	$(this).addClass("bar");
	await_clear_page();
})
$(".join_nav .automate").click(function(){
	$(".access").eq(1).trigger('click');
})
//点击上一页
$(".join_last_page").click(function () {
    if (awaitPage>1) {
    	awaitPage--;
    	$(".join_page_num > input").val(awaitPage).trigger("change");
    }
})
//点击下一页
$(".join_next_page").click(function () {
    if (awaitPage < awaitpageMax) {
    	awaitPage++;
        $(".join_page_num > input").val(awaitPage).trigger("change");
    }
});
//下拉页码
$(".join_page_num div").on("click",function(){
	$(".join_page_num ul").toggle();
})
$(document).click(function(e){
	if(!$(e.target).isChildAndSelfOf(".join_page_num div")){
		$(".join_page_num ul").hide();
	}
})
//页码变化
$(".join_page_num input").change(function(){
	awaitPage=$(this).val();
	getServiceWaitList($(".bar").attr("value"));
	$("body").scrollTop(0);
})
//初始化页码
function await_clear_page(){
	awaitPage = 1;
    $(".join_page_num input").val(awaitPage).trigger("change");
}
//客服接入咨询/用户重新接入
function accessCustomerService(csId){
	var time_stamp=nowTimeStamp.getTime();
	var map = new Map();
	map.put("visit_id",visit_id);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.cs_id=csId;
	enparams.admin_id=adminid;
	console.log(enparams)
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,login_sign_key.slice(0,16),login_sign_key.slice(16));
	map.put("enparams",enparams);
	map.put("action",'access_customer_service');
	$.ajaxloading({
		url:io_customer_service,
		data:map.toJSON(),
		type:"post",
		success:function(e){
			e=$.parseJSON(e);
			e=$.parseJSON(AES_decode(e.endata,login_sign_key.slice(0,16),login_sign_key.slice(16)));
			var data=e.datas;
			getServiceWaitList($(".bar").attr("value"));
//			$(".client_list").empty();
//			$(".serv_content").not($(".serv_content").eq(0)).remove();
//			get_not_close_consulting_by_admin();
//			$(".client[cs_id='"+csId+"']").trigger("click");
		}
	})
}
$(".join_back").click(function(){
	$(".service_join_box").slideUp("slow");
})


