<?php

class GfArticle extends BaseModel {

    public $content_temp = '';
	
	// public $project_list = '';
    public function tableName() {
        return '{{gf_article}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		    array('title', 'required', 'message' => '{attribute} 不能为空'),
		    array('is_open', 'required', 'message' => '{attribute} 不能为空'),
            array('cat_id,title,cat_name,content,author,keywords,is_open,add_time,material_id,file_url,link,description,content,content_temp', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'is_open'),
            'gf_article' => array(self::BELONGS_TO, 'GfArticle', 'id'),
            'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'material_id'),
            'auto_filter_set' => array(self::BELONGS_TO, 'AutoFilterSet', 'cat_id'),
		);
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
			'cat_id' => '文章分类',
			'cat_name' => '分类说明',
            'title' => '文章标题',
            'content' => '文章内容',
			'author' => '发布管理员',
            'keywords' => '关键字',
            'is_open' => '是否显示',
			'add_time' => '添加日期',
			'material_id' => '介绍视频',
			'file_url' => '输入文件地址',
			'link' => '外部链接',
			'description' => '内容简介',
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

        $basepath = BasePath::model()->getPath(192);
        if ($this->content_temp != '') {
            if($this->content != '') {
                set_html($this->content, $this->content_temp, $basepath);
            } else {
                $rs = set_html('', $this->content_temp, $basepath);
                $this->content = $rs['filename'];
            }
        } else {
            $this->content = '';
        }
		
        $this->add_time = date('Y-m-d H:i:s');
        return true;
    }
    public function getCode($cat_id){
        return $this->findAll('cat_id=' . $cat_id);
    }
    public function getAll(){
        return $this->findAll('cat_id in (cat_id)');
    }
    // public function getAll(){
    //     return $this->findAll('cat_id in (211,212,213,214,215,216,217,218,219)');
    // }
}
