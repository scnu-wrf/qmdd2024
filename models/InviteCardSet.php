<?php

class InviteCardSet extends BaseModel {
    public $programs_list = '';
    public function tableName() {
        return '{{video_live_invite_card_modle}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
/*            array('reward_name','required','message'=>'{attribute} 不能为空'),
            array('reward_code','required','message'=>'{attribute} 不能为空'),
            array('reward_pic','required','message'=>'{attribute} 不能为空'),
            array('interact_type','required','message'=>'{attribute} 不能为空'),
            array('gift_type','required','message'=>'{attribute} 不能为空'),*/
            array('card_code,card_name,card_img,card_height,card_width,state','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_state' => array(self::BELONGS_TO,'BaseCode','state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'card_code' => '邀请卡编号',
            'card_name' => '邀请卡名称',
            'card_img' => '邀请卡背景',
            'card_height' => '背景图高(px)',
            'card_width' => '背景图宽(px)',
            'state' => '是否使用',
            'programs_list' => '直播节目单',
            //'txt_typeface_path' => '字体文件',




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
        if (!empty($this->card_img)) {
            //$this->card_img=BasePath::model()->get_www_path().$this->card_img;
            $this->card_img=$this->card_img;
        }

    }

    protected function beforeSave(){
        parent::beforeSave();
        if($this->isNewRecord){
            //$this->reward_time = date('Y-m-d H:i:s');
        }
       // $this->card_img = str_replace('http://upload.gfinter.net/','',$this->card_img);

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

    public function getCode() {
        return $this->findAll('1=1');
    }
}
