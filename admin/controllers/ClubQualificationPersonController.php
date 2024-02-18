<?php

class ClubQualificationPersonController extends BaseController {

     protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($start_date='',$end_date='',$sex='',$project = '', $type_id='',$identity='',$type_code='',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $start_date=empty($start_date) ? date("Y-m-d") : $start_date;
        $end_date=empty($end_date) ? date("Y-m-d") : $end_date;
		$criteria->condition = 'if_del=506 and is_del=648 and unit_state=648 and auth_state=931 and check_state=2 and free_state_Id=1202';
        $criteria->condition = get_where($criteria->condition,!empty($sex),'sex',$sex,'');
        $criteria->condition=get_where($criteria->condition,!empty($project),'project_id',$project,'');
		$criteria->condition=get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($identity),'identity_num',$identity,'');
        $criteria->condition=get_where($criteria->condition,!empty($type_code),'qualification_level',$type_code,'');
        $criteria->condition=get_like($criteria->condition,'gfaccount,qualification_name,gf_code',$keywords,'');
        if ($start_date != '') {
            $criteria->condition.=' and left(expiry_date_start,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(expiry_date_start,10)<="' . $end_date . '"';
        }
        $criteria->order = 'entry_validity desc';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
		$data['sex'] = BaseCode::model()->getSex();
        $data['project_list'] = ProjectList::model()->getAll();
		$data['type_id'] = ClubServicerType::model()->findAll('type=501');
		$data['identity'] = ServicerCertificate::model()->findAll('!isNull(fater_id)');
        $data['type_code'] = ServicerLevel::model()->findAll('type=501');
        parent::_list($model, $criteria,'index', $data);
    }
    
    public function actionUpExcel($info='',$logon_way=1460){
        if(isset($_POST['submit'])){
            $attach = CUploadedFile::getInstanceByName('excel_file');
            $sv = 0;
            $info = '';
            if(!empty($attach)){
                if ($attach->getType()=='application/vnd.ms-excel' || $attach->getType()=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                    if($attach->size > 2*1024*1024){
                        $info = "提示：文件大小不能超过2M";  
                    }
                    else{
                        // 获取文件名
                        $excelFile = $attach->getTempName();
                        $extension = $attach->extensionName ;
                        Yii::$enableIncludePath = false;
                        Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
                        $phpexcel = new PHPExcel;
                        if ($extension=='xls') {
                            $excelReader = PHPExcel_IOFactory::createReader('Excel5');
                        } else {
                            $excelReader = PHPExcel_IOFactory::createReader('Excel2007');
                        }
                        $objPHPExcel = $excelReader->load($excelFile);//
                        $sheet = $objPHPExcel->getSheet(0);
                        $highestRow = $sheet->getHighestRow(); // 取得总行数
                        // $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                        if($highestRow>202){
                            $info = "<br>提示：一次导入信息数据最多为200条。";
                        }else{ //检测数据是否符合要求
                            $pj='';
                            $lx='';
                            $zs='';
                            $dj='';
                            for($row=2;$row<=$highestRow;$row++){
                                $zsxm = $sheet->getCell('B'.$row)->getValue();  // 姓名
                                $sex = $sheet->getCell('C'.$row)->getValue();  // 性别
                                $project_name = $sheet->getCell('D'.$row)->getValue();  // 项目
                                $qualification_type = $sheet->getCell('E'.$row)->getValue();  // 服务者类型
                                $identity_type_name = $sheet->getCell('F'.$row)->getValue();  // 服务者资质证书
                                $qualification_title = $sheet->getCell('G'.$row)->getValue();  // 服务者资质等级
                                $native = $sheet->getCell('K'.$row)->getValue();  // 籍贯
                                $nation = $sheet->getCell('L'.$row)->getValue();  // 民族
                                $birthdate = $sheet->getCell('M'.$row)->getValue();  // 出生年月
                                $id_card = $sheet->getCell('N'.$row)->getValue();  // 身份证号

                                if(strlen($zsxm)>0||strlen($sex)>0||strlen($qualification_type)>0||strlen($native)>0||strlen($nation)>0||strlen($birthdate)>0||strlen($id_card)>0){
                                    $le=['B','C','E','K','L','M','N'];
                                    foreach ($le as $l) {
                                        $content=$sheet->getCell($l.$row)->getValue();
                                        if (strlen($content)==0||strlen($content)>120) {
                                            $info = '<br>提示：第'.$l.'列数据不符合要求。内容不能为空，内容长度不能大于120。';
                                            break;
                                        }
                                    }
                                    $cType=ClubServicerType::model()->find('type=501 and member_second_name="'.$qualification_type.'"');
                                    $project=ProjectList::model()->find('project_type=1 and project_name="'.$project_name.'"');
                                    $identity_name=ServicerCertificate::model()->find('isNull(fater_id) and f_name="'.$identity_type_name.'"');
                                    if(!empty($identity_name)){
                                        $identity_level=ServicerCertificate::model()->find('fater_id='.$identity_name->id.' and f_type_name="'.$qualification_title.'"');
                                    }
                                    if(empty($cType)){
                                        $lx.=($lx==''?'':',').$qualification_type;
                                    }
                                    if(!empty($cType) && $cType->if_project==649 && empty($project_name)){
                                        $info .= '<br>第'.$row.'行该'.$qualification_type.'类型的项目不能为空';
                                    }
                                    if(!empty($cType) && $cType->if_project==649){
                                        $p_count=ProjectList::model()->count('project_type=1 and project_name="'.trim($project_name).'"');
                                        if($p_count<=0){
                                            $pj.=($pj==''?'':',').$project_name;
                                        }
                                    }
    
                                    if(!empty($cType->certificate_type)){
                                        if(empty($identity_name)){
                                            $zs.=($zs==''?'':',').$identity_type_name;
                                        }
                                        if(empty($identity_level)){
                                            $dj.=($dj==''?'':',').$qualification_title;
                                        }
                                    }
                                }

                            }
                            if($pj!=''){
                                $info = '<br>平台不存在'.$pj.'项目'.$info;
                            }
                            if($lx!=''){
                                $info = '<br>平台不存在'.$lx.'服务者类型'.$info;
                            }
                            if($zs!=''){
                                $info = '<br>平台不存在'.$zs.'资质证书'.$info;
                            }
                            if($dj!=''){
                                $info = '<br>平台不存在'.$dj.'资质等级'.$info;
                            }
                        }
                        if($info!=''){
                            $info='<span class="red">导入失败</span>'.$info.'<br>请删除错误数据，重新导入。';
                        }
                        if($info == ''){
                            $sa = 0;
                            $sc = 0;
                            $si = 0;
                            for($row=2;$row<=$highestRow;$row++){
                                $zsxm = $sheet->getCell('B'.$row)->getValue();  // 姓名
                                $sex = $sheet->getCell('C'.$row)->getValue();  // 性别
                                $project_name = $sheet->getCell('D'.$row)->getValue();  // 项目
                                $qualification_type = $sheet->getCell('E'.$row)->getValue();  // 服务者类型
                                $identity_type_name = $sheet->getCell('F'.$row)->getValue();  // 服务者资质证书
                                $qualification_title = $sheet->getCell('G'.$row)->getValue();  // 服务者资质等级
                                $qualification_code = $sheet->getCell('H'.$row)->getValue();  // 资质编号
                                $start_date = $sheet->getCell('I'.$row)->getValue();  // 资质有效期开始时间
                                $end_date = $sheet->getCell('J'.$row)->getValue();  // 资质有效期结束时间
                                if(strlen($end_date)==0){
                                    $end_date='长期';
                                }
                                $native = $sheet->getCell('K'.$row)->getValue();  // 籍贯
                                $nation = $sheet->getCell('L'.$row)->getValue();  // 民族
                                $birthdate = $sheet->getCell('M'.$row)->getValue();  // 出生年月
                                $id_card = $sheet->getCell('N'.$row)->getValue();  // 身份证号
                                $apply_phone = $sheet->getCell('O'.$row)->getValue();  // 联系电话
                                $apply_email = $sheet->getCell('P'.$row)->getValue();  // 电子邮箱
                                
                                $cType=ClubServicerType::model()->find('type=501 and member_second_name="'.$qualification_type.'"');
                                if(!empty($project_name)&&$cType->if_project==649){
                                    $project=ProjectList::model()->find('project_type=1 and project_name="'.trim($project_name).'"');
                                }
                                $identity_name=ServicerCertificate::model()->find('isNull(fater_id) and f_name="'.$identity_type_name.'"');
								if(!empty($identity_name)){
                                    $identity_level=ServicerCertificate::model()->find('fater_id='.$identity_name->id.' and f_type_name="'.$qualification_title.'"');
                                }

                                if(strlen($zsxm)>0||strlen($sex)>0||strlen($qualification_type)>0||strlen($native)>0||strlen($nation)>0||strlen($birthdate)>0||strlen($id_card)>0){
                                    $import = new ClubMemberImportfile();
                                    $import->isNewRecord = true;
                                    unset($import->id);
                                    $import->club_type=501;
                                    // $import->gfid=$model2->gfid;
                                    // $import->gf_account=$model2->gf_account;
                                    $import->zsxm=$zsxm;
                                    $import->phone=$apply_phone;
                                    $import->email=$apply_email;
                                    $import->id_card=trim($id_card);
                                    $import->sex=$sex;
                                    $import->native=$native;
                                    $import->nation=$nation;
                                    $import->real_birthday=$birthdate;
                                    $import->project_id=empty($project)?'':$project->id;
                                    $import->qualification_type=empty($cType)?'':$cType->member_second_id;
                                    $import->identity_type=empty($identity_name)?'':$identity_name->id;
                                    $import->qualification_num=empty($identity_level)?'':$identity_level->id;
                                    $import->qualification_code=$qualification_code;
                                    $import->start_date=$start_date;
                                    $import->end_date=$end_date;
                                    $import->logon_way=$logon_way;
                                    $si = $import->save();
                                }
                            }
                            if($si==1){
                                $info = '导入完成';
                            }
                            elseif($info==''){
                                $info = '导入失败';
                            }
                        }
                    }
                }
            }else{
				$info = "请先上传需要导入的服务者Excel文档"; 
			}
        }
        return $this->render('upExcel',array('info'=>$info));
    }

    public function actionIndex_thawy($start_date='',$end_date='',$keywords = '',$if_del='') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = 'auth_state=931 and is_del=648 and check_state=2 and free_state_Id=1202 and if_del<>506';
        $day=date('Y-m-d H:i:s',strtotime('+7 day'));
        if(empty($if_del)){
            $criteria->condition .= ' and lock_date_end<="'.$day.'" and lock_date_end>="'.date('Y-m-d H:i:s').'"' ;
        }else{
            $criteria->condition=get_where($criteria->condition,!empty($if_del),'if_del',$if_del,'');
        }
        // if ($start_date != '') {
        //     $criteria->condition.=' AND left(lock_date_end,10)>="'.$start_date.'"';
        // }
        if ($end_date != '') {
            $day2=date('Y-m-d',strtotime('+'.$end_date.' day'));
            $criteria->condition.=' AND left(lock_date_end,10)<="'.$day2.'"';
        }
        $criteria->condition=get_like($criteria->condition,'gfaccount,qualification_name,gf_code',$keywords,'');
        $criteria->order = 'lock_date_start desc';
        $data = array();
        $data['if_del']=BaseCode::model()->getReturn('1282,1283,507');
        parent::_list($model, $criteria,'index_thawy', $data);
    }

    // 服务者账号解冻处理
    public function actionRemedy($id,$way){
        $ids = explode(',',$id);
        foreach($ids as $d){
            $modelName = $this->model;
            $model = $this->loadModel($d, $modelName);
            if($way==1&&$model->if_del!=507){
                $model->expiry_date_start=$model->lock_date_end;
            }elseif($way==0){
                $model->lock_date_end=date('Y-m-d H:i:s');
            }
            $model->if_del=506;
            $model->lock_time=date('Y-m-d H:i:s');
            $sv=$model->save();
            if($sv==1){
                $qModel = new QualificationsPersonLock();
                $qModel->isNewRecord = true;
                unset($qModel->id);
                $qModel->qualification_person_id=$model->id;
                $qModel->state=$model->if_del;
                $qModel->add_time=date('Y-m-d H:i:s'); 
                $qModel->remedy_btn=$way; 
                $qModel->lock_date_start=$model->lock_date_start;
                $qModel->lock_date_end=$model->lock_date_end;
                if($way==0){
                    $qModel->lock_date_end=date('Y-m-d H:i:s');
                }
                $qModel->save();
            }
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    public function actionIndex_write($start_date = '', $end_date = '', $project = '', $type_id='', $keywords = '') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'auth_state=931 and check_state=2 and free_state_Id=1202 and unit_state=649';
        
        $start_date=empty($start_date)?date("Y-m-d"):$start_date;
        $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(state_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(state_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($project),'project_id',$project,'');
		$criteria->condition=get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
        $criteria->condition=get_like($criteria->condition,'gfaccount,qualification_name,gf_code',$keywords,'');
        $criteria->order = 'state_time desc';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['project_list'] = ProjectList::model()->getProject();
		$data['type_id'] = ClubServicerType::model()->findAll('type=501');
        parent::_list($model, $criteria,'index_write', $data);
    }
    // 服务者账号注销处理
    public function actionWriteDeal(){
        
        $modelName = $this->model;
        $model = $this->loadModel($_POST['qualification_id'], $modelName);
        $model->unit_state=$_POST['unit_state'];
        $model->unit_cause=$_POST['unit_cause'];
        $sv=$model->save();
        if($sv==1){
            QualificationClub::model()->updateAll(array('state'=>787),'qualification_person_id='.$_POST['qualification_id']);
        }
        show_status($sv,'操作成功',Yii::app()->request->urlReferrer,'操作失败');
    }

    // 已注销列表
    public function actionIndex_cancel($start_date = '', $end_date = '', $project = '', $type_id='', $keywords = '') {
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'auth_state=931 and check_state=2 and free_state_Id=1202 and unit_state=649';
        
        $start_date=empty($start_date)?date("Y-m-d"):$start_date;
        $end_date=empty($end_date)?date("Y-m-d"):$end_date;
        if ($start_date != '') {
            $criteria->condition.=' and left(state_time,10)>="' . $start_date . '"';
        }
        if ($end_date != '') {
            $criteria->condition.=' and left(state_time,10)<="' . $end_date . '"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($project),'project_id',$project,'');
		$criteria->condition=get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
        $criteria->condition=get_like($criteria->condition,'gfaccount,qualification_name,gf_code',$keywords,'');
        $criteria->order = 'state_time desc';
        $data = array();
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;
        $data['project_list'] = ProjectList::model()->getProject();
		$data['type_id'] = ClubServicerType::model()->findAll('type=501');
        parent::_list($model, $criteria,'index_cancel', $data);
    }

    public function actionIndex_renew($sex='',$project = '', $type_id='',$identity='',$type_code='',$renew_state='',$sky='30') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $day=date('Y-m-d H:i:s',strtotime('+'.$sky.' day'));
        $criteria->condition = 'unit_state=648 and is_del=648 and expiry_date_end<="'.$day.'"';
        $criteria->condition = get_where($criteria->condition,!empty($sex),'sex',$sex,'');
        $criteria->condition=get_where($criteria->condition,!empty($project),'project_id',$project,'');//get_where
		$criteria->condition=get_where($criteria->condition,!empty($type_id),'qualification_type_id',$type_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($identity),'identity_num',$identity,'');
        $criteria->condition=get_where($criteria->condition,!empty($type_code),'qualification_level',$type_code,'');
        $criteria->condition=get_where($criteria->condition,!empty($renew_state),'check_state',$renew_state,'');
        $criteria->order = 'id desc ';
        $data = array();
		$data['sex'] = BaseCode::model()->getSex();
        $data['project_list'] = ProjectList::model()->getAll();
		$data['type_id'] = BaseCode::model()->getCode(383);
		$data['identity'] = BaseCode::model()->findAll('F_TCODE="WAITER" AND fater_id<>383');
        $data['type_code'] = MemberCard::model()->getServicLevel();
        $data['renew_state'] = BaseCode::model()->getReturn('371,2,373');
        parent::_list($model, $criteria,'index_renew', $data);
    }
    
    public function actionGetReferees() {
        $modelName = $this->model;
        $gf="0";//
        if (isset($_REQUEST['gfaccount'])) { $gf=$_REQUEST['gfaccount'];};
        $data = array();
        $model= $modelName::model()->find("gfaccount='".$gf."'");
        $data['gfaccount']="";
        if(isset($model->gfaccount))
        if($model->gfaccount==$gf){
            $model1= userlist::model()->find("GF_ACCOUNT='".$gf."'");
            $data['gfid']=$model->gfid;
            $data['gfaccount']=$model->gfaccount;
            $data['qualification_name']=$model->qualification_name;
            $data['gf_code']=$model->gf_code;
            $data['qualification_type']=$model->qualification_type;
            $data['sex']=($model1->SEX==0) ? '女' : '男';
        }
        echo CJSON::encode($data);
    }
		
    public function actionCreate() {    
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();        
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['base_path'] = BasePath::model()->getPath(173);
            //保存资质图片
            $data['qualification_image']=array();
            $data['sub_product_list'] = array();
            $data['club_list'] = array();
            $this->render('create', $data);
        } else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();        
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['base_path'] = BasePath::model()->getPath(173);
            $data['qualification_image'] = explode(',', $model->qualification_image);
            //$model->introduct=get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
			$data['club_list'] = array();
			$data['club_list'] = ClubQualification::model()->getClub($model->id);
            $data['sub_product_list'] = array();
            $data['sub_product_list'] = QualificationVideos::model()->findAll('qualificate_id=' . $model->id);
			$basepath = BasePath::model()->getPath(212);
		    $model->introduct_temp=get_html($basepath->F_WWWPATH.$model->introduct, $basepath);
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }
  
    
    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_delete($id,'is_del',509);
    }


}
  