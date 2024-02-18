<?php

class QualificationsRenewalController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

	
	public function actionIndex($sex='',$project='',$type='',$identity='',$type_code='',$is_pay='',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_where($criteria->condition,!empty($sex),'sex',$sex,'');
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_where($criteria->condition,!empty($type),'qualification_type_id',$type,'');
        $criteria->condition=get_where($criteria->condition,!empty($identity),'identity_num',$identity,'');
        $criteria->condition=get_where($criteria->condition,!empty($type_code),'qualification_level',$type_code,'');
        $criteria->condition=get_where($criteria->condition,!empty($is_pay),'is_pay',$is_pay,'');
		$criteria->condition=get_like($criteria->condition,'project_name',$keywords,'');
        $criteria->order = 'id DESC';
		$data = array();
		// $data['project'] = ClubProject::model()->getClubProject2(get_session('club_id'));
        $data['project'] = ProjectList::model()->getProject();
		$data['type'] = BaseCode::model()->getCode(383);
		$data['sex'] = BaseCode::model()->getSex();
		$data['identity'] = BaseCode::model()->findAll('F_TCODE="WAITER" AND fater_id<>383');
        $data['type_code'] = MemberCard::model()->getServicLevel();
		$data['is_pay'] = BaseCode::model()->getReturn('463,464');
        parent::_list($model, $criteria, 'index', $data);
    }
    
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $data = array();
        if(!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes = $post;
        $model->check_state = get_check_code($_POST['submitType']);
        $b = BaseCode::model()->find('f_id='.get_check_code($_POST['submitType']));
        $model->check_state_name=$b->F_NAME;
        $sv = $model->save();
        show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }
	
	//逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
        $count=0;
		foreach ($club as $d) {
			$qclub=$model->find('id='.$d);
			$model->deleteAll('id='.$d);
			QualificationInvite::model()->deleteAll('id='.$qclub->invite_id);
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

}