<?php

class InviteCardSetController extends BaseController {

    protected $model = '';

    public function init() {
        //$this->model = 'inviteCardSet';
        //parent::init();

        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);

    }

    ///列表搜索
    public function actionIndex($keywords = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition = get_like($criteria->condition,'card_code,card_name',$keywords,'');
        $criteria->order = 'id';
        $data = array();
        parent::_list($model, $criteria, 'index', $data);
    }

    // 打赏礼物名称审核
    // public function actionIndex_exam($keywords='',$state=371) {
    //     set_cookie('_currentUrl_', Yii::app()->request->url);
    //     $modelName = $this->model;
    //     $model = $modelName::model();
    //     $criteria = new CDbCriteria;
    //     $criteria->condition = 'state='.$state;
    //     $criteria->condition = get_like($criteria->condition,'reward_code,reward_name',$keywords,'');
    //     $criteria->order = 'id';
    //     $data = array();
    //     $data['state'] = BaseCode::model()->getReturn('371,2');
    //     parent::_list($model, $criteria, 'index_exam', $data);
    // }

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['gift'] = BaseCode::model()->getCode(1393);
            //$data['programs'] = InviteCardDetail::model()->findAll('card_id=' . $model->id);
            $this->render('update', $data);
        }else{
            $this->saveData($model,$_POST[$modelName]);
        }
    }

    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        if (!Yii::app()->request->isPostRequest) {
            $data = array();
            $data['model'] = $model;
            $data['gift'] = BaseCode::model()->getCode(1393);
            $data['programs'] = InviteCardDetail::model()->findAll('card_id=' . $model->id);
            $this->render('update', $data);
        } else {
            $this->saveData($model,$_POST[$modelName]);
        }
    }/*曾老师保留部份，---结束*/

    function saveData($model,$post) {
        $model->attributes = $post;
        //$model->state = get_check_code($_POST['submitType']);

        $sv = $model->save();
        if($sv==1){

            InviteCardDetail::model()->updateAll(array('color_argb'=>'-1'),'card_id='.$model->id);//做临时删除标识

           if (isset($_POST['programs_list'])) foreach ($_POST['programs_list'] as $v)  {
               if ($v['id'] == '') {
                continue;
                }

                if ($v['id']=='null'){
                    $programs = new InviteCardDetail();
                    $programs->isNewRecord = true;
                    unset($programs->id);
                    $programs->card_id = $model->id;
                    $programs->card_code = $model->card_code;
                }else{
                    $programs=InviteCardDetail::model()->find('id='.$v['id']);
                }
                $programs->type = $v['wordType'];
                $programs->content_type = $v['content_type'];
                $programs->content = $v['content'];
                $programs->height = $v['height'];
                $programs->width = $v['width'];
                $programs->x = $v['x'];
                $programs->y = $v['y'];
                $programs->txt_align = $v['txt_align'];
                $programs->txt_size = $v['txt_size'];

                $programs->txt_typeface = $v['txt_typeface'];
                $programs->txt_typeface_path = $v['txt_typeface_path'];
                $programs->txt_style = $v['txt_style'];
                $programs->txt_typeface_familyname = $v['txt_typeface_familyname'];
                $programs->fillet_diameter = $v['fillet_diameter'];
                $programs->color_argb = $v['color_argb'];
                $sv=$programs->save();
            }

        }

        InviteCardDetail::model()->deleteAll('color_argb="-1"');

       // $this->save_programs($model->id,$post['programs_list']);
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
        //show_status('保存成功', get_cookie('_currentUrl_'),'保存失败');


    }

    public function actionDelete($id) {
        parent::_clear($id);
    }


    public function save_programs($id,$programs_list){
    }




    public function actionUse_state($id){
        $modelName = $this->model;
        $model = $this->loadModel($id,$modelName);
        $sv = $model->updateAll(array('state'=>2),'id='.$id);
        show_status($sv,'审核成功',Yii::app()->request->urlReferrer);
    }

    public function actionGetInteract($interact){
        $arr = array();
        if(!empty($interact)){
            $data = GiftType::model()->findAll('interact_type='.$interact);
            if(!empty($data))foreach($data as $key => $val){
                $arr[$key]['id'] = $val->id;
                $arr[$key]['name'] = $val->name;
            }
        }
        echo CJSON::encode($arr);
    }
}
