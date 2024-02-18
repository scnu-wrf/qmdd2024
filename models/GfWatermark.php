<?php

class GfWatermark extends BaseModel {

    public function tableName() {
        return '{{gf_watermark}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('w_title', 'required', 'message' => '{attribute} 不能为空'),
            array('w_pic', 'required', 'message' => '{attribute} 不能为空'),
            array('club_id', 'required', 'message' => '{attribute} 不能为空'),
            array('w_file_path, w_file_time, watermark_area, dispay_y_area, dispay_x_area', 'safe'),
        );
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'club_list' => array(self::BELONGS_TO, 'ClubList', 'club_id'),
            'base_code' => array(self::BELONGS_TO, 'BaseCode', 'watermark_area'),
        );
    }

    /**
     * 属性标签
     */
    public function attributeLabels() {
        return array(
            'id' => '',
            'gfid' => '管理员',
            'gfaccount' => '管理员帐号',
            'club_id' => '所属单位',
            'w_title' => '水印名称',
            'w_pic' => '水印图片',
            'w_file_path' => '水印路径',
            'w_file_time' => '插入时间',
            'watermark_area' => '显示位置',
            'dispay_y_area' => 'Y轴方向',
            'dispay_x_area' => 'X轴方向',
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

        $this->w_file_time = date('Y-m-d H:i:s');

        if ($this->isNewRecord) {
            $this->gfid = Yii::app()->session['admin_id'];
            $this->gfaccount = Yii::app()->session['gfaccount'];
        }

        return true;
    }

}
