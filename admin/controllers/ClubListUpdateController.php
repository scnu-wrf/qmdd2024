<?php

class ClubListUpdateController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    ///列表搜索
     public function actionIndex($state = '', $type = '', $province = '', $city = '', $area = '', $start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where('if_del=510',!empty($state),' state',$state,''); 
        $criteria->condition=get_where($criteria->condition,!empty($type),' partnership_type',$type,''); 

        if ($province !== '') {
            $criteria->condition.=' AND t.club_address like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND t.club_address like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.club_address like "%' . $area . '%"';
        }
		$criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'apply_time<=',$end_date,'"');
		$criteria->condition=get_like($criteria->condition,'club_name,club_code',$keywords,'');

        $criteria->order = 'id DESC';
        $data = array();
        $data['base_code'] = BaseCode::model()->getCode(370);
        $data['partnertype'] = BaseCode::model()->getClub_type2_all();
        

        parent::_list($model, $criteria, 'index', $data);
    }
    
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['management_category'] = array();
			$data['club_list_pic'] = array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST);
			
        }
		
    }
        
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
		
        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(123);
        $model->about_me_temp=get_html($basepath->F_WWWPATH.$model->about_me, $basepath);
            $data['model'] = $model;
            // 获取经营类目
            if (!empty($model->management_category)) {
                $data['management_category'] = AutoFilterSet::model()->findAll('id in (' . $model->management_category . ')');
            } else {
                $data['management_category'] = array();
            }
			$data['club_list_pic'] =ClubListPic::model()->findall('club_id='.$model->id);
            $this->render('update', $data);
            
        } else {
			$this-> saveData($model,$_POST);
        }
    }
	
	function saveData($model,$post) {
       $modelName = $this->model;
       $model->attributes = $_POST[$modelName];
		if ($_POST['submitType'] == 'shenhe') {
			$model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
       $st=$model->save();
       $errors = array();
      if ($st) {
                ClubListPic::model()->deleteAll('club_id=' . $model->id);
                // 保存图集
                if(isset($_POST[$modelName]['club_list_pic'])){
                $model2 = new ClubListPic();
                $club_list_pic = array();
                $club_list_pic = explode(',', $_POST[$modelName]['club_list_pic']);
                $club_list_pic = array_unique($club_list_pic);
                foreach ($club_list_pic as $v) {
                    $model2->isNewRecord = true;
                    unset($model2->id);
                    $model2->club_id = $model->id;
                    $model2->club_aualifications_pic = $v;
                    $model2->save();
                }
        }
	  }
	  show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
 }

	
//逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
        $count=0;
		foreach ($club as $d) {
			$model->updateByPk($d,array('if_del'=>509));
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }            

}

 

