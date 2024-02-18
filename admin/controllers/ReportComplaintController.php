<?php

class ReportComplaintController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($type = '', $searchtext = '', $state = '', $online = '', $start_date = '', $end_date = '', $keywords = '', $sorttype = '',$is_excel='0') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'type != 751 ';
        if ($type != '') {
            $criteria->condition.=' AND type=' . $type;
        }
        if ($state != '') {
            $criteria->condition.=' AND state = ' . $state;
        }
        if ($searchtext != '') {
            $criteria->condition.=" AND ( connect_code like '%{$searchtext}%' OR connect_title like '%{$searchtext}%' )";
        }
		$criteria->order = 'add_time DESC';
        $data = array();
        $data['type_name'] = BaseCode::model()->getCode(736);
        $data['state_name'] = BaseCode::model()->getCode(752);
        if(!isset($is_excel) || $is_excel!='1'){
            parent::_list($model, $criteria, 'index', $data);
        }else{
            $arclist = $model->findAll($criteria);
            $data=array();
            $title = array();
            foreach ($model->labelsOfList() as $fv) {
                array_push($title, $model->attributeLabels()[$fv]);
            }
            array_push($data, $title);
            foreach ($arclist as $v) {
                $item = array();
                foreach ($model->labelsOfList() as $fv) {
                    $s = '';
                    if ($fv=='report_type_id'){
                        $s = ReportVersion::model()->getName($v->$fv);
                    }elseif($fv=='state' || $fv=='type'){
                        $s = BaseCode::model()->getName($v->$fv);
                    }else{
                        $s= $v->$fv ;
                    }
                    array_push($item, $s);
                }
                array_push($data, $item);
            }
            parent::_excel($data,'投诉举报列表.xls');
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['state_name'] = BaseCode::model()->getCode(752);
            $data['model'] = $model;
			$data['report_pic'] = explode(',', $model->report_pic);
            $this->render('update', $data);
        } else {

            $model->setAttribute('state',$_POST[$modelName]['state']);
            $model->setAttribute('reasons_for_failure',$_POST[$modelName]['reasons_for_failure']);
            $model->setAttribute('admin_account',get_session('gfaccount') );
            date_default_timezone_set('Asia/Shanghai'); 
            $model->setAttribute('udate', date("Y-m-d H:i:s"));
            show_status($model->save(),"保存成功",get_cookie('_currentUrl_'),"保存失败");
            /*
            if ($model->save()) {
                ajax_status(1, '更新成功', get_cookie('_currentUrl_'));
            } else {
                ajax_status(0, '更新失败'.json_encode( $model->attributes));
            } 
            */
        }
    }

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
