<?php
class testShoppingInfoController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }
    
    public function actiongetShoppingInfo($code,$name,$phone){
        $criteria=new CDbCriteria;
        $criteria->order='add_date DESC';
        $criteria->addCondition('add_code='.$code);
        $criteria->addCondition('add_name="'.$name.'"');
        $criteria->addCondition('add_phone="'.$phone.'"');
        $criteria->addCondition('order_type=0 or order_type=3');
        $info=testShoppingInfo::model()->findAll($criteria);
        $data=array();
        $i=0;
        foreach($info as $each){
            if($this->setExpiredOrder($each->id)==1){
                $data[$i]['order_type']=3;
            }
            $data[$i]['info']=$each;
            $data[$i]['detail']=testShoppingDetail::model()->findAll('info_id='.$each->id);
            $i++;
        }
        $i=0;
        echo CJSON::encode($data);
    }

    public function actionPayShopping($id){
        testShoppingInfo::model()->payShopping($id);
        echo CJSON::encode('成功');
    }

    //取消订单
    public function actionCancelShopping($id,$ticketList){
        //解除锁场
        $checkList=json_decode($ticketList);
        foreach($checkList as $each){
             $tempTicket=testTicketDetail::model()->find('id='.$each);
             $tempTicket->status=0;
             $tempTicket->save();
        }
        testShoppingInfo::model()->find('id='.$id)->delete();//先删除锁场订单
        $ticketDtails=testShoppingDetail::model()->findAll('info_id='.$id);//再删除锁场订单的细节记录
        foreach($ticketDtails as $td)
            $td->delete();
        echo CJSON::encode('成功');
    }
    
    public function CascadeDelete($shoppingOrderId){
        testShoppingInfo::model()->find('id='.$shoppingOrderId)->delete();//先删除锁场订单
        $ticketDtails=testShoppingDetail::model()->findAll('info_id='.$shoppingOrderId);//再删除锁场订单的细节记录
        foreach($ticketDtails as $td)
            $td->delete();
    }
    //查看是否订单过期
    public function actionCheckOrder($shoppingOrderId){
        if($this->setExpiredOrder($shoppingOrderId)==1){
            echo CJSON::encode('已过期');
        }else{
            echo CJSON::encode('未过期');
        }
    }
    //先判断条件，如果当前时间大于过期时间，设置订单为过期
    public function setExpiredOrder($shoppingOrderId){
        $tempOrder=testShoppingInfo::model()->find('id='.$shoppingOrderId);
        if(date("Y-m-d H:i:s")>$tempOrder->limit_time){
            $tempOrder->order_type=3;//状态设置为待支付订单过期订单
            $tempOrder->save();
            return 1;//1标识该订单被设置为过期
        }else{
            return 0;//0标识该订单仍为未过期
        } 
    }
    //查找该用户该场馆是否有待支付且未过期订单，有的话返回订单id
    public function actionCheckIsExpiredOrder($stadium_id,$userId){
        $criteria=new CDbCriteria;
        $criteria->condition='stadium_id='.$stadium_id;
        $criteria->addCondition('add_code='.$userId);
        $criteria->addCondition('order_type=0');
        put_msg('场地id: '.$stadium_id." 用户id: ".$userId);
        $temp=testShoppingInfo::model()->find($criteria);
        if(count($temp)!=0){
            if($this->setExpiredOrder($temp->id)==0){
                echo CJSON::encode($temp->id);//返回订单id
                return;
            }else
                echo CJSON::encode('无待支付且未过期订单');
        }else
          echo CJSON::encode('无待支付且未过期订单');
    }
    //两分钟没有支付订单删除订单，解除锁场
    public function actionDeleteShoppingOrderAfterTwoMinute($shoppingOrderId,$ticketList){
           $this->CascadeDelete($shoppingOrderId);
           $checkList=json_decode($ticketList);
           put_msg('数量： '.count($checkList));
           foreach($checkList as $each){
             $tempTicket=testTicketDetail::model()->find('id='.$each);
             $tempTicket->status=0;
             $tempTicket->save();
           }
           echo CJSON::encode('解除锁场成功！');
    }  
    //支付页面点击返回，保留订单，订单时间延长15分钟
    public function actionLockShoppingOrderExtenFifteenMinutes($shoppingOrderId,$ticketList){
            $checkList=json_decode($ticketList);
            $tempShopOrder=testShoppingInfo::model()->find('id='.$shoppingOrderId);
            $current_time=date("Y-m-d H:i:s");
            $future_time_stamp = strtotime($current_time) + (15 * 60);
            $limit_time=date('Y-m-d H:i:s',$future_time_stamp);
            put_msg('当前： '.date("Y-m-d H:i:s"));
            put_msg('限制： '.$limit_time);
            $tempShopOrder->limit_time=$limit_time;
            $tempShopOrder->save();
            put_msg('订单号码： '.$tempShopOrder->id);
            foreach($checkList as $each){
             $tempTicket=testTicketDetail::model()->find('id='.$each);
             $tempTicket->limit_time=$limit_time;
             put_msg($tempTicket->limit_time);
             $tempTicket->save();
           }
           echo CJSON::encode('延长订单成功！');
    }

    public function actionaddShopping($stadium_id,$stadium_name,$list,$add_code,$add_name,$add_phone,$money,$coach,$mode=1){
        $backArray=testShoppingInfo::model()->addShopping($stadium_id,$stadium_name,$list,$add_code,$add_name,$add_phone,$money,'','',$coach,$mode);
        echo CJSON::encode($backArray);
    }

    public function actiongetCredit($id){
        $user=userlist::model()->find('GF_ID='.$id);
        echo CJSON::encode($user->CREDIT);
    }

    public function actionsubCredit($id,$credit,$subcredit){
        $user=userlist::model()->find('GF_ID='.$id);
        $user->CREDIT=$credit;
        $user->save();
        $model=new TopScoreHistory;
        $model->gf_id=$id;
        $model->get_score_game_reson="购买消耗";
        $model->credit=$subcredit;
        $model->uDate=date('Y-m-d-H-i-s');
        $model->credit_type="消耗";
        $model->type="积分";
        $model->save();
        $newuser=userlist::model()->find('GF_ID='.$id);
        $newuser->CREDIT=$newuser->CREDIT+$subcredit;
        $newuser->save();
        $newmodel=new TopScoreHistory;
        $newmodel->gf_id=$id;
        $newmodel->get_score_game_reson="购买赠送";
        $newmodel->credit=$subcredit;
        $newmodel->uDate=date('Y-m-d-H-i-s');
        $newmodel->credit_type="获得";
        $newmodel->type="积分";
        $newmodel->save();
        $quan=new TopScoreHistory;
        $quan->gf_id=$id;
        $quan->get_score_game_reson="购买赠送";
        $quan->credit=$subcredit;
        $quan->uDate=date('Y-m-d-H-i-s');
        $quan->credit_type="获得";
        $quan->type="优惠券";
        $quan->save();
        echo CJSON::encode('成功');
    }

    public function actionSubQuan($id,$money,$qid){
        $user=userlist::model()->find('GF_ID='.$id);
        $user->CREDIT=$user->CREDIT+$money;
        $user->save();
        $oldquan=TopScoreHistory::model()->find('id='.$id);
        $newquan=new TopScoreHistory;
        $newquan->gf_id=$id;
        $newquan->get_score_game_reson="支付使用";
        $newquan->credit=$oldquan->credit;
        $newquan->uDate=date('Y-m-d-H-i-s');
        $newquan->credit_type="消耗";
        $newquan->type="优惠券";
        $newquan->save();
        echo CJSON::encode('成功');
    }

    public function actiongetQuan($id){
        $model=TopScoreHistory::model()->findAll('gf_id='.$id.' and type="优惠券" and credit_type="获得"');
        echo CJSON::encode($model);
    }

    public function actionIndex($keywords = '',$start='',$end='',$order_type='',$is_excel=0){
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $club_code=get_session('club_code');
        $club_stadium=testStadium::model()->findAll("comCode = '".$club_code."'");
        $ids=[];
        foreach($club_stadium as $cs){
            array_push($ids, $cs['id']);
        }
        $ids_str=implode(", ",$ids);
        $criteria = new CDbCriteria;
        $cr='';
        if(!empty($ids_str)){
            $cr.='t.stadium_id in ('.$ids_str.')';
        }
        $cr=get_where($cr,!empty($order_type),' t.order_type',$order_type,'');
        $cr=get_like($cr,'order_code,add_code,stadium_name',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order = 'add_date DESC';
        $data = array();
        $data['order_type'] = BaseCode::model()->findAll('f_id in (1700,1701,1702)');
        parent::_list($model, $criteria, 'index', $data);
    }

    public function actionUpdate($id){
        if (!Yii::app()->request->isPostRequest) {
            $criteria = new CDbCriteria;
            $criteria->condition = 'info_id=:id';
            $criteria->params = array(':id'=>$id);
            $criteria->order = 'product_id ASC';
            $data['arclist'] = testShoppingDetail::model()->findAll($criteria);
            $this->render('update', $data);
        } else {
            $this->saveData($model, $_POST[$modelName]);
        }
    }

}