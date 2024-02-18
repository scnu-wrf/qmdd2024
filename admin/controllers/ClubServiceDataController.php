<?php

class ClubServiceDataController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($project = '', $state = '', $type_code = '', $province = '', $city = '', $area = '', $start_date = '', $end_date = '', $keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('club_service_detailed');
        $criteria->condition=get_where_club_project('club_id','');
		$criteria->condition.= ' AND t.service_no=1 AND t.service_type=521 AND t.if_del=510';
		$criteria->condition=get_where($criteria->condition,!empty($project),' t.project_id',$project,'');
		$criteria->condition=get_where($criteria->condition,!empty($state),' t.state',$state,'');

        if ($type_code != '') {
            $arr = array();
            $arr[] = $type_code;
            $subitem = MallProductsTypeSname::model()->getCode($type_code);
            foreach ($subitem as $v) {
                $arr[] = $v->id;
            }
            $criteria->condition.=' AND t.type_code in (' . implode(',', $arr) . ')';
        }

        if ($province !== '') {
            $criteria->condition.=' AND t.area like "%' . $province . '%"';
        }

        if ($city == '市辖区' || $city == '市辖县' || $city == '省直辖县级行政区划') {
            $city = '';
        }
        if ($area == '市辖区' || $area == '市辖县' || $area == '省直辖县级行政区划') {
            $area = '';
        }

        if ($city != '') {
            $criteria->condition.=' AND t.area like "%' . $city . '%"';
        }

        if ($area != '') {
            $criteria->condition.=' AND t.area like "%' . $area . '%"';
        }

        if ($start_date != '' || $end_date != '') {
            $date_where = '';
            if ($start_date != '') {
                $date_where.=' AND club_service_detailed.service_date>="' . $start_date . '"';
            }
            if ($end_date != '') {
                $date_where.=' AND club_service_detailed.service_date<="' . $end_date . '"';
            }
            $criteria->condition.=' AND exists(SELECT * FROM club_service_detailed WHERE club_service_detailed.club_service_detailed.service_code=t.service_code' . $date_where . ')';
        }

        //if ($keywords != '') {
          //  $criteria->condition.=' AND t.title , t.service_code like "%' . $keywords . '%"';
        //}
		$criteria->condition=get_like($criteria->condition,'t.title,t.service_code',$keywords,'');//get_where

        $criteria->order = 't.id DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        $data['base_code'] = BaseCode::model()->getCode(370);
        $data['type_code'] = MallProductsTypeSname::model()->getCode(173);
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic='';
        $data = array();
        $model->service_type = 521;
        if (!Yii::app()->request->isPostRequest) {
            $model->type_code = '';
            $data['model'] = $model;
            $this->render('create', $data);
        } else {
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

            // 如果是赛事服务，分别存储，存服务者资质人类型为服务类型
            // 如果是服务者，存服务者资质人类型为服务类型
            if ($model->type_code == 180) {
                $data_id = explode(',', $model->data_id);
                //$model->type_code = $model->type_code_person;
                $model->data_id = $data_id[0];
            } elseif ($model->type_code == 225) {
                $model->type_code = $model->type_code_person;
            }

            // 启动事务
            $errors = array();
            //$transaction = $model->dbConnection->beginTransaction();
            // 如果是赛事服务，首先保存服务者
            if ($model->save()) {
                // 如果是赛事服务，继续保存场地
                if (isset($data_id) && is_array($data_id)) {
                    $model->isNewRecord = true;
                    unset($model->id);
                    $model->service_no++;
                    //$model->type_code = 180;
                    $model->data_id = $data_id[1];
                    $model->introduceUrl_temp = '';
                    if (!$model->save()) {
                        $errors[] = $model->getErrors();
                    }
                }

                // 保存服务时间
                $detailed = new ClubServiceDetailed;
                $gift = new GiftAssociation;
                if (isset($_POST['timelist'])) {
                    foreach ($_POST['timelist'] as $k2 => $v2) {
                        if ($v2['service_date'] != '' && $v2['service_datatime_start'] != '' && $v2['service_datatime_end'] != '' && $v2['num'] != '') {
                            $detailed->isNewRecord = true;
                            unset($detailed->id);
                            $detailed->service_code = $model->service_code;
                            $detailed->service_date = $v2['service_date'];
                            $detailed->service_datatime_start = $v2['service_datatime_start'];
                            $detailed->service_datatime_end = $v2['service_datatime_end'];
                            $detailed->time_declare = $v2['time_declare'];
                            $detailed->saleable_quantity = intval($v2['num']);
                            $detailed->if_del = 510;
                            if ($detailed->save() && isset($_POST['gift']) && isset($_POST['gift'][$k2])) {
                                foreach ($_POST['gift'][$k2] as $v3) {
                                    $gift->isNewRecord = true;
                                    unset($gift->id);
                                    $gift->type = 353;
                                    $gift->type_id = $detailed->id;
                                    $gift->relation_type = $v3['relation_type'];
                                    $gift->relation_id = $v3['relation_id'];
                                    $gift->relation_ico = $v3['relation_ico'];
                                    $gift->relation_name = $v3['relation_name'];
                                    $gift->relation_json_attr = $v3['relation_json_attr'];
                                    $gift->relation_num = $v3['relation_num'];
                                    if (!$gift->save()) {
                                        $errors[] = $gift->getErrors();
                                    }
                                }
                            }
                        }
                    }
                }
				$model->save();
				$this->save_gfmaterial($old_pic,$model->imgUrl,$model->title);
                if (!empty($errors)) {
                    ajax_status(0, '添加失败');
                } else {
                    ajax_status(1, '添加成功', get_cookie('_currentUrl_'));
                }
            } else {
                ajax_status(0, '添加失败');
            }
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic=$model->imgUrl;
        if ($model->service_no == 2) {
            $this->render('//public/error', array('message' => '赛事服务请在服务序号1中编辑'));
            exit;
        }
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $malltype = MallProductsTypeSname::model();
            $rs = $malltype->getCode(173);
			
            $arr = array();
            foreach ($rs as $v) {
                $arr[] = $v->id;
            }
			
            if(!empty($model->type_code)){
            $type_code = $malltype->getParentInArr($model->type_code, $arr);
            $model->type_code = $type_code;
            }
//            $model2 = $this->loadModel('', $modelName, 'id!=' . $model->id . ' AND service_code="' . $model->service_code . '"');
//            if ($model2 != null) {
//                $model->type_code = 180;
//            }
            $data['model'] = $model;
            $data['person'] = array();
			$data['place'] = array();
            if ($model->type_code == 174 && !empty($model->data_id)) {
                $data['place'] = GfSite::model()->find('id=' . $model->data_id);
            } elseif ($model->type_code == 180 && !empty($model->data_id)) {
                $data['person'] = QualificationsPerson::model()->find('id=' . $model->data_id);
                $model2 = $this->loadModel('', $modelName, 'service_no=2 AND service_code="' . $model->service_code . '"');
                $data['place'] = GfSite::model()->find('id=' . $model2->data_id);
                $model->data_id = $data['person']->id . ',' . $data['place']->id;
                if(!empty($data['person']->mall_products_type_sname->id)){
                    $model->type_code_person = $data['person']->mall_products_type_sname->id;
                }
            } elseif ($model->type_code == 225 && !empty($model->data_id)) {
                $data['person'] = QualificationsPerson::model()->find('id=' . $model->data_id);
                if(!empty($data['person']->mall_products_type_sname->id)){
                    $model->type_code_person = $data['person']->mall_products_type_sname->id;
                }
            }
            
            $data['service_pic_img'] = array();
            if ($model->service_pic_img != '') {
                $data['service_pic_img'] = explode(',', $model->service_pic_img);
            }
            $data['detailed'] = ClubServiceDetailed::model()->find('service_id="' . $model->id . '"');
            $this->render('update', $data);
        } else {
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

            // 如果是赛事服务，分别存储，存服务者资质人类型为服务类型
            // 如果是服务者，存服务者资质人类型为服务类型
            if ($model->type_code == 180) {
                $data_id = explode(',', $model->data_id);
                //$model->type_code = $model->type_code_person;
                $model->data_id = $data_id[0];
            } elseif ($model->type_code == 225) {
                $model->type_code = $model->type_code_person;
            }

            // 启动事务
            $errors = array();
            // 如果是赛事服务，首先保存服务者
            if ($model->save()) {
                // 如果是赛事服务，继续保存场地
                $model2 = $this->loadModel('', $modelName, 'id!=' . $model->id . ' AND service_code="' . $model->service_code . '"');
                if (isset($data_id) && is_array($data_id)) {
                    if ($model2 != null) {
                        $model2->attributes = $_POST[$modelName];
                        $model2->type_code = 180;
                        $model2->data_id = $data_id[1];
                        $model2->introduceUrl_temp = '';
                        $model2->introduceUrl = $model->introduceUrl;
                        if (!$model2->save()) {
                            $errors[] = $model2->getErrors();
                        }
                    } else {
                        $model->isNewRecord = true;
                        unset($model->id);
                        $model->service_no++;
                        $model->type_code = 180;
                        $model->data_id = $data_id[1];
                        if (!$model->save()) {
                            $errors[] = $model->getErrors();
                        }
                    }
                } else {
                    if ($model2 != null) {
                        $model2->delete();
                    }
                }
				$model->save();
				$this->save_time_list($model->id,$model->service_code,$_POST['timelist']);
				$this->save_gfmaterial($old_pic,$model->imgUrl,$model->title);
                if (!empty($errors)) {
                    ajax_status(0, '更新失败');
                } else {
                    ajax_status(1, '更新成功'/*, get_cookie('_currentUrl_')*/);
                }
            } else {
                ajax_status(0, '更新失败');
            }
        }
    }
	
	function saveData($model,$post) {
       $model->attributes =$post;
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
       $sv=$model->save();  
       $this->save_time_list($model->id,$model->service_code,$_POST['timelist']);
	   $this->save_gfmaterial($old_pic,$model->imgUrl,$model->title);
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败'); 
    }
	
	//保存到素材管理	
    public function save_gfmaterial($oldpic,$pic,$title){  
        $logopath=BasePath::model()->getPath(135);
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

	//////////////////////////////// 保存服务时间/////////////////// 
    public  function save_time_list($id,$code,$timelist){    
        if (isset($_POST['timelist'])) {
            $detailed = new ClubServiceDetailed;
            foreach ($_POST['timelist'] as $v) {
                if ($v['service_date'] == '' && $v['service_datatime_start'] == '' && $v['service_datatime_end']=='' && $v['num']=='' && $v['if_del']=='') {
                    continue;
                }
                if ($v['id']=='null') {
                    $detailed->isNewRecord = true;
                    unset($detailed->id);
                    $detailed->service_id = $id;
                    $detailed->service_code = $code;
                    $detailed->service_date = $v['service_date'];
                    $detailed->service_datatime_start = $v['service_datatime_start'];
                    $detailed->service_datatime_end = $v['service_datatime_end'];
                    $detailed->time_declare = $v['time_declare'];
                    $detailed->saleable_quantity = intval($v['num']);
                    $detailed->if_del = 510;
                    $detailed->save();
                    // $this->save_gift_list($detailed->id,$_POST['gift'][$detailed->id]);
                } else {
                    if ($v['if_del']==510) {
                        $detailed->updateByPk($v['id'],array(
                            'service_date' => $v['service_date'],
                            'service_datatime_start' => $v['service_datatime_start'],
                            'service_datatime_end' => $v['service_datatime_end'],
                            'time_declare' => $v['time_declare'],
                            'saleable_quantity' => intval($v['num']))); 
                        //$this->save_gift_list($v['id'],$_POST[$v['id']]['gift']);
                    } else {
                        $detailed->updateByPk($v['id'],array(
                        'if_del' => 509));
                    }
                }
            }
        }
    }
 
    //////////////////////////////// 保存服务赠品///////////////////  
    public function save_gift_list($id,$gift_list){
        //删除原有赠品
    // GiftAssociation::model()->deleteAll('type=353 AND type_id=' . $id);
        if (isset($_POST['gift']) && isset($_POST[$id]['gift'])) {
            foreach ($_POST[$id]['gift'] as $v3) {
                $gift = new GiftAssociation;
                $gift->isNewRecord = true;
                unset($gift->id);
                $gift->type = 353;
                $gift->type_id = $id;
                $gift->relation_type = $v3['relation_type'];
                $gift->relation_id = $v3['relation_id'];
                $gift->relation_ico = $v3['relation_ico'];
                $gift->relation_name = $v3['relation_name'];
                $gift->relation_json_attr = $v3['relation_json_attr'];
                $gift->relation_num = $v3['relation_num'];
                if (!$gift->save()) {
                    $errors[] = $gift->getErrors();
                }
            }
        }
    }

    //逻辑删除
    public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$service=explode(',', $id);
        $count=0;
		foreach ($service as $d) {
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
