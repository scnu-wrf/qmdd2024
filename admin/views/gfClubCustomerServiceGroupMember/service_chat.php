<link href="customer_service/css/service_chat.css" rel="stylesheet" type="text/css" />
<div class="service_box">
	<div class="serv_left">
		<div class="serv_left_tit">
			<div>会话中</div>
		</div>
		<div class="client_list">
			<!-- <div class="client the_client" code="0">
				<span class="gf_account"></span>
			</div> -->
		</div>
		<div class="stay_ap">
			<div class="ap_box">
				<p class="ap_count">0</p>
				<p>待接入</p>
			</div>
		</div>
	</div>
	<div class="serv_box">
		<div class="serv_box_tit">
			
		</div>
			<div class="serv_center_tit">
				<!-- <span class="widget">654321</span> -->
				<div class="service_tit">
					<span class="serv_convert"><img src="customer_service/images/customer_service2_r6_c7.png">&nbsp;<span>转接</span></span><span class="close_user"><img src="customer_service/images/customer_service2_r5_c9.png">&nbsp;<span>结束</span></span>
			   </div>
			</div>
		<div class="serv_content">
			<!-- <div class="message">
				<div class="serv_mess">
					<div class="serv_mess_time">14:00:02</div>
					<div class="serv_mess_content">
						<p>消息豆如何挣得更多</p>
					</div>
				</div>
				<div class="client_mess">
					<div class="client_mess_time">14:00:02</div>
					<div class="client_mess_content">
						<h4 class="client_mess_tit">体育豆的来源及权益？</h4>
						<p>1.上架不需要体育豆；</p>
						<p>2.根据星级获得相对应的上架窗口，上架窗口的数量按默认的GF官方导购星级数量无需操作；</p>
						<p>3.社区单位只能上架已认证项目的专业产品；</p>
						<p>4.上架的商品数量如GF商城销售完后，可以扣减最后上架的社区单位商品数量。</p>
					</div>
				</div>
				<div class="serv_mess">
					<div class="serv_mess_time">14:00:02</div>
					<div class="serv_mess_content">
						<div class="good_count">
							<a><img src="customer_service/images/about_a2_r14_c31.png" alt=""></a>
							<a><img src="customer_service/images/about_a2_r14_c31.png" alt=""></a>
							<a><img src="customer_service/images/about_a2_r14_c31.png" alt=""></a>
							<a><img src="customer_service/images/about_a2_r14_c31.png" alt=""></a>
							<a><img src="customer_service/images/about_a2_r14_c31.png" alt=""></a>
						</div>
						<p>已解决，5分好评</p>
					</div>
				</div>
			</div> -->
			<!-- <p class="chat_hint"><img src="customer_service/images/customer_service2_r2_r4_c3.png">  超30分钟未对话，会话已结束，你可以选择<a>重新接入</a></p>
			<p class="chat_hint"><img src="customer_service/images/customer_service2_r2_r4_c3.png">  会话已结束，你可以选择<a>重新接入</a></p> -->
		</div>
		<div class="serv_input">
			<form action="">
				<div class="send_btn" id="sendbtn">
					<span>发送</span>
				</div>
				<div class="emotion_box">
				</div>
				<div id="emotion">
					<img src="customer_service/images/event_video_detials5.png">
				</div>
				<div id="pic-select">
					<img src="customer_service/images/event_video_detials4.png">
				</div>
				<div class="input_box" id="msginput">
					<textarea placeholder="请输入..."></textarea>
				</div>
			</form>
			<form enctype="multipart/form-data" onsubmit="return false;" style="display:none" id="pic-select-form">
				<input type="hidden" name="fileCode" value="56_gm">
				<input type="file" accept="image/png,image/jpeg" name="file">
			</form>
		</div>
	</div>
	<div class="serv_right">
		<div class="serv_right_tit">
			<div class="serv_tit">
				<!-- <span class="service_name">
					<!-- <span class="is_on"></span> <span id="admin_name">国宝特工</span> <div class="triangle_down"></div>
					<div class="serv_list">
						<div class="online if_on" id="on" value="1"><span class="on"></span> <span>在线</span></div> 
						<div class="offline if_on" id="of" value="0"><span class="of"></span> <span>离线</span></div>   
						<div class="serv_end"><span class="close"></span> <span>退出</span></div>     		
					</div> 
				</span> -->
				|
				<img id="settings" src="customer_service/images/customer_service2_r2_r1_c7.png">
			</div>
		</div>
		<div class="query_detail">
			<div class="query_nav">
				<span id="myuserinfo_id" class="thead_user">用户信息</span>|
				<span id="myknowle_id">知识库</span>|
				<span id="myreply_id">快捷回复</span>
			</div>
			<div class="myuserinfo">
				<div class="serv_card">
					<h4 class="serv_card_tit"><img src="customer_service/images/customer_service2_r1_c3.png"> 顾客名片</h4>
					<p class="serv_mess_list">
						<span class="mess_tit">流水号</span>
						<span class="serv_num"></span>
					</p>
					<p class="serv_mess_list">
						<span class="mess_tit">用户姓名</span>
						<span class="serv_name"></span></p>
					<p class="serv_mess_list">
						<span class="mess_tit">联系电话</span>
						<span class="gf_phone"></span>
					</p>
					<p class="serv_mess_list">
						<span class="mess_tit">电子邮箱</span>
						<span class="gf_mail"></span>
					</p>
					<p class="serv_mess_list">
						<span class="mess_tit">访问信息</span>
						<span class="serv_info"></span>
					</p>
					<p class="serv_mess_list">
						<span class="mess_tit">来源终端</span>
						<span class="serv_client"></span>
					</p>
				</div>
				<div class="consult_sort">
					<h4 class="consult_sort_tit"><img src="customer_service/images/customer_service2_r3_c2.png"> 咨询分类</h4>
					<select class="consult_type">
						
					</select>
				</div>
				<div class="mess_remark">
					<h4 class="mess_remark_tit"><img src="customer_service/images/customer_service2_r9_c1.png"> 备注信息</h4>
					<textarea></textarea>
				</div>
				<div class="serv_history">
					<h4 class="serv_history_tit"><img src="customer_service/images/customer_service2_r11_c1.png"> 历史记录</h4>
					<p class="history_list">
						<span class="history_tit">01-06 12:00</span>
						<span class="serv_pers">智能小管</span>
					</p>
					<p class="history_list">
						<span class="history_tit">01-06 12:00</span>
						<span class="serv_pers">客服：小丽</span>
					</p>
					<p class="history_list">
						<span class="history_tit">01-06 12:00</span>
						<span class="serv_pers">智能小管</span>
					</p>
					<p class="history_list">
						<span class="history_tit">01-06 12:00</span>
						<span class="serv_pers">客服：小丽</span>
					</p>
				</div>
			</div>
	   <div class="myknowle">
				<div class="seek">
					<div class="seek_box">
						<input class="seek_input" type="text" placeholder="请输入关键字">
						<div class="seek_submit"><img src="customer_service/images/mall_flash_sale.png"></div>
					</div>
				</div>
				<div class="knowle_list">
					<!-- <div class="knowle_item">
						<div class="knowle_title"><div class="triangle_down"></div>服务者</div>
						<div class="knowle_choice">服务者入驻</div>
						<div class="knowle_choice">服务者等级</div>
						<div class="knowle_choice">加入/退出社区单位</div>
						<div class="knowle_choice">服务者续签</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>社区单位</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>战略伙伴</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>赛事活动</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>排名榜</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>GF龙虎组别注册</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>二次上架</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>体育豆</div>
					</div>
					<div class="knowle_item">
						<div class="knowle_title"><div class="triangle-right"></div>GF商城</div>
					</div> -->
				</div>
			</div>
			<div class="myreply">
				<div class="reply">
					<div class="reply_box">
						<input class="reply_input" type="text" placeholder="请输入关键字">
						<div class="reply_submit"><img src="customer_service/images/mall_flash_sale.png"></div>
					</div>
				</div>
				<div class="reply_list"></div>
			</div>
		</div>
	</div>
	
	<div class="seek_job">
		<img class="back" src="customer_service/images/ranking_a4_r2_c5.png">
		<div class="seek_header">
			<div class="seek_header_nav">
				<span class="serv_pers_list thead_user">客服</span>
				<span class="serv_group">客服组</span>
			</div>
		</div>
		<div class="seek_data">
			<div class="search_frame">
				<div class="search_box">
					<input class="search_input" type="text" placeholder="请输入工号/姓名关键字搜索">
					<div class="search_submit"><img src="customer_service/images/mall_flash_sale.png"></div>
				</div>
			</div>
			<div class="search_list">
			
			</div>
			<div class="search_remark">
				<textarea placeholder="备注..."></textarea>
			</div>
			<div class="search_btn">
				<input type="botton" value="确定转接" onclick="customerServiceTransfer(0)">
			</div>
		</div>
		<div class="seek_data2">
			<div class="search_frame2">
				<div class="search_box2">
					<input class="search_input2" type="text" placeholder="请输入工号/姓名关键字搜索">
					<div class="search_submit2"><img src="customer_service/images/mall_flash_sale.png"></div>
				</div>
			</div>
			<div class="search_list2">
				<!-- <div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">发票问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">购物问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">财务问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">订单问题</span>
				</div>
				<div class="group the_search">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">排名积分问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">发票问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">购物问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">财务问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">订单问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">排名积分问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">发票问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">购物问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">财务问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">订单问题</span>
				</div>
				<div class="group">
					<img src="customer_service/images/customer_service_r3_c4.png" class="group_img">
					<span class="job_num">排名积分问题</span>
				</div> -->
			</div>
			<div class="search_remark2">
				<textarea placeholder="备注..."></textarea>
			</div>
			<div class="search_btn2">
				<input type="botton" value="确定转接" onclick="customerServiceTransfer(1)">
			</div>
		</div>
	</div>
