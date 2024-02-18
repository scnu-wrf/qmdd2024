<?php

    class MallProfitInfoController extends BaseController {
        protected $model = '';

        public function init() {
            $this->model = 'MallProfitInfo';
            parent::init();
        }

        public function actionIndex($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition=get_like($criteria->condition,'f_code,f_name',$keywords,'');//get_where
            $data = array();
            parent::_list($model, $criteria, 'index');
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $data['product_list'] =array();
                $this->render('update', $data);
            }else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }
    
        public function actionUpdate($id) {
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $data['product_list'] = MallProfitProduct::model()->findAll('info_id='.$model->id);
                $this->render('update', $data);
            }else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }
        
        function saveData($model,$post) {
        $model->attributes = $post;;
        $st=$model->save();
        $this->save_product($model->id,$model->star_time,$model->end_time);
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
//商品保存
        public function save_product($id,$star_time,$end_time){
            MallProfitProduct::model()->updateAll(array('no'=>-1 ),'info_id='.$id);
            if(!empty($_POST['product'])){
                foreach($_POST['product'] as $v){
                    if($v['product_code']==''){
                        continue;
                    }
                    $product_list=MallProfitProduct::model()->find('info_id='.$id.' and product_code="'.$v['product_code'].'"');
                    if(empty($product_list)){
                        $product_list = new MallProfitProduct();
                        $product_list->isNewRecord = true;
                        unset($product_list->id);
                    }
                    $product_list->info_id = $id;
                    $product_list->product_code = $v['product_code'];
                    $product_list->product_name = $v['product_name'];
                    $product_list->json_attr = $v['json_attr'];
                    $product_list->no = 0;
                    $product_list->star_time = $star_time;
                    $product_list->end_time = $end_time;
                    $product_list->save();
                }
            }
            MallProfitProduct::model()->deleteAll('info_id='.$id.' and no=-1');
        }
    // excel批量添加数据
    public function actionUpExcel($id){
        $model= MallProfitInfo::model()->find('id='.$id);
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
                                    $product_code = $sheet->getCell('A'.$row)->getValue();  // 商品编号
                                    $product_name = $sheet->getCell('B'.$row)->getValue();  // 商品名称
                                    $json_attr = $sheet->getCell('C'.$row)->getValue();  // 型号/规格
                                   
                                    $product = new MallProfitProduct();
                                    $product->isNewRecord = true;
                                    unset($product->id);
                                    $product->product_code = $product_code;
                                    $product->product_name = $product_name;
                                    $product->json_attr = $json_attr;
                                    $product->info_id = $model->id;
                                    $product->star_time = $model->star_time;
                                    $product->end_time = $model->end_time;
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
 
        public function actionDelete($id) {
            $modelName = $this->model;
            $model = $modelName::model();
            $count = 0;
            $le = explode(',',$id);
            foreach($le as $d){
                $model->deleteAll('id='.$d);
                MallProfitProduct::model()->deleteAll('info_id='.$d);
                $count++;
            }
            if ($count > 0) {
                ajax_status(1, '删除成功');
            } else {
                ajax_status(0, '删除失败');
            }
        }
    }