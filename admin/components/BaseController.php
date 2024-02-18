<?php
class BaseController extends CController {

    public $layout = '//layouts/main';

    //public $menu = array();
    //public $breadcrumbs = array();
    public function init() {
        //$this->checkLogin();
        parent::init();
        // 模拟个人登录信息
        $session = array(
            'captcha_word' => 'MzBkZjQzNDAzYQ==',
            'supplier' => 0,
            'datagrid_style_color' => 'gray',
            'action_list' => null,
            'last_check' => '0000-00-00 00:00:00',
            'lang_type' => '1',
            'admin_level' => 0,
            'shop_guide' => false,
            'user_id' => '0',
            'admin_id' => null,
            'user_rank' => '0',
            'discount' => '0.00',
            'email' => '0',);
        if (!isset(Yii::app()->session['admin_id'])) {
         $this->_setSession($session);
        }
        $this->_setSession($session);
    }

    // 基础创建方法
    protected function _setSession($psession) {
        if(isset($psession)){
             foreach ($psession as $k => $v) {
                if (!isset(Yii::app()->session[$k])){
                Yii::app()->session[$k] = $v;}
            }
        }   
    }
        // 基础创建方法
    protected function _check_model($model = null) {
        if ($model === null) {
            ajax_status(0, '没有数据或数据已禁用');
        }
    }

// 基础创建方法
function _setCondition($model, $cr,$data,$pSize) {
 Yii::app()->session["_set00"] =array($model,$cr,$data,$pSize);
}
public function get_listData($model,$criteria,$data,$pageSize,$template=''){
    $pps=get_session('pageSize');
    $pageSize=(!empty($pps)) ?$pps :$pageSize;
    $pm=get_session('pageMode');
    if(!empty($template)){
     $pm1= get_class ($model).$template;
     $pn=$pageSize;
     $b1=($pn==15||$pn==20||$pn==30||$pn==50||$pn==100); 
     if(!($pm==$pm1)||($pm=='0')||(!$b1) ){
        $pageSize=15;
        set_session('pageSize',15);
        set_session('pageMode',$pm1);
      }
    }
    $this->_check_model($model);
    $count = $model->count($criteria);
    $pages = new CPagination($count);
    $pages->pageSize = $pageSize;
    $pages->applylimit($criteria);
    $ast = $model->findAll($criteria);
    $ds=array('model'=>$model,'arclist'=>$ast,'pages'=>$pages,'count'=>$count);
    $data = array_merge($data, $ds);  
    return $data;
}

    // 基础创建方法
protected function _create($model=null,$tpl='create',$data=array(),$redirect=''){
    setGetValue("html_file",$tpl);
    if ($model === null) {
        ajax_status(0, '没有数据或数据已禁用');
    }
    $modelName = $this->model;
    $this->saveDataMsg($model,$modelName,$data,$tpl,'添加成功',$redirect);
}

    // 保存数据处理
protected function saveDataMsg($model,$modelName,$data,$tpl,$pmsg,$redirect) {
    setGetValue("html_file",$tpl);
   if (Yii::app()->request->isPostRequest && isset($_POST[$modelName])) {
        $model->attributes = $_POST[$modelName];
        if ($model->save()) {
            ajax_status(1, '更新成功', $redirect);
        } else {
            $msg =$this->getShowMsg($model->getErrors());
            ajax_status(0, $msg);
        }
    } else {
        $data = array_merge($data, array('model' => $model));
        $this->render($tpl, $data);
    }
}


    // 获取错误信息
    protected function getShowMsg($pmsgs) {
        $msg = '';
        foreach ($pmsgs as $v) {
            foreach ($v as $v2) {
                $msg .= '<p>' . $v2 . '</p>';
            }
        }
        return  $msg;
    }

    // 基础更新方法
    protected function _update($model = null, $tpl = 'update', $data = array(), $redirect = '') {
        setGetValue("html_file",$tpl);
        if ($model === null) {
            ajax_status(0, '没有数据或数据已禁用');
        }
        $modelName = get_class($model);
       $this->saveDataMsg($model,$modelName,$data,$tpl,'更新成功',$redirect);
    }

