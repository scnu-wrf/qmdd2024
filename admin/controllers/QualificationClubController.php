<?php

class QualificationClubController extends BaseController {

    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }

    public function actionIndex($keywords = '',$club_id) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where(" 1=1 ",!empty($club_id),'club_id',$club_id,'');//get_where
        $criteria->condition=get_like($criteria->condition,'project_name',$keywords,'');//get_where
        $criteria->order = 't.id DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getAll();
        $data['base_code'] = ClubServicerType::model()->findAll('type=501');
        $data['type_code'] = MallProductsTypeSname::model()->getCode(173);
        parent::_list($model, $criteria, 'index', $data);
    }

	public function actionIndex1($keywords = '', $club_id, $project_id) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id=' . $club_id . ' AND project_id=' . $project_id.' AND state in(337,497,339)';
        $criteria->condition=get_like($criteria->condition,'project_name',$keywords,'');
        $criteria->order = 'id DESC';
		$data = array();
		$data['project'] = ProjectList::model()->getAll();
		$data['type'] = ClubServicerType::model()->findAll('type=501');
		$data['remove_type'] = AutoFilterSet::model()->getCode(221);
        parent::_list($model, $criteria, 'index1', $data);
    }

	public function actionIndex_club($project='',$type_code='',$type='',$keywords='',$index='',$start_date='',$end_date='',$state='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		$criteria->condition = get_where_club_project('t.club_id','');
		$criteria->join = "JOIN qualifications_person t2 on t.qualification_person_id=t2.id";
		$criteria->join .= " JOIN qualification_invite t3 on t3.id=t.invite_id";
		if($index==1){
			$criteria->condition .= ' and t.state in(498,499) and t3.invite_initiator=502 and isnull(t3.del_initiator) and t3.agree_club in(373,374) and t.club_id='.get_session('club_id');
		}elseif($index==2){
			$criteria->condition .= ' and t.state in(496,499) and t3.invite_initiator=501 and isnull(t3.del_initiator) and t3.agree_club in(371,373) and t.club_id='.get_session('club_id');
		}elseif($index==3){
			$criteria->condition .= ' and t.state in(337,497,339) and t.club_id='.get_session('club_id');
		}elseif($index==4){
			$criteria->condition .= ' and t.state=338 and t.club_id='.get_session('club_id');
		}elseif($index==5){
			$criteria->condition .= ' and t.state in(499) and t.club_id='.get_session('club_id');
		}elseif($index==6){
			$criteria->condition .= ' and t.state in(337,497,339)';
		}
        $criteria->condition = get_where($criteria->condition,!empty($project),'t.project_id',$project,'');
		$criteria->condition = get_where($criteria->condition,!empty($type),'t.qualification_type',$type,'');
		$criteria->condition = get_where($criteria->condition,!empty($state),'t.state',$state,'');
		if ($start_date != '') {
			$criteria->condition.=' AND left(t.udate,10)>="'.$start_date.'"';
		}
		if ($end_date != '') {
			$criteria->condition.=' AND left(t.udate,10)<="'.$end_date.'"';
		}
		$criteria->condition=get_like($criteria->condition,'t2.gfaccount,t2.gf_code,t2.qualification_name',$keywords,'');
		$criteria->order = 't.id DESC';
		$data = array();
        $data['project'] = ClubProject::model()->findAll('state=2 and auth_state=461 and club_id='.get_session('club_id'));
		$data['type'] = ClubServicerType::model()->findAll('type=501');
		$data['remove_type'] = AutoFilterSet::model()->getCode(221);
		$data['state'] = BaseCode::model()->findAll('f_id in(337,339,497)');
		$data['count1'] = $model->count('state=496 and club_id='.get_session('club_id'));
		$data['count2'] = $model->count('state=339 and club_id='.get_session('club_id'));
		parent::_list($model, $criteria, 'index_club', $data);
    }

    public function actionUpExcel($info='',$club_id='',$state='',$logon_way=1460){
        if($club_id==''){
            $club_id=get_session('club_id');
		}
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
							$bk='';
							$bd='';
                            $pj='';
                            $lx='';
                            $zs='';
                            $dj='';
							$club=ClubList::model()->find('id='.$club_id);
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

                                //列数循环 , 列数是以A列开始
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
										$p_count=ClubProject::model()->count('state=2 and auth_state=461 and club_id='.$club_id.' and project_name="'.$project_name.'"');
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
									$gu=userlist::model()->find('id_card_type=843 and id_card="'.trim($id_card).'" and passed=2');
									$count = 0;
									// if($cType->is_rely_on_partner!=649){
									// 	$bk.=($bk==''?'':'、').'第'.$row.'行'.$qualification_type;
									// }
									if(($club->club_type==189&&$cType->rely_on_partner_number==0)||($club->club_type==8&&$cType->rely_on_community_number==0)){
										if(!empty($gu)){
											$cq=ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and gfid='.$gu->GF_ID.' and qualification_type="'.$qualification_type.'"'.($cType->if_project==649?' and project_name="'.$project_name.'"':'').' and auth_state=931 and check_state=2 and free_state_Id=1202');
										}
										if(!empty($cq)){
											$cu = new CDbCriteria;
											$cu->join = "JOIN club_list t2 on t.club_id=t2.id and t.club_id<>".$club_id." and t2.club_type=".$club->club_type;
											$cu->condition='t.qualification_person_id='.$cq->id.' and t.state in(337,339,497)'.($cType->is_rely_on_partner_by_project==649?' and t.project_id='.$project->id:'');
											$count = QualificationClub::model()->count($cu);
										}
										if($count > 0){
											$bd.=($bd==''?'':'、').'第'.$row.'行'.$zsxm;
										}
									}
								}
							}
							if($bk!=''){
                                $info = '<br>'.$bk.'类型不可挂靠'.($club->club_type==189?'战略伙伴':'社区单位');
							}
                            if($bd!=''){
                                $info = '<br>'.$bd.'已绑定其他单位；';
                            }
                            if($pj!=''){
                                $info = '<br>该单位不存在'.$pj.'项目'.$info;
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
                            $sn = 0;
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
                                $project=ProjectList::model()->find('project_type=1 and project_name="'.$project_name.'"');
                                $identity_name=ServicerCertificate::model()->find('isNull(fater_id) and f_name="'.$identity_type_name.'"');
								if(!empty($identity_name)){
									$identity_level=ServicerCertificate::model()->find('fater_id='.$identity_name->id.' and f_type_name="'.$qualification_title.'"');
								}

                                if(strlen($zsxm)>0||strlen($sex)>0||strlen($qualification_type)>0||strlen($native)>0||strlen($nation)>0||strlen($birthdate)>0||strlen($id_card)>0){

                                    $import = new ClubMemberImportfile();
                                    $import->isNewRecord = true;
                                    unset($import->id);
                                    $import->club_type=502;
                                    // $import->gfid=$model2->gfid;
									// $import->gf_account=$model2->gf_account;
									$import->club_id=$club_id;
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

	public function actionIndex_unpaid($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'club_id='.get_session('club_id');
        $criteria->condition=get_like($criteria->condition,'project_name',$keywords,'');
        $criteria->order = 'id DESC';
		$data = array();
        parent::_list($model, $criteria, 'index_club', $data);
    }

//   检查服务是否已挂靠单位
    public function actionInspect() {
		$gfid = $_POST['gfid'];
		$club_list = explode(',', $gfid);

		$project_id = $_POST['project_id'];
		$project=ProjectList::model()->find('id='.$project_id);
        $club_id = $_POST['club_id'];
        $club=ClubList::model()->find('id='.$club_id);
		$type_id = $_POST['type_id'];
		$type=ClubServicerType::model()->find('type=501 and member_second_id='.$type_id);

		$al='';
		$account='';
		$is_binding='';
        foreach ($club_list as $v) {
			$per = ClubQualificationPerson::model()->find('unit_state=648 and if_del=506 and id='.$v);
			$is_adj = QualificationClub::model()->find('club_id='.$club_id.' and qualification_person_id='.$v.' and state=337');
			if(!empty($is_adj)){
				$account.=$per->gfaccount.',';
			}

			if(($club->club_type==189&&$type->rely_on_partner_number==0)||($club->club_type==8&&$type->rely_on_community_number==0)){
				if(!empty($per)){
					$cu = new CDbCriteria;
					$cu->join = "JOIN club_list t2 on t.club_id=t2.id and t.club_id<>".$club_id." and t2.club_type=".$club->club_type;
					$cu->condition='t.qualification_person_id='.$per->id.' and t.state in(337,339,497)'.($type->is_rely_on_partner_by_project==649?' and t.project_id='.$project->id:'');
					$count = QualificationClub::model()->count($cu);
				}
				if(!empty($count)){
					$is_binding.=$per->gfaccount.',';
				}
			}
		}
		if($account==''&&$is_binding==''){
			$this->actionSendInvite();
		}else{
			if($account!='')$al=rtrim($account,',').'服务者已挂靠本单位';
			if($is_binding!='')$al=rtrim($is_binding,',').'服务者已挂靠其他单位';
			ajax_status(0, $al);
		}

	}

  // 发送邀请
    public function actionSendInvite() {
        $modelName = $this->model;
        $model = $modelName::model();
		$data = array();
		$project_id = $_POST['project_id'];
        $club_id = $_POST['club_id'];
		$type_id = $_POST['type_id'];
		$gfid = $_POST['gfid'];
        $msg = $_POST['msg'];
        $club=ClubList::model()->find('id='.$club_id);
		$project=ProjectList::model()->find('id='.$project_id);
		$type=ClubServicerType::model()->find('type=501 and member_second_id='.$type_id);

        $club_list = explode(',', $gfid);
		$arr_q=array();
		if($project_id>0){
			$club_q=$model->findAll('state=498 and club_id='. $club_id.' AND project_id=' . $project_id .' AND qualification_type=' . $type_id);
		}else{
			$club_q=$model->findAll('state=498 and club_id='. $club_id.' AND qualification_type=' . $type_id);
		}
		foreach ($club_q as $s) {
			$arr_q[]=$s->qualification_person_id;
		}
        $errors = array();
		$basepath=BasePath::model()->getPath(123);
		$pic=$basepath->F_WWWPATH;
		if($club_id!='') {
		   $pic=$pic.$club->club_logo_pic;
		   $club_name=$club->club_name;
		}
		if($project_id>0){
			$title=$club_name.'向您发出了'.$project->project_name.'项目的'.$type->member_second_name.'邀请';
		}else{
			$title=$club_name.'向您发出了'.$type->member_second_name.'邀请';
		}
		$acount='';
        foreach ($club_list as $v) {
			if(in_array($v,$arr_q)) {
				$per=QualificationsPerson::model()->find('id='.$v);
				$acount.=$per->gfaccount.',';
			}
		}
        foreach ($club_list as $v2) {
			if($acount!=''){
				ajax_status(0, rtrim($acount, ',').'账号已邀请或已绑定，请勿重复操作');
			}
			$qClub=$model->find('qualification_person_id='.$v.' and club_id='.$club_id.'');
			$log = new QualificationInvite;
			$log->isNewRecord = true;
			unset($log->id);
			//$log->club_id = Yii::app()->session['club_id'];
			$qualification=QualificationsPerson::model()->find('id='.$v);
			$log->club_id = $club_id;
			$log->qualification_person_id = $v;
			$log->qualification_person_account = $qualification->gfaccount;
			if($project_id>0){
				$log->project_id = $project_id;
			}
			$log->qualification_type = $type_id;
			$log->invite_initiator = 502;
			$log->agree_club = 371;
			$log->invite_content = $msg;
			if (!$log->save()) {
				if (!empty($log->getErrors())) {
					$errors[] = $log->getErrors();
				}
			} else {
				if(empty($qClub)){
					$qClub = new QualificationClub;
					$qClub->isNewRecord = true;
					unset($qClub->id);
				}
				//$model->club_id = Yii::app()->session['club_id'];
				$qClub->club_id = $club_id;
				$qClub->qualification_person_id = $v;
				if($project_id>0){
					$qClub->project_id = $project_id;
				}
				$qClub->qualification_type = $type_id;
				$qClub->state = 498;
				$qClub->invite_id = $log->id;
				$qClub->logon_way = $qualification->logon_way;
				$qClub->save();
				$sendArr=array('type'=>'邀请函','pic'=>$pic,'title'=>$title,'content'=>$msg,'url'=>'','invite_id'=>$log->id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>371,'del_initiator'=>'','if_del'=>'');
				club_qualification($log->club_id,$qualification->gfid,$sendArr);
			}
			$log->save();
		}

		if (empty($errors)) {
			ajax_status(1, '邀请发送成功' , Yii::app()->request->urlReferrer);
		} else {
			ajax_status(0, '邀请发送失败');
		}
    }

	 // 撤销已发送的邀请
	// && $model->club_id == Yii::app()->session['club_id']
	public function actionCancelInvite($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$basepath=BasePath::model()->getPath(123);
		$pic=$basepath->F_WWWPATH;
        if ( $model->state == 498 )
		{
		    $model->update($model->state= 499);
			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			}
			$log=QualificationInvite::model()->find('id='.$model->invite_id);
		    $log->update($log->agree_club= 374);
			$qualification=QualificationsPerson::model()->find('id='.$model->qualification_person_id);
			$title='单位撤销邀请';
			$content='抱歉，'.$model->club_name.'撤销了'.$model->project_name.'项目的'.$model->type_name.'邀请';
			$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->invite_id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>374,'del_initiator'=>'','if_del'=>'');
			club_qualification($model->club_id,$qualification->gfid,$sendArr);
			ajax_status(1, '撤销成功', get_cookie('_currentUrl_'));
		} else {
			ajax_status(0, '撤销失败');
		}
    }

	 // 解除绑定 && $model->club_id == Yii::app()->session['club_id']
    public function actionDeleteInvite($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$invite_id=$model->invite_id;
		$qualification=QualificationsPerson::model()->find('id='.$model->qualification_person_id);
		if(!empty($invite_id)){
			$invite=QualificationInvite::model()->find('id='.$invite_id);
		}
		$msg = $_POST['msg'];
		$remove_type= $_POST['type'];
		$basepath=BasePath::model()->getPath(123);
		$pic=$basepath->F_WWWPATH;
		if ($model->state==337) {
			if(empty($invite)){
                $invite = new QualificationInvite();
                $invite->isNewRecord = true;
                unset($invite->id);
			}
			$invite->remove_reason = $msg;
			$invite->if_del = 371;
			$invite->agree_club_time = date('Y-m-d H:i:s');
			$invite->del_initiator = 502;
			if ($invite->save()) {
				$invite_id=$invite->id;
				$model->state= 497;
				if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   	}
				$title='抱歉，'.$model->club_name.'解除了您'.$model->project_name.'项目的'.$model->type_name.'绑定';
				$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$msg,'url'=>'','invite_id'=>$invite_id,'invite_initiator'=>$invite->invite_initiator,'agree_club'=>$invite->agree_club,'del_initiator'=>502,'if_del'=>371);
				club_qualification($model->club_id,$qualification->gfid,$sendArr);
				$model->save();
				// get_cookie('_currentUrl_')
				ajax_status(1, '解除绑定发送成功', Yii::app()->request->urlReferrer);
            }
		} else {
				ajax_status(0, '解除绑定发送失败');
		}

	}

	 // 撤销已发送的解除绑定
	// && $model->club_id == Yii::app()->session['club_id']
	public function actionCancelDeleteInvite($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$basepath=BasePath::model()->getPath(123);
		$pic=$basepath->F_WWWPATH;
		$log=QualificationInvite::model()->find('id='.$model->invite_id);
		$qualification=QualificationsPerson::model()->find('id='.$model->qualification_person_id);
        if ($model->state == 497)
		{
			$log->if_del = 374;
			$log->del_initiator = 502;
			$log->save();
		    $model->state= 337;
			$model->save();
			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   }

			$title='单位撤销解除';
			$content=$model->club_name.'撤销了'.$model->project_name.'项目的'.$model->type_name.'绑定解除';
			$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->invite_id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>2,'del_initiator'=>502,'if_del'=>374);
			club_qualification($model->club_id,$qualification->gfid,$sendArr);
			ajax_status(1, '撤销成功', get_cookie('_currentUrl_'));
		 } else {
            ajax_status(0, '撤销失败');
         }
    }

	 // 审核服务者的加入申请  && $model->club_id == Yii::app()->session['club_id']
    public function actionPassInvite($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$invite_id=$model->invite_id;
		$invite=QualificationInvite::model()->findByPk($invite_id);
		$qualification=QualificationsPerson::model()->find('id='.$model->qualification_person_id);
        $msg = $_POST['msg'];
		$type = $_POST['type'];
		$basepath=BasePath::model()->getPath(123);
		$pic=$basepath->F_WWWPATH;
        if ($invite != null && $model->state == 496) {
			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   }

			$title='单位审核绑定申请';


			if ($type == 'yes') {
				$invite->agree_club=2;
				if($invite->save()) {
					$model->state = 337;
					$model->save();

					$content='恭喜，'.$model->club_name.'同意了您'.$model->project_name.'项目的'.$model->type_name.'绑定申请;'.$msg;
					$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->invite_id,'invite_initiator'=>$invite->invite_initiator,'agree_club'=>$invite->agree_club,'del_initiator'=>'','if_del'=>'');
					club_qualification($model->club_id,$qualification->gfid,$sendArr);
					ajax_status(1, '通过申请', Yii::app()->request->urlReferrer);
				} else {
					ajax_status(0, '操作失败');
				}
			} else {
				$invite->agree_club=373;
				if($invite->save()) {
					$model->state = 499;
					$model->save();
					$content='抱歉，'.$model->club_name.'拒绝了您'.$model->project_name.'项目的'.$model->type_name.'绑定申请；'.$msg;
					$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->invite_id,'invite_initiator'=>$invite->invite_initiator,'agree_club'=>$invite->agree_club,'del_initiator'=>'','if_del'=>'');
					club_qualification($model->club_id,$qualification->gfid,$sendArr);
					ajax_status(1, '拒绝加入', Yii::app()->request->urlReferrer);
				} else {
					ajax_status(0, '操作失败');
				}
			}
        } else {
            ajax_status(0, '操作失败');
        }
    }

	 // 审核服务者的退出申请 && $model->club_id == Yii::app()->session['club_id']
    public function actionIsdelInvite($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$invite_id=$model->invite_id;
		$invite=QualificationInvite::model()->findByPk($invite_id);
		$qualification=QualificationsPerson::model()->find('id='.$model->qualification_person_id);
        $msg = $_POST['msg'];
		$type = $_POST['type'];
		$basepath=BasePath::model()->getPath(123);
		$pic=$basepath->F_WWWPATH;
        if ($invite != null && $model->state == 339) {
			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   }

			$title='单位审核退出申请';
			if ($type == 'yes') {
				$invite->if_del=2;
				if($invite->save()) {
					$model->state = 338;
					$model->save();
					$content=$model->club_name.'同意了您'.$model->project_name.'项目的'.$model->type_name.'绑定解除;'.$msg;
					$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->invite_id,'invite_initiator'=>$invite->invite_initiator,'agree_club'=>$invite->agree_club,'del_initiator'=>$invite->del_initiator,'if_del'=>$invite->if_del);
					club_qualification($model->club_id,$qualification->gfid,$sendArr);
					ajax_status(1, '同意退出申请', Yii::app()->request->urlReferrer);
				} else {
					ajax_status(0, '操作失败');
				}
			} else {
				$invite->if_del=373;
				if($invite->save()) {
					$model->state = 787;
					$model->save();
					$content=$model->club_name.'拒绝了您'.$model->project_name.'项目的'.$model->type_name.'绑定解除；'.$msg;
					$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->invite_id,'invite_initiator'=>$invite->invite_initiator,'agree_club'=>$invite->agree_club,'del_initiator'=>$invite->del_initiator,'if_del'=>$invite->if_del);
					club_qualification($model->club_id,$qualification->gfid,$sendArr);
					ajax_status(1, '拒绝退出申请', Yii::app()->request->urlReferrer);
				} else {
					ajax_status(0, '操作失败');
				}
			}
        } else {
            ajax_status(0, '操作失败');
        }
    }


	//逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
		$club=explode(',', $id);
        $count=0;
		foreach ($club as $d) {
			$qclub=$model->find('id='.$d);
			$model->deleteAll('id='.$d);
			QualificationInvite::model()->deleteAll('id='.$qclub->invite_id);
			$count++;
		}
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

}