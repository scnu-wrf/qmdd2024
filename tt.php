
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Qmdd Menu</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles/general.css" rel="stylesheet" type="text/css" />
<script language="JavaScript">
<!--
var noHelp   = "<p align='center' style='color: #666'>暂时还没有该部分内容</p>";
var helpLang = "{$help_lang}";
//-->
</script>

<style type="text/css"> 
body {
  background: #212121;
}
html::-webkit-scrollbar {
    width: 4px;
    height: 4px;
    background-color: #DBDBDB;
}
html::-webkit-scrollbar-thumb {
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    -o-border-radius: 10px;
    -ms-border-radius: 10px;
    border-radius: 10px;
    -moz-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    -o-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    -ms-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    box-shadow: inset 0 0 6px rgba(0,0,0,0);
    background-color: #303030;
}
html::-webkit-scrollbar-track {
    -moz-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    -o-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    -ms-box-shadow: inset 0 0 6px rgba(0,0,0,0);
    box-shadow: inset 0 0 6px rgba(0,0,0,0);
    -moz-border-radius: 10px;
    -webkit-border-radius: 10px;
    -o-border-radius: 10px;
    -ms-border-radius: 10px;
    border-radius: 10px;
    background-color: #DBDBDB;
}
#tabbar-div {
  padding-left: 10px;
  height: 34px;
  padding-top: 0px;
  background:#303030;
}
#tabbar-div p {
  margin: 1px 0 0 0;
}
.tab-front {
  line-height: 33px;
  font-weight: bold;
  padding: 4px 15px 4px 18px;
  cursor: hand;
  cursor: pointer; font-size:14px; font-family:"微软雅黑"; color:#fff;
}
.tab-back {
  color: #F4FAFB;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  cursor: hand;
  cursor: pointer;
}
.tab-hover {
  color: #F4FAFB;
  line-height: 20px;
  padding: 4px 15px 4px 18px;
  cursor: hand;
  cursor: pointer;
  background: #2F9DB5;
}
#top-div
{
  padding: 3px 0 2px;
  background: #BBDDE5;
  margin: 5px;
  text-align: center;
}
#main-div {


}
#menu-list {
  padding: 0;
  margin: 0;
}
#menu-list ul {
  padding: 0;
  margin: 0;
  list-style-type: none;
  color: #335B64;
}
#menu-list li {

  cursor: hand;
  cursor: pointer;
}
#menu-list li:hover{ background-color:#454545;}
#menu-list li.collapse ul{}
#menu-list li span {
 font-size:14px;padding: 0px 12px; color:#FFF;


}

.collapse, .explode{
display: block;
border-top: #7f7f7f 1px solid;width:100%; color:#FFF; line-height: 42px; text-align:left;}
#main-div a:visited, #menu-list a:link, #menu-list a:hover {
  color: #666
  text-decoration: none;
}
#menu-list a:active {
  color: #fff;
}
.collapse , .explode { text-indent:20px;}
#menu-list li.collapse {

}
.explode{
	background-color:#454545!important;
}

.menu-item {font-size: 12px;
height: 30px;
line-height: 30px;
display: block;
font-weight: normal; background:#575757

}
.menu-item a{font-size: 12px;
height: 30px;
line-height: 30px;
display: block; color:#d7d7d7;}
.menu-item a:hover,.menu-item a.on{background-color:#797979; text-decoration:none; color:#fff;}
#help-title {
  font-size: 14px;
  color: #000080;
  margin: 5px 0;
  padding: 0px;
}
#help-content {
  margin: 0;
  padding: 0;
}
.tips {
  color: #CC0000;
}
.link {
  color: #000099;
}
#menu-ul>li:before{
	content: '';
	display: inline-block;
	position: relative;
    top: -2px;
    width: 5px;
    height: 5px;
    border-radius: 5px;
    background-color: #E6E6E6;
    margin-right: 10px;
}
/* #menu-ul>li:after{
	content: '';
	position: relative;
    float: right;
    left: -10px;
    top: 17px;
	border-top: 9px solid #fff;
	border-right: 8px solid transparent;
	border-left: 8px solid transparent;
} */
#menu-ul>li>ul{
	text-indent:40px;
}
</style>