 // 单字段基础更新方法
 protected function _setField($id,$model=null,$k='',$v=''){
        if ($model === null) {
          ajax_status(0,'没有数据或数据已禁用');
        }
        $model->$k = $v;
        $rs = $model->save();
        if ($rs !== false){
           ajax_status(1,'更新成功');
        }else{
           ajax_status(0,'更新失败');
        }
    }
    // 基础更改状态方法
    protected function _status($id, $status = 0) {
        if (!in_array($status, array(0, 1))) {
            ajax_status(0, '非法数据');
        }
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $yid=Yii::app()->controller->id;
        if (in_array($yid, array('article', 'singlepage'))) {
            $this->checkColumnAccess($model->column_id);
        }
        $this->_setField($id, $model, 'status', $status);
    }



    // 基础更改状态方法
    protected function _recommend($id, $status = 0) {
        if (!in_array($status, array(0, 1))) {
            ajax_status(0, '非法数据');
        }
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (in_array(Yii::app()->controller->id, array('article', 'singlepage'))) {
            $this->checkColumnAccess($model->column_id);
        }

        $this->_setField($id, $model, 'recommend', $status);
    }

    // 基础更改排序方法
    protected function _sortid($id, $sortid = 0) {
        $sortid = intval($sortid);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (in_array(Yii::app()->controller->id, array('article', 'singlepage'))) {
            $this->checkColumnAccess($model->column_id);
        }

        $this->_setField($id, $model, 'sortid', $sortid);
    }
 
