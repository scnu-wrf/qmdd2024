<?php

class GameNewsPic extends BaseModel {

    public function tableName() {
        return '{{game_news_pic}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('game_news_id,news_pic,introduce,news_title,order_num','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_news' => array(self::BELONGS_TO, 'GameNews', 'game_news_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_news_id' => '编码',
            'news_title' => '图片标题说明',
            'news_pic' => '信息图片/视频文件名',
			'introduce' => '介绍',

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
