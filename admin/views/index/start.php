<!-- $Id: start.htm 17216 2011-01-19 06:03:12Z liubo $ -->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php lang('cp_home');?></title>
<meta name="robots" content="noindex, nofollow">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="styles/general.css" rel="stylesheet" type="text/css" />
<link href="styles/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery.json.js"></script>
<script type="text/javascript" src="js/global.js"></script>
<script type="text/javascript" src="js/utils.js"></script>
<script type="text/javascript" src="js/transport_jquery.js"></script>
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" src="js/respond.src.js"></script>
<script language="JavaScript">
<!--
// 这里把JS用到的所有语言都赋值到这里

//-->
</script>
</head>
<body>

<h1>

<span class="action-span1"><a href="index.php?act=main"><?php lang('cp_home');?></a> </span><span id="search_id" class="action-span1"></span>

<div style="clear:both"></div>
</h1>

<!-- directory install start -->
<ul id="cloud_list" style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">

</ul>
<script type="Text/Javascript" language="JavaScript">
<!--
//  Ajax.call('cloud.php?is_ajax=1&act=cloud_remind','', cloud_api, 'GET', 'JSON');
    function cloud_api(result)
    {
      //alert(result.content);
      if(result.content=='0')
      {
        document.getElementById("cloud_list").style.display ='none';
      }
      else
       {
         document.getElementById("cloud_list").innerHTML =result.content;
      }
    }
   function cloud_close(id)
    {
      Ajax.call('cloud.php?is_ajax=1&act=close_remind&remind_id='+id,'', cloud_api, 'GET', 'JSON');
    }
  //-->
 </script>

<ul style="padding:0; margin: 0; list-style-type:none; color: #CC0000;">

</ul>
<!-- directory install end -->
<!-- start personal message -->
<?php if (!empty($admin_msg)){ ?>
<div class="list-div" style="border: 1px solid #CC0000">
  <table cellspacing='1' cellpadding='3'>
    <tr>
      <th><?php lang('pm_title')?></th>
      <th><?php lang('pm_username')?></th>
      <th><?php lang('pm_time')?></th>
    </tr>
    <?php foreach($admin_msg  as $v){ ?>
      <tr align="center">
        <td align="left"><a href="message.php?act=view&id=<?php echo $v->message_id;?>"></a></td>
        <td><?php $v->user_name;?></td>
        <td><?php $v->send_date;?></td>
      </tr>
 <?php } ?>
  </table>
  </div>
<br />
<?php } ?>
<!-- end personal message -->

<div class="list-div">
	<div class="important">
    	<ul>
        	<li class="item01">
            	<div class="con_box">
                	<img src="uploads/images/icon01.png" />
                	<h2>今日销售总额</h2>
                    <p>
                    <?php $today['money'];?></p>
                </div>
            </li>
            <li class="item02">
            	<div class="con_box">
                	<img src="uploads/images/icon02.png" />
                	<h2>今日订单总数</h2>
                    <p><?php $today['order'];?></p>
                </div>
            </li>
            <li class="item03">
            	<div class="con_box">
                	<img src="uploads/images/icon03.png" />
                	<h2>今日注册会员</h2>
                    <p><?php $today['user'];?></p>
                </div>
            </li>
            <li class="item04">
            	<div class="con_box">
                	<img src="uploads/images/icon04.png" />
                	<h2>今日网站访问</h2>
                    <p><?php $today['visit'];?></p>
                </div>
            </li>
        </ul>
    </div>
	<div class="console_detaile">
    	<ul>
        	<li class="item01">
            	<div class="con_box clearfix">
                    <div class="img"><img src="uploads/images/iconfont-weiqueren.png" width="30" height="30" /></div>
                    <div class="text"><h2><?php lang('unconfirmed')?></h2><p><a href="order.php?act=list&composite_status=<?php echo $status['unconfirmed'];?>"><?php echo $order['unconfirmed'];?></a></p></div>
                </div>
            </li><li class="item02">
            	<div class="con_box clearfix">
                    <div class="img"><img src="uploads/images/iconfont-daizhifu.png" width="30" height="30" /></div>
                	<div class="text"><h2><?php lang('await_pay')?></h2><p><a href="order.php?act=list&composite_status=<?php echo $status['await_pay'];?>"><?php echo $order['await_pay'];?></a></p></div>
                </div>
            </li><li class="item03">
            	<div class="con_box clearfix">
                    <div class="img"><img src="uploads/images/iconfont-daifahuo.png" width="30" height="30" /></div>
                	<div class="text"><h2><?php lang('await_ship')?></h2><p><a href="order.php?act=list&composite_status=<?php echo $status['await_ship']?>"><?php echo $order['await_ship'];?></a></p></div>
                </div>
            </li><li class="item04">
            	<div class="con_box clearfix">
                    <div class="img"><img src="uploads/images/iconfont-iconsvggyiwancheng18.png" width="30" height="30" /></div>
                	<div class="text"><h2><?php lang('finished')?></h2><p><a href="order.php?act=list&composite_status=<?php echo $status['finished'];?>"><?php echo $order['finished'];?></a></p></div>
                </div>
            </li><li class="item05">
            	<div class="con_box clearfix">
                    <div class="img"><img src="uploads/images/iconfont-dengji.png" width="30" height="30" /></div>
                	<div class="text clearfix"><h2><?php lang('new_booking')?></h2><p><a href="goods_booking.php?act=list_all">
                  <?php echo $order['booking_goods'];?></a></p></div>
                </div>
            </li><li class="item06">
            	<div class="con_box">
                    <div class="img"><img src="uploads/images/iconfont-yifahuo.png" width="30" height="30" /></div>
                	<div class="text"><h2><?php lang('shipped_part')?></h2><p><a href="order.php?act=list&composite_status=<?php echo $status['shipped_part'];?>"><?php echo $order['shipped_part'];?></a></p></div>
                </div>
            </li><li class="item07">
            	<div class="con_box clearfix">
                    <div class="img"><img src="uploads/images/iconfont-iconfeature.png" width="30" height="30" /></div>
                	<div class="text"><h2><?php lang('new_reimburse')?></h2><p><a href="user_account.php?act=list&process_type=1&is_paid=0"><?php echo $order['new_repay'];?></a></p></div>
                </div>
            </li>
        </ul>
    </div>
