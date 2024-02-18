<?php
class testPricePolicyController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    public function actionIndex($keywords="",$type="",$policy=""){ 
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $w1= get_like('1','code,name',$keywords,'');
        $w1= get_where($w1,$type,'place_type');
        $w1= get_where($w1,$policy,'policy_name');
      
        $criteria->order='code';
        $place_type=testPlaceType::model()->findAll();
        $time_policy=testTimePolicy::model()->findAll();
        $data = array();
        $data['place_type']=$place_type;
        $data['time_policy']=$time_policy;
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
    
    function saveData($model,$post) {
        $modelName = $this->model;
        $allmodel=testPricePolicy::model()->findAll('code='.$model->code.' and time!="" and price!=0 and week!=""');
        if($allmodel){
            $model->attributes=$_POST[$modelName];
            $st=$model->save();
            foreach($allmodel as $eachmodel){
                $eachmodel->attributes=$_POST[$modelName];
                $st=$eachmodel->save();
            }
        }
        else
        {
            $criteria=new CDbCriteria;
            $criteria->order='id desc';
            $max = testPricePolicy::model()->find($criteria);
           
            $model->attributes=$_POST[$modelName];
            $model->policy_id=testTimePolicy::model()->find('name="'.$_POST['testPricePolicy']['policy_name'].'"')->id;
            $st=$model->save();
        }
        show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDetail($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data=array();
        $week=testWeek::model()->findAll();
        $criteria=new CDbCriteria;
        $criteria->order='id';
        $criteria->addCondition('policy_id='.$model->policy_id);
        $criteria->addCondition('policy_name="'.$model->policy_name.'"');
        $timespace=testTimeSpace::model()->findAll($criteria);
        $oldmodel=testPricePolicy::model()->findAll('code='.$model->code.' and time!="" and price!=0 and week!=""');
        $data['sign']=($oldmodel) ? 1: 0;
        $data['oldmodel']=$oldmodel;
        $data['week']=$week;
        $data['timespace']=$timespace;
        $data['model']=$model;
        $this->render('detail', $data);
    }

    public function actionsubmitDetail($values,$id){
        $values=json_decode($values);
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $week=testWeek::model()->findAll();
        $criteria=new CDbCriteria;
        $criteria->order='id';
        $criteria->addCondition('policy_id='.$model->policy_id);
        $criteria->addCondition('policy_name="'.$model->policy_name.'"');
        $timespace=testTimeSpace::model()->findAll($criteria);
        $check=testPricePolicy::model()->findAll('code='.$model->code.' and time!="" and price!=0 and week!=""');
        $i=0;
        $j=0;
        $sign=0;
        if($check){
            foreach($check as $eachcheck){
                foreach($timespace as $eachspace){
                    foreach($week as $eachweek){
                        if($eachcheck->time==$eachspace->time&&$eachcheck->week==$eachweek->week){
                            $eachcheck->price=$values[$i][$j];
                            $eachcheck->save();
                            $sign=1;
                            break;
                        }
                        $j++;
                    }
                    $i++;
                    $j=0;
                    if($sign==1){break;}
                }
                $i=0;
            }
        }
        else{
            foreach($timespace as $eachspace){
                foreach($week as $eachweek){
                    $newmodel=new testPricePolicy;
                    $newmodel->code=$model->code;
                    $newmodel->name=$model->name;
                    $newmodel->place_type=$model->place_type;
                    $newmodel->policy_id=$model->policy_id;
                    $newmodel->policy_name=$model->policy_name;
                    $newmodel->time=$eachspace->time;
                    $newmodel->week=$eachweek->week;
                    $newmodel->price=$values[$i][$j];
                    $newmodel->save();
                    $j++;
                }
                $i++;
                $j=0;
            }
            $i=0;
        }
        echo CJSON::encode("成功");
    }

 }