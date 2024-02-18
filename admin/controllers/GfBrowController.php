<?php

class GfBrowController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '',$start_date='',$end_date='',$state='',$if_user='') {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->condition=get_where($criteria->condition,!empty($state),'state',$state,'');
        $criteria->condition=get_where($criteria->condition,!empty($if_user),'if_user',$if_user,'');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'add_time>=',$start_date,'"');
        $criteria->condition=get_where($criteria->condition,($start_date!=""),'add_time<=',$end_date,'"');
        $criteria->condition=get_like($criteria->condition,'gf_account,gf_name,brow_title',$keywords,'');//get_where
       $criteria->group='t.id';
        $criteria->order = 'id DESC';
        $data = array();
        $data['state'] = BaseCode::model()->getCode(370);
		$data['if_user'] = BaseCode::model()->getCode(505);
        parent::_list($model, $criteria, 'index', $data);
    }
	
	

    public function actionCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
		$old_pic1='';
        $old_pic2='';
        $old_pic3='';
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $data['gf_brow_data'] = array();
            $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
        }
    }


    public function actionUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
		$old_pic1=$model->brow_pic;
        $old_pic2=$model->brow_banner;
        $old_pic3=$model->brow_patent;
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
           $data['model'] = $model;
			if(isset($model->gf_account) && !empty($model->gf_account)) {
                $data['user'] = userlist::model()->find('GF_ACCOUNT="'.$model->gf_account.'"');
            }
           $basepath = BasePath::model()->getPath(238);
          
           $this->render('update', $data);
        } else {
            $this-> saveData($model,$_POST[$modelName]);
         }
    }
  
function saveData($model,$post) {
       $model->attributes =$post;
       $old_pic1=$model->brow_pic;
       $old_pic2=$model->brow_banner;
       $old_pic3=$model->brow_patent;
	   if ($_POST['submitType'] == 'shenhe') {
			$model->state = 371;
        } else if ($_POST['submitType'] == 'baocun') {
            $model->state = 721;
        } else if ($_POST['submitType'] == 'tongguo') {
            $model->state = 2;
        } else if ($_POST['submitType'] == 'butongguo') {
            $model->state = 373;
        } else {
            $model->state = 721;
        }
       $sv=$model->save();  
       $this->save_pics($model->id,$post['gf_brow_data']);
       
	     $this->save_gfmaterial($old_pic1,$model->brow_pic,$model->brow_title);
         $this->save_gfmaterial($old_pic2,$model->brow_banner,$model->brow_title);
         $this->save_gfmaterial($old_pic3,$model->brow_patent,$model->brow_title);
	     $logopath=BasePath::model()->getPath(238);
       show_status($sv,'保存成功', get_cookie('_currentUrl_'),'保存失败');  
 }
 
  //保存到素材管理	
public function save_gfmaterial($oldpic,$pic,$title){  
	$logopath=BasePath::model()->getPath(238);
    $gfpic=GfMaterial::model()->findAll('club_id='.get_session('club_id').' AND v_type=252 AND v_pic="'.$pic.'"');
    $gfmaterial=new GfMaterial();
	if($oldpic!=$pic){
		if(empty($gfpic)){
			$gfmaterial->isNewRecord = true;
			unset($gfmaterial->id);
			$gfmaterial->gf_type=501;
			$gfmaterial->gfid=get_session('admin_id');
			$gfmaterial->club_id=get_session('club_id');
			$gfmaterial->v_type=252;
			$gfmaterial->v_title=$title;
			$gfmaterial->v_pic=$pic;
			$gfmaterial->v_file_path=$logopath->F_WWWPATH;
			$gfmaterial->save();
		}
	}     

  }
 

    //删除
  public function actionDelete($id) {
    $modelName = $this->model;
    $model = $modelName::model();
    $club=explode(',', $id);
    $count=$model->deleteAll('id in('.$id.')');
    if(!empty($count)) {
      foreach ($club as $d) {
        GfBrowData::model()->deleteAll('brow_id='.$d);
      }
      ajax_status(1, '删除成功');
    } else {
      ajax_status(0, '删除失败');
    }
  }
  
     //////////////////////////////// 保存表情包图片//////////////////// 
  public  function save_pics($id,$gf_brow_data){
    GfBrowData::model()->updateAll(array('old_id'=>-1),'brow_id='.$id);
    $newspic = new GfBrowData();
	if (isset($_POST['gf_brow_data'])) {
        foreach ($_POST['gf_brow_data'] as $v) {
            if ($v['brow_cover_map'] == '') {
               continue;
            }		
			if ($v['id'] =='null') {
				$newspic->isNewRecord = true;
                unset($newspic->id);
			} else {
				$newspic=GfBrowData::model()->find('id='.$v['id']);
			}
            $newspic->brow_id =$id;
            $newspic->brow_cover_map =$v['brow_cover_map'];
            $newspic->brow_img =$v['brow_img'];
            $newspic->brow_img_label = $v['intro'];
            $newspic->old_id = 0;
            $newspic->save();
            
        }
    }
    GfBrowData::model()->deleteAll('brow_id='.$id.' and old_id=-1');
	 
  }

public function actionValidate($gf_account=0) {
        $user=userlist::model()->find('GF_ACCOUNT="'.$gf_account.'"');
        if(!empty($user)) {
            ajax_status_gamesign(1, $user->GF_ID, $user->ZSXM,$user->IDNAME,$user->PHONE, $user->real_sex,$user->real_sex_name,$user->real_birthday,$user->id_card_type_name,$user->id_card);
        }
        else{
            ajax_status(0, '帐号不存在');
        }
    }

   

}