    // 基础伪删除方法
    protected function _delete($id, $del = 509, $redirect = '') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id in(' . $id . ')';
        $count = $model->updateAll(array('if_del' => $del), $criteria);
        if ($count > 0) {
            ajax_status(1, '删除成功', $redirect);
        } else {
            ajax_status(0, '删除失败');
        }
    }

    // 基础删除方法
    protected function _clear($id, $redirect = '',$keyname='id') {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll($keyname.' in (' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功', $redirect);
        } else {
            ajax_status(0, '删除失败');
        }
    }
    

    //主从基础创建方法
    protected function _creates($model = null, $tpl = 'create', $data = array(), $redirect = '', $archiveName = 'Archive') {
        if ($model === null) {
            ajax_status(0, '没有数据或数据已禁用');
        }
        setGetValue("html_file",$tpl);
        $archive = new $archiveName('create');

        if (Yii::app()->request->isPostRequest && isset($_POST[$archiveName])) {
            $archive->attributes = $_POST[$archiveName];
            if (!$archive->save()) {
                ajax_status(0, '添加失败1');
            }
            $modelName = get_class($model);
            $model->attributes = $_POST[$modelName];
            $model->archive_id = $archive->id;
            $model->sub_column_id = $archive->sub_column_id;
            if ($model->save()) {
                ajax_status(1, '添加成功', $redirect);
            } else {
                $archive->delete();
                ajax_status(0, '添加失败');
            }
        } else {
            $archive->status = 1;
            $data = array_merge($data, array('archive' => $archive), array('model' => $model));
            $this->render($tpl, $data);
        }
    }

    // 主从基础更新方法
    protected function _updates($model = null, $tpl = 'update', $data = array(), $redirect = '', $archiveName = 'Archive') {
        setGetValue("html_file",$tpl);
        if ($model === null) {
            ajax_status(0, '没有数据或数据已禁用');
        }
        $archive = $archiveName::model()->findByPk($model->archive_id);
        //dump($archive);exit;
        if (Yii::app()->request->isPostRequest && isset($_POST[$archiveName])) {
            $archive->attributes = $_POST[$archiveName];
            if (!$archive->save()) {
                ajax_status(0, '更新失败');
            }
            $modelName = get_class($model);
            $model->attributes = $_POST[$modelName];
            $model->archive_id = $archive->id;
            $model->sub_column_id = $archive->sub_column_id;
            if ($model->save()) {
                ajax_status(1, '更新成功', $redirect);
            } else {
                ajax_status(0, '更新失败');
            }
        } else {
            $data = array_merge($data, array('model' => $model, 'archive' => $archive,));
            $this->render($tpl, $data);
        }
    }

    // 加载模型
    protected function loadModel($id, $modelName, $criteria = null) {
        if ($criteria === null) {
            $model = $modelName::model()->findByPk($id);
        } else {
            $model = $modelName::model()->find($criteria);
        }
        return $model;
    }

    function getPstr($p1,$p2){
      $rs=($p1==$p2) ? 'selected="selected"' :'' ;
      return '<option '.$rs.' value="'.$p1.'">'.$p1.'</option>';
    }

    // 分页控件
    public function page($pages) {
        $pps=get_session('pageSize');
        $pps=(empty($pps)) ? 15 : $pps;
        $s1='<span>显示行:</span>
        <select name="PageSize" onchange="javascript:changPage()" id="PageSize">';
        $s1.=$this->getPstr(15,$pps).$this->getPstr(20,$pps).$this->getPstr(30,$pps);
        $s1.=$this->getPstr(50,$pps).$this->getPstr(100,$pps);
        $s1.='</select></span>';
      //  $s1.=$this->set_Pagesize();
        $pages->pageSize=$pps;
        return $this->widget('CLinkPager', array(
            'pages' => $pages,
            'cssFile' => false,
            'header' => '',
            'footer' => '<div class="info">共' . $pages->getItemCount() . '条内容，当前第' . ($pages->currentPage + 1) . '/' . $pages->pageCount . '页,'.$s1.'</div>'.$this->set_Pagesize(),
            'maxButtonCount' => 5,
            'firstPageLabel' => '首页',
            'prevPageLabel' => '上一页',
            'nextPageLabel' => '下一页',
            'lastPageLabel' => '末页'
        ));
    }

  function set_Pagesize(){
   $rs='<script> function changPage(){';
   $rs.=' var s2 = "'.$this->createUrl("public/setPageSize").'";';
   $rs.=" 
    var options=$('#PageSize option:selected').val(); //获取选中的项
    $.ajax({
        type: 'post', url: s2,
        data: { pageSize: options, },
        dataType: 'json',
        success: function(data) {
 console.log(data);
             document.getElementById('tbody1').innerHTML =data['html'];
//            console.log(data);
        },
        error: function(XMLHttpRequest, textStatus, errorThrown) {
            console.log(XMLHttpRequest);
        }
    });
  }
 </script>";
  return $rs;
}

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'active-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    protected function getOpenid(){
        //获取函数头的token
        $token=$_SERVER['HTTP_TOKEN'];
        Yii::$enableIncludePath = false;
        Yii::import('application.extensions.JWT', 1);
        $jwt=new Jwt;
        //对token进行解码
        $getPayload=$jwt->verifyToken($token);
        return $getPayload['openid'];
    }

    public function beforeAction($action){  
       set_session('no_load','0'); 
       return $this-> checkAccess($action);//角色操作检查
        if (!thisparent::beforeAction($action)) {
            return false;
        }
        if (!parent::beforeAction($action)) {
            return false;
        }
        return true;
    } 

    //安全访问控制：阻止没有操作权限的人通过输入网址来访问无权限内容
 protected function checkAccess($access) {
      $w1=get_session('account');
      $s0=Yii::app()->controller->id;
      setGetValue("html_dir",$s0);
      $s1=$s0.'/'.$access->id;
      return true;
          $tmp=User::model()->getDefaultInfo();
          $rname='no';
          if(!empty($tmp)){
            $rname=$tmp->roleName;
           } 
           $roid=Role::model()->readValue('f_rname="'.$rname.'"','f_opter');
           $w1='UPPER(f_url)="'. strtoupper($s1).'"';
           $uid=Menu::model()->readValue($w1,'id');
           $uid=(empty($uid)) ? '"00"' :'"'.$uid.'"';
           $b1=indexof($roid,$uid);
           $w1='UPPER(f_url) like "'. strtoupper($s0).'/%" and ';
           $w1.="'".$roid."' like CONCAT('%".'"'."',id,'".'"%'."')";
    
           $uid=Menu::model()->readValue($w1,'id');
           $b2=(empty($uid)) ? -1 : 1;
       
           $b3=(($rname=='学生' || $rname=='普通教师'||$rname=='超级管理员')&& ($s0=='exams')) ? 1 : -1;
     
           if ($s0=='index'|| (($b1>=0 || $b2>=0)&&(!($s0=='exams')))|| ($b3>=0) ||(1==1))
          // if(1)
          {
                return true;
          }else if($s0=='pl_news'||$s0=='pl_policy'){
            if ($access->id=='ShowDetail'){
                return true;
            }else{

            echo('对不起，没有操作权限');
            return false;
            }
          }
          else if($s0=='exams'&&$rname=='省级管理员'){
            if($access->id=='indexstu'||$access->id=='indexteacher'){
                return true;
            }else{         
            echo('对不起，没有操作权限');
            return false;
                }
          }
          else if($s0=='pisaexamsdata'||$s0=='pisaexamsquestion'){
          if($rname=='问卷出题专家'){
                return true;
            }else{         
            echo('对不起，没有操作权限');
            return false;
                }
          }
          else{
            echo('对不起，没有操作权限');
            return false;
          }
        return true;
    }
    ///列表搜索
     public function display($modelName, $criteria, $index, $data=array(),$page=15) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = $modelName::model();
        $this->_list($model, $criteria,$index, $data);
    }

    protected function _list($model = null, $criteria = null, $template = 'index',$data = array(), $pageSize = 15) {
        setGetValue("html_file",$template);
        $this->_setCondition($model, $criteria,$data,$pageSize);
        $data=$this->get_listData($model, $criteria,$data,$pageSize,$template);
        $this->render($template, $data);
    }

   ///列表搜索
     public function htmldisplay($modelName, $criteria, $index, $data=array(),$page=15) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $model = $modelName::model();
        set_session("index_cn",$criteria->condition);
        set_session("index_model",$modelName);
        $criteria->condition="1=2";
        setGetValue("html_file",$index);
        $this->_list($model, $criteria,$index, $data);
    }
   ///列表搜索

