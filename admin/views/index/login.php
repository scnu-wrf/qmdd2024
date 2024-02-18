
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <title><?php echo $cp_home;?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link href="styles/general.css" rel="stylesheet" type="text/css" />
    <link href="styles/main.css" rel="stylesheet" type="text/css" />
    <link href="styles/unit_enter.css" rel="stylesheet" type="text/css">
    <style type="text/css">
      body,html {
        height: 100%;
        overflow: hidden;
      }
    </style>
    <script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.json.js"></script>
    <script type="text/javascript" src="js/global.js"></script>
    <script type="text/javascript" src="js/utils.js"></script>
    <script type="text/javascript" src="js/transport_jquery.js"></script>
    <script language="JavaScript">
      // 这里把JS用到的所有语言都赋值到这里
      var process_request = "正在处理您的请求...";
      var todolist_caption = "记事本";
      var todolist_autosave = "自动保存";
      var todolist_save = "保存";
      var todolist_clear = "清除";
      var todolist_confirm_save = "是否将更改保存到记事本？";
      var todolist_confirm_clear = "是否清空内容？";
      var user_name_empty = "管理员用户名不能为空!";
      var password_invaild = "密码必须同时包含字母及数字且长度不能小于6!";
      var email_empty = "Email地址不能为空!";
      var email_error = "Email地址格式不正确!";
      var password_error = "两次输入的密码不一致!";
      var captcha_empty = "您没有输入验证码!";
      if (window.parent != window) {
          window.top.location.href = location.href;
      } 
    </script>
  </head>
  <body style="height: 100%;padding: 0">
    <div class="nav" >
      <div class="nav_body" style=" width:1230px; margin:0 auto;">
      <div id="header-div">
        <div id="logo-div" style="bgcolor:#eaeaea;"></div>
        <div class="top_text1" style="bgcolor:#eaeaea; float:right; line-height:76px;">第一次使用?&nbsp;<a id="top_register" href="#">立即入驻</a></div>
      </div> 
      </div>
    </div>

    <!--///////////////头部分割线  -->
    <form class="login-body" name='theForm' onsubmit="return validate()">
      <div class="login_all" style="width:1230px; margin:auto;">
        <div class="login_all_text" style="font-weight:bold;font-size:30px;color: white;">
        <span>中<font size="50">体</font>得闲</span>
        <p style="font-weight:bold;font-size:15px;color: white;">一站式解决您的休闲需求，体育场地、活动报名、教练预约，体育赛事、演唱会购票，</p>
        <p style="font-weight:bold;font-size:15px;color: white;">尽在其中，畅享休闲乐趣！</p>
        </div>
      <div class="login-hd"></div>
      <div class="center-wrap" id="centerWrap">
        <div class="login-center">
          <div class="bd-logo"></div>
        </div>
        <div class="message"></div>
          <div class="z-bd">
            <div class="login-panel" id="loginPanel">
            <h3 class="panel-hd cl-link-blue"></h3>
            <div class="controls first">
              <svg class="iconphone" width="20px" height="20px" viewBox="0 0 20 20">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                  <g id="2-copy-2" sketch:type="MSArtboardGroup" transform="translate(-505.000000, -357.000000)" fill="#666">
                    <path d="M517.388314,366.868305 C519.068314,366.001784 520.220053,364.252653 520.220053,362.231784 C520.220053,359.350479 517.883966,357.014392 515.002662,357.014392 C512.121357,357.014392 509.78527,359.350479 509.78527,362.231784 C509.78527,364.252653 510.936575,366.001784 512.616575,366.868305 C508.246575,367.938305 505.002662,371.879175 505.002662,376.57961 C505.002662,376.81961 505.197009,377.014392 505.437444,377.014392 C505.677444,377.014392 505.872227,376.81961 505.872227,376.57961 C505.872227,371.537001 509.960053,367.449175 515.002662,367.449175 C520.04527,367.449175 524.133096,371.537001 524.133096,376.57961 C524.133096,376.81961 524.327444,377.014392 524.567879,377.014392 C524.807879,377.014392 525.002662,376.81961 525.002662,376.57961 C525.002662,371.879175 521.758749,367.938305 517.388314,366.868305 L517.388314,366.868305 Z M510.654835,362.231784 C510.654835,359.830479 512.601357,357.883957 515.002662,357.883957 C517.403966,357.883957 519.350488,359.830479 519.350488,362.231784 C519.350488,364.632653 517.403966,366.57961 515.002662,366.57961 C512.601357,366.57961 510.654835,364.632653 510.654835,362.231784 L510.654835,362.231784 Z" id="id" sketch:type="MSShapeGroup"></path>
                  </g>
                </g>
              </svg>
              <input type="text" name="username" id="username" placeholder="用户名" />
            </div>
            <div class="controls two">
              <svg class="iconphone" width="20px" height="20px" viewBox="0 0 20 20">
                <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                  <g id="2-copy-2" sketch:type="MSArtboardGroup" transform="translate(-505.000000, -407.000000)" fill="#666">
                    <path d="M515,418.304324 C514.12782,418.304324 513.421091,418.888119 513.421091,419.608723 C513.421091,419.995004 513.624357,420.341947 513.947394,420.580774 L513.947394,421.782554 C513.947394,422.262857 514.418637,422.652187 515.00003,422.652187 C515.581302,422.652187 516.052667,422.262857 516.052667,421.782554 L516.052667,420.580774 C516.375703,420.341947 516.579,419.995004 516.579,419.608723 C516.57897,418.888119 515.87221,418.304324 515,418.304324 L515,418.304324 L515,418.304324 Z M522.368454,414.391327 L521.315788,414.391327 L521.315788,412.217421 C521.315788,409.335657 518.488418,407 515,407 C511.511582,407 508.684212,409.335657 508.684212,412.217421 L508.684212,414.391327 L507.631576,414.391327 C506.178003,414.391327 505,415.364503 505,416.565234 L505,424.826193 C505,426.026824 506.178003,427 507.631576,427 L522.368424,427 C523.821422,427 525,426.026899 525,424.826193 L525,416.565234 C525.00003,415.364478 523.821422,414.391327 522.368454,414.391327 L522.368454,414.391327 L522.368454,414.391327 Z M515,407.869583 C517.906571,407.869583 520.263152,409.816309 520.263152,412.217396 L520.263152,414.391302 L509.737544,414.391302 L509.737544,412.217396 L509.736848,412.217396 C509.736848,409.816309 512.093459,407.869583 515,407.869583 L515,407.869583 L515,407.869583 Z M523.947364,424.826093 C523.947364,425.546622 523.240604,426.130392 522.368454,426.130392 L507.631606,426.130392 C506.759396,426.130392 506.052667,425.546622 506.052667,424.826093 L506.052667,416.565234 C506.052667,415.84468 506.759426,415.260835 507.631606,415.260835 L522.368454,415.260835 C523.240635,415.260835 523.947364,415.844705 523.947364,416.565234 L523.947364,424.826093 L523.947364,424.826093 L523.947364,424.826093 Z" id="pw" sketch:type="MSShapeGroup"></path>
                  </g>
                </g>
              </svg>
              <input type="password" id="password" placeholder="密码"/>
              <input type="hidden" id="password_md5" name="password">
            </div>
            <div class="controls last">
            <input type="submit" class="btn-a" value="登录"  onclick="login();" />
              <span style="display: none" id="login_error_msg"></span>

            </div>
            <div class="controls bside" style="border: none">
              <input type="checkbox" value="1" name="remember" id="remember" />
              <label for="remember">保存登录信息</label>
              <a class="link-forget cl-link-blue" href="get_password.php?act=forget_pwd">忘记密码?</a>
              <a class="link-home cl-link-blue" href="../">去店铺首页>></a>
            </div>
          </div>
        </div>
      </div>
      <input type="hidden" name="act" value="signin" />
      </div>
    </form>
