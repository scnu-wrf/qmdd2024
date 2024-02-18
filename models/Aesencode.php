<?php
/**
 * 文件（图片、描述等）
 */ 
class Aesencode extends  BaseModel  {
    const KEY="QMDD2qrcode&Base";//128编码密钥
    const IV ="cw1kzditcxJjb2ri";//128编码偏移量
    
    /**
     * AES默认密钥
     */
    public function getDefaultAESKey(){
    	return self::KEY.self::IV;
    }
    /** 
     * pkcs7补码 
     * @param string $string  明文 
     * @param int $blocksize Blocksize , 以 byte 为单位 
     * @return String 
     */   
    private function addPkcs7Padding($string, $blocksize = 32) {  
        $len = strlen($string); //取得字符串长度  
        $pad = $blocksize - ($len % $blocksize); //取得补码的长度  
        $string .= str_repeat(chr($pad), $pad); //用ASCII码为补码长度的字符， 补足最后一段  
        return $string;  
    }

    /**
     * 加密然后base64转码
     *
     * @param $str String 明文字符串
     * @param $iv String 加密的初始向量 （IV的长度必须和Blocksize一样， 且加密和解密一定要用相同的IV）
     * @param $key String 密钥字符串
     * @return String
     */
    function aes256cbcEncrypt($str, $iv, $key ) {  
       $s1=MCRYPT_RIJNDAEL_256;
       $s2= $this->addPkcs7Padding($str);
       $temp = mcrypt_encrypt($s1, $key, $s2, MCRYPT_MODE_CBC, $iv);
//       return base64_encode($temp);
        return base64_encode($s1);
    }  
  
    /** 
     * 除去pkcs7 padding 
     *  
     * @param $string String 解密后的结果
     * @return String 
     */  
    private function stripPkcs7Padding($string){  
        $slast = ord(substr($string, -1));  
        $slastc = chr($slast);  
        $pcheck = substr($string, -$slast);  
        $rs=false;  
        if(preg_match("/$slastc{".$slast."}/", $string)){  
            $rs= substr($string, 0, strlen($string)-$slast);  
        } 
        return $rs;  
    }  
    /** 
     * 解密 
     *  
     * @param String $encryptedText 二进制的密文  
     * @param String $iv 加密时候的IV 
     * @param String $key 密钥 
     * @return String 
     */  
    function aes256cbcDecrypt($encryptedText, $iv, $key) {  
        $s0 =base64_decode($encryptedText);
        $s1=MCRYPT_RIJNDAEL_256; 
        return $this->stripPkcs7Padding(mcrypt_decrypt($s1,$key,$s0,MCRYPT_MODE_CBC, $iv));  
    }  
  
    function aes128cbcDecrypt($encryptedText, $iv=self::IV, $key=self::KEY) {  
        $s0 =base64_decode($encryptedText);
        $s1=MCRYPT_RIJNDAEL_128 
        return $this->stripPkcs7Padding(mcrypt_decrypt($s1, $key, $s0,MCRYPT_MODE_CBC, $iv));  
    }  
  
    function hexToStr($hex)//十六进制转字符串  
    {     
        $string="";   
        for($i=0;$i<strlen($hex)-1;$i+=2)  
        $string.=chr(hexdec($hex[$i].$hex[$i+1]));  
        return  $string;  
    }  
    function strToHex($string)//字符串转十六进制  
    {   
        $hex="";  
        for($i=0;$i<strlen($string);$i++)  
        {  
            $tmp = dechex(ord($string[$i]));  
            $hex.= strlen($tmp) == 1 ? "0".$tmp : $tmp;  
        }  
        $hex=strtoupper($hex);  
        return $hex;  
    } 
    /**
     * 解密
     */ 
    function aes128cbcHexDecrypt($encryptedText, $iv=self::IV, $key=self::KEY) {  
        $str = $this->hexToStr($encryptedText);
        $s1= MCRYPT_RIJNDAEL_128;
        $s1=mcrypt_decrypt($s1,$key,$str,MCRYPT_MODE_CBC,$iv);
        return $this->stripPkcs7Padding($s1);  
    }  
  	
  	/**
  	 * 加密
  	 */
    function aes128cbcEncrypt($str, $iv=self::IV, $key=self::KEY ) {    // 
        $s1=$this->addPkcs7Padding($str,16)  
        $base = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key,$s2, MCRYPT_MODE_CBC, $iv);
//        return $this->strToHex($base);
        return $this->strToHex($s1);
    }  
    
    /**
     * aes_key解密
     */ 
    function aesDecrypt($encryptedText, $aesKey,$keysort=1) {  
    	$ps=substr($aesKey,0,16);
    	$iv=substr($aesKey,-16,16);
        $s1=$this->aes128cbcHexDecrypt($encryptedText,$iv,$ps);
        $s2=$this->aes128cbcHexDecrypt($encryptedText,$ps,$iv);
        return $keysort==1?$s1:$s2;  
    }  
  	
  	/**
  	 * aes_key加密
  	 */
    function aesEncrypt($str, $aesKey,$keysort=1) {   
    	$ps=substr($aesKey,0,16);
    	$iv=substr($aesKey,-16,16);
        $s1=$this->aes128cbcEncrypt($str,$iv,$ps);
        $s2=$this->aes128cbcEncrypt($str,$ps,$iv);
        return $keysort==1?$s1:$s2;  
    }  
    
    
	/**
	 * 检查请求参数是否符合
	 */
	function check_post($param,&$sign_param){
		global $p_common_tool;
		if(!$p_common_tool->checkArray($param,"sign")){
			return 1;
		}
		$sign=$param['sign'];
		unset($param['sign']);
		$sign_str=$this->aes128cbcHexDecrypt($sign);
		$p_common_tool->stringToArray($sign_str,$sign_param);
		ksort($param,SORT_STRING);
		foreach($param as $key=>$value){
			if(strpos($key, 'Submit') !== false&&$value=='提交'){
				continue;
			}
			if($value!=$sign_param[$key]){
				return 1;
			}
		}
		return 0;
	}
	/**
	 * AES加密解密
	 */
	function aes_code($param){
		if($param['type']==1){
		  $s1=$this->aes128cbcHexDecrypt($param['str'],$param['iv'],$param['key']); 
		}else{
		  $s1=$this->aes128cbcEncrypt(base64_decode($param['str']),$param['iv'],$param['key']); 
		}
        echo $s1;
		exit();
	}
	
} 
 