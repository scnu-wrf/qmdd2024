<?php

class GfBrowData extends BaseModel {

    public function tableName() {
        return '{{gf_brow_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('brow_id,brow_cover_map,brow_img,brow_img_label,old_id','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gf_brow_list' => array(self::BELONGS_TO, 'GfBrowList', 'brow_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'brow_id' => '表情ID',
            'brow_cover_map' => '表情图',
            'brow_img_label' => '标签',

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

}