<style>
  .login-body{
    background-color: red;
     height:75%;
  }
  #bottomContainer{
    background-color: #181a1a;
    width: 100%;
    height: 25%;
    position: fixed;
    bottom: 0;
  }
  #bottomInnerContainer1{
     width: 93%;
     margin: auto;
     margin-top: 10px;
     border-top: 1px dotted #ccc;
     border-bottom: 1px dotted #ccc;
     height: 180px;
     display: flex;
     align-items: center;
     justify-content: center;
     gap: 20px;
  }
  #bottomInnerContainer2{
     width: 93%;
     margin: auto;
     margin-top: 10px;
     display: flex;
     align-items: center;
     justify-content: space-between;
     color:#9ca2a2;
  }
  #rightContinaer{
    display: flex;
    gap: 15px;
  }
  .rightItem{
      color: white;
      text-align:center;
  }
  .rightItem img{
     width: 70px;
     height: 70px;
  }
  .minInfo{
    color:#9ca2a2;
  }
  #midContainer{
    display: flex;
    gap: 5px;
    flex-direction: column;
  }
  #leftContainer{
    gap:5px;
    display: flex;
    flex-direction: column;
    color: white;
  }
</style>

<div id="bottomContainer">
  <div id="bottomInnerContainer1">
     <div style="display:flex;gap:15px;justify-content: space-around;flex-direction: row;width: 100%;">
     <div id="leftContainer">
        <div style="color: white;">关于</div>
        <div style="font-weight: bold;">关于我们</div>
        <div style="font-weight: bold;">合作伙伴</div>
     </div>
     <div id="midContainer">
        <div style="color: white;">联系</div>
        <div class="midInfo" style="color:#9ca2a2">邮箱：mai1976@qq.com</div>
        <div class="midInfo" style="color:#9ca2a2">电话：18929501976</div>
        <div class="midInfo" style="color:#9ca2a2">微信：18929501976</div>
        <div class="midInfo" style="color:#9ca2a2">地址：广州市天河区天府路239-257号212室A484</div>
     </div>
     <div id="rightContinaer">
          <div class="rightItem">
             <img src="\sports\images\测试版二维码.jpg">
             <p>小程序二维码</p>
          </div>
          <div class="rightItem">
             <img src="\sports\images\测试版二维码.jpg">
             <p>官方客服二维码</p>
          </div>
          <div class="rightItem">
             <img src="\sports\images\logo.png" style="display:block;background-color: white;">
             <p>合作伙伴LOGO</p>
          </div>
     </div>
    </div>
  </div>
  <div id="bottomInnerContainer2">
     <div>版权所有：得闲体育</div>
     <div>备案号：粤ICP备14073264号-7</div>
  </div>
