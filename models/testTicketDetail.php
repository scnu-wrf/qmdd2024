<?php

class testTicketDetail extends BaseModel { 
    public function tableName() {
        return '{{test_ticket_detail}}';
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
         'stadium_policy_id'=>'场地策略id',
         'stadium_id'=>'场馆编号',
         'stadium_name'=>'场馆名称',
         'place_id'=>'场馆编码',
         'place_name'=>'场馆名称',
         'project'=>'运动项目',
         'sell_time'=>'营业时间',
         'on_time'=>'上线时间',
         'down_time'=>'下线时间',
         'timespace'=>'时段',
         'price'=>'价格',
         'booker'=>'订场人',
         'book_time'=>'订场时间',
         'order_no'=>'订单号',
         'is_lock'=>'场馆锁定',
         'lock_time'=>'锁定时间',
         'status'=>'场地状态',
       );
    }
    protected function afterFind(){
        parent::afterFind();
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
    // public function keySelect(){
    //     return array('1=1', 'id', 'name:name');
    // }
    
    function subDays($start, $days) {
      $new_date = date_sub($start, new DateInterval("P{$days}D"));
      return date_format($new_date, 'Y-m-d');
  }

  public function getNewDate($cdate,$adays){
      $res=$this->dateCreate($cdate);
      return $this->subDays($res,$adays);
  }

 public function dateCreate($cdate){
      $res=date_format($cdate, 'Y-m-d');
      return date_create($res);
  }

  public function setDetail($model){
    $current_date = date_create($model->start_day);
    $end_date = date_create($model->end_day);
    $aday=$model->advance_day;
    $lday=$model->line_day;
    $s1='stadium_policy_id:id,stadium_id,stadium_name,is_lock=0,status=0';
    $tmp=new testTicketDetail;
    $tmp->setFromArray($model,$s1);
    while ($current_date <= $end_date) {

        $tmp->on_time=$this->getNewDate($current_date,$aday);
        $tmp->down_time=$this->getNewDate($current_date,$lday);
        
        $sell_time=date_format($this->dateCreate($current_date),'Y-m-d');
        $tmp->sell_time=$sell_time;

        $week=toCWeek(date('l', strtotime($sell_time)));
        $ptype=$model->place_type;
        $w1='code='.$model->policy_id.' and place_type="'.$ptype'"';
        $price=testPricePolicy::model()->findAll($w1.' and week="'.$week.'"');

        $w1='staName="'.$model->stadium_name.'" and `group`="'.$ptype.'"';
        $this->setPlace($tmp, $model->place,$w1,$price);
        date_add($current_date, new DateInterval('P1D'));
      }
  }

  public function setPlace($tmp,$place,$w1,$price){
    $placeList=explode(',',$place);
    foreach($placeList as $p){
       $p_id=testVenue::model()->readValue($w1.' and name="'.$p.'"','id');
       $tmp->place_id=$p_id;
       $tmp->place_name=$p;
       $this->saveDetail($tmp,$price);
    }
  }

  public function saveDetail($tmp,$price){
     foreach($price as $v){ 
        $detail=new testTicketDetail;
        $detail->attributes=$tmp->attributes;
        $detail->setFromArray($v,'timespace:time,price');
        $detail->save();
      }
  }

}