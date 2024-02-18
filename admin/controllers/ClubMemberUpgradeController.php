<?php

class ClubMemberUpgradeController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }


    public function actionIndex_pay($keywords = '',$time_start='',$time_end='',$free_state_Id='',$project_id='',$member_level='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($free_state_Id==''){
            $criteria->condition = '!isNull(order_num) and free_state_Id in(1195,1201)'; 
            $time_start=$time_start=='' ? date("Y-m-d") : $time_start;
            $time_end=$time_end=='' ? date("Y-m-d") : $time_end;
            if ($time_start != '') {
                $criteria->condition.=' AND left(send_date,10)>="'.$time_start.'"';
            }
            if ($time_end != '') {
                $criteria->condition.=' AND left(send_date,10)<="'.$time_end.'"';
            }
        }else{
            $criteria->condition = 'isNull(order_num) and auth_state=929 and free_state_Id=1200';
        }
        $criteria->condition = get_where($criteria->condition,!empty($project_id),'project_id',$project_id,'');
        $criteria->condition = get_where($criteria->condition,!empty($member_level),'member_level',$member_level,'');
        $criteria->join = "JOIN userlist on t.gf_id = userlist.GF_ID";
        $criteria->condition=get_like($criteria->condition,'userlist.ZSXM,userlist.GF_ACCOUNT',$keywords,'');
        $criteria->order = 'achieve_time DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['fee_list'] = ClubMembershipFeeScaleInfo::model()->findAll('fee_code="TS05" and club_id='.get_session('club_id'));
        $data['count1'] = $model->count('isNull(order_num) and auth_state=929 and free_state_Id=1200');
        $data['project_list'] = ProjectList::model()->getProject();
        $data['level'] = ServicerLevel::model()->findAll('type=1472 and if_del=510');
        parent::_list($model, $criteria, 'index_pay', $data);
    }

    public function actionScaleInfo($id,$par,$check_all,$time_start,$time_end){
        $modelName = $this->model;
        $count = explode(',',$id);
        $fee_info = ClubMembershipFeeScaleInfo::model()->find('id='.$par);
        if($check_all==0){
            foreach($count as $d){
                $model = $this->loadModel($d,$modelName);
                if(!empty($fee_info) && !empty($model->qualification_level)){
                    $data_info = ClubMembershipFeeData::model()->find(' product_id='.$fee_info->product_id.' and scale_info_id='.$fee_info->id.' and levelid='.$model->member_level);
                    if(!empty($data_info)){
                        $upgrade=ClubMemberUpgrade::model()->find('id='.$d.' and cost_admission='.$data_info->scale_amount.' and pay_blueprint='.$fee_info->id);
                        if(empty($upgrade)){
                            $sv=ClubMemberUpgrade::model()->updateByPk($d, array('cost_admission' => $data_info->scale_amount,'cost_account'=>$data_info->scale_amount,'pay_blueprint'=>$fee_info->id,'pay_blueprint_name'=>$fee_info->name));
                        }else{
                            $sv=1;
                        }

                    }
                }
            }
        }
        if($sv==0){
            show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
        }
    }
    /**
     * 免费/有偿入驻操作
     */
    public function actionWhole($id) {
        $this->actionSend($id);
    }

    /**
     * 免费/有偿入驻的执行actionSend这个方法
     * 免费/有偿入驻的首先查找会员相关收费项目表club_membership_fee这个表的入驻商品编号.
     * 然后查找会员等级明细表club_membership_fee_data，把符合等级的并且价格不为0的数据存入商品编号进入购物车表mall_shopping_settlement与mall_shopping_car_copy.
     * 
     * 通知缴费操作会保存一条信息到购物车列表.
     * 缴费后确认缴费操作回填一条到会员信息明细表club_membership_fee_data_list.
     * 
     * 通知缴费操作.
     * 分别存购物车账单表和购物车详细表.
     */
    public function actionSend($id) {
        $modelName = $this->model;
        $count = explode(',',$id);
        foreach($count as $d){
            $model = $this->loadModel($d, $modelName);
            $base_code = BaseCode::model()->find('f_id=359');
            if($model->free_state_Id!=1200){
                $sf = 0;
                continue;
            }
            // $ship_fee = ClubMembershipFee::model()->find('code="TS20"');
            $ship_info = ClubMembershipFeeScaleInfo::model()->find('club_id='.get_session('club_id').' and id='.$model->pay_blueprint);
            if(!empty($ship_info)){
                $fee_data = ClubMembershipFeeData::model()->find('levelid='.$model->member_level.' and product_id='.$ship_info->product_id.' and scale_info_id='.$model->pay_blueprint);
            }
            // 如果$fee_data不等于空并且$fee_data->scale_amount大于0，就执行保存到购物车，否则保存到会员明细表
            if(empty($fee_data)){
                $sf=0;
            }elseif($fee_data->scale_amount>0){
                // 购物车账单
                $gf_user=userlist::model()->find('GF_ID='.$model->gf_id);
		        $order_data=array('order_type'=>359
		        	,'buyer_type'=>1472
			        ,'order_gfid'=>$model->gfid
			        ,'money'=>$fee_data->scale_amount
			        ,'order_money'=>$fee_data->scale_amount
			        ,'total_money'=>$fee_data->scale_amount
			        ,'effective_time'=>date('Y-m-d H:i:s',strtotime('+3 day')));
				$add_order=Carinfo::model()->addOrder($order_data);
				if(empty($add_order['order_num'])){
					$sv=0;
				}else{
					$sv=1;
					// 购物车详细
	                $cat_copy = new CardataCopy();
	                $cat_copy->isNewRecord = true;
	                unset($cat_copy->id);
	                $cat_copy->order_num = $add_order['order_num'];
	                $cat_copy->order_type = 359;
	                $cat_copy->order_type_name = $base_code->F_NAME;
	                $cat_copy->product_id = $fee_data->product_id;
	                $cat_copy->product_code = $fee_data->product_code;
	                $cat_copy->product_title = $fee_data->product_name;
	                $cat_copy->product_data_id = $fee_data->product_id;
	                $cat_copy->json_attr = $fee_data->json_attr;
	                $cat_copy->supplier_id = $fee_data->gf_club_id;
	                $cat_copy->buy_price = $fee_data->scale_amount;  // 商品单价
	                $cat_copy->buy_amount = $fee_data->scale_amount;  // 购买实际金额
	                $cat_copy->project_id = $model->project_id;
	                $cat_copy->project_name = $model->project_name;
	                $cat_copy->buy_level = $model->member_level;
	                $cat_copy->buy_level_no = $model->member_level_xh;
	                $cat_copy->buy_level_name = $model->member_level_name;
	                $cat_copy->buy_count = 1;
	                $cat_copy->total_pay = $fee_data->scale_amount;
	                $cat_copy->gfid = $model->gf_id;
	                $cat_copy->gf_name = $gf_user->zsxm;
	                $cat_copy->uDate = date('Y-m-d H:i:s');
	                $cat_copy->gf_club_id = get_session('club_id');
	                $cat_copy->effective_time = $order_data['effective_time'];
	                $st=$cat_copy->save();
	
	                $sd=ClubMemberUpgrade::model()->updateByPk($d, array('order_num'=>$add_order['order_num'],'send_oper'=>get_session('admin_name'),'send_date'=>date('Y-m-d H:i:s'),'cut_date'=>date('Y-m-d H:i:s', strtotime('3 days')),'free_state_Id'=>1195,'auth_state'=>930,'pay_way'=>12));
				}

                if($sv==1 && $st==1 && $sd==1 ){
                    $sf=1;
                    if($sf==1){
                        $basepath=BasePath::model()->getPath(191); 
                        $club=ClubList::model()->find("id=".get_session('club_id'));
                        $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                        $title=$fee_data->product_name;
                        $content='恭喜，您的资料已通过初审！龙虎注册费用为：'.$fee_data->scale_amount.'元/项目/年，请您在支付时间内完成支付。';
                        $url='';
                        $sendArr=array('type'=>'【龙虎注册缴费通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'order_num'=>$add_order['order_num']);
                        // send_msg(314,get_session('club_id'),$model->gfid,$sendArr);
                    }
                }
                else{
                    $sf=0;
                }
            }elseif($fee_data->scale_amount<=0){
                $this->actionFree($d,1373);
            }
        }
        show_status($sf,'发送成功',Yii::app()->request->urlReferrer,'发送失败');
    }

    /**
     * 免单入驻,直接存进会员明细表club_membership_fee_data_list.
     * 不生成订单号，如果金额不为空，金额填入会员明细表.
     * 
     * 识别价格为0的也执行这个方法.
     */
    public function actionFree($id,$pay_way='') {
        $modelName = $this->model;
        $len = explode(',',$id);
        foreach($len as $v){
            $model = $this->loadModel($v,$modelName);
            $ship_fee = ClubMembershipFee::model()->find('code="TS20"');
            $ship_info = ClubMembershipFeeScaleInfo::model()->find('id='.$model->pay_blueprint);
            if(!empty($ship_fee) && !empty($ship_info)){
                $fee_data = ClubMembershipFeeData::model()->find('levelid='.$model->member_level.' and product_id='.$ship_info->product_id.' and scale_info_id='.$model->pay_blueprint);
            }
            $fee_list = new ClubMembershipFeeDataList;
            $fee_list->isNewRecord = true;
            unset($fee_list->id);
            $gf_user=userlist::model()->find('GF_ID='.$model->gf_id);
            if(!empty($fee_data)){
                $fee_list->scale_list_Id = $fee_data->scale_list_Id;
                $fee_list->scale_data_id = $fee_data->id;
                $fee_list->scale_code = $fee_data->scale_code;
                $fee_list->feeid = $fee_data->feeid;
                $fee_list->code = $fee_data->code;
                $fee_list->name = $fee_data->name;
                $fee_list->levetypeid = $fee_data->levetypeid;
                $fee_list->product_id = $fee_data->product_id;
                $fee_list->product_code = $fee_data->product_code;
                $fee_list->product_name = $fee_data->product_name;
                $fee_list->json_attr = $fee_data->json_attr;
            }
            $fee_list->fee_type = 403;
            $fee_list->f_userdate = date('Y-m-d H:i:s');
            // $fee_list->club_id = get_session('club_id');
            // $fee_list->club_name = get_session('club_name');
            $fee_list->gf_id = $model->gf_id;
            $fee_list->gf_name = $gf_user->zsxm;
            $fee_list->project_id = $model->project_id;
            $fee_list->project_name = $model->project_name;
            $fee_list->levelid = $model->member_level;
            $fee_list->levelname = $model->member_level_name;
            $fee_list->f_username = get_session('admin_name');
            $fee_list->f_freemark = 0;  // 0代表免费
            $fee_list->club_member_upgrade_id = $model->id;
            $sv=$fee_list->save();

            if($pay_way==''){
                $pay_way=1374;
            }
            $sn=ClubMemberUpgrade::model()->updateByPk($v, array('send_oper'=>get_session('admin_name'),'free_charge'=>$model->cost_admission,'cost_account'=>0,'send_date'=>date('Y-m-d H:i:s'),'free_state_Id'=>1201,'auth_state'=>1391,'pay_way'=>$pay_way));

            if($sv==1 && $sn==1){
                $sf=1;
                if($sf==1){
                    $basepath=BasePath::model()->getPath(191); 
                    $club=ClubList::model()->find("id=".get_session('club_id'));
                    $pic=$basepath->F_WWWPATH.$club->club_logo_pic;
                    $title='龙虎注册缴费通知';
                    $content='恭喜，您的资料已通过初审！龙虎注册费用为：'.$model->cost_admission.'元/项目/年（已免单）。';
                    $url='';
                    $type_id=24;
                    $datas=array(array('id'=>$model->id,'auth_state'=>$model->auth_state,'auth_state_name'=>$model->auth_state_name));
                    $sendArr=array('type'=>'【龙虎注册缴费通知】','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>$url,'type_id'=>$type_id,'datas'=>$datas);
                    // game_audit(get_session('club_id'),$model->gfid,$sendArr);
                }
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    /**
     * 取消通知，通过删除购物车数据来取消
     */
    public function actionUnsend($id) {
        $len = explode(',',$id);
        foreach($len as $v){
            $model = ClubMemberUpgrade::model()->find('id='.$v);
            if(!empty($model)){
                // $count->updateByPk($count->id,array('if_del'=>649));
                Carinfo::model()->deleteAll('order_num="'.$model->order_num.'"');
                CardataCopy::model()->deleteAll('order_num="'.$model->order_num.'"');
                ClubMembershipFeeDataList::model()->deleteAll('club_member_upgrade_id='.$model->id);
                $model->updateByPk($v,array('order_num'=>'','free_state_Id'=>1200,'free_state_name'=>'待通知','is_pay'=>463,'auth_state'=>929,'pay_way'=>null,'pay_way_name'=>null));
                $sf=1;
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    /**
     * 龙虎注册缴费待确认列表
     */
    public function actionIndex_confirmed($keywords = '',$project='',$member_level='',$time_start='',$time_end='',$free_state_Id='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        if($free_state_Id==''){
            $criteria->condition = '!isNull(order_num) and free_state_Id=1202'; 
        }else{
            $criteria->condition = '!isNull(order_num) and free_state_Id='.$free_state_Id; 
        }
        $criteria->condition = get_where($criteria->condition,!empty($project),'project_id',$project,'');
        $criteria->condition = get_where($criteria->condition,!empty($member_level),'member_level',$member_level,'');
        if($free_state_Id==1202||empty($free_state_Id)){
            $time_start=$time_start=='' ? date("Y-m-d") : $time_start;
            $time_end=$time_end=='' ? date("Y-m-d") : $time_end;
            if ($time_start != '') {
                $criteria->condition.=' AND left(grade_achieve_time,10)>="'.$time_start.'"';
            }
            if ($time_end != '') {
                $criteria->condition.=' AND left(grade_achieve_time,10)<="'.$time_end.'"';
            }
        }
        $criteria->join = "JOIN userlist on t.gf_id = userlist.GF_ID";
        $criteria->condition=get_like($criteria->condition,'userlist.ZSXM,userlist.GF_ACCOUNT',$keywords,'');
        $criteria->order = 't.grade_achieve_time DESC';  
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['project'] = ProjectList::model()->getProject();
        $data['level'] = ServicerLevel::model()->findAll('type=1472 and if_del=510');
        $data['count1'] = $model->count('!isNull(order_num) and free_state_Id=1201');
        parent::_list($model, $criteria, 'index_confirmed', $data);
    }

    /**
     * 待确认
     */
    public function actionConfirmed($id) {
        $modelName = $this->model;
        $n = explode(',',$id);
        foreach($n as $v){
            $model = $this->loadModel($v,$modelName);
            if($model->free_state_Id==1202) {
                $sf=0;
                continue;
            }
            
            $mall_info = MallSalesOrderInfo::model()->find('order_num="'.$model->order_num.'"');
            $ship_info = ClubMembershipFeeScaleInfo::model()->find('id='.$model->pay_blueprint);
            if(!empty($ship_info)){
                $fee_data = ClubMembershipFeeData::model()->find('levelid='.$model->member_level.' and product_id='.$ship_info->product_id.' and scale_info_id='.$ship_info->id);
            }
            $fee_list = ClubMembershipFeeDataList::model()->find('club_member_upgrade_id='.$model->id);
            if(empty($fee_list)){
                $fee_list = new ClubMembershipFeeDataList;
                $fee_list->isNewRecord = true;
                unset($fee_list->id);
            }
            if(!empty($fee_data)){
                $fee_list->scale_info_id = $fee_data->scale_info_id;
                $fee_list->scale_list_Id = $fee_data->scale_list_Id;
                $fee_list->scale_data_id = $fee_data->id;
                $fee_list->scale_code = $fee_data->scale_code;
                $fee_list->feeid = $fee_data->feeid;
                $fee_list->code = $fee_data->code;
                $fee_list->name = $fee_data->name;
                $fee_list->levetypeid = $fee_data->levetypeid;
                $fee_list->product_id = $fee_data->product_id;
                $fee_list->product_code = $fee_data->product_code;
                $fee_list->product_name = $fee_data->product_name;
                $fee_list->json_attr = $fee_data->json_attr;
            }
            if(!empty($mall_info)){
                $fee_list->scale_no = $mall_info->payment_code;
                $fee_list->scale_type = $mall_info->pay_supplier_type_name;
                $fee_list->date_start_scale = $mall_info->order_Date;
                $fee_list->date_end_scale = $mall_info->pay_time;
                $fee_list->date_scale = $mall_info->pay_time;
                $fee_list->scale_amount = $mall_info->total_money;
            }
            $fee_list->fee_type = 403;
            $gf_user=userlist::model()->find('GF_ID='.$model->gf_id);
            $fee_list->gf_id = $model->gf_id;
            $fee_list->gf_name = $gf_user->zsxm;
            $fee_list->project_id = $model->project_id;
            $fee_list->project_name = $model->project_name;
            $fee_list->levelid = $model->member_level;
            $fee_list->levelname = $model->member_level_name;
            $fee_list->f_username = get_session('admin_name');
            $fee_list->club_member_upgrade_id = $model->id;
            $fee_list->order_num = $model->order_num;
            $sv=$fee_list->save();

            $day='';
            $sLevel=ServicerLevel::model()->find('type=1472 and id='.$model->member_level);
            $cType=ClubServicerType::model()->find('type=1472 and member_second_id='.$sLevel->member_second_id);
            $day=date('Y-m-d H:i:s', strtotime("".$cType->renew_time." day"));
            $now_date=get_date();
            $sn=ClubMemberUpgrade::model()->updateByPk($v, array('cost_oper' => get_session('admin_name'),'auth_state'=>931,'is_pay'=>464,'free_state_Id'=>1202,'entry_validity'=>$now_date,'grade_achieve_time'=>$now_date));
            if($sv==1 && $sn==1){
            	$foot=new GfUserFoot();
                unset($foot->id);
            	$foot->GF_ID=$model->gf_id;
            	$foot->content='注册了“'.$model->project_name.'-'.$model->member_level_name.'”龙虎组别';
            	$foot->time=$now_date;
            	$foot->save();
            	
                $sf=1;

                // 龙虎注册之后会员兑换消费积分
                $credit_set=GfCredit::model()->find('object=1476 and item_type=359 and consumer_type=210');
                if(!empty($credit_set)){
                    if(round($model->cost_account)>0){
                        $gl = new GfCreditHistory();
                        $gl->isNewRecord = true;
                        unset($gl->id);
                        $gl->object=210;
                        $gl->gf_id=$model->gf_id;
                        $gl->get_object=210;
                        $gl->get_id=$model->gf_id;
                        $gl->item_code=$credit_set->id;
                        $gl->service_source='龙虎注册';
                        $gl->order_num=$model->order_num;
                        $gl->add_or_reduce=1;
                        $gl->credit=round($model->cost_account/($credit_set->value/$credit_set->credit));
                        $gl->add_time=date('Y-m-d H:i:s');
                        $gl->save();
                    }
                }
            }
            else{
                $sf=0;
            }
        }
        show_status($sf,'已确认',Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
    
    function saveData($model,$post) {
        $model->attributes =$post;
         $st=$model->save();
         show_status($st,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }




    public function actionDelete($id) {
        parent::_clear($id);
    }



}
