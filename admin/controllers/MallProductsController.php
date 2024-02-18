<?php

class MallProductsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
    }
//商品发布申请列表
   public function actionIndex($keywords = '',$state='') {
        $this->ShowViewIndex($keywords,$state,' and type_fater in (361,364)','index');
    }
//非商城商品发布列表
   public function actionIndex_service($keywords = '',$state='') {
        $this->ShowViewIndex($keywords,$state,' and type_fater in (351,353,355,356,357,359,364,777,1424)','index_service');
    }

   public function ShowViewIndex($keywords='',$state='',$order_type='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='display in (721,371,373)';
        $cr.=' and IS_DELETE=510';
        $cr.=$order_type;
        //$cr.=' AND supplier_id='.get_session('club_id');
        $cr=get_where($cr,$state,' display',$state,''); 
        $cr=get_like($cr,'name,supplier_code,json_attr',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='supplier_code ASC';
        $data = array();
        $data['state'] = BaseCode::model()->findAll('f_id in (721,371,373)');
        parent::_list($model, $criteria, $viewfile, $data);
    }

   //商品发布审核
    public function actionIndex_pass($keywords = '',$state='',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        if ($start=='') $start=$now;
        $criteria = new CDbCriteria;
        $cr='display in (2,373)';
        $cr.=' and IS_DELETE=510';
        $cr=get_where($cr,$state,' display',$state,''); 
        $cr=get_where($cr,($start!=""),'state_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'state_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'name,supplier_code,json_attr,product_code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='product_code ASC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        $data['state'] = BaseCode::model()->findAll('f_id in (2,373)');
        $data['num'] = $model->count('IS_DELETE=510 and display=371');
        parent::_list($model, $criteria, 'index_pass', $data);
   }
//商品发布审核-待审核
   public function actionIndex_check($keywords = '',$start='',$end='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $cr='display=371';
        $cr.=' and IS_DELETE=510'; 
        $cr=get_where($cr,($start!=""),'add_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'add_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'name,supplier_code,json_attr,product_code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='supplier_code ASC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
     parent::_list($model, $criteria, 'index_check', $data);
   }

   //商品发布列表
   public function actionIndex_list($keywords = '',$start='',$end='') {
        $this->ShowViewList($keywords,$start,$end,' AND supplier_id='.get_session('club_id'),'index_list');
    }

   //商品发布查询
   public function actionIndex_search($keywords = '',$start='',$end='') {
        $this->ShowViewList($keywords,$start,$end,'','index_search');
    }

   public function ShowViewList($keywords = '',$start='',$end='',$club='',$viewfile) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d');
        $now_m=date("Y-m-d",strtotime("-1 months",strtotime($now)));
        if ($start=='') $start=$now_m;
        $criteria = new CDbCriteria;
        $cr='display=2';
        $cr.=' and IS_DELETE=510';
        $cr.=$club;
        $cr=get_where($cr,($start!=""),'state_time>=',$start.' 00:00:00','"');
        $cr=get_where($cr,($end!=""),'state_time<=',$end.' 23:59:59','"');
        $cr=get_like($cr,'name,supplier_code,json_attr,product_code',$keywords,'');
        $criteria->condition=$cr;
        $criteria->order ='state_time DESC';
        $data = array();
        $data['start'] = $start;
        $data['end'] = $end;
        parent::_list($model, $criteria, $viewfile, $data);
    }

   //撤销申请
    public function actionCancelSubmit($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $club=explode(',', $id);
        $count=0;
        foreach ($club as $d) {
                $model->updateByPk($d,array('display'=>721));
                $count++;
            
        }
        if ($count > 0) {
            ajax_status(1, '撤销成功');
        } else {
            ajax_status(0, '撤销失败');
        }
    }
 //财务商品分类表  
   public function actionIndex_FD($keywords = '',$code='',$state=2,$brand='',$fd=0) {
    set_cookie('_currentUrl_', Yii::app()->request->url);
     $modelName = $this->model;
     $model = $modelName::model();
	 if($fd==0){
		 $fd_select=' and finance_code=""';
	 } else {
		 $fd_select=' and finance_code<>""'; 
	 }
	 
     $criteria = new CDbCriteria;
	 $cr='IS_DELETE=510 AND '.get_where_club_project('supplier','');
	 $cr=get_where($cr,$state,' display',$state,'');
	 $cr=get_where($cr,$brand,' belong_brand',$brand,''); 
     $cr=get_like($cr,'name,code,supplier_code',$keywords,'');
     $cr=get_where($cr,$code,'left(code,'.strlen($code).')',$code,"'");
	 $criteria->condition.=$cr.$fd_select;
   	 $criteria->order ='code';
	 $num=0;
	 $num=MallProducts::model()->count('finance_code=" " AND IS_DELETE=510 and display=2');
	 $data = array();
	 $data['num']=$num;
     $data['base_code'] = BaseCode::model()->getStateType();
	 $data['club_list'] = ClubList::model()->getCode(380);
     parent::_list($model, $criteria, 'index_FD', $data);
   }
//保存财务编号 
	public function actionFd_code_save() {
        $modelName = $this->model;
     	$model = $modelName::model();
		$arr = $_POST['arr'];
	     $data = array();
		$count=0;
        if (isset($arr)) foreach ($arr as $v) {
            if ($v['id'] == '' || $v['fd_code']=='') {
               continue;
             } else {
             $code ='';
             $code1=substr($v['fd_code'],0, 1);
             $code2=substr($v['fd_code'],0, 3);
             $code3=substr($v['fd_code'],0, 5);
             $code4=substr($v['fd_code'],0, 7);
             $code =$code1.','.$code2.','.$code3.','.$code4;
			 $model->updateAll(array('finance_code' => $v['fd_code'],'finance_type' => $code),'id='.$v['id']);  
			 $count++;
             } 
         }
		 if($count>0){
			 ajax_status(1, '保存成功', get_cookie('_currentUrl_'));
		 } else {
			 ajax_status(0, '保存失败');
		 }
    }
	
	public function actionCreate($id) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$data['model'] = $model;
			$data['product_scroll']=array();
			$data['ptype'] = array();
            $data['city'] = array();
			if($id<>0) {
				$data['model'] = $model->find('id='.$id);
				$model_old = $model->find('id='.$id);
				$basepath = BasePath::model()->getPath(149);
				$data['model']['description_temp']=get_html($basepath->F_WWWPATH.$model_old->description, $basepath);
				if ($model_old->product_scroll != '') {
					$data['product_scroll'] = explode(',', $model_old->product_scroll);
				}
				if (!empty($model_old->type)) {
                    $data['ptype']=explode(',', $model_old->type);
                    $arr_type = explode(',', $model_old->type);
-                   $data['model']['classify_code']=$arr_type[3];
				}
				$data['model']['display']=721;
			}
            $this->render('update', $data);
          } else {
                 $this-> saveData($model,$_POST[$modelName]);
        }
    }
