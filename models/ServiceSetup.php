<?php

    class ServiceSetup extends BaseModel {
        public $project_list="";
        public $selectval="";
        public function tableName() {
            return '{{qmdd_administrators}}';
        }

        /**
         * 模型验证规则
         *
         */
        public function rules() {
            //$save="";
            return array(
                array('admin_gfaccount', 'required', 'message' => '{attribute} 不能为空'),
                array('lang_type', 'required', 'message' => '{attribute} 不能为空'),
                array('admin_level', 'required', 'message' => '{attribute} 不能为空'),
                array('password', 'required', 'message' => '{attribute} 不能为空'),
                array('club_id,admin_gfid,admin_gfaccount,admin_level,admin_gfnick,password,project_list,lang_type,admin_level_type,admin_level,role_name', 'safe'),
            );
        }
    // var s1=$('#Clubadmin_lang_type').find("input:checked").val();
        
        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                'qmdd_administrators_project' => array(self::HAS_MANY, 'ClubadminProject', 'qmdd_admin_id'),
            );
        }


        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'admin_gfaccount' => '账号',
                'admin_gfnick' => '姓名',
                'club_code' => '社区编码',
                'club_name' => '社区名称',
                'admin_level' => '角色',
                'lang_type' => '类型',
                'user_name' => '用户',
                'admin_gfid' => '用户账号',
                'club_id' => '单位账号',
                'password' => '登录密码',
                'pay_pass'=>'支付密码',
                'project_list'=>'服务项目',
                'last_login' => '最后登录时间',
            );
        }

        public function getOne($id) {
            return $this->find('id=' . $id);
        }

        public function getParentAll() {
            $rs = $this->findAll();
            foreach ($rs as $k => $v) {
                if (strlen($v->adv_code) != 1) {
                    unset($rs[$k]);
                }
            }
            return $rs;
        }

        /**
         * Returns the static model of the specified AR class.
         */
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }
        
        protected function afterFind() {
            parent::afterFind();

            if ($this->id != null) {
                $project = ClubadminProject::model()->findAll('qmdd_admin_id=' . $this->id);
                $arr = array();
                foreach ($project as $v) {
                    $arr[] = $v->project_id;
                }
                $this->project_list = implode(',', $arr);

            }
            
            return true;
        }

        protected function beforeSave() {
            parent::beforeSave();
            if (empty($this->dispay_num)) {
                unset($this->dispay_num);
            }
            return true;
        }

        public function getTypeCode() {
            return array( 
                array('f_id' => '0','F_NAME' => '单位'),
                array('f_id' => '1','F_NAME' => '个人'),);
        }
        
    }
