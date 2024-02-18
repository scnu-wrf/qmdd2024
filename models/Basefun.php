<?php
class Basefun extends BaseModel {
    public function tableName() {
       return '{{base_no}}';
    }
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
   
    /**
     * 属性标签
     */
    public function attributeLabels() {
       return array(
        'areaId' =>'id',
        'areaName' =>'名称',
         );
      }

    public  function return_ok($pcode=0){  
         return $this->test_error($pcode);
    }


    public  function test_error($err){  
         return $this->check_error($err>-1,"0","操作成功","2","操作失败");
        }

    public function check_error($ex,$err0,$msg0,$err1="0",$msg1="",$aname="",$value=""){
        $s0=$this->get_error($err0,$msg0);
        $s1=$this->get_error($err1,$msg1);
         $data= ($ex) ? $s0 : $s1 ;
        if (!empty($aname))  $data[$aname]=$value;
        return $data;
    }

   public  function getbirthday($birthday){
      $age = strtotime($birthday);
      if($age === false){
       return false;
      }
      list($y1,$m1,$d1) = explode("-",date("Y-m-d",$age));
      $now = strtotime("now");
      list($y2,$m2,$d2) = explode("-",date("Y-m-d",$now));
      $age = $y2 - $y1;
       if((int)($m2.$d2) < (int)($m1.$d1))
        $age -= 1;
       return $age;
  }
    function get_error($error,$msg){
        return array('error' =>$error,'msg'=>$msg);
    }
    function set_error(&$data,$error,$msg,$exit=0){//不能直接使用get_error($error,$msg)方法，否则$
        if($data==null){
            $data=array();
        }        
        $data['error'] =$error;
        $data['msg'] =  $msg;
        if($exit==1) $this->exit_json($data);
      }

    function exit_error($error,$msg,$data=null){//不能直接使用get_error($error,$msg)方法，否则$
        if($data==null){
            $data=array();
        }        
        $data['error'] =$error;
        $data['msg'] =  $msg;
        $this->exit_data($data);
      }
    
    function exit_data($data){//不能直接使用get_error($error,$msg)方法，否则$
        $this->exit_json($data);
      }


    function set_error_tow(&$data,$ex,$err0,$msg0,$err1,$msg1,$exit=0){
       $ex =($ex) ? $this->set_error($data,$err0,$msg0,$exit) : $this->set_error($data,$err1,$msg1,$exit);
     }


