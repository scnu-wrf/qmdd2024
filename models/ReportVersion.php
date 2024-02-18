<?php

class ReportVersion extends BaseModel {

    public function tableName() {
        return '{{report_version}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
                array('id,base_f_id,base_name,type,fater_id,version,uDate', 'safe'),
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
            'id'  =>  '内部自增id ',
            'base_f_id'  =>  '信息来源类型ID，关联base_code表REPORT类型ID',
            'base_name'  =>  '举报内容',
            'type'  =>  '举报原因',
            'fater_id'  =>  '父级ID',
            'version'  =>  '举报类型版本',
            'uDate'  =>  '添加时间',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
        if ($this->isNewRecord) {
            $this->uDate=date('Y-m-d H:i:s');
        }
        return true;
    }

  public function getName($id) {
        $rs = $this->find('id=' . $id);
        return  str_replace(' ','',is_null($rs->type) ? "" : $rs->type);
    }


}