</div>
<script src="js/md5.js"></script>
<script language="JavaScript">

  document.forms['theForm'].elements['username'].focus();
  
  /**
   * 检查表单输入的内容
   */
  function validate()
  {

    var username = document.getElementById('username');
    var password_input = document.getElementById('password');
    var password_md5 = document.getElementById('password_md5');

    password_md5.value =  hex_md5(username.value+password_input.value);

    return true;
  }
  
</script>

<script>
function login() {

      var post_data = $("#CActiveForm").serialize();
      var s1=$("#username").val();
      var s2='<?php echo $this->createUrl("index/checkUser");?>';
       $.ajax({
        type: 'get',
        url: s2,
        data: {TUNAME: s1,PASSWORD:$("#password").val()},
        dataType:'json',
        success: function(data) {
          if (data.TUNAME==s1){
             var s22='<?php echo $this->createUrl("index/index");?>';
             window.location.href =s22;
          }else{
            // alert("密碼有錯");
          }
       },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
        }
    });
 }
//window.alert
function aa(str)   
  { 
var iframe = document.createElement("IFRAME");
iframe.style.display="none";
iframe.setAttribute("src", 'data:text/plain');
document.documentElement.appendChild(iframe);
window.frames[0].window.alert(str);
iframe.parentNode.removeChild(iframe);

 //function       Alert(strText){
    //   var       pWin=window.showModalDialog("b.htm",str,"dialogHeight:116px;       dialogWidth:232px;       help:       No;       resizable:       no;       status:       No;       scroll:no;       dialogTop:"+(screen.height-116)/2+"px;       dialogLeft:"+(screen.width-232)/2+"px;");
   //    }
  } 
</script>

  </body>
</html>