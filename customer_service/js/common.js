var ctx='https://www.gfinter.net/GF/';
//判断浏览器
var browser = {
    versions: function () {
        var u = navigator.userAgent,
            app = navigator.appVersion;
        return { //移动终端浏览器版本信息
            trident: u.indexOf('Trident') > -1, //IE内核
            presto: u.indexOf('Presto') > -1, //opera内核
            webKit: u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
            gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
            mobile: !! u.match(/AppleWebKit.*Mobile.*/) || !! u.match(/AppleWebKit/), //是否为移动终端
            ios: !! u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
            android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
            iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
            iPad: u.indexOf('iPad') > -1, //是否iPad
            webApp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
        };
    }(),
    language: (navigator.browserLanguage || navigator.language).toLowerCase()
}
//iOS的版本判断：
function get_ios_version(){
    var ua = navigator.userAgent.toLowerCase();
    var version = null;
    if (ua.indexOf("like mac os x") > 0) {
        var reg = /os [\d._]+/gi;
        var v_info = ua.match(reg);
        version = (v_info + "").replace(/[^0-9|_.]/ig, "").replace(/_/ig, "."); //得到版本号9.3.2或者9.0
        version = parseInt(version.split('.')[0]); // 得到版本号第一位
    }

    return version;
}
//Android的版本判断：
function get_android_version() {
    var ua = navigator.userAgent.toLowerCase();
    var version = null;
    if (ua.indexOf("android") > 0) {
        var reg = /android [\d._]+/gi;
        var v_info = ua.match(reg);
        version = (v_info + "").replace(/[^0-9|_.]/ig, "").replace(/_/ig, "."); //得到版本号4.2.2
        version = parseInt(version.split('.')[0]);// 得到版本号第一位
    }

    return version;
}
//ajax遮盖
function showmask(){
	var mask='<img id="progressImgage" src="'+ctx+'resources/images/admin/register/loading.gif" style="z-index: 1000; position: fixed; top: 50%; left: 50%; margin-top: -40px; margin-left: -40px; width: 80px; height:80px;">'+
	'<div id="maskOfProgressImage" class="mask hide" style="position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1000; opacity: 0.1; background-color: rgb(0, 0, 0);"></div>';
	$("body").append(mask);
}
//隐藏ajax遮盖
function hidemask(){
	$("#progressImgage").remove();
	$("#maskOfProgressImage").remove();
}

//获取当前位置提示
function position_msg(){
	var mask='<div id="position_msg" style="z-index: 2000;position: fixed;top: 50%;left: 50%;width: 400px;height: 120px;line-height: 120px;background: #fff;text-align: center;margin-left: -200px;margin-top: -60px;box-shadow: 0 0 10px 1px rgba(0,0,0,0.6);border-radius: 5px;">获取当前位置中，请等待~</div><div id="position_msg_mask" class="mask hide" style="position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1000; opacity: 0;"></div>';
	$("body").prepend(mask);
}
function position_msg_hide(){
	$("#position_msg").fadeOut();
	$("#position_msg_mask").hide();
}

//设置属性，页面间传值
function setAttribute(object,fun){
	var map = new Map();
	for(var j in object){map.put(j,object[j]);}
	$.ajaxloading({
		url:"setAttribute",
		data:map.toJSON(),
		type:"post",
		success:function(e){
	        if(e.error==1) return $.MsgBox.Alert("温馨提示",system_error_msg),!1;
	        else fun();
		}
	});
}

//获取属性
function getAttribute(array,fun){
	var map = new Map();
	for(var i in array){map.put(array[i],"");}
	$(document).queue(function(){
		$.ajaxloading({
			url:"getAttribute",
			data:map.toJSON(),
			type:"post",
			success:function(e){
		        if(e.error==1) return $.MsgBox.Alert("温馨提示",system_error_msg),!1;
		        else fun(e);
		        $(document).dequeue();
			}
		});
	})
}

//移除属性
function removeAttribute(array,fun){
	var map = new Map();
	for(var i in array){map.put(array[i],"");}
	$.ajaxloading({
		url:"removeAttribute",
		data:map.toJSON(),
		type:"post",
		success:function(e){
	        if(e.error==1) return $.MsgBox.Alert("温馨提示",system_error_msg),!1;
	        else fun();
		}
	});
}

//重置系统超时时间倒计时
function resetTimeOut(){setInterval('console.log(new Date($.ajax({async: false}).getResponseHeader("Date")).format("yyyy/MM/dd hh:mm:ss"));console.clear();',1799000)}

//检查是否设置支付密码
function isSetPayPass(fun1,fun2){
	var time_stamp=nowTimeStamp.getTime();
	var keyword = new Map();
	keyword.put("visit_id",visitId);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.gfid=gfId;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,loginSignKey.slice(0,16),loginSignKey.slice(16));//（原请求参数+ts时间戳的json格式base64编码后经过visit_id对应key的AES加密，前16为为密钥，后16位为偏移量）
	keyword.put("enparams",enparams);
	$.ajaxloading({
		url:"Test/isSetPayPass",
		data:keyword.toJSON(),
		type:"post",
		success:function(e){
			if("失败"==e.result)return $.MsgBox.Alert("温馨提示",system_error_msg),!1;
			e=$.parseJSON(e.result);
			console.log(e)
			e=$.parseJSON(AES_decode(e.endata,loginSignKey.slice(0,16),loginSignKey.slice(16)));
			console.log(e)
			if(e.error==0){
				fun1();
			}else{
				fun2();
			}
		}
	});
}

//检查支付密码是否正确
function isPayPass(pass,fun1,fun2){
	var time_stamp=nowTimeStamp.getTime();
	var keyword = new Map();
	keyword.put("visit_id",visitId);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.gfid=gfId;
	enparams.pass=md5(pass);
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,loginSignKey.slice(0,16),loginSignKey.slice(16));//（原请求参数+ts时间戳的json格式base64编码后经过visit_id对应key的AES加密，前16为为密钥，后16位为偏移量）
	keyword.put("enparams",enparams);
	$.ajaxloading({
		url:"Test/isPayPass",
		data:keyword.toJSON(),
		type:"post",
		success:function(e){
			if("失败"==e.result)return $.MsgBox.Alert("温馨提示",system_error_msg),!1;
			e=$.parseJSON(e.result);
			e=$.parseJSON(AES_decode(e.endata,loginSignKey.slice(0,16),loginSignKey.slice(16)));
			console.log(e)
			if(e.error==0){
				fun1();
			}else{
				fun2();
			}
		}
	});
}

//检查是否登录
function checkLogin(fun,force){
	if(logined){
		if(fun)
			fun();
	}else{
		if(force){//强制跳转登录
			$.MsgBox.Alert("温馨提示",not_login_msg,function(){
				goLogin();
			});
		}else{
			$.MsgBox.Confirm("温馨提示",not_login_msg,function(){
				goLogin();
			});
		}
		return false;
	}
}

//去登录
function goLogin(){
	var map = new Map();
	var url=window.location.pathname.replace(ctx,"")+window.location.search;
	map.put("url",url);
	$.ajaxloading({
		url:"GFUser/saveStateBeforeLogin",
		data:map.toJSON(),
		success:function(e){
			var data = e["result"];
			if(data == "成功"){
				window.location.href = ctx + "logins";
			}else if(data == "失败"){
				$.MsgBox.Alert("温馨提示",system_error_msg);
				return false;
			}
		}
	});
}

//单位导购去登录
function goClubLogin(){window.location.href=ctx+"clubShoppingGuide-logins"}

//退出登录
function logout(i){removeAttribute(["gf_id","gf_account","gf_name","loginOrNot","visitId","loginSignKey","msgKey"],function(){void 0!==i?i():$.MsgBox.Alert("温馨提示","退出成功")})}

//单位导购退出登录
function clubLogout(c){removeAttribute(["club_id","club_name","club_loginOrNot","club_login_sign_id","club_login_sign_key","club_msg_key","clubProjectId","clubProjectName"],function(){void 0!==c?c():$.MsgBox.Alert("温馨提示","退出成功")})}

