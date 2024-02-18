<?php

    class MallMemberPriceInfoController extends BaseController {
        protected $model = '';

        public function init() {
            $this->model = 'MallMemberPriceInfo';
            parent::init();
        }

        public function actionIndex($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition='1=1';
            $criteria->condition=get_like($criteria->condition,'f_code,f_name,sale_name',$keywords,'');//get_where
            $criteria->order = 'f_code DESC';
            $data = array();
            parent::_list($model, $criteria, 'index');
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $data['member'] = ServicerLevel::model()->getMember();
                $data['dgmember'] = ServicerLevel::model()->getDgMember();
                $data['clublevel_free'] = ServicerLevel::model()->getClubLevel(453);
                $data['clublevel_pay'] = ServicerLevel::model()->getClubLevel(454);
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
                $data['member'] = ServicerLevel::model()->getMember();
                $data['dgmember'] = ServicerLevel::model()->getDgMember();
                $data['clublevel_free'] = ServicerLevel::model()->getClubLevel(453);
                $data['clublevel_pay'] = ServicerLevel::model()->getClubLevel(454);
                $data['model']->s_sale=explode(',',$data['model']->s_sale); //把字符串打散为数组
                $data['model']->s_club=explode(',',$data['model']->s_club);
                $data['model']->s_sec=explode(',',$data['model']->s_sec);
                $data['model']->s_time=explode(',',$data['model']->s_time);
                $this->render('update', $data);
            }else{
                $this->saveData($model,$_POST[$modelName]);
            }
        }
        
    function saveData($model,$post) {
        $model->attributes = $post;
        $model->s_sale=gf_implode(',',$model->s_sale); //把数组元素组合为一个字符串
        $model->s_club=gf_implode(',',$model->s_club);
        $model->s_sec=gf_implode(',',$model->s_sec);
        $model->s_time=gf_implode(',',$model->s_time);
        $st=$model->save();
        MallMemberPriceData::model()->updateAll(array('f_delete'=>-1 ),'infoid='.$model->id);
        if($model->s_sale=='3') $this->save_s_sale_data($model->id,$model->f_code,$model->f_name,3);
        if($model->s_club=='4') $this->save_s_club_data($model->id,$model->f_code,$model->f_name,4);
        if($model->s_sec=='5') $this->save_s_sec_data($model->id,$model->f_code,$model->f_name,5);
        if($model->s_time=='6') $this->save_s_time_data($model->id,$model->f_code,$model->f_name,6);
        MallMemberPriceData::model()->deleteAll('infoid='.$model->id.' and f_delete=-1');
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
    //自营商家-普通销售
    public function save_s_sale_data($id,$pcode,$pname,$sale_typeid){
        if(!empty($_POST['member'])) foreach($_POST['member'] as $v){
            if($v['sale_levela']=='' || $v['sale_pricea']=='' || $v['sale_show_id']==''){
                continue;
            }
            $sale_price=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_levela='.$v['sale_levela']);
            if(empty($sale_price)){
                $sale_price = new MallMemberPriceData();
                $sale_price->isNewRecord = true;
                unset($sale_price->id);
            }
            $sale_price->infoid = $id;
            $sale_price->f_delete = 0;
            //$sale_price->sale_levela_no = $v['sale_levela_no'];
            $sale_price->sale_levela = $v['sale_levela'];
            $sale_price->sale_typeid = $sale_typeid;
            $sale_price->sale_pricea = $v['sale_pricea'];
            $sale_price->sale_beana = $v['sale_beana'];
            $sale_price->sale_counta = $v['sale_counta'];
            $sale_price->sale_sourcena = $v['sale_sourcena'];
            //$saletype=MallMemberSaleType::model()->find('sale_sourcen='.$v['sale_sourcena'].' and sale_obj='.$v['sale_obja']);
            $sale_price->sale_show_id = $v['sale_show_id'];
            $sale_price->sale_obja = $v['sale_obja'];
            $sale_price->customer_type = $v['type'];
            $sale_price->pd_code = $pcode;
            $sale_price->sale_namea =$pname;
            $sale_price->save();
        }
    }

    //自营商家-单位导购-普通销售
    public function save_s_club_data($id,$pcode,$pname,$sale_typeid){
        if(!empty($_POST['club_data'])) foreach($_POST['club_data'] as $v){
            if($v['sale_levela']=='' || $v['sale_pricea']=='' || $v['sale_show_id']==''){
                continue;
            }
            $sale_price=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_levela='.$v['sale_levela']);
            if(empty($sale_price)){
                $sale_price = new MallMemberPriceData();
                $sale_price->isNewRecord = true;
                unset($sale_price->id);
            }
            $sale_price->infoid = $id;
            $sale_price->f_delete = 0;
            $sale_price->sale_levela = $v['sale_levela'];
            $sale_price->sale_typeid = $sale_typeid;
            $sale_price->sale_pricea = $v['sale_pricea'];
            $sale_price->sale_beana = $v['sale_beana'];
            $sale_price->sale_counta = $v['sale_counta'];
            $sale_price->sale_sourcena = $v['sale_sourcena'];
            $sale_price->sale_show_id = $v['sale_show_id'];
            $sale_price->sale_obja = $v['sale_obja'];
            $sale_price->customer_type = $v['type'];
            $sale_price->pd_code = $pcode;
            $sale_price->sale_namea =$pname;
            $sale_price->save();
        }
    }

    //自营商家-二次上架-普通销售
    public function save_s_sec_data($id,$pcode,$pname,$sale_typeid){
        if(!empty($_POST['dg_member'])) foreach($_POST['dg_member'] as $v){
            if($v['sale_levela']=='' || $v['sale_pricea']=='' || $v['sale_show_id']==''){
                continue;
            }
            $sale_price=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_levela='.$v['sale_levela']);
            if(empty($sale_price)){
                $sale_price = new MallMemberPriceData();
                $sale_price->isNewRecord = true;
                unset($sale_price->id);
            }
            $sale_price->infoid = $id;
            $sale_price->f_delete = 0;
            $sale_price->sale_levela = $v['sale_levela'];
            $sale_price->sale_typeid = $sale_typeid;
            $sale_price->sale_pricea = $v['sale_pricea'];
            $sale_price->sale_beana = $v['sale_beana'];
            $sale_price->sale_counta = $v['sale_counta'];
            $sale_price->sale_sourcena = $v['sale_sourcena'];
            $sale_price->sale_show_id = $v['sale_show_id'];
            $sale_price->sale_obja = $v['sale_obja'];
            $sale_price->customer_type = $v['type'];
            $sale_price->pd_code = $pcode;
            $sale_price->sale_namea =$pname;
            $sale_price->save();
        }
    }
    //自营商家-限时抢购
    public function save_s_time_data($id,$pcode,$pname,$sale_typeid){
        if(!empty($_POST['x_member'])) foreach($_POST['x_member'] as $v){
            if($v['sale_levela']=='' || $v['sale_pricea']=='' || $v['sale_show_id']==''){
                continue;
            }
            $sale_price=MallMemberPriceData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_levela='.$v['sale_levela']);
            if(empty($sale_price)){
                $sale_price = new MallMemberPriceData();
                $sale_price->isNewRecord = true;
                unset($sale_price->id);
            }
            $sale_price->infoid = $id;
            $sale_price->f_delete = 0;
            $sale_price->sale_levela = $v['sale_levela'];
            $sale_price->sale_typeid = $sale_typeid;
            $sale_price->sale_pricea = $v['sale_pricea'];
            $sale_price->sale_beana = $v['sale_beana'];
            $sale_price->sale_counta = $v['sale_counta'];
            $sale_price->sale_sourcena = $v['sale_sourcena'];
            $sale_price->sale_show_id = $v['sale_show_id'];
            $sale_price->sale_obja = $v['sale_obja'];
            $sale_price->customer_type = $v['type'];
            $sale_price->pd_code = $pcode;
            $sale_price->sale_namea =$pname;
            $sale_price->save();
        }
    }
        public function actionDelete($id) {
            $modelName = $this->model;
            $model = $modelName::model();
            $count = $model->deleteAll('id='.$id);
            if ($count > 0) {
                MallMemberPriceData::model()->deleteAll('infoid='.$id);
                ajax_status(1, '删除成功');
            } else {
                ajax_status(0, '删除失败');
            }
        }
}