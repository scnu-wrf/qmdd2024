<?php

class JlbMoods extends BaseModel {

	public function tableName() {
        return '{{jlb_moods}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
		
		return array(
		   array('xq_id,GF_ID,content,ttime,address,gfwb,web_link,pubType,media_url,if_remind,remind_friends,is_show,show_friends,if_del', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gfUser' => array(self::BELONGS_TO, 'userlist', array('GF_ID' => 'GF_ID')),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
		    'xq_id' => '心情记录id',
            'GF_ID' => '发表心情人的gfid',
            'content' => '心情内容 base64',
            'ttime' => '发表时间',
            'address' => '发表心情时的地址GPS定位 base64',
            'gfwb' => '0:不允许分享;1:允许分享',
            'pubType' => '心情发布类型，0自发 1转发 2分享',
            'media_url' => '媒体地址和名称 ，多个用|分隔',
            'if_remind' => '是否设置提醒 1-提醒 2不提醒',
            'remind_friends' => '提醒的好友gfid，|隔开',
            'is_show' => '可视范围 默认0-公开 1-好友 2-私密 3-部分可见',
            'show_friends' => 'is_show为3时，部分可见的gfid，|隔开',
            'if_del' => '是否删除，关联base_code表DATA类型 509-逻辑删除 510正常',
        );
    }
    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
	}
    
    /**
     * 动动圈最新发布的带图片信息
     */
    public function getLastMoodPic($gfid,$visit_gfid){
        $cr = new CDbCriteria;
        $where="if_del=510  and GF_ID=".$gfid;
    	if(!empty($visit_gfid)&&$visit_gfid!=$gfid){
	        $where.=" and (is_show in(0,1) or (is_show=3 and find_in_set(".$visit_gfid.",replace(show_friends,'|',',')))) ";
    	}else{
    		$where.=" and is_show in(0,1)";
    	}
    	$cr->condition=$where." and length(media_url)>0";
        $cr->select="xq_id,media_url";
        $cr->order=" xq_id desc";
    	$mood=$this->find($cr);
    	
    	$cr->condition=$where." and length(web_link)>0";
        $cr->select="xq_id,web_link";
	    $mood2=$this->find($cr);
    	if(empty($mood)&&empty($mood2)){
    		return "";
    	}
    	if(!empty($mood2)&&(empty($model)||$model2->xq_id>$model->xq_id)){
    		$web_link=json_decode(base64_decode($mood2->web_link,true),true);
    		if(empty($web_link)||empty($web_link['imgurl'])){
    			return empty($mood)?'':$mood->media_url;
    		}else{
    			return $web_link['imgurl'];
    		}
    	}else{
    		return empty($mood)?'':$mood->media_url;
    	}
    }

}
