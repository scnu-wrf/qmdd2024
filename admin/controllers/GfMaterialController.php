<?php

class GfMaterialController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionPic($group_id = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		//$criteria->condition=get_where_club_project('club_id','');
        $criteria->condition= 'club_id='.get_session('club_id').' AND v_type=252 and gf_type=501';
        if ($group_id == -1) {
            $criteria->condition.=' AND (group_id is null OR group_id="" OR group_id=0)';
        } else if ($group_id != 0) {
            $criteria->condition.=' AND group_id=' . $group_id;
        }
        $criteria->order = 'id DESC';
        $data = array();
        $data['material_group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=252');
        $data['all_num'] = $model->count('v_type=252 AND club_id='.get_session('club_id'));
        $data['nogroup_num'] = $model->count('v_type=252 AND club_id='.get_session('club_id').' AND (group_id is null OR group_id="" OR group_id=0)');
        $data['group_id'] = $group_id;
        parent::_list($model, $criteria, 'pic', $data);
    }
	
	public function actiondoc($group_id = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		//$criteria->condition=get_where_club_project('club_id','');
        $criteria->condition= 'club_id='.get_session('club_id').' AND v_type=779 and gf_type=501';
        if ($group_id == -1) {
            $criteria->condition.=' AND (group_id is null OR group_id="" OR group_id=0)';
        } else if ($group_id != 0) {
            $criteria->condition.=' AND group_id=' . $group_id;
        }
        $criteria->order = 'id DESC';
        $data = array();
        $data['material_group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=779');
        $data['all_num'] = $model->count('v_type=779 AND club_id='.get_session('club_id'));
        $data['nogroup_num'] = $model->count('v_type=779 AND club_id='.get_session('club_id').' AND (group_id is null OR group_id="" OR group_id=0)');
        $data['group_id'] = $group_id;
        parent::_list($model, $criteria, 'doc', $data);
    }

    public function actionVideo($group_id = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		//$criteria->condition=get_where_club_project('club_id','');
        $criteria->condition= 'club_id='.get_session('club_id').' AND v_type=253 and gf_type=501';
        if ($group_id == -1) {
            $criteria->condition.=' AND (group_id is null OR group_id="" OR group_id=0)';
        } else if ($group_id != 0) {
            $criteria->condition.=' AND group_id=' . $group_id;
        }
        $criteria->order = 'id DESC';
		
        $data = array();
        $data['material_group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=253');
        $data['all_num'] = $model->count('v_type=253 AND club_id='.get_session('club_id'));
        $data['nogroup_num'] = $model->count('v_type=253 AND club_id='.get_session('club_id').' AND (group_id is null OR group_id="" OR group_id=0)');
        $data['group_id'] = $group_id;
        parent::_list($model, $criteria, 'video', $data);
    }

    public function actionAudio($group_id = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
		//$criteria->condition=get_where_club_project('club_id','');
        $criteria->condition= 'club_id='.get_session('club_id').' AND v_type=254 and gf_type=501';
        if ($group_id == -1) {
            $criteria->condition.=' AND (group_id is null OR group_id="" OR group_id=0)';
        } else if ($group_id != 0) {
            $criteria->condition.=' AND group_id=' . $group_id;
        }
        $criteria->order = 'id DESC';
        $data = array();
        $data['material_group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=254');
        $data['all_num'] = $model->count('v_type=254 AND club_id='.get_session('club_id'));
        $data['nogroup_num'] = $model->count('v_type=254 AND club_id='.get_session('club_id').' AND (group_id is null OR group_id="" OR group_id=0)');
        $data['group_id'] = $group_id;
        parent::_list($model, $criteria, 'audio', $data);
    }

    public function actionUppic($group_id = 0) {
        if (!isset($_FILES['Filedata'])) {
            ajax_exit(array('status' => 0, 'msg' => '图片大小超过限制,最大支持' + ini_get('post_max_size')));
        }
        $attach = CUploadedFile::getInstanceByName('Filedata');
        if (!in_array($attach->extensionName, array('jpg', 'gif', 'png'))) {
            ajax_exit(array('status' => 0, 'msg' => '图片文件类型错误，仅支持JPG、GIF、PNG格式图片'));
        }
        $basepath = BasePath::model()->getPath(177);
        if ($basepath == null) {
            ajax_exit(array('status' => 0, 'msg' => '系统BASE_PATH路径无法找到,请稍后再试'));
        }
        $prefix = $basepath->F_CODENAME;
        $savepath = $basepath->F_PATH;
        $datePath = date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if ($prefix != '') {
            $prefix.='_';
        }
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
        $json_rs = file_get_contents(Yii::app()->params['uploadUrl'] . '?fileCode=' . $prefix . '_&fileType=' . $attach->extensionName, false, $file);
        $rs = json_decode($json_rs, true);
        if ($rs['code'] == 0) {
            $modelName = $this->model;
            $model = new $modelName;
            if ($group_id > 0) {
                $model->group_id = $group_id;
            }
            $model->v_type = 252;
			$model->club_id = get_session('club_id');
            $model->v_title = get_basename($attach->name);
            $model->v_pic = $rs['filename'];
            $model->v_name = $rs['filename'];
            $model->v_file_md5 = md5_file($rs['fileUrl'] . '/' . $rs['filename']);
            $model->v_file_path = $rs['fileUrl'] . '/';
            $model->v_file_size = size($attach->size);
            $model->v_file_zt = 1;
            $model->save();
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $rs['fileUrl'] . '/' . $rs['filename'], 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
        }

    }

    public function actionUpvideo($group_id = 0) {
        if (!isset($_FILES['Filedata'])) {
            ajax_exit(array('status' => 0, 'msg' => '视频大小超过限制,最大支持'+ini_get('post_max_size')));
        }
        $attach = CUploadedFile::getInstanceByName('Filedata');
        if (!in_array($attach->extensionName, array('mp4'))) {
            ajax_exit(array('status' => 0, 'msg' => '视频文件类型错误,仅支持MP4格式'));
        }
        $basepath = BasePath::model()->getPath(177);
        if ($basepath == null) {
            ajax_exit(array('status' => 0, 'msg' => '系统BASE_PATH路径无法找到,请稍后再试'));
        }
        $prefix = $basepath->F_CODENAME;
        $savepath = $basepath->F_PATH;
        $datePath = date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if ($prefix != '') {
            $prefix.='_';
        }
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
        $json_rs = file_get_contents(Yii::app()->params['uploadUrl'] . '?fileCode=' . $prefix . '_&fileType=' . $attach->extensionName, false, $file);
        $rs = json_decode($json_rs, true);
        if ($rs['code'] == 0) {
            $modelName = $this->model;
            $model = new $modelName;
            if ($group_id > 0) {
                $model->group_id = $group_id;
            }
            $model->v_type = 253;
            $model->v_title = get_basename($attach->name);
            $model->v_name = $rs['filename'];
            $model->v_file_md5 = md5_file($rs['fileUrl'] . '/' . $rs['filename']);
            $model->v_file_path = $rs['fileUrl'] . '/';
            $model->v_file_size = size($attach->size);
            $model->v_file_zt = 1;
            $model->save();
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $rs['fileUrl'] . '/' . $rs['filename'], 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id, 'duration' => $model->v_file_insert_size, 'date' => substr($model->v_file_time, 0, -9)));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
        }
        /////////////////////////////////////////////////////////////////////////////
