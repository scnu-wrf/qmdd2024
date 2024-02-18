<?php
class testStadiumPolicyController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    public function actionIndex($keywords="",$stadium="",$place="",$price="",$type=""){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->order='start_day desc';
        $cr=get_like('1','place_type,stadium_name,place,policy_name',$keywords,'');
        $cr=get_like($cr,'place',$place,'');
        $cr=get_where($cr,$type,'place_type',$type);
        $cr=get_where($cr,$price,'policy_name',$price);
        $criteria->condition=get_where($cr,$stadium,'stadium_name',$type);
        $data = array();
        $data['stadium']=testStadium::model()->getAll();
        $data['place']=testVenue::model()->getAll();
        $w1='time="" and price=0 and  week=""';
        $data['price']=testPricePolicy::model()->getAll($w1);
        $data['place_type']=testPlaceType::model()->getAll();
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        $criteria = new CDbCriteria;
        $criteria->select = 'DISTINCT name';
        $data['type']=testVenType::model()->getAll();
        $data['stadium']=testStadium::model()->getAll();
        $data['time']=testPricePolicy::model()->getAll($criteria);
        $data['sign'] = 'create';
        $this->render('update', $data);
    }

    public function actionplaceList($stadium,$type){
        $w='staName="'.$stadium.'" and `group`="'.$type.'"';
        $tmp=testVenue::model()->getAll($w1);
        echo CJSON::encode(toArrayNoname($tmp,'name'));
    }

    public function actionpolicyDetail($stadium,$policy,$advance_day,$line_day,$start,$end,$places,$type){
        $model=new testStadiumPolicy;
        $model->stadium_name=$stadium;
        $w1='name="'.$stadium.'"';
        $model->stadium_id=testStadium::model()->readValue($w1,'id');
        $model->place_type=$type;
        $model->advance_day=$advance_day;
        $model->line_day=$line_day;
        $model->policy_name=$policy;
        $w1='name="'.$policy.'"';
        $model->policy_id=testPricePolicy::model()->find($w1,'code');
        $model->place=$places;
        $model->start_day=$start;
        $model->end_day=$end;
        $model->save();
        testTicketDetail::model()->setDetail($model);
        echo CJSON::encode("成功");
    }


    public function actionDetail($id){
        $modelName = $this->model;
        $show = $this->loadModel($id, $modelName);
        $detail=array();
        $i=0;
        $placeList=explode(',', $show->place);
        foreach($placeList as $each){
            $detail[$i]['place']=$each;
            $criteria=new CDbCriteria;
            $criteria->addCondition('stadium_policy_id='.$id);
            $criteria->addCondition('place_name="'.$each.'"');
            $criteria->order='id';
            $model=testTicketDetail::model()->findAll($criteria);
            $detail[$i]['model']=$model;
            $i++;
        }
        $timespaces = testTimeSpace::model()->findAll('policy_id='.testPricePolicy::model()->find('code='.$show->policy_id)->policy_id);
        $dates=array();
        $current_date = date_create($show->start_day);
        $end_date = date_create($show->end_day);
        while ($current_date <= $end_date) {
            $res=date_format($current_date, 'Y-m-d');
            $res=date_create($res);
            $sell_time=date_format($res, 'Y-m-d');
            $dates[]=$sell_time;
            date_add($current_date, new DateInterval('P1D'));
        }
        $data=array();
        $data['show']=$show;
        $data['timespaces']=$timespaces;
        $data['dates']=$dates;
        $data['detail']=$detail;
        $this->render('detail', $data);
    }

    public function actionsubmitDetail(){
        $values=json_decode($_POST['values']);
        $modelName = $this->model;
        $show = $this->loadModel($_POST['id'], $modelName);
        $model=testTicketDetail::model()->findAll('stadium_policy_id='.$_POST['id']);
        $placeList=explode(',', $show->place);
        $timespaces = testTimeSpace::model()->findAll('policy_id='.testPricePolicy::model()->find('code='.$show->policy_id)->policy_id);
        $dates=array();
        $current_date = date_create($show->start_day);
        $end_date = date_create($show->end_day);
        while ($current_date <= $end_date) {
            $res=date_format($current_date, 'Y-m-d');
            $res=date_create($res);
            $sell_time=date_format($res, 'Y-m-d');
            $dates[]=$sell_time;
            date_add($current_date, new DateInterval('P1D'));
        }
        $i=0;$j=0;$k=0;
        $criteria=new CDbCriteria;
        foreach($placeList as $eachplace){
            foreach($timespaces as $eachtime){
                foreach($dates as $date){
                    $criteria->addCondition('place_name="'.$eachplace.'"');
                    $criteria->addCondition('timespace="'.$eachtime->time.'"');
                    $criteria->addCondition('sell_time="'.$date.'"');
                    $ticket=testTicketDetail::model()->find($criteria);
                    if($ticket){
                        $ticket->price=$values[$i][$j][$k];
                        $ticket->save();
                        $criteria=new CDbCriteria;
                    }
                    $k++;
                }
                $k=0;
                $j++;
            }
            $j=0;
            $i++;
        }
        $i=0;
        echo CJSON::encode("成功");
    }

 }