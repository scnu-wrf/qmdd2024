<?php

/**
 * 字符串截取，支持中文和其他编码
 * @static
 * @access public
 * @param string $str 需要转换的字符串
 * @param string $start 开始位置
 * @param string $length 截取长度
 * @param string $charset 编码格式
 * @param string $suffix 截断显示字符
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = true) {
    $str =  Basefun::model()->clear_html(str_replace('&nbsp;', '', strip_tags($str)));
    $isSuffix= (mb_strlen($str) > $length) ? true : false;
 
    if (function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif (function_exists('iconv_substr')) {
        $slice = iconv_substr($str, $start, $length, $charset);
        if (false === $slice) {$slice = '';}
    } else {
        $re['utf-8'] = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk'] = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5'] = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("", array_slice($match[0], $start, $length));
    }
    if ($str == $slice) {
        return $slice;
    } else {
        return $suffix && $isSuffix ? $slice . '…' : $slice;
    }
}


function GetAppName(){
    $AppName = SiteConfig::model()->find('1');
    if(isset($AppName)){
        return $AppName['C_title'];
    }
    else return "暂无标题";
}

function getParam($var,$default='0'){
    return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
}
function DecodeAsk($var,$default='0'){
    return isset($_REQUEST[$var])?$_REQUEST[$var]:$default;
}

function getUploadPath($pid=124){
    return BasePath::model()->getPath($pid);
}

function delUploadPath($str){
    return BasePath::model()->reMovePath($str);
}
function addUploadPath($str){
    return BasePath::model()->addPath($str);
}

//参考三立大屏新增
//进入编辑 就传入id
function show_title($_thisController,$subtile='',$flag=1,$id=0){    //flag判断是否是额外的目录，0是，1不是
    $style1='';
    $color='color:#368EE0';
    if(empty($subtile)){
        $url=getf_url();
        Yii::app()->session['url']=$url;
        $style1=$color;
    }else if(!$flag){
        $url=getf_url($flag);
        Yii::app()->session['url']=$url;
    }
    else
    {
        $url=Yii::app()->session['url'];
    }

    $meun=Menu::model()->find("f_url='$url'");
    if(empty($meun)) return '';
    $group=$meun->f_group;
    $name=$meun->f_name;

    $str= '<div class="box-title c">'.
        '<h2><i class="fa fa-table"></i>'. ' 当前界面：'.$group.' 》'.
        '<span style="'.$style1.'">'.  $name.'</span>';

    if(!empty($subtile)){
        $str.=' 》'.'<span style="'.$color.'">'.$subtile.'</span>';
        if($flag)
            $str.='<span class="back"><a class="btn" href="javascript:;" onclick="history.back();"> <class="fa fa-reply"></i>'.
                '返回'. '</a></span>';
    }

    if(!empty($id)){
        $str.= add_title_button($_thisController,$name,$id);
    }

    $str.='</h2>' .'</div>';

    return $str;
}
//参考三立大屏新增
function getf_url($flag=1){
    $surl = Yii::app()->session['url'];
    if(!( !empty($surl) && strstr(get_url(),$surl.'&'))){//
      $surl= lcfirst(urldecode(get_url_explode()));
    }
    return $surl;
}
//参考三立大屏新增
function get_url(){//完整参数url
    return lcfirst(urldecode(substr(Yii::app()->getRequest()->queryString,2)));
}
//参考三立大屏新增
function get_url_explode(){
    return explode("&page",substr(Yii::app()->getRequest()->queryString,2))[0];
}

function substr_hz($str,$start,$len=0){
    if ($len==0){
        $len=strlen_hz($str)-$start;
    }
    return mb_substr($str,$start,$len,'UTF-8');
}
function subsstr_hz($str,$start,$len=0){
   return substr_hz($str,$start,$len);
}

function strlen_hz($str){
 return mb_strlen($str,'UTF-8');
}

function clear_html($str){
 return  str_replace('&nbsp;', '', strip_tags($str));
}

function crEnter(){
 return chr(13).chr(10);
}
//将内容进行UNICODE编码
function unicode_encode($name)
{
  $name = iconv('UTF-8', 'UCS-2', $name);
  $len = strlen($name);
  $str = '';
  for ($i = 0; $i < $len - 1; $i = $i + 2)
  {
    $c = $name[$i];
    $c2 = $name[$i + 1];
    if (ord($c) > 0)
    {  // 两个字节的文字
      $c2= '\u'.base_convert(ord($c), 10, 16).base_convert(ord($c2),10,16);
    }
    $str .= $c2;
  }
  return $str;
}

function gf_implode($separator='|',$parray){
    $rs="";
    if(!empty($parray)){
        $rs=implode($separator,$parray);
    }
   return $rs;
}

function unicode_decode($name)
{
  // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
  $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
  preg_match_all($pattern, $name, $matches);
  if (!empty($matches))
  {
    $name = '';
    for ($j = 0; $j < count($matches[0]); $j++)
    {
      $str = $matches[0][$j];
      if (strpos($str, '\\u') === 0)
      {
        $code = base_convert(substr($str, 2, 2), 16, 10);
        $code2 = base_convert(substr($str, 4), 16, 10);
        $c = chr($code).chr($code2);
        $str= iconv('UCS-2', 'UTF-8', $c);
      }
      $name .= $str;
    }
  }
  return $name;
}

 function   get_gb_to_utf8($value){
  $value_1= $value;
  $value_2   =   @iconv( "gb2312", "utf-8//IGNORE",$value_1);
  $value_3   =   @iconv( "utf-8", "gb2312//IGNORE",$value_2);
  return (strlen($value_1)==strlen($value_3)) ? $value_2 : $value_1;
 }

//使用@抵制错误，如果转换字符串中，某一个字符在目标字符集里没有对应字符，那么，这个字符之后的部分就被忽略掉了；即结果字符串内容不完整，此时要使用//IGNORE
 function   get_utf8_to_gb($value){
  $value_1= $value;
  $value_2   =   @iconv( "utf-8", "gb2312//IGNORE",$value_1);
  $value_3   =   @iconv( "gb2312", "utf-8//IGNORE",$value_2);
   return (strlen($value_1)   ==   strlen($value_3)) ?  $value_2 : $value_1;
 }


/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @return mixed
 */
function show_status($status,$msg='',$redirect='',$msg2='', $redirect2 = '')
{
     if ($status) { ajax_status(1, $msg, $redirect);}
     else {ajax_status(0, $msg2, $redirect2);}
 }

function ajax_status($status = 0, $msg = '', $redirect = '') {
  ajax_exit(array('status'=>$status,'msg'=>$msg,'redirect' => $redirect));
}

function ajax_exit($arr) {
    header('Content-type:application/json;charset=utf-8');
    echo array_str($arr);
    exit;
}

function show_JsonData($data,$dateItem) {
    BaseLib::model()->echoAjxCode($data,$dateItem);
}

function show_json_encode($data) {
   echo json_encode($data);
}

function msgtoArray($msg,$icon){
 return array('msg'=>$msg,'icon'=>$icon);
}

