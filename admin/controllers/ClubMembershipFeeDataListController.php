<?php 

    class ClubMembershipFeeDataListController extends BaseController {
        protected $model = '';

        public function init() {
            $this->model = 'ClubMembershipFeeDataList';
            parent::init();
        }

        public function actionIndex($keywords = '',$start_date='',$end_date='',$club_id='') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'f_freemark=1 and scale_no=""';
            $criteria->condition = get_where($criteria->condition, !empty($start_date),'date_start_scale>=',$start_date,'"');
            $criteria->condition = get_where($criteria->condition, !empty($start_date),'date_end_scale<=',$end_date,'"');
            $criteria->condition = get_where($criteria->condition, !empty($club_id),'club_id',$club_id,'"');
            $criteria->condition = get_like($criteria->condition,'',$keywords,'');
            // $criteria->join = "JOIN club_list on t.club_id=club_list.id";
            // $criteria->condition=get_where_club_project('club_id','');
            // $criteria->order = '';
            $data = array();
            $data['club_id'] = ClubList::model()->findAll('state=2 ');
            parent::_list($model, $criteria, 'index', $data);
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $this->render('update',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id) {
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            $data = array();
            if(!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $this->render('update',$data);
            }
            else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post) {
            $model->attributes = $post;
            $sv=$model->save();
            show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
        }

        public function actionFreemark($id){
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            $f_freememo = $_POST['f_freememo'];
            $model->f_freemark = 0;
            $model->f_freememo = $f_freememo;
            $model->save();
            ajax_status(1,'保存成功',Yii::app()->request->urlReferrer);
        }

        // public function actionDelete($id) {
        //     parent::_clear($id);
        // }
        // public function actionDelete($id) {
        //     $modelName = $this->model;
        //     $model = $modelName::model();
        //     $count = $model->deleteAll('id in(' . $id . ')');
        //     if ($count > 0) {
        //         ajax_status(1, '删除成功');
        //     } else {
        //         ajax_status(0, '删除失败');
        //     }
        // }
    }