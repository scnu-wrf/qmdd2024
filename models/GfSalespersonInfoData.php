<?php

    class GfSalespersonInfoData extends BaseModel {

        public function tableName() {
            return '{{gf_salesperson_info_data}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('infoid,sale_typeid,sale_typename,sale_obja,sale_leveltp,sale_leveltype,sale_level,sale_levelcode,sale_levelname,sale_centa,sale_centb,sale_total,sale_totaltype,f_username,f_userdate,sale_show_id','safe'),
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
                'infoid' => '價格方案ID',
                'sale_typeid' => '销售方式',
                'sale_typename' => '第一次銷售名',
                'sale_obja' => '购买人员类型',
                'sale_leveltp' => '社区注册类别，0免费，1收费',
                'sale_leveltype' => '1社区，2会员',
                'sale_level' => '會員級別',
                'sale_levelcode' => '銷售会员级别代码，方便查看',
                'sale_levelname' => '会员级别名称',
                'sale_centa' => '提成占总毛利比例，用于分类',
                'sale_centb' => '提成成员分类的比例',
                'sale_total' => '实际占总毛利比例',
                'sale_totaltype' => '毛利归属标识。总毛利余额所属，0不归，1是归属',
                'f_username' => '操作员',
                'f_userdate' => '修改日期',
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