<?php

class VideoClassify extends BaseModel {

    public function tableName() {
        return '{{video_classify}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('sn_name', 'required', 'message' => '{attribute} 不能为空'),
            array('tn_code', 'required', 'message' => '{attribute} 不能为空'),
            array('base_f_id', 'required', 'message' => '{attribute} 不能为空'),
            array('if_menu_dispay', 'required', 'message' => '{attribute} 不能为空'),
            array('queue_number', 'required', 'message' => '{attribute} 不能为空'),
			/*
		    array('project_list', 'required', 'message' => '{attribute} 不能为空'),
            array('tn_image', 'required', 'message' => '{attribute} 不能为空'),
			array('tn_click_icon', 'required', 'message' => '{attribute} 不能为空'),
			array('tn_web_image', 'required', 'message' => '{attribute} 不能为空'),
			array('tn_web_click_icon', 'required', 'message' => '{attribute} 不能为空'),
            array('if_list_dispay', 'required', 'message' => '{attribute} 不能为空'),
			array('if_menu_dispay', 'required', 'message' => '{attribute} 不能为空'),
			array('if_apply_return', 'required', 'message' => '{attribute} 不能为空'),
			array('if_examine', 'required', 'message' => '{attribute} 不能为空'),
			array('if_reduce_inventory', 'required', 'message' => '{attribute} 不能为空'),
			array('is_post', 'required', 'message' => '{attribute} 不能为空'),
			array('if_apply_return', 'required', 'message' => '{attribute} 不能为空'),
			array('if_invoice', 'required', 'message' => '{attribute} 不能为空'),
			array('star_time', 'required', 'message' => '{attribute} 不能为空'),*/
			//array('fater_id', 'length', 'allowEmpty'=> true),
            array('tn_code,sn_name,base_f_id,if_menu_dispay,queue_number', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'ordertype' => array(self::BELONGS_TO, 'BaseCode', 'base_f_id'),

		
		);
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'tn_code' => '分类编号',
            'id' => 'ID',
			'base_f_id' => '视频类别',
            'sn_name' => '分类名称',
			'if_menu_dispay' => '是否显示前端',
            'queue_number' => '排序号',
            'star_time' => '开始时间',
            'end_time' => '结束时间',



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
	
	public function getCode($base_f_id) {
        return $this->findAll('base_f_id=' . $base_f_id);
    }
    /*
    public function getTn_Code($tn_code) {
        $lg=strlen($tn_code);
        $lg1=$lg+2;
        return $this->findAll('left(tn_code,'.$lg.')="'.$tn_code.'" and length(tn_code)='.$lg1);
    }
	public function getServiceGameCode($fater_id) {
        return $this->findAll('id in('.$fater_id.')');
    }
	public function getAll() {
        return $this->findAll('base_f_id in (350,360,361,362,363,364,367)');
    }
    public function getParentInArr($id, $arr) {
        if (in_array($id, $arr)) {
            return $id;
        }
        $rs = $this->find('id=' . $id);
        if ($rs == null) {
            return 0;
        }
        $id = $rs->fater_id;
        if ($id == '') {
            return 0;
        }
        if (in_array($id, $arr)) {
            return $id;
        } else {
            $this->getParentInArr($id, $arr);
        }
    }*/

	/**
	 * 获取视频/直播分类
	 * 365-video,366-live
	 */
	public function get_videoLive_type($base_id=365){
		$data=get_error(1,"获取失败");
        $cr = new CDbCriteria;
        $cr->condition='if_menu_dispay=1 and base_f_id='.$base_id;//now() between star_time and end_time and 
        $cr->order = 'queue_number DESC';
        $cr->select="id,tn_code,tn_image,sn_name,base_f_id";
        $datas=$this->findAll($cr,array(),false);
        $sdata=array();
        $n=0;
        $mdata=array();
        //$path_www="https://upload.gfinter.net/";
        foreach($datas as $k=>$v){
        	if(!empty($mdata[$v['tn_code']])){
        		continue;
        	}
        	$mdata[$v['tn_code']]=$n;
        	$sdata[$n]['id']=$v['id'];
        	$sdata[$n]['code']=$v['tn_code'];
        	//$sdata[$n]['logo']=empty($v['tn_image'])?"":($path_www.$v['tn_image']);
        	$sdata[$n]['name']=$v['sn_name'];
        	$sdata[$n]['is_live']=0;
        	$n++;
        }
		return $sdata;
    }
}
