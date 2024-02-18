<?php 
    class ClubMembershipFee extends BaseModel {

        public function tableName() {
            return '{{club_membership_fee}}';
        }

        public function rules() {
            return array(
                array('name','required', 'message' => '{attribute} 不能为空'),
                array('product_name','required', 'message' => '{attribute} 不能为空'),
                array('product_code','required', 'message' => '{attribute} 不能为空'),
                array('code,name,product_id,product_code,product_name,json_attr,notepad,', 'safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                // 'mall_product_id' => array(self::BELONGS_TO,'MallProduct','product_id'),
            );
        }

        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'code' => '收费项目编号',
                'name' => '收费项目名称',
                'product_id' => '绑定商品id',  // 关联mall_product表id',
                'product_code' => '绑定商品编号',  // '1会员，2社区，3会员购买上架,0是所有',
                'product_name' => '商品名称',
                'json_attr' => '属性',  // '1会员，2社区，3会员购买上架,9供应商',
                'f_username' => '操作员',
                'f_userdate' => '修改日期',
                'notepad' => '备注'
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
            $this->f_username = Yii::app()->session['gfnick'];
            $this->f_userdate = date('Y-m-d H:i:s');
            return true;
        }

    }