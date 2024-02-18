<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>找回登录密码</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-detail">
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
     
     <div class="nav" >
  <div class="nav_body" style=" width:1230px; margin:0 auto;">
    <div id="header-div">
      <div id="logo-div" style="bgcolor:#eaeaea;"><img src="images/topLogo.png" alt="QMDD - power for e-commerce" /></div>
      <div class="top_text1" ><span>没有GF平台帐号?&nbsp;<a id="top_register" href="index.php?r=user/registers">立即注册</a></span></div>
  </div> 
  </div>
</div>

<div class="container">

<!-- 找回密码 -->
<div class="find_pass_box" id="find_pass_box1">
  <div class="find_pass_titbox"><span class="find_pass_title" id="find_pass_title">找回密码</span></div>
  <div class="find_pass_info_box" id="find_pass_info_box1" >
      <p>请输入账号:</p>
      <input type="text" name="account" id="account" placeholder="账号" ><br>
      <div id="yan_box">
      <input  style="width:48%;" maxlength="6" type="text" name="code" id="code"  >
      <input  style="width:48%; text-align:center;" type="text" class="register_yzm" onclick="createCode()" readonly="readonly" id="checkCode" name="checkCode" id="checkCode" /> 

      <input id="get_phone" type="button" style="margin-top:50px;margin-left:10px; width:300px; height:40px" value="下一步"> 
      </div>

      <div id="identifying_code" style="display:none" >
      <!--<input type="text" name="phone" id="phone" placeholder="手机号" ><br>-->
      <div>为了保护账号安全，需要验证手机有效性</div>
      <div id="sent_codecheck" >我们已向您绑定的手机<span id="phone_munber">131</span>发生了验证信息，请获取验证码短信</div>
      <input class="find_pass_yzm" maxlength="4" type="text" name="inputCode" id="inputCode"  placeholder="验证码">
      <input type="button" id="get_codes" style="height:34px;width:150px; " value="点击获取验证码"  />
      <input id="find" type="button" style="margin-top:50px;margin-left:10px; width:300px; height:40px" value="下一步"> 
      </div>
  </div>
<!-- 修改登录密码 -->

  <div class="find_pass_info_box" id="find_pass_info_box2"  style="display:none" >
      <p>请输入新密码:</p>
      <input type="text" name="new_account" id="new_account" readonly= "true " placeholder="account"><br>
      <input type="password" name="new_password" id="new_password" placeholder="新密码"><br>
      <input type="password" name="config_password" id="config_password" placeholder="二次确认密码"><br>
      
      <input id="revise" type="button" style="margin-top:50px;margin-left:10px; width:300px; height:40px" value="提交"> 
          
  </div>    

  
  
</div>
<!-- 底部 -->
<div class="footer_bg" style="width:100%; height:70px;">
  <div class="footer" style="width:1230px; margin:auto; border-top:solid 1px #CCCCCC;">
    <div class="footer_l" style="width:500px; float:left;">
      <p ><a>联系客服</a>&nbsp;|&nbsp;<a>运营规范</a>&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;版权所有&#169;2023-2025得闲体育软件有限公司 </p>
    </div>
    <div class="footer_r" style="width:200px; float:right;">
      <p><a style="color:#ff7b05;">中文</a>&nbsp;|&nbsp;<a>English</a></p>
    </div>
    <div class="clear"></div>
  </div>
</div>
</div>
        <div class="box-detail-submit"><button onclick="submitType='baocun'" class="btn btn-blue" type="submit">保存</button><button class="btn" type="button" onclick="we.back();">取消</button></div>
        <?php $this->endWidget(); ?>
    </div><!--box-detail end-->
</div><!--box end-->


<script>
 var act=getQueryString("act");
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
        btn.value = '点击发送验证码';
        nums = time; //重置时间
      }
     }
}
var code; //在全局 定义验证码
createCode();   
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


$("#find" ).button().click(function(){//下一步2
	$("#new_account").val($("#account").val());
	check_account();
  });
$("#get_codes" ).button().click(function(){//获取验证码
	sendCode(get_codes,60);
	get_phone_cod(phone);
  });
$("#revise" ).button().click(function(){//设置新密码
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
	set_newpassword();
  });
$("#get_phone" ).button().click(function(){//下一步1
   
   var checkcode=$("#checkCode").val();
   var inputcode=$("#code").val();
   if(checkcode==inputcode){
    $("#yan_box").hide();
    get_administrators_phone();}
    else
      alert("验证码错误！");
  });
function get_phone_cod(phone) {//mombile 
	 //console.log(phone);
   $.ajax({
              url: "data_sms.php",
              data:"action=send_sms&mobile="+phone,//&mobile=13622721233+mombile
              type: 'post',
              async:true,
              dataType: 'json',
              success: function (data) {
                yancode=data["msg"];
                //console.log(yancode);            
              },
              error: function (request) {
                  alert("发生不了验证码");   
              }
          });
}
function check_account(){

	var gfaccount=$("#account").val();
	var inputcode=$("#inputCode").val();
	//console.log(gfaccount+phone+inputcode);
	$.ajax({
              url: "findpassword_interfaces.php",
              data:"action=find_password&gfaccount="+gfaccount+"&phone="+phone+"&inputcode="+inputcode+"&yancode="+yancode,
              type: 'post',
              async:true,
              dataType: 'json',
              success: function (data) {  
                id=data;
                //console.log(id);
                if(id>0){
                	$("#find_pass_info_box1").hide();
                	$("#find_pass_info_box2").show();
                }
                else{alert("输入信息有误！");}  
              },
              error: function (request) {
                  alert("wrong"); 
              }

          });
}
function set_newpassword(){
	var new_pass=$("#new_password").val();
	$.ajax({
              url: "findpassword_interfaces.php",
              data:"action=set_newpassword&id="+id+"&new_pass="+new_pass+"&act="+act,
              type: 'post',
              async:true,
              dataType: 'json',
              success: function (data) {
              //console.log(data);        
                alert("修改密码成功！");
              if(act=="forget_paypass")
                window.location.href='account_security.php';
              else
                window.location.href='../privilege.php?act=login';

              },
              error: function (request) {
                  alert("wrong2");             
              }
          });
}
 function get_administrators_phone(){

  var account=$("#account").val();
  //console.log(account);
    $.ajax({
              url: "findpassword_interfaces.php",
              data:"action=get_phone_number&account="+account,
              type: 'post',
              async:true,
              dataType: 'json',
              success: function (data) {
                //console.log(data);
                if(data["phone"]>0){
                phone=data["phone"];
                $("#phone_munber").html(data["phoneshow"]);  
                
                $('#phone').attr('readOnly',true);
                $('#account').attr('readOnly',true);
                $("#get_phone").hide();
                $("#identifying_code").show();}
                else
                  alert("该账号没有绑定手机号");
                 sendCode(get_codes,60);
                 get_phone_cod(phone);
              },
              error: function (request) {
                  alert("wrong3");
              }

          });
 }
</script>