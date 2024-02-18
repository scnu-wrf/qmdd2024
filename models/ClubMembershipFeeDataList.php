<?php 
    class ClubMembershipFeeDataList extends BaseModel {

        public function tableName() {
            return '{{club_membership_fee_data_list}}';
        }

        public function rules() {
            return array(
                array('f_freememo,product_name,product_code,json_attr,levetypeid', 'safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                'base_levetypeid' => array(self::BELONGS_TO,'BaseCode','levetypeid'),
                'club_projectid' => array(self::BELONGS_TO,'ClubProject','club_project_id'),
                'qualifications_personid' => array(self::BELONGS_TO,'QualificationsPerson','qualifications_person_id'),
                'mall_sales_order_info' => array(self::BELONGS_TO,'MallSalesOrderInfo','qualifications_person_id'),
                'gf_user' => array(self::BELONGS_TO,'userlist','gf_id'),
            );
        }

        /**
         * 属性
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'scale_info_id' => '收费名称',  // club_membership_scale_info ID',
                'scale_list_Id' => 'club_membership_scale_list ID',
                'scale_data_id' => 'club_membership_fee_data的ID',
                'club_id' => '社区/会员',
                'club_name' => '社区/成员名称', //可能是社区，也可能是会员',
                'project_id' => '项目',
                'project_name' => '项目名称',
                'gf_id' => '账号',  // 社区的时候为0， 缴费会员
                'gf_name' => '姓名',  // 社区的时候为空', 缴费成员姓名
                'scale_code' => '收费项目编码',
                'fee_type' => '收费成员类型',  // BASECODE ID 404 是单位 403是个人',
                'feeid' => '收费名称id',
                'code' => '编号',
                'name' => '收费名称',
                'levetypeid' => '会员类型',
                'levelid' => '会员级别',  // 在member_card',
                'levelname' => '会员级别名称',
                'product_id' => '商品',  // 关联mall_product表id',
                'product_code' => '商品编码',
                'product_name' => '商品名称',
                'json_attr' => '属性',
                'scale_amount' => '应收金额',
                'date_start_scale' => '开始缴费日期',
                'date_end_scale' => '结束缴费日期',
                'date_scale' => '实际缴费日期',
                'scale_no' => '订单号',
                'scale_type' => '缴费类型',  // ，支付宝，微信等',
                'f_username' => '操作员',
                'f_userdate' => '申请日期',   // 修改日期 添加日期
                'f_tmpmark' => '临时删除标识',
                'f_freemark' => '免费标识',  // 0是免费，1是收费',
                'f_freememo' => '免费原因',
                'order_num' => '缴费单号',  // 关联mall_shopping_settlement表',
                'qualifications_person_id' => '收费资质人ID',  // qualifications_person表id
                'club_project_id' => '社区项目ID',  // club_project表id
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
            if($this->isNewRecord){
                $this->f_userdate = date('Y-m-d H:i:s');
            }
            return true;
        }

    }