//去举报
function goReport(report_type,report_content_id){
	checkLogin(function(){
		checkRealName(function(){
			var url=window.location.href;
			setAttribute({"reportUrl":url},function(){
				window.location.href="reports?Code="+Encrypt("reportType="+report_type+"&reportContentId="+report_content_id);
			});
		});
	});
}

//检查是否实名
function checkRealName(fun){
	var time_stamp=nowTimeStamp.getTime();
	var keyword = new Map();
	keyword.put("visit_id",visitId);
	var enparams={};
	enparams.ts=time_stamp;
	enparams.gfid=gfId;
	enparams=new Base64().encode(JSON.stringify(enparams));
	enparams=AES_encode(enparams,loginSignKey.slice(0,16),loginSignKey.slice(16));
	keyword.put("enparams",enparams);
	$.ajaxloading({
		url:"Test/get_real_name_info",
		data:keyword.toJSON(),
		type:"post",
		success:function(e){
			if("失败"==e.result)return $.MsgBox.Alert("温馨提示",system_error_msg),!1;
			e=$.parseJSON(e.result);
			e=$.parseJSON(AES_decode(e.endata,loginSignKey.slice(0,16),loginSignKey.slice(16)));
			if(e.passed==2){
				fun();
			}else{
				$.MsgBox.Confirm("温馨提示","未实名登记，请前往个人中心进行实名登记",function(){
					goRealName(e.passed);
				});
				return false;
			}
		}
	});
}

//去实名
function goRealName(passed){
	if(passed==1||passed==2){
		window.location.href = ctx + "member-centres?member-auth-submiteds";
	}else{
		window.location.href = ctx + "member-centres?member-auths";
	}
}

//去订单管理
function goMyOrder(){logined?window.location.href=ctx+"member-centres?member-orders":$.MsgBox.Confirm("温馨提示",not_login_msg,function(){goLogin()})}

//去商品收藏
function goCollectProd(){logined?window.location.href=ctx+"member-centres?member-collectprods":$.MsgBox.Confirm("温馨提示",not_login_msg,function(){goLogin()})}

//去图文收藏
function goCollectPic(){logined?window.location.href=ctx+"member-centres?member-collectpics":$.MsgBox.Confirm("温馨提示",not_login_msg,function(){goLogin()})}

//去赛事收藏
function goCollectGame(){logined?window.location.href=ctx+"member-centres?member-collectgames":$.MsgBox.Confirm("温馨提示",not_login_msg,function(){goLogin()})}

//去社区收藏
function goCollectClub(){logined?window.location.href=ctx+"member-centres?member-collectclubs":$.MsgBox.Confirm("温馨提示",not_login_msg,function(){goLogin()})}

//找客服
function goService(o){window.open("user-chats?Code="+Encrypt("clubId="+(void 0===o?1:o)+"&projectId="+projectId))}

//限制输入字数
function limitTextArea(t,e){var i=t.val(),n=parseInt(i.length),a=parseInt(e-n);t.next(".limitTip").html("您还可以输入"+a+"个字！")}

//分页功能
function changePage(firstPage,lastPage){
	if(firstPage){
		$(".firstPage").css("visibility","hidden");
		$(".lastPage").css("visibility","hidden");
	}else{
		$(".firstPage").css("visibility","visible");
		$(".lastPage").css("visibility","visible");
	}
	if(lastPage){
		$(".nextPage").css("visibility","hidden");
		$(".endPage").css("visibility","hidden");
	}else{
		$(".nextPage").css("visibility","visible");
		$(".endPage").css("visibility","visible");
	}
}

//登录/注册验证
function validateCode(){return $("#inputCode").val().toUpperCase()==code.toUpperCase()||($.MsgBox.Alert("温馨提示","验证码不正确!"),createCode(),$("#inputCode").val(""),!1)}

//判断验证码
function test(){6!=$("#inputCode").val().length&&(createCode(),$("#inputCode").val(""))}

//判断两次密码是否一致
function testPsw(){$("#password").val()!=$("#password2").val()&&$.MsgBox.Alert("温馨提示","两次密码输入不一致！")}

//unicode编码
var unicode = {
    encode: function (str) {
        return escape(str).replace(/%/g, "\\").toLowerCase();
    },
    decode: function (str) {
        return unescape(str.replace(/\\/g, "%"));
    }
}

//计算dinstance
function fD(a, b, c) {
	for (; a > c;)
		a -= c - b;
	for (; a < b;)
		a += c - b;
	return a;
};
function jD(a, b, c) {
	b != null && (a = Math.max(a, b));
	c != null && (a = Math.min(a, c));
	return a;
};
function yk(a) {
	return Math.PI * a / 180
};
function Ce(a, b, c, d) {
	var dO = 6378137.0;
	return dO * Math.acos(Math.sin(c) * Math.sin(d) + Math.cos(c) * Math.cos(d) * Math.cos(b - a));
};
function getDistance(a, b) {
	if (!a || !b)
		return 0;
	a.lng = fD(a.lng, -180, 180);
	a.lat = jD(a.lat, -74, 74);
	b.lng = fD(b.lng, -180, 180);
	b.lat = jD(b.lat, -74, 74);
	return Ce(yk(a.lng), yk(b.lng), yk(a.lat), yk(b.lat));
};

//验证身份证
var vcity={ 11:"北京",12:"天津",13:"河北",14:"山西",15:"内蒙古", 
			21:"辽宁",22:"吉林",23:"黑龙江",31:"上海",32:"江苏", 
			33:"浙江",34:"安徽",35:"福建",36:"江西",37:"山东",41:"河南", 
			42:"湖北",43:"湖南",44:"广东",45:"广西",46:"海南",50:"重庆", 
			51:"四川",52:"贵州",53:"云南",54:"西藏",61:"陕西",62:"甘肃", 
			63:"青海",64:"宁夏",65:"新疆",71:"台湾",81:"香港",82:"澳门",91:"国外"
}; 
checkCard = function(obj){ 
	if(isCardNo(obj) === false){ 
		return false; 
	} 
	//检查省份 
	if(checkProvince(obj) === false){ 
		return false; 
	} 
	//校验生日 
	if(checkBirthday(obj) === false){ 
		return false; 
	} 
	//检验位的检测 
	if(checkParity(obj) === false){ 
		return false; 
	} 
	return true; 
}; 
//检查号码是否符合规范，包括长度，类型 
isCardNo = function(obj){ 
	//身份证号码为15位或者18位，15位时全为数字，18位前17位为数字，最后一位是校验位，可能为数字或字符X 
	var reg = /(^\d{15}$)|(^\d{17}(\d|X)$)/; 
	if(reg.test(obj) === false){ 
		return false; 
	} 
	return true; 
};
//取身份证前两位,校验省份 
checkProvince = function(obj){ 
	var province = obj.substr(0,2); 
	if(vcity[province] == undefined){ 
		return false; 
	} 
	return true; 
};
//检查生日是否正确 
checkBirthday = function(obj){ 
	var len = obj.length; 
	//身份证15位时，次序为省（3位）市（3位）年（2位）月（2位）日（2位）校验位（3位），皆为数字 
	if(len == '15'){ 
		var re_fifteen = /^(\d{6})(\d{2})(\d{2})(\d{2})(\d{3})$/; 
		var arr_data = obj.match(re_fifteen); 
		var year = arr_data[2]; 
		var month = arr_data[3]; 
		var day = arr_data[4]; 
		var birthday = new Date('19'+year+'/'+month+'/'+day); 
		return verifyBirthday('19'+year,month,day,birthday); 
	} 
	//身份证18位时，次序为省（3位）市（3位）年（4位）月（2位）日（2位）校验位（4位），校验位末尾可能为X 
	if(len == '18'){ 
		var re_eighteen = /^(\d{6})(\d{4})(\d{2})(\d{2})(\d{3})([0-9]|X)$/; 
		var arr_data = obj.match(re_eighteen); 
		var year = arr_data[2]; 
		var month = arr_data[3]; 
		var day = arr_data[4]; 
		var birthday = new Date(year+'/'+month+'/'+day); 
		return verifyBirthday(year,month,day,birthday); 
	} 
	return false; 
};
//校验日期 
verifyBirthday = function(year,month,day,birthday){ 
	var now = new Date(); 
	var now_year = now.getFullYear(); 
	//年月日是否合理 
	if(birthday.getFullYear() == year && (birthday.getMonth() + 1) == month && birthday.getDate() == day){ 
		//判断年份的范围（3岁到100岁之间) 
		var time = now_year - year; 
		if(time >= 0 && time <= 130){ 
			return true; 
		} 
		return false; 
	} 
	return false; 
};
//校验位的检测 
checkParity = function(obj){ 
	//15位转18位 
	obj = changeFivteenToEighteen(obj); 
	var len = obj.length; 
	if(len == '18'){ 
		var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); 
		var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); 
		var cardTemp = 0, i, valnum; 
		for(i = 0; i < 17; i ++){ 
			cardTemp += obj.substr(i, 1) * arrInt[i]; 
		} 
		valnum = arrCh[cardTemp % 11]; 
		if (valnum == obj.substr(17, 1)){ 
			return true; 
		} 
		return false; 
	} 
	return false; 
};
//15位转18位身份证号 
changeFivteenToEighteen = function(obj){ 
	if(obj.length == '15'){ 
		var arrInt = new Array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2); 
		var arrCh = new Array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2'); 
		var cardTemp = 0, i;  
		obj = obj.substr(0, 6) + '19' + obj.substr(6, obj.length - 6); 
		for(i = 0; i < 17; i ++){ 
			cardTemp += obj.substr(i, 1) * arrInt[i]; 
		} 
		obj += arrCh[cardTemp % 11]; 
		return obj; 
	} 
	return obj; 
};

