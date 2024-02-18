<?php

class PersonalSubscription extends BaseModel {

    public function tableName() {
        return '{{personal_subscription}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
             array('', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'news_type'),
            'user' => array(self::BELONGS_TO, 'userlist', 'gfid')
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'if_remind' => '订阅方式',
            'news_type' => '订阅类型',
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

        return true;
    }
    
    /**
     * 是否订阅
     * news_type，news_id，user_type,gfid
     * @return 0-未订阅，1-已订阅
     */
    public function isSubscription($param){
		if(checkArray($param,'gfid,news_id,news_type',0)){
			$param['user_type']=empty($param['user_type'])?210:$param['user_type'];
			$cr = new CDbCriteria;
        	$cr->condition="news_type=".$param['news_type']." and news_id=".$param['news_id']." and gf_user_type=".$param['user_type']." and gfid=".$param['gfid'];
        	$count=$this->count($cr);
        	return $count>0?1:0;
		}else{
			return 0;
		}
    }

}
