<?php

class testPricePolicy extends BaseModel {  
    public function tableName() {
        return '{{test_price_policy}}';
    }
    /*** Returns the static model of the specified AR class. */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**  * 模型关联规则  */
    public function relations() {
        return array();
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
      return array(
         'id'=>'编号',
         'code'=>'策略编码',
         'name'=>'策略名称',
         'place_type'=>'场地类型',
         'policy_id'=>'时间策略编号',
         'policy_name'=>'时间策略名称',
         'time'=>'时间段',
         'price'=>'价格',
         'week'=>'星期',
     );
    }
    protected function afterFind(){
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    public function getAll($cr='1'){
        return testPricePolicy::model()->findAll($cr);
    }
    /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    // public function keySelect(){
    //     return array('1=1', 'id', 'name:name');
    // }
    // 
      public function setPolicyDetail($stadium,$policy,$advance_day,$line_day,$start,$end,$places,$type){
        $current_date = date_create($start);
        $end_date = date_create($end);
        $model=new testStadiumPolicy;
        $model->stadium_name=$stadium;
        $model->stadium_id=testStadium::model()->find('name="'.$stadium.'"')->id;
        $model->place_type=$type;
        $model->advance_day=$advance_day;
        $model->line_day=$line_day;
        $model->policy_name=$policy;
        $model->policy_id=testPricePolicy::model()->find('name="'.$policy.'"')->code;
        $model->place=$places;
        $model->start_day=$start;
        $model->end_day=$end;
        $model->save();
        while ($current_date <= $end_date) {
            $res=date_format($current_date, 'Y-m-d');
            $res=date_create($res);
            $up_time=$this->subDays($res,$advance_day);
            $res=date_format($current_date, 'Y-m-d');
            $res=date_create($res);
            $down_time=$this->subDays($res,$line_day);
            $res=date_format($current_date, 'Y-m-d');
            $res=date_create($res);
            $sell_time=date_format($res, 'Y-m-d');
            $week=toCWeek(date('l', strtotime($sell_time)));
            $price=testPricePolicy::model()->findAll('code='.$model->policy_id.' and place_type="'.$model->place_type.'" and week="'.$week.'"');
            $placeList=explode(',', $model->place);
            foreach($placeList as $eachplace){
                foreach($price as $eachprice){ 
                    $detail=new testTicketDetail;
                    $detail->stadium_policy_id=$model->id;
                    $detail->stadium_id=$model->stadium_id;
                    $detail->stadium_name=$model->stadium_name;
                    $detail->place_id=testVenue::model()->find('staName="'.$model->stadium_name.'" and name="'.$eachplace.'" and `group`="'.$model->place_type.'"')->id;
                    $detail->place_name=$eachplace;
                    $detail->sell_time=$sell_time;
                    $detail->on_time=$up_time;
                    $detail->down_time=$down_time;
                    $detail->timespace=$eachprice->time;
                    $detail->price=$eachprice->price;
                    $detail->is_lock=0;
                    $detail->status=0;
                    $detail->save();
                }
            }
            date_add($current_date, new DateInterval('P1D'));
        }
        echo CJSON::encode("成功");
    }

}