//        if (!is_dir($savepath . $datePath)) {
//            mk_dir($savepath . $datePath);
//        }
//
//        $fileName = $datePath . $prefix . uniqid('', true) . '.' . $attach->extensionName;
//
//        if ($attach->saveAs($savepath . $fileName)) {
//            $modelName = $this->model;
//            $model = new $modelName;
//            if ($group_id > 0) {
//                $model->group_id = $group_id;
//            }
//            $model->v_type = 253;
//            $model->v_title = get_basename($attach->name);
//            $model->v_name = $fileName;
//            $model->v_file_md5 = md5_file($savepath . $fileName);
//            $model->v_file_path = $basepath->F_WWWPATH;
//            $model->v_file_size = size($attach->size);
//            $model->v_file_zt = 1;
//            $model->save();
//            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $basepath->F_WWWPATH . $fileName, 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id, 'duration' => $model->v_file_insert_size, 'date' => substr($model->v_file_time, 0, -9)));
//        } else {
//            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
//        }
    }
	
	public function actionSaveMaterial($group_id = 0) {
		$v_title=$_POST['v_title'];
		$v_type=empty($_POST['v_type'])?253:$_POST['v_type'];
		$v_name=$_POST['v_name'];
		$v_file_path=$_POST['v_file_path'];
		$res = get_headers($v_file_path . $v_name,true);
		$v_file_size=round($res['Content-Length']/1024/1024,2).'M';
		$file_format=pathinfo( parse_url($v_file_path . $v_name)['path'] )['extension'];
		$v_file_insert_size=$_POST['v_file_insert_size'];
		$modelName = $this->model;
		$model = new $modelName;
		if ($group_id > 0) {
			$model->group_id = $group_id;
		}
		$model->v_type = $v_type;
		$model->v_title = $v_title;
		$model->v_name = $v_name;
		$model->v_file_path = $v_file_path;
		$model->v_file_size = $v_file_size;
		$model->v_file_insert_size = $v_file_insert_size;
		$model->v_file_zt = 1;
		$model->save();
		ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $v_file_path . $v_name, 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id, 'duration' => $model->v_file_insert_size, 'file_size' => $model->v_file_size, 'file_format' => $file_format, 'date' => substr($model->v_file_time, 0, -9)));
	}
	

    public function actionUpaudio($group_id = 0) {
        if (!isset($_FILES['Filedata'])) {
            ajax_exit(array('status' => 0, 'msg' => '音频大小超过限制,最大支持'+ini_get('post_max_size')));
        }
        $attach = CUploadedFile::getInstanceByName('Filedata');
        if (!in_array($attach->extensionName, array('mp3', 'wma', 'wav', 'amr'))) {
            ajax_exit(array('status' => 0, 'msg' => '音频文件类型错误'));
        }
        $basepath = BasePath::model()->getPath(177);
        if ($basepath == null) {
            ajax_exit(array('status' => 0, 'msg' => '系统BASE_PATH路径无法找到,请稍后再试'));
        }
        $prefix = $basepath->F_CODENAME;
        $savepath = $basepath->F_PATH;
        $datePath = date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if ($prefix != '') {
            $prefix.='_';
        }
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
        $json_rs = file_get_contents(Yii::app()->params['uploadUrl'] . '?fileCode=' . $prefix . '_&fileType=' . $attach->extensionName, false, $file);
        $rs = json_decode($json_rs, true);
        if ($rs['code'] == 0) {
            $modelName = $this->model;
            $model = new $modelName;
            if ($group_id > 0) {
                $model->group_id = $group_id;
            }
            $model->v_type = 254;
            $model->v_title = get_basename($attach->name);
            $model->v_name = $rs['filename'];
            $model->v_file_md5 = md5_file($rs['fileUrl'] . '/' . $rs['filename']);
            $model->v_file_path = $rs['fileUrl'] . '/';
            $model->v_file_size = size($attach->size);
            $model->v_file_zt = 1;
            $model->save();
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $rs['fileUrl'] . '/' . $rs['filename'], 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id, 'duration' => $model->v_file_insert_size, 'date' => substr($model->v_file_time, 0, -9)));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
        }
        /////////////////////////////////////////////////////////////////////////////