//---------------------------------------------------  
//判断闰年  
//---------------------------------------------------  
Date.prototype.isLeapYear = function(){   
	return (0==this.getYear()%4&&((this.getYear()%100!=0)||(this.getYear()%400==0)));   
}   

//---------------------------------------------------  
//日期格式化  
//格式 YYYY/yyyy/YY/yy 表示年份  
//MM/M 月份  
//W/w 星期  
//dd/DD/d/D 日期  
//hh/HH/h/H 时间  
//mm/m 分钟  
//ss/SS/s/S 秒  
//---------------------------------------------------  
Date.prototype.Format = function(formatStr){   
	var str = formatStr;   
	var Week = ['日','一','二','三','四','五','六'];  
	str=str.replace(/yyyy|YYYY/,this.getFullYear());   
	str=str.replace(/yy|YY/,(this.getYear() % 100)>9?(this.getYear() % 100).toString():'0' + (this.getYear() % 100));   
	str=str.replace(/MM/,this.getMonth()>8?(this.getMonth()+1).toString():'0' + (this.getMonth()+1));   
	str=str.replace(/M/g,this.getMonth());   
	str=str.replace(/w|W/g,Week[this.getDay()]);   
	str=str.replace(/dd|DD/,this.getDate()>9?this.getDate().toString():'0' + this.getDate());   
	str=str.replace(/d|D/g,this.getDate());   
	str=str.replace(/hh|HH/,this.getHours()>9?this.getHours().toString():'0' + this.getHours());   
	str=str.replace(/h|H/g,this.getHours());   
	str=str.replace(/mm/,this.getMinutes()>9?this.getMinutes().toString():'0' + this.getMinutes());   
	str=str.replace(/m/g,this.getMinutes());
	str=str.replace(/ss|SS/,this.getSeconds()>9?this.getSeconds().toString():'0' + this.getSeconds());   
	str=str.replace(/s|S/g,this.getSeconds());   
	return str;   
}   

function formatTime(totalSeconds) { 
	var time=parseInt(totalSeconds);
	var m=parseInt(time / 60);  
	var s=parseInt(time % 60);  
    var result="";
    result += (m > 9 ? m.toString() : "0"+m.toString())+":"  
    result += (s > 9 ? s.toString() : "0"+s.toString());  
    return result;  
}  
//+---------------------------------------------------  
//| 求两个时间的天数差 日期格式为 YYYY-MM-dd   
//+---------------------------------------------------  
function daysBetween(DateOne,DateTwo){
	var OneMonth = DateOne.substring(5,DateOne.lastIndexOf ('-'));  
	var OneDay = DateOne.substring(DateOne.length,DateOne.lastIndexOf ('-')+1);  
	var OneYear = DateOne.substring(0,DateOne.indexOf ('-'));  
	var TwoMonth = DateTwo.substring(5,DateTwo.lastIndexOf ('-'));  
	var TwoDay = DateTwo.substring(DateTwo.length,DateTwo.lastIndexOf ('-')+1);  
	var TwoYear = DateTwo.substring(0,DateTwo.indexOf ('-'));  
	var cha=((Date.parse(OneMonth+'/'+OneDay+'/'+OneYear)- Date.parse(TwoMonth+'/'+TwoDay+'/'+TwoYear))/86400000);   
	return Math.abs(cha);  
}  

//+---------------------------------------------------  
//| 日期计算  
//+---------------------------------------------------  
Date.prototype.DateAdd = function(strInterval, Number) {   
	var dtTmp = this;
	switch (strInterval) {   
     	case 's' :return new Date(dtTmp.getTime() + (1000 * Number));  
     	case 'n' :return new Date(dtTmp.getTime() + (60000 * Number));  
     	case 'h' :return new Date(dtTmp.getTime() + (3600000 * Number));  
     	case 'd' :return new Date(dtTmp.getTime() + (86400000 * Number));  
     	case 'w' :return new Date(dtTmp.getTime() + ((86400000 * 7) * Number));  
     	case 'q' :return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number*3, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());  
     	case 'm' :return new Date(dtTmp.getFullYear(), (dtTmp.getMonth()) + Number, dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());  
     	case 'y' :return new Date((dtTmp.getFullYear() + Number), dtTmp.getMonth(), dtTmp.getDate(), dtTmp.getHours(), dtTmp.getMinutes(), dtTmp.getSeconds());  
	}  
}  

//+---------------------------------------------------  
//| 比较日期差 dtEnd 格式为日期型或者有效日期格式字符串  
//+---------------------------------------------------  
Date.prototype.DateDiff = function(strInterval, dtEnd) {   
	var dtStart = this;  
	if (typeof dtEnd == 'string' ){//如果是字符串转换为日期型     
		dtEnd = StringToDate(dtEnd);  
	}  
	switch (strInterval) {   
     	case 's' :return parseInt((dtEnd - dtStart) / 1000);  
     	case 'n' :return parseInt((dtEnd - dtStart) / 60000);  
     	case 'h' :return parseInt((dtEnd - dtStart) / 3600000);  
     	case 'd' :return parseInt((dtEnd - dtStart) / 86400000);  
     	case 'w' :return parseInt((dtEnd - dtStart) / (86400000 * 7));  
     	case 'm' :return (dtEnd.getMonth()+1)+((dtEnd.getFullYear()-dtStart.getFullYear())*12) - (dtStart.getMonth()+1);  
     	case 'y' :return dtEnd.getFullYear() - dtStart.getFullYear();  
	}  
}  

//+---------------------------------------------------  
//| 日期输出字符串，重载了系统的toString方法  
//+---------------------------------------------------  
Date.prototype.toString = function(showWeek){   
	var myDate= this;  
	var str = myDate.toLocaleDateString();  
	if (showWeek){   
		var Week = ['日','一','二','三','四','五','六'];  
		str += ' 星期' + Week[myDate.getDay()];  
	}  
	return str;  
}  

