<?php
class testTicketDetailController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    public function actionGetTicketDetail($id,$date,$project){
        $stadium=testStadium::model()->find('id='.$id);
        $criteria_place = new CDbCriteria;
        $criteria_place->addcondition('project="'.$project.'"');
        $criteria_place->addcondition('staName="'.$stadium->name.'"');
        $places = testVenue::model()->findAll($criteria_place);
        $ticket=array();
        $i=0;
        foreach($places as $eachplace){
            $ticket[$i]['place_name']=$eachplace->name;
            //先查找到该场次的所有场地
            $ticket_temp=testTicketDetail::model()->findAll('stadium_id='.$id.' and place_name="'.$eachplace->name.'" and project="'.$project.'" and sell_time="'.$date.'"');
            //
            if($ticket_temp){
                foreach($ticket_temp as $tt){
                    //如果是暂时被占用场地

                    if($tt->status==2){
                        //过了占用时间
                        if($tt->limit_time<date('Y-m-d H:i:s')){
                            $tt->status=0;//设置为没占用
                            $tt->save();//同步到数据库
                        }
                    }
                }
            }
            $ticket[$i]['detail']=testTicketDetail::model()->findAll('stadium_id='.$id.' and place_name="'.$eachplace->name.'" and project="'.$project.'" and sell_time="'.$date.'"');
            $i++;
        }
        $i=0;
        $timeList=array();
        $result = [];
        $criteria_time = new CDbCriteria;
        $criteria_time->addcondition('project="'.$project.'"');
        $criteria_time->addcondition('stadium_id='.$id);
        $criteria_time->addcondition('sell_time="'.$date.'"');
        $res = testTicketDetail::model()->find($criteria_time);
        if($res){
            $criteria_new=new CDbCriteria;
            $criteria_new->addcondition('policy_id='.testPricePolicy::model()->find('code='.testStadiumPolicy::model()->find('id='.$res->stadium_policy_id)->policy_id)->policy_id);
            $criteria_new->order='id';
            $times = testTimeSpace::model()->findAll($criteria_new);
            foreach($times as $eachtime){
                $timeList[]=$eachtime->time;
            }
            $result = [];
            foreach ($timeList as $time_range) {
                $start_time = substr($time_range, 0, strpos($time_range, '-'));
                $end_time = substr($time_range, strpos($time_range, '-') + 1);
                if (!in_array($start_time, $result)) {
                    $result[] = $start_time;
                }
                if (!in_array($end_time, $result)) {
                   $result[] = $end_time;
                }
            }
        }
        $data=array();
        $data['timeList']=$result;
        $data['ticket']=$ticket;
        echo CJSON::encode($data);
    }

 }