    function exit_jsonb($data){
        $data['stime']=time();
        ob_clean();
        exit(json_encode($data,JSON_UNESCAPED_SLASHES));
    }


        
    function resultAuto($ret) {
        if (empty( $ret ))
            return $this->result( 1, '数据异常' );
        else
            return $this->result( 0, $ret );
    }
    /**
     * 组装返回array('error','res')
     */
    function result($err, $ret) {
        return array ('error' => $err,'res' => $ret );
    }
    /**
     * 检查数据是否在有效范围内
     */
    function checkNum($num, $min, $max) {
        $n = intval( $num );
        return $min <= $n && $n <= $max;
    }
    /**
     * 检查键值对，
     * @param $exit=0 存在空值返回false; =1 exit(json_encode(array('error'=>2,'msg'=>'缺少参数')));
     */
    function checkArray($array, $keys,$exit=0) {
        global $p_gf_user_login_history;
        $keyArr = explode( ',', $keys );
        foreach ( $keyArr as $k => $v ) {
            if ($this->isEmpty( $array[$v] )){
                if($exit){
                    $p_gf_user_login_history->exit_json(array('error'=>2,'msg'=>'缺少关键参数','keyword'=>$v));
                }else{
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * 参数过滤匹配
     */
    function fliterParam($array, $def) {
      $ret = array ();
      foreach ( $def as $k => $v )
          if (!isset($array[$k]) || $this->isEmpty( $array[$k] ))
              $ret[$k] = $def[$k];
          else
              $ret[$k] = $array[$k];
      return $ret;
    }
    /**
     * 返回数据交集
     */
    function params($arr, $keys) {
        return parama( $arr, explode( ',', $keys ) );
    }
    /**
     * 返回数据交集
     */
    function parama($arr, $keys) {
        $keycheck;
        foreach ( $keys as $k => $v ) {
            $keycheck[trim( $v )] = $k;
        }
        return array_intersect_key( $arr, $keycheck );
    }
    /**
     * 值是否为空
     */
    function isEmpty($p) {
        if (isset( $p ))
            return trim( $p ) == '';
        return true;
    }
    
      //将 xml数据转换为数组格式。
    function xml_to_array($xml){
      $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
      if(preg_match_all($reg, $xml, $matches)){
        $count = count($matches[0]);
        for($i = 0; $i < $count; $i++){
        $subxml= $matches[2][$i];
        $key = $matches[1][$i];
          if(preg_match( $reg, $subxml )){
            $arr[$key] = $this->xml_to_array( $subxml );
          }else{
            $arr[$key] = $subxml;
          }
        }
      }
      return $arr;
    }

//app_appid: 'wx775e4d708b9cbe29',//深海
//app_secret : 'c05e533273ef7bc864fc89bc51e663b8',
 
public static function get_appid() {
    return 'wx566c15824fd2564b';
  }
public static function get_secret() {
    return 'c32b9f18e8be0e5293c388521b9341ec';//$this->app_secret;
  }
     
public static function Get3rdsession($len)
{
      $s1 ='0123456789abcdefghijklmnopqrstuvwxyz';
      $s1.='!@#$%^&*()ABCDEFGHIJKLMNOPQRSTUVWXYZ';
      $s2='';
      for($i=0;$i<100;$i++){
        $i1=rand(0,70);
        $s2.=substr($s1,$i1,1);
      }
        // convert from binary to string
        $result = base64_encode($s2);
        // remove none url chars
        $result = strtr($result, '+/', '-_');
         return substr($result, 0, $len);
 }


  function exit_json($data){
    global $p_aes_encode_class,$p_gf_user_login_history,$s_logger;
    $jsus=JSON_UNESCAPED_SLASHES;
    if($data['error']!=0){
      $s_logger->write_to_file($_POST['visit_id']." -v ".json_encode($_REQUEST,$jsus)." exit=".json_encode($data,$jsus));
    }
    if(!empty($_POST['visit_id'])){
        $key=$p_gf_user_login_history->getLoginKey($_POST['visit_id']);
        if(!empty($_POST['enparams'])){
          $sign_data=Aescode::model()->aesEncrypt(json_encode($data,$jsus),$key);
          ob_clean();
          exit(json_encode(array('error'=>$data['error'],'endata'=>$sign_data),$jsus));
        }elseif(isset($data['datas'])){
          $data['datas'] = Aescode::model()->aesEncrypt(json_encode($data['datas'],$jsus),$key,empty($_POST['iosign'])?1:0);
        }
      }
    $data['stime']=time();
    ob_clean();
    exit(json_encode($data,$jsus));
  }


function str_to_html($str,$filename,$param) //内容保存文件
    {
      $str=str_replace(BasePath::model()->get_wpath(),'<htt></htt>',$str);
      $str=str_replace(BasePath::model()->get_www_gwpath(),'<htt></htt>',$str);
      return str_to_file($str,$filename,$param);
    }

function str_save_to_html($file, $content, $basepath = null, $strtr = array()){
   return $this->set_html($file, $content, $basepath, $strtr);
}

function set_html($file, $content, $basepath = null, $strtr = array()) {
    $prefix = '';
    if ($basepath != null) {
        $content = strtr($content, array($basepath->F_WWWPATH => '<htt></htt>'));
        $prefix = $basepath->F_CODENAME;
    }
    if (!empty($strtr)) {
        $content = strtr($content, $strtr);
    }
$htmlHeader ='<!doctype html><html><head>
<meta charset="utf-8"><title></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"/>
<style>
*{
    margin:0; padding:0;
    -webkit-tap-highlight-color:rgba(0,0,0,0);}
img{
  max-width:100%;display:block;float:left; height:auto;}
body{
  line-height:26px !important;font-size:20px;color:#000;
  -webkit-text-size-adjust:none;
  -o-text-size-adjust:none;
  text-size-adjust:none;
  background:#fff;
    padding:10px 20px 10px 20px !important;}
.qmdd-wrapper{}
body p{line-height:26px !important;font-size:17px !important;font-family:宋体 !important}
body span{line-height:26px !important;font-size:17px !important;font-family:宋体 !important}
</style>
</head>
<body><div class="qmdd-wrapper">
<!--详情开始--->';
    $htmlFooter ='<!--详情结束---></div></body></html>';
    $test=$htmlHeader.$content.$htmlFooter;
    $param['fileCode']=$prefix;
    $rs = $this->str_to_html($htmlHeader.$content.$htmlFooter,$file,$param);
    return $rs;
}

// $file 文件完整路径
// $path 替换内容中占位符的路径
function get_html($file, $basepath = null, $strtr = array()) {
    $content='';
    if(!empty($file) && strstr($file,'html')){
        if (check_file_exists($file)) {
            $opts = array( 'https'=>array('method'=>"GET",
                    'header'=>"Referer: " 
                )
            );
          $content = file_get_contents($file."?_".time(),false,stream_context_create($opts));
          $rs = preg_match('%<body>(.*?)</body>%si', $content, $matches);
          $content= (!$rs) ? '' : $matches[1];
          if ($basepath != null) {
            $content = strtr($content, array('<htt></htt>' => $basepath->F_WWWPATH));
            $content = strtr($content, array('<htt></htt>' => $basepath->F_WWWPATH));
          }
          if (!empty($strtr)) {  $content = strtr($content, $strtr); }
        } 
    }
    return $content;
}

function getplaintextintrofromhtml($html, $numchars) {
  $html = strip_tags($html);
  $html = html_entity_decode($html, ENT_QUOTES, 'UTF-8');
  $html_len = mb_strlen($html,'UTF-8');
  $html = mb_substr($html, 0, $numchars, 'UTF-8');
  if($html_len>$numchars){ $html .= "…";}
  return $html;
}
//tmp 对象,$html_name 字段名,$path模型表名称
public  function getAboutMe($tmp,$html_name){
    $basepath =$this->getTablePath($tmp);
    $about=$tmp->{$html_name};
    $about_tmp=$tmp->{$html_name.'_temp'};
    $about_me='';
    if ($about_tmp!= '') {
        $rs=$this->set_html($about, $about_tmp, $basepath);
        if (isset($rs['filename'])) {
          $about_me = $rs['filename'];
        }
    } 
    return $about_me;
}

public  function getTablePath($tmp){
    $path=str_replace('{','',$tmp->tableName());
    $path=str_replace('}','',$path);
    $path=strtolower($path);
    return BasePath::model()->find("F_SCODE='".$path."'");
  }

  public function getAge($birthday){
    //$birthday = '1980-05-23'; // 生日日期
     $today = date('Y-m-d'); // 当前日期
 
    // 将生日转换为时间戳
    $timestampBirthday = strtotime($birthday);
    // 获取今天的时间戳
    $timestampToday = strtotime($today);
    // 计算两个时间戳之间相差的秒数
    $secondsDiff = $timestampToday - $timestampBirthday;
    // 将秒数转换成年份
    return floor($secondsDiff / (60 * 60 * 24 * 365));
  }

  function toCWeek($weekday){
        $chineseWeekday ='星期一';
        switch ($weekday) {
        case 'Monday':
            $chineseWeekday = '星期一';
            break;
        case 'Tuesday':
            $chineseWeekday = '星期二';
            break;
        case 'Wednesday':
            $chineseWeekday = '星期三';
            break;
        case 'Thursday':
            $chineseWeekday = '星期四';
            break;
        case 'Friday':
            $chineseWeekday = '星期五';
            break;
        case 'Saturday':
            $chineseWeekday = '星期六';
            break;
        case 'Sunday':
            $chineseWeekday = '星期日';
            break;
        }
        return $chineseWeekday;
    }
}
