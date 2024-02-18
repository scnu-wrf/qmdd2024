
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<link href="../qmdd/model/css/login_header.css" rel="stylesheet" type="text/css" />
		<link href="../qmdd/model/css/find_pass.css" rel="stylesheet" type="text/css" />
		<link href="../qmdd/model/css/unit_enter.css" rel="stylesheet" type="text/css">
		<link href="../qmdd/model/css/css.css" rel="stylesheet" type="text/css" />
		<script src="../qmdd/model/js/js_combo_show.js"></script>
		<title>找回登录密码</title>
	</head>
	<body onload="createCode()">
		<!--header-->
		<div class="nav" >
			<div class="nav_body">
				<div id="header-div">
					<a href="https://qmdd.gfinter.net/admin/index.php">
						<div id="logo-div" style="bgcolor:#eaeaea;">
							<img src="https://qmdd.gf41.net/admin/images/topLogo.png" alt="QMDD - power for e-commerce" />
						</div>
					</a>
					<div class="top_text1" >
						<span>没有GF平台帐号?&nbsp;
							<a id="top_register" href="https://www.gf41.net/GF/registers" target="_black">立即注册</a>
						</span>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<!-- 找回密码 -->
			<div class="find_pass_box" id="find_pass_box1">
				<div class="find_pass_titbox">
					<span class="find_pass_title" id="find_pass_title">找回密码</span>
				</div>
				<div class="find_pass_info_box" id="find_pass_info_box1">
					<div id="yan_box">
						<p>请输入账号:</p>
						<input type="text" name="account" id="account" placeholder="请输入GF账号"><br>
						<input maxlength="6" type="text" name="code" id="code" onkeyup="this.value=this.value.toUpperCase();" autocapitalize="on" placeholder="请输入验证码">
						<input type="text" class="register_yzm" onclick="createCode()" readonly="readonly" id="checkCode" name="checkCode" />
						<input id="get_phone" type="button" value="下一步">
					</div>
					<div id="identifying_code" style="display:none">
						<!--<input type="text" name="phone" id="phone" placeholder="手机号"><br>-->
						<div>为了保护账号安全，需要验证手机有效性</div>
						<div id="sent_codecheck">我们已向您绑定的手机<span id="phone_munber">131</span>发送了验证信息，请获取短信验证码</div>
						<input class="find_pass_yzm" maxlength="4" type="text" name="inputCode" id="inputCode"  placeholder="验证码">
						<input type="button" id="get_codes" value="点击获取验证码"  />
						<input id="find" class="submit-next" type="button" value="下一步">
					</div>
				</div>
				<!-- 修改登录密码 -->
				<div class="find_pass_info_box" id="find_pass_info_box2" style="display:none">
					<p>请输入新密码:</p>
					<input type="text" name="new_account" id="new_account" readonly="true" placeholder="account"><br>
					<input type="password" name="new_password" id="new_password" placeholder="新密码"><br>
					<input type="password" name="config_password" id="config_password" placeholder="二次确认密码"><br>
					<input id="revise" class="submit-next" type="button" value="提交">
				</div>
			</div>
			<!-- 底部 -->
			<div class="footer_bg">
				<div class="footer">
					<div class="footer_l">
						<p ><a>联系客服</a>&nbsp;|&nbsp;<a>运营规范</a>&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;版权所有&#169;2005-2017得闲体育软件有限公司 </p>
					</div>
					<div class="footer_r">
						<p><a style="color:#ff7b05;">中文</a>&nbsp;|&nbsp;<a>English</a></p>
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
	</body>
