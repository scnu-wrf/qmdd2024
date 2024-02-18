<?php 
    class ClubMembershipFeeScaleInfo extends BaseModel {
        public $scale_info = '';
        public $gf_id = '';
        public $gf_name = '';

        public function tableName() {
            return '{{club_membership_fee_scale_info}}';
        }

        public function rules() {
            return array(
                array('name', 'required', 'message' => '{attribute} 不能为空'),
                // array('club_id', 'required', 'message' => '{attribute} 不能为空'),
                array('scale_info_id,scale_code,code,name,feeid,fee_code,fee_name,levetypeid,levetypename,lowerleveltypeid,lowerleveltypename,product_id,
                        product_code,product_name,json_attr,scale_amount,f_username,f_userdate,date_start,date_end,
                        date_start_scale,date_end_scale,club_id,club_name,fee_type,fee_type_name,gf_id,gf_name,fee_day_id,
                        expiry_date_start,expiry_date_end,is_project_scale,use_default,entry_way', 'safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                'club_info_id' => array(self::BELONGS_TO, 'ClubMembershipFeeDataList', 'id'),
            );
        }

        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'scale_info_id' => '收费名称ID',  // club_membership_scale_info ID',
                'scale_code' => '收费项目编码',
                'code' => '收费方案编码',
                'name' => '收费方案名称',
                'remark' => '描述说明',
                'feeid' => '收费项目',
                'fee_code' => '收费项目编码',
                'fee_name' => '收费项目名称',
                'levetypeid' => '会员类型(一级)',
                'levetypename' => '会员类型(一级)',
                'lowerleveltypeid' => '会员类型(二级)',
                'lowerleveltypename' => '会员类型(二级)',
                'product_id' => '商品id',  // 关联mall_product表id',
                'product_code' => '商品编码',
                'product_name' => '商品名称',
                'json_attr' => '属性',
                'scale_amount' => '收费金额',
                'f_username' => '操作员',
                'f_userdate' => '操作时间',
                'date_start' => '网上开始缴费日期',
                'date_end' => '网上结束缴费日期',
                'date_start_scale' => '收费开始时间',  // 这个控制会员的入驻时间段',收费开始时间
                'date_end_scale' => '收费截止日期',  // 收费截止日期
                'club_id' => '收费单位',
                'club_name' => '收费单位名称',
                'fee_type' => '收费成员类型',  // BASECODE ID 404 是单位 403是个人
                'fee_day_id' => '收费有效期',
                'fee_day_name' => '收费有效期名称',
                'expiry_date_start' => '有效开始日期',
                'expiry_date_end' => '有效截止日期',
                'is_project_scale' => '按项目收费',  // 0否，1 是
                'use_default' => '默认使用',  // 0不默认，1 默认
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
            $day_id = ClubFeeDay::model()->find('id='.$this->fee_day_id);
            if(!empty($day_id)){
                $this->fee_day_name = $day_id->f_name;
            }
            return true;
        }

    }