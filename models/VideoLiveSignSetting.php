<?php
    class VideoLiveSignSetting extends BaseModel {

        public function tableName() {
            return '{{video_live_sign_setting}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('video_live_id,video_live_code,video_live_title,video_live_programs_id,
                video_live_programs_title,remarks,add_time','safe'),
            );
        }

        /**
         * 模型关联
         */
        public function relations() {
            return array(
                'videoLive_id' => array(self::BELONGS_TO,'VideoLive','video_live_id'),
            );
        }

        /**
         * 属性标签
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'video_live_id' => '直播视频ID',  // ，关联video_live表',
                'video_live_code' => '直播编号',  //  关联video_live表code',
                'video_live_title' => '直播标题',  // 关联video_live表title',
                'video_live_programs_id' => '直播节目单ID',  // 关联video_live_programs表',
                'video_live_programs_code' => '节目单号',  // 关联video_live_programs表',
                'video_live_programs_title' => '节目单名称',  // 关联video_live_programs表',
                'remarks' => '备注说明',
                'live_num' => '打赏对象数',
                'add_time' => '添加时间',
                'uDate' => '修改时间',

                'live_man' => '打赏对象',
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
                $video_live = VideoLive::model()->find('id='.$this->video_live_id);
                $programs = VideoLivePrograms::model()->find('id='.$this->video_live_programs_id);
                if(!empty($video_live)){
                    $this->video_live_code = $video_live->code;
                    $this->video_live_title = $video_live->title;
                }
                if(!empty($programs)){
                    $this->video_live_programs_code = $programs->program_code;
                    $this->video_live_programs_title = $programs->title;
                }
            }
            $this->uDate = date('Y-m-d H:i:s');
            return true;
        }
    }