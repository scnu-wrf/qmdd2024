<?php 
   class BaseNo extends BaseModel { 
    public function tableName() {
        return '{{base_no}}'; //'表序号'
    } 
    public function relations() {
     return array();
    }
    /*** 模型验证规则*/
    public function rules() {
      return $this->attributeRule();
    }
    /** * 属性标签 */
    public function attributeLabels() {
        return $this->getAttributeSet();
    }
    public function attributeSets() {
      return array(
	  'id' =>'ID',
	  'table_name' => '表名称',
	  'table_id' => '表自增ID',
	  'type_id' => '表类型id',
	  'code_project' => '编码前加代码',
	  'code_year' => '年',
	  'code_month' =>'月',
	  'code_day' => '日',
	  'code_gfaccount' => '会员账号',//，服务机构编号，订单编号使用
	  'code_num' => '序号数字',
	  'code_str' => '自动生成',
        );
     }

    public static function model($className = __CLASS__) {
         return parent::model($className);
    }
        
    protected function beforeSave() {
         parent::beforeSave();
         return true;
    }

	public function getNewNo($table){
        $st=str_replace('-','',date('Y-m-d H:i:s'));
        $yy=substr($st,0,4);
        $mm=substr($st,4,2);
        $w1="table_name='".$table."'";
        $w1.=" and code_year='".$yy."' and code_month='".$mm."'";
        $tmp=$this->find($w1);
        if(empty($tmp)){
           $tmp=new BaseNo();
           $tmp->table_name=$table;
           $tmp->code_year=$yy;
           $tmp->code_month=$mm;
           $tmp->save();
        }
        $tmp->code_num+=1;
        $tmp->save();
        return substr($st,0,6).substr('000'.$tmp->code_num,-3);
        //return substr($st,0,6).substr('00000000'.$tmp->code_num,-8);
     } 
     
	public function getAutoNo($table,$account='',$sf='No'){
		return $this->getNosf($table,$sf).$this->getNewNo($table).$account;
	}

	public function getNosf($table,$sf='No'){
        if($table=='testStadium') $sf="CG"; 
        if($table=='testVenue') $sf="CD"; 
        if($table=='testSubsidy') $sf="BTQ"; 
		if($table=='ClubListSqdw') $sf="SQ"; 
		return $sf;
	}
    }