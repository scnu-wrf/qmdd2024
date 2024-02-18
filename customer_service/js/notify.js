
var ClientId;
var s_topic;//发送主题
var r_topic;//订阅主题
$(function(){
	ClientId=visitId;
})
var Websocket = function() {
	this.client = null;
	this._init();
};
Websocket.prototype._init = function() {
	var _this = this;
	var mqtt_port=8083;
	if(location.hostname.indexOf("gf41.net")>=0){
		mqtt_port=(location.protocol=="http:"?8083:8084);
	}else if(location.hostname.indexOf("oss.gfinter.net")>=0){
		mqtt_port=(location.protocol=="http:"?6063:6064);
	}else if(location.hostname.indexOf("gfinter.net")>=0){
		mqtt_port=(location.protocol=="http:"?7073:7074);
	}
	_this.vmWS = {
		data: {
			connState : false,
			cInfo : {
				host : "emq.gf41.net",
				port : mqtt_port,
				clientId : ClientId,
				userName : null,
				password : null,
				keepAlive: null,
				cleanSession : true,
				useSSL : (location.protocol=="http:"?false:true)
			},
			subInfo : {
				topic : r_topic,
				qos : 0
			},
			subscriptions : [],
			sendInfo : {
				topic : s_topic,
				qos : 0,
				retained : false
			},
			sendMsgs : [],
			receiveMsgs : []
		},
		filters: {
			reverse: function( arr ) {
				return arr.reverse();
			}
		},
		methods : {
			connect : function() {
				_this.connect();
			},
			disconnect : function() {
				_this.disconnect();
			},
			sub : function() {
				_this.subscribe();
			},
			unsub : function() {
				_this.unsubscribe(); 
			},
			send : function() {
				_this.sendMessage();
			},
			sslPort :function() {
				_this.sslPort();
			}
		}
	}
};
Websocket.prototype.newClient = function() {
	this.client = new Paho.MQTT.Client(
			this.vmWS.data.cInfo.host,
			Number(this.vmWS.data.cInfo.port),
			this.vmWS.data.cInfo.clientId);
};
Websocket.prototype.sslPort = function() {
	var useSSL = this.vmWS.data.cInfo.useSSL;
	if (useSSL) {
		this.vmWS.data.cInfo.port = 8084
	} else {
		this.vmWS.data.cInfo.port = 8083
	}
};
var payloadBytes;//消息结构
var encode_payloadBytes;//加密消息结构
Websocket.prototype.connect = function(MessageArrivedFun) {
	var _this = this;
	_this.newClient();

	if (!_this.client) {
		return;
	}
	// called when the client loses its connection
	_this.client.onConnectionLost = function(responseObject) {
		if (responseObject.errorCode !== 0) {
			console.log("onConnectionLost: " + responseObject.errorMessage);
		}
		_this.disconnect();
	}
	// called when a message arrives
	_this.client.onMessageArrived = MessageArrivedFun;
	
	var options = {
		onSuccess : function() {
//			console.log("The client connect success.");
			_this.vmWS.data.connState = true;
			_this.subscribe();
		},
		onFailure : function(err) {
			console.log(err)
			console.log("The client connect failure abc " + err.errorMessage);  
		
			_this.vmWS.data.connState = false;
		}
	};
	var userName = _this.vmWS.data.cInfo.userName;
	var password = _this.vmWS.data.cInfo.password;
	var keepAlive = _this.vmWS.data.cInfo.keepAlive;
	var cleanSession = _this.vmWS.data.cInfo.cleanSession;
	var useSSL = _this.vmWS.data.cInfo.useSSL;
	if (userName) {
		options.userName = userName;
	}
	if (password) {
		options.password = password;
	}
	if (keepAlive) {
		options.keepAliveInterval = Number(keepAlive);
	}
	options.cleanSession = cleanSession;
	options.useSSL= useSSL;
	_this.client.connect(options);
};
Websocket.prototype.disconnect = function() {
	var _this = this;
	if (_this.client && _this.client.isConnected()) {
		_this.client.disconnect();
		_this.client = null;
	}
	console.log("The client disconnect success.");
	_this.vmWS.data.connState = false;
};
Websocket.prototype.subscribe = function() {
	var _this = this;
	if (!_this.client || !_this.client.isConnected()) {
		alert('The client does not connect to the broker');
		return;
	}
	if (!_this.vmWS.data.subInfo.topic) {
		alert('Please fill in the topic.');
		return;
	}
	this.client.subscribe(_this.vmWS.data.subInfo.topic, {
		qos : Number(_this.vmWS.data.subInfo.qos),
		onSuccess : function(msg) {
//			console.log(JSON.stringify(msg));
			_this.vmWS.data.subInfo.time = (new Date()).format("yyyy-MM-dd hh:mm:ss");
			_this.vmWS.data.subscriptions.push(_this.vmWS.data.subInfo);
			_this.vmWS.data.subInfo = {qos : _this.vmWS.data.subInfo.qos};
		},
		onFailure : function(err) {
			if (err.errorCode[0] == 128) {
				alert('The topic cannot SUBSCRIBE for ACL Deny');
				console.log(JSON.stringify(err));
			}
		}
	});
};
Websocket.prototype.unsubscribe = function() {
	var _this = this;
	if (!_this.client || !_this.client.isConnected()) {
		alert('The client does not connect to the broker');
		return;
	}
	if (!_this.vmWS.data.subInfo.topic) {
		alert('Please fill in the topic.');
		return;
	}
	this.client.unsubscribe(_this.vmWS.data.subInfo.topic, {
		onSuccess : function(msg) {
			console.log(JSON.stringify(msg));
			_this.vmWS.data.subInfo = {qos : _this.vmWS.data.subInfo.qos};
		},
		onFailure : function(err) {
			console.log(JSON.stringify(err));
		}
	});
};
var sendBytes;
Websocket.prototype.sendMessage = function(text) {
	var _this = this;
	if (!_this.client || !_this.client.isConnected()) {
		alert('The client does not connect to the broker');
		return;
	}
	if (!s_topic) {
		$.MsgBox.Alert("温馨提示",'未选择聊天对象');
		return;
	}
	if (!text) {
		alert('Please fill in the message content.');
		return;
	}
	sendBytes={};
	var array=sendBytes.packType
	array=new Uint8Array(array);
	var message = new Paho.MQTT.Message(array);
	message.destinationName = s_topic;
	message.qos = Number(_this.vmWS.data.sendInfo.qos);
	message.retained = _this.vmWS.data.sendInfo.retained;
	_this.client.send(message);
	_this.vmWS.data.sendInfo.time = (new Date()).format("yyyy-MM-dd hh:mm:ss");
	_this.vmWS.data.sendMsgs.push(_this.vmWS.data.sendInfo);
	_this.vmWS.data.sendInfo = {
			topic : s_topic,
			qos : _this.vmWS.data.sendInfo.qos,
			retained : _this.vmWS.data.sendInfo.retained};
};
//字符串转字节数组
function stringToByte(str) {  
    var bytes = new Array();  
    var len, c;  
    len = str.length;  
    for(var i = 0; i < len; i++) {  
        c = str.charCodeAt(i);  
        if(c >= 0x010000 && c <= 0x10FFFF) {  
            bytes.push(((c >> 18) & 0x07) | 0xF0);  
            bytes.push(((c >> 12) & 0x3F) | 0x80);  
            bytes.push(((c >> 6) & 0x3F) | 0x80);  
            bytes.push((c & 0x3F) | 0x80);  
        } else if(c >= 0x000800 && c <= 0x00FFFF) {  
            bytes.push(((c >> 12) & 0x0F) | 0xE0);  
            bytes.push(((c >> 6) & 0x3F) | 0x80);  
            bytes.push((c & 0x3F) | 0x80);  
        } else if(c >= 0x000080 && c <= 0x0007FF) {  
            bytes.push(((c >> 6) & 0x1F) | 0xC0);  
            bytes.push((c & 0x3F) | 0x80);  
        } else {  
            bytes.push(c & 0xFF);  
        }  
    }  
    return bytes;
}  
//字节数组转字符串
function byteToString(arr) {  
    if(typeof arr === 'string') {  
        return arr;  
    }  
    var str = '',  
        _arr = arr;  
    for(var i = 0; i < _arr.length; i++) {  
        var one = _arr[i].toString(2),  
            v = one.match(/^1+?(?=0)/);  
        if(v && one.length == 8) {  
            var bytesLength = v[0].length;  
            var store = _arr[i].toString(2).slice(7 - bytesLength);  
            for(var st = 1; st < bytesLength; st++) {  
                store += _arr[st + i].toString(2).slice(2);  
            }  
            str += String.fromCharCode(parseInt(store, 2));  
            i += bytesLength - 1;  
        } else {  
            str += String.fromCharCode(_arr[i]);  
        }  
    }  
    return str;  
} 
/*int数值转换为占四个字节的byte数组*/
//(低位在前，高位在后)
function intToByte(value){   
    var src = new Array(4);  
    src[3] = ((value>>24) & 0xFF);  
    src[2] = ((value>>16) & 0xFF);  
    src[1] = ((value>>8) & 0xFF);    
    src[0] = (value & 0xFF);                  
    return src;   
} 
//(高位在前，低位在后)
function intToByte2(value){   
    var src = new Array(4);  
    src[0] = ((value>>24) & 0xFF);  
    src[1] = ((value>>16) & 0xFF);  
    src[2] = ((value>>8) & 0xFF);    
    src[3] = (value & 0xFF);                  
    return src;   
} 
/*byte数组中取int数值*/
//(低位在前，高位在后)
function byteToInt(src,offset) {  
    var value;    
    value = ((src[offset] & 0xFF)   
        | ((src[offset+1] & 0xFF)<<8)   
        | ((src[offset+2] & 0xFF)<<16)   
        | ((src[offset+3] & 0xFF)<<24));  
    return value;  
}
//(高位在前，低位在后)
function byteToInt2(src,offset) {  
    var value;    
    value = ( ((src[offset] & 0xFF)<<24)  
        |((src[offset+1] & 0xFF)<<16)  
        |((src[offset+2] & 0xFF)<<8)  
        |(src[offset+3] & 0xFF));  
    return value;  
}
/*long数值转换为占四个字节的byte数组*/
//(低位在前，高位在后)
function longToByte(value){  
	var src = new Array(8);  
	src[7] = ((value>>56) & 0xFF);  
	src[6] = ((value>>48) & 0xFF);  
	src[5] = ((value>>40) & 0xFF);
	src[4] = ((value>>32) & 0xFF);  
	src[3] = ((value>>24) & 0xFF);  
	src[2] = ((value>>16) & 0xFF);  
	src[1] = ((value>>8) & 0xFF);
	src[0] = (value & 0xFF);
	return src;   
} 
//(高位在前，低位在后)
function longToByte2(value){   
	var src = new Array(8);  
	src[0] = ((value>>56) & 0xFF); 
	src[1] = ((value>>48) & 0xFF);  
	src[2] = ((value>>40) & 0xFF);  
	src[3] = ((value>>32) & 0xFF);  
	src[4] = ((value>>24) & 0xFF);  
	src[5] = ((value>>16) & 0xFF);  
	src[6] = ((value>>8) & 0xFF);    
	src[7] = (value & 0xFF);                  
	return src;   
} 
/*byte数组中取long数值*/
//(低位在前，高位在后)
function byteToLong(src,offset) {  
	var value;    
	value = ((src[offset] & 0xFF) 
		| ((src[offset+1] & 0xFF)<<8)   
		| ((src[offset+2] & 0xFF)<<16)   
		| ((src[offset+3] & 0xFF)<<24)
		| ((src[offset+4] & 0xFF)<<32)
		| ((src[offset+5] & 0xFF)<<40)
		| ((src[offset+6] & 0xFF)<<48)
		| ((src[offset+7] & 0xFF)<<56));
	return value;  
}
//(高位在前，低位在后)
function byteToLong2(src,offset) {  
    var value;    
    value = (((src[offset] & 0xFF)<<56)
        |((src[offset+1] & 0xFF)<<48)
        |((src[offset+2] & 0xFF)<<40)
        |((src[offset+3] & 0xFF)<<32)
    	|((src[offset+4] & 0xFF)<<24)
        |((src[offset+5] & 0xFF)<<16)  
        |((src[offset+6] & 0xFF)<<8)  
        |(src[offset+7] & 0xFF));  
    return value;  
}

