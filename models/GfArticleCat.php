<?php

class GfArticleCat extends BaseModel {
	
	// public $project_list = '';
    public function tableName() {
        return '{{gf_article_cat}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		    array('cat_name', 'required', 'message' => '{attribute} 不能为空'),
			// array('fater_id', 'length', 'allowEmpty'=> true),
            array('cat_name,cat_type,keywords,cat_desc,sort_order,show_in_nav,parent_id', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'show_in_nav'),
            // 'base_code_type' => array(self::BELONGS_TO, 'BaseCode', 'show_in_nav'),
		);
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
			'cat_name' => '分类名称',
            'cat_type' => '分类类型',
            'keywords' => '关键字',
			'cat_desc' => '描述',
            'sort_order' => '排序',
            'show_in_nav' => '是否显示在导航栏',
			'parent_id' => '上级分类',
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
    public function getCode($parent_id){
        return $this->findAll('parent_id=' . $parent_id);
    }
    public function getAll(){
        return $this->findAll('parent_id in (parent_id)');
    }

}
