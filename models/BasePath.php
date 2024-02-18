<?php
class Basepath extends BaseModel {
    var $db_data="2";//文件上传使用的是统一的服务器，需要设置访问数据源，1-新服务器，2-内测，3-公测，4-公网
       public function tableName() {
        return '{{base_path}}';
    }
/*
各类图片存放路径说明\r\n表使用说明：表名称（F_SCODE）  +  存放属性名（F_FIELDNAME），如商城mall_products表product_LOG字段=ID为115访问路径http://upload.gf41.net/，存储路径为/home/oss/qmdd_upload/Mall/pic/2020/01/13/w200h50/，图片上传按：F_PATH存放路径+FILE_DIRECTORY+年/月/日+/w+宽+h+高/，存储文件名为时间戳_+FILE_PATH_NAME+序号.文件格式名，如商城图片存放/home/oss/qmdd_upload/Mall/pic/2020/01/13/w200h50/1607930378_thumbnail_pic_pic.jpg';
 */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
      return array(
      'f_id' => 'id',
      'F_CODE' =>'编码',
      'F_SCODE' =>'表名称',
      'F_NAME'=> '名称',
      'F_PATH' =>'路径',
      'FILE_DIRECTORY' =>'文件目录',
      'FILE_PATH_NAME' =>'文件名称',
      'TABLE_WHERE' => '类型判断',
      'ADD_ACCOUNT' => '添加账号',//，0-不添加，1-添加',
      'F_WWWPATH' => '',
      'F_CODENAME' => '上传文件属性',
      'F_FIELDNAME' => '图片类型',
      'F_PNUM' => '代码路径',
      'F_PNUMB' => '',
      'F_PATH_CODE' => '标识代码',
      'F_PX_WIDE' => '图片宽度',
      'F_PX_HIGH' => '图片高度',
      );
    }


  public function sortPath() {
     return "/uploads/temp/";
  }

  public function savePath() {
     return ROOT_PATH. '/' .$this->sortPath();
  }
  
  public function wwwPath() {
     return $this->get_www_path();
  }
    public function get_www_path() {
        return  $this->sitePath().$this->sortPath();

    }
    public function sitePath() {
        return  SITE_PATH. '/' ;  
    }
//    http://127.0.0.1//hns/hhnew/uploads/20190122/by202308200902394-11.png
  public function fmodelPath(){
     $s1=get_session('modelPath');
     $s1=($s1) ? $s1.'/' : 'temp/';
     $m=date('m');
     $s0=(($m<10) ? '0' :'').$m;
     return  $s1 .date('Y') . '/' . $s0. '/' ;
  }

  public function datePath(){
     $savepath = BasePath::model()->savePath();
     $ymd = date("Ymd");
     $datePath=substr($ymd,0,4).'/'.substr($ymd,4,2).'/'.substr($ymd,6,2);
     $this->mk_dir($savepath . $datePath);
     return  $datePath;
   }
  
  function mk_dir($path, $mode = 0755) {
      if(!is_dir($path)) {
        $ds=explode("/",$path);
        $s1="";$b1='';
        foreach ($ds as $v) {
           if(!empty($v)){
            $s1.=$b1.$v;$b1='/';
            if (!is_dir($s1)) { mkdir($s1,$mode,true); }
          }
        }
      }
    }

public function toNewPage($paction) {
    return  $this->sitePath().'index?r='.$paction;
  }

public function reMovePath($str1){
  return  str_replace($this->sitePath(),"",$str1);
}

public function addPath($str1){
    if($str1)
        if(!substr_count($str1,'http') &&(indexof($str1,'127.0.0')<0) ){
            $str1=$this-> get_www_path().$str1;
        }
    return  $str1;
}
public function remove_path($str) {
  return $this->reMovePath($str);
}
public function fileIcon($flie) {
   $s1=substr($flie,-3,3);
   $s2='uploads/temp/image/'.$s1.'_icon.jpg';
   $rs=$flie;
   if (substr($flie,-3,3)=='pdf') $rs=$s2;
    return $rs;
  }

  public function getPath($f_id) {
      return $this->find('f_id=' . $f_id);
  }

}