//商品发布详情
    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
			$basepath = BasePath::model()->getPath(149);
			$model->description_temp=get_html($basepath->F_WWWPATH.$model->description, $basepath);
			$data['model'] = $model;
            $data['product_scroll'] = array();
            if ($model->product_scroll != '') {
                $data['product_scroll'] = explode(',', $model->product_scroll);
            }
			// 获取分类
            if (!empty($model->type)) {
                $data['ptype']=explode(',', $model->type);
                $arr_type = explode(',', $model->type);
-                $data['model']['classify_code']=$arr_type[3];
            } else {
                $data['ptype'] = array();
            }
            $data['city'] = (!empty($model->province)) ? TRegion::model()->getUpper($model->province,2) :array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
  } 
    public function actionCreate_service($id) {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['product_scroll']=array();
            $data['ptype'] = array();
            $data['city'] = array();
            if($id<>0) {
                $data['model'] = $model->find('id='.$id);
                $model_old = $model->find('id='.$id);
                $basepath = BasePath::model()->getPath(149);
                $data['model']['description_temp']=get_html($basepath->F_WWWPATH.$model_old->description, $basepath);
                if ($model_old->product_scroll != '') {
                    $data['product_scroll'] = explode(',', $model_old->product_scroll);
                }
                if (!empty($model_old->type)) {
                    $data['ptype']=explode(',', $model_old->type);
                    $arr_type = explode(',', $model_old->type);
-                   $data['model']['classify_code']=$arr_type[3];
                }
                $data['model']['display']=721;
            }
            $this->render('update_service', $data);
          } else {
                 $this-> saveData($model,$_POST[$modelName]);
        }
    }
