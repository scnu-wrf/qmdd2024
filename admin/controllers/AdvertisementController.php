<?php

class AdvertisementController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($type = '', $club = '', $state = '', $online = '', $start_date = '', $end_date = '', $keywords = '', $sorttype = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        //$criteria->with = array('advertisement_project', 'club_list');
		
		$criteria->join = "JOIN advertisement_project on t.id=advertisement_project.adv_id";
        //获得登录人员使用的社区和项目 =get_where_club_project（社区属性，项目属性）
        $criteria->condition=get_where_club_project('club_id','advertisement_project.project_id');
		$criteria->condition.=' AND ADVER_PID is NULL';
		$criteria->condition=get_where($criteria->condition,!empty($type),' advertisement_type',$type,''); 
		$criteria->condition=get_like($criteria->condition,'club_name',$club,'');
		$criteria->condition=get_where($criteria->condition,!empty($state),' t.state',$state,'');  
        if ($start_date != '') {
            $criteria->condition.=' AND ADVER_DATE_START>"' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND ADVER_DATE_START<"' . $end_date . '"';
        }
		$criteria->condition=get_where($criteria->condition,!empty($online),' ADVER_STATE',$online,'');  
		$criteria->condition=get_like($criteria->condition,'ADVER_TITLE,adver_code',$keywords,'');

//        if (Yii::app()->session['club_id'] != 1) {
//            $criteria->condition.=' AND club_id=' . Yii::app()->session['club_id'];
//        }
//        $todayDate = date('Y-m-d');
//        $criteria->select = '*,(ADVER_DATE_START<"' . $todayDate . '" AND ADVER_DATE_END>"' . $todayDate . '") as s1';
//        $criteria->order = 's1 ASC,ADVER_STATE DESC, advertisement_number DESC';
        if ($sorttype != '') {
            $todayDate = date('Y-m-d H:i:s');
            $criteria->select = '*,(ADVER_DATE_START<"' . $todayDate . '" AND ADVER_DATE_END>"' . $todayDate . '" AND t.ADVER_STATE=1 AND t.state=2) as select_id';
            $criteria->order .= 'select_id DESC,advertisement_number DESC,';
        }
		$criteria->group='t.id';
        $criteria->order = 't.id DESC';
		
        $data = array();
        $data['adver_name'] = AdverName::model()->findAll();
        //dump($data['adver_name']);exit;
        $data['base_code'] = BaseCode::model()->getCode(370);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['project_list'] = ProjectList::model()->getAll();
            $data['model'] = $model;
			$data['sub_product_list'] = array();
			$data['sub_product_list2'] = array();
            $this->render('create', $data);
        } else {
            //dump($_POST);exit;
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
            if ($model->advertisement_type == 5) {
                $model->ADVER_URL_ID = 3;
            }
			$sv=$model->save();
            if ($sv) {
                $pid = $model->id;
                // 广告关联项目添加
                $this->save_project_list($model->id,$_POST[$modelName]['project_list']);

                // 跳转类型为赛事馆二级商品
                if (!empty($_POST['sub_product_list'])) {
                    $model->deleteAll('ADVER_PID=' . $pid .' AND advertisement_type=16');
                    foreach ($_POST['sub_product_list'] as $k => $v) {
                        $model->isNewRecord = true;
                        unset($model->id);
                        $model->advertisement_type = 16;
                        $model->ADVER_URL_ID = 16;
                        $model->ADVER_WHERE = $k;
                        $model->ADVER_PID = $pid;
                        $model->ADVER_TITLE = $v['title'];
                        $model->advertisement_pic = $v['pic'];
                        $model->save();
                    }
                }
				
				if (!empty($_POST['sub_product_list2'])) {
                    $model->deleteAll('ADVER_PID=' . $pid .' AND advertisement_type=17');
                    foreach ($_POST['sub_product_list2'] as $k => $v) {
                        $model->isNewRecord = true;
                        unset($model->id);
                        $model->advertisement_type = 17;
                        $model->ADVER_URL_ID = 16;
                        $model->ADVER_WHERE = $k;
                        $model->ADVER_PID = $pid;
                        $model->ADVER_TITLE = $v['title'];
                        $model->advertisement_pic = $v['pic'];
                        $model->save();
                    }
                }
				$this->save_gfmaterial($old_pic,$model->advertisement_pic,$model->ADVER_TITLE);
                ajax_status(1, '添加成功', get_cookie('_currentUrl_'));
            } else {
                ajax_status(0, '添加失败');
            }
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->advertisement_pic;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {           
            $data['model'] = $model;
			$data['project_list'] = AdvertisementProject::model()->findAll('adv_id='.$model->id);
            $data['sub_product_list'] = array();
			$data['sub_product_list2'] = array();
            if ($model->advertisement_type == 5) {
                $data['sub_product_list'] = $model->findAll('ADVER_PID=' . $model->id.' AND advertisement_type=16');
				$data['sub_product_list2'] = $model->findAll('ADVER_PID=' . $model->id.' AND advertisement_type=17');
            }
            $this->render('update', $data);
        } else {
			//$this-> saveData($model,$_POST[$modelName]);
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
            if ($model->advertisement_type == 5) {
                $model->ADVER_URL_ID = 3;
            }
			$sv=$model->save();
            if ($sv) {
                $pid = $model->id;
                // 广告关联项目
                $this->save_project_list($model->id,$_POST[$modelName]['project_list']);
                // 跳转类型为赛事馆二级商品
                if (!empty($_POST['sub_product_list'])) {
                    $model->deleteAll('ADVER_PID=' . $pid .' AND advertisement_type=16');
                    foreach ($_POST['sub_product_list'] as $k => $v) {
                        $model->isNewRecord = true;
                        unset($model->id);
                        $model->advertisement_type = 16;
                        $model->ADVER_URL_ID = 16;
                        $model->ADVER_WHERE = $k;
                        $model->ADVER_PID = $pid;
                        $model->ADVER_TITLE = $v['title'];
                        $model->advertisement_pic = $v['pic'];
                        $model->save();
                    }
                }
				
				if (!empty($_POST['sub_product_list2'])) {
                    $model->deleteAll('ADVER_PID=' . $pid .' AND advertisement_type=17');
                    foreach ($_POST['sub_product_list2'] as $k => $v) {
                        $model->isNewRecord = true;
                        unset($model->id);
                        $model->advertisement_type = 17;
                        $model->ADVER_URL_ID = 16;
                        $model->ADVER_WHERE = $k;
                        $model->ADVER_PID = $pid;
                        $model->ADVER_TITLE = $v['title'];
                        $model->advertisement_pic = $v['pic'];
                        $model->save();
                    }
                }
				$this->save_gfmaterial($old_pic,$model->advertisement_pic,$model->ADVER_TITLE);
                ajax_status(1, '更新成功', get_cookie('_currentUrl_'));
            } else {
                ajax_status(0, '更新失败');
            }
        }
    }

