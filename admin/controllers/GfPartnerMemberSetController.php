<?php

class GfPartnerMemberSetController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = 'GfPartnerMemberSet';
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }
    public function actionIndex($keywords = '' ,$type = '') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition='club_id='.get_session('club_id').' and type='.$type;
		$criteria->condition=get_like($criteria->condition,'code,title',$keywords,'');
        $criteria->order = 'id DESC';
        parent::_list($model, $criteria);
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
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
           $data = array();
           $basepath = BasePath::model()->getPath(148);
           $model->rules_description_temp=get_html($basepath->F_WWWPATH.$model->rules_description, $basepath);
           $data['model'] = $model;
           $data['attr_data'] = GfPartnerMemberInputset::model()->findAll('set_id='.$id.' and type='.$model->type);
           $this->render('update', $data);
        } else {
           $this->saveData($model,$_POST[$modelName]);
        }
    }

    function saveData($model,$post) {
        $model->attributes =$post;
        $sv=$model->save();
        // $this->save_value($model->id, $post['program_list']);
        $this->save_attr($model, $post['attr_data']);
        show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');
    }
    public function save_attr($model,$attr_data){
        $modelName = $this->model;
        if(!empty($_POST['attr_data'])){
            foreach($_POST['attr_data'] as $v){
                $attr=GfPartnerMemberInputset::model()->find('id='.$v['attr_id']);
                if(empty($attr)&&$v['attr_id']==0){
                    $attr=new GfPartnerMemberInputset();
                    $attr->isNewRecord = true;
                    unset($attr->id);
                    $attr->set_id = $model->id;
                }
                $attr->attr_name = $v['attr_name'];
                $attr->attr_unit = $v['attr_unit'];
                $attr->attr_input_type = $v['attr_input_type'];
                // $attr->is_invite = $v['is_invite'];
                $attr->type = $model->type;
                // $attr->sort_order = $v['sort_order'];
                $st=$attr->save();
                if($st==1){
                    if(!empty($v['values'])){
                        foreach($v['values'] as $v2){
                            $option=GfPartnerMemberValues::model()->find('id='.$v2['values_id']);
                            if(!isset($option)&&$v2['values_id']==0){
                                $option=new GfPartnerMemberValues();
                                $option->isNewRecord = true;
                                unset($option->id);
                            }
                            $option->set_id=$attr->set_id;
                            $option->set_input_id=$attr->id;
                            $option->attr_values=$v2['values_name'];
                            $option->attr_unit=$v['attr_unit'];
                            $option->save();
                        }
                    }
                }
            }
        }
        if(!empty($_POST[$modelName]['remove_inputset'])){
            $remove_data=explode(',', $_POST[$modelName]['remove_inputset']);
            foreach ($remove_data as $d) {
                if(!empty($d))GfPartnerMemberInputset::model()->deleteAll('id='.$d);
            }
        }
        if(!empty($_POST[$modelName]['remove_attribute'])){
            $remove_val=explode(',', $_POST[$modelName]['remove_attribute']);
            foreach ($remove_val as $r) {
                if(!empty($r))GfPartnerMemberValues::model()->deleteAll('id='.$r);
            }
        }
    }
    public function save_value($id,$program_list){
        $gf_partner=GfPartnerMemberValues::model()->findAll('set_id='.$id);
        $arr=array();
        $programs = new GfPartnerMemberValues();
        if(!empty($_POST['program_list'])){
            foreach($_POST['program_list'] as $v){
                if($v['attr_values'] == '' && $v['attr_unit'] == '' && $v['effective_date'] ==''){
                    continue;
                }
                if($v['id']=='null'){
                    $programs->isNewRecord = true;
                    unset($programs->id);
                    $programs->set_id = $id;
                    $programs->attr_values = $v['attr_values'];
                    $programs->attr_unit = $v['attr_unit'];
                    $programs->effective_date = $v['effective_date'];
                    $programs->save();
                }
                else{
                    $programs->updateByPk($v['id'],array(
                        'attr_values' => $v['attr_values'],
                        'attr_unit' => $v['attr_unit'],
                        'effective_date' => $v['effective_date']
                    ));
                    $arr[]=$v['id'];
                }
            }
        }
        if(isset($gf_partner)){
            foreach($gf_partner as $k){
                if(!in_array($k->id,$arr)){
                    GfPartnerMemberValues::model()->deleteAll('id='.$k->id);
                }
            }
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    //  选择类型模板
    public function actionTemplate($type){

        $d1 = GfPartnerMemberInputset::model()->findAll('!isNull(adminid) and type='.$type);
        $data=[];
        $num=0;
        foreach($d1 as $d){
            $data[$num]['id']=$d->id;
            $data[$num]['attr_name']=$d->attr_name;
            $data[$num]['type']=$d->type;
            $data[$num]['attr_unit']=$d->attr_unit;
            // $data[$num]['sort_order']=$d->sort_order;
            $datas=GfPartnerMemberValues::model()->findAll('set_input_id='.$d->id);
            if(!empty($datas)){
                $index=0;
                $data[$num]['datas']=[];
                foreach($datas as $v){
                    $data[$num]['datas'][$index]['id']=$v->id;
                    $data[$num]['datas'][$index]['attr_values']=$v->attr_values;
                    $index++;
                }
            }
            $num++;
        }
        if(!empty($data)){
            echo CJSON::encode($data);
        }
        
    }
    // 判断该模板是否唯一
    public function actionIs_exist($type,$club_id,$project_id){
        $count=GfPartnerMemberSet::model()->count('type='.$type.' and club_id='.$club_id.' and project_id='.$project_id);
        echo $count;
    }
}