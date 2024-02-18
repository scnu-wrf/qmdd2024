<?php
    class VirtualMallPriceSetDetails extends BaseModel {

        public function tableName() {
            return '{{virtual_mall_price_set_details}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array();
        }

        /**
         * 属性
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'set_id' => '方案表id',  // 关联virtual_mall_price_set表ID',
                'set_code' => '上架单号',
                'set_name' => '上架方案名称',
                'pricing_type' => '订单类型',  // 364- 关联表base_code表order类型ID为351-369明星空间,385、503',
                'no' => '序号',
                'product_id' => '商品id',  // 关联mall_product表id',
                'product_code' => '商品编码',
                'product_name' => '商品名称',
                'Inventory_quantity' => '上架数量,下架单的时候表示下架数量',
                'available_quantity' => '销售数量',
                'shopping_price' => '销售价',
                'if_dispay' => '是否下架',  // 关联base_code表yes_no类型id 648=否，649是',
                'u_date' => '添加时间',
                'star_time' => '上线时间',
                'end_time' => '下线时间',
                'f_check' => '审核状态',  // 关联base_code表ID371-374 721'',',
                'f_check_name' => '审核状态',  // 关联base_code表ID371审核中 2审核通过 373审核未通过 374撤销 721编辑中'',',
                'mall_pricing_details_id' => '商品价格表 set_details_id',
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
                $this->u_date = get_date();
            }
            return true;
        }
    }