</div>
<div class="service_join_box" style="display:none">
	<div class="join_title">
		<span class="join_name">待接入（0）</span>
		<span class="join_back"><img src="customer_service/images/customer_service2_r2_r1_c11.png">返回</span>
	</div>
	<div class="join_nav">
		<ul><li class="bar" value="1">待接入</li>|<li value="2">已过期</li></ul>
		<span class="automate">自动接入</span>
	</div>
	<div class="join_table_top">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td width="40%" style="text-indent: 1.5em;">客户信息</td>
			  <td width="calc(60% - 110)/2">消息时间</td>
			  <td width="calc(60% - 110)/2">上次接待客服</td>
			  <td width="110px" style="text-align:center">操作</td>
			</tr>
		</table>
	</div>
	<div class="join_table_bg">
		<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<!-- <tr>
				<td width="40%" style="text-indent: 1.5em;"><p>654321</p><p class="col" style="width:360px">您好，有个问题想要咨询下，关于赛事体检过期了应该怎么做</p></td>
				<td width="calc(60% - 110)/2"><p>11:02:12</p><p class="col">5小时后过期</p></td>
				<td width="calc(60% - 110)/2"><p>果宝特攻</p><p class="col">2018/8/8 11:02:12</p></td>
				<td width="110px" style="text-align:center"><span class="automate">接入</span></td>
			</tr>
			<tr>
				<td width="40%" style="text-indent: 1.5em;"><p>654321</p><p class="col" style="width:360px">您好，有个问题想要咨询下，关于赛事体检过期了应该怎么做</p></td>
				<td width="calc(60% - 110)/2"><p>11:02:12</p><p class="col">5小时后过期</p></td>
				<td width="calc(60% - 110)/2"><p>果宝特攻</p><p class="col">2018/8/8 11:02:12</p></td>
				<td width="110px" style="text-align:center"><span class="automate">接入</span></td>
			</tr>
			<tr>
				<td width="40%" style="text-indent: 1.5em;"><p>654321</p><p class="col" style="width:360px">您好，有个问题想要咨询下，关于赛事体检过期了应该怎么做</p></td>
				<td width="calc(60% - 110)/2"><p>11:02:12</p><p class="col">5小时后过期</p></td>
				<td width="calc(60% - 110)/2"><p>果宝特攻</p><p class="col">2018/8/8 11:02:12</p></td>
				<td width="110px" style="text-align:center"><span class="automate">接入</span></td>
			</tr> -->
		</table>
	</div>
	<div class="join_page_bottom">
		<div class="join_turn_page">
			<div class="join_last_page">
				<img src="customer_service/images/member_a2_r16_c8.png">
			</div>
			<div class="join_page_num">
				<input value="1" readonly="readonly">
				<div></div>
				<ul></ul>
			</div>
			<div class="join_next_page">
				<img src="customer_service/images/member_a2_r16_c17.png">
			</div>
		</div>
	</div>
