<?php

class tableUpdate extends BaseModel {

    public function tableName() {
        return '{{table_update}}';//数据修改表里
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
          'id' =>'id',
          'f_field' => '字段名',
          'f_value' => '值',
          'f_data' =>'修改内容',//text,
          'f_time' =>'修改时间',//datetime DEFAULT NULL,
          'f_table' =>'表名字',
          'f_update' =>'更改类型',//修改删除',
          'f_user' =>'操作者',
          'f_ip' =>'修改IP'
        );
    }

protected function update_log($tmp) {
    return 0;
    $dm=$tmp->attributeLabels();
    $key=$tmp->getTableKey($tname);
    $val=$tmp->{$key};
    $tmp2=$tmp->find($key."='".$val."'");
    $data=array();
    foreach($tmp0 as $v)
    {
        $k=$v['Field'];
        if(isset($this->{$k})){
          $s1=$tmp2->{$k};
          $s2=$this->{$k};
          if(!($s1==$s2)){
              $data[$k]=array($s1,$s2);
          }
        }
    }
 //   save_change($tname,0,$data,$key,$val);//0修改 1 删除
  //  save_change_table($tname);
}



function save_change($table,$uptype,$data,$keyname,$keyvalue) {
    if (is_array($data)){
        $data=json_encode($data,JSON_UNESCAPED_UNICODE);
    }
    $test=new Datachange();
    $test->isNewRecord = true;
    $test->f_field=$keyname;
    $test->f_value=$keyvalue;
    $test->f_data=$data;
    $test->f_table=$table;
    $test->f_update=$uptype;
    $test->f_user=Yii::app()->session['TCOD'];
    $test->f_tname=Yii::app()->session['TNAME'];
    $test->f_time=date('Y-m-d H:i:s');

    $test->save();
}
function save_change_table($table) {
    $tmp=Datachangetable::model()->find("f_table='".$table."'");
    if(empty($tmp)){
        $test=new Datachangetable();
        $test->isNewRecord = true;
        $test->f_table=$table;
        $test->save();
    }
}

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}
