<?php
class testCommentController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    //小程序获取场馆评论
    public function actionGetComment($staId) { 
        $criteria = new CDbCriteria;
        $criteria->addCondition("staCode='$staId'");
        $model1 = testComment::model()->find($criteria);
        $tags = explode(",",$model1->tags);
        $model1->tags = $tags;
        echo CJSON::encode($model1);
    }

 }