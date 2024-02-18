<?php

class QmddFuntionData extends BaseModel {
    public function tableName() {
        return '{{qmdd_funtion_data}}';
    }

    /**
     * 模型验证规则
    */
    public function rules() {
        return array(
            array('function_area_id', 'required', 'message' => '{attribute} 不能为空'),
            array('function_id', 'required', 'message' => '{attribute} 不能为空'),
            array('dispay_type', 'required', 'message' => '{attribute} 不能为空'),
            array('project_id', 'required', 'message' => '{attribute} 不能为空'),
            array('club_id', 'required', 'message' => '{attribute} 不能为空'),
            // array($ar1,'safe'),
            array($this->safeField(), 'safe'),
            
        );
    }

    /**
     * 模型关联规则
     */
     public function relations() {
         return array(
             'base_code_if_user' => array(self::BELONGS_TO, 'BaseCode', 'if_user'),
             'base_code_dispay_type' => array(self::BELONGS_TO, 'BaseCode', 'dispay_type'),
             'qmdd_function_area'=> array(self::BELONGS_TO, 'QmddFunctionArea','function_area_id'),
             'qmdd_function'=> array(self::BELONGS_TO, 'QmddFunction','function_id'),
             'club_list'=> array(self::BELONGS_TO, 'ClubList','club_id'),
             'project_list'=> array(self::BELONGS_TO, 'ProjectList','project_id'),
             'qmdd_administrators'=> array(self::BELONGS_TO, 'QmddAdministrators','add_adminid'),
         );
     }

     /**
      * 属性标签
      */
      public function attributeLabels() {
          return array(
              'id' => 'ID',
              'set_code' => '方案编码',         // 格式为年月+4位数序号
              'function_area_id' => '展示区域',         // 关联qmdd_function_area表ID
              'function_area_name' => '功能区域表说明',
              'function_id' => '展示功能',        // 关联qmdd_function表ID
              'function_name' => '功能表说明',
              'dispay_icon' => '默认图标',
              'dispay_click_icon' => '选中图标',
              'dispay_title' => '显示名称',
              'dispay_num' => '排序序号',
              'project_id' => '使用项目',           // 关联project_list表id
              'dispay_type' => '使用类型',        // 关联base_code表CLIENT类型id
              'dispay_format' => '排序格式',
              'dispay_star_time' => '上线时间',
              'dispay_end_time' => '下架时间',
              'club_id' => '使用单位',          // 关联club_list表id
              'club_name' => '单位名称',
              'add_adminid' => '添加管理员',       // 关联qmdd_administrators表id
              'if_user' => '使用状态',             // 关联base_code表yes_no类型id
              'updeta_time' => '新增/更新时间',
          );
      }

      /**
       * Returns the static model of the specified AR class
       */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSava() {
        parent::beforeSava();
        $this->add_adminid = Yii::app()->session['gfnick'];
        $this->update = date('Y-m-d H:i:s');
        return true;
    }
    
    /**
	 * 显示条件
	 * @return array('where'=>$where,'table'=>$table);
	 */
	private function getShowSql($menu_type,$dispay_type,$club_id=null,$project_id=null){
		$table=" left join qmdd_function qf on qf.id=t.function_id";
		$where="t.function_area_id=".$menu_type;
		$where.=" and t.if_user=649 and (t.dispay_star_time='0000-00-00 00:00:00' or t.dispay_star_time <= now()) and (t.dispay_end_time='0000-00-00 00:00:00' or  t.dispay_end_time is null or t.dispay_end_time >= now())";
		$where.=empty($dispay_type)?"":(" and (ISNULL(t.dispay_type) or FIND_IN_SET(t.dispay_type,".$dispay_type.")");
		$where.=empty($club_id)?"":(" and t.club_id=".$club_id);
		$where.=empty($project_id)?"":(" and (ISNULL(t.project_id) or t.project_id=".$project_id.")");
		return array('where'=>$where,'table'=>$table);
	}
    
    public function getMenuData($param){
		if (!checkArray($param,'menu_type')) {
			return null;
		}
		$club_id=empty($param['club_id'])?"":$param['club_id'];
		$project_id=empty($param['project_id'])?"":$param['project_id'];
		$menu_type=empty($param['menu_type'])?"":$param['menu_type'];
		$dispay_type=empty($param['dispay_type'])?"":($param['dispay_type']+727);
		
		$select="t.function_id as id,if(ISNULL(t.id),IFNULL(qf.function_title,''),t.dispay_title) as name,if(IFNULL(t.dispay_icon,'')='',if(IFNULL(qf.function_icon,'')='','',qf.function_icon),t.dispay_icon) as img,if(IFNULL(t.dispay_click_icon,'')='',if(IFNULL(qf.function_click_icon,'')='','',qf.function_click_icon),t.dispay_click_icon) as click_img";
		$show_sql_data=$this->getShowSql($menu_type,$dispay_type,$club_id,$project_id);
		
		$cr = new CDbCriteria;
        $cr->condition=$show_sql_data['where'];
        $cr->select=$select;
        $cr->join=$show_sql_data['table'];
        $cr->group='t.function_id';
        $cr->order='t.dispay_num desc';
        $menu_datas=$this->findAll($cr,array(),false);
        
		if($menu_type==45||$menu_type==46||$menu_type==47){
			foreach($menu_datas as $mk=>$mv){
				if($mv['id']==25||$mv['id']==90){//商城
 					$type_where="star_time< now() and end_time> now() and mall_type.if_menu_dispay=1";
					$tcontent=parent::get_data_list($type_where,"group_concat(distinct mall_type.sn_name order by mall_type.queue_number SEPARATOR '、') as name","(select * from mall_products_type_sname order by id desc) mall_type","",0,0,"**");
					$menu_datas[$mk]['content']=count($tcontent)==0?"":$tcontent[0]['name'];
				}else if($mv['id']==3||$mv['id']==91){//直播
 					$type_where="star_time< now() and end_time> now() and mall_type.if_list_dispay=1 and base_f_id=366";
					$tcontent=parent::get_data_list($type_where,"group_concat(distinct mall_type.sn_name order by mall_type.queue_number desc SEPARATOR '、') as name","(select * from video_classify order by id desc) mall_type","mall_type.queue_number desc",0,0,"**");
					$menu_datas[$mk]['content']=count($tcontent)==0?"":$tcontent[0]['name'];
				}else if($mv['id']==19){//点播
 					$type_where="star_time< now() and end_time> now() and mall_type.if_list_dispay=1 and base_f_id=365";
					$tcontent=parent::get_data_list($type_where,"group_concat(distinct mall_type.sn_name order by mall_type.queue_number desc SEPARATOR '、') as name","(select * from video_classify order by id desc) mall_type","",0,0,"**");
					$menu_datas[$mk]['content']=count($tcontent)==0?"":$tcontent[0]['name'];
				}
				$menu_datas[$mk]['content']=empty($menu_datas[$mk]['content'])?"":$menu_datas[$mk]['content'];
			}
		}
		return $menu_datas;
		
    }
    
}