</div>
<div class="service_set_box">
	<div class="set_title">
		<span class="set_name">设置</span>
		<span class="set_back"><img src="customer_service/images/customer_service2_r2_r1_c11.png">返回</span>
	</div>
	<div class="set_nav">
		<ul>
			<li id="account_info" class="set_bar">帐号信息</li>
			|
			<li id="join_set">接入设置</li>
			|
			<li id="shortcut_reply">快捷回复</li>
		</ul>
	</div>
	<div class="set_box account_info">
		<div class="service_info">
			<img id="service_head" src="customer_service/images/event_player (5).png" onerror="this.src=error_head">
			<p id="service_name">客服丽丽</p>
		</div>
		<div class="club_account">
			<p id="club_name">服务单位：<span>GF官方</span></p>
			<p id="admin_gfaccount">GF帐号：<span>654321</span></p>
		</div>
		<div class="quit_input serv_end">退出</div>
	</div>
	<div class="set_box join_set">
		<div class="join_set_box">
			<div class="automation_join_client">
				<p>是否启动自动接入</p>
				<p>&nbsp;<span class="checkbox access" value="0"></span>&nbsp;不启动自动接入，全部手动接入</p>
				<p>&nbsp;<span class="checkbox access" value="1"></span>&nbsp;启动自动接入，即当待回复人数低于设置人数，系统自动为您接入等待中的客户</p>
				<div class="join_member_box">
					<p>最大接入量    <input type="text" id="join_member" onkeyup="value=value.replace(/[^\d]/g,'')"> 人，不足时自动接入补充人数</p>
				</div>
			</div>
			<div class="automation_send_greetings">
				<p>接入客服时，是否启动自动问候语</p>
				<p>&nbsp;<span class="checkbox greet" value="0"></span>&nbsp;不启动自动问候语</p>
				<p>&nbsp;<span class="checkbox greet" value="1"></span>&nbsp;启用自动问候语</p>
				<textarea id="greetings_box" maxlength="100" placeholder="0|100"></textarea>
			</div>
		</div>
	</div>
	<div class="set_box shortcut_reply">
		<div class="reply_set">
			<label>
				<input type="checkbox" id="check_all" onclick="replyList(event)">
				<div class="show-box"></div>
			</label>
			<p>
				<input type="text" readonly value="批量移动分组">
				<i class="arrow"></i>
			</p>
			<span class="remove_reply_all">删除</span>
			<div class="add_list">
				<div class="add_expr"><span>+</span>新增常用语</div>
				<div class="add_grou"><span>+</span>新建分组</div>
				<div class="manage_grou"><span></span>&nbsp;管理分组</div>
			</div>
		</div>
		<div class="reply_table_top">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
				  <td width="20%" style="position:relative">
					<p class="group_toggle">全部分组&nbsp;&nbsp;<span class="switch_down"></span></p>
					<ul class="group_all">
						<li value="-1" title="全部分组">全部分组</li>
						<!-- <li class="group_name">打招呼</li>
						<li class="group_name">结束语</li>
						<li class="group_name">感谢语</li> -->
					</ul>
				  </td>
				  <td width="65%">内容</td>
				  <td width="15%" align="center">操作</td>
				</tr>
			</table>
		</div>
		<div class="reply_table_bg">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<!-- <tr>
					<td width="20%" style="text-indent:1.4em;">
						<label>
							<input type="checkbox" >
							<div class="reply_check"></div>
						</label>&nbsp;&nbsp;打招呼
					</td>
					<td width="65%"><input class="reply_content" type="text" value="您好，很荣幸为你服务" readonly></td>
					<td width="15%" align="center">
						<img class="amend_shortcut" src="customer_service/images/customer_service2_r12_r3_c1.png">
						<img class="delete_shortcut" src="customer_service/images/customer_service2_r12_r3_c5.png">
					</td>
				</tr>
				<tr>
					<td width="20%" style="text-indent:1.4em;">
						<label>
							<input type="checkbox" >
							<div class="reply_check"></div>
						</label>&nbsp;&nbsp;打招呼
					</td>
					<td width="65%"><input class="reply_content" type="text" value="您好，很荣幸为你服务" readonly></td>
					<td width="15%" align="center">
						<img class="amend_shortcut" src="customer_service/images/customer_service2_r12_r3_c1.png">
						<img class="delete_shortcut" src="customer_service/images/customer_service2_r12_r3_c5.png">
					</td>
				</tr> -->
			</table>
		</div>
		<div class="page_bottom">
			<div class="turn_page">
				<div class="last_page">
					<img src="customer_service/images/member_a2_r16_c8.png">
				</div>
				<div class="page_num">
					<input value="1" readonly="readonly">
					<div></div>
					<ul>
						
					</ul>
				</div>
				<div class="next_page">
					<img src="customer_service/images/member_a2_r16_c17.png">
				</div>
			</div>
		</div>
		
		<div class="add_expr_box">
			<img class="back" src="customer_service/images/ranking_a4_r2_c5.png">
			<div class="add_expr_data">
				<div class="add_expr_tit">请输入分组名称</div>
				<div class="add_expr_text">
					<input type="text">
				</div>
				<div class="add_expr_btn">
					<span>确&nbsp;定</span>
				</div>
			</div>
		</div>
		<div class="add_expr_box2">
			<img class="back" src="customer_service/images/ranking_a4_r2_c5.png">
			<div class="add_expr_data2">
				<div class="add_expr_tit2">分组&nbsp;&nbsp;&nbsp;<span class="add_grou">+建分组</span></div>
				<div class="add_expr_sele">
					<select>
						<option value="">未分组</option>
					</select>
				</div>
				<div class="add_expr_tit2">常用语</div>
				<div class="add_expr_textarea">
					<textarea></textarea>
				</div>
				<div class="add_expr_btn2">
					<span>确&nbsp;定</span>
				</div>
			</div>
		</div>
		<div class="group_sup_box">
			<div class="group_sup_tit">管理分组</div>
			<div class="group_data_count">
				<div class="group_data"><span>打招呼</span><img class="remove_group" src="customer_service/images/customer_service2_r12_r3_c5.png"></div>
				<div class="group_data"><span>打招呼</span><img class="remove_group" src="customer_service/images/customer_service2_r12_r3_c5.png"></div>
				<div class="group_data"><span>打招呼</span><img class="remove_group" src="customer_service/images/customer_service2_r12_r3_c5.png"></div>
				<div class="group_data"><span>打招呼</span><img class="remove_group" src="customer_service/images/customer_service2_r12_r3_c5.png"></div>
				<div class="group_data"><span>打招呼</span><img class="remove_group" src="customer_service/images/customer_service2_r12_r3_c5.png"></div>
				<div class="group_data"><span>打招呼</span><img class="remove_group" src="customer_service/images/customer_service2_r12_r3_c5.png"></div>
			</div>
			<div class="sub_save"><span>关&nbsp;闭</span></div>
		</div>
	</div>
