<?php 
    class QmddServerTimePriceData extends BaseModel {

        public function tableName() {
            return '{{qmdd_server_time_price_data}}';
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
            return array(
                'base_if_send' => array(self::BELONGS_TO, 'BaseCode', 'if_send'),
            );
        }

        /**
         * 属性标签
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'f_dcode' => '序号',
                'f_dname' => '时间段名称',
                'f_dname1' => '时间段名称1',
                'f_dname2' => '时间段名称2',
                'f_dname3' => '时间段名称3',
                'f_dname4' => '时间段名称4',
                'f_dname5' => '时间段名称5',
                'f_dname6' => '时间段名称6',
                'f_dname7' => '时间段名称7',
                'f_dname8' => '时间段名称8',
                'f_dname9' => '时间段名称9',
                'f_dname10' => '时间段名称10',
                'f_level' => '会员级别',  // 取MEMBER_CARD
                'f_levelname' => '会员级别名称',
                'f_price' => '价格',
                'f_price1' => '价格1',
                'f_price2' => '价格2',
                'f_price3' => '价格3',
                'f_price4' => '价格4',
                'f_price5' => '价格5',
                'f_price6' => '价格6',
                'f_price7' => '价格7',
                'f_price8' => '价格8',
                'f_price9' => '价格9',
                'f_price10' => '价格10',
                'info_id' => '方案id',
                'tp_code' => '方案编码',  // 时间价格编码
                'tp_name' => '方案名称',  // 时间价格方案表
                'f_uid' => '服务类型',  // 暂时用qmdd_server_usertype表
                'f_ucode' => '服务类型编码',
                'f_uname' => '服务类型名称',
                't_code' => '资源代码',
                't_name' => '资源名称',
                'project_ids' => '项目集合',
                'if_send' => '是否使用',  // 是否可以发布小时， 关联base_code表yes_no类型id 648=否，649是',
                'if_user_name' => '是否使用名称',
                'add_time' => '添加时间',
                'if_del' => '是否删除',  // 关联base_code表DATA类型 509-逻辑删除 510正常
                'uDate' => '修改时间',
            );
        }

        /**
         * Return the static model of the specified AR class.
         */
        public static function model($className = __CLASS__) {
            return parent::model($className);
        }

        protected function beforeSave() {
            parent::beforeSave();
            $this->uDate = date('Y-m-d H:i:s');
            return true;
        }

    }