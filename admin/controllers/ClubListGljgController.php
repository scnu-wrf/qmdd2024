<?php

class ClubListGljgController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex_add($keywords='',$start_date='',$end_date='',$to_day=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'member_code = "U01" and state = 721 and unit_state = 648 ';
        $criteria->order = 'id DESC';
        $data = array();
        date_default_timezone_set('Asia/Shanghai');
        $current_time = (date("Y-m-d"));
        $data['count1'] = $model->count('member_code = "U01" and state = 721 and left(apply_time,10) = "'.$current_time.'"');
        parent::_list($model, $criteria, 'index_add', $data);
    }


    public function actionIndex_glbm($keywords='',$start_date='',$end_date='',$to_day=0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'member_code_second = "U0101" and state = 2 and unit_state = 648 ';
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'index_glbm', $data);
    }

    public function actionIndex_xmgs($keywords='',$start_date='',$end_date='',$to_day=0) {

        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'member_code_second = "U0110" and state = 2 and unit_state = 648 ';
        $criteria->order = 'id DESC';

        $data = array();
        parent::_list($model, $criteria, 'index_xmgs', $data);
    }


    public function actionIndex_unit_cancel($keywords='',$start_date='',$end_date='',$to_day=0) {

        set_cookie('_currentUrl_', Yii::app()->request->url);

        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'member_code_second = "U0110" and state = 2';
        //if($to_day==1){
        //$criteria->condition .= ' and left(apply_time,10)="'.date('Y-m-d').'"';
        //}
        $criteria->order = 'id DESC';

        $data = array();
        parent::_list($model, $criteria, 'index_unit_cancel', $data);
    }


    public function actionCreate() {

        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();

        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $data['project_list'] = array();
            $data['province']='';
            $data['city']='';
            $data['area']='';
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST);

        }

    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();

        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if($model->state==721){
                $data['project_list'] = ClubProject::model()->findAll('club_id in ('.$id.') and project_state=506');
            }else{
                $data['project_list'] = ClubProject::model()->findAll('club_id in ('.$id.') and project_state=506 and auth_state=461 and state=2');
            }
            $data['sign_type'] = ClubType::model()->findAll('length(f_ctcode)=3 order by f_ctcode');
            $data['province']=$model->club_area_province;
            $data['city']=$model->club_area_city;
            $data['area']=$model->club_area_district;
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST);
        }
    }

    public function actionGetType(){
        $code = $_POST['code'];
        $f_code = ClubType::model()->findAll('left(f_ctcode,3)="'.$code.'" and length(f_ctcode)>3');
        $ar = array();
        if(!empty($f_code))foreach($f_code as $key => $val){
            $ar[$key]['id'] = $val->id;
            $ar[$key]['f_ctcode'] = $val->f_ctcode;
            $ar[$key]['f_ctname'] = $val->f_ctname;
        }
        echo CJSON::encode($ar);
    }

	function saveData($model,$post) {
       $model->check_save(1);
       $model->attributes = $post;
       $modelName = $this->model;
       $model->attributes = $_POST[$modelName];
       $model->approve_state=453;
		if ($_POST['submitType'] == 'shenhe') {
            $model->state = 371;
			$model->edit_state = 371;
            $yes='提交成功';
            $no='提交失败';
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
			$model->edit_state = 721;
            $yes='保存成功';
            $no='保存失败';
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
			$model->edit_state = 2;
            $model->pass_time = date('Y-m-d H:i:s');
            $yes='操作成功';
            $no='操作失败';
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
			$model->edit_state = 373;
            $model->pass_time = date('Y-m-d H:i:s');
            $yes='操作成功';
            $no='操作失败';
        } else {
            $model->state = 721;
			$model->edit_state = 721;
            $yes='保存成功';
            $no='保存失败';
        }
        // $model->club_name = $_POST[$modelName]['company'];
        $model->club_area_province = $_POST['province'];
        $model->club_area_city = $_POST['city'];
        $model->club_area_district = $_POST['area'];
        $st=$model->save();

        if($st==1){
            // 保存图集
            ClubListPic::model()->deleteAll('club_id=' . $model->id);
            if(!empty($_POST[$modelName]['club_list_pic'])){
                $model2 = new ClubListPic();
                $club_list_pic = array();
                $club_list_pic = explode(',', $_POST[$modelName]['club_list_pic']);
                $club_list_pic = array_unique($club_list_pic);
                foreach ($club_list_pic as $v2) {
                    $model2->isNewRecord = true;
                    unset($model2->id);
                    $model2->club_id = $model->id;
                    $model2->club_aualifications_pic = $v2;
                    $sa=$model2->save();
                }
            }

            if(!empty($_POST[$modelName]['remove_project_ids'])){
                $count = ClubProject::model()->deleteAll('club_id='.$model->id.' and project_id in('.$_POST[$modelName]['remove_project_ids'].')');
            }

            
            if(!empty($_POST[$modelName]['project_list']))foreach (explode(",",$_POST[$modelName]['project_list']) as $v) {
                $cp=ClubProject::model()->find('club_id='.$model->id.' and project_id='.$v);
                if(empty($cp)){
                    $cp = new ClubProject();
                    $cp->isNewRecord = true;
                    unset($cp->id);
                    $cp->club_id=$model->id;
                    $cp->project_id=$v;
                }
                $cp->p_code = $model->club_code;
                $cp->approve_state = $model->approve_state;
                $club_list_pic2=ClubListPic::model()->findall('club_id='.$model->id);
                $pic='';
                foreach ($club_list_pic2 as $p) {
                    $pic.=$p->club_aualifications_pic.'|';
                }
                $cp->qualification_pics = rtrim($pic, "|");
                $cp->pay_way = 1373;
                $cp->entry_validity = date('Y-m-d H:i:s');
                $cp->effective_date = date('Y-m-d H:i:s');
                $cp->state = $model->state;
                if($model->state==2){
                    $cp->auth_state = 461;
                    $cp->free_state_Id = 1202;
                }
                $cp->admin_gfid = get_session('admin_gfid');
                $cp->admin_gfname = get_session('admin_name');
                $cp->club_type = $model->club_type;
                $cp->club_type_name = $model->club_type_name;
                $cp->partnership_type = $model->partnership_type;
                $cp->partnership_name = $model->partnership_name;
                $st=$cp->save();
            }

            if($model->state==2){
                $data = QmddAdministrators::model()->find('club_id='.$model->id);
                // $role = QmddRoleClub::model()->find('f_club_item_type='.$model->club_type);
                if(empty($data)){
                    $data = new QmddAdministrators();
                    $data->isNewRecord=true;
                    unset($data->f_id);
                }
                $data->club_id=$model->id;
                $data->admin_gfaccount=$model->club_code;
                $data->club_name=$model->company;
                $data->lang_type=0;
                $data->admin_level=35;
                $data->role_name='集团公司';
                $st=$data->save();
            }
        }
	    show_status($st,$yes, get_cookie('_currentUrl_'),$no);
 }




