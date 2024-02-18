<?php
    class VirtualMallProducts extends BaseModel {

        public function tableName() {
            return '{{virtual_mall_products}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('code','required','message'=>'{attribute} 不能为空'),
                array('mall_pricing_details_id,product_id,product_code,name,type_fater,supplier_id,supplier_name,add_time,admin_id,admin_nick,update,product_name','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                'base_type_fater' => array(self::BELONGS_TO,'BaseCode','type_fater'),
                'mall_pricing_id' => array(self::BELONGS_TO,'MallPricingDetails','mall_pricing_details_id'),
            );
        }

        /**
         * 属性
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'mall_pricing_details_id' => '商品价格表',  // mall_pricing_details表ID',
                'code' => '商品编号',  // （不含供应商编号）',
                'product_id' => '商品id',
                'product_code' => '商品编号',  // （含供应商编号）:供应商（10位）+商品类型码（1+2+2+2=7位）+商品名称编码（6位）+型号规格（2位）',
                'product_name' => '商品名',
                'p_code' => '商品分类统一编码',
                'type_fater' => '父级分类ID',  // 关联表base_code表order类型ID为351-369明星空间,385、503',
                'type' => '该商品所在类',  // tn_code,关联mall_products_type_sname,用户“，”隔开',
                'type_code' => '商品分类编码',
                'supplier_id' => '供应商',  // 关联club_list表id',
                'supplier_name' => '供应商名称',
                'add_time' => '商品添加时间',
                'admin_id' => '操作管理员ID',
                'admin_nick' => '操作管理员名称',
                'update' => '更新时间',
                'IS_DELETE' => '删除标记',  // 关联base_code表DATA类型 509-逻辑删除 510正常',
                'supplier_code' => '供应商商品货号',
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
            }
            $this->admin_id = get_session('admin_id');
            $this->admin_nick = get_session('admin_name');
            $this->update = get_date();
            $this->type_fater = 364;
            $this->supplier_id = get_session('club_id');
            $this->supplier_name = get_session('club_name');
            return true;
        }
    }