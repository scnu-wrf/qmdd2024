<?php

class BoutiqueVideoSeries extends BaseModel {

	public $programs_list = '';
	public $video_classify_name = '';
	public $publish_classify_name = '';
	public $series_publish_num = '';
	public $series_publish_title = '';
	public $series_ids = '';
	public $down_type_name = '';
	public $down_time = '';
	public $submit_count = '';
    public function tableName() {
        return '{{boutique_video_series}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('video_id,programs_list', 'required', 'message' => '{attribute} 不能为空'),
            array('video_series_title,video_series_num,video_source_id,video_duration,video_format,video_id,series_publish_id,reasons_for_failure', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
            'boutique_video' => array(self::BELONGS_TO, 'BoutiqueVideo', 'video_id'),
            'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'video_source_id'),
            'qmdd_administrators' => array(self::BELONGS_TO, 'QmddAdministrators', 'admin_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '视频集ID',
            'video_series_code' => '分集编号',
            'video_series_title' => '分集名称',
            'video_series_num' => '分集排序',
            'video_source_id' => '视频文件',
            'video_duration' => '时长(分钟)',
            'video_format' => '格式',
            'video_id' => '所属视频',
            'video_code' => '视频编号',
            'video_title' => '视频名称',
            'video_logo' => '缩略图',
            'apply_time' => '申请时间',
            'publish_time' => '发布时间',
            'publish_id' => '发布管理员ID',
            'state' => '状态',
            'state_time' => '审核时间',
            'reasons_for_failure' => '操作备注',
            'is_uplist' => '上/下线状态',
            'video_clicked' => '点击量',
            'video_download_volume' => '下载量',
            'club_id' => '发布单位',
            'publish_classify' => '发布分类',
            'programs_list' => '视频分集',
            'series_publish_id' => '视频分集发布id',
            'series_publish_num' => '发布分集数',
            'series_publish_title' => '发布分集号',
			'down_type_name' => '下架类型',
			'down_time' => '下架时间',
			
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
        
		if ($this->id != null) {
			$video_classify=VideoClassify::model()->findBySql('select GROUP_CONCAT(sn_name) as sn_name from video_classify,boutique_video where find_in_set(video_classify.id,boutique_video.video_classify) and boutique_video.id=' . $this->video_id);
            $this->video_classify_name = $video_classify['sn_name'];
			$publish_classify=VideoClassify::model()->findBySql('select GROUP_CONCAT(sn_name) as sn_name from video_classify,boutique_video where find_in_set(video_classify.id,boutique_video.publish_classify) and boutique_video.id=' . $this->video_id);
            $this->publish_classify_name = $publish_classify['sn_name'];
            $this->series_publish_num = BoutiqueVideoSeries::model()->count('series_publish_id='.$this->series_publish_id);
			$publish=BoutiqueVideoSeries::model()->findBySql('select GROUP_CONCAT(video_series_title) as series_publish_title,GROUP_CONCAT(id) as series_ids from boutique_video_series where series_publish_id='.$this->series_publish_id);
            $this->series_publish_title = $publish->series_publish_title;
            $this->series_ids = $publish->series_ids;
        }
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();
		if ($this->isNewRecord) {
            $this->publish_id = Yii::app()->session['admin_id'];
            $this->publish_time = date('Y-m-d H:i:s');
        }
        $this->udate = date('Y-m-d H:i:s');
        return true;
    }
}
