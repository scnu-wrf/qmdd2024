<?php

class testShoppingInfo extends BaseModel { 
    public function tableName() {
        return '{{testShoppingInfo}}';
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
           'order_code'=>'订单号',
           'order_title'=>'订单说明',
           'order_type'=>'订单类型',
           'add_code'=>'购买者账号',
           'add_name'=>'购买者姓名',
           'add_phone'=>'购买者电话',
           'add_date'=>'下单时间',
           'stadium_id'=>'场馆编号',
           'stadium_name'=>'场馆名称',
           'money'=>'价格',
       );
    }
    protected function afterFind(){
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
    /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    // public function keySelect(){
    //     return array('1=1', 'id', 'name:name');
    // }
   

    //添加订单
    public function addShopping($stadium_id,$stadium_name,$list,$add_code,$add_name,$add_phone,$money,$orderNo='',$orderTime='',$coach,$mode=1){
        $checkList=is_array($list) ? $list : json_decode($list);
        $coachList=json_decode($coach);
        $shop=new testShoppingInfo;
        $shop->add_code=$add_code;
        $shop->add_name=$add_name;
        $shop->add_phone=$add_phone;
        $shop->add_date=$orderTime; //下单时间
        if($mode==0){
            $shop->add_date=date('Y-m-d H:i:s');
            $shop->order_type=0;
        }
        $shop->stadium_id=$stadium_id;
        $shop->stadium_name=$stadium_name;
        $shop->money=$money;
        $shop->order_code = $orderNo; //订单号，唯一
        $shop->save();
        if($mode==0){
            //如果是选厂页面->支付页面，$list保存的是完整的场地数据，提取其中的id到$checkList，兼容原来的代码
            $temp=array();
            foreach($checkList as $each){
                array_push($temp,$each->id);
            }
            $checkList=$temp;
        }
        $lockTicketArray=array();
        foreach($checkList as $each){
            $detail=new testShoppingDetail;
            $detail->info_id=$shop->id; //订单id
            $detail->add_code=$add_code; //购买者账号
            $detail->add_name=$add_name; //购买者姓名
            $detail->add_phone=$add_phone; //购买者电话
            $detail->order_code=$orderNo; //订单号，唯一
            $detail->product_id=$each;
            $ticket=testTicketDetail::model()->find('id='.$each);
            if($mode==0){
                $ticket->status=2;//锁场标识
                //支付页面两分钟锁场
                $current_time=date("Y-m-d H:i:s");
                $future_time_stamp = strtotime($current_time) + (2 * 60);
                $ticket->limit_time=date('Y-m-d H:i:s',$future_time_stamp);
                array_push($lockTicketArray,$ticket->id);
                put_msg("两分钟？？");
                $ticket->save();
            }
            $detail->product_project=$ticket->project;
            $detail->product_place=$ticket->place_name;
            $detail->product_date=$ticket->sell_time;
            $detail->product_time=$ticket->timespace;
            $detail->price=$ticket->price;
            $detail->save();
        }
        //把教练信息加入到订单详情中
        foreach($coachList as $eachcoach){
            foreach($eachcoach->detail as $eachdetail){
                $detail=new testShoppingDetail;
                $detail->info_id=$shop->id; //订单id
                $detail->type="教练";
                $detail->order_code=$orderNo; //订单号，唯一
                $detail->add_code=$add_code; //购买者账号
                $detail->add_name=$add_name; //购买者姓名
                $detail->add_phone=$add_phone; //购买者电话
                $detail->product_id=$eachcoach->id;
                $ticket=testTicketDetail::model()->find('id='.$eachcoach->id);
                $detail->product_project=$ticket->project;
                $detail->product_place=$ticket->place_name;
                $detail->product_date=$ticket->sell_time;
                $detail->product_time=$ticket->timespace;
                $detail->product_coach_id=$eachdetail->id;
                $detail->product_name=$eachdetail->qualification_name;
                $detail->price=200;
                $detail->save();
            }
        }
        $backArray=array();
        $backArray['shopId']=$shop->id;$backArray['staId']=$stadium_id;$backArray['lockTicketArray']=$lockTicketArray;
        return $backArray;
    }

    //支付订单，未支付订单表->支付订单表
    public function payShopping($id){
        $info=testShoppingInfo::model()->find('id='.$id);
        $detail=testShoppingDetail::model()->findAll('info_id='.$id);
        $orderInfo=new testOrderInfo;
        /*$s2='order_code,order_title,order_type="待使用",rec_code:add_code,rec_name:add_name,rec_phone:add_phone,order_date:add_date,stadium_id,stadium_name,money,pay_time="微信支付",pay_code=1';
        $orderInfo->setFromArray($info,$s2);
        $orderInfo->pay_time=date('Y-m-d H:i:s');
        $orderInfo->save();*/
        $orderInfo->order_code=$info->order_code;
        $orderInfo->order_title=$info->order_title;
        $orderInfo->order_type='待使用';
        $orderInfo->rec_code=$info->add_code;
        $orderInfo->rec_name=$info->add_name;
        $orderInfo->rec_phone=$info->add_phone;
        $orderInfo->order_date=$info->add_date;
        $orderInfo->stadium_id=$info->stadium_id;
        $orderInfo->stadium_name=$info->stadium_name;
        $orderInfo->money=$info->money;
        $orderInfo->pay_type='微信支付';
        $orderInfo->pay_code=1;
        $orderInfo->pay_time=date('Y-m-d H:i:s');
        $orderInfo->save();
        $mallInfo=new MallSalesOrderInfo;
        $mallInfo->order_num=$info->order_code;
        $mallInfo->order_title=$info->order_title;
        $mallInfo->order_type='待使用';
        $mallInfo->rec_code=$info->add_code;
        $mallInfo->rec_name=$info->add_name;
        $mallInfo->rec_phone=$info->add_phone;
        $mallInfo->order_Date=$info->add_date;
        $mallInfo->money=$info->money;
        $mallInfo->pay_type_name='微信支付';
        $mallInfo->pay_time=date('Y-m-d H:i:s');
        $mallInfo->save();
        $info->delete();//从未支付订单表删除
        foreach($detail as $each){
            $ticket=testTicketDetail::model()->find('id='.$each->product_id);
            $ticket->status=1;
            $ticket->save();
            $orderDetail=new testOrderDetail;
            $orderDetail->info_id=$orderInfo->id;
            $orderDetail->type=$each->type;
            $orderDetail->order_code=$orderInfo->order_code;
            $orderDetail->order_title=$orderInfo->order_title;
            $orderDetail->order_type=$orderInfo->order_type;
            $orderDetail->rec_code=$orderInfo->rec_code;
            $orderDetail->rec_name=$orderInfo->rec_name;
            $orderDetail->rec_phone=$orderInfo->rec_phone;
            $orderDetail->product_id=$each->product_id;
            $orderDetail->product_project=$each->product_project;
            $orderDetail->product_place=$each->product_place;
            $orderDetail->product_date=$each->product_date;
            $orderDetail->product_time=$each->product_time;
            $orderDetail->product_coach_id=$each->product_coach_id;
            $orderDetail->product_name=$each->product_name;
            $orderDetail->price=$each->price;
            $orderDetail->save();
            $mallData=new MallSalesOrderData;
            $mallData->info_id=$orderInfo->id;
            $mallData->order_num=$orderInfo->order_code;
            $mallData->order_type_name=$orderInfo->order_type;
            if($each->type=='场地'){
                $mallData->product_id=$each->product_id;
                $mallData->product_title=$each->product_name;
            }
            if($each->type=='教练'){
                $mallData->product_id=$each->product_coach_id;
                $mallData->product_title=$each->product_name;
            }
            $mallData->total_pay=$each->price;
            $mallData->save();
            $each->delete();//从未支付订单详情表删除
        }
    }

    //取消订单
    public function CancelShopping($id){
        $info=testShoppingInfo::model()->find('id='.$id);
        $detail=testShoppingDetail::model()->findAll('info_id='.$id);
        $info->delete();
        foreach($detail as $each){
            $each->delete();
        }
    }
}