function saveState($s1){
   $res=($s1) ? msgtoArray('提交成功',"success") :msgtoArray('保存失败',"error");
   return  json_encode($res);
}

function show_ajax($s1,$msg){
   return  ajax_exit(array('status' => $s1, 'msg' => $msg));
}

function array_str($arr) {
    return CJSON::encode($arr);
}
/**
 * 设置cookie
 * @param string $name 名称
 * @param mixed $value 值
 * @param integer $day 有效天数
 * @return string
 */
function set_cookie($name, $value, $day = 1) {
    $cookie = new CHttpCookie($name, $value);
    $cookie->expire = time() + 60 * 60 * 24 * $day;
    Yii::app()->request->cookies[$name] = $cookie;
}

/**
 * 获取cookie
 * @param string $name 名称
 * @return mixed
 */
function get_cookie($name) {
    $cookie = Yii::app()->request->getCookies();
    return (null === $cookie[$name]) ? null : $cookie[$name]->value;
}

function get_user($name) {
    $cookie = Yii::app()->request->getCookies();
    return (null === $cookie[$name]) ? '0' : $cookie[$name]->value;
}

function get_userid($id) {
    return ($id==0) ? get_user('userId') : $id;
}

/**
 * 删除cookie
 * @param string $name 名称
 */
function del_cookie($name) {
    $cookie = Yii::app()->request->getCookies();
    unset($cookie[$name]);
}

function timeToFilename(){
 return getTime();
}
/**
 * 把返回的数据集转换成编号
 * @access public
 * @param array $table 表或对象 
 * @param $account账号，$sfno 前置，$slen长度，$pcode 默认值
 * @return array
 */
function getAutoNo($table,$account='',$sfno='No',$slen=8,$pcode=''){
  if(empty($pcode)){
    $pcode=BaseNo::model()->getAutoNo($table,$account,$sfno,$slen);
  }
  return $pcode;
}

function getAboutMe($tmp,$fielddname,$tablename=''){
  return Basefun::model()->getAboutMe($tmp,$fielddname);
}

/**
 * 把返回的数据集转换成Tree
 * @access public
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @return array
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if (is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] = & $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = & $list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = & $refer[$parentId];
                    $parent[$child][] = & $list[$key];
                }
            }
        }
    }
    return $tree;
}

/**
 * 快速文件数据读取和保存 针对简单类型数据 字符串、数组
 * @param string $name 缓存名称
 * @param mixed $value 缓存值
 * @param string $path 缓存路径
 * @return mixed
 */