//非商城商品发布详情
    public function actionUpdate_service($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $basepath = BasePath::model()->getPath(149);
            $model->description_temp=get_html($basepath->F_WWWPATH.$model->description, $basepath);
            $data['model'] = $model;
            $data['product_scroll'] = array();
            if ($model->product_scroll != '') {
                $data['product_scroll'] = explode(',', $model->product_scroll);
            }
            // 获取分类
            if (!empty($model->type)) {
                $data['ptype']=explode(',', $model->type);
                $arr_type = explode(',', $model->type);
-                $data['model']['classify_code']=$arr_type[3];
            } else {
                $data['ptype'] = array();
            }
            $data['city'] = (!empty($model->province)) ? TRegion::model()->getUpper($model->province,2) :array();
            $this->render('update_service', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
  }
    function saveData($model,$post) {
       $model->attributes =$post;
       $model->display=get_check_code($_POST['submitType']);
       if($_POST['submitType']=='shenhe'){
           $model->add_time=date('Y-m-d h:i:s');
       }
        $model->made_in=$model->province.$model->city;
       $sv=$model->save();
       if($_POST['submitType']=='shenhe'){
            show_status($sv,'提交成功', get_cookie('_currentUrl_'),'提交失败'); 
       } else {
            show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
       }
       
    }

  public function actionUpdate_check($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $basepath = BasePath::model()->getPath(149);
            $model->description_temp=get_html($basepath->F_WWWPATH.$model->description, $basepath);
            $data['model'] = $model;
            $data['product_scroll'] = array();
            if ($model->product_scroll != '') {
                $data['product_scroll'] = explode(',', $model->product_scroll);
            }
            // 获取分类
            if (!empty($model->type)) {
                $data['ptype']=explode(',', $model->type);
                $arr_type = explode(',', $model->type);
-                $data['model']['classify_code']=$arr_type[3];
            } else {
                $data['ptype'] = array();
            }
            $this->render('update_check', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $state=get_check_code($_POST['submitType']);
            $st=0;
            $msg=$model->reasons_for_failure;
            $type=$model->type;
            $admin_id = get_session('admin_id'); 
            $admin_nick = get_session('admin_name');
            $now=date('Y-m-d h:i:s');
            if($state!=''){
                MallProducts::model()->updateAll(
                    array('display'=>$state,
                        'type'=>$type,
                        'state_time'=>$now,
                        'reasons_for_failure'=>$msg,
                        'admin_id'=>$admin_id,
                        'admin_nick'=>$admin_nick,
                        'long_pay_time'=>$model->long_pay_time,
                        'is_post'=>$model->is_post,
                        'sign_long_cycle'=>$model->sign_long_cycle,
                        'if_apply_return'=>$model->if_apply_return,
                        'return_cycle'=>$model->return_cycle,
                        'if_invoice'=>$model->if_invoice,
                        'invoice_cycle'=>$model->invoice_cycle
                    ),'id='.$model->id);
                if($state==2) $this->save_product_code($model->id);
                $this->save_project_list($model->id,$_POST['MallProducts']['project_list']);
                $st++;
            }
            show_status($st,'已审核',get_cookie('_currentUrl_'),'审核失败');
        }
  }
  public function actionUpdate_change($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $basepath = BasePath::model()->getPath(149);
            $model->description_temp=get_html($basepath->F_WWWPATH.$model->description, $basepath);
            $data['model'] = $model;
            $data['product_scroll'] = array();
            if ($model->product_scroll != '') {
                $data['product_scroll'] = explode(',', $model->product_scroll);
            }
            // 获取分类
            if (!empty($model->type)) {
                $data['ptype']=explode(',', $model->type);
                $arr_type = explode(',', $model->type);
-                $data['model']['classify_code']=$arr_type[3];
            } else {
                $data['ptype'] = array();
            }
            $this->render('update_change', $data);
        } else {
            $model->attributes =$_POST[$modelName];
            $state=get_check_code($_POST['submitType']);
            $st=0;
            $msg=$model->reasons_for_failure;
            $type=$model->type;
            $admin_id = get_session('admin_id'); 
            $admin_nick = get_session('admin_name');
            if($state!=''){
                MallProducts::model()->updateAll(
                    array(
                        'type'=>$type,
                        'reasons_for_failure'=>$msg,
                        'admin_id'=>$admin_id,
                        'admin_nick'=>$admin_nick,
                        'long_pay_time'=>$model->long_pay_time,
                        'is_post'=>$model->is_post,
                        'sign_long_cycle'=>$model->sign_long_cycle,
                        'if_apply_return'=>$model->if_apply_return,
                        'return_cycle'=>$model->return_cycle,
                        'if_invoice'=>$model->if_invoice,
                        'invoice_cycle'=>$model->invoice_cycle
                    ),'id='.$model->id);
                $this->save_product_code($model->id);
                $this->save_project_list($model->id,$_POST['MallProducts']['project_list']);
                $st++;
            }
            show_status($st,'更新成功',get_cookie('_currentUrl_'),'更新失败');
        }
  }

  public function actionUpdate_pass($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $basepath = BasePath::model()->getPath(149);
            $model->description_temp=get_html($basepath->F_WWWPATH.$model->description, $basepath);
            $data['model'] = $model;
            $data['product_scroll'] = array();
            if ($model->product_scroll != '') {
                $data['product_scroll'] = explode(',', $model->product_scroll);
            }
            // 获取分类
            if (!empty($model->type)) {
                $data['ptype']=explode(',', $model->type);
                $arr_type = explode(',', $model->type);
-                $data['model']['classify_code']=$arr_type[3];
            } else {
                $data['ptype'] = array();
            }
            $this->render('update_pass', $data);
        }
  }


  public function save_project_list($id,$project_list){       
    //删除原有项目
    MallProductsProject::model()->deleteAll('mall_products_id='.$id);
    if(!empty($project_list)){
        $model2 = new MallProductsProject();
        $club_list_pic = array();
        $club_list_pic = explode(',', $project_list);
        $club_list_pic = array_unique($club_list_pic);
        foreach ($club_list_pic as $v) {
            $model2->isNewRecord = true;
            unset($model2->id);
            $model2->mall_products_id =$id;
            $model2->project_id = $v;
            $model2->save();
        }
    }
  }
    public function save_product_code($id){
        $model= MallProducts::model()->find('id='.$id);
        $supplier_code='';
        $supplier=ClubList::model()->find('id='.$model->supplier_id); 
        if(!empty($supplier)){
           $supplier_code.=$supplier->club_code; 
        }    
        $gf_code=substr($model->type, -8);
        $product_code='';
        $se1='IS_DELETE=510 AND code like "'.$gf_code.'%" order by code DESC';
        $se='IS_DELETE=510 AND code like "'.$gf_code.'%" and name="'.$model->name.'"';
        $ptype=MallProducts::model()->find($se1);
        if(!empty($ptype)){
            $product=MallProducts::model()->find($se.' order by code DESC');
            if(!empty($product) && !empty($product->code)){
                $name_code=substr($ptype->code,0, 14);
                $pattr=MallProducts::model()->find('IS_DELETE=510 AND code like "'.$name_code.'%" and name="'.$model->name.'"'.' and json_attr="'.$model->json_attr.'" order by code DESC');
                if(!empty($pattr)){
                    $product_code=$pattr->code;
                } else{
                    $attr_code=substr($product->code, -2);
                    $acode = substr('00' . strval(intval($attr_code)+1), -2);
                    $product_code=substr($product->code, 0, -2).$acode;
                }
            } else{
                $pro_code=substr($ptype->code,8, -2);
                $pcode = substr('000000' . strval(intval($pro_code)+1), -6);
                $product_code=$gf_code.$pcode.'01';
            }
        } else{
            $product_code=$gf_code.'00000101';
        }
        MallProducts::model()->updateAll(array('code'=>$product_code,'product_code'=>$supplier_code.$product_code),'id='.$id);
        //$this->code=$product_code;
        //$this->product_code=$supplier_code.$product_code;
    }
  //根据分类编码获取商品分类
  public function actionValidate($code) {
      $type=MallProductsTypeSname::model()->find('tn_code="'.$code.'"');
	  $arr = array();
	  for ($i=1;$i<5;$i++){
        $t=substr($code,0,$i*2);
	    $typeInfo= MallProductsTypeSname::model()->find('tn_code="'.$t.'"');
        $arr['tname'.$i] = '无此分类';
	    $arr['code'.$i]='-1';
      if(!empty($typeInfo)) {
        $arr['code'.$i] = $typeInfo->tn_code;
		$arr['tname'.$i] = $typeInfo->sn_name;
       } 
      }
      if(!empty($type)) {
        $arr['long_pay_time']=$type->long_pay_time;
        $arr['is_post']=$type->is_post;
        $arr['sign_long_cycle']=$type->sign_long_cycle;
        $arr['if_apply_return']=$type->if_apply_return;
        $arr['return_cycle']=$type->return_cycle;
        $arr['if_invoice']=$type->if_invoice;
        $arr['invoice_cycle']=$type->invoice_cycle;
      } else{
        $arr['long_pay_time']='';
        $arr['is_post']='';
        $arr['sign_long_cycle']='';
        $arr['if_apply_return']='';
        $arr['return_cycle']='';
        $arr['if_invoice']='';
        $arr['invoice_cycle']='';
      }
	    ajax_exit($arr);
    }

    public function actionValidatecode($code) {
      $arr = array();
      if(!empty($code)){
      $typeInfo= MallProducts::model()->find('code="'.$code.'"');
      }
      if(!empty($typeInfo)) {
        $arr['id'] = $typeInfo->id;
        $arr['name'] = $typeInfo->name;
       }
        ajax_exit($arr);
    }

    // excel批量添加数据
    public function actionUpExcel($info=''){
        $modelName = $this->model;
        $model = new $modelName;
        if(isset($_POST['submit'])){
            $attach = CUploadedFile::getInstanceByName('excel_file');
            $sv = 0;
            $info = '';
            if(!empty($attach)){
                $dotArray = explode('.', $attach->getName());    //把文件名安.区分，拆分成数组
                $type = end($dotArray);
                if ($type=='xls' || $type=='xlsx') {
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
                        // $highestColumn ='B';
                        if($highestRow>1002){
                            $info = "提示：一次导入信息数据最多为1000条。";
                        } else{
                            if($info==''){
                                //$sv = 0;
                                for($row=3;$row<=$highestRow;$row++){
                                    $supplier_code = $sheet->getCell('A'.$row)->getValue();  // 供应商编号
                                    $name = $sheet->getCell('B'.$row)->getValue();  // 商品名称
                                    $json_attr = $sheet->getCell('C'.$row)->getValue();  // 型号/规格
                                    $type_fater = $sheet->getCell('D'.$row)->getValue();  // 商品类型
                                    $product_model = $sheet->getCell('E'.$row)->getValue();  // 销售、赠品
                                    $weigth = $sheet->getCell('F'.$row)->getValue();  // 商品重量
                                    $unit = $sheet->getCell('G'.$row)->getValue();  // 商品单位
                                    $price = $sheet->getCell('H'.$row)->getValue();  // 全国统一零售价
                                    $keywords = $sheet->getCell('I'.$row)->getValue();  // 商品关键词
                                   
                                    $product = new MallProducts();
                                    $product->isNewRecord = true;
                                    unset($product->id);
                                    $product->supplier_id = get_session('club_id');
                                    $product->supplier_code = $supplier_code;
                                    $product->name = $name;
                                    $product->type_fater = $type_fater;
                                    $product->product_model = $product_model;
                                    $product->json_attr = $json_attr;
                                    $product->weigth = $weigth;
                                    $product->unit = $unit;
                                    $product->price = $price;
                                    $product->keywords = $keywords;
                                    $sv=$product->save();
                                }
                                if($sv==1){
                                    $info = '导入完成';
                                }
                                else{
                                    $info = '导入失败';
                                }
                            }
                        }
                    }
                } else {
                    $info = '不支持该文档类型';
                }
            }
        }
        return $this->render('upExcel',array('info'=>$info));
    }
	
	//逻辑删除
  public function actionDelete($id) {
        $modelName = $this->model;
        $model = $modelName::model();
        $now=date('Y-m-d H:i:s');
		$club=explode(',', $id);
        $count=0;
		foreach ($club as $d) {
            $detail=MallPriceSetDetails::model()->findAll('product_id='.$d.' and star_time<"'.$now.'" and end_time>"'.$now.'"');
            if(empty($detail)){
                $model->updateByPk($d,array('IS_DELETE'=>509));
                $count++;
            } else {
                ajax_status(0, '商品正在上架，无法删除'); 
            }
			
		}
		
        if ($count > 0) {
            ajax_status(1, '删除成功');
        } else {
            ajax_status(0, '删除失败');
        }
    }

}
