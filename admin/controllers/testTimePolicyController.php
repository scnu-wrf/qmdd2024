<?php
class testTimePolicyController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    public function actionIndex($keywords=""){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if(!empty($keywords)) $criteria->condition = get_like($criteria->condition,'name',$keywords,'');
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        $data['sign'] = 'create';
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

     public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        $data['sign'] = 'update';
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    function timeToNumber($time) {
        list($hour, $minute) = explode(':', $time);
        return $hour;
    }

    function saveData($model,$post) {
        $modelName = $this->model;
        $model->attributes=$_POST[$modelName];
        $st=$model->save();
        $timemodel=testTimeSpace::model()->findAll('policy_id='.$model->id.' and policy_name="'.$model->name.'"');
        if($timemodel){
            foreach($timemodel as $eachmodel){
                $eachmodel->delete();
            }
        }
        for($i=$this->timeToNumber($model->morning_start);$i<$this->timeToNumber($model->morning_end);$i=$i+$model->timespace){
            $newtimemodel=new testTimeSpace;
            $newtimemodel->policy_id=$model->id;
            $newtimemodel->policy_name=$model->name;
            $newtimemodel->time=strval($i).':00-'.strval($i+$model->timespace).':00';
            $newtimemodel->save();
        }
        for($i=$this->timeToNumber($model->afternoon_start);$i<$this->timeToNumber($model->afternoon_end);$i=$i+$model->timespace){
            $newtimemodel=new testTimeSpace;
            $newtimemodel->policy_id=$model->id;
            $newtimemodel->policy_name=$model->name;
            $newtimemodel->time=strval($i).':00-'.strval($i+$model->timespace).':00';
            $newtimemodel->save();
        }
        for($i=$this->timeToNumber($model->night_start);$i<$this->timeToNumber($model->night_end);$i=$i+$model->timespace){
            $newtimemodel=new testTimeSpace;
            $newtimemodel->policy_id=$model->id;
            $newtimemodel->policy_name=$model->name;
            $newtimemodel->time=strval($i).':00-'.strval($i+$model->timespace).':00';
            $newtimemodel->save();
        }
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

 }