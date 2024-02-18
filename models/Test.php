<?php

class Test extends BaseModel {
    public $selectval=array(2);
    public function tableName() {
        return '{{test_err}}';
    }
   public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function relations() {
        return array();
    }
  public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    protected function afterFind(){
      parent::afterFind();
      return true;
    }
    protected function beforeSave(){
      parent::beforeSave();
      return true;
    }
    protected function afterSave() {
        parent::afterSave();
    }
    public function attributeSets() {
        return array(
        'f_id' => 'ID',
        'f_rcode' => '编码',
        'f_rname' => '名称',
        'f_type' => '类别',
        'f_child' => '子角色',
        'f_default' => '权限',
        );
    }

   public static function aput_msg($pmsg) {
       // $this->isNewRecord = true;
       // $this->f_msg=$pmsg;
        //$this->save();

        if (is_array($pmsg)){
            $pmsg=json_encode($pmsg);
        }
       // $backtrace = debug_backtrace();
  
         $this->isNewRecord = true;
        if (is_array($pmsg)){
            $pmsg=json_encode($pmsg,JSON_UNESCAPED_UNICODE);
        }
        $tmp = new Test();
        $tmp ->isNewRecord = true;
        $tmp ->f_msg=$pmsg;
       // $tmp=$tmp->put_more($tmp);
        $tmp ->f_time=get_date();
        $tmp ->save();
     }

     
    public static  function put_file($str,$fname='error_log.txt',$pnew='0')
    {
        if (is_array($str))
         $str=json_encode($str,JSON_UNESCAPED_UNICODE);
        $wr=($pnew=='0') ?'a' :'w';
        $fp = fopen($fname,$wr);
        fputs($fp,$str);
        fclose($fp);
    } 
 
    //增加科目
    //参数：科目ID，修改的信息数组
    //返回值：true
 
   public static function put_msg($pmsg,$er=0)
    {
      $this->put_file($pmsg);
      return ;
      $fname='error_log.txt';
        $str=json_encode($str,JSON_UNESCAPED_UNICODE);
        $wr=($pnew=='0') ?'a' :'w';
        $fp = fopen($fname,$wr);
        fputs($fp,$str);
        fclose($fp);
        return ;
        $er=1;
        if($er) {
           $this->put_file($pmsg);   
           $this->put_file(chr(13).chr(10));
         } else{
           $this->put_msg_rec($pmsg);
         }
    }

  public function put_more($tmp) {
        $s1=json_encode(debug_backtrace(),JSON_UNESCAPED_UNICODE);
        for($i=0;$i<=3;$i++){
          $s1=str_replace('select_item'.$i,'',$s1);//html_tmp0
          $s1=str_replace('html_tmp'.$i,'',$s1);
        }
        $s1=str_replace('select_id','',$s1);
        $s1=str_replace('select_code','',$s1);//wamp64\\www\\trace\\
        $s1=str_replace('wamp64','',$s1);//\\wamp64\\www\\trace\\
        $s1=str_replace('""','',$s1);//":"",
        $s1=str_replace('::','',$s1);//":"",
        $s1=str_replace(':null','',$s1);
        $s1=str_replace(';;','',$s1);//select_title
        $s1=str_replace('select_title','',$s1);//select_title
        $s1=str_replace('data_check','',$s1);//select_title
        $s1=str_replace('www','',$s1);
        $s1=str_replace(':,','',$s1);//":"", ""
        $s1=str_replace('""','',$s1);//":"",
        $tmp->f_callname=$s1;
        return $tmp; 
     }
         $this->f_username=get_session('admin_name');
     //    $this->f_callname=json_encode(debug_backtrace());
         $this->save();
    
    }


}
