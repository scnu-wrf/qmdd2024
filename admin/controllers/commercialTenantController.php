<?php
class commercialTenantController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

  public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    public function convertEncoding($string){
    //根据系统进行配置
    $encode = stristr(PHP_OS, 'WIN') ? 'GBK' : 'UTF-8';
    $string = iconv('UTF-8', $encode, $string);
    //$string = mb_convert_encoding($string, $encode, 'UTF-8');
    return $string;
    }

    public function UploadImg($s){
            if(isset($_FILES[$s]['name'])){
                  $fileName=$_FILES[$s]['name'];
                  $fileTmpname=$_FILES[$s]['tmp_name'];
                  $fileSize=$_FILES[$s]['size'];
                  $fileError=$_FILES[$s]['error'];
                  $filenType=$_FILES[$s]['type'];
                   $fileExt=explode('.',$fileName);//文件类型
                   $fileActualExt=strtolower(end($fileExt)); 
                   $allowed=array('jpg','jpeg','png');
                   if(in_array($fileActualExt,$allowed)){
                    if($fileError===0){
                       if($fileSize<5000000){
                            $fileNameNew=uniqid('',true).".".$fileActualExt;
                            $fileDestination='uploads/image/'.$fileNameNew;
                            $fileDestination=$this->convertEncoding($fileDestination);
                            move_uploaded_file($fileTmpname, $fileDestination);
                            return $fileDestination;
                       }else{
                          //过大
                          return;
                       }
                    }else{
                        //错误
                          return;
                    }
                   }else{
                    //格式不对
                    return;
                   }
            }else{
                return "";
            }
    }
    public function setData($model){
           if(isset($_POST['ct_type']))
             $model->ct_type=$_POST['ct_type'];
           if(isset($_POST['organization_name'])){
           $model->organization_name=$_POST['organization_name'];
           $model->organization_type=$_POST['organization_type'];
           }
           $model->ct_name=$_POST['ct_name'];
           //处理营业照片
           $temp_ct_certificates_img=$this->UploadImg('ct_certificates_img');
           $model->ct_certificates_number=$_POST['ct_certificates_number'];
           $model->ct_certificates_start=$_POST['ct_certificates_start'];
           $model->ct_certificates_end=$_POST['ct_certificates_end'];
           //处理商户银行
           $temp_ct_bank_pic=$this->UploadImg('ct_bank_pic');
           $model->ct_bank_name=$_POST['ct_bank_name'];
           $model->ct_bank_branch_name=$_POST['ct_bank_branch_name'];
           $model->ct_bank_account=$_POST['ct_bank_account'];
           //处理地址
           $tempaddress="";
           if(!empty($_POST['area']['1']['ct_area_code'])){
            $model->ct_province=TRegion::model()->find("id=".$_POST['area']['1']['ct_area_code'])->region_name_c;
            $tempaddress.=$_POST['area']['1']['ct_area_code'].',';
           }
           if(isset($_POST['area']['2']['ct_area_code'])){
            $model->ct_city=TRegion::model()->find("id=".$_POST['area']['2']['ct_area_code'])->region_name_c;
            $tempaddress.=$_POST['area']['2']['ct_area_code'].',';
           }
           if(isset($_POST['area']['3']['ct_area_code'])){
            $model->ct_district=TRegion::model()->find("id=".$_POST['area']['3']['ct_area_code'])->region_name_c;
            $tempaddress.=$_POST['area']['3']['ct_area_code'].',';
           }
           if(isset($_POST['area']['4']['ct_area_code'])){
            $model->ct_street=TRegion::model()->find("id=".$_POST['area']['4']['ct_area_code'])->region_name_c;
            $tempaddress.=$_POST['area']['4']['ct_area_code'].',';
           }
           $model->ct_area_code=substr($tempaddress, 0, -1);
           $model->ct_address=$_POST['ct_address'];
           //处理法人
           $temp_ct_legal_entity_idCardFront=$this->UploadImg('ct_legal_entity_idCardFront');
           $temp_ct_legal_entity_idCardBack=$this->UploadImg('ct_legal_entity_idCardBack');
           $model->ct_legal_entity_name=$_POST['ct_legal_entity_name'];
           $model->ct_legal_entity_idCardNumber=$_POST['ct_legal_entity_idCardNumber'];
           $model->ct_legal_entity_phone=$_POST['ct_legal_entity_phone'];
           $model->ct_legal_entity_email=$_POST['ct_legal_entity_email'];
           //处理联系人
           $temp_ct_connector_idCardFront=$this->UploadImg('ct_connector_idCardFront');
           $temp_ct_connector_idCardBack=$this->UploadImg('ct_connector_idCardBack');
           $model->ct_connector_name=$_POST['ct_connector_name'];
           $model->ct_connector_idCardNumber=$_POST['ct_connector_idCardNumber'];
           $model->ct_connector_phone=$_POST['ct_connector_phone'];
           $model->ct_connector_email=$_POST['ct_connector_email'];
           //如果是修改
            $model->ct_certificates_img=$temp_ct_certificates_img==""?$model->ct_certificates_img:$temp_ct_certificates_img;
            $model->ct_bank_pic=$temp_ct_bank_pic==""?$model->ct_bank_pic:$temp_ct_bank_pic;
            $model->ct_legal_entity_idCardFront=$temp_ct_legal_entity_idCardFront==""?$model->ct_legal_entity_idCardFront:$temp_ct_legal_entity_idCardFront;
            $model->ct_legal_entity_idCardBack=$temp_ct_legal_entity_idCardBack==""?$model->ct_legal_entity_idCardBack:$temp_ct_legal_entity_idCardBack;
            $model->ct_connector_idCardFront=$temp_ct_connector_idCardFront==""?$model->ct_connector_idCardFront:$temp_ct_connector_idCardFront;
            $model->ct_connector_idCardBack=$temp_ct_connector_idCardBack==""?$model->ct_connector_idCardBack:$temp_ct_connector_idCardBack;
           return $model;
    }
    //添加商户列表
    public function actionIndex($keywords='') {    
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->condition = get_like('ct_condition="未提交审核"','ct_name,ct_connector_name',$keywords,'');
    $criteria->order = 'ct_update_time desc';
    $data = array();
    parent::_list($model, $criteria, 'index', $data);
    }
    //审核商户列表
    public function actionauditIndex($keywords='') {    
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->condition = get_like('ct_condition!="未提交审核"','ct_name,ct_connector_name',$keywords,'');
    $criteria->order = 'ct_update_time desc';
    $data = array();
    parent::_list($model, $criteria, 'auditIndex', $data);
    }
    //过审商户列表
    public function actionauditPassIndex($keywords='') {    
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->condition = get_like('ct_condition="已过审"','ct_name,ct_connector_name',$keywords,'');
    $criteria->order = 'ct_update_time desc';
    $data = array();
    parent::_list($model, $criteria, 'auditPassIndex', $data);
    }
    //未过审商户列表
    public function actionauditNoPassIndex($keywords='') {    
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->condition = get_like('ct_condition="未过审"','ct_name,ct_connector_name',$keywords,'');
    $criteria->order = 'ct_update_time desc';
    $data = array();
    parent::_list($model, $criteria, 'auditNoPassIndex', $data);
    }
    //注销商户列表
    public function actionlockIndex($keywords=''){
    set_cookie('_currentUrl_', Yii::app()->request->url);
    $modelName = $this->model;
    $model = $modelName::model();
    $criteria = new CDbCriteria;
    $criteria->condition = get_like('ct_condition="已注销"','ct_name,ct_connector_name',$keywords,'');
    $criteria->order = 'ct_update_time desc';
    $data = array();
    parent::_list($model, $criteria, 'lockIndex', $data);      
    }
    //添加商户
    public function actionAdd($mode) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(isset($_GET['type'])){
               if($_GET['type']==0){
                   $data['type']=0;
               }else{
                   $data['type']=1;
               }
            }
            $this->render('add',$data);
        } else {
           $newCT=new commercialTenant();
           $newCT=$this->setData($newCT);
           if($mode==1)
             $newCT->ct_condition='未提交审核';
           else if($mode==2)
             $newCT->ct_condition="待审核";
           $newCT->ct_update_time=date("Y-m-d H:i:s");
           $newCT->save();
        }
    }
    //mode=0添加后直接点击去审核，mode=1修改页面修改后直接去审核，mode=2添加index页面直接点击提交审核
    public function actionChangeAuditCondition($id,$mode){
      if($mode==0){
               
      }else if($mode==1){
        $model=commercialTenant::model()->find('id='.$id);
        $model=$this->setData($model);
        $model->ct_condition='待审核';
        $model->ct_update_time=date("Y-m-d H:i:s");
        $this->actionauditIndex('');
      }
    }

    public function actionUpdateEnterprise($id,$mode) {
        $model=commercialTenant::model()->find('id='.$id);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('updateEnterprise', $data);
        } else {
           if($mode==1){
             $model=$this->setData($model);
             $model->ct_condition='未提交审核';
           }
           else if($mode==2){
             $model=$this->setData($model);
             $model->ct_condition='待审核';
           }else if($mode==3){
             $model->ct_condition='待审核';
           }
           $model->ct_update_time=date("Y-m-d H:i:s");
           $model->save();
        }
    }
    public function actionauditEnterprise($id,$mode) {
        $model=commercialTenant::model()->find('id='.$id);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            if(isset($_GET['from'])){
                switch($_GET['from']){
                    case 0:$data['from']='审核';break;
                    case 1:$data['from']='已过审';break;
                    case 2:$data['from']='未过审';break;
                    case 3:$data['from']='已注销';break;
                    default:break;
                }
            }
            $this->render('auditEnterprise', $data);
        } else {
           $model->ct_audit_reasons=$_POST['ct_audit_reasons'];
           $model=$this->setData($model);
           if($mode==1){
             $model->ct_condition='已过审';
           }
           else if($mode==2){
             $model->ct_condition='未过审';
           }else if($mode==4){
             $model->ct_condition='待审核';
           }
           $model->ct_update_time=date("Y-m-d H:i:s");
           $model->save();
        }
    }
    //注销操作
    public function actionlockCT(){
        $model=commercialTenant::model()->find("id=".$_POST['hidId']);
        $model->ct_lock_reason=$_POST['lockReason'];
        $model->ct_lock_date=date("Y-m-d H:i");
        $model->ct_update_time=date("Y-m-d H:i");
        $model->ct_condition="已注销";
        $model->save();
        echo CJSON::encode(1);
    }
    //恢复操作
    public function actionunlockCT(){
        $model=commercialTenant::model()->find("id=".$_POST['hidId']);
        $model->ct_update_time=date("Y-m-d H:i");
        $model->ct_condition="待审核";
        $model->save();
    }
    public function actionScales($info_id){
        $tmp = TRegion::model()->findAll('upper_region='.$info_id);
        $s1='id,CODE,country_id,country_code,region_name_e,level';
        $data=toIoArray($tmp,$s1.',upper_region,region_name_c');
        echo CJSON::encode($data);
    }

 }