function file_cache($name, $value = '', $path = ROOT_PATH) {
    static $_cache = array();
    $filename = $path . '/' . $name . '.php';
    if ('' !== $value) {
        if (is_null($value)) {
            // 删除缓存
            return false !== strpos($name, '*') ? array_map("unlink", glob($filename)) : unlink($filename);
        } else {
            // 缓存数据
            $dir = dirname($filename);
            // 目录不存在则创建
            if (!is_dir($dir))
                mkdir($dir, 0755, true);
            $_cache[$name] = $value;
            return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
        }
    }
    if (isset($_cache[$name]))
        return $_cache[$name];
    // 获取缓存数据
    $value = false;
    if (is_file($filename)) {
        $value = include $filename;
        $_cache[$name] = $value;
    }
    return $value;
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dump($var, $echo = true, $label = null, $strict = true) {
    $label = ($label === null) ? '' : rtrim($label) . ' ';
        if (!$strict) {
            $output = $label . print_r($var, true);
            if (ini_get('html_errors')) {
                $output = print_r($var, true);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        } else {
            ob_start();
            var_dump($var);
            $output = ob_get_clean();
            if (!extension_loaded('xdebug')) {
                $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
        if ($echo) {
            echo($output);
            $output=null;
        }
        return $output;
}

function mk_dir($path) {
    BasePath::model()->mk_dir($path);
}

function arrayTostr($pstr,$bstr=',') {
    return (is_array($pstr) ) ? implode($bstr,$pstr) : $pstr;
}

function strToArray($pstr,$bstr=',') {
    return (is_array($pstr)) ? $pstr : explode($bstr,$pstr);
}

function toCWeek($weekday){
  return Basefun::model()->toCWeek($weekday);
}

function encrypt($str, $salt = '') {
    return md5($str . '!@#$%' . $salt . '^&*()');
}


// discuz 加密解密函数
function authcode($string, $operation = 'DECODE', $key = 'wzg', $expiry = 0) {
     return Aescode::model()->authcode($string, $operation, $key, $expiry);
}

function urlauthcode($string, $operation = 'DECODE', $key = 'zxs6477', $expiry = 0) {
   return Aescode::model()-> urlauthcode($string, $operation, $key , $expiry);
}

function https_request($url) {
    $data=null;
    if (function_exists('curl_init')) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $data = curl_exec($curl);
        if (curl_errno($curl)) {
            return null;
        }
        curl_close($curl);
    } else {
        if (file_exists($url)) {
           $data = file_get_contents($url);
        }
    }
    return $data;

}

function getTime(){
     $time = explode ( " ", microtime () );
     $time = "".($time [0] * 1000);
     $time2 = explode ( ".", $time );
     $time = $time2 [0];
     $s1=dateToymds();
     return $s1.$time;//2010-08-29 11:25:26
}

function checkTime($ts,$exit=1){
    $data=array('ts'=>$ts);
    $ts=substr($ts,0,10)+1;
    $t=time();$r=0;
    $max_time=86400;//24小时
    if(($t-$ts>$max_time)||($t-$ts<-$max_time)){//1分钟内有效，超过表示请求超时
        if($exit==1){
            $data['tt']=$t;
            $data['ts1']=$ts;
            set_error($data,102,"请求超时",$exit);
        }
       $r= 1;
    }
    return $r;
 }
function strTodate($str){
    $s1=substr($str,0,4).'-'.substr($str,4,2).'-'.substr($str,6,2).' ';
    $s1.=substr($str,8,2).':'.substr($str,10,2).':'.substr($str,12,2);
 return $s1;
//2010-08-29 11:25:26
}


function get_date(){
    return date('Y-m-d H:i:s',time());
}

function dateToymds(){
    $s1=str_replace('-','',get_date());
    $s1=str_replace(':','',$s1);
    $s1=str_replace(' ','',$s1);
    return $s1;
}

function nullDateToStr($pdate){
    if(empty($pdate)||$pdate=='0000-00-00 00:00:00'){
     $pdate='';
    }
    return $pdate;
}

function get_file_name($key=""){
     return get_short_path().getTime();
}
//保存文件


function getimages($str) {
    preg_match_all('/<img[^>]*src\s*=\s*([\'"]?)([^\'" >]*)\1/isu', $str, $src);
    return $src[2];
}

function round_dp($num, $dp) {
    $sh = pow(10, $dp);
    return (round($num * $sh) / $sh);
}

//size()  统计文件大小
function size($byte) {
    if ($byte < 1024) {
        $unit = "B";
    } else if ($byte < 1048576) {
        $byte = round_dp($byte / 1024, 2);
        $unit = "KB";
    } else if ($byte < 1073741824) {
        $byte = round_dp($byte / 1048576, 2);
        $unit = "MB";
    } else {
        $byte = round_dp($byte / 1073741824, 2);
        $unit = "GB";
    }

    $byte .= $unit;
    return $byte;
}

function pass_md5($ec_salt,$pass){
 return empty( $ec_salt ) ? md5( $pass ) : md5( md5( $pass ) . $ec_salt );}


//$reread需要重新读，0不要，1需要
function get_role_access($pmodelname,$reread=1) {
    $reread=1;
    $role_tmp=get_session('role_access');
    if ((empty($role_tmp))||(!isset($role_tmp[$pmodelname]))||($reread)){
       $role_tmp=Menu::model()->get_role_power(get_session('level'),$pmodelname);
       Yii::app()->session['role_access']=$role_tmp;
    }
    return $role_tmp;
 }

//show_shenhe_box('保存|提交审核|审核通过|审核不通过')。
function get_action_name(&$r1,&$r2)
{   $r1=Yii::app()->controller->id;
    $r2='index';
    $s1=get_cookie('_currentUrl_').'&';
    if(indexof($s1,'%2F')>0){
       $s1= str_replace('%2F','/',$s1);
    }
    $i1=indexof($s1,'?r=');
    $i2=indexof($s1,'&');

    if(($i1>0)&&($i2>0)){
       $s1=substr($s1,$i1+3,$i2-3);
       $i1=indexof($s1,'/');
       $r1=substr($s1,0,$i1);
       $s1=substr($s1,$i1+1);
       $i1=indexof($s1,'&');
       $r2=substr($s1,0,$i1);
    }
    $r1=strtolower($r1);
 }

function show_shenhe_box($she_box_name) {
    $mname= ""; $ac= "";
    $s1="";
    foreach ($she_box_name as $bname => $btitle) {
        $oname=$bname;
        $oname1=$bname;
        if($oname=='tongguo'){$oname1='shenhe';}
        if($oname=='butongguo'){$oname1='shenhe';}
        if($oname=='tuihui'){$oname1='shenhe';}//退回修改
        if($oname=='quxiao'){$oname1='shenhe';}  // quxiao:取消审核
        if($oname=='chexiao'){$oname1='revoke';}  // 1、revoke=撤销提交  2、next=下一步
        if(($oname=='baocun') || ($oname=='shenhe') || ($oname=='next')){$oname='update';$oname1='create';}
       // if((isset($role_tmp[$mname][$ac][$oname]))||(isset($role_tmp[$mname][$ac][$oname1]))){
          $s1.='<button id="'.$bname.'" onclick="submitType='."'".$bname."'".'"';
          $s1.=' class="btn btn-blue" type="submit"> '.$btitle.'</button>&nbsp;';
       // }
    }
    return $s1;
 }

function getShenheState($shenhe,$estate,$state) {
    $rs=array('edit'=>$estate,'state'=>$state);
    if ($shenhe == 'shenhe') {
      $rs=array('edit'=>'371','state'=>'371');
     } 
    if ($shenhe == 'baocun') { } 
    if ($shenhe == 'tongguo') {
          $rs=array('edit'=>'2','state'=>'2');
     } 
    if ($shenhe == 'butongguo') {
        $rs=array('edit'=>'373','state'=>'373');
    } 
    return $rs;
 }



// $is_s2为自定义属性功能
function show_command($command,$url="",$title="",$style='',$is_s2='') {
    if($title==""){
        $title=$command=='修改'?'编辑':$command;
    }
    $s1= "";$s2= "delete";
    $mname= ""; $ac= "";
    //get_action_name($mname,$ac);
    $role_tmp= '';//get_role_access($mname);
    if ($command == '添加') {
     $s1='<a class="btn" href="'.$url.'" '.$style.'>';
     $s1.='<i class="fa fa-plus"></i>'.$title.'</a>';
     $s2='create';
    } else if ($command == '修改') {
        $s1='<a class="btn" href="'.$url.'" ';
        $s1.=' title="编辑" '.$style.'>'.$title.'</a>';
        $s2='update';
    } else if ($command == '批删除') {
        $s1='<a style="display:none;" id="j-delete" class="btn"';
        $s1.=' href="javascript:;" onclick="';
        $s1.="we.dele(we.checkval('.check-item input:checked'), deleteUrl)";
        $s1.=';"><i class="fa fa-trash-o"></i>'.$title.'</a>';
    } else if ($command == '删除') {
        $s1='<a class="btn" href="javascript:;" onclick="we.dele(';
        $s1.=$url.', deleteUrl);" title="删除">';
        $s1.=empty($title) ? '<i class="fa fa-trash-o"></i></a>' : $title.'</a>';
    }
    else if ($command == '审核') {
        $s1='<a class="btn" href="'.$url.'" ';
        $s1.=' title="审核">'.$title.'</a>';
        $s2='shenhe';
    }
    else if ($command == '详情') {
        $s1='<a class="btn" href="'.$url.'" ';
        $s1.=' title="详情">'.$title.'</a>';
        $s2='update';
    }
    else{
        $s1='<a class="btn" href="'.$url.'" '.$style.' title="'.$title.'">'.$title.'</a>';
        $s2=$is_s2;
    }
    //if(!isset($role_tmp[$mname][$ac][$s2])){
       // put_msg(get_session('level').'***'.json_encode($role_tmp));
       // $s1="";
    //}
    // if(empty($s1)){
    //     $name = get_session('admin_name');
    //     $s1 = '<span class="red">'.$name.'('.$s2.')权限丢失</span>';
    // }
    return $s1;
 }



  function getUrlType(&$s1,&$s2,$url,$cmd,$title,$style,$cmd){
    $s1='<a class="btn" href="'.$url.'" '.$style.' title="'.$title.'">'.$title.'</a>';
    $s2=$cmd;
  }
  function get_form_list(){
    set_session('html_edit',0);
    set_session('edit_name',array());
    return array(
            'id' => 'active-form',
            'enableClientValidation' => true,
            'clientOptions' => array(
                'validateOnSubmit' => true,
                'afterValidate' => 'js:function(form,data,hasError){
                    if(!hasError){
                        we.overlay("show");
                        $.ajax({
                            type:"post",
                            url:form.attr("action"),
                            data:form.serialize()+"&submitType="+submitType,
                            dataType:"json",
                            success:function(d){
                                if(d.status==1){
                                    we.success(d.msg, d.redirect);
                                }else{
                                    we.error(d.msg, d.redirect);
                                }
                            }
                        });
                    }else{
                        var html="";
                        var items = [];
                        for(item in data){
                            items.push(item);
                            html+="<p>"+data[item][0]+"</p>";
                        }
                        we.msg("minus", html);
                        var $item = $("#"+items[0]);
                        $item.focus();
                        $(window).scrollTop($item.offset().top-10);
                    }
                }',
            ),
        );
  }

//检查$_POST变量是否存在，不存在，设置后面的值
 function check_post($pvarname,$pdefault=0) {
   if(empty($_POST[$pvarname])){
        $_POST[$pvarname]=$pdefault;
    }
  }

//检查$_REQUEST变量是否存在，不存在，设置后面的值
 function check_request($pvarname,$pdefault=0) {
   if(empty($_REQUEST[$pvarname])){
        $_REQUEST[$pvarname]=$pdefault;
    }
  }

function get_form_login(){
    return array(
        'id' => 'active-form',
        'enableClientValidation' => true,
        'clientOptions' => array( 'validateOnSubmit' => true,
            'afterValidate' => 'js:function(form,data,hasError){
            }',
        ),
    );

}
//$afieldstr 是一个这样的格式 WXID:FIELID
//参数说明
//对象表，$cooperation
//$afieldstr，属性转换映射表A:B,其中A是表属性，B是请教要求的属性
//$def_array 是原来有的对象，昨晚合并数组使用
function toIoArray($cooperation,$afieldstr,$def_array=array()){
  return BaseLib::model()->toArray($cooperation,$afieldstr,$def_array);
}

function recToArray($tmp,$afieldstr){
  return BaseLib::model()->recToArray($tmp,$afieldstr);
}
function file_in($string){
    return is_file($string);
}

function toArrayNoname($cooperation,$afieldstr)
{
    $arr=array();
    if(is_array($cooperation))
        foreach ($cooperation as $v) {
        $arr[]=$v[$afieldstr];
    }
    return $arr;
}
/*
   生成JAVA 的 echo '{data:'.json_encode(toArray($cooperation,'f_id,F_NAME,fater_id')).'}';
   //$cooperation,YII查询的表数据
//$$afieldstr 要转换的属性名称，用“，”分割
 */

function toJava_json($cooperation,$afieldstr)
{
    return '{data:'.json_encode(toIoArray($cooperation,$afieldstr)).'}';
}

function getUserIp($user_ip=''){
    $ip=Yii::app()->request->getUserHostAddress();
    $cip = (!empty($user_ip)) ? $user_ip : $ip;
    return empty($cip)? "127.0.0.1" : $cip;
}

function getUser($user=''){
    return  User::model()->getUser($user);
}
function getStsnum($stsnum=''){
    return  User::model()->getStsnum($stsnum);
}

//把YII查询的数据转换成数组
//$cooperation,YII查询的表数据
//$$afieldstr 要转换的属性名称，用“，”分割
function toArray($cooperation,$afieldstr)
{
    return toIoArray($cooperation,$afieldstr);
    $arr = array();$r=0;
    $afields=explode(',',$afieldstr);
    foreach ($cooperation as $v) {
         foreach($afields as $v1){
             $vs=$v[$v1];
             if(empty($vs)){ $vs="";}
             $arr[$r][$v1] = $vs;
            }
            $r=$r+1;
    }
    return $arr;
}


function put_msg($pmsg,$parr=0){
  put_file($pmsg);
  put_file(chr(13).chr(10));
    //Test::model()->put_msg($pmsg);
}

function put_errorb($str){
  put_msg($str);
} 

   function put_error($str)
    {
       put_file($str);
    } 
  function put_file($str,$fname='error_log.txt',$pnew='0')
    {
      if (is_array($str))
         $str=json_encode($str,JSON_UNESCAPED_UNICODE);
        $wr=($pnew=='0') ?'a' :'w';
        if(!is_string($str)) $str='no string';
        $fp = fopen($fname,$wr);
        fputs($fp,$str);
        fclose($fp);
    } 

   function setTemplateFile($model,$tpl){
     //put_msg('show file==');
     //$dir=$model->getTableName();
    // put_msg($dir);
    // setGetValue("html_dir",$dir);
     setGetValue("html_file",$tpl);
  }


  function put_html($thisv,$str,$model,$pnew='0'){
    putStrTohtml($str);
  }
  
  function putStrTohtml($str){
    $ms=setGetValue("html_dir");
    $path=ROOT_PATH.'/template/'.$ms;
    BasePath::model()->mk_dir($path);
    $fname=$path.'/'.setGetValue("html_file").'.html';
    put_file($str,$fname,'1');
  }
  
function to_imgs($str) {
   $ds=array();
   $sn=0;
   if(!empty($str)){
      $ds=explode(',',$str);
      $sn=count($ds);
   }
   for($i=$sn;$i<10;$i++){
     $ds[$i]='';
    }
    return $ds;
 }

function to_scroll_imgs($ds,$picurl='PicUrl') {
    $arr=array();
    for($i=0;$i<9;$i++){
        if($ds[$i]){
           $arr[]=array($picurl=>$ds[$i]);
        }
    }
    return $arr;
}

function getWxData($dName) {
    $arr=array();
    if(isset($_GET[$dName])) {
       $DB_msg =$_GET[$dName];
       $arr=json_decode($DB_msg,true);
    }
    return $arr;
}

 function getParameter($def_value='') {
    $request = file_get_contents('php://input');
    $rs=json_decode($request,true);
    $def_value=str_replace("=",":",$def_value);
    $arr1 =explode(',',$def_value);
    if(is_array($arr1))
        foreach ($arr1 as $v) {
          $ds=explode(':',$v);
          if(!isset($rs[$ds[0]]))  {$rs[$ds[0]]='';}
          if(isset($ds[1])){
            if(empty($rs[$ds[0]]))
             $rs[$ds[0]]=$ds[1];
          }
     }
    if(is_array($_POST))
        foreach ($_POST as $k=>$v) {
            $rs[$k]=$v;
     }

     $openid = '';
     if(!empty($rs['openid'])) $openid = $rs['openid'];
     $rs['openid']=$openid;
     if(!isset($rs['userId'])) $rs['userId']='';
     if(empty($rs['userId']) &&($openid)){
       $rs['userId']=Users::model()->readValue("wxappid='".$openid."'",'userId');
     }
    return $rs;
}

//查询地区使用，参数省、市、区码，地区树结构码，排序，附加查询条件，参考otherCondition
function areaCondition($province,$city,$area,$acode,$aorder = '',$okey=''){
   $area=(is_numeric($area)) ? $area :'';
   $code=(!empty($area)) ? $area : ( (!empty($city)) ? $city : $province);
   $code=(empty($code)) ? '44' : $code;
   $criteria = new CDbCriteria;
   $criteria->condition=$acode." like'".$code."%'";//所属教育行政部门
   $criteria->condition.=(empty($okey)) ? '' : otherCondition($okey);
   if(!empty($aorder)) $criteria->order=$aorder;
   return $criteria;
}

function yearCondition($yearName,$termName){
   $area=(is_numeric($area)) ? $area :'';
   $code=(!empty($area)) ? $area : ( (!empty($city)) ? $city : $province);
   $code=(empty($code)) ? '44' : $code;
   $criteria = new CDbCriteria;
   $criteria->condition=$acode." like'".$code."%'";//所属教育行政部门
   $criteria->condition.=(empty($okey)) ? '' : otherCondition($okey);
   if(!empty($aorder)) $criteria->order=$aorder;
   return $criteria;
}
    // $w1='type:f_type,competent:f_competent,level:f_level';
function otherCondition($w1){
  $d=explode(',', $w1);
  $rs='';
  if(is_array($d)){
    foreach ($d as $k => $v) {
      $d1=explode(':', $v.':'.$v);
      $s1=$d1[0];
      if(isset($_GET[$s1])){
        $s2=$_GET[$s1];
        if(!empty($s2)){
          $rs.=' and '.$d1[1].'="'.$s2.'"';
        }
      }
    }
   }
   return $rs;
}

function getDateCondition($cr,$start,$end,$dateName){
    if ($start != '') { $cr.=' AND left('.$dateName.',10)>="' . $start. '"';}
    if (!empty($end)) {  $cr.=' AND left('.$dateName.',10)<="' . $end . '"';}
    return $cr;
}

//生成 sha1WithRSA 签名
function genSign($toSign, $privateKey){
    $privateKey = "-----BEGIN RSA PRIVATE KEY-----\n" .
        wordwrap($privateKey, 64, "\n", true) .
        "\n-----END RSA PRIVATE KEY-----";

    $key = openssl_get_privatekey($privateKey);
    openssl_sign($toSign, $signature, $key);
    openssl_free_key($key);
    $sign = base64_encode($signature);
    return $sign;
}

//校验 sha1WithRSA 签名
function verifySign($data, $sign, $pubKey){
    $sign = base64_decode($sign);

    $pubKey = "-----BEGIN PUBLIC KEY-----\n" .
                wordwrap($pubKey, 64, "\n", true) .
                "\n-----END PUBLIC KEY-----";

    $key = openssl_pkey_get_public($pubKey);
    $result = openssl_verify($data, $sign, $key, OPENSSL_ALGO_SHA1) === 1;
    return $result;
}

 function getOpenid(){
   //获取函数头的token
    if(!isset($_SERVER['HTTP_TOKEN'])) return '';
     return '';
      Yii::$enableIncludePath = false;
        Yii::import('application.extensions.JWT', 1);
        $payload=array(
            'openid'=>$json_obj["openid"],
            'session_key'=>$json_obj["session_key"]);
        $jwt=new Jwt;
        $token=$jwt->getToken($payload);  //加密,形成token
        $w1="wx_openid='".$json_obj["openid"]."'";  //
        $data['isSaveSuccess']="1";//$this->addUserInfo($json["encryptedData"],$json["iv"],$json_obj['session_key']);
        //返回token用于用户识别
}

   /**
 * 积分兑金额WSTBCMoney
 * $isBack=true则$score实际上传入金额，通过金额反推需要兑换的积分
 */
function SHScoreToMoney($score,$isBack = false){
    $scoreToMoney = (int)SHTConf('CONF.scoreToMoney');
    if($scoreToMoney<=0) return 0;
    return ($isBack) ? intval(strval($score*$scoreToMoney)) : round($score/$scoreToMoney,2);
}

/**
 * 根据送货城市获取运费
 * @param $cityId 送货城市Id
 * @param $shopId 店铺ID
 * @param $carts 购物车信息
 */
function SHFreight($shopId,$cityId,$carts=[]){
    $cnt = Shopexpress::model()->find("shopId=".$shopId);
    $freight = 0;
    if($cnt){
        $freight = Carts::model()->getShopFreight($shopId,$cityId,$carts);
    }else{
        $shop = Shops::model()->find("shopId=".$shopId);
        if($shop) $freight = (float) $shop->freight;
    }
    return ($freight>0) ? $freight : 0;
}

/**
 * 高精度数字相加
 * @param $num
 * @param number $i 保留小数位
 */
function SHBCMoney($num1,$num2=0,$i=2){
    $num = bcadd($num1, $num2, $i);
    return (float)$num;
}

function getAreaCondition($account,$areacode){
  return User::model()->getAreaCondition($account,$areacode);
}

/**
 * 保持数值为大于0的数值
 */
function SHPositive($num){
   return ($num>0)?round($num,2):0;
}

/**
 * 获取分类的佣金
 */
function SHGoodsRate($goodsCatId){
    $cats = Goodscats::model()->find('catId='.$goodsCatId);
    if(empty($cats)){
        return 0;
    }else{
      $Rate=$cats->commissionRate;
      if($Rate>=0) return $Rate;
        return SHGoodsRate($cats->parentId);
    }
}

/**
 * 收货方式
 */
function WSTLangDeliverType($v){
    switch ($v) {
        case 1:return "自提";
        case 0:return "送货上门";
        default:return '';
    }
}
/**
 * 订单状态
 */
function WSTLangOrderStatus($v){
    return SysConfig::model()->orderState($v);
}
/**
 * 积分来源
 */
function WSTLangScore($v){
    return SysConfig::model()->langScore($v);
}
/**
 * 资金来源
 */
function WSTLangMoneySrc($v){
     return SysConfig::model()->langMoneySrc($v);
}

/**
 * 生成数据返回值
 */
function WSTReturn($msg,$status = -1,$data = []){
    $rs = ['status'=>$status,'msg'=>$msg];
    if(!empty($data)) $rs['data'] = $data;
    return $rs;
}

/**
 * 投诉状态
 */
function WSTLangComplainStatus($v){
    return SysConfig::model()->langComplainStatus($v);
}

/**
 * 性别
 */
function WSTLangSex($v){
     return SysConfig::model()->langSex($v);
}
/**
 * 支付来源
 */
function WSTLangPayFrom($pkey = '',$type = 0){
    $paySrc = cache('WST_PAY_SRC');
    if(!$paySrc){
        $paySrc = Db::name('payments')->order('payOrder asc')->select();
        cache('WST_PAY_SRC',$paySrc,31622400);
    }
    if($pkey=='' && $type == 1)return $paySrc;
    foreach($paySrc as $v){
       if($pkey==$v['payCode'])return $v['payName'];
    }
    return '其他';
}

/**
 * 插件状态
 */
function WSTLangAddonStatus($v){
    return SysConfig::model()->langAddonStatus($v);
}

/**
 * 获取业务数据内容【根据catCode获取】
 */
function SHDatas($catCode,$id = 0){
    $tmp =Datacats::model()->find("catCode='".$catCode."'");
    $rs=array();
    if($tmp){
        $catId=$tmp['catId'];
        $w1='dataFlag=1 and catId='.$catId;
        $w1.=($id==0) ? '' : " and dataVal='".$id."'";
        $tmps = Datas::model()->findAll($w1);
        foreach ($tmps as $key =>$v){
             $rs[$v['dataVal']] = $v;
        }
        if(!empty($id)) {
           $rs=(isset($data[$id]))? $data[$id] : '';
         }
    }
    return $rs;
}
/**
 * 检测业务数据内容
 */
function WSTCheckDatas($catCode,$val){
    $tmp =Datacats::model()->find("catCode='".$catCode."'  and dataVal='".$val."'");
    return ($tmp) ? true : false;
}
/**
 * 获取消息模板
 */
function SHMsgTemplates($tplCode){
    $tmp = Templatemsgs::model()->find("plCode='".$tplCode."'");
    $v=null;
    if($tmp){
      $v=$tmp->attributes;
      if($v['tplContent']){
        $v['content'] = htmlspecialchars_decode($v['tplContent']);
        $v['tplContent'] = strip_tags(htmlspecialchars_decode($v['tplContent']));
      }
    }
    return $v;
}
/**
 * 发送微信消息
 */
function WSTWxMessage($params){
    $tpl = WSTMsgTemplates($params['CODE']);
    if($tpl && file_exists('wstmart'.DS.'wechat'.DS.'behavior'.DS.'InitWechatMessges.php')){
        Hook::exec(['wstmart\\wechat\\behavior\\InitWechatMessges','run'],$params);
    }
}
/**
 * 批量发送微信消息
 */
function WSTWxBatchMessage($params){
    $tpl = WSTMsgTemplates($params['CODE']);
    if($tpl && file_exists('wstmart'.DS.'wechat'.DS.'behavior'.DS.'InitWechatMessges.php')){
        \think\facade\Hook::exec(['wstmart\\wechat\\behavior\\InitWechatMessges','batchRun'],$params);
    }
}
/**
 * 发送小程序消息
 */
function WSTWeMessage($params){
    $tpl = WSTMsgTemplates($params['CODE']);
    if($tpl && file_exists('wstmart'.DS.'weapp'.DS.'behavior'.DS.'InitWeappMessges.php')){
        Hook::exec(['wstmart\\weapp\\behavior\\InitWeappMessges','run'],$params);
    }
}

/**
 * 删除一维数组里的多个key
 */
function SHUnset(&$data,$keys){
    if($keys!='' && is_array($data)){
        $key = explode(',',$keys);
        foreach ($key as $v)unset($data[$v]);
    }
}
/**
 * 只允许一维数组里的某些key通过
 */
function TAllow(&$data,$keys){
    if($keys!='' && is_array($data)){
        $key = explode(',',$keys);
        foreach ($data as $vkeys =>$v)
            if(!in_array($vkeys,$key))unset($data[$vkeys]);
    }
}

// 2020.11.24
// 原来条件，现在条件，属性名，值，前缀名
function get_where($pw0,$pwhere,$pfields,$pvalue='',$pdelc="")
{   $bs="=";
    if(empty($pvalue)) $pvalue=$pwhere;
    if(is_string($pvalue)) $pdelc='"';
    if (indexof($pfields,'=')>=0 || indexof($pfields,'>')>=0 || indexof($pfields,'<')>=0) $bs="";
    $pw1=(empty($pwhere)) ? "" : $pfields . $bs . $pdelc . $pvalue . $pdelc;
    $pw0.=((empty($pw0) || empty($pw1))  ? "" : " and ").$pw1 ;
    return $pw0;
}

//查找字符的位置，-1表示没找到
function indexof($string,$find,$start=0){
   if(empty($string)) return -1;
   if(empty($find)) return -1;
    $pos=strpos($string,$find,$start);
    return ($pos === false) ? -1 : $pos;
}

function del_daohao($pstr,$dchar=','){
       $pstr=str_replace(' ','', $pstr);
       return str_replace($dchar.$dchar,$dchar,$pstr);
}
// 原来条件，现在条件，属性名，值，前缀名
function get_like($pw0,$pfields1,$pvalue,$pfields2="")
{   if($pvalue=='undefined') $pvalue="";
    if(!empty($pvalue)){
        $pfields1.=empty($pfields2) ? "" : (",".$pfields2);
        $fs= explode(',',$pfields1);
        $pw1="";$aor="";
        for ($i = 0; $i < count($fs); $i = $i + 1) {
            $pw1.=$aor.  $fs[$i]. " like '%" . $pvalue ."%'";
            $aor=" or ";
        }
        $pw1=empty($pw1) ?"" :" ( ".$pw1." ) ";
        $pw0.=((empty($pw0) || empty($pw1))  ? "" : " and ").$pw1 ;
    }
    return $pw0;
}

function get_ols() {
   return BaseCode::model()->get_ols();
 }

function sql_update($sql){
  return sql_command($sql);
}

function sql_delete($sql){
  return sql_command($sql);
}

function sql_command($sql){
  $connection=Yii::app()->db;
  return $connection->createCommand($sql)->execute();
}

function sql_find($sql){
  return sql_findall($sql);
}

function sql_findone($sql){
  $connection=Yii::app()->db;
  return $connection->createCommand($sql)->queryOne();
}

function sql_findall($sql){
  $connection=Yii::app()->db;
  return $connection->createCommand($sql)->queryAll();
}

function get_session($name) {
    $rs=0;
    if(!isset($_SESSION)){ session_start();}
    if(isset(Yii::app()->session[$name])){
        $rs=Yii::app()->session[$name] ;}
    if($rs==0&&(isset($_SESSION[$name]))){
        $rs=$_SESSION[$name] ;}
    return $rs;
}

function set_session($name,$value) {
    $rs=0;
    if(!isset($_SESSION)){ session_start();}
    Yii::app()->session[$name]=$value ;
}

function setGetValue($name,$value='',$defalue_value='0') {
    if(!empty($value)) set_session($name,$value);
    if(empty($value)) {$value=get_session($name,$value);};
    return $value;
}

function recToSession($tmp,$names){
    $dm=explode(",",$names);
    foreach($dm as $v)
    {
        $d1=explode(":",$v);
        $s0=$d1[0];$s1=$s0;
        if(isset($d1[1])) $s1=$d1[1];
        if(isset($tmp->{$s1})){
          $v0=$tmp->{$s1};
          if(isset($d1[2])) $v0=$d1[2];
          set_session($s0,$v0);
        }
   }
}

// 2023.11.18

  //获取管理字段属性
function getToFields($colname){
    $ds=explode(',',$colname);
    $rs=array();
    foreach ($ds as $key => $value) {
       if(indexof($value,':h')<0){
         $ds1=explode(':',$value.':'.$value);
         $c=$ds1[0];
         if(indexof($c,'=')<0){
          $rs[]=array($c,$ds1[1],''); 
         } else{
           $d2=explode('=',$c);
           $rs[]=array($d2[0],'',$d2[1]); 
         }
       }
    }
    return $rs;
  }

// 2020.11.30
function setEventCode($id){
    return  MallPriceSet::model()->setEventCode($id);
}

// 获取平台框架相关
function sysConfigHs($typename){
    return SysConfig::model()->getValue($typename);
}
function getHtmlFile($tmp,$html_name){
  return  Basefun::model()->getAboutMe($tmp,$html_name);
 }

function hsYii_selectByData($form,$m,$atts0,$data,$shownName,$onchange='',$noneshow=''){
 return BaseLib::model()->selectByData($form,$m,$atts0,$data,$shownName,$onchange,$noneshow);
}

function hsYii_searchBy($title,$field,$datas,$id='id'){
     return BaseLib::model()->searchBy($title,$field,$datas,$id);
}
function hsYii_searchByData($title,$field,$datas,$id='id',$name='name'){
     return BaseLib::model()->searchByData($title,$field,$datas,$id,$name);
}

function hsYii_tableInput($form,$model,$s11){
     return BaseLib::model()->tableInput($form,$model,$s11);
}

function hsYii_updateData($thism,$model,$inputCmd,$title,$comstr){
   BaseLib::model()->updateBox($thism,$model,$inputCmd,$title,$comstr);
}

function hsYii_updateMore($thism,$model,$inputCmd,$title,$comstr){
   BaseLib::model()->updateBox($thism,$model,$inputCmd,$title,$comstr);
}

function hsYii_updateHtml($thism,$model,$inputCmd,$title,$comstr){
   BaseLib::model()->updateHtml($thism,$model,$inputCmd,$title,$comstr);
}

//输出省市联通的选择在
function areaRelationjs($thisv,$seachCmd){
    if((indexof($seachCmd,'EducationBureau/province')>=0)
        &&(indexof($seachCmd,'list(EducationBureau/city')>=0)){
       echo EducationBureau::model()->areaRelationjs($thisv);
    }
}

function hsYii_indexShow($thism,$model,$title,$schcmd,$data,$arclist,$pages,$eData=''){
    set_Session("setInSituTP",'1');
    set_Session("views_from",$thism);
    set_session("indexselect",'0');
    
   ob_start();
  if(empty($eData)){
    BaseLib::model()->indexShow($thism,$model,$title,$schcmd,$data,$arclist,$pages);
    areaRelationjs($thism,$schcmd);
   } else{
     hsYii_indexData($thism,$model,$title,$schcmd,$data,$arclist,$pages,$eData);
   } 
   $output = ob_get_clean();
   ob_end_clean(); 
   put_html($thism,$output,$model,'1');
   echo $output;
}

function hsYii_selectShow($thism,$model,$title,$schcmd,$data,$arclist,$pages){
   baseTemplate::model()->selectShow($thism,$model, $title,$schcmd,$data,$arclist,$pages);
}

function hsYii_indexData($thisv,$model,$title,$schcmd,$data,$arclist,$pages,$eData,$idu='0'){
   set_session("indexUpdate",$idu);
   BaseLib::model()->indexData($thisv,$model,$title,$schcmd,$data,$arclist,$pages,$eData);
   areaRelationjs($thisv,$schcmd);
}

function hsYii_showTable($thisv,$model,$title,$schcmd,$data,$arclist,$pages,$eData,$idu='0'){
  hsYii_indexData($thisv,$model,$title,$schcmd,$data,$arclist,$pages,$eData,$idu);
  // set_session("indexUpdate",$idu);
  // BaseLib::model()->indexData($thisv,$model,$title,$schcmd,$data,$arclist,$pages,$eData);
 //  areaRelationjs($thisv,$schcmd);
}

function hsYii_gridHeadShow($model,$coumnName){
   return BaseLib::model()->gridHeadShow($model,$coumnName);
}

function hsYii_gridRowsShow($thisp,$arclist,$idname,$coumnName,$cmdstr){
   return BaseLib::model()->gridRowsShow($thisp,$arclist,$idname,$coumnName,$cmdstr);
}


function  showGridData($thisv,$model,$arclist,$id,$coumnName,$cmdstr){
   return BaseLib::model()->showGridData($thisv,$model,$arclist,$id,$coumnName,$cmdstr);
}
 

function hsYii_updatelist($thisv,$opdata,$datas){
 // hsYii_indexData($thisv,$model,$title,$schcmd,$data,$arclist,$pages,$eData,'1');
 // ob_start();
  baseTemplate::model()->updatelist($thisv,$opdata,$datas);
  //$output = ob_get_clean();
  //ob_end_clean(); 
  //echo $output;
}

function hsYii_areaRelationJs($thisv,$m,$city='city',$area='area'){
  echo EducationBureau::model()->areaRelationjs($thisv,$m.'_'.$city,$m.'_'.$area);
}

function hsYii_addRelationJs($thisv,$city='city',$area='area',$ac,$m='',$params=array()){
  $m.=(empty($m)) ?'' :'_';
  $city=$m.$city;$area=$m.$area;
  echo EducationBureau::model()->dataRelationjs($thisv,$city,$area,$ac,$params);
}

function hsYii_json_encode($data) {
  ob_start();//ob_clean();
//ob_end_clean();ob_get_clean();ob_flush();
//ob_end_flush();ob_get_flush();
  echo json_encode($data);
  ob_end_flush();
  // ob_end_clean();
}
/**
 *小程序接口
 */
function getWXParameter($def_value='') {
    $request = file_get_contents('php://input');
    $rs=json_decode($request,true);
    $arr1 =explode(',',$def_value);
    if(is_array($arr1))
        foreach ($arr1 as $v) {
            $ds=explode(':',$v);
            if(!isset($rs[$ds[0]]))  {$rs[$ds[0]]='';}
            if(isset($ds[1])){
                if(empty($rs[$ds[0]])) $rs[$ds[0]]=$ds[1];
            }
        }
    //2022-1-20 
    //$openid=getOpenid();
    $openid=(!empty($rs['openid']) ) ? $rs['openid'] :'';
    $rs['openid']=$openid;
    if(!isset($rs['userId'])) $rs['userId']='';
    if(empty($rs['userId']) &&($openid)){
        $rs['userId']=Users::model()->readValue("wx_openid='".$openid."'",'userId');
    }
    return $rs;
}

function WX_echo($data = array(),$code = 200){
    $data['code'] = $code;
    echo CJSON::encode($data);
}

function autoCloseDialog(){
  $cs=get_session('winclose');set_session('winclose','0');
  $s1='<script>
   var cs='.$cs.';
   if(cs=="1"){
      api = $.dialog.open.api;  
       if (api) {  $.dialog.close();}
      function mm(){ window.opener=null;window.close();}
   }
  </script>';
 echo $s1;
}

//传入图片地址，id名（update用）
function show_pic($flie='',$id='',$maxHeight='80',$maxWidth='70',$canOpen='1'){
    $html='';
    if($flie){
        $html=empty($id)?'<div style="max-width:'.$maxHeight.'px; max-height:'.$maxWidth.'px;overflow:hidden;">':
            '<div style="float: left; margin-right:10px" id="upload_pic_'.$id.'">';
        if($canOpen) $html.= '<a href="'.$flie.'" target="_blank" title="点击查看">';

        $html.= substr($flie,-3,3)=='pdf'?
            '<img src="'.'/scnursps/uploads/temp/image/pdf_icon.jpg'.'" style="max-height:30px; max-width:20px;">':
            '<img src="'.$flie.'" style="max-height:'.$maxHeight.'px; max-width:'.$maxWidth.'px;">';
        if($canOpen) $html.='</a>';
        $html.='</div>';
    }
    return $html;
}


function show_picture($flie='',$id=''){
    $html='';
    if($flie){
        $html=empty($id)?'<div style="max-width:150px; max-height:80px;overflow:hidden;">':
            '<div style="float: left; margin-right:50px" id="upload_pic_'.$id.'">';
        $html.= '<a href="'.$flie.'" target="_blank" title="点击查看">';
        $html.= get_picUrl($flie);
        $html.='</a></div>';
    }
    return $html;
}

function get_picUrl($flie){
    $s1=substr($flie,-3,3);
    $s2=($s1=='pdf') ?'../uploads/temp/image/pdf_icon.jpg' : $flie; 
    return '<img src="'.$s2.'" style="height:80px; width:150px;">';
}


function isMobile() {
//如果有HTTP_X_WAP_PROFILE则一定是移动设备
if (isset($_SERVER["HTTP_X_NAP_PROFILE"])){ return true;}
//如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息if (isset($_SERVER["HTTP_VIA'])){
//找不到为flase,否则为true
return stristr($_SERVER['HTTP_VIA'],"wap") ? true : false;
///脑残法﹐判断手机发送的客户端标志,兼容性有待提高。其中'MicroMessenger'是电脑微信
if (isset($_SERVER["HTTP_USER_AGENT"]) ){
   $clientkeywods = array('nokia', 'sony', 'ericsson', 'mot' , 'samsung', 'htc','sgh', 'lg' , 'sharp', 'sie-', 'philips', 'panasonic', 'alcatel', 'lenovo', 'iphone', 'ipod', 'blackberry', 'meizu', 'android','netfront', 'symbian', 'ucweb' , 'windcwsce', 'palm','operamini' , 'operamobi' , 'openwave', 'nexusone' , 'cldc' , 'midp' , 'wap' ,'mobile','microMessenger');
//从HTTP_USER_AGENT中查找手机浏览器的关键字
if (preg_match("/(" . implode('|', $clientkeywords). ")/i",strtolower($_SERVER['HTTP_USER_AGENT'])))
  {return true;}
}
//协议法，因为有可能不准确﹐放到最后判断
if (isset($_SERVER['HTTP_ACCEPT'])){
  $hstr=$_SERVER['HTTP_ACCEPT'];
//如果只支持wm1并且不支持html那一定是移动设备/如果支持wml和html但是wm1在html之前则是移动设备
 if((strpos($hstr, 'vnd.wap.ml') !== false)&&(strpos($hstr, 'text/html') === false 
  ||(strpos($hstr,'vnd.wap.wml') < strpos($hstr,'text/html') ) ) )
  { return true;}
}
return false;
}

function getConfig($pnamem,$pic=''){
    return configm::model()->getValue($pname,$pic); 
}

function showDate($date1,$date2,$times=''){
  $r1='';
  if(!empty($date1)) $rs.=$date1->format('Y-m-d').chr(13).chr(10);
  if(!empty($date2)) $rs.=$date2->format('Y-m-d');
  return  $rs1;
}
function setbkcolor($bks=0){
  setGetValue("bkcolor",$bks);
}
//$form,$model,$fieldname 分别是表单，模型(数据),字段
function readData($form,$model,$fieldname,$td='1'){
  $rs= BaseLib::model()->getTdData($form,$model,$fieldname);
  if($td=='0'){ $rs=getNewData($rs);}
  return $rs;
}

function getNewData($s1){
  $r=indexof($s,'</td>');
  if($r>=0){
     $s1=substr($rs,$r+5); 
     $r=indexof($s1,'>');$s1=substr($s1,$r+1); 
     $r=indexof($s1,'<div');
     if($r>=0){ $s1=substr($s1,0,$r);}
  }
  return $s1;
}


function readDatatd($form,$model,$fieldname){
  return readData($form,$model,$fieldname);
}

function readDatatr($form,$model,$fieldname){
  return BaseLib::model()->trInput($form,$model,$fieldname);
}

function get_date_path($bpath){
    $ymd = date("Ymd");
    $yy=$bpath.substr($ymd,0,4);mk_dir($yy);
    $yy.='/'.substr($ymd,4,2);mk_dir($yy);
    $yy.='/'.substr($ymd,6,2);mk_dir($yy);
    return $yy.'/';
}

function get_date_default($pday,$ptype=0){
    if(empty($pday)){
         $pday = date('Y-m-d').(($ptype==0) ? "" : ' 23:59:59');
    }
    return $pday;
}

function get_html($file, $basepath = null, $strtr = array()) {
    return Basefun::model()->get_html($file, $basepath, $strtr);
}

function getplaintextintrofromhtml($html, $numchars) {
  $html = strip_tags($html);
  $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
  $html_len = mb_strlen($html,'UTF-8');
  $html = mb_substr($html, 0, $numchars, 'UTF-8');
  if($html_len>$numchars){  $html .= "…"; }
  return $html;
}

//判断文件是否存在
function check_file_exists($url) {
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_HEADER,0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //不验证证书
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1 );
    curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
    $res = curl_exec($ch);
    return $res;
}

