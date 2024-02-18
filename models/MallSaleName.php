<?php

    class MallSaleName extends BaseModel {

        public function tableName() {
            return '{{mall_sale_name}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('sale_id,f_code,f_name,f_content,sale_code,sale_name,sale_namea,sale_sourcea,sale_obja,sale_sourceb,sale_nameb,sale_objb,f_username,f_userdate','safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array();
        }

        /**
         * 属性标签
         */

        public function attributeLabels() {
            return array(
                'sale_id' => 'ID',
                'sale_code' => '编号',
                'sale_name' => '销售名稱',
                'sale_namea' => '第一次销售名',
                'sale_sourcea' => '销售来源',  // 1会员，2社区，3会员购买上架,9供应商,
                'sale_obja' => '销售对象',  // 1会员，2社区，3会员购买上架,0是所有,
                'sale_nameb' => '第二次销售名',
                'sale_sourceb' => '销售类别',//'1会员，2社区，3会员购买上架,9供应商',
                'sale_objb' => '销售对象',  // 类型，1会员，2社区，3会员购买上架,0是所有,
                'f_username' => '操作员',
                'f_userdate' => '修改日期',
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
            // $this->f_username = Yii::app()->session['admin_id'];
            $this->f_username = Yii::app()->session['gfnick'];
            $this->f_userdate = date('Y-m-d H:i:s');
            return true;
        }
		
	public function getSaleType() {
        return $this->findAll();
    }
    public function getSaleType2() {
        $cooperation= $this->getSaleType();
        $arr = array();
        $r=0;
        foreach($cooperation as $v){
            $arr[$r]['sale_id'] = $v->sale_id;
            $arr[$r]['sale_name'] = $v->sale_name;
            $r=$r+1;
        }
        return $arr;
    }
}