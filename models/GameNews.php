<?php

class GameNews extends BaseModel {

    public $game_news_pic='';
	public $news_content_temp = '';
    public function tableName() {
        return '{{game_news}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('game_id', 'required', 'message' => '{attribute} 不能为空'),
            array('news_title', 'required', 'message' => '{attribute} 不能为空'),
            array('news_code,game_id,news_title,news_pic,news_content_temp,news_content,club_id,news_type,news_introduction,news_date_start,news_date_end,state,reasons_for_failure,news_video,order_num','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            //'project_list' => array(self::BELONGS_TO, 'ClubNewsProject', 'project_id'),
            'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'news_video'),


        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'news_code'=>'编号',
            'news_title'=>'标题',
			'news_pic'=>'缩略图',
            'game_id'=>'所属赛事',
            'game_news_pic'=>'子图',
            'news_video'=>'视频',
            'news_type'=>'类型',
            'news_type_name'=>'信息类型',
            'news_introduction'=>'信息简介',
            'news_content'=>'图文内容',
            'club_id'=>'发布单位',
            'club_names'=>'发布单位名称',
			'game_names'=>'所属赛事',
            'news_clicked'=>'点击量',
            'collection_num'=>'收藏数',
            'version'=>'版本号',
            'order_num'=>'排序',
            'news_date_start'=>'上线时间',
            'news_date_end'=>'下线时间',
            'uDate'=>'操作时间',
            'state'=>'状态',
            'reasons_for_failure'=>'操作备注',
            'state_qmddid'=>'审核员',
            'state_time'=>'审核日期',
            'apply_date'=>'申请日期',
            'if_del'=>'下架',
			//'club_list'=>'推荐到单位',
			//'project_id'=>'项目',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function afterFind() {
        parent::afterFind();

        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        // 图文描述处理
        $basepath = BasePath::model()->getPath(189);
        if ($this->news_content_temp != '') {
            // 判断是否存储过，没有存储过则保存新文件
            if ($this->news_content != '') {
                set_html($this->news_content, $this->news_content_temp, $basepath);
            } else {
                $rs = set_html('', $this->news_content_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->news_content = $rs['filename'];
            }
        } else {
            $this->news_content = '';
        }

        $this->uDate = date('Y-m-d H:i:s');  
		$this->state_qmddid = get_session('admin_id'); 
		$this->state_qmddname = get_session('admin_name'); 
        return true;
    }


}
