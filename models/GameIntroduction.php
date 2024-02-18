<?php

class GameIntroduction extends BaseModel {

    public $intro_content_temp = '';
	public $intro_content_temp1 = '';
    public function tableName() {
        return '{{game_introduction}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('game_id,intro_title,intro_title_en,intro_simple_content,intro_content,uDate,intro_content_temp','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_list_id' => array(self::HAS_MANY, 'GameList', 'game_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_id' => '赛事ID',
            'intro_title' => '标题',
            'intro_title_en' => '英文标题',
            'intro_simple_content' => '简介',
            'intro_content' => '正文',
			'update' => '更新时间',
			'uDate' => '发布时间',
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
        // 图文描述处理
        $basepath = BasePath::model()->getPath(164);
        if ($this->intro_content_temp != '') {
            // 判断是否存储过，没有存储过则保存新文件
            if ($this->intro_content != '') {
                $rs = set_html($this->intro_content, $this->intro_content_temp, $basepath);
            } else {
                $rs = set_html('', $this->intro_content_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->intro_content = $rs['filename'];
            }
        } else {
            $this->intro_content = '';
        }
        if($this->isNewRecord){
            $this->uDate = date('Y-m-d h:i:s');
        }
        $this->update = date('Y-m-d h:i:s');
        return true;
    }
	
	protected function afterFind() {
        parent::afterFind();

        if ($this->intro_content != '') {
            $basepath = BasePath::model()->getPath(164);
            $this->intro_content_temp = get_html($basepath->F_WWWPATH . $this->intro_content, $basepath);
            $this->intro_content_temp1 = getplaintextintrofromhtml($this->intro_content_temp, 50);
        }
        return true;
    }
    
    public function select($game_id){
         return $this->findAll('game_id=' . $game_id);
    }
}
