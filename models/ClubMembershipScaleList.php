<?php 
    class ClubMembershipScaleList extends BaseModel {

        public function tableName() {
            return '{{club_membership_scale_list}}';
        }

        public function rules() {
            return array(
                array('', 'safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array();
        }

        public function attributeLabels() {
            return array();
        }

        /**
         * Returns the static model of the specified AR class.
         */
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }

        protected function beforeSave() {
            parent::beforeSave();
            $this->f_username = Yii::app()->session['gfnick'];
            $this->f_userdate = date('Y-m-d H:i:s');
            return true;
        }

    }