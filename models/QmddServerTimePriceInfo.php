<?php 
    class ServerTimePrice extends BaseModel {

        public $service_time = '';
        public $f_level = '';

        public function tableName() {
            return '{{qmdd_server_time_price_info}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('f_typeid', 'required', 'message' => '{attribute} 不能为空'),
                array('tp_name', 'required', 'message' => '{attribute} 不能为空'),
                array('club_id,club_name,tp_code,tp_name,f_typeid,f_uid,f_ucode,f_uname,t_code,t_name,project_ids,if_send,add_time,state,uDate','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                // 'base_if_send' => array(self::BELONGS_TO, 'BaseCode', 'if_send'),
            );
        }

        /**
         * 属性标签
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'club_id' => '发布单位',
                'club_name' => '单位名称',
                'tp_code' => '方案编码',  // 时间价格编码
                'tp_name' => '方案名称',  // 时间价格方案表
                'f_typeid' => '服务类型',  // 服务类型ID,qmdd_server_type的ID
                'f_uid' => '服务类型',  // 暂时用qmdd_server_usertype表
                'f_ucode' => '服务类型编码',
                'f_uname' => '服务类型名称',
                't_code' => '资源代码',
                't_name' => '服务类型名称',
                'project_ids' => '服务项目',
                'if_send' => '是否使用',  // 是否可以发布小时， 关联base_code表yes_no类型id 648=否，649是',
                'if_user_name' => '是否使用名称',
                'add_time' => '添加时间',
                'state' => '状态',  // 关联base_code表STATE类型状态id：371-374',
                'state_name' => '审核状态名',
                'uDate' => '修改时间',
            );
        }

        /**
         * Return the static model of the specified AR class.
         */
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }

        protected function beforeSave() {
            parent::beforeSave();
            if($this->isNewRecord){
                $this->add_time = date('Y-m-d H:i:s');
            }
            $this->club_id = Yii::app()->session['club_id'];
            $this->uDate = date('Y-m-d H:i:s');
            $num = date('Ymd');
            $num1= '00';  
            $code = $this->find("left(tp_code,8)='".$num."' order by tp_code DESC");
            if(!empty($code)){
                $num1=$code->tp_code;
            }
            $this->tp_code = $num.substr(''.(101+substr($num1, -2)),1,2);

            $base_state = BaseCode::model()->find('f_id='.$this->state);
            $this->state_name = $base_state->F_NAME;
            return true;
        }

    }