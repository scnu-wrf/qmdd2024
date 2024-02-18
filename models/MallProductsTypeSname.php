<?php

class MallProductsTypeSname extends BaseModel {
	
	public $project_list = '';
    public function tableName() {
        return '{{mall_products_type_sname}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('sn_name', 'required', 'message' => '{attribute} 不能为空'),
            array('tn_code', 'required', 'message' => '{attribute} 不能为空'),
			/*
		    array('project_list', 'required', 'message' => '{attribute} 不能为空'),
            array('tn_image', 'required', 'message' => '{attribute} 不能为空'),
			array('tn_click_icon', 'required', 'message' => '{attribute} 不能为空'),
			array('tn_web_image', 'required', 'message' => '{attribute} 不能为空'),
			array('tn_web_click_icon', 'required', 'message' => '{attribute} 不能为空'),
            array('if_list_dispay', 'required', 'message' => '{attribute} 不能为空'),
			array('if_menu_dispay', 'required', 'message' => '{attribute} 不能为空'),
			array('if_apply_return', 'required', 'message' => '{attribute} 不能为空'),
			array('if_examine', 'required', 'message' => '{attribute} 不能为空'),
			array('if_reduce_inventory', 'required', 'message' => '{attribute} 不能为空'),
			array('is_post', 'required', 'message' => '{attribute} 不能为空'),
			array('if_apply_return', 'required', 'message' => '{attribute} 不能为空'),
			array('if_invoice', 'required', 'message' => '{attribute} 不能为空'),
			array('star_time', 'required', 'message' => '{attribute} 不能为空'),*/
			array('fater_id', 'length', 'allowEmpty'=> true),
            array('tn_code,sn_name,fater_id,tn_image,tn_click_icon,tn_web_image,tn_web_click_icon,project_list,if_list_dispay,if_menu_dispay,base_f_id_one,base_f_id,if_examine,auto_id,examine_time,if_reduce_inventory,long_pay_time,is_post,sign_long_cycle,if_apply_return,return_cycle,if_invoice,invoice_cycle,count,tn_memo,end_time,queue_number,star_time,', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'auto_filter_set' => array(self::BELONGS_TO, 'AutoFilterSet', 'auto_id'),
			'mall_products' => array(self::BELONGS_TO, 'MallProducts', 'type'),
            'mall_products_type_project' => array(self::HAS_MANY, 'MallProductsTypeProject', 'type_id'),
		
		);
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'project_list' => '关联项目',
            'id' => 'ID',
			't_code' => '编码',
            'tn_code' => '分类编码',
            'tn_image' => '手机图标',
			'tn_click_icon' => '手机图标（点击选中）',
			'tn_web_image' => '网页图标',
			'tn_web_click_icon' => '网页图标（点击选中）',
			'sn_name' => '分类名称',
            'count' => '商品数量',
            'if_menu_dispay' => '导航栏显示',
            'if_list_dispay' => '列表显示',
            'if_apply_return' => '支付后是否可申请退货',
            'star_time' => '开始时间',
			'end_time' => '结束时间',
			'queue_number' => '排序号',
			'fater_id' => '上级分类',
			'base_f_id_one' => '订单类型',
			'base_f_id' => '订单类型',
			'if_examine' => '生成订单时是否审核',
			'examine_time' => '审核时长',
			'if_reduce_inventory' => '生成订单未支付是否减库存',
			'long_pay_time' => '可等待支付时长',
			'is_post' => '是否需要邮寄',
			'sign_long_cycle' => '签收最长周期',
			'return_cycle' => '签收后退货周期',
			'if_invoice' => '支付成功时是否可申请开票',
			'invoice_cycle' => '交易完成后发票可申请周期',
			'tn_memo' => '分类描述',
			'auto_id' => '类目名称',
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
		
        return true;
    }
	
	public function getCode($fater_id) {
        return $this->findAll('fater_id=' . $fater_id);
    }
    public function getTn_Code($tn_code) {
        $lg=strlen($tn_code);
        $lg1=$lg+2;
        return $this->findAll('left(tn_code,'.$lg.')="'.$tn_code.'" and length(tn_code)='.$lg1);
    }
	public function getServiceGameCode($fater_id) {
        return $this->findAll('id in('.$fater_id.')');
    }
	public function getAll() {
        return $this->findAll('base_f_id in (350,360,361,362,363,364,367)');
    }
    public function getParentInArr($id, $arr) {
        if (in_array($id, $arr)) {
            return $id;
        }
        $rs = $this->find('id=' . $id);
        if ($rs == null) {
            return 0;
        }
        $id = $rs->fater_id;
        if ($id == '') {
            return 0;
        }
        if (in_array($id, $arr)) {
            return $id;
        } else {
            $this->getParentInArr($id, $arr);
        }
    }

}
