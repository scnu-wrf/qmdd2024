<?php

class InvoiceRequestList extends BaseModel {
	public $orderdata = '';

    public function tableName() {
        return '{{invoice_request_list}}';
    }
	public function rules() {
        return array(
        	/*
            array('order_num', 'required', 'message' => '{attribute} 不能为空'),
            array('invoice_category', 'required', 'message' => '{attribute} 不能为空'),
            array('company_personer', 'required', 'message' => '{attribute} 不能为空'),
			array('receipt_head', 'required', 'message' => '{attribute} 不能为空'),
			array('main_unit', 'required', 'message' => '{attribute} 不能为空'),
			array('invoiced_amount', 'required', 'message' => '{attribute} 不能为空'),
			array('invoice_number', 'required', 'message' => '{attribute} 不能为空'),
			*/
		   array('order_num,logistics_xh,invoiced_amount,company_personer,invoice_category,receipt_head,tax_number,registered_address,registered_phone,branch_account,bank_account,invoice_content,receipt_email,main_unit,udate,electronics_images,invoice_number,drawer_admin_id,logistics_date,receipt_state,apply_type', 'safe'), 
        );
    }

    /**
     * 模型关联规则
     */

    public function relations() {
        return array(
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'main_unit'),
			'qmdd_administrators' => array(self::BELONGS_TO, 'QmddAdministrators', 'drawer_admin_id'),
			'base_code' => array(self::BELONGS_TO, 'BaseCode', 'invoice_category'),
			'type' => array(self::BELONGS_TO, 'BaseCode', 'company_personer'),
			'state' => array(self::BELONGS_TO, 'BaseCode', 'receipt_state'),
			'orderinfo' => array(self::BELONGS_TO, 'MallSalesOrderInfo', array('order_num' => 'order_num')),
        );
    }



    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'order_num' => '订单号',
			'logistics_xh' => '发货包分单序号',
			'invoice_category'=>'发票类型',
			'company_personer'=>'开票类型',
            'receipt_head'  => '发票抬头',
			'invoiced_amount'  => '开票金额',
		    'invoice_content'  => '发票内容',
		    'receipt_email'  => '电子邮箱',
		    'udate' => '申请时间',
		    'main_unit'  => '销售商家',
		    'invoice_number'  => '发票代码/发票号',
		    'electronics_images'  => '上传电子发票',
		    'drawer_admin_id' => '开票人',
		    'logistics_date'  => '开票时间',
			'receipt_state'  => '开票状态',
			'tax_number'  => '纳税人识别号',
			'rec_address'  => '邮寄地址',
			'rec_phone'  => '联系电话',
			'zipcode'  => '邮编',
			'rec_name'  => '收件人',
			'branch_account'  => '开户银行',
			'bank_account'  => '银行账户',
			'detail'  => '发票说明',

			'registered_phone'  => '注册电话',
			'registered_address'  => '注册地址',
			'bank_account'  => '银行账户',
			'detail'  => '发票说明',
			
			'logistics_number'  => '物流单号',
			'logistics_id'  => '物流公司',
			'logistics_name'  => '物流公司',

        );
    }


	 /**
     * Returns the static model of the specified AR class.
	 模型关联返信息
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
	protected function beforeSave() {
        parent::beforeSave();
				
		if ($this->isNewRecord) {

			$this->udate = date('Y-m-d h:i:s');
        }
        
        //$this->reasons_adminid = Yii::app()->session['admin_id'];
        //$this->reasons_adminname = Yii::app()->session['gfnick'];
        //$this->uDate = date('Y-m-d h:i:s');

        return true;
	}

}
