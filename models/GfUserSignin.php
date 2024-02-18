<?php

class GfUserSignin extends BaseModel {

    public function tableName() {
        return '{{gf_user_signin}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('data_id,gfid,gf_account,gf_zsxm,type,type_name,service_id,code,service_name,service_data_id,
                    service_data_name,game_arrange_code,sign_type,sign_time,sign_longitude,sign_latitude','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            //'project_list' => array(self::BELONGS_TO, 'ClubNewsProject', 'project_id'),
            'gf_material' => array(self::BELONGS_TO, 'GfMaterial', 'news_video'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'data_id'=>'服务表id',  // 关联表gf_service_data表id
            'gfid'=>'签到会员id',
			'gf_account'=>'GF帐号',
            'gf_zsxm'=>'队名/姓名',
            'type'=>'服务类型',
            'type_name'=>'服务类型',
            'service_id'=>'服务id',  // 具体的商品/服务ID，根据order_type类型取关联表ID
            'code'=>'服务编码',  // 对应于type类型的所属编码,赛事game_list，动动约club_order，培训train_info
            'service_name'=>'服务名称',
            'service_data_id'=>'服务项目',
            'service_data_name'=>'服务项目',
            'game_arrange_code'=>'赛程编码',  // 关联game_list_arrange表code字段
            'sign_type'=>'签到情况',  // 0-签到 1-签退
			'sign_time'=>'服务时间',
            'sign_longitude'=>'签到地点经度',
            'sign_latitude'=>'签到地点纬度',
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
        return true;
    }
}
