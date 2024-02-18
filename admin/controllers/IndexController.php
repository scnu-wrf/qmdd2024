<?php

class IndexController extends BaseController {
    protected $model = '';
    public $layout = false;
    public $signin=false;

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
      }

    public function actionIndex() {

      if (empty($_SESSION['admin_id'])||(!isset($_SESSION['club_name'])) ) {
          $this->login_form();
        }
        else {
            $model = new QmddAdministrators('create');
        $s1='index';
        $data = Language::model()->getSwitch();
        $data['model'] = $model;
        $data['cp_home'] = '管理中心';

         $this->render('index',$data);
         }
    }

 public function actionTop(){
      $data = Language::model()->getSwitch();
      $model = new QmddAdministrators('create');
      $data['model'] = $model;
      $data['cp_home'] = '管理中心';
      $data['club_name'] = $_SESSION['club_name'] ;
      $data['app_name'] = '运动预约系统' ;
      $data['gfaccount']=$_SESSION['gfaccount'];
      $data['gfnick']=$_SESSION['gfnick'];
      $data['admin_id']=$_SESSION['gfnick'];
      $data['nav_list']=MainMenu::model()->findAll('f_show=1 order by f_code');
      $this->render('top',$data);  
  }
 public function actionDrag(){
     return '';  
  }
public function actionMenu($type='A'){
   $model = new QmddAdministrators('create');
    $data = array();
   $data['model'] = $model;
    $data['target'] ='_blank';
    $slvl=get_session('level');
    $menu =Menu::model()->getNewmenu($slvl,'',$type);
    $data['menus']=  $menu ;
   $this->render('menu',$data); 
    
}
  public function actionStart(){
    $model = new QmddAdministrators('create');
    $data = array();
    $data['model'] = $model;
    $data['target'] ='_blank';
    $data['admin_msg']=array();
    $data['today']=array('money'=>0,'order'=>0,'user'=>0,'visit'=>0);
    $data['order']=array('unconfirmed'=>0,'await_pay'=>0,'await_ship'=>0,
      'finished'=>0,'booking_goods'=>0,'shipped_part'=>0,'new_repay'=>0);
    $data['status']=$data['order'];
    $data['thismonth']=date("m");
    $this->render('start',$data);  
  }

  public function actionLogin(){
       $this->login_form();
    }

  public function actionLogout(){
       $this->login_form();
    }

    function login_form(){
        $model = new QmddAdministrators('create');
        $data = Language::model()->getSwitch();
        $data['model'] = $model;
        $data['cp_home'] = '管理中心';
        $data['model'] = $model;
        $data['target'] ='_blank';
        // $this->redirect(array('index/logout','target'=>'_blank'));
        $this->render('Login',$data);  
    }

  /*  验证登陆   */
    function get_signin($user='', $pass='') {
      //$user='2018000094#918974';
      //$pass='123456';
 
      $users = explode("#", $user."#".$user);
      $this->signin=(1==2);
      $gfacc=$users[1];
      $w1="admin_gfaccount ='".$gfacc."' and club_code='";
      $tmp=QmddAdministrators::model()->find($w1.$users[0]."'");
      if(!empty($tmp)){
         ini_set('session.gc_divisor', 1);
         ini_set('session.gc_maxlifetime',  5000000);
         ini_set('session.cookie_lifetime', 1000000);
      //   session.gc_maxlifetime = 86400;
        $clubid=$tmp['club_id'];
        $sid=  session_id();
         session_id($sid);
        $_SESSION['gfnick']=$tmp['admin_gfnick'];
        $_SESSION['gfid']=$tmp['admin_gfid'];//这里为帐号gf_account
        $_SESSION['gfaccount'] =$gfacc;
        $_SESSION['level'] =$tmp['admin_level']; //管理员级别 平台管理员级，普通社区为0.admin_gfnick
        $_SESSION['club_id'] =$clubid;
        $_SESSION['name']= $_SESSION['gfnick'];
        $_SESSION['admin_id']= $tmp['id'];
        $_SESSION['club_name'] =$tmp['club_name'];//$_SESSION['gfnick'];//
        $ec_salt =$tmp['ec_salt'];
        $passmd5 =$this->pass_md5($ec_salt,$pass);
        $this->signin=($passmd5 ==$tmp["password"]);
        $aec='adminid='.$tmp['id'].'&admin_gfid='.$tmp['admin_gfid'].'&admin_gfaccount='.$gfacc;
        $aec.='&admin_name='.$tmp['admin_gfnick'].'&club_id='.$clubid;
       // $aec=ecaes($aec);
        $_SESSION['role_menu']=Menu::model()->get_role_menu($_SESSION['level'], $aec);
       }
       return $this->signin;
    }

    public function actionCheckuser() {
      $usercode="0";//
      Yii::app()->session['admin_id']=null;
      Yii::app()->session['admin']=0;
      $data = array();
      $data['TUNAME']="";
      if (isset($_REQUEST['TUNAME'])) { $usercode=$_REQUEST['TUNAME'];};
      if ($this-> get_signin($usercode,$_REQUEST['PASSWORD'])){
        $data['TUNAME']=$usercode;
        $data['menu']=$_SESSION['role_menu'];
      }   
 
      echo CJSON::encode($data);
    }


    function pass_md5($ec_salt,$pass){  
      return empty( $ec_salt ) ? md5( $pass ) : md5( md5( $pass ) . $ec_salt );
    }

  
   function add_chose($p1,$p2,$p3){
    $da2=explode('|',$p2);
    for($i = 0 ; $i < count($da2);$i++){
         $c=$da2[$i];
         $this->role_code.=','.$c.$p3;
         if ($this-> indexof($p1.',',','.$c.',')<0)  $p1.=','.$c;
        }
    return  $p1;

   }

    function get_oper($pid,$p2){
     return  $this-> indexof($this->role_code,$pid.$p2)>=0;
    }


    function get_user_code($user,$r=1) {
        $users = explode("#",$user."#");
        return $users[$r];              
    }
}