//桌面提示
function notify(msg) {
    showMsgNotification('新消息', msg);
}
var timer = null,
title = $('title').text();
function showMsgNotification(title, msg, icon) {
    var options = {
        body: msg,
        icon: icon || "customer_service/images/footer_download8.png"
    };
    var Notification = window.Notification || window.mozNotification || window.webkitNotification;
    if (Notification) { //支持桌面通知  
    	if (Notification && Notification.permission === "granted") { //已经允许通知  
            var instance = new Notification(title, options);
            instance.onclick = function () {
                // Something to do  
            };
            instance.onerror = function () {
                // Something to do  
            };
            instance.onshow = function () {
                // Something to do
                setTimeout(function () {
                    instance.close();
                }, 3000)
                //console.log(instance.body)
            };
            instance.onclose = function () {
                // Something to do  
            };
            //console.log(instance)
        } else if (Notification && Notification.permission !== "denied") { //第一次询问或已经禁止通知(如果用户之前已经禁止显示通知，那么浏览器不会再次询问用户的意见，Notification.requestPermission()方法无效)  
            Notification.requestPermission(function (status) {
                if (Notification.permission !== status) {
                    Notification.permission = status;
                }
                // If the user said okay  
                if (status === "granted") { //用户允许  
                    var instance = new Notification(title, options);
                    instance.onclick = function () {
                        // Something to do  
                    };
                    instance.onerror = function () {
                        // Something to do  
                    };
                    instance.onshow = function () {
                        // Something to do  
                        setTimeout(instance.close, 3000);
                    };
                    instance.onclose = function () {
                        // Something to do  
                    };
                } else { //用户禁止  
                    return false
                }
            });
        } else {
            return false;
        }
    } else { //不支持(IE等)  
        var index = 0;
        clearInterval(timer);
        timer = setInterval(function () {
            if (index % 2) {
                $('title').text('【　　　】' + msg); //这里是中文全角空格，其他不行  
            } else {
                $('title').text('【'+title+'】' + msg);
            }
            index++;

            if (index > 20) {
                clearInterval(timer);
            }
        }, 500);
    }
}