<?php

class GfMaterial extends BaseModel {

    public function tableName() {
        return '{{gf_material}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('gfid', 'numerical', 'integerOnly' => true),
            array('gfaccount,club_id,group_id,v_type,v_title,v_pic,'
                . 'v_name,v_file_md5,v_file_path,v_file_size,v_file_sy,v_file_zt,'
                . 'v_file_insert_size,v_file_time,v_file_key', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'gf_material_group' => array(self::BELONGS_TO, 'GfMaterialGroup', 'group_id'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'gfid' => '管理员',
            'gfaccount' => '管理员帐号',
            'club_id' => '所属单位',
            'group_id' => '分组',
            'v_type' => '素材类型',
            'v_title' => '素材标题',
            'v_pic' => '素材封面',
            'v_name' => '文件名',
            'v_file_md5' => '校验码',
            'v_file_path' => '文件路径',
            'v_file_size' => '文件大小',
            'v_file_sy' => '是否被使用',
            'v_file_zt' => '是否保存完成',
            'v_file_insert_size' => '视频时长',
            'v_file_time' => '最后插入时间',
            'v_file_key' => '文件key',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function getNum($group_id, $type) {
        return $this->count('group_id=' . $group_id . ' AND v_type=' . $type);
    }

    protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->gfid = Yii::app()->session['admin_id'];
            $this->gfaccount = Yii::app()->session['gfaccount'];
            $this->club_id = Yii::app()->session['club_id'];
        }
        $this->v_file_time = date('Y-m-d H:i:s');

//        if (check_file_exists($this->v_file_path . $this->v_name)) {
//            $this->v_file_md5 = md5_file($this->v_file_path . $this->v_name);
//        }

        return true;
    }

}
