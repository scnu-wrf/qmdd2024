<?php

class VideoClassifyController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$code='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1';
        $criteria->condition=get_like($criteria->condition,'sn_name',$keywords,'');
        if($code!='') {
            $criteria->condition.=' AND tn_code like "'.$code.'%"';
        }
        $criteria->order = 'tn_code ASC';
        parent::_list($model, $criteria, 'index');
    }

    public function actionIndex_publish($keywords = '', $online = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        //$criteria->with = array('mall_brand_project');
        //get_session('club_id')
        $criteria->condition = 'state !=2 and club_id='.get_session('club_id') ;
        //$criteria->condition=get_where('1=1',!empty($online),' brand_state',$online,'');
        $criteria->condition=get_where($criteria->condition,!empty($online),' brand_state',$online,'');
        $criteria->condition=get_like($criteria->condition,'brand_title,brand_no',$keywords,'');
        $criteria->order = 'id DESC';

        parent::_list($model, $criteria,'index_publish');
    }

    public function actionIndex_examine($keywords = '', $online = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        //$criteria->with = array('mall_brand_project');
        $criteria->condition = 'state in(2,373)';
        $criteria->condition=get_where($criteria->condition,!empty($online),' brand_state',$online,'');
        $criteria->condition=get_like($criteria->condition,'brand_title,brand_no',$keywords,'');
        $criteria->order = 'id DESC';

        $data = array();
        date_default_timezone_set('Asia/Shanghai');
        $current_time = (date("Y-m-d"));
        $data['count1'] = $model->count('state = 371');
        parent::_list($model, $criteria,'index_examine', $data);
    }

    public function actionIndex_no_exam($keywords='',$start_date='',$end_date='',$to_day=0) {
        $start_date2 = substr($start_date,0,10);
        $end_date2 = substr($end_date,0,10);
       
        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = ' state = 371';
        /* if($to_day==1){
             $criteria->condition .= ' and left(apply_time,10)="'.date('Y-m-d').'"';
         }*/
        $criteria->order = 'id DESC';
        /*$criteria->condition=get_like($criteria->condition,'club_code,club_name,company',$keywords,'');
        $criteria->condition=get_where($criteria->condition,($start_date2!=""),'left(apply_time,10)>=',$start_date2,'"');
        $criteria->condition=get_where($criteria->condition,($end_date2!=""),'left(apply_time,10)<=',$end_date2,'"');*/

        $data = array();
        date_default_timezone_set('Asia/Shanghai');
        $current_time = (date("Y-m-d"));

        $data['count1'] = $model->count('state = 371');
       
        parent::_list($model, $criteria, 'index_no_exam', $data);
    }

    public function actionIndex_brand_list($keywords = '', $online = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        //$criteria->with = array('mall_brand_project');
        //get_session('club_id')
        $criteria->condition = 'state = 2 and if_del = 510 and club_id='.get_session('club_id');
        //$criteria->condition=get_where('1=1',!empty($online),' brand_state',$online,'');
        $criteria->condition=get_where($criteria->condition,!empty($online),' brand_state',$online,'');
        $criteria->condition=get_like($criteria->condition,'brand_title,brand_no',$keywords,'');
        $criteria->order = 'id DESC';

        parent::_list($model, $criteria,'index_brand_list');
    }

    public function actionIndex_brand_manage($keywords = '', $online = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        //$criteria->with = array('mall_brand_project');
        $criteria->condition = 'state = 2';
        $criteria->condition=get_where($criteria->condition,!empty($online),' brand_state',$online,'');
        $criteria->condition=get_like($criteria->condition,'brand_title,brand_no,club_name',$keywords,'');
        $criteria->order = 'f_userdate DESC';

        $data = array();
        date_default_timezone_set('Asia/Shanghai');
        $current_time = (date("Y-m-d"));
        $data['count1'] = $model->count('state = 371');
        parent::_list($model, $criteria,'index_brand_manage', $data);
    }


    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            //$data['project_list'] = ProjectList::model()->getAll();
            $data['model'] = $model;
            $data['brand_certificate']=array();

            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            //$data['project_list'] = ProjectList::model()->getAll();
            $data['model'] = $model;
            $data['brand_certificate']=array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
        if ($_POST['submitType'] == 'baocun') {
            $yes='保存成功';
            $no='保存失败';
        }

        $st=$model->save();

        /*$model->updateAll(array('if_examine'=>$model->if_examine,'examine_time'=>$model->examine_time,'if_reduce_inventory'=>$model->if_reduce_inventory,'long_pay_time'=>$model->long_pay_time,'is_post'=>$model->is_post,'sign_long_cycle'=>$model->sign_long_cycle,'if_apply_return'=>$model->if_apply_return,'return_cycle'=>$model->return_cycle,'if_invoice'=>$model->if_invoice,'invoice_cycle'=>$model->invoice_cycle),'tn_code like "'.$model->tn_code.'%"');
        $this->save_project_list($model->tn_code,$post['project_list']);*/

        show_status($st,$yes, get_cookie('_currentUrl_'),$no);

    }

    public function save_project_list($id,$project_list){
        //删除原有项目
        MallBrandProject::model()->deleteAll('brand_id='.$id);
        if(!empty($project_list)){
            $model2 = new MallBrandProject();
            $club_list_pic = array();
            $club_list_pic = explode(',', $project_list);
            $club_list_pic = array_unique($club_list_pic);
            foreach ($club_list_pic as $v) {
                $model2->isNewRecord = true;
                unset($model2->id);
                $model2->brand_id = $id;
                $model2->project_id = $v;
                $model2->save();
            }
        }
    }



    //撤销
    public function  actionRevoke_brand(){

        //$GF_IDArray  = explode(",",$GF_ID);
        //$thawMode  = $thawMode;

        $id = $_GET['id'];
      

        $modelName = $this->model;
        $model = $modelName::model();
        $idArray = explode(",",$id);
        $count=0;
        //$count=$model->deleteAll('id in('.$id.')');
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('state'=>721));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '撤销失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }

    //上线
    public function  actionOn_line(){
        //$GF_IDArray  = explode(",",$GF_ID);
        //$thawMode  = $thawMode;
        $id = $_GET['id'];
        $modelName = $this->model;
        $model = $modelName::model();
        $idArray = explode(",",$id);
        $count=0;
        //$count=$model->deleteAll('id in('.$id.')');
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('brand_state'=>649));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '上线成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '上线失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }

    //下线
    public function  actionOff_line(){
        $id = $_GET['id'];
        $modelName = $this->model;
        $model = $modelName::model();
        $idArray = explode(",",$id);
        $count=0;
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('brand_state'=>648));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '下线成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '下线失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }

    // 基础删除方法
    /*public function actionDelete($id) {
        //$count = ClubBrand::model()->deleteAll('id='.$id);
        $club_brand1 = ClubBrand::model()->find('id='.$id);
        $club_brand1->if_del = 509;
        $club_brand1->save();


        $mall_brand_street1 = MallBrandStreet::model()->find('club_brand_id='.$id);
        $mall_brand_street1->if_del = 509;
        $st = $mall_brand_street1->save();

        show_status($st,'删除成功', get_cookie('_currentUrl_'),'删除失败');

        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }*/


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


    //逻辑删除
    /* public function actionDelete($brand_id) {
           $modelName = $this->model;
           $model = $modelName::model();
           $club=explode(',', $brand_id);
           $count=0;
           foreach ($club as $d) {
                   $model->delete('brand_id='.$d);
                   MallBrandProject::model()->deleteAll('brand_id='.$d);
                   $count++;

           }

           if ($count > 0) {
               ajax_status(1, '删除成功');
           } else {
               ajax_status(0, '删除失败');
           }
       }*/

}