</head>
<body>
	<div id="tabbar-div" style="display:none">
		<p><span class="tab-front" id="menu-tab">aaa===导航菜单</span></p>
	</div>
	<div id="main-div">
		<div id="menu-list">
			<ul id="menu-ul">
			     						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A05"" key="A05" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					账号管理				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubListZlhb/update_data&id=[:club_id]" target="main-frame">
              战略伙伴认证</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubListSqdw/update_data&id=0" target="main-frame">
              社区单位认证</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubListGys/update_prove&id=0" target="main-frame">
              商家认证</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A10"" key="A10" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					单位归属				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=gfPartnerMemberApply/index_club&index=1&type=404" target="main-frame">
              我加入的单位</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=gfPartnerMemberApply/index_club&index=3&type=404" target="main-frame">
              待审核列表</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=gfPartnerMemberApply/index_club&index=4&type=404" target="main-frame">
              退会列表</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=gfPartnerMemberApply/index_club&index=2&type=404" target="main-frame">
              审核未通过列表</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A15"" key="A15" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					空间/流量				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="javascript:alert('功能暂未开放');" target="main-frame">
              已购流量</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="javascript:alert('功能暂未开放');" target="main-frame">
              已购空间</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A25"" key="A25" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					世界一家				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubList/index&club_type=9" target="main-frame">
              GF官方单位</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubList/index_can&club_type=9" target="main-frame">
              单位注销</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A26"" key="A26" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					管理机构				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubList/index&club_type=1086" target="main-frame">
              集团公司</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubList/index&club_type=495" target="main-frame">
              项目公司</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubListGljg/index_add" target="main-frame">
              添加机构</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubListGljg/index_glbm" target="main-frame">
              管理部门列表</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubListGljg/index_xmgs" target="main-frame">
              项目公司列表</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubList/index_can&club_type=1086" target="main-frame">
              管理机构注销</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubServicerType/index_gldw" target="main-frame">
              管理类型设置</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A30"" key="A30" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					直播权限				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=videoLiveClub/update_apply&id=0" target="main-frame">
              直播权限</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A35"" key="A35" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					费用中心				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=mallShoppingSettlement/index_club" target="main-frame">
              待支付订单</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=mallSalesOrderInfo/index_paid" target="main-frame">
              已支付订单</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A40"" key="A40" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					资产管理				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=gfCreditHistory/index" target="main-frame">
              积分/体育豆</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A45"" key="A45" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					关于我们				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubList/about_me" target="main-frame">
              关于我们</a>
						</li>
											</ul>
											<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubList/index_about_me" target="main-frame">
              各单位关于我们查询</a>
						</li>
											</ul>
									</li>
						               						<li class="collapse lis drop" style="background:#575757 url(images/Backstage-icon/menu/down.png) 179px 12px no-repeat;background-size: 12px 15px;" id="ico2_A50"" key="A50" name="menu" key_data1="images/Backstage-icon/menu/down.png" key_data2="images/Backstage-icon/menu/down.png">
					修改密码				  					<ul style="display:none;">
												<li class="menu-item">
													<a href="qmdd/../qmdd2018/index.php?r=clubadmin/change_password" target="main-frame">
              修改密码</a>
						</li>
											</ul>
									</li>
						          	
			</ul>
		</div>
		<div id="help-div" style="display:none">
			<h1 id="help-title"></h1>
			<div id="help-content"></div>
		</div>
	</div>
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.json.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/transport_jquery.js"></script>
<script language="JavaScript">
<!--
var collapse_all = "闭合";
var expand_all = "展开";
var collapse = true;

var getClass=function(name){
  var ele=document.getElementById("menu-ul").getElementsByTagName("li"),arr=[];
  var reg=new RegExp("(^|\\s)"+name+"(\\s|$)");
  for(var i=0;i<ele.length;i++){
    if(reg.test(ele[i].className)){
      arr.push(ele[i]);
    }
  }
  return arr;
}

function toggleCollapse()
{
  var items = document.getElementsByTagName('LI');
  var span=document.getElementById('menu-ul').getElementsByTagName("span");
  for (i = 0; i < items.length; i++)
  {
    if (collapse)
    {
      if (items[i].className == "explode")
      {
        toggleCollapseExpand(items[i], "collapse");
      }
    }
    else
    {
      if ( items[i].className == "collapse")
      {
        toggleCollapseExpand(items[i], "explode");
        ToggleHanlder.Reset();
      }
    }
  }

  collapse = !collapse;
  var toggleImg = document.getElementById('toggleImg');
  if(toggleImg)
  {
  toggleImg.src = collapse ? 'images/menu_minus.gif' : 'images/menu_plus.gif';
  toggleImg.alt = collapse ? collapse_all : expand_all;
  }
}


