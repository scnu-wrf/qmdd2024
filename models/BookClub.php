<?php

class BookClub extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{book_club}}';
    }



    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'clublist' => array(self::BELONGS_TO, 'ClubList', 'id', 'foreignKey'=>'club_id','alias'=>'clublist', 'select'=>'club_name,club_logo_pic,book_club_num'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
        );
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
    public function isBook($param){
		if(checkArray($param,'gfid,club_id',0)){
			$cr = new CDbCriteria;
        	$cr->condition=" club_id=".$param['club_id']." and book_gfid=".$param['gfid'];
        	$count=$this->count($cr);
        	return $count>0?1:0;
		}else{
			return 0;
		}
    }

        /**
     * 获取用户订阅单位列表
     */
    public function getBookList($gfid,$fans_param="fans_num",$exit=0,$if_list=0) {
        $data=array('error'=>0,'msg'=>"无订阅社区");
        $tmp=$this->findAll('book_gfid='.$gfid);
        $ids=getIdstr($tmp,'club_id');
        $club_list_url_dir = $p_basepath->get_url_dir("club_list", "club_logo_pic");
        $club_sql_data=$p_clublist->getClubProjectSql('book_club.club_id',null,1,1,1);
        $where=$club_sql_data['where']." and book_club.book_gfid={$gfid} and (case when club_list.club_type=8 then ifnull(servicer_level.id,0)>0 else 1=1 end)  group by club_list.id";
        $select="club_list.id as club_id,club_list.club_name,{$p_common_tool->get_column_show_key('club_list.club_type')} as club_type,(case when club_list.club_type=8 then 5 when club_list.partnership_type>=11 and club_list.partnership_type<16 then club_list.partnership_type-11 end) as partnership_type,concat('{$club_list_url_dir}',club_list.club_logo_pic) as club_logo_pic,club_list.book_club_num as ".$fans_param.",concat('[',group_concat(concat('{\"project_name\":\"',club_project.project_name,'\",\"project_level\":\"',IFNULL(servicer_level.card_xh,0),'\"}')),']') as project";
        $table="book_club,".$club_sql_data['table']." left join servicer_level on club_project.project_level=servicer_level.id";
        $datas=$this->get_data_list($where,$select,$table,"book_club.id desc",0,0,"**");
        foreach($datas as $k=>$v){
            $datas[$k]['project']=$p_common_tool->JsonStrToArray($datas[$k]['project']);
        }
        $data["datas"] = $datas;
        parent::set_error_tow($data,count($datas),0,"获取订阅社区成功",0,"无订阅社区",$exit);
        return json_encode($data);
    }
    

}