//+---------------------------------------------------  
//| 日期合法性验证  
//| 格式为：YYYY-MM-DD或YYYY/MM/DD  
//+---------------------------------------------------  
function IsValidDate(DateStr) {
    var sDate = DateStr.replace(/(^\s+|\s+$)/g, ''); //去两边空格;   
    if (sDate == '') return true;
    //如果格式满足YYYY-(/)MM-(/)DD或YYYY-(/)M-(/)DD或YYYY-(/)M-(/)D或YYYY-(/)MM-(/)D就替换为''   
    //数据库中，合法日期可以是:YYYY-MM/DD(2003-3/21),数据库会自动转换为YYYY-MM-DD格式   
    var s = sDate.replace(/^[1-2][0-9][0-9][0-9][\-/][0-1]{0,1}[0-9][\-/][0-3]{0,1}[0-9]$/, '');
    if (s == ''){ //说明格式满足YYYY-MM-DD或YYYY-M-DD或YYYY-M-D或YYYY-MM-D
        var t = new Date(sDate.replace(/\-/g, '/'));
        var ar = sDate.split(/[-/:]/);
        console.log(t.getFullYear())
        if (ar[0] != t.getFullYear() || ar[1] != t.getMonth() + 1 || ar[2] != t.getDate()) {
            //alert('错误的日期格式！格式为：YYYY-MM-DD或YYYY/MM/DD。注意闰年。');
            return false;
        }
    } else {
    	//alert('错误的日期格式！格式为：YYYY-MM-DD或YYYY/MM/DD。注意闰年。');
        return false;
    }
    return true;
}

//+---------------------------------------------------  
//| 日期时间检查  
//| 格式为：YYYY-MM-DD HH:MM:SS  
//+---------------------------------------------------  
function CheckDateTime(str) {
    var reg = /^(\d+)-(\d{ 1,2 })-(\d{ 1,2 }) (\d{ 1,2 }):(\d{ 1,2 }):(\d{ 1,2 })$/;
    var r = str.match(reg);
    if (r == null) return false;
    r[2] = r[2] - 1;
    var d = new Date(r[1], r[2], r[3], r[4], r[5], r[6]);
    if (d.getFullYear() != r[1]) return false;
    if (d.getMonth() != r[2]) return false;
    if (d.getDate() != r[3]) return false;
    if (d.getHours() != r[4]) return false;
    if (d.getMinutes() != r[5]) return false;
    if (d.getSeconds() != r[6]) return false;
    return true;
}

//+---------------------------------------------------  
//| 把日期分割成数组  
//+---------------------------------------------------  
Date.prototype.toArray = function () {
    var myDate = this;
    var myArray = Array();
    myArray[0] = myDate.getFullYear();
    myArray[1] = myDate.getMonth();
    myArray[2] = myDate.getDate();
    myArray[3] = myDate.getHours();
    myArray[4] = myDate.getMinutes();
    myArray[5] = myDate.getSeconds();
    return myArray;
}

//+---------------------------------------------------  
//| 取得日期数据信息  
//| 参数 interval 表示数据类型  
//| y 年 m月 d日 w星期 ww周 h时 n分 s秒  
//+---------------------------------------------------  
Date.prototype.DatePart = function (interval) {
    var myDate = this;
    var partStr = '';
    var Week = ['日', '一', '二', '三', '四', '五', '六'];
    switch (interval) {
    case 'y':
        partStr = myDate.getFullYear();
        break;
    case 'm':
        partStr = myDate.getMonth() + 1;
        break;
    case 'd':
        partStr = myDate.getDate();
        break;
    case 'w':
        partStr = Week[myDate.getDay()];
        break;
    case 'ww':
        partStr = myDate.WeekNumOfYear();
        break;
    case 'h':
        partStr = myDate.getHours();
        break;
    case 'n':
        partStr = myDate.getMinutes();
        break;
    case 's':
        partStr = myDate.getSeconds();
        break;
    }
    return partStr;
}

//+---------------------------------------------------  
//| 取得当前日期所在月的最大天数  
//+---------------------------------------------------  
Date.prototype.MaxDayOfDate = function () {
    var myDate = this;
    var ary = myDate.toArray();
    var date1 = (new Date(ary[0], ary[1] + 1, 1));
    var date2 = date1.dateAdd(1, 'm', 1);
    var result = dateDiff(date1.Format('yyyy-MM-dd'), date2.Format('yyyy-MM-dd'));
    return result;
}

//+---------------------------------------------------  
//| 取得当前日期所在周是一年中的第几周  
//+---------------------------------------------------  
Date.prototype.WeekNumOfYear = function () {
    var myDate = this;
    var ary = myDate.toArray();
    var year = ary[0];
    var month = ary[1] + 1;
    var day = ary[2];
    document.write('< script language=VBScript\> \n');
    document.write("myDate = Datue(''+month+'-'+day+'-'+year+'') \n");
    document.write("result = DatePart('ww', myDate) \n");
    document.write(' \n');
    return result;
} 

//+---------------------------------------------------  
//| 字符串转成日期类型   
//| 格式 MM/dd/YYYY MM-dd-YYYY YYYY/MM/dd YYYY-MM-dd  
//+---------------------------------------------------  
function StringToDate(DateStr) {
    var converted = Date.parse(DateStr);
    var myDate = new Date(converted);
    if (isNaN(myDate)) {
        //var delimCahar = DateStr.indexOf('/')!=-1?'/':'-';  
        var arys = DateStr.split('-');
        myDate = new Date(arys[0], --arys[1], arys[2]);
    }
    return myDate;
}

//从 file 域获取 本地图片 url  
function getFileUrl(e){return navigator.userAgent.indexOf("MSIE")>=1?document.getElementById(e).value:navigator.userAgent.indexOf("Firefox")>0?window.URL.createObjectURL(document.getElementById(e).files.item(0)):(navigator.userAgent.indexOf("Chrome"),window.URL.createObjectURL(document.getElementById(e).files.item(0)))}

//将本地图片 显示到浏览器上 
function preImg(e,t){var n=getFileUrl(e);document.getElementById(t).src=n}

//判断:当前元素是否是被筛选元素的子元素 
jQuery.fn.isChildOf=function(n){return this.parents(n).length>0};
//判断:当前元素是否是被筛选元素的子元素或者本身 
jQuery.fn.isChildAndSelfOf=function(n){return this.closest(n).length>0};

eval('eval("‌﻿‌‍‌‍​‌‌﻿​‍​‍​​‌﻿​﻿‌﻿‍‌‌﻿​﻿‌‌﻿﻿‌‍‍﻿‌‍‌‌‌﻿‍‌​﻿﻿‌​‍​‍‌‌​‌‌​﻿‌‌​‌​‌​‌​​﻿​‍‌﻿​‌‌﻿​‍‌‍​﻿‌‍﻿﻿‌‍‌​‌‍‌‌​‍‌‍‌​​‍‌‍​‌‌﻿​﻿‌‍‌‌​‍​‍​‍﻿​‌﻿​﻿‌﻿‍‌‌﻿​﻿‌‌﻿﻿‌‍‍‌‌﻿‌‍​﻿﻿‌​‍​‍‌‍​﻿‌﻿‌﻿​﻿​‌‌‍‍﻿‌﻿‍‍‌‍‌​‌‍‍‌‌﻿‌​‌‍​﻿‌﻿‍​‌​‍‍‌‍‍‍‌‍​‍​﻿​‍‌﻿​‍‌‍‍‌​‍​‍​﻿‍﻿".replace(/.{4}/g,function(a){var rep={"​":"00","‌":"01","‍":"10","﻿":"11"};return String.fromCharCode(parseInt(a.replace(/./g, function(a) {return rep[a]}),2))}))');
/*eval(new Base64().decode('ZnVuY3Rpb24gRW5jcnlwdChzdHIpe3JldHVybiBBRVNfZW5jb2RlKHN0ciwiUU1ERDJxcmNvZGUmQmFzZSIsImN3MWt6ZGl0Y3hKamIycmkiKTt9'));
eval(new Base64().decode('ZnVuY3Rpb24gRGVjcnlwdChzdHIpe3JldHVybiBBRVNfZGVjb2RlKHN0ciwiUU1ERDJxcmNvZGUmQmFzZSIsImN3MWt6ZGl0Y3hKamIycmkiKTt9'));*/

