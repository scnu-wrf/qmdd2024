<?php
    class VirtualCoinExchangeSettings extends BaseModel {

        public function tableName() {
            return '{{virtual_coin_exchange_settings}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('code','required','message'=>'{attribute} 不能为空'),
                array('recharge_amount','required','message'=>'{attribute} 不能为空'),
                array('exchange_num','required','message'=>'{attribute} 不能为空'),
                array('code,recharge_amount,exchange_num,state,state_name,reasons_adminID,reasons_adminname,
                        reasons_time,reasons_failure,pricing_details_id','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                'admin_reasons_adminID' => array(self::BELONGS_TO,'QmddAdministrators','reasons_adminID'),
                'mall_pricing_details_id' => array(self::BELONGS_TO,'MallPriceSetDetails','pricing_details_id'),
            );
        }

        /**
         * 属性
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'code' => '虚拟币充值编码',
                'recharge_amount' => '充值金额',
                'exchange_num' => '兑换虚拟币数量',
                'state' => '审核状态',  // 关联base_code表STATE类型状态id：371-374',
                'state_name' => '状态名称',
                'reasons_adminID' => '操作员',  // 关联qmdd_administrators表ID',
                'reasons_adminname' => '操作员名称',
                'reasons_time' => '操作时间',
                'reasons_failure' => '未通过原因',
                'pricing_details_id' => '商品',  // 关联mall_pricing_details表set_details_id，表示手改商品规定价钱及商品代码',
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
            $this->reasons_time = get_date();
            $this->reasons_adminID = get_session('admin_id');
            $this->reasons_adminname = get_session('admin_name');
            $state = BaseCode::model()->find('f_id='.$this->state);
            if(!empty($state)){
                $this->state_name = $state->F_NAME;
            }
            return true;
        }
    }