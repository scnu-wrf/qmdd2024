<?php
class ClubStoreType extends BaseModel {

    public function tableName() {
        return '{{club_store_type}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('f_id,code,type,classify,display,fater_id,if_del', 'safe'),
        );
    }
    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'base_f_id' => array(self::BELONGS_TO,'BaseCode','f_id'),
            'is_display' => array(self::BELONGS_TO,'BaseCode','display'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => '编号',
            'type' => '类型',
            'classify' => '类别',
            'display' => '是否展示前端',
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
            $arr[$r]['code'] = $v->code;
            $arr[$r]['type'] = $v->type;
            $arr[$r]['classify'] = $v->classify;
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
