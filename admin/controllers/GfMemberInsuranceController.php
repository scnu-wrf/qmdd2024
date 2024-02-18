<?php

class GfMemberInsuranceController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
    public function actionIndex($keywords = '', $Insurance_type = '', $start_date = '', $end_date = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where($criteria->condition,!empty($Insurance_type),'t.insurance_type',$Insurance_type,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'t.insurance_date_star>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'t.insurance_date_end<=',$end_date,'"');
		$criteria->condition=get_like($criteria->condition,'gf_account,gf_name',$keywords,'');
        $criteria->order = 'id ASC';
        $data = array();
		$data['Insurance_type']=MallProductsTypeSname::model()->getCode(153);
        parent::_list($model, $criteria, 'index', $data);
    }
    
    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['insurance_img']=array();
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
			$data['insurance_img'] = array();
            if ($model->insurance_img != '') {
                $data['insurance_img'] = explode(',', $model->insurance_img);
            }
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
	
	public function actionRecognizee($data_id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$arr = array();
		$recognizee=GameSignList::model()->findAll('sign_game_data_id='.$data_id.' AND game_man_type=997 AND state=2 AND is_pay=464 AND sign_gfid is not NULL');
		$r=0;
		if(!empty($recognizee)){
			foreach ($recognizee as $v) {
				$sign_user=userlist::model()->find('GF_ID='.$v->sign_gfid);
				$arr[$r]['gf_id'] = $v->sign_gfid;
				$arr[$r]['gf_account'] = $v->sign_account;
				$arr[$r]['gf_name'] = $v->sign_name;
				$arr[$r]['gf_phone'] = $v->sign_game_contect;
				$arr[$r]['id_card_type'] = $sign_user->id_card_type;
				$arr[$r]['id_card_type_name'] = $sign_user->id_card_type_name;
				$arr[$r]['id_card'] = $sign_user->id_card;
				$r=$r+1;
			}
			//ajax_status(1, $arr);
			ajax_exit($arr);
		} //else {
			//ajax_status(0, '该服务规格没有符合条件的被保人');
		//}
    }
	
	// 获取投保人帐号信息
    public function actionAchieve($gf_account=0) {
	   $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
	   if(!empty($user)) {
	   	  ajax_status_Insurance(1, $user->GF_ID, $user->ZSXM,$user->PHONE,$user->id_card_type,$user->id_card_type_name,$user->id_card);
		} else {
			ajax_status(0, '帐号不存在');
		}

	}
	// 获取被保人帐号信息
    public function actionInsured($gf_account=0) {
	   $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
	   if(!empty($user)) {
	   	  ajax_status_Insurance(1, $user->GF_ID, $user->ZSXM,$user->PHONE,$user->id_card_type,$user->id_card_type_name,$user->id_card);
		} else {
			ajax_status(0, '帐号不存在');
		}

	}

    function saveData($model,$post){
        $model->attributes = $post;
		if ($_POST['submitType'] == 'shenhe') {
			$model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
        $sv = $model->save();
		$this->save_user_list($model->id,$post['user_list']);
        show_status($sv, '保存成功', get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    public function save_user_list($id,$user_list){
         $userlist=GfInsuredInsurance::model()->findAll('insurance_id='.$id);
        $arr=array();
        $insured = new GfInsuredInsurance();
        // 保存体检信息
        if(isset($_POST['user_list'])){
            foreach($_POST['user_list'] as $v){
				if ($v['gf_id'] == '' || $v['gf_account'] == '') {
               		continue;
             	}
                if($v['id']=='null'){
                    $insured->isNewRecord = true;
                    unset($insured->id);
                    $insured->insurance_id = $id;
                    $insured->gf_id = $v['gf_id'];
                    $insured->gf_account = $v['gf_account'];
                    $insured->gf_name = $v['gf_name'];
                    $insured->gf_phone = $v['gf_phone'];
                    $insured->id_card_type = $v['id_card_type'];
					$insured->id_card = $v['id_card'];
                    $insured->save();
                }
                else{
                    $insured->updateByPk($v['id'],array(
                        'gf_account' => $v['gf_account']
                    ));
                    $arr[]=$v['id'];
                }
            }
        }
         if(isset($userlist)) {
             foreach ($userlist as $k) {
                 if(!in_array($k->id,$arr)) {
                     GfInsuredInsurance::model()->deleteAll('id='.$k->id);
                 }
             }
         }
    }
}

