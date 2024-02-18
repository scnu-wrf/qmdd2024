<?php

class ServicerLevel extends BaseModel {


    public $location ='';
    public function tableName() {
        return '{{servicer_level}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('type,member_type_id, member_second_id, entry_way, card_name, card_xh, card_level, card_score, card_end_score, certificate_type,renew_time,card_level_logo', 'safe'),
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
        if($_REQUEST['r']=='servicerLevel/create'||$_REQUEST['r']=='servicerLevel/update'||$_REQUEST['r']=='servicerLevel/index'){
            $member_type_id = '服务者类型';
            $card_name = '服务者等级';
        }elseif($_REQUEST['r']=='servicerLevel/create_dragon_tiger'||$_REQUEST['r']=='servicerLevel/update_dragon_tiger'||$_REQUEST['r']=='servicerLevel/index_dragon_tiger'){
            $member_type_id = '龙虎类型';
            $card_name = '龙虎等级';
        }elseif($_REQUEST['r']=='servicerLevel/create_gf'||$_REQUEST['r']=='servicerLevel/update_gf'||$_REQUEST['r']=='servicerLevel/index_gf'){
            $member_type_id = '会员类型';
            $card_name = '会员等级';
        }else{
            $member_type_id = '会员类型';
            $card_name = '项目等级';
        }
        return array(
            'id' => '表示',
            'member_type_id' => $member_type_id,
            'member_type_code' => $member_type_id,
            'member_type_name' => $member_type_id,
            'member_second_id' => '单位会员二级类型id,关联club_type表id',
            'member_second_code' => '会员编码(二级)',
            'member_second_name' => '会员二级类型名称',
            'entry_way' => '入驻方式',
            'entry_way_name' => '入驻方式',
            'card_name' => $card_name,
            'card_level_logo' => '等级图标',
            'card_xh' => '等级序号',
            'card_level' => '晋级级别序号',
            'card_score' => '等级起算积分',
            'card_end_score' => '等级止算积分',
            'certificate_type' => '等级分来源',
            'renew_time' => '有效期（天）',

            /* 自定义属性 */
            'card_name1' => '等级名称',
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
        if ($this->isNewRecord) {

        }
        return true;
    }

    //毛利分成单位
    public function getSharing() {
        return $this->findAll('card_level=-1  and is_profit=1 order by card_xh ASC');
    }
    //GF会员/龙虎会员等级
    public function getMember() {
        return $this->findAll('type in(210,1472)  and is_profit=1 order by card_xh ASC');
    }
    //龙虎会员等级
    public function getDgMember() {
        return $this->findAll('type=1472  and is_profit=1 order by card_xh ASC');
    }
    //社区单位
    public function getClubLevel($entry) {
        return $this->findAll('type=1467  and is_profit=1 and entry_way='.$entry.' order by card_xh ASC');
    }
    public function getCode($type) {
        return $this->findAll('type='.$type);
    }


}
