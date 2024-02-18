<?php

class TRegion extends BaseModel {

    public function tableName() {
        return '{{t_region}}';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
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
        'CODE' => '编号', 
        'level' => '级别',
        'upper_region' => '上级编码:k',
        'country_id' => '国家',
        'country_code' => '地区代码',
        'region_name_e' => '地区英文名',
        'region_name_c' => '地区中文名:k',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
    public function getCode($level) {
        return $this->findAll('level=' . $level);
    }
    public function getLevel() {
        return $this->getCode(1);
    }

    public function getProvinceCode() {
        return $this->getCode(1);
    }

    public function getCityCode() {
        return $this->getCode(2);
    }

    public function getProvinceCodelAll() {
        $cooperation= $this->getCityCode();
        return toArray($cooperation,'id,region_name_c,upper_region');
    }

    public function getCountyAll() {
        $cooperation= $this->getCode(3);
        return toArray($cooperation,'id,region_name_c,upper_region');
    }
    
    public function getStreetAll($upper_region) {
        return $this->findAll('upper_region=' . $upper_region);
    }
    public function getUpper($name,$level) {
        $level2=$level-1;
        $region=TRegion::model()->find('region_name_c="'.$name.'"');
        if(!empty($region)) return $this->findAll('upper_region=' . $region->id);
        
    }
    
    public function getRegionname($code) {
        $cr = new CDbCriteria;
        $cr->condition="id in (".$code.")";
        $cr->select="group_concat(region_name_c separator ' ') as region_name";
        $region=TRegion::model()->find($cr,array(),false);
        if(!empty($region)) return $region['region_name'];
        return '';
    }

    public function getDistrict($pids){
        $tmp=TRegion::model()->findAll("id in(".$pids.")");
        $rs=array('province'=>'','city'=>'','district'=>'');
        foreach($tmp as $k=>$v){
            $s1=$v->region_name_c;
            if($k==0){
                $rs['province']=$s1;
            }elseif($k==1){
                $param['city']=$s1;
            }elseif($k==2){
                $param['district']=$s1;
            }
        }
        return $rs;
    }

    public function getAreaCode($post){
        $rs=$this->testArecCode('' ,$post['level1']);
        $rs=$this->testArecCode($rs,$post['level2']);
        $rs=$this->testArecCode($rs,$post['level3']);
        $rs=$this->testArecCode($rs,$post['level4']);
        return $rs;
    } 

public function selectHead($level) {
   $s1='<select class="area" name="level'.$level.'" id="level'.$level;
   $s1.='" onchange="setAreaList(this)" style="margin-right:10px;">';
   return $s1.'<option value="">请选择</option>';
}

public function selectOption($w1,$level,$id){
    $datas=TRegion::model()->findAll($w1);
    $html=$this->selectHead($level);
    foreach($datas as $v){
        $s0=($v->id==$id) ? ' selected="selected" ' : '';
        $html.='<option value="'.$v->id.'"'.$s0.'>';
        $html.=$v->region_name_c.'</option>';
    }
    return  $html.'</select>'; 
}
// 地区选择
function areaList($id='',$style='',$level=1,$up_level=''){
  if($id==''){
    $html=$this->selectOption('level='.$level,$level,-1);
  }else{
    $html='';
    $data=TRegion::model()->findAll('id in('.$id.')');
    $num=-1;
    foreach($data as $info){
      $s0='level='.$info->level;
      $s0.=($num==-1) ?'' : ' and upper_region='.$data[$num]->id;
      $html.=$this->selectOption($s0,$info->level,$info->id);
      $num++;
    }
  }
  return $html.$this->selectJs();
}
// 地区选择
function selectJs(){
  $html='<script type="text/javascript">
  function setAreaList(obj){
    var show_id=$(obj).val();
    if(show_id>0){
      $.ajax({
        type: "post",
        url: "qmdd/../index.php?r=area/scales&info_id="+show_id,
        dataType: "json",
        success: function(data) {
          console.log(data[0].level)
          if($(obj).attr("id")=="level1"){
            $("#level2,#level3,#level4").remove();
          }
          if($(obj).attr("id")=="level2"){
            $("#level3,#level4").remove();
          }
          if($(obj).attr("id")=="level3"){
            $("#level4").remove();
          }
          var content="";
          content+="<select class="+"area"+" name="+"level"+data[0].level+""+" id="+"level"+data[0].level+""+" onchange="+"setAreaList(this)"+" style="+"margin-right:10px;"+"><option value="+""+">请选择</option>";
          $.each(data,function(k,info){
            content+="<option value="+info.id+">"+info.region_name_c+"</option>"
          })
          content+="</select>";
          $(obj).parent().append(content);
        }
      })
    }
  };
  </script>';
  return $html;
 }
}