//        if (!is_dir($savepath . $datePath)) {
//            mk_dir($savepath . $datePath);
//        }
//
//        $fileName = $datePath . $prefix . uniqid('', true) . '.' . $attach->extensionName;
//
//        if ($attach->saveAs($savepath . $fileName)) {
//            $modelName = $this->model;
//            $model = new $modelName;
//            if ($group_id > 0) {
//                $model->group_id = $group_id;
//            }
//            $model->v_type = 254;
//            $model->v_title = get_basename($attach->name);
//            $model->v_name = $fileName;
//            $model->v_file_md5 = md5_file($savepath . $fileName);
//            $model->v_file_path = $basepath->F_WWWPATH;
//            $model->v_file_size = size($attach->size);
//            $model->v_file_zt = 1;
//            $model->save();
//            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $basepath->F_WWWPATH . $fileName, 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id, 'duration' => $model->v_file_insert_size, 'date' => substr($model->v_file_time, 0, -9)));
//        } else {
//            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
//        }
    }
	
	public function actionUpdoc($group_id = 0) {
        if (!isset($_FILES['Filedata'])) {
            ajax_exit(array('status' => 0, 'msg' => '文件大小超过限制,最大支持' + ini_get('post_max_size')));
        }
        $attach = CUploadedFile::getInstanceByName('Filedata');
        if (!in_array($attach->extensionName, array('txt', 'doc','docx'))) {
            ajax_exit(array('status' => 0, 'msg' => '文件文件类型错误，仅支持TXT、DOC格式文件'));
        }
        $basepath = BasePath::model()->getPath(177);
        if ($basepath == null) {
            ajax_exit(array('status' => 0, 'msg' => '系统BASE_PATH路径无法找到,请稍后再试'));
        }
        $prefix = $basepath->F_CODENAME;
        $savepath = $basepath->F_PATH;
        $datePath = date('Y') . '/' . date('m') . '/' . date('d') . '/';

        if ($prefix != '') {
            $prefix.='_';
        }
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
        $json_rs = file_get_contents(Yii::app()->params['uploadUrl'] . '?fileCode=' . $prefix . '_&fileType=' . $attach->extensionName, false, $file);
        $rs = json_decode($json_rs, true);
        if ($rs['code'] == 0) {
            $modelName = $this->model;
            $model = new $modelName;
            if ($group_id > 0) {
                $model->group_id = $group_id;
            }
            $model->v_type = 779;
            $model->v_title = get_basename($attach->name);
            $model->v_pic = $rs['filename'];
            $model->v_name = $rs['filename'];
            $model->v_file_md5 = md5_file($rs['fileUrl'] . '/' . $rs['filename']);
            $model->v_file_path = $rs['fileUrl'] . '/';
            $model->v_file_size = size($attach->size);
            $model->v_file_zt = 1;
            $model->save();
            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $rs['fileUrl'] . '/' . $rs['filename'], 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
        }
		/////////////////////////////////////////////////////////////////////////////
//        if (!is_dir($savepath . $datePath)) {
//            mk_dir($savepath . $datePath);
//        }
//
//        $fileName = $datePath . $prefix . uniqid('', true) . '.' . $attach->extensionName;
//
//        if ($attach->saveAs($savepath . $fileName)) {
//            $modelName = $this->model;
//            $model = new $modelName;
//            if ($group_id > 0) {
//                $model->group_id = $group_id;
//            }
//            $model->v_type = 254;
//            $model->v_title = get_basename($attach->name);
//            $model->v_name = $fileName;
//            $model->v_file_md5 = md5_file($savepath . $fileName);
//            $model->v_file_path = $basepath->F_WWWPATH;
//            $model->v_file_size = size($attach->size);
//            $model->v_file_zt = 1;
//            $model->save();
//            ajax_exit(array('status' => 1, 'msg' => '上传成功', 'allpath' => $basepath->F_WWWPATH . $fileName, 'name' => $model->v_name, 'title' => $model->v_title, 'id' => $model->id, 'group_id' => $model->group_id, 'duration' => $model->v_file_insert_size, 'date' => substr($model->v_file_time, 0, -9)));
//        } else {
//            ajax_exit(array('status' => 0, 'msg' => '上传失败'));
//        }
    }

    public function actionChangeTitle() {
        $modelName = $this->model;
        $model = $modelName::model();
        $id = intval($_POST['id']);
        $count = $model->updateByPk($id, array('v_title' => $_POST['title']));
        if ($count > 0) {
            ajax_exit(array('status' => 1, 'msg' => '更新成功'));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '更新失败'));
        }
    }

    public function actionAddGroup($m_type) {
        $modelName = 'GfMaterialGroup';
        $model = $modelName::model();
        $name = $_POST['name'];
        $rs = $model->find('group_name="' . $name . '"');
        if ($rs != null) {
            ajax_exit(array('status' => 0, 'msg' => '分组已存在，请勿重复添加'));
        } else {
            $model = new $modelName;
            $model->group_name = $name;
			$model->club_id = get_session('club_id');
			$model->v_type = $m_type;
            if ($model->save()) {
                ajax_exit(array('status' => 1, 'msg' => '分组添加成功', 'id' => $model->id));
            }
        }
    }
	//删除分组
	public function actionDeleteGroup() {
        $modelName = 'GfMaterialGroup';
        $model = $modelName::model();
        $group_id = $_POST['group_id'];
		GfMaterial::model()->update('group_id='.$group_id,array('group_id'=>''));
		$count=$model->deleteAll('id='.$group_id);
        if ($count>0) {
            ajax_exit(array('status' => 1, 'msg' => '分组已删除'));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '删除分组失败'));
        }
    }

    public function actionGetGroup($m_type) {
        $modelName = 'GfMaterialGroup';
        $model = $modelName::model();
        $rs = $model->findAll('club_id='.get_session('club_id').' AND v_type='.$m_type);
        $str = '';
        foreach ($rs as $v) {
            $str.='<option value="' . $v->id . '">' . $v->group_name . '</option>';
        }
        echo $str;
    }

    public function actionChangeGroup() {
        $modelName = $this->model;
        $model = $modelName::model();
        $group_id = intval($_POST['group_id']);
        $count = $model->updateAll(array('group_id' => $group_id), 'id in (' . $_POST['changeGroupId'] . ')');
        if ($count > 0) {
            ajax_exit(array('status' => 1, 'msg' => '移动分组成功'));
        } else {
            ajax_exit(array('status' => 0, 'msg' => '移动分组失败'));
        }
    }

    public function actionDelete($id) {
        //ajax_status(1, '删除成功');
        parent::_clear($id);
    }

    public function actionVideoCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();

        $model->v_type = 253;

        if (!Yii::app()->request->isPostRequest) {
            $data['group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=253');
        }

        parent::_create($model, 'videoCreate', $data, get_cookie('_currentUrl_'));
    }

    public function actionVideoUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=253');
        }
        parent::_update($model, 'videoUpdate', $data, get_cookie('_currentUrl_'));
    }
	
	public function actionDocCreate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();

        $model->v_type = 779;

        if (!Yii::app()->request->isPostRequest) {
            $data['group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=779');
        }

        parent::_create($model, 'docCreate', $data, get_cookie('_currentUrl_'));
    }

    public function actionDocUpdate($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=779');
        }
        parent::_update($model, 'docUpdate', $data, get_cookie('_currentUrl_'));
    }




   public function actionPicUpdate() {
        $modelName = $this->model;
        $model = new $modelName('create');
        $data = array();

        $model->v_type = 252;

        if (!Yii::app()->request->isPostRequest) {
            $data['group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=252');
            parent::_create($model, 'picUpdate', $data, get_cookie('_currentUrl_'));
        }else{

            $model->attributes = $_POST[$modelName];
            $model->v_name=$model->v_pic;
            $st=$model->save();
            $s1= get_cookie('_currentUrl_');
            $s2=indexof($s1,'?r=');
            if($s2>=0){
                $s1=substr($s1,0,$s2).'?r=select/materialPicture&type=252';
            }
            show_status($st,'保存成功',$s1,'保存失败');
            // $this->redirect(array('select/materialPicture','type'=>252));
        }

    }
	//视频播放
	public function actionVideo_player($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();
        if (!Yii::app()->request->isPostRequest) {
            $data['model'] = $model;
            $this->render('video_player', $data);
        } else {
            //$this->saveData($model,$_POST[$modelName]);
        }
    }



    public function actionCropPicture($id) {
        $modelName = $this->model;
        $model = $this->loadModel($id, $modelName);
        $data = array();

        parent::_update($model, 'cropPicture', $data, get_cookie('_currentUrl_'));
    }



    public function actionMaterialPictureAll($group_id = 0,$keywords = '',$club_id = 0) {
        // 252图片 253视频 254音频    

        $data = array();
        $model = GfMaterial::model();
        $criteria = new CDbCriteria;
        //$criteria->condition = ($club_id==0) ? '1' : 'club_id='.$club_id;
		$criteria->condition ='club_id='.get_session('club_id');
        $criteria->select = '*,id as select_id,v_title as select_title,v_name as select_code';

        $criteria->condition.=' AND v_type=252';

        if ($keywords != '' and $keywords!='请输入标题关键字搜索') {
            $criteria->condition .= ' AND v_title like "%' . $keywords . '%"';
        }

        if ($group_id == -1) {
            $criteria->condition.=' AND (group_id is null OR group_id="" OR group_id=0)';
        } else if ($group_id != 0) {
            $criteria->condition.=' AND group_id=' . $group_id;
        }

        $criteria->order = 'id DESC';
        $data = array();
        $data['material_group'] = GfMaterialGroup::model()->findAll('club_id='.get_session('club_id').' AND v_type=252');
        $data['all_num'] = $model->count('club_id='.get_session('club_id').' AND v_type=252');
        $data['nogroup_num'] = $model->count('v_type=252 AND (group_id is null OR group_id="" OR group_id=0)');
        $data['group_id'] = $group_id;

        parent::_list($model, $criteria, 'materialPictureAll', $data,$pageSize = 10);
    }


}
