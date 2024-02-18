<?php
    class VideoLiveSign extends BaseModel {

        public function tableName() {
            return '{{video_live_sign}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
        array('video_live_id,video_live_programs_id,video_live_sign_setting_id,
                gf_account,gf_name,gf_zsxm,add_time,uDate,show_name,show_icon','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                // 'video_live' => array(self::BELONGS_TO,'VideoLive','video_live_id'),
            );
        }

        /**
         * 属性
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'video_live_id' => '直播id',  // 连接video_live表',
                'video_live_programs_id' => '节目单id',  // 连接 video_live_programs表',
                'video_live_sign_setting_id' => '打赏设置id',  // 连接 video_live_programs表',
                'member_type' => '对象类型',  // 210-gf会员(gf_account关联表userlist的gf_account)，502-服务机构（gf_account关联表club_list的club_code）
                'gf_account' => 'GF帐号',
                'gf_name' => '昵称',
                'gf_zsxm' => '姓名',
                'add_time' => '添加时间',
                'uDate' => '修改时间',
                'sign_delete' => '删除标记',
                'show_name' => '打赏显示名称',
                'show_icon' => '打赏显示头像',
            );
        }

        /**
         * Returns the static model of the specified AR class.
         */
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }

        protected function beforeSave() {
            parent::beforeSave();
            if($this->isNewRecord){
                $this->add_time = date('Y-m-d H:i:s');
            }
            $this->uDate = date('Y-m-d H:i:s');
            return true;
        }
    }