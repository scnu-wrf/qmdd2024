<?php

class GfGroup extends BaseModel {

    public function tableName() {
        return '{{gf_group_1}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('ID','GF_ID','GF_GROUP_NAME'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */   
    public function attributeLabels() {
        return array();
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
	}

	/**
	 * 获取会员好友组id,不存在则添加
	 * @return gp_id
	 */
	public function getGP($gfid) {
        $cr = new CDbCriteria;
        $cr->condition="GF_GROUP_NAME='我的G友' and GF_ID=".$gfid;
        $cr->select="id";
        $datas=$this->findAll($cr,array(),false);
        if(count($datas)==0){
        	$record = new GfGroup;
        	unset($record->ID);
        	$record->GF_ID = $gfid;
        	$record->GF_GROUP_NAME = '我的G友';
        	$res=empty($record->ID)?$record->insert($record):$record->update($record);//$record->save(true,$record);	
        	return $record->ID;
        }else{
        	return $datas[0]['id'];
        }
	}
}
