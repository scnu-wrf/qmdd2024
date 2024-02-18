<?php

class VideoDownloadRecord extends BaseModel {

    public function tableName() {
        return '{{video_download_record}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('video_type', 'required', 'message' => '{attribute} 不能为空'),
            array('video_source_id', 'required', 'message' => '{attribute} 不能为空'),
            array('video_url', 'required', 'message' => '{attribute} 不能为空'),
            array('user_type', 'required', 'message' => '{attribute} 不能为空'),
            array('queue_number', 'required', 'message' => '{attribute} 不能为空'),
            array('gfid', 'required', 'message' => '{attribute} 不能为空'),
            array('video_type,video_id,live_program_id,video_title,video_logo,video_classify,video_source_id,video_url,user_type,gfid,gfaccount,gfname,download_date', 'safe'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            
			'video_id' => '视频ID',
            'live_program_id' => '直播节目录制',
			'id' => 'ID',
            'video_type' => '视频类型',
        	'video_source_id' => '视频在视频源',
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
	 * 添加下载记录
	 */
	public function addDownloadRecord($param) {
		$data=get_error(1,"操作失败");
		checkArray($param,'gfid,video_type',1);
		if($param['video_type']==365){
			checkArray($param,'video_id,video_series_id',1);
		}else if($param['video_type']==366){
			checkArray($param,'live_program_id',1);
		}else{
			set_error($data,1,'缺少参数',1);
		}
        $record = new VideoDownloadRecord();
        unset($record->id);
        $record->gfid = $param['gfid'];
        $record->video_type = $param['video_type'];
        $record->user_type = 1;
		if($param['video_type']==365){
        	$record->video_id = $param['video_id'];
        	$record->video_series_id = $param['video_series_id'];
		}else if($param['video_type']==366){
        	$record->live_program_id = $param['live_program_id'];
		}
        $res=$record->save();
		set_error_tow($data,$res,0,'操作成功',1,'操作失败',1);
	}
	
	/**
	 * 获取下载记录
	 */
	public function getDownloadRecord($param){
		$data=get_error(1,"获取失败");
		checkArray($param,'gfid,video_type',1);
		if($param['video_type']==365){
			checkArray($param,'video_id',1);
			$where="t.video_id in(".$param['video_id'].")";
		}else if($param['video_type']==366){
			checkArray($param,'live_program_id',1);
			$where="t.live_program_id in(".$param['live_program_id'].")";
		}else{
			set_error($data,1,'缺少参数',1);
		}
	    $img_dir=getShowUrl('file_path_url');
        $cr = new CDbCriteria;
        $cr->condition=$where;
        $cr->join = "join boutique_video bv on bv.id=t.video_id join base_code bc on t.video_classify=bc.f_id";
        $cr->select="t.video_title,t.video_logo,t.video_url,bc.f_name as video_classify_name,bv.video_download_volume";
        $datas=$this->findAll($cr,array(),false);
        $sdata=array();
        $path_www=getShowUrl('file_path_url');
        foreach($datas as $k=>$v){
        	$sdata[$k]=$v;
      		$sdata[$k]['video_logo']=empty($v['video_logo'])?"":($path_www.$v['video_logo']);
      		$sdata[$k]['video_url']=empty($v['video_url'])?"":($path_www.$v['video_url']);
        }	
		$data['datas']=$sdata;
		set_error($data,0,'获取成功',1);
	}
}
