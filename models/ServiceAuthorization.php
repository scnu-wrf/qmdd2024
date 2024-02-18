<?php
    class ServiceAuthorization extends BaseModel{
        public function tableName(){
            return '{{qmdd_service_authorization}}';
        }

        /**
         * 模型验证规则
         */
        public function rules(){
            return array(
                array('service_type','required','message'=>'{attribute} 不能为空'),
                array('authorized_person_id','required','message'=>'{attribute} 不能为空'),
                array('club_id,club_name,service_type,service_type_name,authorization_man_id,authorized_person_id,time,uDate','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations(){
            return array();
        }

        /**
         * 属性标签
         */
        public function attributeLabels(){
            return array(
                'id' => 'ID',
                'club_id' => '发布单位',
                'club_name' => '发布单位名称',
                'service_type' => '授权签到类型',  // 动动约类型,qmdd_server_type表id
                'service_type_name' => '动动约类型名称',
                'authorization_man_id' => '授权人',  // 授权人gfid 单位授权为club_list表id，单位管理员为gfid
                'authorized_person_id' => '被授权人',  // 被授权人gfid 用“,”隔开
                'time' => '授权时间',
                'uDate' => '更新时间',

                // 添加字段
                'authorization_account' => '被授权人',
                'service_name' => '姓名',
            );
        }

        /**
         * Return the static model of the specified AR class.
         * 授权表
         */
        public static function model($className = __CLASS__){
            return parent::model($className);
        }

        protected function beforeSave(){
            parent::beforeSave();
            if($this->isNewRecord){
                $this->time = date('Y-m-d H:i:s');
            }
            $this->uDate = date('Y-m-d H:i:s');
            return true;
        }
    }