function downList($datalist,$idname,$showname,$selectname,$style='',$pvalue='') {
  if(empty($pvalue)){
    $pvalue=Yii::app()->request->getParam($selectname);
  }
  $html='<select name="'.$selectname.'" '.$style.'>';
  $html.='<option value="">请选择</option>';
  if (is_array($datalist)){
    foreach($datalist as $v){
      $html.='<option value="'.$v[$idname].'"'.(($v[$idname]==$pvalue) ? ' selected >' :'>');
      $html.=$v[$showname].'</option>';
    }
  }
  $html.='</select>';
  return $html;
}

// 地区选择
function areaList($id='',$style='',$level=1,$up_level=''){
    return TRegion::model()->areaList($id,$style,$level,$up_level);
}
//
//参数$club_field='',$project_field=''=pf 简化
function get_where_club_project($club_field='',$pf=''){
      $clubid=get_SESSION('club_id');
      $w1='1';
      $w1.=(empty($club_field)) ? '':' and '.$club_field.'='.$clubid;
      $w1.=(empty($pf)) ? '':' and '.$pf.' in ('.get_SESSION('club_project').')';
      return $w1;
  }

function getIds($tmp,$idName) {
    $rs="";$b='';
    foreach($tmp as $v){
      $rs.=$b.$v[$rs];
      $b1=',';
    }
    return  $rs;
}

