<?php

    class MallProfitInfo extends BaseModel {

        public $product = '';

        public function tableName() {
            return '{{mall_profit_info}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('gf_salesperson_info_id,f_code,f_name,f_content,f_username,add_date,star_time,end_time','safe'),
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
                'gf_salesperson_info_id' => '毛利方案',
                'f_code' => '毛利方案编号',
                'f_name' => '方案名称',
                'f_content' => '备注说明',
                'f_username' => '操作员',
                'add_date' => '添加时间',
                'star_time' => '销售开始时间',
                'end_time' => '销售结束时间',
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
            $this->f_username =get_session('admin_name');
            $this->add_date = date('Y-m-d H:i:s');
            return true;
        }
    }