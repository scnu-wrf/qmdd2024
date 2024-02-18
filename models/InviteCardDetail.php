<?php

class InviteCardDetail extends BaseModel {
    public $programs_list = '';
    public function tableName() {
        return '{{video_live_invite_card_modle_detail}}';
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
            array('type,content_type,content,width,height,x,y,txt_align,txt_size,txt_typeface,txt_typeface_path,txt_style,txt_typeface_familyname,fillet_diameter,color_argb','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            //'base_state' => array(self::BELONGS_TO,'BaseCode','state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            //'id' => 'ID',


            'type' => '类型',
            'content_type' => '内容类型',
            'content' => '内容',
            'width' => '宽',
            'height' => '高',
            'x' => '起点坐标x',
            'y' => '起点坐标y',
            'txt_align' => '对齐方式',
            'txt_size' => '文字大小',
            'txt_typeface' => '文字字体',
            'txt_typeface_path' => '字体文件',
            'txt_style' => '文字样式',
            'txt_typeface_familyname' => '样式名称',
            'fillet_diameter' => '图片直径',
            'color_argb' => '文字颜色',



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
        if (!empty($this->txt_typeface_path)) {
            //$this->txt_typeface_path=BasePath::model()->get_www_path().$this->txt_typeface_path;
            $this->txt_typeface_path=$this->txt_typeface_path;
        }

    }

    protected function beforeSave(){
        parent::beforeSave();
        if($this->isNewRecord){
            //$this->reward_time = date('Y-m-d H:i:s');
        }
        //$this->txt_typeface_path = str_replace('http://upload.gfinter.net/','',$this->txt_typeface_path);
   
/*        if(!empty($this->gift_type)){
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
        }*/
        return true;
    }

    public function getCode() {
        return $this->findAll('1=1');
    }
}