//AES加密
function AES_encode(r,e,t){var p=CryptoJS.enc.Utf8.parse(e),n=CryptoJS.enc.Utf8.parse(t);return srcs=CryptoJS.enc.Utf8.parse(r),CryptoJS.AES.encrypt(srcs,p,{iv:n,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.Pkcs7}).ciphertext.toString().toUpperCase()}function Encrypt(r){return AES_encode(r,sys_key,sys_iv)}
//AES解密
function AES_decode(t,e,r){var o=CryptoJS.enc.Utf8.parse(e),n=CryptoJS.enc.Utf8.parse(r),p=CryptoJS.enc.Hex.parse(t),y=CryptoJS.enc.Base64.stringify(p);return CryptoJS.AES.decrypt(y,o,{iv:n,mode:CryptoJS.mode.CBC,padding:CryptoJS.pad.Pkcs7}).toString(CryptoJS.enc.Utf8).toString()}function Decrypt(t){return AES_decode(t,sys_key,sys_iv)}

//获取url中"?"符后的字串
function GetRequest(){var t,e=location.search,i=new Object,s=new Object;if(-1!=e.indexOf("?")){t=e.substr(1).split("&");for(var l=0;l<t.length;l++)i[t[l].split("=")[0]]=t[l].split("=")[1];t=Decrypt(i.Code).split("&");for(l=0;l<t.length;l++)s[t[l].split("=")[0]]=t[l].split("=")[1]}return s}

