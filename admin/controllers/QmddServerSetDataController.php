<?php

class QmddServerSetDataController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$project='', $s_date=''/*,$server_type=''*/) {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $project=empty($project) ? '1' : $project;
        $s_date=empty($s_date) ? date('Y-m') : $s_date;
        $club_id = get_where_club_project('club_id');
        $se_data = $model->find($club_id.' and t_typeid='.$project);
        if(!empty($se_data)){
            $keywords=empty($keywords) ? $se_data->s_name : $keywords;
        }else{
            $keywords=empty($keywords) ? '' : $keywords;
        }
        $criteria = new CDbCriteria;
        $w1= $club_id.' and t_stypeid<>2';
        $w1 = get_where($w1,$project,'t_typeid',$project,"");
        $w1 = get_where($w1,!empty($s_date),'left(s_date,7)',$s_date,"'");
        $criteria->condition = get_like($w1,'s_name',$keywords,"");
        $criteria->order = 'id';
        $data = array();
        $data['project_list']=QmddServerType::model()->findAll();
        $data['nowDate']=$s_date;
        $data['keywords']=$keywords;
        $data['s_type']=$project;
        parent::_list($model, $criteria, 'index', $data,10000);
    }

    // 日安排表
    public function actionDay_index($s_date='',$t_typeid='',$t_stypeid='',$project_id='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $t_typeid=empty($t_typeid) ? '1' : $t_typeid;
        $s_date=empty($s_date) ? date("Y-m-d") : $s_date;
        $project_id=empty($project_id) ? '' :' and find_in_set('.$project_id.',project_ids)';
        $club_id = get_where_club_project('club_id');
        $criteria = new CDbCriteria;
        $w1 = $club_id.' and f_check=2 and t_typeid='.$t_typeid.$project_id;  //  and t_stypeid<>2
        $w1 = get_where($w1,!empty($s_date),'s_date',$s_date,'"');
        $criteria->condition= get_where($w1,!empty($t_stypeid),'t_stypeid',$t_stypeid,'');
        $site_type = ($t_typeid==1) ? ',site_type' : '';
        $criteria->order = 'LPAD(s_name,100,0),club_id,s_gfid'.$site_type;//防止s_name字段出现编号为10的排序在1前面或后面，添加LPAD在字段前填充字符“100”
        $data = array();
        $data['t_typeid']=QmddServerType::model()->findAll();
        $data['project_list'] = ClubProject::model()->findAll($club_id.' and project_state=506 and auth_state=461 and state=2 and free_state_Id=1202');
        // $data['server_type']=BaseCode::model()->getCode(519);
        $data['nowDate'] = $s_date;
        $data['s_type'] = $t_typeid;
        $data['condition'] = $criteria->condition;
        parent::_list($model, $criteria, 'day_index', $data);
    }

    // 服务安排管理-服务者
    public function actionIndex_replace($keywords = '', $project_id='', $s_date='', $t_typeid='', $t_stypeid=''/*, $server_type=''*/) {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $t_typeid=empty($t_typeid) ? '1' : $t_typeid;
        $s_date=empty($s_date) ? date("Y-m-d") : $s_date;
        $project_id = !empty($project_id) ? ' and find_in_set('.$project_id.',project_ids)' : '';
        $club_id = get_where_club_project('club_id');
        $criteria = new CDbCriteria;
        $w1 = $club_id.' and f_check=2 and t_typeid='.$t_typeid.$project_id;  
        $w1 = get_where($w1,!empty($s_date),'s_date',$s_date,'"');
        $criteria->condition = get_where($w1,!empty($t_stypeid),'t_stypeid',$t_stypeid,'');
        $site_type = ($t_typeid==1) ? ',site_type' : '';
        $criteria->order = 'LPAD(s_name,100,0),club_id,s_gfid'.$site_type;//防止s_name字段出现编号为10的排序在1前面或后面，添加LPAD在字段前填充字符“100”
        $data = array();
        $data['t_typeid']=QmddServerType::model()->findAll();
        $data['project_list'] = ClubProject::model()->findAll($club_id.' and project_state=506 and auth_state=461 and state=2 and free_state_Id=1202 ');
        // $data['server_type']=BaseCode::model()->getCode(519);
        $data['nowDate'] = $s_date;
        $data['s_type'] = $t_typeid;
        $data['condition'] = $criteria->condition;
        parent::_list($model, $criteria, 'index_replace', $data);
    }

    // 日服务查询
    public function actionIndex_server_day($t_typeid='',$s_date='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $s_date = empty($s_date) ? date("Y-m-d") : $s_date;
        $criteria = new CDbCriteria;
        $w1 = get_where_club_project('club_id');
        $w1 = get_where($w1,!empty($t_typeid),'t_typeid',$t_typeid,'');
        $criteria->condition = get_where($w1,!empty($s_date),'s_date',$s_date,'"');
        $site_type = ($t_typeid==1) ? ',site_type' : '';
       // 同单位会有多个资源，所以分组不能用club_id
        $criteria->order = 'LPAD(s_name,100,0),club_id,s_gfid'.$site_type;//防止s_name字段出现编号为10的排序在1前面或后面，添加LPAD在字段前填充字符“100”
        $data = array();
        $data['nowDate'] = $s_date;
        $data['condition'] = $criteria->condition;
        $data['t_typeid'] = QmddServerType::model()->findAll('if_user=1');
        parent::_list($model, $criteria, 'index_server_day', $data);
    }

    // 月服务查询
    public function actionIndex_server_month($t_typeid='',$s_name='',$s_date='') {
        set_cookie('_currentUrl_',Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $s_date = empty($s_date) ? date("Y-m") : $s_date;
        $criteria = new CDbCriteria;
        $club_id = get_where_club_project('club_id');
        $t_typeid = empty($t_typeid) ? 1 : $t_typeid;
        $se_data = $model->find($club_id.' and t_typeid='.$t_typeid);
        if(!empty($se_data)){
            $s_name = empty($s_name) ? $se_data->s_name : $s_name;
        }
        $w1 = $club_id;
        $w1 = get_where($w1,!empty($t_typeid),'t_typeid',$t_typeid,'');
        $w1 = get_where($w1,!empty($s_date),'left(s_date,7)=',$s_date,'"');
        $criteria->condition = get_where($w1,!empty($s_name),'s_name',$s_name,'"');
        $data = array();
        $data['nowDate'] = $s_date;
        $data['condition'] = $criteria->condition;
        $data['t_typeid'] = $t_typeid;
        $data['s_name'] = $s_name;
        $data['type_list'] = QmddServerType::model()->findAll('if_user=649 and if_del=510');
        parent::_list($model, $criteria, 'index_server_month', $data, 1000);
    }

    // 设置每日服务安排 开启|关闭
    public function actionSave_server_detail($id,$down){
        $len = QmddServerSetData::model()->updateAll(array('down'=>$down),'id in('.$id.')');
        show_status($len,'设置成功', Yii::app()->request->urlReferrer,'设置失败');
    }
  public function actionCreate() {   
       $this-> viewUpdate(0);
   } 

   public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }/*曾老师保留部份，---结束*/
  
  public function viewUpdate($id=0) {
        $modelName = $this->model;
        $model = ($id==0) ? new $modelName('create') : $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
           $this->render('update', $data);
        } else {
           $this-> saveData($model,$_POST[$modelName]);
        }
    }/*曾老师保留部份，---结束*/
  
    function saveData($model,$post) {
        $model->attributes = $post;
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll('id in(' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

    // 获取服务类别
    public function actionGetUserType($type_id){
        $w1="t_server_type_id=".$type_id;
        $tmp = QmddServerUsertype::model()->findAll($w1." and f_member_type<>261");
        $data = toIoArray($tmp,'id,f_uname');
        echo CJSON::encode($data);
    }

    public function actionGetDetails($id){
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $s1='s_name,order_project_name,s_timename,info_order_num';
        $s1.=',order_num,order_account,order_name';
        $data=recToArray($model,$s1);
        echo CJSON::encode($data);
    }

    public function actionGetList(){
        $modelName = $this->model;
        $cr= new CDbCriteria;
        $cr->select="name,price,place,distance";
        //name: '海珠区羽毛球馆B',  price: 180, place: '广东省广州市海珠区羽毛球馆', distance:
       // $cr->distinct=true;
        $model = $modelName::model()->findAll();
        $s1='s_name,order_project_name,s_timename,info_order_num';
        $s1.=',order_num,order_account,order_name';
        $data=recToArray($model,$s1);
        echo CJSON::encode($data);
    }
}