<?php
    class VirtualMallPriceSet extends BaseModel {

        public $product = '';
        public function tableName() {
            return '{{virtual_mall_price_set}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('code','required','message'=>'{attribute} 不能为空'),
                array('name','required','message'=>'{attribute} 不能为空'),
                array('code,name,set_details_id,mall_pricing_id,add_time,uDate,is_user,
                    if_del,admin_id,admin_name,star_time,end_time','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                'base_is_user' => array(self::BELONGS_TO,'BaseCode','is_user'),
            );
        }

        /**
         * 属性
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'code' => '方案编码',
                'name' => '方案名称',
                'set_details_id' => '商品上下架数量明细数量表ID',
                'add_time' => '添加时间',
                'uDate' => '更新时间',
                'is_user' => '是否使用',
                'if_del' => '是否删除',  // 是：649，否：648',
                'admin_id' => '操作员',  // qmdd_administrators表id
                'admin_name' => '操作员',
                'star_time' => '上线时间',
                'end_time' => '下线时间',
                'club_id' => '发布单位',
                'club_name' => '发布单位名称',
                'f_check' => '审核状态',
                'mall_price_set_id' => 'mall_price_set表id',

                'add_mall' => '添加商品',
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
            if($this->isNewRecord){
                $this->add_time = get_date();
                $this->club_id = get_session('club_id');
                $this->club_name = get_session('club_name');
            }
            $this->admin_id = get_session('admin_id');
            $this->admin_name = get_session('admin_name');
            $this->uDate = get_date();
            return true;
        }
    }