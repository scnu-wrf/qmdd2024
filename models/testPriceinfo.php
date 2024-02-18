<?php

class testPriceinfo extends BaseModel {

    public function tableName() {
        return '{{test_price_info}}';
    }

     /*** Returns the static model of the specified AR class. */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    /**  * 模型关联规则  */
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
      'id' => 'ID',
      'code' => '编码:k',
      'name' =>'策略名称:k',
      'clubcode'=> '社区编码',
      'clubname' =>'社区名称',
      'place_type' =>'场地类型',
      'policy_id' => '时间策略编号',
      'policy_name' => '时间策略名称',
      'memo' => '备注',
        );
    }

  public function setDefaultValue() {
      $relations='clublist,clubcode:club_code,clubname:club_name;';
      //$relations.='clublist,clubcode:club_code,clubname:club_name;';
      //$relations.='clublist,clubcode:club_code,clubname:club_name';
      $rs=array(
      'sess'=>'',//保持登录信息
      'date'=>'',//保存修改
      'def_sess'=>'',//保持第一次操作信息
      'def_date'=>'',//保存地一次修改信息
      'pcipath'=>'',//属性名:模型名称，模型空取上一个模型
      'relations'=>$relations//关联取值
      );
      return $rs;
    } 
  //public function picLabels() {return 'subpic';}
  //public  function pathLabels(){ return '';}
   /* 用于列表查询使用，三个参数分别是  1 条件 2 是排序 三是或取值，格式 变量[：变量]*/
    public function keySelect(){
        return array('1','code','code:name');
   }

    protected function beforeSave() {
        parent::beforeSave();
         //$relations='clublist,clubcode:club_code,clubname:club_name;';
        
         //$w1='club_code="'.$this->clubcode.'"';
         //$this->clubname=clublist::model()->readValue($w1,'club_name');
        return true;
    }
}
