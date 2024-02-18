<?php

class AutoFilterSet extends BaseModel {

    public function tableName() {
        return '{{auto_filter_set}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
           // array('code', 'required', 'message' => '{attribute} 不能为空'),
          //  array('name', 'required', 'message' => '{attribute} 不能为空'),
           // array('type_base_id', 'required', 'message' => '{attribute} 不能为空'),
          //  array('fater_id,url_table,url_table_query', 'length', 'allowEmpty'=> true),
            
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(

         //   'basecode' => array(self::BELONGS_TO, 'BaseCode', 'type_base_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '树状编码',
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
	public function getTypename($code) {
        return $this->findAll("code like '" . $code . "%'" );
    }
	public function getCode($fater_id) {
        return $this->findAll('fater_id=' . $fater_id);
    }

}
