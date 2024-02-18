<?php

class PublicController extends CController
{

    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'application.extensions.MyCaptchaAction',
                'backColor' => 0xFFFFFF,
                'maxLength' => '4', // 最多生成几个字符
                'minLength' => '4', // 最少生成几个字符
                'offset' => 1,
                'height' => '40',
                'width' => '100',
                //'fontFile'=> ROOT_PATH.'/static/captcha.ttf',
            ),
        );
    }

    public function actionIndex()
    {
        $data = array();
        $this->render('index', $data);
    }

    public function actionSetPageSize($pageSize=15)
    {
        if($_POST['pageSize']){
          $pageSize=$_POST['pageSize'];      
        }
        set_session('pageSize',$pageSize);
        $data = array('ok'=>'ok','pasgeSize'=>$pageSize);
        echo CJSON::encode($data);
    }

    public function actionLate()
    {
        $data = array();
        $this->render('late', $data);
    }

    public function actionUppic($savepath = '', $sitepath = '', $prefix = '')
    {
        $this->_uploadify($savepath, $sitepath, $prefix);
    }

    // 保存路径结尾带/
    protected function _uploadify($savepath = '', $sitepath = '', $prefix = '')
    {
        if (!isset($_FILES['Filedata'])&&!isset($_FILES['audioData'])) {
            ajax_exit(array('status' => 0, 'msg' => '图片大小超过限制,最大支持' + ini_get('post_max_size')));
        }
        $mp3='';
        if(isset($_FILES['Filedata'])) $attach = CUploadedFile::getInstanceByName('Filedata');
        if(isset($_FILES['audioData'])) {
          $attach = CUploadedFile::getInstanceByName('audioData');
          $mp3='.mp3';
        }
        $savepath = BasePath::model()->savePath();
        # $savepath = ROOT_PATH . '/uploads/temp/';
        
        $sitepath = BasePath::model()->wwwPath();
        
        if ($prefix != '') {
            $prefix .= '_';
        }
        $datePath = BasePath::model()->datePath();
        if (Yii::app()->session['admin_id'] != null) {
            $prefix .= Yii::app()->session['admin_id'] . '_';
        }
        // 保存到远程服务器接口
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'content-type:application/octet-stream',
                'content' => file_get_contents($attach->tempName),
            ),
        );
        $file = stream_context_create($options);
        if (1 == 2) {
            $json_rs = file_get_contents(Yii::app()->params['uploadUrl'] . '?fileCode=' . $prefix . '_&fileType=' . $attach->extensionName, false, $file);
            $rs = json_decode($json_rs, true);
            if ($rs['code'] == 0) {
                ajax_exit(array('status' => 1, 'msg' => '上传成功', 'savename' => $rs['filename'], 'allpath' => $rs['fileUrl'] . '/' . $rs['filename']));
            } else {
                ajax_exit(array('status' => 0, 'msg' => '上传失败'));
            }
        }
        $mp3=($mp3) ? $mp3 : $attach->extensionName;
        $mp3=strtolower($mp3);
        $fileName = $datePath . $prefix . uniqid('', true) . '.' . $mp3;
        if(strtolower($mp3)=='php' || strtolower($mp3)=='exe'){
          ajax_exit(array('status' => 0, 'msg' => '上传失败'));
  
        } else{
        if ($attach->saveAs($savepath . $fileName)) {
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'savename' => $fileName, 'allpath' => $sitepath . $fileName));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
        }
       }
    }

    public function actionVideoLiveNotify()
    {
        echo 'success';
    }

    public function getfileext(){
        $format='';
       // $extstr='';
         if ($extname == 'jpg' || $extname == 'jpeg' || $extname == 'gif' || $extname == 'png' || $extname == 'doc' ||
                $extname == 'xls' || $extname == 'txt'  || $extname == 'zip' || $extname == 'rar' || $extname == 'ppt' ||
                $extname == 'pdf' || $extname == 'rm'   || $extname == 'mid' || $extname == 'wav' || $extname == 'bmp' ||
                $extname == 'swf' || $extname == 'chm'  || $extname == 'sql' || $extname == 'cert'|| $extname == 'pptx' || 
                $extname == 'xlsx' || $extname == 'docx')
            {
                $format = $extname;
            }
            return $format; 
    }
}
