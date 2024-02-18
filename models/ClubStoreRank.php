<?php
class ClubStoreRank extends BaseModel {

    public function tableName() {
        return '{{club_store_rank}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('id,code,type_name,rank_name,fater_id', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '编号',
            'type_name' => '职称类型',
            'rank_name' => '证书等级',
        );
    }

    public function getFater($fater_id='') {
        if($fater_id==''){
            $cooperation= $this->findAll('isnull(fater_id) ');
        }else{
            $cooperation= $this->findAll('fater_id='.$fater_id.' ');
        }
         $arr = array();$r=0;
        foreach ($cooperation as $v) {
            $arr[$r]['id'] = $v->id;
            $arr[$r]['type_name'] = $v->type_name;
            $arr[$r]['rank_name'] = $v->rank_name;
            $r=$r+1;
        }
        return $arr;
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
}
