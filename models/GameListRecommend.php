<?php

class GameListRecommend extends BaseModel {

    public function tableName() {
        return '{{game_list_recommend}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('game_id,recommend_clubid', 'numerical', 'integerOnly' => true),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'game_list' => array(self::BELONGS_TO, 'GameList', 'game_id'),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'recommend_clubid'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'game_id' => '源赛事',
            'recommend_clubid' => '推荐到单位',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }


  public  function getRecommend($gid) {
        $gid=(empty($gid)) ? 0 : $gid;
        $tmp = GameListRecommend::model()->findAll('game_id=' . $gid);
        $rs = array(0);
        foreach ($tmp as $v) {
            $RS[] = $v->recommend_clubid;
        }
        return implode(',', $rs);
    }

}