function toggleCollapseExpand(obj, status)
{
  var lis=getClass("lis");
  var explode=getClass("explode");
  var ie=/ie 7/i.test(navigator.userAgent),dis=null;
  var ul=document.getElementById("menu-ul").getElementsByTagName("ul");
  var ul0=document.getElementById("menu-ul").getElementsByTagName("li");
  if (obj.tagName.toLowerCase() == 'li' && obj.className != 'menu-item')
  {
    for (i = 0; i < obj.childNodes.length; i++)
    {
      if (obj.childNodes[i].tagName == "UL")
      {
        if (status == null)
        {
          dis=obj.childNodes[1].style.display;
          for(var j=0;j<ul.length;j++){
              ul[j].style["display"]="none";
          }
          obj.childNodes[1].style.display = (dis!= "none") ? "none" : "block";
          if (dis!= "none")
          {
            ToggleHanlder.RecordState(obj.getAttribute("key"), "collapse");
            var s = obj.getAttribute("key_data1");
            obj.className = "collapse lis";
            obj.style.background="#575757 url("+s+") 179px 12px no-repeat;background-size: 12px 15px;";
          }
          else
          {
            for(var i=0;i<lis.length;i++){
              var tmp=lis[i].getAttribute("key_data1");
               lis[i].className="collapse lis";//+tmp;
               lis[i].style.background="#575757 url("+tmp+") 179px 12px no-repeat;background-size: 12px 15px;"
             }
			for(var j=0;j<ul0.length;j++){
				if(ul0[j].getAttribute("name")=="menu"){
					ul0[j].className = 'collapse lis';
				}
			}
            ToggleHanlder.RecordState(obj.getAttribute("key"), "explode");
            var s = obj.getAttribute("key_data2");
            obj.className = "explode";
            obj.style.background="#454545 url("+s+") 179px 12px no-repeat;background-size: 12px 15px;";
          }
          break;
        }
        else
        {
          if( status == "collapse")
          {
            ToggleHanlder.RecordState(obj.getAttribute("key"), "collapse");
            var s ="#575757 url("+obj.getAttribute("key_data1");
            obj.className = "collapse lis";
          }
          else
          {
            ToggleHanlder.RecordState(obj.getAttribute("key"), "explode");
            var s ="#454545 url("+obj.getAttribute("key_data2");
            obj.className = "explode";
          }
          obj.style.background=s+") 179px 12px no-repeat;background-size: 12px 15px;";
          obj.childNodes[1].style.display = (status == "explode") ? "block" : "none";
        }
      }
    }

     for(var j=0;j<ul0.length;j++){
       if(ul0[j].getAttribute("name")=="menu"){
        if((ul0[j].getAttribute("class")=="explode")&&(obj.getAttribute("key")!==ul0[j].getAttribute("key"))){
         var s = ul0[j].getAttribute("key_data1");
         ul0[j].style.background="#575757 url("+s+") 179px 12px no-repeat;background-size: 12px 15px;";
        }
      }
     }
  }
}

document.getElementById('menu-list').onclick = function(e)
{
  var obj = Utils.srcElement(e);
 toggleCollapseExpand(obj);
 var target = e.target;
 if(target.nodeName == "A"){
   var menu_a = document.getElementById('menu-list').getElementsByTagName("a");
   var alength = menu_a.length;
   for(var i = 0 ; i < alength; i ++){
     removeClass(menu_a[i],"on");
   }
   addClass(target,"on");
 }
}
//原生js  addClass,hasClass,removeClass
function addClass(obj, cls) {
  if (!this.hasClass(obj, cls)) obj.className += " " + cls;
}
function hasClass(obj, cls) {
  return obj.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
}
function removeClass(obj, cls) {
  if (hasClass(obj, cls)) {
    var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
    obj.className = obj.className.replace(reg, ' ');
  }
}

document.getElementById('tabbar-div').onmouseover=function(e)
{
  var obj = Utils.srcElement(e);

  if (obj.className == "tab-back")
  {
    obj.className = "tab-hover";
  }
}

document.getElementById('tabbar-div').onmouseout=function(e)
{
  var obj = Utils.srcElement(e);

  if (obj.className == "tab-hover")
  {
    obj.className = "tab-back";
  }
}

