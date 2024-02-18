<?php

class BoutiqueVideo extends BaseModel {

    public $project_list = '';
    public $programs_list = '';
	public $video_classify_name = '';
	public $publish_classify_name = '';
    public $video_intro_temp = '';
    public $series_num = '';
    public $show=0;

    public function tableName() {
        return '{{boutique_video}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
		$s2='club_id,publish_classify,video_classify,video_title,video_sec_title,video_logo,program_num,year,area,topic,video_intro,is_uplist,video_start,video_end,project_is,video_show,open_club_member,gf_price,member_price,t_duration,reasons_for_failure';
        if($this->show==0){
            $a = array(
                array('club_id,publish_classify,video_classify,video_title,video_logo,program_num,year,topic,video_intro,programs_list,is_uplist,video_start,video_end,project_is,video_show,open_club_member', 'required', 'message' => '{attribute} 不能为空'),
                array($s2,'safe'),
            );
        } else{
            $a = array(
                array($s2,'safe'),
            );
        }
        return $a;
    }

    public function check_save($show) {
        $this->show=$show;
    }

    /**
     * 模型关联规则
     *    'boutique_video_projec' => array(self::HAS_MANY, 'BoutiqueVideoProject', 'boutique_video_id'),
       
     */
    public function relations() {
        return array(
            'payment' => array(self::BELONGS_TO, 'BaseCode', 'is_pay'),
            'open_club_member_name' => array(self::BELONGS_TO, 'BaseCode', 'open_club_member'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'boutique_video_project' => array(self::BELONGS_TO, 'BoutiqueVideoProject', 'boutique_video_id'),
       
            'mall_product_data' => array(self::BELONGS_TO, 'MallProductData', 'product_id'),
            'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'video_source_id'),
            'qmdd_administrators' => array(self::BELONGS_TO, 'QmddAdministrators', 'is_pay'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'project_list' => '展示项目',
            'video_intro_temp' => '视频简介',
            'id' => 'ID',
            'video_code' => '视频编号',
            'video_title' => '视频名称',
            'video_sec_title' => '副标题（选填）',
            'video_logo' => '缩略图',
            'video_source_id' => '视频内容',
            'video_start' => '上线时间',
            'video_end' => '下线时间',
            'video_clicked' => '点击量',
            'video_duration' => '视频时长',
            'video_intro' => '视频简介',
            'video_hot' => '',
            'video_content' => '',
            'publish_classify' => '发布分类',
            'video_classify' => '展示分类',
            'open_club_member' => '开放对象',
            'product_id' => '收费项目',
            'state' => '状态',
            'reasons_for_failure' => '操作备注',
            'club_id' => '发布单位',
            'video_publish_gfid' => 'ID',
            'video_publish_time' => '发布时间',
            'is_uplist' => '上/下线状态',
            'apply_time' => '申请时间',
            'state_time' => '审核时间',
            'video_show' => '视频展示位置',
			'project_is' => '展示项目',
            'gf_price' => '会员收费',
            'member_price' => '单位会员收费',
            't_duration' => '试看时长',
            'down_type' => '状态',
            'programs_list' => '视频分集',
            'program_num' => '总集数',
            'area' => '发行地区',
            'year' => '发行年份',
            'topic' => '题材类型',
            'down_time' => '下架时间',
            'series_num' => '分集数',
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
            $project = BoutiqueVideoProject::model()->findAll('boutique_video_id=' . $this->id);
            $arr = array();
            foreach ($project as $v) {
                $arr[] = $v->project_id;
            }
            $this->project_list = implode(',', $arr);
			$video_classify=VideoClassify::model()->findBySql('select GROUP_CONCAT(sn_name) as sn_name from video_classify,boutique_video where find_in_set(video_classify.id,boutique_video.video_classify) and boutique_video.id=' . $this->id);
            $this->video_classify_name = $video_classify['sn_name'];
			$publish_classify=VideoClassify::model()->findBySql('select GROUP_CONCAT(sn_name) as sn_name from video_classify,boutique_video where find_in_set(video_classify.id,boutique_video.publish_classify) and boutique_video.id=' . $this->id);
            $this->publish_classify_name = $publish_classify['sn_name'];
            $this->series_num = BoutiqueVideoSeries::model()->count('video_id='.$this->id);
        }

        // if ($this->video_intro != '') {
        //     $basepath = BasePath::model()->getPath(180);
        //     $this->video_intro_temp = get_html($basepath->F_WWWPATH . $this->video_intro, $basepath);
        // }
        return true;
    }
    protected function beforeSave() {
        parent::beforeSave();

        // 图文描述处理
        $basepath = BasePath::model()->getPath(180);
        if (!empty($this->video_intro_temp)) {
            // 判断是否存储过，没有存储过则保存新文件
            if (!empty($this->video_intro)) {
                set_html($this->video_intro, $this->video_intro_temp, $basepath);
            } else {
                $rs = set_html('', $this->video_intro_temp, $basepath);
            }
			if (isset($rs['filename'])) {
                $this->video_intro = $rs['filename'];
            }
        } else {
            $this->video_intro = $this->video_intro;
        }

        if ($this->isNewRecord||empty($this->video_code)) {
            $this->video_publish_gfid = Yii::app()->session['admin_id'];
            $this->video_publish_time = date('Y-m-d H:i:s');

            // 生成视频编号
            $video_code = 'SP';
            $video_code.=substr(date('Y'),2).date('m').date('d');
            $video_code_start = $video_code;
            $count = $this->count("video_code like '" . $video_code_start."_____'");
            $code = substr('00000' . strval($count + 1), -5);
            $video_code.=$code;
            $this->video_code = $video_code;
        }

//        if (empty($this->club_id)) {
//            $this->club_id = Yii::app()->session['club_id'];
//        }
        $this->admin_id = Yii::app()->session['admin_id'];
        $this->admin_nick = Yii::app()->session['gfnick'];
        $this->udate = date('Y-m-d H:i:s');
        return true;
    }
    
    /**
     * 视频在前端可显示的条件
     */
    public function SqlShow($table_tag=''){
    	$table_tag=empty($table_tag)?'':($table_tag.'.');
    	return 'now() between '.$table_tag.'video_start and '.$table_tag.'video_end and '.$table_tag.'state=2 and '.$table_tag.'is_uplist=1 and '.$table_tag.'down_type not in (1,2,3) and !isnull('.$table_tag."video_classify) and isnull(".$table_tag."live_program_id)";//is_uplist=1
    }

}