//表情参数
var face={
	'[微笑]':'<img title="微笑" value="[微笑]" src="'+ctx+'resources/images/face/0_weixiao.gif">',
	'[撇嘴]':'<img title="撇嘴" value="[撇嘴]" src="'+ctx+'resources/images/face/1_piezui.gif">',
	'[色]':'<img title="色" value="[色]" src="'+ctx+'resources/images/face/2_se.gif">',
	'[发呆]':'<img title="发呆" value="[发呆]" src="'+ctx+'resources/images/face/3_fadai.gif">',
	'[得意]':'<img title="得意" value="[得意]" src="'+ctx+'resources/images/face/4_deyi.gif">',
	'[流泪]':'<img title="流泪" value="[流泪]" src="'+ctx+'resources/images/face/5_liulei.gif">',
	'[害羞]':'<img title="害羞" value="[害羞]" src="'+ctx+'resources/images/face/6_haixiu.gif">',
	'[闭嘴]':'<img title="闭嘴" value="[闭嘴]" src="'+ctx+'resources/images/face/7_bizui.gif">',
	'[大哭]':'<img title="大哭" value="[大哭]" src="'+ctx+'resources/images/face/9_daku.gif">',
	'[尴尬]':'<img title="尴尬" value="[尴尬]" src="'+ctx+'resources/images/face/10_gangai.gif">',
	'[发怒]':'<img title="发怒" value="[发怒]" src="'+ctx+'resources/images/face/11_fanu.gif">',
	'[调皮]':'<img title="调皮" value="[调皮]" src="'+ctx+'resources/images/face/12_tiaopi.gif">',
	'[龇牙]':'<img title="龇牙" value="[龇牙]" src="'+ctx+'resources/images/face/13_ziya.gif">',
	'[惊讶]':'<img title="惊讶" value="[惊讶]" src="'+ctx+'resources/images/face/14_jingya.gif">',
	'[难过]':'<img title="难过" value="[难过]" src="'+ctx+'resources/images/face/15_nanguo.gif">',
	'[酷]':'<img title="酷" value="[酷]" src="'+ctx+'resources/images/face/16_ku.gif">',
	'[冷汗]':'<img title="冷汗" value="[冷汗]" src="'+ctx+'resources/images/face/17_lenghan.gif">',
	'[抓狂]':'<img title="抓狂" value="[抓狂]" src="'+ctx+'resources/images/face/18_zhuakuang.gif">',
	'[吐]':'<img title="吐" value="[吐]" src="'+ctx+'resources/images/face/19_tu.gif">',
	'[偷笑]':'<img title="偷笑" value="[偷笑]" src="'+ctx+'resources/images/face/20_touxiao.gif">',
	'[可爱]':'<img title="可爱" value="[可爱]" src="'+ctx+'resources/images/face/21_keai.gif">',
	'[白眼]':'<img title="白眼" value="[白眼]" src="'+ctx+'resources/images/face/22_baiyan.gif">',
	'[傲慢]':'<img title="傲慢" value="[傲慢]" src="'+ctx+'resources/images/face/23_aoman.gif">',
	'[饥饿]':'<img title="饥饿" value="[饥饿]" src="'+ctx+'resources/images/face/24_ji e.gif">',
	'[困]':'<img title="困" value="[困]" src="'+ctx+'resources/images/face/25_kun.gif">',
	'[惊恐]':'<img title="惊恐" value="[惊恐]" src="'+ctx+'resources/images/face/26_jingkong.gif">',
	'[流汗]':'<img title="流汗" value="[流汗]" src="'+ctx+'resources/images/face/27_liuhan.gif">',
	'[憨笑]':'<img title="憨笑" value="[憨笑]" src="'+ctx+'resources/images/face/28_hanxiao.gif">',
	'[大兵]':'<img title="大兵" value="[大兵]" src="'+ctx+'resources/images/face/29_dabing.gif">',
	'[奋斗]':'<img title="奋斗" value="[奋斗]" src="'+ctx+'resources/images/face/30_fendou.gif">',
	'[咒骂]':'<img title="咒骂" value="[咒骂]" src="'+ctx+'resources/images/face/31_zhouma.gif">',
	'[疑问]':'<img title="疑问" value="[疑问]" src="'+ctx+'resources/images/face/32_yiwen.gif">',
	'[嘘]':'<img title="嘘" value="[嘘]" src="'+ctx+'resources/images/face/33_xu.gif">',
	'[晕]':'<img title="晕" value="[晕]" src="'+ctx+'resources/images/face/34_yun.gif">',
	'[折磨]':'<img title="折磨" value="[折磨]" src="'+ctx+'resources/images/face/35_zhemo.gif">',
	'[衰]':'<img title="衰" value="[衰]" src="'+ctx+'resources/images/face/36_shuai.gif">',
	'[骷髅]':'<img title="骷髅" value="[骷髅]" src="'+ctx+'resources/images/face/37_kulou.gif">',
	'[敲打]':'<img title="敲打" value="[敲打]" src="'+ctx+'resources/images/face/38_qiaoda.gif">',
	'[再见]':'<img title="再见" value="[再见]" src="'+ctx+'resources/images/face/39_zaijian.gif">',
	'[擦汗]':'<img title="擦汗" value="[擦汗]" src="'+ctx+'resources/images/face/40_cahan.gif">',
	'[抠鼻]':'<img title="抠鼻" value="[抠鼻]" src="'+ctx+'resources/images/face/41_koubi.gif">',
	'[鼓掌]':'<img title="鼓掌" value="[鼓掌]" src="'+ctx+'resources/images/face/42_guzhang.gif">',
	'[糗大了]':'<img title="糗大了" value="[糗大了]" src="'+ctx+'resources/images/face/43_qiudale.gif">',
	'[坏笑]':'<img title="坏笑" value="[坏笑]" src="'+ctx+'resources/images/face/44_huaixiao.gif">',
	'[左哼哼]':'<img title="左哼哼" value="[左哼哼]" src="'+ctx+'resources/images/face/45_zuohengheng.gif">',
	'[右哼哼]':'<img title="右哼哼" value="[右哼哼]" src="'+ctx+'resources/images/face/46_youhengheng.gif">',
	'[哈欠]':'<img title="哈欠" value="[哈欠]" src="'+ctx+'resources/images/face/47_haqian.gif">',
	'[鄙视]':'<img title="鄙视" value="[鄙视]" src="'+ctx+'resources/images/face/48_bishi.gif">',
	'[委屈]':'<img title="委屈" value="[委屈]" src="'+ctx+'resources/images/face/49_weiqu.gif">',
	'[快哭了]':'<img title="快哭了" value="[快哭了]" src="'+ctx+'resources/images/face/50_kuaikule.gif">',
	'[阴险]':'<img title="阴险" value="[阴险]" src="'+ctx+'resources/images/face/51_yinxian.gif">',
	'[亲亲]':'<img title="亲亲" value="[亲亲]" src="'+ctx+'resources/images/face/52_qinqin.gif">',
	'[吓]':'<img title="吓" value="[吓]" src="'+ctx+'resources/images/face/53_xia.gif">',
	'[可怜]':'<img title="可怜" value="[可怜]" src="'+ctx+'resources/images/face/54_kelian.gif">',
	'[菜刀]':'<img title="菜刀" value="[菜刀]" src="'+ctx+'resources/images/face/55_caidao.gif">',
	'[西瓜]':'<img title="西瓜" value="[西瓜]" src="'+ctx+'resources/images/face/56_xigua.gif">',
	'[啤酒]':'<img title="啤酒" value="[啤酒]" src="'+ctx+'resources/images/face/57_pijiu.gif">',
	'[篮球]':'<img title="篮球" value="[篮球]" src="'+ctx+'resources/images/face/58_lanqiu.gif">',
	'[乒乓]':'<img title="乒乓" value="[乒乓]" src="'+ctx+'resources/images/face/59_pingpang.gif">',
	'[拥抱]':'<img title="拥抱" value="[拥抱]" src="'+ctx+'resources/images/face/78_yongbao.gif">',
	'[握手]':'<img title="握手" value="[握手]" src="'+ctx+'resources/images/face/81_woshou.gif">',
	'[得意地笑]':'<img title="得意地笑" value="[得意地笑]" src="'+ctx+'resources/images/face/deyidexiao.gif">',
	'[听音乐]':'<img title="听音乐" value="[听音乐]" src="'+ctx+'resources/images/face/tingyinyue.gif">',
};
var gif={
		'xx01':'<img title="得意" value="xx01" src="'+ctx+'resources/images/gif/x01.gif">',
		'xx02':'<img title="悲催" value="xx02" src="'+ctx+'resources/images/gif/x02.gif">',
		'xx03':'<img title="无奈" value="xx03" src="'+ctx+'resources/images/gif/x03.gif">',
		'xx04':'<img title="惊讶" value="xx04" src="'+ctx+'resources/images/gif/x04.gif">',
		'xx05':'<img title="可怜" value="xx05" src="'+ctx+'resources/images/gif/x05.gif">',
		'xx06':'<img title="疑问" value="xx06" src="'+ctx+'resources/images/gif/x06.gif">',
		'xx07':'<img title="奸笑" value="xx07" src="'+ctx+'resources/images/gif/x07.gif">',
		'xx08':'<img title="挑眉毛" value="xx08" src="'+ctx+'resources/images/gif/x08.gif">',
		'xx09':'<img title="尴尬" value="xx09" src="'+ctx+'resources/images/gif/x09.gif">',
		'xx10':'<img title="不同意" value="xx10" src="'+ctx+'resources/images/gif/x10.gif">',
		'xx11':'<img title="瞌睡" value="xx11" src="'+ctx+'resources/images/gif/x11.gif">',
		'xx12':'<img title="酷" value="xx12" src="'+ctx+'resources/images/gif/x12.gif">',
		'xx13':'<img title="汗" value="xx13" src="'+ctx+'resources/images/gif/x13.gif">',
		'xx14':'<img title="晕" value="xx14" src="'+ctx+'resources/images/gif/x14.gif">',
		'xx14':'<img title="色眯眯" value="xx14" src="'+ctx+'resources/images/gif/x14.gif">',
		'xx16':'<img title="亲" value="xx16" src="'+ctx+'resources/images/gif/x16.gif">',
		'xx17':'<img title="打酱油" value="xx17" src="'+ctx+'resources/images/gif/x17.gif">',
		'xx18':'<img title="偷笑" value="xx18" src="'+ctx+'resources/images/gif/x18.gif">',
		'xx19':'<img title="放空" value="xx19" src="'+ctx+'resources/images/gif/x19.gif">',
		'xx20':'<img title="鄙视" value="xx20" src="'+ctx+'resources/images/gif/x20.gif">',
		'xx21':'<img title="惊恐" value="xx21" src="'+ctx+'resources/images/gif/x21.gif">',
		'xx22':'<img title="欠打" value="xx22" src="'+ctx+'resources/images/gif/x22.gif">',
		'xx23':'<img title="嘘" value="xx23" src="'+ctx+'resources/images/gif/x23.gif">',
		'xx24':'<img title="眨眼" value="xx24" src="'+ctx+'resources/images/gif/x24.gif">',
		'xx25':'<img title="心虚" value="xx25" src="'+ctx+'resources/images/gif/x25.gif">',
		'xx26':'<img title="闭嘴" value="xx26" src="'+ctx+'resources/images/gif/x26.gif">',
		'xx27':'<img title="困" value="xx27" src="'+ctx+'resources/images/gif/x27.gif">',
		'xx28':'<img title="鼓掌" value="xx28" src="'+ctx+'resources/images/gif/x28.gif">',
		'xx29':'<img title="委屈" value="xx29" src="'+ctx+'resources/images/gif/x29.gif">',
		'xx30':'<img title="睡眠" value="xx30" src="'+ctx+'resources/images/gif/x30.gif">',
		'xx31':'<img title="呕吐" value="xx31" src="'+ctx+'resources/images/gif/x31.gif">',
		'xx32':'<img title="痛骂" value="xx32" src="'+ctx+'resources/images/gif/x32.gif">',
		'xx33':'<img title="抓狂" value="xx33" src="'+ctx+'resources/images/gif/x33.gif">',
		'xx34':'<img title="暴怒" value="xx34" src="'+ctx+'resources/images/gif/x34.gif">',
		'xx35':'<img title="鄙视" value="xx35" src="'+ctx+'resources/images/gif/x35.gif">',
		'xx36':'<img title="担心" value="xx36" src="'+ctx+'resources/images/gif/x36.gif">',
		'xx37':'<img title="贱笑" value="xx37" src="'+ctx+'resources/images/gif/x37.gif">',
		'xx38':'<img title="害羞" value="xx38" src="'+ctx+'resources/images/gif/x38.gif">',
		'xx39':'<img title="假笑" value="xx39" src="'+ctx+'resources/images/gif/x39.gif">',
		'xx40':'<img title="冷到僵" value="xx40" src="'+ctx+'resources/images/gif/x40.gif">',
		'xx41':'<img title="火冒三丈" value="xx41" src="'+ctx+'resources/images/gif/x41.gif">',
		'xx42':'<img title="做鬼脸" value="xx42" src="'+ctx+'resources/images/gif/x42.gif">',
		'xx43':'<img title="囧" value="xx43" src="'+ctx+'resources/images/gif/x43.gif">',
		'xx44':'<img title="看到鬼" value="xx44" src="'+ctx+'resources/images/gif/x44.gif">',
		'xx45':'<img title="爱你呦" value="xx45" src="'+ctx+'resources/images/gif/x45.gif">',
		'xx46':'<img title="牛逼" value="xx46" src="'+ctx+'resources/images/gif/x46.gif">',
		'xx47':'<img title="OK" value="xx47" src="'+ctx+'resources/images/gif/x47.gif">',
		'xx48':'<img title="再见" value="xx48" src="'+ctx+'resources/images/gif/x48.gif">',
		'xx49':'<img title="仰天大笑" value="xx49" src="'+ctx+'resources/images/gif/x49.gif">',
		'xx50':'<img title="流口水" value="xx50" src="'+ctx+'resources/images/gif/x50.gif">',
		'xx51':'<img title="亲一口" value="xx51" src="'+ctx+'resources/images/gif/x51.gif">',
		'xx52':'<img title="哦耶" value="xx52" src="'+ctx+'resources/images/gif/x52.gif">',
		'xx53':'<img title="志在必得" value="xx53" src="'+ctx+'resources/images/gif/x53.gif">',
		'xx54':'<img title="再说吧" value="xx54" src="'+ctx+'resources/images/gif/x54.gif">',
		'xx55':'<img title="大哭" value="xx55" src="'+ctx+'resources/images/gif/x55.gif">',
		'xx56':'<img title="锤死你" value="xx56" src="'+ctx+'resources/images/gif/x56.gif">',
		'xx57':'<img title="卧地撒娇" value="xx57" src="'+ctx+'resources/images/gif/x57.gif">',
		'xx58':'<img title="泪奔" value="xx58" src="'+ctx+'resources/images/gif/x58.gif">',
		'xx59':'<img title="灵魂出窍" value="xx59" src="'+ctx+'resources/images/gif/x59.gif">',
		'xx60':'<img title="鬼来了" value="xx60" src="'+ctx+'resources/images/gif/x60.gif">',
		'xx61':'<img title="人呢" value="xx61" src="'+ctx+'resources/images/gif/x61.gif">',
		'xx62':'<img title="被雷劈中" value="xx62" src="'+ctx+'resources/images/gif/x62.gif">',
		'xx63':'<img title="我闪" value="xx63" src="'+ctx+'resources/images/gif/x63.gif">',
		'xx64':'<img title="超级搞笑" value="xx64" src="'+ctx+'resources/images/gif/x64.gif">',
		'xx65':'<img title="晕倒" value="xx65" src="'+ctx+'resources/images/gif/x65.gif">',
		'xx66':'<img title="数钱" value="xx66" src="'+ctx+'resources/images/gif/x66.gif">',
		'xx67':'<img title="求求你嘞" value="xx67" src="'+ctx+'resources/images/gif/x67.gif">',
		'xx68':'<img title="吐死你" value="xx68" src="'+ctx+'resources/images/gif/x68.gif">',
		'xx69':'<img title="虾米" value="xx69" src="'+ctx+'resources/images/gif/x69.gif">',
		'xx70':'<img title="有糖吃" value="xx70" src="'+ctx+'resources/images/gif/x70.gif">',
		'xx71':'<img title="受不鸟了" value="xx71" src="'+ctx+'resources/images/gif/x71.gif">',
		'xx72':'<img title="吐血身亡" value="xx72" src="'+ctx+'resources/images/gif/x72.gif">',
		'xx73':'<img title="扎小人" value="xx73" src="'+ctx+'resources/images/gif/x73.gif">',
		'xx74':'<img title="被蹂躏" value="xx74" src="'+ctx+'resources/images/gif/x74.gif">',
		'xx75':'<img title="惊醒" value="xx75" src="'+ctx+'resources/images/gif/x75.gif">',
		'xx76':'<img title="刚睡醒" value="xx76" src="'+ctx+'resources/images/gif/x76.gif">',
		'xx77':'<img title="喷血身亡" value="xx77" src="'+ctx+'resources/images/gif/x77.gif">',
		'xx78':'<img title="吃饭啦" value="xx78" src="'+ctx+'resources/images/gif/x78.gif">',
		'xx79':'<img title="机关枪" value="xx79" src="'+ctx+'resources/images/gif/x79.gif">',
		'xx80':'<img title="铁头功" value="xx80" src="'+ctx+'resources/images/gif/x80.gif">',
		'xx81':'<img title="不要哇哇" value="xx81" src="'+ctx+'resources/images/gif/x81.gif">',
		'xx82':'<img title="加油" value="xx82" src="'+ctx+'resources/images/gif/x82.gif">',
		'xx83':'<img title="拍小人" value="xx83" src="'+ctx+'resources/images/gif/x83.gif">',
		'xx84':'<img title="飘过" value="xx84" src="'+ctx+'resources/images/gif/x84.gif">',
		'xx85':'<img title="后会有期" value="xx85" src="'+ctx+'resources/images/gif/x85.gif">',
};
var reg_img=/\[.+?\]/g;
var reg_gif=/xx\d\d/g;
var reg_n=new RegExp("\n","g");
var reg_nbsp=new RegExp(" ","g");

