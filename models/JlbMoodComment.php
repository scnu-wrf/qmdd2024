<?php

class JlbMoodComment extends BaseModel {


    public function tableName() {
        return '{{jlb_mood_comment}}';
    }

    public static function model($className = __CLASS__) {
    return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

    protected function afterSave() {
        parent::afterSave();
        // 将点赞、评论、回复需要给谁读的统计信息写入`jlb_mood_comment_read_record`表，全部默认未读。
        $w0 = 'xq_id='.$this->xq_id.' OR xq_id='.$this->belong_xq;
        $publisherGfid = JlbMoods::model()->find($w0)->attributes['GF_ID'];
        JlbMoodComment::model()->updateAll(array('P_GFID'=>$publisherGfid),$w0);
        $this->P_GFID = $publisherGfid;
        $publisherFriendGroupIds = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$publisherGfid.' AND GF_GROUP_NAME !="黑名单")';
        $publisherFriends = GfGroupInfo::model()->findAll('GP_ID IN '.$publisherFriendGroupIds);
        $publisherFriendIds = array_column($publisherFriends,'GF_ID');
        if ($this->type == 1){
            $likerFriendGroupIds = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$this->like_id.' AND GF_GROUP_NAME !="黑名单")';
            $likerFriends = GfGroupInfo::model()->findAll('GP_ID IN '.$likerFriendGroupIds);
            $likerFriendIds = array_column($likerFriends,'GF_ID');
            $mutualFriendIds = array_intersect($publisherFriendIds,$likerFriendIds);
            $readRecord = new JlbMoodCommentReadRecord();
            $readRecord->publish_gfid = $publisherGfid;
            $readRecord->type_id = $this->ID;
            $readRecord->type_gfid = $this->like_id;
            $readRecord->read_gfid = $publisherGfid;
            $readRecord->type = 1;
            $readRecord->save();
            foreach ($mutualFriendIds as $mutualFriendId){
                $w1 = '(xq_id='.$this->xq_id.' OR belong_xq='.$this->xq_id.') AND (like_id='.$mutualFriendId.' OR C_GFID='.$mutualFriendId.')';
                $tmp1 = JlbMoodComment::model()->findAll($w1);
                if (!empty($tmp1)){
                    $readRecord = new JlbMoodCommentReadRecord();
                    $readRecord->publish_gfid = $publisherGfid;
                    $readRecord->type_id = $this->ID;
                    $readRecord->type_gfid = $this->like_id;
                    $readRecord->read_gfid = $mutualFriendId;
                    $readRecord->type = 1;
                    $readRecord->save();
                }
            }
        }elseif($this->type == 2){
            $commenterFriendGroupIds = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$this->C_GFID.' AND GF_GROUP_NAME !="黑名单")';
            $commenterFriends = GfGroupInfo::model()->findAll('GP_ID IN '.$commenterFriendGroupIds);
            $commenterFriendIds = array_column($commenterFriends,'GF_ID');
            $mutualFriendIds = array_intersect($publisherFriendIds,$commenterFriendIds);
            $readRecord = new JlbMoodCommentReadRecord();
            $readRecord->publish_gfid = $publisherGfid;
            $readRecord->type_id = $this->ID;
            $readRecord->type_gfid = $this->C_GFID;
            $readRecord->read_gfid = $publisherGfid;
            $readRecord->type = 2;
            $readRecord->save();
            foreach ($mutualFriendIds as $mutualFriendId){
                $w2 = '(xq_id='.$this->xq_id.' OR belong_xq='.$this->xq_id.') AND (like_id='.$mutualFriendId.' OR C_GFID='.$mutualFriendId.')';
                $tmp2 = JlbMoodComment::model()->findAll($w2);
                if (!empty($tmp2)){
                    $readRecord = new JlbMoodCommentReadRecord();
                    $readRecord->publish_gfid = $publisherGfid;
                    $readRecord->type_id = $this->ID;
                    $readRecord->type_gfid = $this->C_GFID;
                    $readRecord->read_gfid = $mutualFriendId;
                    $readRecord->type = 2;
                    $readRecord->save();
                }
            }
        }elseif($this->type == 3){
            $replierFriendGroupIds = '(SELECT ID FROM gf_group_1 WHERE GF_ID='.$this->C_GFID.' AND GF_GROUP_NAME !="黑名单")';
            $replierFriends = GfGroupInfo::model()->findAll('GP_ID IN '.$replierFriendGroupIds);
            $replierFriendIds = array_column($replierFriends,'GF_ID');
            $mutualFriendIds = array_intersect($publisherFriendIds,$replierFriendIds);
            $readRecord = new JlbMoodCommentReadRecord();
            $readRecord->publish_gfid = $publisherGfid;
            $readRecord->type_id = $this->ID;
            $readRecord->type_gfid = $this->C_GFID;
            $readRecord->read_gfid = $publisherGfid;
            $readRecord->type = 3;
            $readRecord->save();
            foreach ($mutualFriendIds as $mutualFriendId){
                $w3 = '(xq_id='.$this->xq_id.' OR belong_xq='.$this->xq_id.') AND (like_id='.$mutualFriendId.' OR C_GFID='.$mutualFriendId.')';
                $tmp3 = JlbMoodComment::model()->findAll($w3);
                if (!empty($tmp3)){
                    $readRecord = new JlbMoodCommentReadRecord();
                    $readRecord->publish_gfid = $publisherGfid;
                    $readRecord->type_id = $this->ID;
                    $readRecord->type_gfid = $this->C_GFID;
                    $readRecord->read_gfid = $mutualFriendId;
                    $readRecord->type = 3;
                    $readRecord->save();
                }
            }
        }
        return true;
    }

}