</div>

<div class="list-div">
	<div class="order_count">
        <p style="position:absolute; margin:-1px 0 0 0;"><span class="tab_front" style="font-size:20px;"><strong><?php echo $thismonth;?>月订单统计</strong></span></p>
        <div style='height:400px;' id='order_chart_div'></div>
    </div>
</div>
<br />
<div class="list-div">
	<div class="order_count">
        <p style="position:absolute; margin:-1px 0 0 0;"><span class="tab_front" style="font-size:20px;"><strong><?php echo $thismonth;?>月销售额统计</strong></span></p>
        <div style='height:400px;' id='sales_chart_div'></div>
    </div>
</div>
<!-- </div> -->
<br />


<script type="Text/Javascript" language="JavaScript">
<!--
onload = function()
{
  /* 检查订单 */
 // startCheckOrder();
}
//  Ajax.call('index.php?is_ajax=1&act=main_api','', start_api, 'GET', 'TEXT','FLASE');
  //Ajax.call('cloud.php?is_ajax=1&act=cloud_remind','', cloud_api, 'GET', 'JSON');
   function start_api(result)
    {
      apilist = document.getElementById("lilist").innerHTML;
      document.getElementById("lilist").innerHTML =result+apilist;
      if(document.getElementById("Marquee") != null)
      {
        var Mar = document.getElementById("Marquee");
        lis = Mar.getElementsByTagName('div');
        //alert(lis.length); //显示li元素的个数
        if(lis.length>1)
        {
          api_styel();
        }
      }
    }

      function api_styel()
      {
        if(document.getElementById("Marquee") != null)
        {
            var Mar = document.getElementById("Marquee");
            if (Browser.isIE)
            {
              Mar.style.height = "52px";
            }
            else
            {
              Mar.style.height = "36px";
            }

            var child_div=Mar.getElementsByTagName("div");

        var picH = 16;//移动高度
        var scrollstep=2;//移动步幅,越大越快
        var scrolltime=30;//移动频度(毫秒)越大越慢
        var stoptime=4000;//间断时间(毫秒)
        var tmpH = 0;

        function start()
        {
          if(tmpH < picH)
          {
            tmpH += scrollstep;
            if(tmpH > picH )tmpH = picH ;
            Mar.scrollTop = tmpH;
            setTimeout(start,scrolltime);
          }
          else
          {
            tmpH = 0;
            Mar.appendChild(child_div[0]);
            Mar.scrollTop = 0;
            setTimeout(start,stoptime);
          }
        }
        setTimeout(start,stoptime);
        }
      }
//-->
</script>
{include file="pagefooter.htm"}
