<?php

class GfUserSigninController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$start_date='',$end_date='',$order_type='',$server_sourcer='',$project_id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where($criteria->condition,!empty($order_type),'type',$order_type,'');
        $criteria->condition=get_where($criteria->condition,!empty($server_sourcer),'service_data_id',$server_sourcer,'');
        $criteria->condition=get_where($criteria->condition,!empty($project_id),'service_data_id',$project_id,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'sign_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'sign_time<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'news_title,news_code,club_names',$keywords,'');//get_where
        $criteria->order = 'id DESC';
        $data = array();
        $data['order_type'] = BaseCode::model()->getCode(350);
		$data['project_id'] = ProjectList::model()->getAll();
		$data['server_sourcer'] = QmddServerSourcer::model()->findAll('state=2');
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $basepath = BasePath::model()->getPath(189);
            // $model->news_content_temp=get_html($basepath->F_WWWPATH.$model->news_content, $basepath);
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
  
    function saveData($model,$post) {
        $model->attributes =$post;
        $model->state = get_check_code($_POST['submitType']);
        $sv=$model->save();
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
    }

    public function actionSignin($id) {
        $sign = GfUserSignin::model()->find('id='.$id);
        // ajax_status(0,'验证码错误');
        // ajax_status(1,'签到成功',Yii::app()->request->urlReferrer);
    }

    // public function actionDelete($id) {
    //     parent::_clear($id);
    // }
    //逻辑删除
    // public function actionDelete($id) {
    //     $modelName = $this->model;
    //     $model = $modelName::model();
	// 	$club=explode(',', $id);
    //     $count=0;
	// 	foreach ($club as $d) {
	// 		$model->updateByPk($d,array('if_del'=>507));
	// 		$count++;
	// 	}
    //     if ($count > 0) {
    //         ajax_status(1, '删除成功');
    //     } else {
    //         ajax_status(0, '删除失败');
    //     }
    // }
}