</div>
<script>
var adminid=<?php echo $_SESSION['admin_id'];?>;
var admin_gfid=<?php echo $_SESSION['gfid'];?>;
var admin_gfaccount=<?php echo $_SESSION['gfaccount'];?>;
var admin_name="<?php echo ($_SESSION['lang_type']==0?$_SESSION['club_name']:$_SESSION['gfnick']);?>";
var club_id=<?php echo $_SESSION['club_id'];?>;
var ec_salt=<?php echo $_SESSION['ec_salt'];?>;
var nowTimeStamp = new Date('<?php echo date("Y-m-d H:i:s",intval(time()));?>');
var send_msg_url="<?php echo $this->createUrl("send_msg");?>";
function runTimeStamp() {       
	nowTimeStamp.setSeconds(nowTimeStamp.getSeconds() + 1);//此方法让now变量加1秒
}
setInterval("runTimeStamp();", 1000);//run方法每1秒运行1次
</script>
<script type="text/javascript" src="customer_service/js/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="customer_service/js/jquery.similar.msgbox.js"></script>
<script type="text/javascript" src="customer_service/js/jsencrypt.min.js"></script>
<script type="text/javascript" src="customer_service/js/aes_1.js"></script>
<script type="text/javascript" src="customer_service/js/common.js"></script>
<script type="text/javascript" src="customer_service/js/commonAjax.js"></script>
<script type="text/javascript" src="customer_service/js/mqttws31.js"></script>
<script type="text/javascript" src="customer_service/js/notify.js"></script>
<script type="text/javascript" src="customer_service/js/service_chat.js"></script>