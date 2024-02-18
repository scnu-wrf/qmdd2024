<?php 

class ClubStoreDemandController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$project = '', $state = '', $type_code = '', $province = '', $city = '', $area = '', $start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('club_service_detailed');
        $criteria->condition = 'service_no=1 AND service_type=520';
        // 社区单位只展示已审核通过状态并未确认的信息
        $club_id = ClubList::model()->find('id='.get_session('club_id'));
        if($club_id->partnership_type==16){
            $criteria->condition.=' AND state=2';
        }
        if($project != '') {
            $criteria->condition.=' AND t.project_id = ' . $project;
        }
        if($state != '') {
            $criteria->condition.=' AND t.state = ' . $state;
        }
        if($type_code != '') {
            $arr = array();
            $arr[] = $type_code;
            $subitem = MallProductsTypeSname::model()->getCode($type_code);
            foreach($subitem as $v) {
                $arr[] = $v->id;
            }
            $criteria->condition.=' AND t.type_code in (' . implode(',' ,$arr) . ')';
        }
        if ($province !== '') {
            $criteria->condition.=' AND t.area like "%' . $province . '%"';
        }
        if($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }
        if($city != '') {
            $criteria->condition.= ' AND t.area like "%' . $city . '%"';
        }
        if($area != '') {
            $criteria->condition.= ' AND t.area like "%' . $area . '%"';
        }
        if($start_date != '' || $end_date != '') {
            $date_where = '';
            if($start_date != '') {
                $date_where.= ' AND club_service_detailed.service_date >= "' . $start_date . '"';
            }
            if($end_date != '') {
                $date_where.= ' AND club_service_detailed.service_date <= "' . $end_date . '"';
            }
            $criteria->condition.= ' AND exists(SELECT * FROM club_service_detailed WHERE club_service_detailed.club_service_detailed.service_code=t.service_code' . $date_where . ')';
        }
        $criteria->condition=get_like($criteria->condition,'t.service_code,t.title',$keywords,'');//get_where
        $criteria->order = 'id';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        $data['base_code'] = BaseCode::model()->getCode(370);
        $data['type_code'] = MallProductsTypeSname::model()->getCode(173);
        $data['data_id'] = array();
        $dataid = GfSite::model()->findAll();
        foreach($dataid as $v) {
            $data['data_id'][$v->id] = $v->id;
        }
        parent::_list($model, $criteria, 'index', $data);
    }

    // public function actionCreate() {
    //     $modelName = $this->model;
    //     $model = new $modelName('create');
    //     $data = array();
    //     $model->service_type = 520;
    //     if(!Yii::app()->request->isPostRequest) {
    //         $model->type_code = '';
    //         $data['model'] = $model;
    //         $data['service_pic_img'] = array();
    //         $this->render('create', $data);
    //     }
    //     else {
    //         $this-> saveData($model,$_POST[$modelName]);
    //     }
    // }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if($model->service_no == 2) {
            $this->render('//public/error', array('message' => '赛事服务请在服务序号1中编辑'));
            exit;
        }
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $malltype = MallProductsTypeSname::model();
            $rs = $malltype->getCode(173);
            $arr = array();
            foreach($rs as $v) {
                $arr[] = $v->id;
            }
            $type_code = $malltype->getParentInArr($model->type_code, $arr);
            $model->type_code = $type_code;
            $data['service_pic_img'] = array();
            if(!empty($model->service_pic_img != '')) {
                $data['service_pic_img'] = explode(',', $model->service_pic_img);
            }
            
            // 获取场地
            $data['timelist'] = ClubServiceDetailed::model()->findAll('service_code="' . $model->service_code . '"');
            if(!empty($model->data_id)) {
                $data['data_id'] = GfSite::model()->findAll('id in (' . $model->data_id . ')');
            }
            // else {
            //     $data['data_id'] = array();
            // }

            // 获取reply
            $data['clubStore_id'] = ClubServiceReply::model()->findAll('order_detail_code="' . $model->service_code . '"');
            
            // 获取单位星级
            if(!empty($model->club_id)){
                $data['club_project'] = ClubProject::model()->find('club_id='.$model->club_id.' AND project_id='.$model->project_id);
            }
            $this->render('update', $data);
        }
        else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        $model->state = get_check_code($model->state);
        $sv=$model->save();
        // if($sv) {
        //     // 先删除再保存
        //     // ClubServiceReply::model()->deleteAll('order_detail_code=' . $model->service_code);
        //     // 保存时间信息到“ClubServiceReply”表
        //     $clubReply = new ClubServiceReply;
        //     $clubReply->isNewRecord = true;
        //     unset($clubReply->id);
        //     $clubReply->order_detail_code = $model->service_code;
        //     $clubReply->reply_service_datailed_id = $model->club_reply;
        //     $clubReply->save();
        // }
        show_status($sv,'保存成功'/*,get_cookie('_currentUrl_'),'保存失败'*/);
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

    // 查看
    public function actionLoo($loo_id) {
        $model = ClubServiceReply::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'id=' . $loo_id ;
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'loo', $data);
    }

    // 撤销
    public function actionDeleteclubStore($id) {
        $count = ClubServiceReply::model()->deleteAll('id in(' . $id . ')');
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }

    public function actionReply($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        //$time_list_deta1 = ClubServiceReply::model();
        $service_code = $_POST['service_code'];
		$datailed_id= $_POST['datailed_id'];
        if(isset($service_code) && isset($datailed_id)) {
            $time_list_deta = new ClubServiceReply();
            $time_list_deta->isNewRecord = true;
            unset($time_list_deta->id);
            $time_list_deta->order_detail_code = $service_code;
            $time_list_deta->reply_service_datailed_id = $datailed_id;
            $time_list_deta->save();
            ajax_status(1, '申请成功',Yii::app()->request->urlReferrer);
        } else {
            ajax_status(0, '申请失败');
        }
    }

    public function actionReply_copy($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if(!empty($_POST['time_list'])){
            foreach($_POST['time_list'] as $v){
                // if($v['id'] == 'null'){
                //     $reply_copy = new ClubServiceReply;
                //     $reply_copy->isNewRecord = true;
                //     unset($reply_copy->id);
                // }
                // else{
                //     $reply_copy = ClubServiceReply::model()->find('order_detail_code='.$model->service_code);
                // }
                // $reply_copy->reply_service_id = $id;
                // $reply_copy->reply_service_name = $model->title;
                // $reply_copy->order_detail_code = $v['code'];
                // $reply_copy->apply_club_id = $v['clubid'];
                // $reply_copy->reply_project_id = $v['projectid'];
                // $reply_copy->save();
            }
        }
    }

}