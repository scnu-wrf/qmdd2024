<?php

class SensitiveWordsController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        
    }


    public function actionIndex($type_name = '',  $keywords = '',$is_excel='0') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '1=1 '; 
        $criteria->order = 'id DESC' ;//排序条件

        if ($type_name != "所有类型" and $type_name != "") {
            $criteria->condition=get_like($criteria->condition,'sensitive_type_name',$type_name,'');
        }


        if ($keywords !="请输入关键字")  {
         $criteria->condition=get_like($criteria->condition,'sensitive_content',$keywords,'');
        }

         // parent::_list($model, $criteria);

        if(!isset($is_excel) || $is_excel!='1'){
             parent::_list($model, $criteria);
            // parent::_list($model, $criteria, 'index', $data);
        }else{
            $arclist = $model->findAll($criteria);
            $total = count($model->findAll($criteria));
            $data=array();
            $title = array();

            Yii::$enableIncludePath = false;
            Yii::import('application.extensions.PHPExcel.PHPExcel',1);
            Yii::import('application.extensions.PHPExcel.PHPExcel.IOFactory',1);

// include 'phpexcel/PHPExcel.php';
// include 'phpexcel/PHPExcel/Writer/Excel2007.php';

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->setActiveSheetIndex(0);

            $objPHPExcel->getActiveSheet()->setCellValue('A1', '敏感词类型');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', '敏感词内容');

            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('宋体');
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setName('宋体');
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setSize(10);
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);

            $i=2;
            foreach ($arclist as $v) {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $i,$v->sensitive_type_name);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $v->sensitive_content);               
                $i++;
            }
            // for ($i = 2; $i <=$total; $i++) {
            //     $objPHPExcel->getActiveSheet()->setCellValue('A' . $i,$v->sensitive_type_name);
            //     $objPHPExcel->getActiveSheet()->setCellValue('B' . $i,$v->sensitive_content);
            // }           
            // foreach ($arclist as $v) {
            //     for ($i = 2; $i <=$total; $i++) {
            //         $objPHPExcel->getActiveSheet()->setCellValue('A' . $i,$v->sensitive_type_name);
            //         $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, $v->sensitive_content);
            //     }
            // }

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
            header("Content-Type:application/force-download");
            header("Content-Type:application/vnd.ms-execl");
            header("Content-Type:application/octet-stream");
            header("Content-Type:application/download");
            //文件名称
            header('Content-Disposition:attachment;filename="敏感词库.xlsx"');
            header("Content-Transfer-Encoding:binary");
            $objWriter->save('php://output');
            exit;
            
            parent::_list($model, $criteria);
        }

    }

    public function actionUpExcel($retValue=''){  
        // $st=0; //判断返回哪个页面

        if(isset($_POST['submit'])){
            
            $attach = CUploadedFile::getInstanceByName('excel_file');  
            if ($attach->getType()=='application/vnd.ms-excel' || $attach->getType()=='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {

                if($attach->size > 2*1024*1024){  
                    $retValue = "提示：文件大小不能超过2M";  
                }
                else{ //数据导入开始
                
                   $excelFile = $attach->getTempName();//获取文件名
                    $extension = $attach->extensionName ;

                    Yii::$enableIncludePath = false;
                    Yii::import('application.extensions.PHPExcel.PHPExcel', 1);
                    $phpexcel = new PHPExcel;
                    if ($extension=='xls') {
                        $excelReader = PHPExcel_IOFactory::createReader('Excel5');
                    } else {
                        $excelReader =PHPExcel_IOFactory::createReader('Excel2007');
                    }
                    
                    
                    $objPHPExcel = $excelReader->load($excelFile);//

                    $sheet=$objPHPExcel->getSheet(0);

                    $highestRow = $sheet->getHighestRow(); // 取得总行数
                     // $highestColumn = $sheet->getHighestColumn(); // 取得总列数
                    // $highestColumn ='B';

                        if ($highestRow>1001){ //第一行为标题，第二行开始为数据
                            $retValue = "提示：一次导入客户数据最多为1000条。"; 
                            
                        }
                        else{ //检测数据是否符合要求
                            for ($row = 2; $row <= $highestRow; $row++){
                                //列数循环 , 列数是以A列开始
                                $sType=$sheet->getCell('A'.$row)->getValue();
                                $sName=$sheet->getCell('B'.$row)->getValue();

                                if (strlen($sType)==0||strlen($sType)>120||strlen($sName)==0||strlen($sName)>120) {
                                   $retValue = '提示：第'.$row.'行数据不符合要求。敏感词类型、敏感词内容不能为空，敏感词内容长度小于120。';
                                    break;
                                }

                            } //for 

                        }//检测数据是否符合要求

                        if ($retValue==''){
                                    //开始导数据
                                    $modelName = $this->model;
                                    $model1= new $modelName;
                                    /** 循环读取每个单元格的数据 */
                                    //行数循环
                                    for ($row = 2; $row <= $highestRow; $row++){
                                        //列数循环 , 列数是以A列开始
                                        $sType=$sheet->getCell('A'.$row)->getValue();
                                        $sName=$sheet->getCell('B'.$row)->getValue();
                                        
                                        $model1= new $modelName;
                                        $model1->isNewRecord=true;
                                        $model1->sensitive_type_name=$sType;
                                        $model1->sensitive_content=$sName;
                                        $model1->save();  
                                          
                                    }         
                             $retValue='导入完成'; 
                                                            
                        }                       

               // exit;
                } //数据导入结束 else


            } 
            
        } //isset($_POST['submit'])

        // echo $retValue;
        return $this->render('upExcel',array('retValue'=>$retValue)); 

        
       
    }  

    public function actionUpExcel1() {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        var_dump(Yii::app()->request->isPostRequest);
        var_dump( '   '.$_POST['inputExcel']);
       return $this->render('upExcel');
    }        

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        $s1=get_cookie('_currentUrl_');
        $s2=strpos($s1,'?r=');
            if($s2>=0){
                $s1=substr($s1,0,$s2).'?r=SensitiveWords/index';
                }

        parent::_create($model, 'update', $data, $s1);
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();

       $s1=get_cookie('_currentUrl_');
        $s2=strpos($s1,'?r=');
            if($s2>=0){
                $s1=substr($s1,0,$s2).'?r=SensitiveWords/index';
                }
     
        parent::_update($model, 'update', $data, $s1);
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }


}

