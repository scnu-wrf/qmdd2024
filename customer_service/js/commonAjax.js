// JavaScript Document
var FAILURE_MSG = "failure";
var ERROR_MSG = "error";
var SUCCESS_MSG = "success";
var EMPTY_MSG = "empty";
var returnData = "";//返回结果
var serverIp = "";//整合后不需要跨域调用


/**
 * url不显示参数的参数传递
 * 
 */
(function(){
    //设置命名空间
    var CodeSTD = window.CodeSTD || {};

    window.CodeSTD = CodeSTD; 

    /**
     * 创建Form表单
     * @author Valone
     * @param config Object
     *  <p>url:form的Action，提交的后台地址</p>
     *  <p>method:使用POST还是GET提交表单</p>
     *  <p>params:参数 K-V</p>
     * @return Form
     */
    CodeSTD.form = function(config){
    	console.log(config);
        config = config || {};

        var url = config.url,
            method = config.method || 'GET',
            params = config.params || {};

        var form = document.createElement('form');
        form.action = url;
        form.method = method;
        form.target = "_blank";

        for(var param in params){
            var value = params[param],
                input = document.createElement('input');

            input.type = 'hidden';
            input.name = param;
            input.value = value;

            form.appendChild(input);
        }

        return form;
    }


})()


/**
* 
* 通用AJAX调用action，不返回JSON数据
* @author valone
* @param keyword Map()对象
* @param action调用的功能
* @param type:get,post
* @param async:false同步,true异步
* @param callback1(data)回调函数，用于在发送请求前做判断数据操作
* @param callback2(data)回调函数，用于处理获取的结果data
* @return 调用成功返回success
* @return 调用失败返回error
*/
var ajaxNoReturn = function(keyword,action,type,async,callback1,callback2){
	var dataMap = keyword.toJSON();
	$.ajax({
		type:type,
		url:action,
		data:dataMap,
		async:async,
		beforeSend: function(e){
			if(callback1 && typeof callback1 != 'undefined' && callback1 != undefined)
				if(!callback1(e))
					return false;
				else
					return true;
		},
		success: function(e){
			console.log(e);
			if(e["result"] == "成功")
				returnData = SUCCESS_MSG;
			else if(e["result"] == "失败")
				returnData = FAILURE_MSG;
			else
				returnData = ERROR_MSG;
			callback2(returnData);
//			console.clear();
		},
		error: function(){
			returnData = ERROR_MSG;	
			callback2(returnData);
		}
	})	
}

/**
* 
* 通用AJAX调用action获取JSON数据
* @author valone
* @param keyword Map()对象
* @param action调用的功能
* @param type:get,post
* @param async:false同步,true异步
* @param callback1(data)回调函数，用于在发送请求前做判断数据操作
* @param callback2(data)回调函数，用于处理获取的结果data
* @return 调用成功获取数据无错非空返回JSON字符串
* @return 数据为空返回empty
* @return 数据错误返回error
* @return 调用失败返回error
*/
var ajaxJsonReturn = function(keyword,action,type,async,callback1,callback2){
	var dataMap = keyword.toJSON();
	$.ajax({
		type:type,
		url:action,
		data:dataMap,
		async:async,
		beforeSend: function(e){
			if(callback1 && typeof callback1 != 'undefined' && callback1 != undefined)
				if(!callback1(e))
					return false;
				else
					return true;
		},
		success: function(e){
			if(!e.error && !e.empty){
				returnData = e;
			}
			else if(e.empty)
				returnData = EMPTY_MSG;
			else
				returnData = ERROR_MSG;	
			callback2(returnData);
//			console.clear();
		},
		error: function(){
			returnData = ERROR_MSG;	
			callback2(returnData);
		}
	})	
}

$.ajaxloading = function (options, aimDiv) {
    var img = $('<img id="progressImgage"  src="customer_service/images/loading.gif"/>'); //Loading小图标
    var mask = $('<div id="maskOfProgressImage"></div>').addClass("mask").addClass("hide"); //Div遮罩
	var PositionStyle = "fixed";
	
    //是否将Loading固定在aimDiv中操作,否则默认为全屏Loading遮罩
    if (aimDiv != null && aimDiv != "" && aimDiv != undefined) {
        $(aimDiv).css("position", "relative").append(img).append(mask);
        PositionStyle = "absolute";
    }
    else {
        $("body").append(img).append(mask);
    }
    img.css({
        "z-index": "1000",
        "display": "none"
    })
    mask.css({
        "position": PositionStyle,
        "top": "0",
        "right": "0",
        "bottom": "0",
        "left": "0",
        "z-index": "1000",
        "background-color": "#000000",
        "display": "none"
    });
	var complete = options.complete;
    options.complete = function (httpRequest, status) {
        img.remove();
        mask.remove();
        if (complete) {
            complete(httpRequest, status);
        }
//        console.clear();
    };
    img.show().css({
    	"width":"80px",
    	"heigth":"80px",
        "position": PositionStyle,
        "top": "50%",
        "left": "50%",
        "margin-top": "-40px",
        "margin-left": "-40px"
    });
    mask.show().css("opacity", "0.1");
    $.ajax(options);
};




/**
* 
* Map对象
* @valone
* @return Map  
*/
function Map(){
	this.container = new Object();	
}

/**
*
* Map put 方法
* @valone
* @param key
* @param vlaue 
*/
Map.prototype.put = function(key,value){
	this.container[key] = value;	
}

/**
*
* Map get 方法
* @valone
* @param key
* @return vlaue 
*/
Map.prototype.get = function(key){
	return this.container[key];	
}

/**
*
* Map keySet 方法
* @valone
* @return key集合
*/
Map.prototype.keySet = function(){
	var keySet = new Array();
	var count = 0;
	for(var key in this.container){
		if(key == 'extend')
			continue;
		keySet[count] = key;
		count ++;
	}
	return keySet;
}

/**
*
* Map size 方法
* @valone
* @return size
*/
Map.prototype.size = function(){
	var count = 0;
	for(var key in this.container){
		if(key == 'extend')
			continue;
		count ++;	
	}
	return count;
}

/**
*
* Map remove 方法
* @valone
* @param key 
*/
Map.prototype.remove = function(key){
	delete this.container[key];	
}


/**
*
* @valone
* @return string形式 
* Map toString 方法
*/
Map.prototype.toString = function(){
	var str = "";
	for(var key in this.container){
		if(key == 'extend')
			continue;
		str += key + ":" + this.container[key] + ","
	}
	str = str.substring(0,str.length-1);
	return str;
}

/**
*
* @valone
* @return JSON形式 
* Map toJSON 方法
*/
Map.prototype.toJSON = function(){
	return this.container;
}

/**
 * @valone
 * 扩展javaScriptDate类型工具js
 * 实现格式化日期功能
 */
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