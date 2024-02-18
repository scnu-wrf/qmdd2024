<?php

class CooperationClubListController extends BaseController {

    protected $model = '';

    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
        //dump(Yii::app()->request->isPostRequest);
    }

    public function actionIndex($keywords = '', $project_id = 0, $state = 0) {
        set_cookie('_currentUrl_', Yii::app()->request->url);
        $modelName = $this->model;
        $model = $modelName::model();
        $criteria = new CDbCriteria;
        $criteria->with = array('club', 'invite_club');
        $criteria->condition = '(t.club_id=' . Yii::app()->session['club_id'] . ' OR t.invite_club_id=' . Yii::app()->session['club_id'] . ')';
        if ($keywords !== '') {
            $criteria->condition.=' AND (club.club_name like "%' . $keywords . '%" OR club.club_code like "%' . $keywords . '%"'
                    . ' OR invite_club.club_name like "' . $keywords . '" OR invite_club.club_code like "' . $keywords . '")';
        }

        if ($project_id > 0) {
            $criteria->condition.=' AND t.project_id=' . $project_id;
        }

        if ($state > 0) {
            $criteria->condition.=' AND t.cooperation_state=' . $state;
        }

        $criteria->order = 't.id DESC';
        $data = array();
        $data['projectlist'] = ProjectList::model()->getProject();
        $data['project'] = ClubProject::model()->findAll(array('with' => array('project_list'), 'condition' => 't.club_id='
            . Yii::app()->session['club_id'] . ' AND t.project_state=118 AND t.t.auth_state=461 AND project_list.if_del=0 or if_del=648 AND project_list.IF_VISIBLE=649 or IF_VISIBLE=1'));
        $data['base_code']=  BaseCode::model()->getCode(336);
        parent::_list($model, $criteria, 'index', $data);
    }

    // 发送联盟邀请
    public function actionSendInvite() {
        $modelName = $this->model;
        $model = $modelName::model();

        $data = array();

        $project_id = $_POST['project_id'];
        $club_id = $_POST['club_id'];
        $msg = $_POST['msg'];

        $club_list = explode(',', $club_id);
        $transaction = $model->dbConnection->beginTransaction();
        // 删除已邀请过，切状态为可以二次邀请的单位：338，499，511
        $model->deleteAll('club_id=' . Yii::app()->session['club_id'] . ' AND invite_club_id in (' . $club_id . ') AND project_id=' . $project_id . ' AND cooperation_state in (338,499,511)');
        $num = 0;
        $errors = array();
        $log = new CooperationClub;
        foreach ($club_list as $v) {
            $model->isNewRecord = true;
            unset($model->id);
            $model->club_id = Yii::app()->session['club_id'];
            $model->invite_club_id = $v;
            $model->project_id = $project_id;
            $model->cooperation_state = 498;
            if (!$model->save()) {
                if (!empty($model->getErrors())) {
                    $errors[] = $model->getErrors();
                } else {
                    $num++;
                }
            } else {
                $log->isNewRecord = true;
                unset($log->id);
                $log->club_id = Yii::app()->session['club_id'];
                $log->invite_club_id = $v;
                $log->project_id = $project_id;
                $log->join_or_del = 771;
                $log->join_reason = $msg;
                $log->join_state = 371;
                $log->save();
            }
        }

        if (empty($errors)) {
            $transaction->commit();
            $fail = '';
            if ($num > 0) {
                $fail = '，其中' . $num . '个已邀请，请勿重复操作';
            }
            ajax_status(1, '邀请发送成功' . $fail, get_cookie('_currentUrl_'));
        } else {
            $transaction->rollBack();
            ajax_status(0, '邀请发送失败');
        }
    }

    // 取消已发送的联盟邀请
    public function actionCancelInvite() {
        $modelName = $this->model;
        $model = $modelName::model();

        $transaction = $model->dbConnection->beginTransaction();
        $errors = array();
        $num = 0;
        $invite_list = explode(',', $_POST['invite_id']);
        $log = new CooperationClub;
        foreach ($invite_list as $v) {
            $invite = $model->findByPk($v);
            if ($invite != null && $invite->cooperation_state == 498 && $invite->club_id == Yii::app()->session['club_id']) {
                $invite->cooperation_state = 499;
                if ($invite->save()) {
                    $log->isNewRecord = true;
                    unset($log->id);
                    $log->club_id = Yii::app()->session['club_id'];
                    $log->invite_club_id = $invite->invite_club_id;
                    $log->project_id = $invite->project_id;
                    $log->join_or_del = 771;
                    $log->join_reason = $_POST['msg'];
                    $log->join_state = 374;
                    $log->save();
                    $num++;
                } else {
                    $errors[] = $invite->getErrors();
                }
            }
        }

        if (empty($errors)) {
            $transaction->commit();
            ajax_status(1, '撤销邀请成功，共撤销' . $num . '个', get_cookie('_currentUrl_'));
        } else {
            $transaction->rollBack();
            ajax_status(0, '撤销邀请失败');
        }
    }

    // 审核别人的联盟邀请
    public function actionPassInvite() {
        $modelName = $this->model;
        $model = $modelName::model();

        $transaction = $model->dbConnection->beginTransaction();
        $errors = array();
        $num = 0;
        $invite_list = explode(',', $_POST['invite_id']);
        $type = $_POST['type'];
        $log = new CooperationClub;
        foreach ($invite_list as $v) {
            $invite = $model->findByPk($v);
            if ($invite != null && $invite->cooperation_state == 498 && $invite->invite_club_id == Yii::app()->session['club_id']) {
                if ($type == 'yes') {
                    $invite->cooperation_state = 337;
                } else {
                    $invite->cooperation_state = 499;
                }

                if ($invite->save()) {
                    $log->isNewRecord = true;
                    unset($log->id);
                    $log->club_id = Yii::app()->session['club_id'];
                    $log->invite_club_id = $invite->club_id;
                    $log->project_id = $invite->project_id;
                    $log->join_or_del = 771;
                    $log->join_reason = $_POST['msg'];
                    if ($type == 'yes') {
                        $log->join_state = 2;
                    } else {
                        $log->join_state = 373;
                    }
                    $log->save();
                    $num++;
                } else {
                    $errors[] = $invite->getErrors();
                }
            }
        }

        if ($type == 'yes') {
            $typeText = '同意';
        } else {
            $typeText = '拒绝';
        }
        if (empty($errors)) {
            $transaction->commit();
            ajax_status(1, $typeText . '邀请成功，共' . $typeText . $num . '个', get_cookie('_currentUrl_'));
        } else {
            $transaction->rollBack();
            ajax_status(0, $typeText . '邀请失败');
        }
    }

    // 解除联盟
    public function actionDeleteInvite() {
        $modelName = $this->model;
        $model = $modelName::model();

        $transaction = $model->dbConnection->beginTransaction();
        $errors = array();
        $num = 0;
        $invite_list = explode(',', $_POST['invite_id']);
        $log = new CooperationClub;
        foreach ($invite_list as $v) {
            $invite = $model->findByPk($v);
            if ($invite != null && $invite->cooperation_state == 337 && ($invite->club_id == Yii::app()->session['club_id'] || $invite->invite_club_id == Yii::app()->session['club_id'])) {
                $invite->cooperation_state = 497;

                if ($invite->save()) {
                    $log->isNewRecord = true;
                    unset($log->id);
                    $log->club_id = Yii::app()->session['club_id'];
                    $log->invite_club_id = $invite->club_id != Yii::app()->session['club_id'] ? $invite->club_id : $invite->invite_club_id;
                    $log->project_id = $invite->project_id;
                    $log->join_or_del = 772;
                    $log->join_reason = $_POST['msg'];
                    $log->join_state = 371;
                    $log->save();
                    $num++;
                } else {
                    $errors[] = $invite->getErrors();
                }
            }
        }

        if (empty($errors)) {
            $transaction->commit();
            ajax_status(1, '解除邀请发送成功，共' . '解除' . $num . '个', get_cookie('_currentUrl_'));
        } else {
            $transaction->rollBack();
            ajax_status(0, '解除邀请发送失败');
        }
    }

    // 撤销已发送的解除联盟
    public function actionCancelDeleteInvite() {
        $modelName = $this->model;
        $model = $modelName::model();

        $transaction = $model->dbConnection->beginTransaction();
        $errors = array();
        $num = 0;
        $invite_list = explode(',', $_POST['invite_id']);
        $log = new CooperationClub;
        foreach ($invite_list as $v) {
            $invite = $model->findByPk($v);
            $last_delete_log = $invite->getLastDeleteLog();
            if ($invite != null && $invite->cooperation_state == 497 && $last_delete_log != null && $last_delete_log->club_id == Yii::app()->session['club_id'] && $last_delete_log->join_or_del == 772) {
                $invite->cooperation_state = 337;

                if ($invite->save()) {
                    $log->isNewRecord = true;
                    unset($log->id);
                    $log->club_id = Yii::app()->session['club_id'];
                    $log->invite_club_id = $invite->club_id != Yii::app()->session['club_id'] ? $invite->club_id : $invite->invite_club_id;
                    $log->project_id = $invite->project_id;
                    $log->join_or_del = 772;
                    $log->join_reason = $_POST['msg'];
                    $log->join_state = 374;
                    $log->save();
                    $num++;
                } else {
                    $errors[] = $invite->getErrors();
                }
            }
        }

        if (empty($errors)) {
            $transaction->commit();
            ajax_status(1, '撤销解除联盟成功，共' . '撤销' . $num . '个', get_cookie('_currentUrl_'));
        } else {
            $transaction->rollBack();
            ajax_status(0, '撤销解除联盟失败');
        }
    }

    // 审核别人的解除请求
    public function actionIsdelInvite() {
        $modelName = $this->model;
        $model = $modelName::model();

        $transaction = $model->dbConnection->beginTransaction();
        $errors = array();
        $num = 0;
        $invite_list = explode(',', $_POST['invite_id']);
        $type = $_POST['type'];
        $log = new CooperationClub;
        foreach ($invite_list as $v) {
            $invite = $model->findByPk($v);
            $last_delete_log = $invite->getLastDeleteLog();
            if ($invite != null && $invite->cooperation_state == 497 && $last_delete_log != null && $last_delete_log->club_id != Yii::app()->session['club_id'] && $last_delete_log->join_or_del == 772) {
                if ($type == 'yes') {
                    $invite->cooperation_state = 338;
                } else {
                    $invite->cooperation_state = 337;
                }

                if ($invite->save()) {
                    $log->isNewRecord = true;
                    unset($log->id);
                    $log->club_id = Yii::app()->session['club_id'];
                    $log->invite_club_id = $invite->club_id == Yii::app()->session['club_id'] ? $invite->invite_club_id : $invite->club_id;
                    $log->project_id = $invite->project_id;
                    $log->join_or_del = 772;
                    $log->join_reason = $_POST['msg'];
                    if ($type == 'yes') {
                        $log->join_state = 2;
                    } else {
                        $log->join_state = 373;
                    }
                    $log->save();
                    $num++;
                } else {
                    $errors[] = $invite->getErrors();
                }
            }
        }

        if ($type == 'yes') {
            $typeText = '同意';
        } else {
            $typeText = '拒绝';
        }
        if (empty($errors)) {
            $transaction->commit();
            ajax_status(1, $typeText . '解除成功，共' . $typeText . $num . '个', get_cookie('_currentUrl_'));
        } else {
            $transaction->rollBack();
            ajax_status(0, $typeText . '解除失败');
        }
    }

    public function actionInviteLog($invite_id) {
        $invite = CooperationClubList::model()->findByPk($invite_id);
        if ($invite == null) {
            exit('error');
        }
        $model = CooperationClub::model();
        $criteria = new CDbCriteria;
        $criteria->condition = '((club_id=' . $invite->club_id . ' AND invite_club_id=' . $invite->invite_club_id . ')'
                . ' OR (club_id=' . $invite->invite_club_id . ' AND invite_club_id=' . $invite->club_id . ')) AND project_id=' . $invite->project_id;
        $criteria->order = 'id DESC';
        $data = array();
        parent::_list($model, $criteria, 'log', $data);
    }

}