//输入框中插入指定内容
(function($){
    $.fn.extend({
        insertAtCaret: function(myValue){
            var $t=$(this)[0];
            if (document.selection) {
                this.focus();
                sel = document.selection.createRange();
                sel.text = myValue;
                this.focus();
            }
            else
                if ($t.selectionStart || $t.selectionStart == '0') {
                    var startPos = $t.selectionStart;
                    var endPos = $t.selectionEnd;
                    var scrollTop = $t.scrollTop;
                    $t.value = $t.value.substring(0, startPos) + myValue + $t.value.substring(endPos, $t.value.length);
                    this.focus();
                    $t.selectionStart = startPos + myValue.length;
                    $t.selectionEnd = startPos + myValue.length;
                    $t.scrollTop = scrollTop;
                }
                else {
                    this.value += myValue;
                    this.focus();
                }
        }
    })  
})(jQuery);

//移除数组中的固定元素
function removeByValue(e,r){for(var a=0;a<e.length;a++)if(e[a]==r){e.splice(a,1);break}}

//删除数组重复元素
function uniqueArray(r){var n=new Array;for(var u in r)-1==n.indexOf(r[u])&&n.push(r[u]);return n}
//删除数组重复对象
function uniqueObject(n){var r={};return n.forEach(function(n){r[JSON.stringify(n)]=n}),n=Object.keys(r).map(function(n){return JSON.parse(n)})}

//动态详情
function club_news_id(id,url,replace){
	replace=replace||false;
	replace?location.replace(url+"?Code="+Encrypt("newsId="+id)):window.location.href=url+"?Code="+Encrypt("newsId="+id)
}
function club_news_essay(id,replace){club_news_id(id,"club-news-essays",replace)}
function club_news_picture(id,replace){club_news_id(id,"club-news-pictures",replace)}
function club_news_video(id,replace){club_news_id(id,"club-news-videos",replace)}

//赛事详情
function enterGameDetail(e,o){if(void 0===o)var t=window.open("about:blank");void 0!==o?location.replace(ctx+"game-centres?Code="+Encrypt("gameId="+e+"&projectId="+projectId)):t.location.replace("game-centres?Code="+Encrypt("gameId="+e+"&projectId="+projectId))}

//赛事介绍详情
function enterGameIntroduction(e,o,i){void 0!==i?location.replace("game-introductions?Code="+Encrypt("gameId="+e+"&introductionId="+o)):window.location.href="game-introductions?Code="+Encrypt("gameId="+e+"&introductionId="+o)}

//社区详情
function enterClubDetail(c,e,n,o){0==n||8==n?void 0!==o?location.replace("myclubs?Code="+Encrypt("clubId="+c)):window.location.href="myclubs?Code="+Encrypt("clubId="+c):void 0!==o?location.replace("partner-indexs?Code="+Encrypt("clubId="+c)):window.location.href="partner-indexs?Code="+Encrypt("clubId="+c)}

//直播详情
function enterLivePlay(e,i){null!=e&&(void 0!==i?location.replace("livepage?Code="+Encrypt("liveId="+e)):window.location.href="livepage?Code="+Encrypt("liveId="+e))}

//点播详情
function enterVideoPlay(e,o,d,i){void 0!==i?location.replace("video-comments?Code="+Encrypt("classId="+e+"&videoId="+o+"&videoTitle="+d)):window.location.href="video-comments?Code="+Encrypt("classId="+e+"&videoId="+o+"&videoTitle="+d)}

