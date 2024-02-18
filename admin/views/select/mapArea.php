
<div class="mapbox c">
    <div class="container_address" id="container_address_man">
      <style type="text/css">#iCenter{width:300px; height: 280px; border:1px #000 solid;margin:20px auto;}</style>
     <!-- <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.3&key=3df877a70685dac5ecb3afa375d4c305"></script> -->
     <script type="text/javascript" src="https://webapi.amap.com/maps?v=1.4.10&key=2fd6f788be3b84c6177aacfa4a050453"></script>
 <div id="iCenter"></div>
 </div>


    <div class="container_address_right">
        <a id="curCityText" href="javascript:void(0)" onClick="curCityText()"><strong id="curCity" class="curCity">北京市</strong></a>
        <input id="txtarea" type="text" size="50" style="width:195px;margin-left:5px;"placeholder="输入地址搜索" />  
        <button  id="areaSearch" style="cursor: pointer;" class="container_address_right_seek">搜索</button> 
        <div><strong>纬度：</strong><br/><input name="txtlatitude" type="text" id="txtlatitude" value="<?php echo $latitude; ?>" /> </div>
        <div><strong>经度：</strong><br/><input name="txtLongitude" type="text" id="txtLongitude" value="<?php echo $longitude; ?>" /> </div>
        <input name="txtprovince" type="hidden" id="txtprovince" value="<?php echo $province; ?>" />
		<input name="txtcity" type="hidden" id="txtcity" value="<?php echo $city; ?>" />
		<input name="txtdistrict" type="hidden" id="txtdistrict" value="<?php echo $district; ?>" />
		<input name="txttownship" type="hidden" id="txttownship" value="<?php echo $township; ?>" />
		<input name="txtstreet" type="hidden" id="txtstreet" value="<?php echo $street; ?>" />
        <div><strong>标注点所在区域：</strong><br/><input name="txtAreaCode" value="<?php echo $address; ?>" type="text" id="txtAreaCode" style="height:60px;" /> </div>
        <!--div class="sel_container"> 
          <strong id="curCity" class="curCity">北京市</strong> 
          <button id="curCityText" href="javascript:void(0)" class="container_address_right_change">更换成市</button> 
        </div--> 
        <div class="map_popup" id="cityList" style="display: none;"> 
            <div class="popup_main"> 
                <div class="popup_main_title"> 城市列表</div> 
                <div class="cityList" id="citylist_container"></div>
                <button id="popup_close"> </button> 
            </div> 
        </div> 
    </div>
</div>


 <script type="text/javascript">
 var country='';
var province='';
var city='';
var district='';
var township='';
var street='';
    var mapObj = new AMap.Map('container_address_man');
     mapObj.plugin('AMap.Geolocation', function () {
         geolocation = new AMap.Geolocation({
             enableHighAccuracy: true, // 是否使用高精度定位，默认:true
             timeout: 10000,           // 超过10秒后停止定位，默认：无穷大
             maximumAge: 0,            // 定位结果缓存0毫秒，默认：0
             convert: true,            // 自动偏移坐标，偏移后的坐标为高德坐标，默认：true
             showButton: true,         // 显示定位按钮，默认：true
            buttonPosition: 'LB',     // 定位按钮停靠位置，默认：'LB'，左下角
             buttonOffset: new AMap.Pixel(10, 20), // 定位按钮与设置的停靠位置的偏移量，默认：Pixel(10, 20)
             showMarker: true,         // 定位成功后在定位到的位置显示点标记，默认：true
             // showCircle: true,         // 定位成功后用圆圈表示定位精度范围，默认：true
             panToLocation: true,      // 定位成功后将定位到的位置作为地图中心点，默认：true
             zoomToAccuracy:true       // 定位成功后调整地图视野范围使定位位置及精度范围视野内可见，默认：false
         });
         mapObj.addControl(geolocation);
         geolocation.getCurrentPosition();
         AMap.event.addListener(geolocation, 'complete', onComplete); // 返回定位信息
         AMap.event.addListener(geolocation, 'error', onError);       // 返回定位出错信息
     });
     
 mapObj.on("click",addAMapMarker)
function addAMapMarker(point,type){
    var lng = "";
    var lat = "";
    if(type==1){
        lng = point.getLng();
        lat = point.getLat();
    }else{
        lng = point.lnglat.getLng();
        lat = point.lnglat.getLat();
    }
    var lnglatXY = [lng, lat];
    mapObj.clearMap();
    var marker = new AMap.Marker({
        icon:  new AMap.Icon({
            image: "http://webapi.amap.com/theme/v1.3/markers/n/loc.png"
        }),
        position: lnglatXY,
        map:mapObj
    });
    AMap.plugin('AMap.Geocoder',function() {
        geocoder = new AMap.Geocoder({});
        geocoder.getAddress(lnglatXY, function (status, rs) {
            if (status === 'complete' && rs.info === 'OK') {
                set_address(rs.regeocode.formattedAddress,lng,lat);
                var addComp=rs.regeocode.addressComponent;
                province=addComp.province;
                city=addComp.city;
                district=addComp.district;
				township=addComp.township;
                street=addComp.street;
                document.getElementById("curCity").innerHTML=province;
            } else {
                
            }
        });
    })
}
  function onComplete(obj){
	  //consloe.log(obj.position);
      set_address(obj.formattedAddress,obj.position.lng,obj.position.lat);
      var loc=obj.addressComponent;
      province=loc.province;
      city=loc.city;
      district=loc.district;
      township=loc.township;
      street=loc.street;
    }
 
  function onError(obj) {
     }
  function set_address(Address,lng,lat) {
        document.getElementById("txtLongitude").value=lng ;
        document.getElementById("txtlatitude").value=lat ;
        document.getElementById("txtAreaCode").value=Address;
        /*
        document.getElementById("txtprovince").value=loc.province;
        document.getElementById("txtcity").value=loc.city ;
        document.getElementById("txtdistrict").value=loc.district;
        document.getElementById("txttownship").value=loc.township ;
        document.getElementById("txtstreet").value=loc.street;
        province=loc.province;
        city=loc.city;
        district=loc.district;
        township=loc.township;
        street=loc.street;
        */
		
     }
   
   //搜索 
