<?php

class Reward extends BaseModel {

  public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{video_live_reward}}';
    }

    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    protected function afterSave() {
        parent::afterSave();
    }
    public function attributeSets() {
        return array(
        'id' => 'ID',
        'video_live_id' => '视频直播id',
        'interact_type' => '互动类型',
        'gift_type' => '礼物类型',
        'reward_id' => '项目名称',
		'reward_code' => '打赏编码',
        'reward_name' => '打赏名称',
		'reward_state' => '审核状态',
		'reward_price' => '打赏价格',
        'reward_pic' => '静态图标',
        'reward_gif' => '动态图标',
		'reward_time' => '添加时间',
        'live_state' => '审核状态',
        'state' => '备案审核状态',
		'if_use' => '是否使用',
        );
    }
   public function picLabels() {
        return 'reward_pic,reward_gif';//,site_description_tem
    }
    public function pathLabels(){ return '';}

    protected function afterFind(){
        parent::afterFind();
         return true;
    }

    protected function beforeSave(){
        parent::beforeSave();
        if($this->isNewRecord){
            $this->reward_time = date('Y-m-d H:i:s');
        }
        return true;
    }
}
