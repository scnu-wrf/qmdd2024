<?php

    class MallMemberPriceInfo extends BaseModel {

        public $member = '';
        public $x_member = '';
        public $club_data = '';
        public $dg_member = '';

        public function tableName() {
            return '{{mall_member_price_info}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('sale_id', 'required', 'message' => '{attribute} 不能为空'),
                array('f_code', 'required', 'message' => '{attribute} 不能为空'),
                array('f_name', 'required', 'message' => '{attribute} 不能为空'),
                array('sale_id,f_code,f_name,f_content,sale_code,sale_name,sale_namea,sale_sourcea,sale_obja,sale_sourceb,sale_nameb,sale_objb,f_username,f_userdate,s_sale,s_club,s_sec,s_time','safe'),
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
                'sale_id' => '销售类型ID',
                'f_code' => '定价方案编码',
                'f_name' => '定价方案名称',
                'f_content' => '备注说明',
                'sale_code' => '销售类型',
                'sale_name' => '销售方式',
                'sale_namea' => '第一次销售名',
                'sale_sourcea' => '1会员，2社区，3会员购买上架,9供应商',
                'sale_obja' => '1会员，2社区，3会员购买上架,0是所有',
                'sale_sourceb' => '1会员，2社区，3会员购买上架,9供应商',
                'sale_nameb' => '第二次銷售名',
                'sale_objb' => '销售对象类型',  // 1会员，2社区，3会员购买上架,0是所有,
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