//商城商品详情
function enterMallDetails(id,club_id,replace,pre_sale,star_time){
	club_id=club_id||"";
	replace=replace||false;
	pre_sale=pre_sale||"";
	star_time=star_time||"";
	if(replace){
		location.replace("mall-details?Code="+Encrypt("productId="+id+(club_id==''?"":"&clubId="+club_id)+(pre_sale==''?"":"&pre_sale="+pre_sale)+(star_time==''?"":"&star_time="+star_time)));
	}else{
		window.location.href = "mall-details?Code="+Encrypt("productId="+id+(club_id==''?"":"&clubId="+club_id)+(pre_sale==''?"":"&pre_sale="+pre_sale)+(star_time==''?"":"&star_time="+star_time))
	}
}

//单位导购商品详情
function clubEnterMallDetails(id,replace){
	replace=replace||false;
	if(replace){
		location.replace("clubShoppingGuide-details?Code="+Encrypt("productId="+id));
	}else{
		window.location.href = "clubShoppingGuide-details?Code="+Encrypt("productId="+id);
	}
}

//龙特权商品详情
function enterMallRightDetails(id,replace){
	replace=replace||false;
	if(replace){
		location.replace("mall-right-details?Code="+Encrypt("productId="+id));
	}else{
		window.location.href = "mall-right-details?Code="+Encrypt("productId="+id);
	}
}

//商品类别
function EnterProjectChild(sn_code,sn_name,replace){
	setAttribute({"sn_code":sn_code,"sn_name":sn_name},function(){
		replace=replace||false;
		if(replace){
			location.replace(ctx+"mall-list-childs");
		}else{
			window.location.href = ctx+"mall-list-childs";
		}
	})
}

//指定品牌列表
function enterBrandChild(n,d){void 0!==d?location.replace("mall-brand-shops?Code="+Encrypt("brandId="+n)):window.location.href="mall-brand-shops?Code="+Encrypt("brandId="+n)}

//培训详情
function enterTrainDetail(i,c,n){void 0!==n?location.replace("train-details?Code="+Encrypt("trainId="+i+"&clubId="+c)):window.location.href="train-details?Code="+Encrypt("trainId="+i+"&clubId="+c)}

//动动约详情
function enterServiceDetail(e,i){void 0!==i?location.replace("service-details?Code="+Encrypt("serviceCode="+e)):window.location.href="service-details?Code="+Encrypt("serviceCode="+e)}

//服务者详情
function enterQualification(c,i){window.location.href=ctx+"myclub-coach-infos?Code="+Encrypt("clubId="+i+"&qualificationPersonId="+c)}

//图片不足容器尺寸时放大图片尺寸
function resizeImg(obj){
	var W,w,H,h;
	W=obj.parent().width();//容器宽
	H=obj.parent().height();//容器高
	w=obj.width();//图片宽
	h=obj.height();//图片高
	if(w<W&&h<H){
		if(w/h<W/H){//放大图片至图片高等于容器高
			obj.height("100%");
			obj.width("auto");
			h=H;
		}else{//放大图片至图片宽等于容器宽
			obj.width("100%");
			obj.height("auto");
			w=W
		}
	}
}
//裁剪图片
function clipImg(obj){
	var W,w,H,h;
	var clip="";
	W=obj.parent().width();
	H=obj.parent().height();
	w=obj.width();
	h=obj.height();
	if(h>=H){
		clip='rect('+(h-H)/2+'px auto '+(h+H)/2+'px auto)';
	}else{
		obj.css("height",H);
		obj.css("width","auto");
		w=obj.width();
		h=obj.height();
		clip='rect(auto '+(w+W)/2+'px auto '+(w-W)/2+'px)';
	}
	obj.css("top",(H-h)/2);
	obj.css("left",(W-w)/2);
	obj.css("clip",clip);
}
//分享到全民动动
function SharetoQMDD(type_id,type,club_id,id,title,imgurl,info_time,price,bean,linkurl,class_id){
	checkLogin(function(){
		window.open('share-tos?Code='+Encrypt('type_id='+type_id+'&type='+type+'&club_id='+club_id+'&id='+id+'&title='+title+'&imgurl='+imgurl+'&info_time='+info_time+'&price='+price+'&bean='+bean+'&linkurl='+linkurl+'&class_id='+class_id));
	});
}

//分享到动动圈
function SharetoWord(type_id,project_id,id,type,club_id,club_type,name,class_id,url,img){
	checkLogin(function(){
		window.open('share-to-myworlds?Code='+Encrypt('type_id='+type_id+'&from_gfid='+gfId+'&project_id='+projectId+'&id='+id+'&type='+type+'&club_id='+club_id+'&club_type='+club_type+'&name='+name+'&class_id='+class_id+'&url='+url+'&img='+img));
	});
}

//打开APP
var createIframe = (function () {
    var iframe;
    return function () {
        if (iframe) {
            return iframe;
        } else {
            iframe = document.createElement('iframe');
            iframe.style.display = 'none';
            document.body.appendChild(iframe);
            return iframe;
        }
    }
})()
var baseScheme = "qmdd://share/from?",baseLink="http://www.gfinter.net?";
var createScheme = function (options,isLink) {
    var urlScheme = isLink?baseLink:baseScheme;
    var urlcode='';
    for (var item in options) {
    	urlcode+=item + '=' + encodeURIComponent(options[item]) + "&";
    }
    urlScheme+=Encrypt(urlcode.substring(0, urlcode.length-1));
    return urlScheme;
}
var openApp = function (options) {
	if((!!/MicroMessenger/i.test(navigator.userAgent))||((!!/MQQBrowser/i.test(navigator.userAgent))&&(!!/QQ\//i.test(navigator.userAgent)))){
		$.MsgBox.Alert("温馨提示",'请用浏览器打开');
	}else{
		var localUrl=createScheme(options);
		$(".app_url").prop("href",localUrl)
	    var openIframe = createIframe();
	    if(browser.versions.ios){//判断是否是ios
//	        if(get_ios_version()>=9){
//	            //判断是否为ios9以上的版本,跟其他判断一样navigator.userAgent判断,ios会有带版本号
//	            localUrl=createScheme(options,true);//代码还可以优化一下
//	            location.href = localUrl;//实际上不少产品会选择一开始将链接写入到用户需要点击的a标签里
//	            return;
//	        }
	    	$(".app_url")[0].click();
	        var loadDateTime = Date.now();
	        setTimeout(function () {
	            var timeOutDateTime = Date.now();
	            if (timeOutDateTime - loadDateTime < 1000) {
	            	 window.open("http://itunes.apple.com/us/app/quan-min-dong-dong/id1075717826?ls=1&mt=8");
	            }
	        }, 25);
	    }else if(browser.versions.android){//判断是否是android
	        if (browser.versions.webKit) {
	            //chrome浏览器用iframe打不开得直接去打开，算一个坑
	        	$(".app_url")[0].click();
	        } else {
	            //抛出你的scheme
	            openIframe.src = localUrl;
	        }
	        setTimeout(function () {
	        	window.open("https://www.gf41.net/qmdd/");
	        }, 2000);
	    } else if (isWeiXin()) {
	    	setTimeout(function () {
	        	window.open("https://www.gf41.net/qmdd/");
	        }, 2000);
	    } else if (is_qq()) {
	    	setTimeout(function () {
	        	window.open("https://www.gf41.net/qmdd/");
	        }, 2000);
	    } else{
	        //主要是给winphone的用户准备的,实际都没测过，现在winphone不好找啊
	        openIframe.src = localUrl;
	        setTimeout(function () {
	        	window.open("https://www.gf41.net/qmdd/");
	        }, 2000);
	    }
	}
}


//判断是否是微信浏览器的函数
function isWeiXin(){return"micromessenger"==window.navigator.userAgent.toLowerCase().match(/MicroMessenger/i)}

// 判断是否是qq浏览器
function is_qq(){return!1!==strpos($_SERVER.HTTP_USER_AGENT,"MQQBrowser")}

