<?php

class MemberCard extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{member_card}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'states' => array(self::BELONGS_TO,'BaseCode','state'),
        );
    }

  public function actionCreate() {   
       $this-> viewUpdate(0);
   } 

   public function actionUpdate($id) {
        $this-> viewUpdate($id);
    }/*曾老师保留部份，---结束*/
  
  public function viewUpdate($id=0) {
        return array(
        'card_code' => '会员编码',
        'mamber_type' => '会员类型',
		'card_name' => '名称',
        'card_xh' => '等级序号',
		'short_name' => '短名',
        'up_type' => '支持二次上架',//是否
		'if_project' => '是否绑定项目',//需要
        'job_partner_num' => '可加伙伴数',//入战略
		'job_club_num' => '可加入单位数',
		'description' => '会员描述',
		'card_level' => '晋级级别',
		'card_score' => '晋级起始积分',
		'card_end_score' => '晋级结束积分数',
		'renew_time' => '有效期天数',
		'renew_notice_time' => '通知倒计时天数',
        );
    }

    protected function beforeSave() {
        //parent::beforeSave();
        return true;
    }
	
	// 获取单条数据，主表名转换为模型返回
    public function getOne($id, $ismodel = true) {
        $rs = $this->find('f_id=' . $id);
        if ($ismodel) {
          if ($rs != null && $rs->user_table != '') {
             $modelName = explode(',',$rs->user_table);
             $arr = explode('_', $modelName[0]);
             $modelName[0] = '';
             foreach ($arr as $v) {
                 $modelName[0].=ucfirst($v);
             }
             $rs->user_table = implode(',', $modelName);
          } 
        }
        return $rs;
    }

    public function getCode($mamber_type) {
        return $this->findAll('mamber_type=' . $mamber_type);
    }

  public function getClubLevel() {
        return $this->findAll("left(card_code,1)='D'");
    }
//$ple=0,全部，=1是虎，2是龙
  public function getMemberLevel($ple=0) {
        return $this->findAll("left(card_code,1)='A' OR left(card_code,1)='B'");
    }

     public function getServicLevel() {//服务者级别
        return $this->findAll("left(card_code,1)='Q'");
    }
    
}