document.getElementById('tabbar-div').onclick=function(e)
{
  var obj = Utils.srcElement(e);
 // var mnuTab = document.getElementById('menu-tab');
  var hlpTab = document.getElementById('help-tab');
  var mnuDiv = document.getElementById('menu-list');
  var hlpDiv = document.getElementById('help-div');


  if (obj.id == 'help-tab')
  {
    mnuTab.className = 'tab-back';
    hlpTab.className = 'tab-front';
    mnuDiv.style.display = "none";
    hlpDiv.style.display = "block";

    loc = parent.frames['main-frame'].location.href;
    pos1 = loc.lastIndexOf("/");
    pos2 = loc.lastIndexOf("?");
    pos3 = loc.indexOf("act=");
    pos4 = loc.indexOf("&", pos3);

    filename = loc.substring(pos1 + 1, pos2 - 4);
    act = pos4 < 0 ? loc.substring(pos3 + 4) : loc.substring(pos3 + 4, pos4);
    loadHelp(filename, act);
  }
}

/**
 * 创建XML对象
 */
function createDocument()
{
  var xmlDoc;

  // create a DOM object
  if (window.ActiveXObject)
  {
    try
    {
      xmlDoc = new ActiveXObject("Msxml2.DOMDocument.6.0");
    }
    catch (e)
    {
      try
      {
        xmlDoc = new ActiveXObject("Msxml2.DOMDocument.5.0");
      }
      catch (e)
      {
        try { xmlDoc = new ActiveXObject("Msxml2.DOMDocument.4.0");}
        catch (e)
        {
          try { xmlDoc = new ActiveXObject("Msxml2.DOMDocument.3.0"); }
          catch (e) { alert(e.message); }
        }
      }
    }
  }
  else
  {
    if (document.implementation && document.implementation.createDocument)
    {
      xmlDoc = document.implementation.createDocument("","doc",null);
    }
    else
    {
      alert("Create XML object is failed.");
    }
  }
  xmlDoc.async = false;

  return xmlDoc;
}

//菜单展合状态处理器
var ToggleHanlder = new Object();

Object.extend(ToggleHanlder ,{
  SourceObject : new Object(),
  CookieName   : 'Toggle_State',
  RecordState : function(name,state)
  {
    if(state == "collapse")
    {
      this.SourceObject[name] = state;
    }
    else
    {
      if(this.SourceObject[name])
      {
        delete(this.SourceObject[name]);
      }
    }
    var date = new Date();
    date.setTime(date.getTime() + 99999999);
  document.setCookie(this.CookieName, $.toJSON(this.SourceObject), date.toGMTString());
  },

  Reset :function()
  {
    var date = new Date();
    date.setTime(date.getTime() + 99999999);
    document.setCookie(this.CookieName, "{}" , date.toGMTString());
  },

  Load : function()
  {
    if (document.getCookie(this.CookieName) != null)
    {
     //this.SourceObject = t_eval();
      var items = document.getElementsByTagName('LI');
      for (var i = 0; i < items.length; i++)
      {
        if ( items[0].getAttribute("name") == "menu" && items[0].getAttribute("id") != '20_yun')
        {
          for (var k in this.SourceObject)
          {
            if ( typeof(items[i]) == "object")
            {
              if (items[i].getAttribute('key') == k)
              {
                toggleCollapseExpand(items[i], this.SourceObject[k]);
                collapse = false;
              }
            }
          }
        }
     }
    }
  var toggleImg = document.getElementById('toggleImg');
  if(toggleImg)
  {
      toggleImg.src = collapse ? 'images/menu_minus.gif' : 'images/menu_plus.gif';
      toggleImg.alt = collapse ? collapse_all : expand_all;
  }
  }
});

ToggleHanlder.CookieName += "_{$admin_id}";
//初始化菜单状态
ToggleHanlder.Load();
//Ajax.call('cloud.php?is_ajax=1&act=menu_api','', start_menu_api, 'GET', 'JSON');
function start_menu_api(result)
{
      if(result.content!==0)
      {
          document.getElementById("menu-ul").innerHTML = document.getElementById("menu-ul").innerHTML + result.content;
          var arr=[{key_data1:"lis ico_15",key_data2:"lis ico2_15"},{key_data1:"lis ico_16",key_data2:"lis ico2_16"}]
          var explode=getClass("explode");
          for(var i=0;i<explode.length;i++){
              explode[i].childNodes[1].style["display"]="none";
              var o=arr[i],obj=explode[i];
              for(var index in o){
                obj.setAttribute(index,o[index]);
               }
              explode[i].className="collapse "+explode[i].getAttribute("key_data1");
          }
      }
}
//-->
</script>

</body>
</html>