</html>
<script>
	$(document).ready(function(){
		$("#account").focus(function(){
			$("#account").css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
			$('#find_pass_info_box1 p').css({"color":"#333"});
		});
		$("#code").focus(function(){
			$("#code").css({"border-color":"#d9d9d9","box-shadow":"0 0 0 #ccc"});
		});
		$("#account").blur(function(){
			if($('#account').val()==''){
				$("#account").css({"border-color":"#f00","box-shadow":"0 0 5px red"});
				$('#find_pass_info_box1 p').css({"color":"#f00"});
			}
		});
		$("#code").blur(function(){
			if($('#code').val()==''){
				$("#code").css({"border-color":"#f00","box-shadow":"0 0 5px red"});
			}
		});
	});
	var act=getQueryString("act");
	// console.log('100--',act);
	var id=0;
	var yancode=0;
	var phone;//在全局 手机号
	function sendCode(thisBtn,time)//验证码倒计时
	{
		var clock = '';
		var nums = time;
		var btn;
		btn = thisBtn;
		btn.disabled = true; //将按钮置为不可点击
		btn.value = nums+'秒后可重新获取';
		clock = setInterval(doLoop, 1000); //一秒执行一次
		function doLoop()
		{
			nums--;
			if(nums > 0){
				btn.value = nums+'秒后可重新获取';
			}else{
			clearInterval(clock); //清除js定时器
				btn.disabled = false;
				btn.value = '没收到？重新发送验证码';
				nums = time; //重置时间
			}
		}
	}

	$(function () {
		createCode();
	});

	var code; //在全局 定义验证码
	function createCode() {
		code = "";
		var codeLength = 6;//验证码的长度
		var checkCode = document.getElementById("checkCode");
		var selectChar = new Array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9,'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');//所有候选组成验证码的字符，当然也可以用中文的
		for (var i = 0; i < codeLength; i++) {
			var charIndex = Math.floor(Math.random() * 36);
			code += selectChar[charIndex];
		}
		//alert(code);
		if (checkCode) {
			$("#checkCode").addClass("code");
		//  checkCode.addClass = "code";
			checkCode.value = code;
			checkCode.innerHTML = code;
		}
	}

	// $("#find").button().click(function(){//下一步2
	$("#find").on('click',function(){
		$("#new_account").val($("#account").val());
		check_account();
	});

	// $("#get_codes").button().click(function(){//获取验证码
	$("#get_codes").on('click',function(){
		sendCode(get_codes,60);
		get_administrators_phone();
		// get_phone_cod(phone);
	});

	// $("#revise").button().click(function(){//设置新密码
	$("#revise").on('click',function(){
		if($("#new_password").val()==""){
			alert("请输入新密码！");
			return;
		}else if($("#config_password").val()==""){
			alert("请输入确认密码！");
			return;
		}else if($("#new_password").val()!=$("#config_password").val()){
			alert("确认密码不一致！请重新输入");
			return;
		}
		else if($("#new_password").val().length<6){
			alert('输入的新密码小于6位');
			return;
		}
		set_newpassword();
	});

	// 下一步
	$('#get_phone').on('click', function(){
		if($('#account').val()==''){
			alert('请输入GF账号');
			return false;
		}
		if($('#code').val()==''){
			alert('请输入验证码');
			return false;
		}
		// console.log('192--'+$('#account').val());
		var checkcode=$("#checkCode").val();
		var inputcode=$("#code").val();
		// console.log('195=='+inputcode);
		// console.log('196=='+checkcode);
		if(checkcode==inputcode){
			// $("#yan_box").hide();
			get_administrators_phone();
		}
		else{
			alert("验证码错误！");
		}
	});

	function get_administrators_phone(){
		var account=$('#account').val();
		// console.log('208--'+account);
		$.ajax({
			type: 'get',
			url: '<?php echo $this->createUrl('getphonenumber'); ?>',
			data: {account:account},
			dataType: 'json',
			async: true,
			success: function(data){
				// console.log('216--',data);
				// console.log('217--',data['id']);
				if(data['phone'].length>=11){
					phone=data['phone'];
					phoneid=data['id'];
					// console.log('221--',phone);
					$('#phone_munber').html('<strong>'+data["phone"]+'<strong>');
					$('#phone').attr('readOnly',true);
					$('#account').attr('readOnly',true);
					$("#yan_box").hide();
					$('#get_phone').hide();
					$('#identifying_code').show();
				}
				else{
				    alert("该账号没有绑定手机号");
					return false;
                }
				sendCode(get_codes,60);
				get_phone_cod(phoneid);
			},
			error: function (request) {
				alert("账号错误");
			}
		});
	}

	function get_phone_cod(phoneid) {//mombile
		// console.log('243--',phoneid);
		$.ajax({
			type: 'get',
			url: '<?php echo $this->createUrl('dataSms'); ?>',
			data: {mobile:phoneid},
			async: true,
			dataType: 'json',
			success: function(data){
				// console.log('251--',data);
				yancode=data.sms_code;
				// console.log('253--',yancode);
			},
			error: function(request){
				alert("发送不了验证码");
			}
		});
	}

	function check_account(){
		var gfaccount=$("#account").val();
		var inputcode=$("#inputCode").val();
		//console.log(gfaccount+phone+inputcode);
		$.ajax({
			type: 'get',
			url: '<?php echo $this->createUrl('yanCode'); ?>',
			data: {gfaccount:gfaccount,phone:phoneid,inputcode:inputcode,yancode:yancode},
			async:true,
			dataType: 'json',
			success: function(data){
				// console.log('272--',data);
				id=data.phone;
				if(id>0){
					$("#find_pass_info_box1").hide();
					$("#find_pass_info_box2").show();
				}
				else{
					alert("输入信息有误！");
				}
			},
			error: function(request){
				alert("验证码错误");
			}
		});
	}

	function set_newpassword(){
		var account=$('#account').val();
		var new_pass=$("#new_password").val();
		// console.log('291--',new_pass);
		// console.log('292--',id);
		// console.log('293--',account);
		$.ajax({
			type: 'get',
			url: '<?php echo $this->createUrl('newpsd'); ?>',
			data: {id:id,new_pass:new_pass,account:account},
			async:true,
			dataType: 'json',
			success: function(data){
				// console.log('301--',data);
				alert("修改密码成功！");
				if(act=="forget_paypass"){
					window.location.href='../qmdd/account_security.php';
				}
				else{
					window.location.href='../privilege.php?act=login';
				}
			},
			error: function(request){
				alert("保存错误");
			}
		});
	}
</script>