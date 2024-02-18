<?php

class CommentList extends BaseModel {

    public function tableName() {
        return '{{comment_list}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('type,communication_news_title,communication_gfaccount,communication_gfnick,communication_type,communication_content,evaluate_img_url,if_dispay,communication_praise,reasons_for_failure,state,state_qmddid,state_time,uDate','safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            // 'base_code' => array(self::BELONGS_TO, 'BaseCode', 'type'),
            'base_code_type' => array(self::BELONGS_TO, 'BaseCode', 'communication_type'),
            'project_list' => array(self::BELONGS_TO, 'ProjectList', 'member_project_id'),
        );
    }

    /**
     * 属性标签
     */   
    public function attributeLabels() {
        return array(
            'id'=>'ID',
            'type' => '信息类型',//'信息类型，定义communication_news_id所属表：0-社区动态信息（club_news），
                                 //1-赛事（game_list），2-赛事图集、视频（game_news），3-直播评论（video_live）,4-gf点播视频评论（boutique_video）'
            'type_name' => '信息类型',
            'communication_news_id'=>'信息ID',
            'communication_news_title'=>'信息标题',
            'communication_gfaccount'=>'评论人账号',
            'communication_gfid' => '评论人ID',
            'communication_gfnick'=>'评论人昵称',
            'communication_type'=>'评论类型',//'评论类型，根据此类型来显示communication_content：0-文字评论，
                                             //1-表情评论（同社交表情xx01-xx85），2-图片评论，URL多张图片以|为分隔符，3-混合评论，必须为json格式{"str":"文字内容","pics":"图片信息，多张图片以|为分隔符"}'
                                             
            'communication_content'=>'评论内容',//'评论的内容，base64编码'
            'evaluate_img_url'=>'评论图片',// '评论图片，用“｜”隔开'
            'communication_praise'=>'信息点赞数',
            'if_del'=>'删除',//'使用会员表id,关联club_member表id'
            't_code'=>'评论编码',//'评论编码--评论id+001+001+001.......;当communication_type=4时，为被点赞的评论ID'
            'uDate'=>'评论时间',
            'if_dispay'=>'是否显示',
            'if_dispay_name'=>'是/否显示',//'是否显示名称'
            'state'=>'审核状态',
            'state_name'=>'审核状态',//'审核状态名称'
            'reasons_for_failure'=>'操作备注',
            'state_qmddid'=>'审核员ID',
            'state_qmddname'=>'审核员名称',
            'state_time'=>'审核时间',
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
        $this->communication_content=base64_decode($this->communication_content);
        
        return true;
    }

    protected function beforeSave() {
        parent::beforeSave();
        // 图文描述处理
        if ($this->isNewRecord) {
             
        $this->uDate = date('Y-m-d H:i:s');  
        }
        $this->communication_content=base64_encode($this->communication_content);
        $this->state_time = date('Y-m-d H:i:s');
        return true;
    }


}
