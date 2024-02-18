<?php

class QmddAchievemenData extends BaseModel {
    public function tableName() {
        return '{{qmdd_achievemen_data}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
                array('f_id,order_num,gf_id,gf_account,gf_zsxm,product_id,product_code,product_title,product_data_id,is_dispay,club_f_mark,club_f_mark_name,club_evaluate_info,club_evaluate_time,servic_f_mark,servic_f_mark_name,servic_evaluate_info,servic_evaluate_time,add_date,gf_service_data_id,service_order_num', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'orderNum'=>array(self::BELONGS_TO,'GfServiceData',array('gf_service_data_id'=>'id')),
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'f_id'=>'ID',
            'order_num'=>'订单号',
            'order_type'=>'订单类型',
            'order_type_name'=>'订单类型',
            'order_num_id'=>'订单ID',
            'gf_id'=>'评价人的ID',
            'gf_account'=>'评价人帐号',
            'gf_zsxm'=>'评价人',
            'product_id'=>'商品id',
            'product_code'=>'商品编号',
            'product_title'=>'商品标题',
            'product_data_id'=>'商品属性id',
            'json_attr'=>'属性名称',
            'club_id'=>'所属商家',
            'qua_id'=>'服务者ID',
            'logistics_id'=>'物流公司ID',
            'service_id' => '购买的实际服务产品id',
            'service_code' => '服务编号',
            'service_ico' => '服务产品图标全路径',
            'service_name' => '服务名称',
            'service_data_id' => '服务产品属性ID',
            'service_data_name' => '服务产品属性名',
            'gf_id' => '参与评价人的ID',
            'gf_account' => '帐号',
            'gf_zsxm' => '评价人',
            'f_achievemenid' => '评价项目ID',  // qmdd_achievemen的f_id',
            'f_achievemen_name' => '评价项目名称',
            'f_data_id' => '评价的项目',  // 关联base_code表OBJECT类型
            'f_mark1'=>'用户评分',
            'f_mark1_name'=>'评分评语',
            'evaluate_info'=>'评价内容',
            'evaluate_img'=>'用户评价图片',
            'evaluate_time'=>'评价时间',
            'club_f_mark'=>'对用户评价',
            'club_f_mark_name'=>'单位对用户评语',
            'club_evaluate_info'=>'商家回复',  // 限制文字在120字以内
            'club_evaluate_time' => '单位评价时间',
            'is_dispay' => '是否显示前端',  // 关联base_code表yes_no类型id 648=否，649是',
            'is_dispay_name' => '是否显示说明',
            'gf_service_data_id' => '我的服务ID',  // 对应表gf_service_data的id',
            'servic_f_mark'=>'服务者对用户评星',
            'servic_f_mark_name'=>'服务者对用户评语',
            'servic_evaluate_info'=>'服务者评价描述',  // 限制文字在120字以内
            'servic_evaluate_time' => '服务者评价时间',
            'add_date' => '评价时间',
            'service_order_num' => '服务流水号',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        return true;
    }

 
	public function getServertype() {
		return $this->findAll('if_del=510');
    }
    
    /**
     * 评价列表
     * 根据类型、产品id获取已评价信息列表
     * 满意度=（好评*100*好评数+中评*70*中评数）／评价总数
     */
    public function getEvaluateList($param){
		checkArray($param,'visit_gfid,order_type,product_id,comment_type,page,per_page',1);
        $gfid=$param['visit_gfid'];//gfid
		$order_type = $param['order_type'];
		$product_id = $param['product_id'];
		$comment_type = $param['comment_type'];
		$page = $param['page'];
		$pageSize = $param['per_page'];
		
		$data =get_error( 1,'获取失败');
		$where = "t.is_dispay=649 and t.IFNULL(t.f_mark1,0)>0  and t.order_type=".$order_type;
		if($order_type==361){//商品
			global $p_products;
			$product=MallProducts::model()->find("id=".$product_id);
			if(empty($product)){
				set_error($data,1,"获取失败",1);
			}
			$product_len=MallProducts::model()->product_len;
			$where .= " and left(t.product_code,{$product_len})=left('".$product->product_code."',{$product_len})";
		}else if($order_type==353){//动动约
			checkArray($param,'server_type',1);
			$server_type = $param['server_type'];
		 	$where = get_where($where, $server_type, "t.service_type", $server_type);
			if($server_type==1){//场地
		 		$where = get_where($where, $product_id, "t.service_parent_id", $product_id);
			}else{
		 		$where = get_where($where, $product_id, "t.service_id", $product_id);
			}
		}else{
		 	$where = get_where($where, $product_id, "t.service_id", $product_id);
		}
		//根据类型获取评价项目设置，满意度
        $cr = new CDbCriteria;
        $cr->condition="f_type=".$order_type;
        $cr->select="f_achid,f_achid_name,f_mark";
		$eva_set=QmddAchievemen::model()->findAll($cr,array(),false);
		if(empty($eva_set)){
			set_error($data,1,"获取失败",1);
		}
		foreach($eva_set as $ek=>$ev){
			$swhere = $where." and t.f_data_id=".$ev['f_achid'];
			$where1=$swhere." and t.f_mark1 in(4,5) ";
            $gcount = Yii::app()->db->createCommand('select count(*) as countq from qmdd_achievemen_data t where '.$where1)->queryAll();
			$eva_set[$ek]['good_count'] = !empty($gcount)&&$gcount[0]['countq']>0?$gcount[0]['countq']:0;
			$where2=$swhere." and t.f_mark1 in(2,3)";
            $mcount = Yii::app()->db->createCommand('select count(*) as countq from qmdd_achievemen_data t where '.$where2)->queryAll();
			$eva_set[$ek]['middle_count'] = !empty($gcount)&&$mcount[0]['countq']>0?$mcount[0]['countq']:0;
			$where3=$swhere." and t.f_mark1 in(1)";
            $ncount = Yii::app()->db->createCommand('select count(*) as countq from qmdd_achievemen_data t where '.$where3)->queryAll();
			$eva_set[$ek]['neg_count'] = !empty($gcount)&&$ncount[0]['countq']>0?$ncount[0]['countq']:0;
			$eva_set[$ek]['total_count'] = $eva_set[$ek]['good_count']+$eva_set[$ek]['middle_count']+$eva_set[$ek]['neg_count'];
			$like_percent=$eva_set[$ek]['total_count']>0?($eva_set[$ek]['good_count']*100+$eva_set[$ek]['middle_count']*70)/($eva_set[$ek]['total_count']):0;
			$eva_set[$ek]['like_percent']=$like_percent>0?$like_percent.'%满意':'';
			$percent=$ev['f_mark']==0?0:100/$ev['f_mark'];
			$eva_set[$ek]['like_mark'] =$percent>0?$like_percent/$percent:0;
			if($ev['f_achid']==800){
				$data['good_count'] = $eva_set[$ek]['good_count'];
				$data['middle_count'] = $eva_set[$ek]['middle_count'];
				$data['neg_count'] = $eva_set[$ek]['neg_count'];
				$data['total_count'] = $eva_set[$ek]['total_count'];
				$data['percent'] = $like_percent;
				$eva_set[$ek]['f_achid_name'] ='服务综合评分';
			}else{
				$eva_set[$ek]['f_achid_name'] ='单位综合评分';
			}
		}
		$data['eva_datas']=$eva_set;
		$page = $page > 0 ? $page : 1;
		$pageSize = $pageSize > 1 ? $pageSize : 10;
		$page = ($page -1) * $pageSize;
		
		
        $cr = new CDbCriteria;
        $cr->condition=$where.' and t.f_data_id=800';
        $pages = new CPagination($eva_set[$ek]['total_count']);
        $pages->pageSize = $pageSize;
        $pages->applylimit($cr);
        $cr->join=" left join userlist as gf on gf.gf_id=t.gf_id";
		$cr->order="t.f_id desc";
        $path_www=getShowUrl('file_path_url');
        $cr->select="t.gf_id,gf.TXNAME as gf_icon,gf.gf_account,gf.gf_name,t.f_id as id,t.f_mark1,IFNULL(t.evaluate_info,'') as evaluate_info,IFNULL(t.evaluate_img,'') as evaluate_img,IFNULL(t.evaluate_time,'') as evaluate_time,IFNULL(t.show_service_data_title,t.json_attr) as json_attr,t.order_date";
        $list=$this->findAll($cr,array(),false);
		foreach($list as $k=>$v){
			$list[$k]["gf_icon"]=CommonTool::model()->addto_url_dir($path_www,$v["gf_icon"],",","");
			$list[$k]["evaluate_img"]=CommonTool::model()->addto_url_dir($path_www,$v["evaluate_img"],"|");
			$list[$k]["club_reply_html"]='';//新增业务，单位回复内容；如'<b>单位回复：</b><br/><font color=\"#808080\">回复内容信息</font>'
			$list[$k]["order_date"]=date("Y-m-d",strtotime($v['order_date']));
		}
		$data['datas']=$list;
		$data['comment_type']=array(array('id'=>0,'name'=>'全部('.$data['total_count'].')'),array('id'=>1,'name'=>'好评('.$data['good_count'].')'),array('id'=>2,'name'=>'中评('.$data['middle_count'].')'),array('id'=>3,'name'=>'差评('.$data['neg_count'].')'));
		set_error($data,0,"获取成功",1);
    }
	/**
	 * 用户删除自己发表的评价
	 * 逻辑删除 if_del=509
	 */
	function DelEvaluate($param){
		checkArray($param,'visit_gfid,id',1);
		$eva=$this->find('gf_id='.$param['visit_gfid'].' and id='.$param['id']);
		$data =get_error( 1,'删除失败');
		if(empty($eva)){
			set_error($data,1,"数据异常",1);
		}else{
			$eva->if_del=509;
			$res=$eva->update($eva);
			set_error_tow($data,$res,0,'删除成功',0,'删除失败',1);
		}
	}
    
}
