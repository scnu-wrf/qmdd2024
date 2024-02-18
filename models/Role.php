<?php

class Role extends BaseModel {
    public $selectval=array(2);
    public $tmp_opter=array();
    public $tmp_opter2=array();
    public function tableName() {
        return '{{qmdd_role_new}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_rcode', 'required', 'message' => '{attribute} 不能为空'),
            array('f_rname', 'required', 'message' => '{attribute} 不能为空'),
//array('f_club_type', 'required', 'message' => '{attribute} 不能为空'),           // 
//array('f_club_item_type', 'required', 'message' => '{attribute} 不能为空'),
      array('club_id,f_tcode,f_child,f_club_item_type,f_type,f_opter,if_inster,if_update,if_delete,if_select,f_club_type,f_club_type_name','safe'), 
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array();
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'f_id' => 'ID',
            'f_tcode' => '全码',
            'f_rcode' => '编码',
            'f_rname' => '名称',
            'f_type' => '类别',
            'f_club_item_type' => '单位类型',
            'f_club_item_type_name' => '单位类型',
            'f_club_type' => '单位类型',
            'f_club_type_name' => '单位类型',
            'f_user_type' => '职位类型',
            'f_user_type_name'=>'职位类型',
            'f_child' => '子角色',
            'f_default' => '菜单权限',
            'if_state' => '审核权限',
            'if_inster' => '插入权限',
            'if_update' => '修改权限',
            'if_delete' => '删除权限',
            'if_select' => '查询权限',
            'f_opter' => '操作权限',
            'f_temporary' => '临时用户',//使用类型，0普通，1临时使用,只对一级人员使用'
        );
    }

   // public static function find(){
    // return new GoodCategoryQuery(get_called_class());
   // }

    public function getCode() {
        return array( 
            array('f_id' => '1','F_NAME' => '机构'),
            array('f_id' => '2','F_NAME' => '其他'),);
    }

   public function getLevel($lang_type='0',$club_id=-1) {
      $ws=($lang_type=='1') ? ' club_id='.$club_id.' and not isnull(f_rcode) ' : "substr(f_rcode,3,1)>' ' and club_id=0 and substr(f_rcode,4,1)=' '";
      $ws.=' order by f_rcode';
      return $this->findAll($ws);
    }

  public function getChild($pcode,$pnew=0) {
      $w1=($pnew==0) ? " and (1=2) " : "";
      return $this->findAll("left(f_tcode,".strlen($pcode).")='".$pcode."' and f_tcode<>'".$pcode."'".$w1);
    }

     function get_tree($pclub=0){
        $criteria = new CDbCriteria() ;    
        $criteria->order='f_rcode';
        $criteria->condition = "substr(f_rcode,4,1)=' '";
        if($pclub<>0){
           $tmp=Clubadmin::model()->find("club_id=".get_session('club_id'));
           $level=get_session('level');
           if(!empty($tmp)) {
            $level=$tmp->admin_level;
           }
           $criteria->condition = '(club_id='.get_session('club_id').' or  f_id in ('.$level.')) and not isnull(f_rcode)';
        }
        return $this->findAll($criteria);   
     }
     
   public function RoleName($rolestr) {
      $rolestr.=($rolestr=='') ? '0' : '';
      $list=$this->findAll("f_id in (". $rolestr.')');
       $w1='';
       foreach ($list as $v) {
          if($v->f_tcode){
                $father = $this->find('f_rcode="'.$v->f_tcode.'"');
                $w1.=$father->f_rname.'-';
            }
          $w1.=$v['f_rname'].',';
         }
      return $w1;
    }

    public function getPathName($pcode="") {
     $wln=strlen($pcode);
     $w1="系统";
     if($wln>0){
       $w1=" f_type=" . ($wln+1);
       $w1.=($wln==0) ? " " : " and left(f_tcode,1)='".substr($pcode,0,1)."'";
       $adver=$this->findAll($w1);
       $w1='';
       foreach ($adver as $v) {
         $s1=str_replace(' ','',$v->f_rname);
        if ($s1==substr($pcode,0,strlen($s1))){
          $w1.=$v->f_rname.'\ ';}
         }
        $rs =$this->find(array('select' =>array('f_id ','f_rname'),'condition'=>"f_tcode='".$pcode."'"));
       if ($rs != null && $rs->f_rname != '' && $rs->f_rname != null) {     
            return $rs->f_rname;
        } 
     
      }
      return $w1;
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
     parent::beforeSave();
        //树树编码
        $l1=strlen($this->f_tcode);
        $l2=strlen($this->f_rcode);
        if(empty($this->f_tcode)||$this->f_tcode==' '){
          return ($l2==1);
        }   
        return ((substr($this->f_rcode,0,strlen($this->f_tcode))==$this->f_tcode) && ($l1==($l2-2)));//true;
    }    

 public function getParent($pfieldname,$pcode) {
      $rs =$this->find(array('select' =>array('f_id ',$pfieldname.' f_rname'),'condition'=>"f_tcode='".$pcode."'"));
      if ($rs != null && $rs->f_rname != '' && $rs->f_rname != null) {     
            return $rs->f_rname;
        } 
      return '';
   }
   
 public function getParent_by_level($pfieldname,$level) {
      $rs =$this->find(array('select' =>array('f_id '),'condition'=>"f_id in (".$level.")"));
      $tc="";$bs="";
      foreach ( $rs as $key => $value ) {
       $tc.=$bs . " f_tcode like '".$value."%'";
       $bs=" or ";
      }
      $rs =$this->find(array('select' =>array('f_id ',$pfieldname.' f_rname'),'condition'=>$tc));
       if ($rs != null && $rs->f_rname != '' && $rs->f_rname != null) {     
            return $rs->f_rname;
        } 
      return '';
   }
   //获取所有f_rcode长度为1的角色与其下一级子角色
   public function getParentAndChildren(){
        $all = $this->findAll();
        $first=array();
        $second=array();
        //找到第一级菜单
        foreach($all as $k=>$v){
            if(strlen($v->f_rcode)==1){
                $second[$v->f_rcode]=array();
                $first[$v->f_rcode]=$v->f_rname;
            }
        }
        //找到第二级菜单放入第一级的数组中
        foreach($all as $k=>$v){
            if(strlen($v->f_tcode)==1){
                $second[$v->f_tcode][]=$v;
            }
        }
        $first = $this->_sortArrayKeys($first);
        return array('first'=>$first,'second'=>$second);
   }
   //数组排序 
   function _sortArrayKeys($array){
    $keys = array_keys($array);
    sort($keys);

    $sortedArray = array();
    foreach ($keys as $key) {
        $sortedArray[$key] = $array[$key];
    }

    return $sortedArray;
    }
   /*public function getCode($f_club_item_type) {
        return $this->findAll('f_club_item_type=' . $f_club_item_type);
    }*/

}
