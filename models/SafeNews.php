<?php

class SafeNews extends BaseModel {
	public $news_content_temp = '';
    public function tableName() {
        return '{{safe_news}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
			array('news_title', 'required', 'message' => '{attribute} 不能为空'),
			//array('news_pic', 'required', 'message' => '{attribute} 不能为空'),
            //array('order_num', 'numerical', 'integerOnly' => true),
            array('news_title,news_pic,news_content_temp,news_content,club_id,
                news_type,news_introduction,news_date_start,news_date_end,state,reasons_for_failure,if_del,news_pic','safe'),
        );
    }
        
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),


        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'no' => '序号',
            'news_code'=>'编码',
            'news_title'=>'标题',
			'news_pic'=>'缩略图',
            'news_type'=>'信息类型',
            'news_type_name'=>'信息类型',
            'news_introduction'=>'信息简介',
            'news_content'=>'信息内容',
            'club_id'=>'俱乐部',
            'news_clicked'=>'点击量',
            'collection_num'=>'收藏数',
            'version'=>'版本号',
            'order_num'=>'序号',
            'news_date_start'=>'上线时间',
            'news_date_end'=>'下线时间',
            'uDate'=>'更新时间',
            'state'=>'状态',
            'reasons_for_failure'=>'操作备注',
            'state_qmddid'=>'审核员',
            'state_time'=>'审核时间',
            'if_del'=>'是否使用',

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
        $basepath = BasePath::model()->getPath(257);
        if (!empty($this->news_content_temp)) {
            // 判断是否存储过，没有存储过则保存新文件
            if (!empty($this->news_content)) {
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
        return true;
    }

}
