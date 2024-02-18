<?php

class GameList extends BaseModel {

    public $intro_title='';
    public $intro_simple_content='';
    public $intro_uDate='';
	public $club_list = '';
    public $show=0;
	public $entry_information_url_temp='';
	public $entry_member_notice='';
	public $entry_team_notice='';
	public $video_id='';
	public $video_title='';
	public $project_list = '';
	public $project_name_list = '';
    //public $game_list_data = '';

    public function tableName() {
        return '{{game_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        $s2='game_title,game_small_pic,game_big_pic,game_club_id,game_club_code,game_club_name,game_code,game_type,game_level,game_area,
            area_name,game_state,game_statec,game_address,local_men,local_and_phone,Longitude,latitude,entry_information_url,dispay_star_time,
            dispay_end_time,Signup_date,Signup_date_end,game_time,game_time_end,publish_time,if_game_live,isSignOnline,game_apply_way_referee,
            game_check_way,game_score_way,game_score_detail,state,state_name,reasons_for_failure,game_online,intro_simple_content,
            entry_information_url_temp,club_list,game_web_top,game_web_top_color,game_web_bg,state_qmddid,state_qmddname,game_web_bg_color,
            recommend_type,navigatio_address,member_notice,team_notice,state_time,video_live_id,organizational,effective_time,if_del_time,if_del_admin,
            entry_member_notice,entry_team_notice';
        if($this->show==0){
            $a = array(
                // array('game_code', 'required', 'message' => '{attribute} 不能为空'),
                array('game_title', 'required', 'message' => '{attribute} 不能为空'),
                // array('game_type', 'required', 'message' => '{attribute} 不能为空'),
                array('game_level', 'required', 'message' => '{attribute} 不能为空'),
                array('game_area', 'required', 'message' => '{attribute} 不能为空'),
                array('local_men', 'required', 'message' => '{attribute} 不能为空'),
                array('local_and_phone', 'required', 'message' => '{attribute} 不能为空'),
                array('game_small_pic', 'required', 'message' => '{attribute} 不能为空'),
                array('game_big_pic', 'required', 'message' => '{attribute} 不能为空'),
                array('game_apply_way_referee', 'required', 'message' => '{attribute} 不能为空'),
                array('Signup_date', 'required', 'message' => '{attribute} 不能为空'),
                array('Signup_date_end', 'required', 'message' => '{attribute} 不能为空'),
                array('game_time', 'required', 'message' => '{attribute} 不能为空'),
                array('game_time_end', 'required', 'message' => '{attribute} 不能为空'),
                array('dispay_star_time', 'required', 'message' => '{attribute} 不能为空'),
                array('dispay_end_time', 'required', 'message' => '{attribute} 不能为空'),
                array('local_and_phone', 'numerical', 'integerOnly' => true),
                array('game_address', 'required', 'message' => '{attribute} 不能为空'),
                array('navigatio_address', 'required', 'message' => '{attribute} 不能为空'),
                array($s2,'safe'),
            );
        } else{
            $a = array(
                array('game_title', 'required', 'message' => '{attribute} 不能为空'),
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
     */
    public function relations() {
        return array(
            'Introduction' => array(self::BELONGS_TO, 'GameIntroduction', array('game_id'=>'id')),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'game_club_id'),
            'game_list_data' => array(self::HAS_MANY, 'GameListData', array('game_id'=> 'id')),
            'game_list_arrange' => array(self::HAS_MANY, 'GameListArrange', array('game_id'=> 'id')),
            'base_game_type' => array(self::BELONGS_TO, 'BaseCode', 'game_type'),
            'base_apply_way' => array(self::BELONGS_TO, 'BaseCode', 'game_apply_way_referee'),
            'base_check_way' => array(self::BELONGS_TO, 'BaseCode', 'game_check_way'),
            'base_game_live' => array(self::BELONGS_TO, 'BaseCode', 'if_game_live'),
            'base_game_online' => array(self::BELONGS_TO, 'BaseCode', 'game_online'),
            'base_recommend_type' => array(self::BELONGS_TO, 'BaseCode', 'recommend_type'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'game_code'=>'编号',//编码规则年月日+4位序号
            'game_title'=>'名称',
            'game_small_pic'=>'列表缩略图',
            'game_big_pic'=>'首页滚动图',//多张图用|分隔
            'game_club_id'=>'发布单位',//赛事活动发起者俱乐部ID
            'game_club_code'=>'发布单位编码',
            'game_club_name'=>'发布单位名称',
            'game_type'=>'所属分类',
            'game_level'=>'类型',//根据game_type类型关联base_code表ACTIVITY活动类型 和GAMELEVEL赛事类型,如 : 164积分自助赛 165专业赛 166职业赛 167龙虎晋级赛
            'level_name'=>'级别名称',
            'game_area'=>'赛事等级',//161世界级，160国家级，159省级，162社区单位级
            'area_name'=>'地区级别',
            'game_state'=>'赛事状态',//151-报名中 145-报名截止 146-比赛/活动中 149-比赛/活动结束，关联base_code表
            'game_statec'=>'状态名称',//151-报名中 145-报名截止 146-比赛/活动中 149-比赛/活动结束，关联base_code表
            'game_address'=>'比赛地点',//如 广州 海口 日月广场
            'navigatio_address'=>'导航定位',//如 广州省,海口市,琼山区,五指山南路,
            'local_men'=>'联系人',
            'local_and_phone'=>'联系电话',
            'latitude'=>'纬度',
            'Longitude'=>'经度',
            'entry_information_url'=>'参赛须知',
            'entry_information_url_temp'=>'参赛须知',
            'dispay_time'=>'前端显示时间',
            'dispay_star_time'=>'显示开始',
            'dispay_end_time'=>'显示结束',
            'signup_time' => '报名时间',
            'Signup_date'=>'报名开始',
            'Signup_date_end'=>'报名结束',
            'game_time'=>'比赛开始',
            'game_time_end'=>'比赛结束',
            'publish_time'=>'发布时间',
            'if_game_live'=>'是否开通直播',//关联base_code表yes_no类型id 648=否，649是
            'isSignOnline'=>'成员报名方式',//关联base_code表sign_online类型id 641=线下，642=线上
            'game_apply_way_referee'=> '裁判报名方式',//关联base_code表sign_online类型id 641=线下，642=线上
            'game_check_way' => '裁判报名审核',  // 报名审核方式
            'game_score_way'=>'得分方式', //0平台默认 1排名得分 2胜负平得分
            'game_score_detail'=>'积分规则设置',//是a1,b1,c1;a2,b2,c2; 表示第ai-bi名的ci分。胜负平时 a,b,c分别对应胜负平
            'state'=>'状态',//关联base_code表STATE类型状态id：371-374
            'state_time'=>'审核时间',
            'state_name'=>'状态名称',
            'uDate'=>'操作时间',
            'game_online'=>'是否显示前端',//0=否，1是
            'online_name'=>'上线',
            'if_del'=>'逻辑删除',//关联base_code表DATA类型 509-逻辑删除 510正常
            'if_del_time' => '删除时间',
            'if_del_admin' => '删除人id',
            'intro_title' => '介绍标题',
            'intro_simple_content' => '简介',
			'intro_uDate' => '更新时间',
			'club_list'=>'推荐到单位',
			'game_web_top'=>'主页顶部背景',  // 图片路径及命名base_path表
			'game_web_top_color'=>'主页顶部背景纯色',  // 十六进制色系
			'game_web_bg'=>'主页底部背景',  // 图片路径及命名base_path表
			'game_web_bg_color'=>'主页底部背景纯色',  // 十六进制色系
            'recommend_type' => '推荐至单位',
            'reasons_for_failure' => '备注',
            'state_qmddid' => '操作员',
            'state_qmddname' => '操作员姓名',
            'member_notice' => '运动员报名须知',
            'team_notice' => '裁判员报名须知',
            'organizational' => '赛事组织单位',
            'effective_time' => '缴费截止日期',
            'if_organizational' => '组织单位',
            'down_type' => '下架方式',
            'down_type_name' => '下架类型名称',
            'down_admin_id' => '下架员',
            'down_admin_nick' => '下架员昵称',
            'down_time' => '下架时间',
            'down_reason' => '下架原因',

            'game_time1' => '比赛时间',
            'game_time2' => '比赛时间',
            'Signup_date1' => '报名时间',
            'dispay_time1' => '显示时间',
            'video_live_id' => '关联直播',

            'organizational_type' => '组织单位类型',
            'conmplay_name' => '单位名称',
            'state1' => '发布状态',
            'publish_time1' => '申请时间',
            'project_num' => '赛事项目',
            'money_type' => '收费类型',
            'money_total' => '赛事收费总额（元）',
            'dispay_time1' => '显示时间',
            'stati_time' => '统计日期',
            'project_list' => '赛事项目',
        );
    }

    public function labelsOfList() {
        return array(
        'id',
        'game_code',
        'game_title',
        'game_club_name',
        'area_name',
        'level_name',
        'game_statec',
        'state_name',
        'publish_time',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

	public function getGame() {
        return $this->findAll('game_club_id='.get_session('club_id'));
    }

    public function getName($id) {
        return $this->readValue('id='.$id,'game_title');
    }

	protected function afterFind() {
        parent::afterFind();
        $this->club_list =GameListRecommend::model()->getRecommend($this->id);
    }

    protected function beforeSave() {
        parent::beforeSave();
        if($this->isNewRecord){
         $this->publish_time = date('Y-m-d H:i:s');
        }
        if(empty($this->game_code)){
          $this->game_code =getNewNo('GameList');
        } 
        $this->state_qmddid = Yii::app()->session['admin_id'];
        $this->state_qmddname = Yii::app()->session['gfnick'];
        if($this->state==2){
            $this->updatePriceSet($this); //*定价方案开始*/
            /*审核通过操作*/
            $this->updatePriceSetDetails($this);
        }
        return true;
    }

    public function save_set($model){
        if($model->state==2){
            $this->updatePriceSet($this); //*定价方案开始*/
            $this->updatePriceSetDetails($this);
        }
    }

    function updatePriceSet($tmp){
        $s1='service_id:id,event_title:game_title,supplier_id:game_club_id,';
        $s1.='supplier_name:game_club_name,star_time:Signup_date,';
        $s1.='end_time:Signup_date_end,down_time:Signup_date_end,';
        $s1.='start_sale_time:Signup_date,if_user_state=1,f_check=2,';
        $s1.='pricing_type=1,pricing_type_name=赛事活动,f_check_name=审核通过';
        MallPriceSet::model()->updatePriceSet($tmp,$tmp->id,1,$s1);
    }


    function updatePriceSetDetails($thism){
        $club_product= ClubMembershipFee::model()->find('code="TS45"');
        $w1='service_id='.$thism->id.' and pricing_type=1';
        $mset_id = MallPriceSet::model()->readValue($w1,'id');
        $data = array('f_check' => -1);
        $MSetDetails = new MallPriceSetDetails;
        $MPricing = new MallPriceSetDetails;
        $w1='set_id='.$mset_id ;
        $MSetDetails->updateAll($data,$w1);
        $MPricing->updateAll($data,$w1);
        $gdata=GameListData::model()->findAll('game_id='.$thism->id.' ');
        foreach ($gdata as $v) { //生成销售价格方案
            $this->savePriceSetDetails($thism,$v,$mset_id, $club_product);
            $this->savePricingDetails($thism,$v,$mset_id, $club_product);
        }
        $w1.=' and f_check=-1';
        $MSetDetails->deleteAll($w1);
        $MPricing->deleteAll($w1);
    }

    function savePricingDetails($thism,$v,$mset_id,$p){
      
        $bmrs =($v->game_player_team==1) ? $v->number_of_member : $v->max_num_team;
        $s1='service_data_id:id,sale_price:game_money,';
        $s1.=',inventory_quantity='.$bmrs.',start_sale_time:signup_date';
        $s1.='shopping_price:game_money,star_time:signup_date,';
        $s1.='end_time:signup_date_end,down_time:signup_date_end';

        $s2='service_id:id,f_check=2,sale_show_id=1,sale_show_name=普通销售';
        $s2.=',customer_type=1,if_user=1,';

        $s3='product_id,product_data_code:product_code,product_name';
        $parray=array(array($v,$s1),array($thism,$s2),array($p,$s2));
        MallPricingDetails::model()->savePriceDetails($mset_id,$v->id,$parray);
    }

    function savePriceSetDetails($thism,$v,$mset_id,$p){
        $bmrs =($v->game_player_team==1) ? $v->number_of_member : $v->max_num_team;
        $s1='set_id='.$mset_id.',service_data_id:id,up_quantity='.$bmrs;
        $s1.=',Inventory_quantity='.$bmrs.',service_data_name:game_data_name';
        $s1.=',sale_price:game_money,star_time:signup_date';
        $s1.=',end_time:signup_date_end,down_time:signup_date_end';

        $s2='service_id:id,service_code:game_code,service_name:game_title,';
        $s2.='f_check=2,pricing_type=1,purpose=1,shop_purpose=1';
        $s3='product_id,product_code,product_name';
        $parray=array(array($v,$s1),array($thism,$s2),array($p,$s2));
        MallPriceSetDetails::model()->savePriceDetails($mset_id,$v->id,$parray);
    
    }

     public  function getProject(){
       return GameListData::model()->getProjects($this->id);
    }

    public function game2_combom($parray,$game_id=0) {
        $s1="select a.id aid,a.game_title namea,";
        $s1.="b.id bid,game_data_name nameb";
        $s1.=" from game_list a,game_list_data b where a.id=b.game_id and ";
        if($game_id==0){
            $s1.=' a.game_state<>4 and a.state=2  ';
            $s1.=' and datediff(now(),a.game_time_end)<60';
        }
        else{
             $s1.=' a.id='.$game_id;
        }
        $s1.=' and '.get_where_club_project("a.game_club_id");
        $s1.=' order by a.id,b.id';
        $tmp=sql_findall($s1);
        $r_op=array();
        foreach ( $tmp as $mk => $mv ) {
            $namea=trim($mv['namea']).':'.$mv['aid'];
            $nameb=trim($mv['nameb']).':'.$mv['bid'];
            $r_op[$namea][$nameb]='1';
        }
        return select2_html($parray,$r_op);
    }

    public $js = ['jquery.yiiactiveform.js',];

}
