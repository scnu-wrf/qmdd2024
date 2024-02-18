<?php

class QualificationExchangeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$state='',$project_id='',$start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='type=209';
        if($state==''){
            $criteria->condition.=' and state in(2,373)';
            $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
            $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
        }
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($project_id),'get_score_project_id',$project_id,'');
        
        $criteria->join = "JOIN userlist on t.get_score_gfid = userlist.GF_ID";
        $criteria->condition=get_like($criteria->condition,'userlist.ZSXM,userlist.GF_ACCOUNT',$keywords,'');
        if ($start_date != '') {
            $criteria->condition.=' AND left(state_time,10)>="'.$start_date.'"';
        }
        if ($end_date != '') {
            $criteria->condition.=' AND left(state_time,10)<="'.$end_date.'"';
        }
        $criteria->order = 'id DESC';
        $data = array();
		$data['project_id'] = ProjectList::model()->getProject();
        $num=$model->count('type=209 AND state=371'); //$num 统计指定条件的记录总数
        $data['num'] =$num;
        $data['startDate']=$start_date;
        $data['endDate']=$end_date;
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {   
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('create', $data);
        }else{
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           
           $data['model'] = $model;

           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
 function saveData($model,$post) {
       $model->attributes =$post;
	   $flag=0;
       if ($_POST['submitType'] == 'shenhe') {
            $model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
			$flag=1;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
        
        $qp=QualificationExchange::model()->find('get_score_gfid='.$model->get_score_gfid.' and qua_id='.$model->qua_id.' and get_score_project_id='.$model->get_score_project_id);
        
        $no='保存失败';
        if(!empty($qp)&&$qp->id!=$model->id){
            $sv=0;
            $no='保存失败，该龙虎积分已置换';
        }else{
            $sv=$model->save();
        }
		if($flag==1&&$sv==1){
			$old_ex=QualificationExchange::model()->findAll('get_score_gfid='.$model->get_score_gfid.' and type='.$model->type.' and get_score_project_id='.$model->get_score_project_id.' and type_id='.$model->type_id);
            foreach($old_ex as $v){
                if($v->get_score<=$model->get_score){
                    QualificationExchange::model()->updateByPk($v->id, array('is_user'=>648));

                } else {
                    QualificationExchange::model()->updateByPk($model->id, array('is_user'=>648));

                }

            }
		}
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),$no);  
 }


    public function actionDelete($id) {
        parent::_clear($id);
    }
 

}
