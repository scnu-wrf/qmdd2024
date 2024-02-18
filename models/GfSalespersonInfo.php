<?php

    class GfSalespersonInfo extends BaseModel {

        public $gf_sale = '';
        public $member = '';
        public $x_member = '';
        public $club_data = '';
        public $dg_member = '';

        public function tableName() {
            return '{{gf_salesperson_info}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('f_code,f_name,f_content,f_username,f_userdate,s_sale,s_club,s_sec,s_time','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array();
        }

        /**
         * 属性标签
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'f_code' => '方案编码',
                'f_name' => '方案名称',
                'f_content' => '备注说明',
                'f_username' => '操作员',
                'f_userdate' => '修改日期',
                's_sale' => '普通销售',
                's_club' => '单位导购',
                's_sec' => '二次上架',
                's_time' => '限时抢购',
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
            // $this->f_username = Yii::app()->session['admin_id'];
            $this->f_username = Yii::app()->session['gfnick'];
            $this->f_userdate = date('Y-m-d H:i:s');
            return true;
        }
    }