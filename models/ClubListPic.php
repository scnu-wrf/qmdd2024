<?php

class ClubListPic extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{club_list_pic}}';
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
            'club_id' => '单位名称',
			'club_aualifications_pic' => '图片',
        );
    }
	
    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }
  // 保存图集
    public function savePics($cid,$pics) {
        ClubListPic::model()->deleteAll('club_id=' .$cid);
        $tmp= new ClubListPic();
        $list_pic = explode(',', $pics);
        foreach ($list_pic as $v) {
            $tmp->isNewRecord = true;
            unset($tmp->id);
            $tmp->club_id = $cid;
            $tmp->club_aualifications_pic = $v;
            $tmp->save();
        }
    }
    
    public function getPics($club_id){
        $tmp=ClubListPic::model()->findall('club_id='.$club_id);
        $pic='';$b1='';
        foreach ($tmp as $p) {
            $pic.=$b1.$p->club_aualifications_pic;$b1='|';
        }
        return $pic;
    }
}
