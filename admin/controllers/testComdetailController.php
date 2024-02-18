<?php
class testComdetailController extends BaseController{//与模建立联系
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
     public function actionUploadCommentImg(){
        //put_msg($_FILES);
            if(isset($_FILES['file']['name'])){
                  $fileName=$_FILES['file']['name'];
                  $fileTmpname=$_FILES['file']['tmp_name'];
                  $fileSize=$_FILES['file']['size'];
                  $fileError=$_FILES['file']['error'];
                  $filenType=$_FILES['file']['type'];
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
                            echo CJSON::encode($fileDestination);
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
    //小程序保存评论
    public function actionsaveComment($staId,$staName,$userHeadImg,$userName,$commentContent,$commentTime,$imageUrl){
        $newComment=new testComdetail();
        $newComment->staCode=$staId;
        $newComment->staName=$staName;
        $newComment->userAvatar=$userHeadImg;
        $newComment->nickName=$userName;
        $newComment->content=$commentContent;
        $newComment->publicTime=$commentTime;

        $temp=substr($imageUrl,0,-1);
        $temp=str_replace('"','',$temp);
        $newComment->contentPic=$temp;
        put_msg('传过来的场馆id：'.$staId);
        put_msg('传过来的场馆名字：'.$staName);
        put_msg('传过来的用户头像：'.$userHeadImg);
        put_msg('传过来的用户姓名：'.$userName);
        put_msg('传过来的评论内容：'.$commentContent);
        put_msg('传过来的评论时间：'.$commentTime);
        put_msg('传过来的评论url：'.$temp);
        $newComment->publicDetailTime=date("Y-m-d H:i:s");
        if(empty($imageUrl))
            put_msg('没传过来url啊');
        $newComment->save();
    }
    //小程序获取场馆评论具体内容
    public function actionGetCommentDetail($staId) { 
        $criteria = new CDbCriteria;
        $criteria->addCondition("staCode='$staId'");
        $criteria->order="publicDetailTime desc";
        $model1 = testComdetail::model()->findAll($criteria);
        foreach ($model1 as $v) {
           if($v->contentPic!=""){
            $contentPic = array();
            $contentPic = explode(";",$v->contentPic);
            $v->contentPic = $contentPic;
          }
        }
        echo CJSON::encode($model1);
    }

 }