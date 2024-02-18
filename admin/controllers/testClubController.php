<?php
class testClubController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    //小程序获取场馆俱乐部信息
    public function actionGetClub($staId) {
        $tmp = testClub::model()->findAll("staCode='".$staId."'");
        foreach($tmp as $k=>$v){
            $tmp[$k]->leader=explode(",", $v->leader);;
            $tmp[$k]->phone=explode(",", $v->phone);
        }
        echo CJSON::encode($model1);
    } 

 }