<?php

class RewardName extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{video_live_reward_name}}';
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
			'reward_code' => '打赏编码',
            'reward_name' => '打赏名称',
			'reward_pic' => '静态图标',
			'reward_gif' => '动态图标',
			'interact_type' => '互动方式',
			'interact_type_name' => '互动方式',
			'gift_type' => '礼物类型',
			'gift_type_name' => '礼物类型',
			'state' => '审核状态',
			'reward_time' => '添加时间',
			'reward_price' => '打赏价格',
        );
    }
   public function picLabels() {
        return 'reward_pic,reward_gif';//,site_description_tem
    }
    public function pathLabels(){ return '';}
    protected function afterFind() {
        parent::afterFind();
    }

   public function getrelations() {
      $s1='GiftType,gift_type:id,gift_type_name:gift->name;';
      return $s1;
    }
    protected function beforeSave(){
        parent::beforeSave();
        if($this->isNewRecord){
            $this->reward_time = date('Y-m-d H:i:s');
        }

        if(!empty($this->gift_type)){
            $gift = GiftType::model()->find('id='.$this->gift_type);
            if(!empty($this->gift_type)){
                $this->gift_type_name = $gift->name;
            }
        }
        if(!empty($this->interact_type)){
            $interact = BaseCode::model()->find('f_id='.$this->interact_type);
            if(!empty($interact)){
                $this->interact_type_name = $interact->F_NAME;
            }
        }
        return true;
    }

}
