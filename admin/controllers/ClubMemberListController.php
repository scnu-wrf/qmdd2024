<?php

class ClubMemberListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    public function actionIndex($keywords = '',$start_date='',$end_date='',$member_project_id = '',$club_status='',$club_id='',$is_excel='',$index='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        ClubMember::model()->updateAll(array('if_del'=>511),'!isNull(end_time) and end_time<"'.date('Y-m-d H:i:s').'" and (if_del<>511 or if_del<>2)');

        $start_date=empty($start_date)?date("Y-m-d", strtotime("-1 month")):$start_date;
        $end_date=empty($end_date)?date("Y-m-d"):$end_date;

        $criteria->condition='t.';
        $criteria->join = "JOIN club_member t2 on t.user_member_id = t2.id";
        if($index==1){
            $criteria->condition.='t.club_id='.get_session('club_id').' and club_status in(498)';
        }elseif($index==2){
            $criteria->condition.='t.club_id='.get_session('club_id').' and club_status in(498) and left(apply_time,10)="'.date("Y-m-d").'"';
        }elseif($index==3){
            $criteria->condition.='t.club_id='.get_session('club_id').' and club_status in(337,499) and left(t2.start_time,10)>="'.$start_date.'" and left(t2.start_time,10)<="'.$end_date.'"';
        }elseif($index==4){
            $criteria->condition.='t.club_id='.get_session('club_id').' and club_status in(496)';
        }
        elseif($index==5){
            $criteria->condition.='t.club_id='.get_session('club_id').' and club_status in(337,497,339) and left(t2.start_time,10)>="'.$start_date.'" and left(t2.start_time,10)<="'.$end_date.'"';
        }
        elseif($index==6){
            $criteria->condition.='t.club_id='.get_session('club_id').' and club_status in(338,497,339) and left(t2.start_time,10)>="'.$start_date.'" and left(t2.start_time,10)<="'.$end_date.'"';
        }
        elseif($index==7){
            $criteria->condition.='t.club_id='.get_session('club_id').' and club_status = 499  and left(t.udate,10)>="'.$start_date.'" and left(t.udate,10)<="'.$end_date.'"';
        }
        elseif($index==8){
            $criteria->condition.=get_where_club_project('t.club_id','').' and t.club_status in(337,497) and left(t2.start_time,10)>="'.$start_date.'" and left(t2.start_time,10)<="'.$end_date.'"';
        }
        $criteria->condition=get_where($criteria->condition,!empty($club_status),'club_status',$club_status,'');
        $criteria->condition=get_where($criteria->condition,!empty($club_id),'t.club_id',$club_id,'');
        $criteria->condition=get_where($criteria->condition,!empty($member_project_id),'t2.member_project_id',$member_project_id,'');
        $criteria->condition=get_like($criteria->condition,'t.zsxm,t.gf_account,t.project_name,t.club_name',$keywords,'');
        $criteria->order = 'id DESC';
        $data = array();
        $data['club_status'] = BaseCode::model()->getStatus();
        $data['club_id'] = ClubList::model()->findAll();
        $data['member_project_id'] = ClubProject::model()->findAll('club_id in ('.get_session('club_id').') and auth_state=461');
        $data['project'] = ClubProject::model()->getClubProject2(get_session('club_id'));
        $data['count1'] = $model->count('club_id='.get_session('club_id').' and club_status in(498) and left(apply_time,10)="'.date("Y-m-d").'"');
        $data['count2'] = $model->count('club_id='.get_session('club_id').' and club_status in(496)');
		if(!isset($is_excel) || $is_excel!='1'){
            parent::_list($model, $criteria, 'index', $data);
		}else{
		    $arclist = $model->findAll($criteria);
		    $data=array();
            $title=array();
            if($index==5){
                $titlefiled = array(
                    'gf_account',
                    'zsxm',
                    'real_sex',
                    'project_name',
                    'project_level_name',
                    'club_status_name',
                    'start_time',
                );
            }
            foreach ($titlefiled as $fv) {
                array_push($title, $model->getAttributeLabel($fv));
		    }
            array_push($data, $title);
		    foreach ($arclist as $v) {
		        $item = array();
		        foreach ($titlefiled as $fv) {
		            $s = '';
		            if ($fv == 'real_sex') {
		                $s = $v->base_code_sex->F_NAME;
		            } elseif ($fv == 'start_time') {
		                $s = $v->club_member->start_time;
		            } else {
		                $s = $v->$fv;
		            }
		            array_push($item, $s);
		        }
		        array_push($data, $item);
		    }
		    parent::_excel($data,'学员列表.xls');
        }
    }

    public function actionUpExcel($info='',$club_id='',$logon_way=1460){
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
                        $info = "<br>提示：文件大小不能超过2M";  
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
                            $info = "提示：一次导入信息数据最多为200条。";
                        }
                        else{ //检测数据是否符合要求
                            $exist='';
                            $pj='';
                            for ($row = 2; $row <= $highestRow; $row++){
                                $project_name = $sheet->getCell('B'.$row)->getValue();  // 项目
                                $zsxm = $sheet->getCell('C'.$row)->getValue();  // 姓名
                                $real_sex = $sheet->getCell('D'.$row)->getValue();  // 性别
                                $native = $sheet->getCell('E'.$row)->getValue();  // 籍贯
                                $birthdate = $sheet->getCell('F'.$row)->getValue();  // 出生年月
                                $id_card = $sheet->getCell('H'.$row)->getValue();  // 身份证号码
                                //列数循环 , 列数是以A列开始
                                if(strlen($project_name)>0&&strlen($zsxm)>0&&strlen($real_sex)>0&&strlen($native)>0&&strlen($birthdate)>0&&strlen($id_card)>0){
                                    $le=['B','C','D','E','F','H'];
                                    foreach ($le as $l) {
                                        $content=$sheet->getCell($l.$row)->getValue();
                                        if (strlen($content)==0||strlen($content)>120) {
                                            $info = '<br>提示：第'.$l.'列数据不符合要求。内容不能为空，内容长度不能大于120。';
                                            break;
                                        }
                                    }
                                    $p_count=ClubProject::model()->count('state=2 and auth_state=461 and club_id='.$club_id.' and project_name="'.$project_name.'"');
                                    if($p_count<=0){
                                        $pj.=($pj==''?'':',').$project_name;
                                    }
    
                                    $id_card = $sheet->getCell('H'.$row)->getValue();  // 身份证号码
                                    $zsxm = $sheet->getCell('C'.$row)->getValue();  // 姓名
                                    $member_list=ClubMemberList::model()->find('!isnull(club_id) and project_name="'.$project_name.'" and id_card_type=843 and id_card="'.trim($id_card).'" and club_status=337 ');
                                    if(!empty($member_list)){
                                        $info .= '<br>第'.$row.'行'.$zsxm.'，已绑定其他单位；';
                                    }
                                }
                            }

                            if($pj!=''){
                                $info = '<br>该单位不存在'.$pj.'项目'.$info;
                            }

                        }//检测数据是否符合要求
                        if($info!=''){
                            $info='<span class="red">导入失败</span>'.$info.'<br>请删除错误数据，重新导入。';
                        }
                        if($info==''){
                            $modelName = $this->model;
                            $model = new $modelName;
                            $sa = 0;
                            $sc = 0;
                            $sn = 0;
                            for($row=2;$row<=$highestRow;$row++){
                                $project_name = $sheet->getCell('B'.$row)->getValue();  // 项目
                                $zsxm = $sheet->getCell('C'.$row)->getValue();  // 姓名
                                $real_sex = $sheet->getCell('D'.$row)->getValue();  // 性别
                                $native = $sheet->getCell('E'.$row)->getValue();  // 籍贯
                                $birthdate = $sheet->getCell('F'.$row)->getValue();  // 出生年月
                                $apply_phone = $sheet->getCell('G'.$row)->getValue();  // 联系电话
                                $id_card = $sheet->getCell('H'.$row)->getValue();  // 身份证号码

                                if(strlen($project_name)>0&&strlen($zsxm)>0&&strlen($real_sex)>0&&strlen($native)>0&&strlen($birthdate)>0&&strlen($id_card)>0){
                                    $project=ProjectList::model()->find('project_type=1 and project_name="'.$project_name.'"');

                                    $import = new ClubMemberImportfile();
                                    $import->isNewRecord = true;
                                    unset($import->id);
                                    $import->club_type=8;
                                    $import->club_id=$club_id;
                                    // $import->gfid=empty($gfUser)?'':$gfUser->GF_ID;
                                    // $import->gf_account=empty($gfUser)?'':$gfUser->GF_ACCOUNT;
                                    $import->zsxm=$zsxm;
                                    $import->phone=$apply_phone;
                                    $import->id_card=trim($id_card);
                                    $import->sex=$real_sex;
                                    $import->native=$native;
                                    $import->real_birthday=$birthdate;
                                    $import->project_id=$project->id;
                                    $import->logon_way=$logon_way;
                                    $si = $import->save();
                                }
                            }
                            if($si==1){
                                $info = '导入完成';
                            }else{
                                $info = '导入失败';
                            }
                        }
                    }
                }
            }else{
				$info = "请先上传需要导入的学员Excel文档"; 
			}
        }
        return $this->render('upExcel',array('info'=>$info));
    }

    //解除学员
    public function  actionRelieve_apply(){

        $id = $_GET['id'];
        $modelName = $this->model;
        $model = $modelName::model();
        $idArray = explode(",",$id);
        $count=0;
        //$count=$model->deleteAll('id in('.$id.')');
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('club_status'=>497));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '解除成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '解除失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }



    //撤销邀请
    public function  actionRevoke_apply(){

        //$GF_IDArray  = explode(",",$GF_ID);
        //$thawMode  = $thawMode;

        $id = $_GET['id'];
        $user_member_id = $_GET['user_member_id'];

        $club_member_row  = ClubMember::model()->find('id='.$user_member_id);
        $club_member_row->agree_club = 374;
        $club_member_row->save();



        $modelName = $this->model;
        $model= $modelName::model()->find('user_member_id='.$user_member_id);

        $model->save();

        $idArray = explode(",",$id);
        $count=0;
        //$count=$model->deleteAll('id in('.$id.')');
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('club_status'=>499));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '撤销失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }


    //撤销解除
    public function  actionRevoke_relieve(){
        $id = $_GET['id'];

        $modelName = $this->model;
        $model = $modelName::model();
        $idArray = explode(",",$id);
        $count=0;
        //$count=$model->deleteAll('id in('.$id.')');
        foreach ($idArray as $d) {
            $model->updateByPk($d,array('club_status'=>337));
            $count++;
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功',get_cookie('_currentUrl_'));
        } else {
            ajax_status(0, '撤销失败');
        }


        //show_status($sv,'撤销成功',get_cookie('_currentUrl_'),'保存失败');
    }

    // 发送学员邀请
    public function actionSendInvite() {
        $modelName = $this->model;
        $model = $modelName::model();
        $data = array();
        $member_gfid = $_POST['member_gfid'];
        $project_id = $_POST['project_id'];
        $club_id = $_POST['club_id'];
        $msg = $_POST['msg'];
        $account = $_POST['account'];

        $intime=date('Y-m-d H:m:s');
		$gfuser= userlist::model()->find('GF_ACCOUNT="'.$account.'"');
		$clubuser_on=ClubMemberList::model()->find('gf_account="'.$account.'" AND club_status=337 AND member_project_id='.$project_id);//在位
		$clubuser_in=ClubMemberList::model()->find('gf_account="'.$account.'" AND (club_status=498 OR club_status=496)  AND member_project_id='.$project_id);//正在加入
		$clubuser_out=ClubMemberList::model()->find('gf_account="'.$account.'" AND (club_status=339 OR club_status=497) AND member_project_id='.$project_id);//正在解除
		$basepath=BasePath::model()->getPath(191);
        $pic=$basepath->F_WWWPATH;
        $yes='邀请发送成功';
        $no='邀请发送成功';
		if(!empty($gfuser)) {
			if($gfuser->user_state==506) {
				if($gfuser->passed==2) {
					if(!empty($clubuser_on)) {
                        $sv=0;
                        $no='该帐号已注册学员，请勿重复操作';
					} else if(!empty($clubuser_in)) {
                        $sv=0;
                        $no='该帐号正在加入，请勿重复操作';
					} else if(!empty($clubuser_out)) {
                        $sv=0;
                        $no='该帐号正在解除中，无法邀请';
					} else {
						$log = new ClubMember;
						$log->isNewRecord = true;
						unset($log->id);
						$log->club_id = $club_id;
						$log->member_gfid = $gfuser->GF_ID;
						$log->member_project_id = $project_id;
						$log->member_content = $msg;
						$log->gf_account = $account;
						$log->member_level_register_time = $intime;
						$log->invite_initiator = 502;
						$log->agree_club = 371;
                        $log->zsxm = $gfuser->ZSXM;
						$sv=$log->save();
					}
				} else {
                    $sv=0;
                    $no='该帐号未实名登记';
				}
			} else {
                $sv=0;
                $no='该帐号已冻结';
			}
		} else {
            $sv=0;
            $no='该帐号不存在';
		}

		if ($sv==1) {
            if(!empty($club_id)) {
               $club=ClubList::model()->find('id='.$club_id);
               $pic=$pic.$club->club_logo_pic;
               $club_name=$club->club_name;
            }
            if(!empty($project_id)) {
               $project=ProjectList::model()->find('id='.$project_id);
               $project_name=$project->project_name;
            }
            $title=$club_name.'向您发出了'.$project_name.'项目的学员邀请';
            $content=$msg;
            $sendArr=array('type'=>'邀请函','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$log->id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>371,'del_initiator'=>$log->del_initiator,'if_del'=>$log->if_del);
            club_member_list($club_id,$member_gfid,$sendArr);
			ajax_status(1, $yes, get_cookie('_currentUrl_'));
		} else {
			ajax_status(0, $no);
		}
        
    }
    // 审核别人的学员申请
    public function actionPassInvite() {
        $modelName = $this->model;
        $model = $modelName::model();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
        } else {
            $invite_id = $_POST['invite_id'];
            $type = $_POST['type'];
			$msg = $_POST['msg'];
            $model= $modelName::model()->find('id='.$invite_id);

            if ($type == 'yes') {
                //die;

                $model->club_status = 337;
                //$model->register_time = date('Y-m-d H:i:s');

                //die;
                $log= ClubMember::model()->find('id='.$model->user_member_id);
                $log->updateByPk($log['id'],array(
                 'agree_club' => 2,
                 'start_time' => date('Y-m-d H:i:s'))); 
				 $title='恭喜，'.$model->club_name.'同意了您'.$model->project_name.'项目的学员注册申请';

            } else {
                //sdie;
                $model->club_status=499;
                $log= ClubMember::model()->find('id='.$model->user_member_id);
                $log->updateByPk($log['id'],array('agree_club' => 373,'start_time' => date('Y-m-d H:i:s')));
                $title='抱歉，'.$model->club_name.'拒绝了您'.$model->project_name.'项目的学员注册申请';
            }
			$basepath=BasePath::model()->getPath(191);
			$pic=$basepath->F_WWWPATH;
			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   }
			$content=$msg;
			$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->user_member_id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>$log->agree_club,'del_initiator'=>$log->del_initiator,'if_del'=>$log->if_del);
            club_member_list($model->club_id,$model->member_gfid,$sendArr);
            if($model->save()){
            if ($type == 'yes') {

                ajax_status(1, '加入成功', get_cookie('_currentUrl_'));
     
            } else {
                ajax_status(1, '拒绝加入', get_cookie('_currentUrl_'));
                
            }
        }}
    }
    // 取消已发送的学员邀请
    public function actionCancelInvite() {
        $modelName = $this->model;
        $model = $modelName::model();
        $errors = array();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
        } else {
            $invite_id = $_POST['invite_id'];


			//$msg = $_POST['msg'];
			$basepath=BasePath::model()->getPath(191);
			$pic=$basepath->F_WWWPATH;

            $model= $modelName::model()->find('id='.$invite_id);

			$log= ClubMember::model()->find('id='.$model->user_member_id);

			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   }

			$title='抱歉，'.$model->club_name.'撤销了'.$model->project_name.'项目的学员邀请';
			$content='';
			$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->user_member_id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>374,'del_initiator'=>$log->del_initiator,'if_del'=>$log->if_del);
			club_member_list($model->club_id,$model->member_gfid,$sendArr);

			$log->agree_club=374;

			$log->save();

            $model->club_status=499;


			if ($model->save()) {
				ajax_status(1, '撤销邀请成功', get_cookie('_currentUrl_'));
			} else {
				ajax_status(0, '撤销邀请失败');
			}
		}
    }
    // 解除学员
     public function actionDeleteInvite() {

        $id = $_POST['id'];

        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);

        $errors = array();
        $member_gfid = $model->member_gfid;
        $project_id = $model->member_project_id;
        $club_id = $model->club_id;
        //$msg = $_POST['msg'];
        $zsxm = $model->zsxm;
		$basepath=BasePath::model()->getPath(191);
		$pic=$basepath->F_WWWPATH;
        $projectname = ProjectList::model()->find('id='.$project_id);
        $club = ClubList::model()->find('id='.$club_id);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
        } else {
            $invite_id = $id;
            //$model= $modelName::model()->find('id='.$invite_id);
            $model->club_status = 497;
            $log= ClubMember::model()->find('id='.$model->user_member_id);
                $log->updateByPk($log['id'],array(
                    'del_initiator' => 502,
                    'if_del' => 371,
                    //'remove_reason' => '解除你',
                    'unbund_time' => date('Y-m-d H:i:s'),
                    'end_time' => date('Y-m-d H:i:s', strtotime('7 days'))
                ));
			$pic=$pic.$club->club_logo_pic;
			$title=$model->club_name.'向您发出了'.$model->project_name.'项目的学员解除通知';
			//$content='解除你';
			$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'url'=>'','invite_id'=>$model->user_member_id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>$log->agree_club,'del_initiator'=>502,'if_del'=>371);
			club_member_list($model->club_id,$model->member_gfid,$sendArr);

            if($model->save()){
                ajax_status(1, '解除成功', get_cookie('_currentUrl_'));
     
            } else {
                ajax_status(0, '解除失败', get_cookie('_currentUrl_'));
                
            }
        }
    }
    // 撤销已发送的解除联盟
    public function actionCancelDeleteInvite() {
        $modelName = $this->model;
        $model = $modelName::model();
        $errors = array();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
        } else {
            $invite_id = $_POST['invite_id'];
            $model= $modelName::model()->find('id='.$invite_id);  
            $model->club_status = 337;
			$msg = $_POST['msg'];
			$basepath=BasePath::model()->getPath(191);
			$pic=$basepath->F_WWWPATH;
			$log= ClubMember::model()->find('id='.$model->user_member_id);
			$log->if_del=374;
			$log->save();
			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   }
			$title=$model->club_name.'撤销了'.$model->project_name.'项目的学员解除';
			$content=$msg;
			$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->user_member_id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>$log->agree_club,'del_initiator'=>$log->del_initiator,'if_del'=>$log->if_del);
			club_member_list($model->club_id,$model->member_gfid,$sendArr);
			
            if ($model->save()) {
                ajax_status(1, '撤销解除会员成功', get_cookie('_currentUrl_'));
            } else {
                ajax_status(0, '撤销解除会员失败');
            }
        }
    }

    // 审核别人的解除请求
    public function actionIsdelInvite() {
        $modelName = $this->model;
        $model = $modelName::model();
        $errors = array();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;
        } else {
            $invite_id = $_POST['invite_id'];
            $type = $_POST['type'];
			$msg = $_POST['msg'];
            $model= $modelName::model()->find('id='.$invite_id);
           	$log= ClubMember::model()->find('id='.$model->user_member_id);
            if ($type == 'yes') {
                $model->club_status = 338;
                $log->updateByPk($log['id'],array('if_del' => 2,'end_time' => date('Y-m-d H:i:s'))); 
                $title=$model->club_name.'同意了您'.$model->project_name.'项目的学员解除申请';
            } else {
                $model->club_status = 497;
                $log->updateByPk($log['id'],array('if_del' => 371,));
                $title=$model->club_name.'拒绝了您'.$model->project_name.'项目的学员解除申请';
            }
			
			$basepath=BasePath::model()->getPath(191);
			$pic=$basepath->F_WWWPATH;
			if($model->club_id!='') {
				   $club=ClubList::model()->find('id='.$model->club_id);
				   $pic=$pic.$club->club_logo_pic;
			   }
			$content=$msg;
			$sendArr=array('type'=>'单位通知','pic'=>$pic,'title'=>$title,'content'=>$content,'url'=>'','invite_id'=>$model->user_member_id,'invite_initiator'=>$log->invite_initiator,'agree_club'=>$log->agree_club,'del_initiator'=>$log->del_initiator,'if_del'=>$log->if_del);
            if($model->save()){
                if ($type == 'yes') {
                    ajax_status(1, '解除成功', get_cookie('_currentUrl_'));
                } else {
                    ajax_status(1, '拒绝解除', get_cookie('_currentUrl_'));
                }
            }else {
                ajax_status(0, '解除失败');
            }
        }
            
    }

    public function actionShow($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;

            // 获取项目
            // if (!empty($model->project_name)) {
            //     //找到项目列表里的项目id等于当前字段id，并保存到当前数组
            //     $data['project_name'] = ProjectList::model()->findAll('id in (' . $model->project_name . ')');

            // } else {
            //     //否则该数组为空
            //     $data['project_name'] = array();
            // }
            $this->render('show', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $data['model'] = $model;

           // 获取项目
            // if (!empty($model->project_name)) {
            //     //找到项目列表里的项目id等于当前字段id，并保存到当前数组
            //     $data['project_name'] = ProjectList::model()->findAll('id in (' . $model->project_name . ')');

            // } else {
            //     //否则该数组为空
            //     $data['project_name'] = array();
            // }
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }
  
    function saveData($model,$post) {
        $model->attributes =$post;
        if ($_POST['submitType'] == 'tongguo') {
                $model->club_status = 337;
            } else if ($_POST['submitType'] == 'butongguo') {
                $model->club_status = 499;
            }
            $sv=$model->save();
            show_status($sv,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }


    public function actionDelete($id) {
        parent::_delete($id);
    }
 
    
    public function actionIndex_non($project_id='',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_level_xh=0 and integral>0';
        $criteria->condition = get_where($criteria->condition,!empty($project_id),'member_project_id',$project_id,'');
        $criteria->condition=get_like($criteria->condition,'gf_account,zsxm',$keywords,'');
        $criteria->order = 'udate DESC';
        $data = array();
        $data['project_list'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_non', $data);
    }

    public function actionIndex_dragon_tiger($project_id='',$time_start='',$time_end='',$keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = 'project_level_xh>0';
        $criteria->join = "JOIN club_member_upgrade t2 on t.member_gfid=t2.gf_id and t.member_project_id=t2.project_id and t.project_level_id=t2.member_level and t2.is_pay=464 and !isnull(t2.grade_achieve_time)";
        $time_start=$time_start=='' ? date("Y-m-d") : $time_start;
        $time_end=$time_end=='' ? date("Y-m-d") : $time_end;
        if ($time_start != '') {
            $criteria->condition.=' AND left(t2.grade_achieve_time,10)>="'.$time_start.'"';
        }
        if ($time_end != '') {
            $criteria->condition.=' AND left(t2.grade_achieve_time,10)<="'.$time_end.'"';
        }
        $criteria->condition = get_where($criteria->condition,!empty($project_id),'member_project_id',$project_id,'');
        $criteria->condition=get_like($criteria->condition,'gf_account,zsxm',$keywords,'');
        $criteria->order = 'udate DESC';
        $data = array();
        $data['time_start'] = $time_start;
        $data['time_end'] = $time_end;
        $data['project_list'] = ProjectList::model()->getProject();
        parent::_list($model, $criteria, 'index_dragon_tiger', $data);
    }

    public function actionCreate_dragon_tiger() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_dragon_tiger', $data);
        } else {
            $this->saveLhData($model,$_POST[$modelName]);

        }
    }

    public function actionUpdate_dragon_tiger($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('update_dragon_tiger', $data);
        } else {
            $this->saveLhData($model,$_POST[$modelName]);
        }
    }

    function saveLhData($model,$post) {
        $s1=TopScoreHistory::model()->findAll('gf_id='.$post['member_gfid'].' and project_id='.$post['member_project_id'].' and state=2');
        $num=0;
        
        if(!empty($s1))foreach($s1 as $v){
            $num=$num+$v->credit;
        }
        $sa=0;
        if($post['integral']>$num){
            $log = new TopScoreHistory;
            $log->isNewRecord = true;
            unset($log->id);
            $log->gf_id = $post['member_gfid'];
            $log->get_type = 1375;
            $log->get_score_game_reson = '后台添加';
            $log->project_id = $post['member_project_id'];
            $log->credit = $post['integral']-$num;
            $log->state = 2;
            $log->uDate = date('Y-m-d H:i:s');
            $sa=$log->save();
        }else{
            $sa=1;
        }
        show_status($sa,'保存成功',get_cookie('_currentUrl_'),'保存失败');
    }

    public function actionGetLevel($gf_id,$project_id){
        $s1=TopScoreHistory::model()->findAll('gf_id='.$gf_id.' and project_id='.$project_id.' and state=2');
        $num=0;
        foreach($s1 as $v){
            $num=$num+$v->credit;
        }

        $s2=ServicerLevel::model()->findAll('type in(1472)  order by card_xh ASC');
        $member=ClubMemberList::model()->find('member_gfid='.$gf_id.' and member_project_id='.$project_id.'');
        if(!empty($member)&&$member->project_level_xh>0){
            $m_level=ServicerLevel::model()->find('type in(1472)  and card_xh='.$member->project_level_xh);
            if(empty($m_level)){
                $m_level->card_score=0;
                $m_level->card_end_score=0;
            }
            $s2=ServicerLevel::model()->findAll('type in(1472)  and card_score>='.$m_level->card_score.' and card_end_score>='.$m_level->card_end_score.' order by card_xh ASC');
            $level_xh=$member->project_level_xh;
        }else{
            $level_xh=0;
        }
        $datas=[];
        $index=0;
        foreach($s2 as $vl){
            $datas[$index]['member_level']=$vl->id;
            $datas[$index]['member_level_xh']=$vl->card_xh;
            $datas[$index]['member_level_name']=$vl->card_name;
            $datas[$index]['card_score']=$vl->card_score;
            $datas[$index]['card_end_score']=$vl->card_end_score;
            $index++;
        }
        $error=0;
        $msg='请求成功';

        ajax_exit(array('data' => $datas, 'integral'=>$num, 'level_xh'=>$level_xh, 'error' => $error, 'msg' => $msg));
    }
    
}