public function htmlrender($view, $data) {
        set_session("update_model",$date['model']);
        set_session("update_key",$data['update_key']);
        $this->render($view, $data);
    }
//
//$gridset=array(0$index,1$idName,2$hfiels,3$hw,4$cmd);
    // 基础列表方法
    // $data=array(0,'id',$coumnName,'',$cmd);
    // ($thisp,$arclist,$index0,$idname,$coumnName,$cmdstr)
public function getIndexData($modelName=null,$criteria=null,$data=array(),$pageSize = 15) {
     $model=$modelName::model();
     $data0=$this->get_listData($model, $criteria,array(),$pageSize);
     $alist=$data0['arclist'];
     $id=$data['keyid'];$kname=$data['keyname'];$cmd=$data['keycmd'];
     $rs=BaseLib::model()->indexGridRowsHtml($modelName,$alist,'0',$id,$kname,$cmd);
    return $rs;
}

public function actionIndexData($keyname=''){
       $criteria=new CDbCriteria;
       $criteria->condition='1';//get_session("index_cn");
       $modelname='goodstype';//get_session("index_model");
       $ds=$_POST;
   put_msg('468==');
       $data=$this->getIndexData($modelname,$criteria,$ds);//basecontrol
       hsYii_json_encode(array('code'=>'ok','html'=>$data));
    }


//tableInput($form,$m,$INPUTstr,$tr="1") 
public function getUpdateData() {
    $ds=$_POST;
    $keys=get_session("update_key");
    $modelName=$keys[2];
    $id=$keys[1]; 
    $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
    $cmd=$ds['keycmd'];
    $thisv=$modelName.'Controller';
    $thisv=new $thisv(); 
    $form=$thisv->beginWidget('CActiveForm', get_form_list());
    $rs=BaseLib::model()->tableInput($form, $model,$cmd);
    return $rs;
}
    
  public function actionUpdateData($keyname=''){
    $data=$this->getUpdateData();//basecontrol
    hsYii_json_encode(array('code'=>'ok','html'=>$data));
   }

}
