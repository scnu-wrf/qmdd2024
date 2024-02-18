<?php

    class GfSalespersonInfoController extends BaseController {
        protected $model = '';

        public function init() {
            $this->model = 'GfSalespersonInfo';
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
//毛利方案商品绑定设置
        public function actionIndex_install($keywords = '') {
            set_cookie('_currentUrl_', Yii::app()->request->url);
            $modelName = $this->model;
            $model = $modelName::model();
            $criteria = new CDbCriteria;
            $criteria->condition=get_like($criteria->condition,'f_code,f_name',$keywords,'');//get_where
            $data = array();
            parent::_list($model, $criteria, 'index_install');
        }

        public function actionCreate() {
            $modelName = $this->model;
            $model = new $modelName('create');
            $data = array();
            if(!Yii::app()->request->isPostRequest){
                $data['model'] = $model;
                $data['sharclub'] = ServicerLevel::model()->getSharing();
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
                $data['sharclub'] = ServicerLevel::model()->getSharing();
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
        GfSalespersonInfoData::model()->updateAll(array('sale_levelcode'=>'-1' ),'infoid='.$model->id);
        if($model->s_sale=='3') $this->save_s_sale_data($model->id,3);
        if($model->s_time=='6') $this->save_s_time_data($model->id,6);
        if($model->s_club=='4') $this->save_s_club_data($model->id,4);
        if($model->s_sec=='5') $this->save_s_sec_data($model->id,5);
        GfSalespersonInfoData::model()->deleteAll('infoid='.$model->id.' and sale_levelcode="-1"');
        show_status($st,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
//普通销售保存
        public function save_s_sale_data($id,$sale_typeid){
            if(!empty($_POST['member'])){
                foreach($_POST['member'] as $v){
                    if($v['sale_level']=='' || $v['sale_centa']=='' || $v['sale_show_id']==''){
                        continue;
                    }
                    $sale_centa=GfSalespersonInfoData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_level='.$v['sale_level'].' and is_member='.$v['is_member']);
                    if(empty($sale_centa)){
                        $sale_centa = new GfSalespersonInfoData();
                        $sale_centa->isNewRecord = true;
                        unset($sale_centa->id);
                    }
                    $sale_centa->infoid = $id;
                    $sale_centa->sale_typeid = $sale_typeid;
                    $sale_centa->sale_levelname = $v['sale_levelname'];
                    $sale_centa->type = $v['type'];
                    //$sale_centa->sale_typename = $v['sale_typename'];
                    $sale_centa->sale_show_id = $v['sale_show_id'];
                    $sale_centa->sale_level = $v['sale_level'];
                    $sale_centa->sale_centa = $v['sale_centa'];
                    $sale_centa->sale_centb = $v['sale_centb'];
                    $sale_centa->sale_total = $v['sale_total'];
                    $sale_centa->is_member = $v['is_member'];
                    $sale_centa->sale_levelcode = '';
                    $sale_centa->save();
                }
            }
        }
//限时抢购保存
        public function save_s_time_data($id,$sale_typeid){
            if(!empty($_POST['x_member'])){
                foreach($_POST['x_member'] as $v){
                    if($v['sale_level']=='' || $v['sale_centa']=='' || $v['sale_show_id']==''){
                        continue;
                    }
                    $sale_centa=GfSalespersonInfoData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_level='.$v['sale_level'].' and is_member='.$v['is_member']);
                    if(empty($sale_centa)){
                        $sale_centa = new GfSalespersonInfoData();
                        $sale_centa->isNewRecord = true;
                        unset($sale_centa->id);
                    }
                    $sale_centa->infoid = $id;
                    $sale_centa->sale_typeid = $sale_typeid;
                    $sale_centa->sale_levelname = $v['sale_levelname'];
                    $sale_centa->type = $v['type'];
                    //$sale_centa->sale_typename = $v['sale_typename'];
                    $sale_centa->sale_show_id = $v['sale_show_id'];
                    $sale_centa->sale_level = $v['sale_level'];
                    $sale_centa->sale_centa = $v['sale_centa'];
                    $sale_centa->sale_centb = $v['sale_centb'];
                    $sale_centa->sale_total = $v['sale_total'];
                    $sale_centa->is_member = $v['is_member'];
                    $sale_centa->sale_levelcode = '';
                    $sale_centa->save();
                }
            }
        }
//单位导购保存
        public function save_s_club_data($id,$sale_typeid){
            if(!empty($_POST['club_data'])){
                foreach($_POST['club_data'] as $v){
                    if($v['sale_level']=='' || $v['sale_centa']=='' || $v['sale_show_id']==''){
                        continue;
                    }
                    $sale_centa=GfSalespersonInfoData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_level='.$v['sale_level'].' and is_member='.$v['is_member']);
                    if(empty($sale_centa)){
                        $sale_centa = new GfSalespersonInfoData();
                        $sale_centa->isNewRecord = true;
                        unset($sale_centa->id);
                    }
                    $sale_centa->infoid = $id;
                    $sale_centa->sale_typeid = $sale_typeid;
                    $sale_centa->sale_levelname = $v['sale_levelname'];
                    $sale_centa->type = $v['type'];
                    //$sale_centa->sale_typename = $v['sale_typename'];
                    $sale_centa->sale_show_id = $v['sale_show_id'];
                    $sale_centa->sale_level = $v['sale_level'];
                    $sale_centa->sale_centa = $v['sale_centa'];
                    $sale_centa->sale_centb = $v['sale_centb'];
                    $sale_centa->sale_total = $v['sale_total'];
                    $sale_centa->is_member = $v['is_member'];
                    $sale_centa->sale_levelcode = '';
                    $sale_centa->save();
                }
            }
        }
//二次上架保存
        public function save_s_sec_data($id,$sale_typeid){
            if(!empty($_POST['dg_member'])){
                foreach($_POST['dg_member'] as $v){
                    if($v['sale_level']=='' || $v['sale_centa']=='' || $v['sale_show_id']==''){
                        continue;
                    }
                    $sale_centa=GfSalespersonInfoData::model()->find('infoid='.$id.' and sale_typeid='.$sale_typeid.' and sale_show_id='.$v['sale_show_id'].' and sale_level='.$v['sale_level'].' and is_member='.$v['is_member']);
                    if(empty($sale_centa)){
                        $sale_centa = new GfSalespersonInfoData();
                        $sale_centa->isNewRecord = true;
                        unset($sale_centa->id);
                    }
                    $sale_centa->infoid = $id;
                    $sale_centa->sale_typeid = $sale_typeid;
                    $sale_centa->sale_levelname = $v['sale_levelname'];
                    $sale_centa->type = $v['type'];
                    //$sale_centa->sale_typename = $v['sale_typename'];
                    $sale_centa->sale_show_id = $v['sale_show_id'];
                    $sale_centa->sale_level = $v['sale_level'];
                    $sale_centa->sale_centa = $v['sale_centa'];
                    $sale_centa->sale_centb = $v['sale_centb'];
                    $sale_centa->sale_total = $v['sale_total'];
                    $sale_centa->is_member = $v['is_member'];
                    $sale_centa->sale_levelcode = '';
                    $sale_centa->save();
                }
            }
        }
 
        public function actionDelete($id) {
            $modelName = $this->model;
            $model = $modelName::model();
            $count = 0;
            $le = explode(',',$id);
            foreach($le as $d){
                $model->deleteAll('id='.$d);
                GfSalespersonInfoData::model()->deleteAll('infoid='.$d);
                $count++;
            }
            if ($count > 0) {
                ajax_status(1, '删除成功');
            } else {
                ajax_status(0, '删除失败');
            }
        }
    }