//保存到素材管理	
public function save_gfmaterial($oldpic,$pic,$title){  
	$logopath=BasePath::model()->getPath(174);
    $gfpic=GfMaterial::model()->findAll('club_id='.get_session('club_id').' AND v_type=252 AND v_pic="'.$pic.'"');
    $gfmaterial=new GfMaterial();
	if($oldpic!=$pic){
		if(empty($gfpic)){
			$gfmaterial->isNewRecord = true;
			unset($gfmaterial->id);
			$gfmaterial->gf_type=501;
			$gfmaterial->gfid=get_session('admin_id');
			$gfmaterial->club_id=get_session('club_id');
			$gfmaterial->v_type=252;
			$gfmaterial->v_title=$title;
			$gfmaterial->v_pic=$pic;
			$gfmaterial->v_file_path=$logopath->F_WWWPATH;
			$gfmaterial->save();
		}
	}     

  }
  public function save_project_list($id,$project_list){       
    //删除原有项目
    AdvertisementProject::model()->deleteAll('adv_id='.$id);
    if(!empty($project_list)){
        $model2 = new AdvertisementProject();
        $club_list_pic = array();
        $club_list_pic = explode(',', $project_list);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $model2->isNewRecord = true;
            unset($model2->id);
            $model2->adv_id =$id;
            $model2->project_id = $v;
            $model2->save();
        }
    }
  }
 /* 
   ///赛事管二级商品
  public function save_product_list($id,$type,$product,$product2){ 
        $model3 = new Advertisement();
    if($type==5){
		if (!empty($_POST['sub_product_list'])) {
            //$model->deleteAll('ADVER_PID=' . $id .' AND advertisement_type=16');
            foreach ($_POST['sub_product_list'] as $k => $v) {
				if ($v['id']=='null') {
                $model3->isNewRecord = true;
                unset($model3->id);
                $model3->advertisement_type = 16;
                $model3->ADVER_URL_ID = 16;
                $model3->ADVER_WHERE = $k;
                $model3->ADVER_PID = $id;
                $model3->ADVER_TITLE = $v['title'];
                $model3->advertisement_pic = $v['pic'];
                $model3->save();
				} else {
					$model3->updateByPk($v['id'],array(
					 'ADVER_TITLE' => $v['title'],
					 'advertisement_pic' => $v['pic'])); 
				}
             }
         }
		 if (!empty($_POST['sub_product_list2'])) {
             //$model->deleteAll('ADVER_PID='.$id.' AND advertisement_type=17');
             foreach ($_POST['sub_product_list2'] as $k => $v) {
				 if ($v['id']=='null') {
                 $model3->isNewRecord = true;
                 unset($model3->id);
                 $model3->advertisement_type = 17;
                 $model3->ADVER_URL_ID = 16;
                 $model3->ADVER_WHERE = $k;
                 $model3->ADVER_PID = $id;
                 $model3->ADVER_TITLE = $v['title'];
                 $model3->advertisement_pic = $v['pic'];
                 $model3->save();
				 } else {
					 $model3->updateByPk($v['id'],array(
					 'ADVER_TITLE' => $v['title'],
					 'advertisement_pic' => $v['pic']));
				 }
             }
         }
        
    }
  }
 
*/
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $count = $model->deleteAll('id in(' . $id . ') OR ADVER_PID in(' . $id . ')');
        if ($count > 0) {
            AdvertisementProject::model()->deleteAll('adv_id in(' . $id . ')');
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

}