function getAge($birthday){
   return Basefun::model()->getAge($birthday);
}

function Lang($pname){
   echo  Language::model()->getLang($pname);
}

function update_log($tmp){
   tableUpdate::model()->update_log($tmp);
}
function save_change($table,$uptype,$data,$keyname,$keyvalue) {
    $test->save_change($table,$uptype,$data,$keyname,$keyvalue);
}

function filein($filename){
    return (is_file($filename)) ? 1 : 0 ;
}

function wwwsportcn(){
    return 'htt.gdinin.com';
}

function wwwsportnet(){
    return wwwsportcn();
}

function httpssportnet(){
    return 'https://'.wwwsportcn();
}
function birthday($birthday){
  return Basefun::model()->getbirthday($birthday);
}
//输出200状态 copy by wrf
function JsonSuccess($data=array(),$ecode='200'){
    $rs = array('data'=>$data,'time'=>time(),'code'=>$ecode,'request'=>$_REQUEST);
    echo CJSON::encode($rs);
}

//输出500状态 copy by wrf
function JsonFail($data='访问失败'){
    if(!is_array($data)) { $data=array($data);}
    JsonSuccess($data,'500');
}

function modelGetPost(&$model,$post){
    foreach ($post as $key => $value) {
        $model->{$key} = $value;
    }
    return true;
}
