<?php
/*
 * Created on 2017年5月25日
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
class CommonTool extends BaseModel{
	
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
	}
	/**
	 * 返回结果 $res 请求者的IP
	 */
	function get_client_ip() {
	    //strcasecmp 比较两个字符，不区分大小写。返回0，>0，<0。
	    if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
	        $ip = getenv('HTTP_CLIENT_IP');
	    } elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
	        $ip = getenv('HTTP_X_FORWARDED_FOR');
	    } elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
	        $ip = getenv('REMOTE_ADDR');
	    } elseif(isset($_SERVER["HTTP_CLIENT_IP"]) && $_SERVER['HTTP_CLIENT_IP'] && strcasecmp($_SERVER['HTTP_CLIENT_IP'], 'unknown')) {
            $realip = $_SERVER["HTTP_CLIENT_IP"];
        } elseif(isset($_SERVER["HTTP_X_FORWARDED_FOR"]) && $_SERVER['HTTP_X_FORWARDED_FOR'] && strcasecmp($_SERVER['HTTP_X_FORWARDED_FOR'], 'unknown')){
	            $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
	        $ip = $_SERVER['REMOTE_ADDR'];
	    }
//	    echo getenv('HTTP_CLIENT_IP')."=-=".getenv('HTTP_X_FORWARDED_FOR')."=-=".getenv('REMOTE_ADDR');
//	    echo $_SERVER["HTTP_CLIENT_IP"]."==".$_SERVER["HTTP_X_FORWARDED_FOR"]."==".$_SERVER['REMOTE_ADDR'];
//	    echo json_encode($_SERVER);
	    $res =  preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';;
	    return $res;
	}
	
	
	/**
	 * array参数是null的，转为''
	 */
	function ArrayNullToStr($array,$default='') {
		$ret = array ();
		foreach ( $array as $k => $v ){
			if (!isset($array[$k]))
				$ret[$k] = $default;
			else
				$ret[$k] = $array[$k];
		}
		return $ret;
	}
	/**
	 * 参数是null的，转为''
	 */
	function ParamNullToStr($param,$default='') {
		return 	isset($param)?$param:$default;
	}
	
	/**
	 * 四舍五入保留两位小数
	 */
	function StrToPoint2($n){
		return sprintf("%.2f", $n);
	}
	
    /**
     * 给相对路径文件添加绝对路径
     */
    function addto_url_dir($dir,$urls,$separator=',',$rseparator=''){
    	if(empty($urls)){
    		return "";
    	}
    	$rseparator=empty($rseparator)?$separator:$rseparator;
    	$dir=empty($dir)||strlen($dir)==0?"":$dir;
    	$pics_array=explode($separator, $urls);
    	if(count($pics_array)==1){
    		$pics_array=explode(',', $urls);
    	}
    	if(count($pics_array)==1&&strstr($urls, "|") !== false){
    		$pics_array=explode("|", $urls);
    	}
		$pics="";
		foreach($pics_array as $key=>$value){
			if(strlen($pics)==0){
				$pics=$this->url_path_name($dir,$value);
			}else{
				$pics.=$rseparator.$this->url_path_name($dir,$value);
			}
		}
		return $pics;
    }
    
    /**
     * 给相对路径文件添加绝对路径,以array形式返回
     */
    function addto_url_dir_array($dir,$urls,$separator=',',$rt=1){
		$pics=array();
    	if(empty($urls)){
    		return $pics;
    	}
    	$dir=empty($dir)||strlen($dir)==0?"":$dir;
    	$pics_array=explode($separator, $urls);
    	if(count($pics_array)==1&&strstr($urls, "|") !== false){
    		$pics_array=explode("|", $urls);
    	}
		foreach($pics_array as $key=>$value){
			$pics[count($pics)]=$this->url_path_name($dir,$value);
		}
		return $rt?$pics:(count($pics)>0?$pics[0]:"");
    } 
    
    /**
     * 文件地址拼接，如本身带有路径则不再加路径
     */
    function url_path_name($dir,$value){
    	return strstr(strtolower($value),"http")!==false?$value:$dir.$value;
    }
    
    /**
     * 把全路径图片的，网络路径去掉，只余相对路径，存至数据库
     */
    function get_fullurl_name($dir,$value){
    	$value=str_replace("\\/","/",$value);
    	return str_replace($dir,"",$value);
    }
    
    /**
     * 毫秒时间戳
     */
    function getMillisecond() {
		list($t1, $t2) = explode(' ', microtime());
		return (float)sprintf('%.0f',(floatval($t1)+floatval($t2))*1000);
	}
    
    /**
     * action=123&time=123 返回 array('action'=>'123','time'=>'123');
     * @param $urlEnCode =1需要urldecode
     */
	function stringToArray($get_str,&$sign_param,$urlEnCode=0){
		$p_array=explode("&", $get_str);
		foreach($p_array as $key=>$value){
			$k_array=explode("=", $value);
			$sign_param[$k_array[0]]=$urlEnCode==1?urldecode($k_array[1]):$k_array[1];
		}
	}
    /**
     * array('action'=>'123','time'=>'123'); 返回 action=123&time=123
     * @param $urlEnCode =1需要urlencode
     */
	function ArrayToString($param,$urlEnCode=0){
		foreach($param as $key=>$value){
			if(strpos($key, 'Submit') !== false&&$value==($urlEnCode==1?urlencode('提交'):'提交')){
				continue;
			}
			if(!empty($check_str)){
				$check_str.="&";
			}
			$check_str.=$key."=".($urlEnCode==1?urlencode($value):$value);
		}
		return $check_str;
	}
	
	/**
	 * key值调整
	 * @param $array=array('action'=>'123','time'=>'1234')
	 * @param $keys=array('action'=>'key','time'=>'show')
	 * @return array('key'=>'123','show'=>'1234')
	 */
	function ChangeArrayKey($array,$keys){
		$param=$array;
		foreach ( $keys as $k => $v ) {
			$param[$v] = $array[$k];
			unset($param[$k]);
		}
		return $param;
	}
	/**
	 * key值调整
	 * @param $array=array('key'=>'123','show'=>'1234')
	 * @param $keys=array('action'=>'key','time'=>'show')
	 * @return array('action'=>'123','time'=>'1234')
	 */
	function ChangeArrayKey2($array,$keys){
		$param=$array;
		foreach ( $keys as $k => $v ) {
			$param[$k] = $array[$v];
			unset($param[$v]);
		}
		return $param;
	}
	/**
	 * 获取需要的信息，不需要的去掉
	 * @param $array=array('action'=>'123','time'=>'1234','tt'=>'1')
	 * @param $keys=array('action,time')
	 * @param $changeKeys=array('time'=>'show') key值调整 参考@method Array ChangeArrayKey
	 * @return array('action'=>'123','show'=>'1234')
	 */
	function getKeyArray($array, $keys,$changeKeys=array()) {
		$data=array();
		$keyArr = explode( ',', $keys );
		foreach ( $keyArr as $k => $v ) {
			if (isset( $array[$v] )){
				$ck=empty($changeKeys[$v])?$v:$changeKeys[$v];
				$data[$ck]=$array[$v];
			}
		}
		return $data;
	}
	
	/**
	 * 删除掉$keys 中参数
	 */
	function moveKeyArray($array, $keys) {
		$data=$array;
		$keyArr = explode( ',', $keys );
		foreach ( $keyArr as $k => $v ) {
			unset($data[$v]);
		}
		return $data;
	}
	
	/**
	 * Http get请求
	 */
	function url_get($url,$header=false,$nobody=false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_HEADER, $header);
		curl_setopt($ch, CURLOPT_NOBODY, $nobody);
		$output = curl_exec($ch); 
		$post_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$output = ($post_code == '404' ||$post_code=='0')?"":$output;	
		curl_close($ch);
		return $output;
	}
	
	/**
	 * Http post请求
	 */
	function url_post($url,$post_data,$header=false,$nobody=false,$isHttps=false){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, $header);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_NOBODY, $nobody);
	    curl_setopt($ch, CURLOPT_POST, true);//POST数据
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);//post变量
	    if ($isHttps === true) {
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,  false);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  false);
	    }
	    $output = curl_exec($ch);
		$post_code=curl_getinfo($ch, CURLINFO_HTTP_CODE);
		$output = ($post_code == '404' ||$post_code=='0')?"":$output;	
		curl_close($ch);
		return $output;
	}
    
    
   /**
    * 根据base_code，获取该字段相对前端显示值
    */
   function get_column_show_key($column,$default_key=0){
   		return "(case when isnull(".$column.") then ".$default_key." else (select F_CODE from base_code where f_id=".$column.") end)";
   }
    /**
     * jsonStr to Array
     */
	function JsonStrToArray($json_str){
        $json_str =  preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', trim($json_str));
        $json_str=str_replace ('\"','"', $json_str);
        return json_decode($json_str, true);
	}
	/**
	 * 需要转全路径字段
	 */
	function SQLFullUrl($img_dir,$column,$to_col=""){
		$con="concat(if(locate('http:',IFNULL(".$column.",''))=0 and IFNULL(".$column.",'')<>'','{$img_dir}',''),IFNULL(".$column.",''))";
		$con.=empty($to_col)?"":" as ".$to_col;
		return $con;
	}
	
	function TimeRange($time_ranges){
		global $p_basecode;
		$ranges_time="";
		$datetime=$p_basecode->get_now_datetime();
		switch($time_ranges){
			case 0;//最近一周，
			$ranges_time=date('Y-m-d H:i:s',strtotime($datetime.' -7 day'));
			break;
			case 1;//最近一个月，
			$ranges_time=date('Y-m-d H:i:s',strtotime($datetime.' -1 month'));
			break;
			case 2://最近三个月，
			$ranges_time=date('Y-m-d H:i:s',strtotime($datetime.' -3 month'));
			break;
			case 3://最近半年，
			$ranges_time=date('Y-m-d H:i:s',strtotime($datetime.' -6 month'));
			break;
			case 4://最近一年
			$ranges_time=date('Y-m-d H:i:s',strtotime($datetime.' -1 year'));
			break;
		}
		return $ranges_time;
	}
	
	/**
	 * 去掉换行符
	 */
	function removeLineBreak($content){
		return str_replace(array("\n","\r"),"",$content);
	}
	
	/**
	 * 字节转KB，MB
	 */
	function FileSizeShow($size_long){
		$s_k=1024;
		$s_m=$s_k*$s_k;
		if($size_long>$s_m){
			return round($size_long/$s_m,2).'MB';
		}else if($size_long>$s_k){
			return round($size_long/$s_k,2).'KB';
		}else{
			return $size_long;
		}
	}
	/** 
	 *      把秒数转换为时分秒的格式 
	 *      @param Int $times 时间，单位 秒 
	 *      @return String 
	 */  
	function secToTime($times){  
        $result = '00:00:00';  
        if ($times>0) {  
            $hour = floor($times/3600);  
            $minute = floor(($times-3600 * $hour)/60);  
            $second = floor((($times-3600 * $hour) - 60 * $minute) % 60);  
            $result = str_pad($hour, 2, "0", STR_PAD_LEFT).':'.str_pad( $minute,2, "0", STR_PAD_LEFT).':'.str_pad( $second,2, "0", STR_PAD_LEFT);  
        }  
        return $result;  
	} 
	/**
	 * 部分数据隐藏 密保手机，邮箱
	 */
	function PartialDataHiding($dataStr){
		$data_map=explode('@',$dataStr);
		if(count($data_map)>0){
			$pstr=$data_map[0];
			$size=strlen($pstr);
			$key_p=2;
			$hideStr="";
			if($size<4){
				$key_p=0;
			}
			if($key_p>0){
				$hideStr=substr($pstr,0,$key_p);
			}
			$endkey_p=($size-$key_p-2)>2?$size-2:$size;
			$hide_p=$key_p;
			while($hide_p<$endkey_p){
				$hideStr.="*";
				$hide_p++;
			}
			$hideStr.=substr($dataStr,$endkey_p,strlen($dataStr));
			return $hideStr;
		}
		return $data_map;
	}
	
	/**
	 * 根据IP地址获取其所在省市
	 * {"code":0,"data":{"ip":"59.49.129.247","country":"中国","area":"","region":"广州","city":"XX","county":"XX"
	 * ,"isp":"电信","country_id":"CN","area_id":"","region_id":"460000","city_id":"xx","county_id":"xx","isp_id":"100017"}}
	 * //http://ip.taobao.com/service/getIpInfo.php?ip=59.49.129.247、http://www.ip2location.com/demo/59.49.129.247、https://db-ip.com/59.49.129.247、http://api.db-ip.com/v2/free/59.49.129.247、http://ip-api.com/json/59.49.129.247、http://ip.chinaz.com/ajaxsync.aspx?at=ip&ip=59.49.129.247
	 */
	function GetIpLookup($ip = ''){
		global $s_logger;
		$s_logger->write_to_file(' try-1 ');
		$ip_m=explode('.',$ip);
		if($ip_m<4||($ip_m[0]=='192'&&$ip_m[1]=='168')
			||($ip_m[0]=='10')
			||($ip_m[0]=='172'&&$ip_m[1]>=16&&$ip_m[1]<=31)){
				return array('code'=>-1,'address'=>"local");
		}
		$address_str = $this->url_get("http://ip.taobao.com/service/getIpInfo.php?ip=" . $ip);
		$address_json = json_decode($address_str, true);
		$s_logger->write_to_file(' try-2 ');
		return $address_json;
	}
	
	/**
	 * 异或处理
	 */
	function content_encrypt($source, $key){  
        $content = '';          // 处理后的字符串  
        $index=0;
        $bytes=$this->StringtoBytes($source);
        $key_bytes=$this->StringtoBytes($key);
        $keylen=count($key_bytes);
        foreach($bytes as $ch) { 
	         $content .= chr($ch^$key_bytes[$index%$keylen]); 
	         $index++;  
	    } 
//        $keylen = strlen($key); // 密钥长度  
//  
//        for($i=0,$s=strlen($source);$i<$s;$i++){  
//            $content .= substr($source,$i, 1) ^ substr($key,$index%$keylen,1);  
//        }  
        return $content;  
    } 
    
	function StringtoBytes($string) { 
	    $bytes = array(); 
	    for($i = 0; $i < strlen($string); $i++){ 
	         $bytes[] = ord($string[$i]); 
	    } 
	    return $bytes; 
	} 
	function BytetoStr($bytes) { 
		$str = ''; 
	    foreach($bytes as $ch) { 
	         $str .= chr($ch); 
	    } 
	    return $str; 
	}  
	
	/**
	 * 将字符串中部分字符隐藏,留前后2个字符，若是邮箱，则保留前两个和‘@’之后的的字符
	 */
	function HideKeyContent($content) { 
		if(empty($content)){
			return $content;
		}
		$len=strlen($content);
		$key_p=2;
		if($len<4){
			$key_p=0;
		}
		if($key_p>0){
			$hide_str=substr($content,0,$key_p);
		}
		$end_p=$key_p; 
		if(indexof($content,'@',0)>=0){
			$end_p=indexof($content,'@',0);
		}
		$hide_p=$key_p;
	    while($hide_p<$len-$end_p) { 
	    	$hide_str.='*';
	        $hide_p++;
	    } 
	    if($hide_p>0&&$hide_p<$len){
			$hide_str.=substr($content,$len-$end_p, $len);
		}
	    return $hide_str; 
	} 
}
 
?>
