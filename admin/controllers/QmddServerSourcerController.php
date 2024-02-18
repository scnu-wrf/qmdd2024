<?php

class QmddServerSourcerController extends BaseController {
	//protected $project_list = '';
    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$site_envir='',$type='',$site_level='',$state='',$province = '', $city = '', $area = '',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        // $criteria->distinct = true;
		$criteria->condition=get_where_club_project('club_id','');
        $criteria->condition.= ' and state=2';
		$criteria->condition=get_where($criteria->condition,!empty($site_envir),'site_envir',$site_envir,'');
		$criteria->condition=get_where($criteria->condition,!empty($type),'t_typeid',$type,'');
		$criteria->condition=get_where($criteria->condition,!empty($site_level),'site_level',$site_level,'');
		$criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_like($criteria->condition,'t.site_code,site_name,belong_name',$keywords,'');
		$criteria->condition=get_like($criteria->condition,'t.area_province',$province,'');
		if ($province !== '') {
            $criteria->condition.=' AND t.site_address like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }
        if ($city != '') {
            $criteria->condition.=' AND t.site_address like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.site_address like "%' . $area . '%"';
        }
        
        if ($start_date != '') {
            $criteria->condition.=' AND site_date_end>="' . $start_date . '"';
        }

        if ($end_date != '') {
            $criteria->condition.=' AND site_date_end<="' . $end_date . '"';
        }
		$criteria->order = 'id DESC';
		$data = array(); 
        $data['site_envir'] = BaseCode::model()->getCode(667);
		$data['type'] = QmddServerType::model()->getServertype();
		$data['state'] = BaseCode::model()->getCode(370);
		parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['picture'] = array();
            
            $this->render('update', $data);
			
        }else{
            $this-> saveData($model,$_POST[$modelName]);
			
        }
    }

  

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			// 获取项目
			$data['model'] = $model;
			$data['project'] = array();
            $data['project'] = ProjectList::model()->findAll('id in (' . $model->project_ids . ')');
			
			$data['servant'] = array();
            $data['servant'] = ClubQualificationPerson::model()->findAll('id in (' . $model->s_gfid . ')');
			
            if ($model->s_picture != '') {
                $data['picture'] = explode(',', $model->s_picture);
            } else {
				$data['picture'] = array();
			}
            $this->render('update', $data);
            
        } else {
			$this-> saveData($model,$_POST[$modelName],$id);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
		$model->state =get_check_code($_POST['submitType']);
        $st=$model->save();
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }
    
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

}
