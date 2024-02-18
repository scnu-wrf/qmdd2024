<?php

class GfSiteUser extends BaseModel {

    public function tableName() {
        return '{{gf_site_user}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            //array('project_id', 'numerical', 'integerOnly' => true),
            
             array('project_id,','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'user_site_code' => array(self::BELONGS_TO, 'GfSite', 'site_code'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'state'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            `id` => 'ID',
            `site_code` => '场地编码',  // 关联gf_site表',
            `club_id` => '申请单位ID',  // 关联club_list表id',
            `club_name` => '单位名称',
            `club_contacts` => '单位申请人',
            `club_contacts_phone` => '单位联系人电话',
            `claim_time` => '认领时间',
            `state` => '申请状态',  // 关联base_code表ID为371-374',
            `if_del` => '是否解除',  // 0正常  1解除，state=2通过时使用',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
