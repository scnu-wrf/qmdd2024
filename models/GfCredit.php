<?php

class GfCredit extends BaseModel {
	
	public $beans_num = '';
	
    public function tableName() {
        return '{{gf_credit}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('code,object,item_type,item_type_name,consumer_type,value,credit,item_value,gredit,sqdw_value,sqdw_gredit,zlhb_value,zlhb_gredit,sjyj_value,sjyj_gredit,beans,beans_num,consume_beans_num,beans_date_start,beans_date_end,if_use,remark', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'baseCode' => array(self::BELONGS_TO, 'BaseCode', 'object'),
            'ifuse' => array(self::BELONGS_TO, 'BaseCode', 'if_use'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '自增ID',
            'object' => '积分方式',
            'account' => 'GF账号/管理账号',
            'nickname' => '姓名/名称',
            'code' => '积分编号',
            'item_type' => '收费项目',
            'item_type_name' => '收费项目',
            'consumer_type' => '消费主体',
            'consumer_type_name' => '消费主体',
            'value' => '消费主体比率',
            'credit' => '消费主体比率',
            'item_value' => '会员积分比率',
            'gredit' => '会员积分比率',
            'sqdw_value' => '社区单位积分比率',
            'sqdw_gredit' => '社区单位积分比率',
            'zlhb_value' => '战略伙伴积分比率',
            'zlhb_gredit' => '战略伙伴积分比率',
            'sjyj_value' => '得闲体育积分比率',
            'sjyj_gredit' => '得闲体育积分比率',
            'beans' => '转体育豆数量',
            'beans_num' => '限兑数量',
            'consume_beans_num' => '已兑数量',
            'beans_date_start' => '起止时间',
            'beans_date_end' => '结束时间',
            'if_use' => '是否开放',
            'remark' => '备注',
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
		if ($this->isNewRecord) {
			
			
        }
		

        return true;
    }

}
