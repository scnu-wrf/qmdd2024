<?php

    class ForgetPasswordController extends BaseController {
        protected $model = '';

        public function init(){
            // $this->model = substr(__CLASS__,0,-10);
            $this->model = 'ForgetPassword';
            parent::init();
        }

        public function actionLogin(){
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            parent::_list($model, $criteria, 'login');
        }

        // function saveData($model,$post){
        //     $model->attributs = $post;
        //     $sv=$model->save();
        //     $show_status($sv,'发送成功'/*,Yii::app()->request->urlReferrer,'发送失败'*/);
        // }

        public function actionGetPhoneNumber($account){
            $data=QmddAdministrators::model()->find('admin_gfaccount='.$account);
            date_default_timezone_set('Asia/Shanghai');
            $model2 = new PhoneSmsLog();
            $rand=rand(1000,9999);
            // if(!empty($data)){
            //     $model2->isNewRecord = true;
            //     unset($model2->id);
            //     $model2->phone_code=86;
            //     $model2->phone=$data->phone;
            //     $model2->sms_code=$rand;
            //     $model2->type=2;
            //     $model2->device_type=1;
            //     $model2->uDate=date('Y-m-d H:i:s');
            //     $model2->send_time=date('Y-m-d H:i:s');
            //     $model2->save();
            // }
            if($data['phone']!=''){
                $data['id']=$data['phone'];
                $phone=$data['phone'];
                $P1=substr($phone, 0,3);
                $P2=substr($phone, 7,10);
                $P=$P1."****".$P2;
                $data['phone']=$P;
            }
            // sendSms($data['id'],"您的验证码是：".$rand."。请不要把验证码泄露给其他人。");
            echo CJSON::encode($data);
        }

        public function actionDataSms($mobile){
            $data=PhoneSmsLog::model()->find('phone='.$mobile.' AND id order by id DESC');
            echo CJSON::encode($data);
        }

        public function actionYanCode($gfaccount,$phone,$inputcode,$yancode){
            $data=PhoneSmsLog::model()->find('sms_code='.$inputcode.' AND phone='.$phone);
            $data->updateByPk($data['id'],array('send_state'=>1,'if_user'=>649));
            echo CJSON::encode($data);
        }

        public function actionNewpsd($id,$new_pass,$account){
            $data=QmddAdministrators::model()->find('phone='.$id.' AND admin_gfaccount='.$account);
            $ec_salt=rand(1000,9999);
            $new_pass=pass_md5($ec_salt,$new_pass);
            $data->updateByPk($data['id'],array('password'=>$new_pass,'ec_salt'=>$ec_salt));
            echo CJSON::encode($data);
        }
    }