<?php
//controller中才是与数据库交互的地方
class CreditController extends BaseController {
	//protected $project_list = '';
    protected $model = '';
    protected $model2 = '';

    public function init() {
        $this->model = 'userlist';
        $this->model2 = 'TopScoreHistory';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionDelete($id) {
        parent::_clear($id);
    }//用id进行删除


    public function actionIndex($keywords='') {    
        set_cookie('_currentUrl_', Yii::app()->request->url);//生成一个返回index控制器的url
        $modelName = $this->model;
        $model = $modelName::model();
        //$model1=Payment::model();
        $criteria = new CDbCriteria;
        //$criteria->addCondition("site_state_name='待提交'");//考虑是否可以放入或的几种查询
        if(!empty($keywords)) 
            $criteria->condition = get_like($criteria->condition,'GF_NAME',$keywords,'');
        $criteria->order = 'GF_ID';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }//结合此处做查询

     public function actionCreditDetail($id=0,$keywords=''){//拿到当前的id
        //set_cookie('_currentUrl2_', Yii::app()->request->url);
        $model =TopScoreHistory::model();
        $criteria = new CDbCriteria;
        $id = setGetValue('id',$id);
        $criteria->condition = get_like('1','get_score_game_reson',$keywords,'');
        $criteria->addCondition("gf_id=".$id);
            
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'credit_detail', $data);
        }
    
}
