<style type="text/css">
#center {
  MARGIN-RIGHT: auto;
  MARGIN-LEFT: auto;
}
.STYLE2 {
  color: #FF0000
}
._tittle {
  border-bottom: solid 1px #CCCCCC;
}
.button { padding: 5px 15px 5px; margin: 2px 2px; border: none; background: #ff3f3f; color: #FFF; cursor: pointer; border-radius:3px; font-size:14px;font-family:"方正兰亭黑_GBK";}
.as_item_title {font-size:16px;font-family:"方正兰亭黑_GBK";}
.as_item_phone {color:#FF6700;}
.as_item_detail {font-family:"方正兰亭黑_GBK";}
.as_item_btn {border:none; background:none; font-size:14px !important; font-family:"方正兰亭黑_GBK"; cursor:pointer;}

.dialog_content {TEXT-ALIGN: center; width:100%; position:absolute !important; top:0;}
.change_pwd_text {width:300px; height:40px; border-radius:3px; border:solid 1px #CCCCCC;font-size:14px;font-family:"方正兰亭黑_GBK"; margin-bottom:10px !important; text-indent:1em;}
.change_pro {width:300px; height:40px; border:none; border-radius:4px; margin-top:20px; background:#ff9024;font-size:16px;font-family:"方正兰亭黑_GBK"; color:#FFFFFF; cursor:pointer;}
.dialog_title_bg {width:100%; font-family:"方正兰亭黑_GBK"; line-height:50px; color:#000000; border-bottom:solid 1px #CCCCCC; margin-bottom:30px; font-weight:normal;}
.wang_pwd {width:300px; margin:auto; text-align:right; font-size:16px; font-family:"方正兰亭黑_GBK"; line-height:100px; font-weight:normal;}
.dialog_title_bg span {font-size:14px; text-align:left !important;}
.as_step1 {color:#FD1F00;}
.as_step2 {color:#FF7E00;}
.as_step3 {color:#FFB600;}
.dialog_title {display:inline-block !important; width:180px !important; text-align:left !important; font-size:18px !important; text-indent:1em;}
.phone_text {width:300px; height:40px; text-align:center; border:none; background:none; font-size:16px;font-family:"方正兰亭黑_GBK";}
.yan_text {width:200px; height:40px; text-align:center; border:none; background:none; font-size:16px;font-family:"方正兰亭黑_GBK"; border-bottom:solid 1px #CCCCCC;}
.yan_btn {width:100px; height:40px; border:none; background:none; font-size:16px;font-family:"方正兰亭黑_GBK"; border-bottom:solid 1px #CCCCCC;color:#FF7E00; cursor:pointer;}
input[type="button"] {cursor:pointer;}
</style>

<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>帐号安全</h1><span class="back">
    </span></div><!--box-title end-->
    <div class="box-detail" >
    <?php  $form = $this->beginWidget('CActiveForm', get_form_list()); ?>
    <table>
      <tr>
        <td><p class="as_item_title">绑定手机&nbsp;&nbsp;<span class="as_item_phone" id="phone_nember"></span></p>
          <p class="as_item_detail">管理联系手机，找回密码</p></td>
        <td width="100"><input name="change_phone" type="button" id="change_phone" onClick="fnPhone();" value="修改" class="btn" /></td>
      </tr>
    </table>
    <table>
      <tr>
        <td><p class="as_item_title">登录密码</p>
          <p class="as_item_detail">修改登录密码</p></td>
        <td width="100"><input name="change_password" type="button" id="change_password" value="修改" class="btn"/></td>
        <!-- onclick="window.location.href='change_pwd.php'"--> 
      </tr>
    </table>
    <table>
      <tr>
        <td><p class="as_item_title">支付密码</p>
          <p class="as_item_detail">修改支付密码</p></td>
        <td width="100"><input name="change_pay_password" type="button" class="btn" id="change_pay_password" value="修改" /></td>
      </tr>
    </table>
<?php $this->endWidget(); ?>
</div><!--box-detail end-->
</div><!--box end-->
<script>
var PhoneHtml='<div style="width:500px;">'+
'<table class="box-detail-table showinfo">'+
    '<tr>'+
        '<td width="20%">绑定手机号</td>'+
        '<td><input id="phone" name="phone" type="text" value="<?php echo $model->phone;?>" class="text-input"></td>'+
    '</tr>'+
    '<tr>'+
        '<td>验证码</td>'+
        '<td><input id="phone_yan" name="phone_yan" type="text" value="" class="text-input"><input type="button" id="get_codes" class="btn" onClick="fnPhone();"get_code() value="发送验证码" /><input name="act" id="act" type="hidden" value="change_phone" /><input name="id" id="id" type="hidden" value="" /><input name="smscode" id="smscode" type="hidden" value="" /></td>'+
    '</tr>'+
'</table>';
// 绑定手机号
var fnPhone=function(){
    $.dialog({
        id:'phone',
        lock:true,
        opacity:0.3,
        title:'手机号码',
        content:PhoneHtml,
        button:[
            {
                name:'提交',
                callback:function(){
                    return fnSendInvite();
                },
                focus:true
            },
            {
                name:'取消',
                callback:function(){
                    return true;
                }
            }
        ]
    });
};
</script>


<script>
 var admin_id = <?php echo $_SESSION['admin_id'];?>;//qmdd_administrators表的id
 var yancode;//验证码
 var pay_pass;
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

 function check(phone){//检测号码有效性
    var reg = /^0?1[3|4|5|8][0-9]\d{8}$/;
     return "true";
       if (reg.test(phone)) 
            return "true";
      else
        alert("手机号有误！");
    }

function show_main(p){
   $("#show_main").hide();
   $("#dialog_bind").hide();
   $('#dialog_change_pwd').hide();
   $('#dialog_set_pwd').hide();
   $('#act').val(p);
   if(p==0) $("#show_main").show();
   if(p==1) $("#dialog_bind").show();
   if(p==2) $("#dialog_change_pwd").show();
   if(p==3) $("#dialog_set_pwd").show();
}

$("#back" ).click(function(){show_main(0);});
$("#back1" ).click(function(){show_main(0);});
$("#back2" ).click(function(){show_main(0);});

$("#change_phone" ).click(function(){show_main(1); });
$("#change_password" ).click(function(){show_main(2);});
$("#change_pay_password" ).click(function(){show_main(3);});

$("#set_submit_paypass" ).click(function(){//设置支付密码
     if($("#set_new_paypass").val()==""){
              alert("请输入新密码！");return;
          }else if($("#set_confirm_paypass").val()==""){
              alert("请输入确认密码！");return;
          }else if($("#set_new_paypass").val()!=$("#set_confirm_paypass").val()){
              alert("确认密码不一致！请重新输入");return;
          }
       update_submit();
  });
$("#submit_pwd").click(function () {
      if($("#old_pwd").val()==""){
            alert("请输入原密码！");return;
        }else if($("#new_pwd").val()==""){
            alert("请输入新密码！");return;
        }else if($("#confirm_pwd").val()==""){
            alert("请输入确认密码！");return;
        }else if($("#new_pwd").val()!=$("#confirm_pwd").val()){
            alert("确认密码不一致！请重新输入");return;
        }
       update_submit();
  });

$("#submit_yan" ).click(function(){//提交验证码】
  f($('#smscode').val()!=$("#phone_yan").val()){
            alert("验证码错！请重新输入");return;
        }
   update_submit();
 });

function get_code(){//发验证码
console.log('hgf==1');
var p=$("#phone").val();
	console.log('hgf=='+p);
  if(check($("#phone").val())=="true"){
    get_phone_code($("#phone").val());
    sendCode(get_codes,60);
   }
 });

 function update_submit() {
  var s2='<?php echo $this->createUrl("Clubadmin/updatepassword");?>';  
   $.ajax({
        type: 'get',
        url: s2,
        data: {phone:$('#phone').val(),newpwd:$("#new_pwd").val(),
        set_pwd:$("#set_new_paypass").val(),act:$("#act").val()},
        dataType:'json',
        success: function(data) {
                  if (data.phone==s1){
                    $('#smscode').val(data.smscode);
                  }else{
                    we.msg('minus', '密码修改成功');
                    }
                },
          error: function (request) {
          }
      });
  }

 //show_phone_nember();
function get_phone_code() {
   var s1=$('#phone').val();
   var s2='<?php echo $this->createUrl("Public/smscode");?>';  
   $.ajax({
        type: 'get',
        url: s2,
        data: {mombile:s1},
        dataType:'json',
        success: function(data) {
                  if (data.mombile==s1){
                    $('#smscode').val(data.scode);
                  }else{
                    we.msg('minus', '该账号没有资质');
                    }
                },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest); 
            }
    });
}

</script>
<!--div  id="dialog_change_pwd" style="display:none;">
  <div id="center" class="login">
    <div class="dialog_title_bg"> <span id="change_password_title" class="dialog_title">修改登录密码</span>
    <input name="back1" type="button" style=" margin-top:15px; float:right;" id="back1" value="返回" />
      <div class="clear"></div>
    </div>
    <p>
      <input name="old_pwd" type="password" class="change_pwd_text" id="old_pwd" placeholder="原密码" />
    </p>
    <p>
      <input name="new_pwd" type="password" class="change_pwd_text" id="new_pwd" placeholder="新密码" />
    </p>
    <p>
      <input name="confirm_pwd" type="password" class="change_pwd_text" id="confirm_pwd" placeholder="确认密码" />
    </p>
    <p>
      <input name="submit_pwd" type="button" class="change_pro" id="submit_pwd" value="提交" />
    </p>
    <div id="forget_password" style="display:none;" class="wang_pwd"><a href="find_pass.php?act=forget_password">忘记密码?</a></div>
  </div>
</div>
<!--设置新密支付密码码框>
<div  id="dialog_set_pwd" style="display:none;">
  <div id="center" class="login">
    <div class="dialog_title_bg"> <span id="change_password_title" class="dialog_title">设置支付密码</span>
    <input name="back2" type="button" style=" margin-top:15px; float:right;" id="back2" value="返回" />
      <div class="clear"></div>
    </div>
    <p>
      <input name="set_new_paypass" type="password" class="change_pwd_text" id="set_new_paypass" placeholder="新密码" />
    </p>
    <p>
      <input name="set_confirm_paypass" type="password" class="change_pwd_text" id="set_confirm_paypass" placeholder="确认密码" />
    </p>
    <p>
      <input name="set_submit_paypass" type="button" class="change_pro" id="set_submit_paypass" value="提交" />
    </p>
  </div>
</div>
<!--修改密码弹框-->