document.getElementById("areaSearch").onclick = function () { 
    // 创建地址解析器实例 
 AMap.plugin("AMap.PlaceSearch", function(e) {
        var placeSearch = new AMap.PlaceSearch({ city: '全国' });
        placeSearch.search($("#txtarea").val(), function(status, rs) {
             //console.log(rs.poiList);
            if (status === 'complete' && rs.info === 'OK') {
                set_address(rs.poiList.pois[0].address,rs.poiList.pois[0].location.lng, rs.poiList.pois[0].location.lat);
                addAMapMarker(new AMap.LngLat(rs.poiList.pois[0].location.lng, rs.poiList.pois[0].location.lat),1);
                mapObj.setFitView();
				
				var slnglatXY = [rs.poiList.pois[0].location.lng, rs.poiList.pois[0].location.lat];
				
				AMap.plugin('AMap.Geocoder',function() {
					geocoder = new AMap.Geocoder({});
					geocoder.getAddress(slnglatXY, function (status, result) {
						if (status === 'complete' && result.info === 'OK') {
							set_address(result.regeocode.formattedAddress,lng,lat);
							var addComp=result.regeocode.addressComponent;
							province=addComp.province;
							city=addComp.city;
							district=addComp.district;
							township=addComp.township;
							street=addComp.street;
							document.getElementById("curCity").innerHTML=province;
						} else {
							
						}
					});
				})
				
				
            } else {
                $.MsgBox.Alert("温馨提示","搜索不到结果");
            }
        });
    });
} 

 </script>

<!--<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script> //-百度地图的文件 -->
<!--<script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script> 城市选择的-->

<style>
    .mapbox{padding:10px; width:887px;}
    .container_address{width: 480px; height: 340px; border: 1px solid gray; float: left;z-index:200;}
    .container_address_right{float:left;margin-left:10px;width:350px;height:340px;}
    .container_address_right input{width:340px;height:30px;line-height:30px;border:1px solid #ccc;text-indent:5px;border-radius:2px;}
    .curCity{border-radius:2px;border:1px solid #ccc;width:80px;height:33px;line-height:33px;top:5px;float:left;text-indent:5px;}
    .container_address_right_seek{width:60px;height:35px;line-height:35px;border:1px solid #ccc;float:right;}
    .container_address_right_change{width:80px;float:left;margin-left:5px;height:30px;}
    .container_address_right div{margin:5px;}
    .container_address_right div strong{height:30px;line-height:30px;}
    .map_popup{background:#FFF;margin-top:50px;border:1px solid #ccc;float:left;COLOR:#000;height:300px;overflow-x:hidden;overflow-y:scroll;width:340px;}
    .popup_main_title{width:100%;font-weight:bold;font-size:16px/20px 黑体;border-bottom:1px solid #f60;line-height:40px;}

</style>
<script  language="javascript" >

/*
function geocodeSearch(pt) { 
	var myGeo = new BMap.Geocoder(); 
	myGeo.getLocation(pt, function (rs) { 
		var addComp = rs.addressComponents; 
		document.getElementById("txtAreaCode").value = addComp.province + "," + addComp.city + "," + addComp.district+ "," + addComp.street + ", " + addComp.streetNumber; 
		country=addComp.country;
		province=addComp.province;
		city=addComp.city;
		district=addComp.district;
		township=addComp.township;
		street=addComp.street;
	}); 
}*/ 

$(function(){
    api = $.dialog.open.api;
    if (!api) return;

    // 操作对话框
    api.button(
        {
            name: '确认',
            callback: function () {
                $.dialog.data('maparea_address', $('#txtAreaCode').val());
                $.dialog.data('maparea_lng', $('#txtLongitude').val());
                $.dialog.data('maparea_lat', $('#txtlatitude').val());
                $.dialog.data('txtarea', $('#txtarea').val());
				$.dialog.data('country', country);
				$.dialog.data('province', province);
				$.dialog.data('city', city);
				$.dialog.data('district', district);
				$.dialog.data('township', township);
				$.dialog.data('street', street);
                //$.dialog.close();
                //return false;
            },
            focus: true
        },
        {
            name: '取消'
        }
    );
//    $('.box-table tbody tr').on('click', function(){
//        var $this=$(this);
//        $.dialog.data('service_place_id', $this.attr('data-id'));
//        $.dialog.data('service_place_title', $this.attr('data-title'));
//        $.dialog.close();
//    });
});
 
    
</script>

