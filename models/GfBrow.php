<?php

class GfBrow extends BaseModel {

   public  $gf_brow_data='';
    public function tableName() {
        return '{{gf_brow_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
		    //array('gf_account', 'required', 'message' => '{attribute} 不能为空'),
			array('brow_title', 'required', 'message' => '{attribute} 不能为空'),
			array('brow_pic', 'required', 'message' => '{attribute} 不能为空'),
            //array('brow_patent', 'numerical', 'integerOnly' => true),
            array('gf_id,gf_account,gf_name,brow_title,brow_describe,brow_pic,brow_banner,brow_patent,add_time,state,reasons_for_failure,state_time,if_user,version,brow_type,user_type','safe'),
        );
    }
        
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
           
            //'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'news_video'),
            'brow_data' => array(self::HAS_MANY, 'GfBrowData', array('brow_id'=>'id')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'gf_id' => '作者',
            'gf_account'=>'作者帐号',
            'gf_name'=>'作者姓名',
			'brow_title'=>'作品名称',
            'brow_describe'=>'描述',
			'brow_pic'=>'封面图',
            'brow_banner'=>'横幅图',
            'brow_patent'=>'专利证明',
            'add_time'=>'提交时间',
            'state'=>'审核状态',
            'reasons_for_failure'=>'审核说明',
            'state_time'=>'审核时间',
            'if_user'=>'是/否使用',
            'version'=>'版本号',
			'gf_brow_data'=>'表情图',
            'brow_type'=>'表情类型',

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
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->user_type =2;
            $this->add_time = date('Y-m-d h:i:s');
            $this->gf_id = get_session('admin_id');
        }
        
        
        //$this->gf_id = get_session('admin_id');
       // $this->gf_name = get_session('admin_name'); 
        return true;
    }

}
