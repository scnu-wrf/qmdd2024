<?php
    class GfSecretKey extends BaseModel {

        public function tableName(){
            return '{{gf_secret_key}}';
        }

        /**
         * 模型验证规则
         */
        public function rules(){
            return array(
                array('','safe'),
            );
        }

        public function relations(){
            return array(
                // 'base_code' => array(self::BLONGS_TO,'BaseCode','');
            );
        }

        public function attributeLabels(){
            return array(
                'id' => 'ID',
            );
        }

        public static function model($className = __CLASS__){
            return parent::model($className);
        }

        protected function beforeSave(){
            parent::beforeSave();
            return true;
        }
    }