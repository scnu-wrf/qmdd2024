<?php

    class MallMemberPriceData extends BaseModel {
        public function tableName() {
            return '{{mall_member_price_data}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('id,infoid,sale_typeid,pd_code,sale_namea,sale_sourcena,sale_obja,sale_levela,sale_levelcodea,sale_pricea,sale_beana,sale_counta,f_delete,f_username,customer_type','safe'),
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
                'pd_id' => 'ID',
                'infoid' => '价格方案ID',
                'sale_typeid' => '销售方式',
                'pd_code' => '编号',
                'sale_namea' => '第一次销售名',
                'sale_sourcena' => '销售来源',  // 1会员，2社区，3会员购买上架,9供应商
                'sale_obja' => '购买人员类型',
                'levle_charge' => '会员注册认证交付类型',  // 1 收费，0是免费
                'sale_levela' => '會員級別',
                'sale_levelcodea' => '销售会员级别',
                'sale_levelnamea' => '第一次购买会员级别名称',
                'sale_pricea' => '价格折扣',
                'sale_beana' => '体育豆折扣',
                'sale_counta' => '最大销售数量',
             
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
            return true;
        }
    }