// 帐号验证
    public function actionValidate($gf_account=0) {
        $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
        if(!empty($user)) {
            if($user->passed==2) {
                ajax_status_gamesign(1, $user->GF_ID);
            } else {
                ajax_status(0, '帐号未实名');
            }
        } else {
            ajax_status(0, '帐号不存在');
        }

    }

    // 身份证验证（由视图触发）
    public function actionCheck_id_card($id_card) {
        $idc =  $this->is_idcard($id_card);
        if($idc==1){

        }else{
            ajax_status(0, '身份证号码有误');
        }
    }

   // 身份证验证
    function is_idcard( $id ){

        $id = strtoupper($id);

        $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/";

        $arr_split = array();

        if(!preg_match($regx, $id))

        {

            return FALSE;

        }

        if(15==strlen($id)) //检查15位

        {

            $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/";



            @preg_match($regx, $id, $arr_split);

            //检查生日日期是否正确

            $dtm_birth = "19".$arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];

            if(!strtotime($dtm_birth))

            {

                return FALSE;

            } else {

                return TRUE;

            }

        }

        else      //检查18位

        {

            $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/";

            @preg_match($regx, $id, $arr_split);

            $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4];

            if(@!strtotime($dtm_birth)) //检查生日日期是否正确

            {

                return FALSE;

            }

            else

            {

                //检验18位身份证的校验码是否正确。

                //校验位按照ISO 7064:1983.MOD 11-2的规定生成，X可以认为是数字10。

                $arr_int = array(7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2);

                $arr_ch = array('1', '0', 'X', '9', '8', '7', '6', '5', '4', '3', '2');

                $sign = 0;

                for ( $i = 0; $i < 17; $i++ )

                {

                    $b = (int) $id{$i};

                    $w = $arr_int[$i];

                    $sign += $b * $w;

                }

                $n = $sign % 11;

                $val_num = $arr_ch[$n];

                if ($val_num != substr($id,17, 1))

                {

                    return FALSE;

                }

                else

                {

                    return TRUE;

                }

            }

        }



    }

//逻辑删除
  public function actionDelete($id) {
        parent::_delete($id);
    }

}



