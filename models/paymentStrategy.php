<?php

class paymentStrategy extends BaseModel {  

	public $project_list = '';
	public $site_description_temp='';
    //public $show=370;

    public function tableName() {
        return '{{payment_strategy}}';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function check_save($show) {
        $this->show=$show;
    }

    /*public function relations() {
        return array(
            'gf_site_project'=>array(self::HAS_MANY, 'GfSiteProject', array('site_id' => 'id')),
			'club_list' => array(self::BELONGS_TO, 'ClubList', 'user_club_id'),
            //'envir' => array(self::BELONGS_TO, 'BaseCode', 'site_envir'),
            'level' => array(self::BELONGS_TO, 'ServicerLevel', 'site_level'),
			'sitebelong' => array(self::BELONGS_TO, 'BaseCode', 'site_belong'),
            'origin' => array(self::BELONGS_TO, 'BaseCode', 'site_origin'),
        );
    }*/

    public function rules() {
      return $this->attributeRule();
    }

    public function attributeLabels() {
        return $this->getAttributeSet();
    }

    public function attributeSets() {
        return array(
        'id'=> 'ID',
        'name' => '减免明细',
        'uptime' => '上线时间',
        'offtime' => '下线时间',
        'showtime' => '优惠展示开始时间',
        'payment_id' => '所属活动编码',
        'type' => '优惠策略',
        'times' => '优惠次数',
        'discount' => '优惠折扣',
        'is_first_time' =>'是否只有第一次消费可以使用',
        'strategy_code' => '优惠策略编码'
        );
    }

    public function picLabels() {//如果使用pic上传，需要告知哪个文件成了图片
        return '';
    }

    // public function pathLabels(){ 
    //     return '';
    // }

	protected function afterFind() {
        parent::afterFind();
        //$this->project_list =GfSiteProject::model()->getProjectIds($this->id);
        return true;
    }

	protected function beforeSave() { 
        //parent::beforeSave();
        // 图文描述处理
        // $this->site_description=getHtmlFile($this,'site_description');
        // if ($this->isNewRecord) {
        //   	$this->user_club_id=get_session('club_id');
		// 	$this->belong_id=get_session('club_id');
        // }
        return true;
    }

}
