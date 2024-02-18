<?php 
    class StudentInfoController extends BaseController {
        protected $model = '';

        public function init() {
            $this->model = 'StudentInfo';
            parent::init();
        }

        public function actionIndex($keywords='',$is_excel='0') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition = 'club_id='.get_session('club_id');
            // $criteria->order = '';
            $data = array();
            if(!isset($is_excel) || $is_excel!='1'){
                parent::_list($model, $criteria);
               // parent::_list($model, $criteria, 'index', $data);
           }else{
                $arclist = $model->findAll($criteria);
                $total = count($model->findAll($criteria));
                $count = $total+2;
                $data=array();
                $title = array();
                Yii::$enableIncludePath = false;
                Yii::import('application.extensions.PHPExcel.PHPExcel',1);
                Yii::import('application.extensions.PHPExcel.PHPExcel.IOFactory',1);
                $objPHPExcel = new PHPExcel();
                $objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getActiveSheet()->setCellValue('A1', get_session('club_name'));
                $objPHPExcel->getActiveSheet()->getStyle('A:O')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  // 垂直居中
                $objPHPExcel->getActiveSheet()->getStyle('A:O')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  // 水平居中
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);  // 垂直居中
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);  // 水平居中
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFCC99');  // 设置单元格颜色
                $objPHPExcel->getActiveSheet()->getStyle('A2:O2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('FFCC99');
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('宋体');
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(10);
                $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getStyle('F')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);  // 整列为文本格式,防止出现科学计数
                $objPHPExcel->getActiveSheet()->getStyle('K')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objPHPExcel->getActiveSheet()->getStyle('L')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);
                $objPHPExcel->getActiveSheet()->mergeCells('A1:O1');  // 合并单元格
                $objActSheet = $objPHPExcel->getActiveSheet();
                $objActSheet->getColumnDimension('A')->setWidth(10);  // 设置列宽
                $objActSheet->getColumnDimension('B')->setWidth(20);
                $objActSheet->getColumnDimension('C')->setWidth(10);
                $objActSheet->getColumnDimension('D')->setWidth(10);
                $objActSheet->getColumnDimension('E')->setWidth(25);
                $objActSheet->getColumnDimension('F')->setWidth(25);
                $objActSheet->getColumnDimension('G')->setWidth(30);
                $objActSheet->getColumnDimension('H')->setWidth(10);
                $objActSheet->getColumnDimension('I')->setWidth(15);
                $objActSheet->getColumnDimension('J')->setWidth(20);
                $objActSheet->getColumnDimension('K')->setWidth(30);
                $objActSheet->getColumnDimension('L')->setWidth(15);
                $objActSheet->getColumnDimension('M')->setWidth(20);
                $objActSheet->getColumnDimension('N')->setWidth(20);
                $objActSheet->getColumnDimension('O')->setWidth(35);
                $styleThinBlackBorderOutline = array(
                    'borders' => array (
                        'allborders' => array (  // allborders：设置全部边框，outline：设置单元格边框
                            'style' => PHPExcel_Style_Border::BORDER_THIN,   // 细边框
                            //'style' => PHPExcel_Style_Border::BORDER_THICK,  // 粗边框
                            'color' => array ('argb' => 'FF000000'),          //设置border颜色
                        ),
                    ),
                );
                $objPHPExcel->getActiveSheet()->getStyle('A1:O'.$count)->applyFromArray($styleThinBlackBorderOutline);
             
                    $objPHPExcel->getActiveSheet()->setCellValue('A2', '序号');
                    $objPHPExcel->getActiveSheet()->setCellValue('B2', '院系');
                    $objPHPExcel->getActiveSheet()->setCellValue('C2', '学年');
                    $objPHPExcel->getActiveSheet()->setCellValue('D2', '年级');
                    $objPHPExcel->getActiveSheet()->setCellValue('E2', '班级');
                    $objPHPExcel->getActiveSheet()->setCellValue('F2', '学号');
                    $objPHPExcel->getActiveSheet()->setCellValue('G2', '姓名');
                    $objPHPExcel->getActiveSheet()->setCellValue('H2', '性别');
                    $objPHPExcel->getActiveSheet()->setCellValue('I2', '民族');
                    $objPHPExcel->getActiveSheet()->setCellValue('J2', '籍贯');
                    $objPHPExcel->getActiveSheet()->setCellValue('K2', '身份证号码');
                    $objPHPExcel->getActiveSheet()->setCellValue('L2', '联系电话');
                    $objPHPExcel->getActiveSheet()->setCellValue('M2', '电子邮箱');
                    $objPHPExcel->getActiveSheet()->setCellValue('N2', '邮政编码');
                    $objPHPExcel->getActiveSheet()->setCellValue('O2', '通讯地址');
                // }
                $i=3;
                $num=1;
                foreach ($arclist as $v) {
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$i,$num);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $v->sc_facult);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $v->sc_yeal);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $v->sc_grade);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $v->sc_class);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$i, $v->sc_studentID);
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$i, $v->sc_code);
                    $objPHPExcel->getActiveSheet()->setCellValue('O'.$i, $v->sc_address);
                    $gf_user = userlist::model()->find('GF_ID='.$v->gf_user_id);
                    if(!empty($gf_user)){
                        $objPHPExcel->getActiveSheet()->setCellValue('G'.$i, $gf_user->ZSXM);
                        $objPHPExcel->getActiveSheet()->setCellValue('H'.$i, $gf_user->real_sex_name);
                        $objPHPExcel->getActiveSheet()->setCellValue('I'.$i, $gf_user->nation);
                        $objPHPExcel->getActiveSheet()->setCellValue('J'.$i, $gf_user->native);
                        $objPHPExcel->getActiveSheet()->setCellValue('K'.$i, $gf_user->id_card);
                        $objPHPExcel->getActiveSheet()->setCellValue('L'.$i, $gf_user->PHONE);
                        $objPHPExcel->getActiveSheet()->setCellValue('M'.$i, $gf_user->EMAIL);
                    }
                    $i++;
                    $num++;
                }
                $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
                ob_end_clean();
                header("Pragma: public");
                header("Expires: 0");
                header("Cache-Control:must-revalidate, post-check=0, pre-check=0");
                header("Content-Type:application/force-download");
                header("Content-Type:application/vnd.ms-execl");
                header("Content-Type:application/octet-stream");
                header("Content-Type:application/download");
                //文件名称
                header('Content-Disposition:attachment;filename="学生信息.xlsx"');
                header("Content-Transfer-Encoding:binary");
                $objWriter->save('php://output');
                exit;
                parent::_list($model, $criteria);
           }
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if (!Yii::app()->request->isPostRequest) {
                $data['model'] = $model;
                $this->render('update', $data);
            } else {
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        public function actionUpdate($id) {
            $modelName = $this->model;
            $model = $this->loadModel($id, $modelName);
            if (!Yii::app()->request->isPostRequest) {
                $data = array();
                $data['model'] = $model;
                $this->render('update', $data);
            } else {
                $this->saveData($model,$_POST[$modelName]);
            }
        }

        function saveData($model,$post) {
            $model->attributes = $post;
            $sv = $model->save();
            // $this->actionExcel();
            show_status($sv,'操作成功',get_cookie('_currentUrl_'),'操作失败');
        }

        public function actionUpExcel($info=''){
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
                            if($highestRow>1002){
                                $info = "提示：一次导入信息数据最多为1000条。";
                            }
                            else{
                                if($info==''){
                                    $modelName = $this->model;
                                    $model = new $modelName;
                                    $sa = 0;
                                    $sc = 0;
                                    for($row=3;$row<=$highestRow;$row++){
                                        $sc_facult = $sheet->getCell('B'.$row)->getValue();  // 院系
                                        $sc_yeal = $sheet->getCell('C'.$row)->getValue();  // 学年
                                        $sc_grade = $sheet->getCell('D'.$row)->getValue();  // 年级
                                        $sc_class = $sheet->getCell('E'.$row)->getValue();  // 班级
                                        $sc_studentID = $sheet->getCell('F'.$row)->getValue();  // 学号
                                        $sc_code = $sheet->getCell('N'.$row)->getValue();  // 邮编
                                        $sc_address = $sheet->getCell('O'.$row)->getValue();  // 通讯地址

                                        // userlist
                                        $gf_ZSXM = $sheet->getCell('G'.$row)->getValue();  // 姓名
                                        $gf_SEX = $sheet->getCell('H'.$row)->getValue();  // 性别
                                        $gf_nation = $sheet->getCell('I'.$row)->getValue();  // 民族
                                        $gf_native = $sheet->getCell('J'.$row)->getValue();  // 籍贯
                                        $gf_id_card = $sheet->getCell('K'.$row)->getValue();  // 身份证
                                        $gf_PHONE = $sheet->getCell('L'.$row)->getValue();  // 手机号
                                        $gf_EMAIL = $sheet->getCell('M'.$row)->getValue();  // 邮箱
                                        // userlist
                                        $rand = floor(rand(100000,999999));
                                        $gf_user = userlist::model()->find('GF_ACCOUNT="'.$rand.'"');
                                        if(empty($gf)){
                                            $gf_user = new userlist();
                                            $gf_user->isNewRecord = true;
                                            unset($gf_user->GF_ID);
                                            $gf_user->GF_ACCOUNT = $rand;
                                            $gf_user->nation = $gf_nation;
                                            $gf_user->native = $gf_native;
                                            if($gf_SEX=='男'){
                                                $gf_user->real_sex = 205;
                                            }
                                            else if($gf_SEX=='女'){
                                                $gf_user->real_sex = 207;
                                            }
                                            $gf_user->real_sex_name = $gf_SEX;
                                            $gf_user->ZSXM = $gf_ZSXM;
                                            $gf_user->id_card = $gf_id_card;
                                            $gf_user->PHONE = $gf_PHONE;
                                            $gf_user->EMAIL = $gf_EMAIL;
                                            $sa = $gf_user->save();
                                        }
                                        $model = new $modelName;
                                        $model->isNewRecord = true;
                                        unset($model->id);
                                        $model->club_id = get_session('club_id');
                                        $model->gf_user_id = $gf_user->GF_ID;
                                        $model->sc_facult = $sc_facult;
                                        $model->sc_yeal = $sc_yeal;
                                        $model->sc_studentID = $sc_studentID;
                                        $model->sc_grade = $sc_grade;
                                        $model->sc_class = $sc_class;
                                        $model->sc_code = $sc_code;
                                        $model->sc_address = $sc_address;
                                        $sc = $model->save();
                                    }
                                    if($sa==1 && $sc==1){
                                        $info = '导入完成';
                                    }
                                    else{
                                        $info = '导入失败';
                                    }
                                }
                            }
                        }
                    }
                }
                // show_status($sv,$info,get_cookie('_currentUrl_'),$info);
                // return $this->render('upExcel',array('info'=>$info));
                // else{
                //     // ajax_status(0,'请上传数据');
                //     $r = '请上传数据';
                //     // return $r;
                //     return CJSON::encode($r);
                // }
            }
            return $this->render('upExcel',array('info'=>$info));
        }

        public function actionDelete($id) {
            // parent::_clear($id);
            $modelName = $this->model;
            $len = explode(',',$id);
            $count = 0;
            foreach($len as $d){
                $model = $this->loadModel($d, $modelName);
                $gf = userlist::model()->deleteAll('GF_ID='.$model->gf_user_id);
                $model->deleteAll('id='.$d);
                $count++;
            }
            if($count>0){
                ajax_status(1, '删除成功');
            }
            else{
                ajax_status(0, '删除失败');
            }
        }
    }