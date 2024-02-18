<?php

class GfApp extends BaseModel {

    public function tableName() {
        return '{{gf_app}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('app_name', 'required', 'message' => '{attribute} 不能为空'),
            array('app_type', 'required', 'message' => '{attribute} 不能为空'),
            array('app_item', 'required', 'message' => '{attribute} 不能为空'),
            array('app_introduce', 'required', 'message' => '{attribute} 不能为空'),
            array('app_type,app_type_name, app_item, app_item_name, app_icon,app_icon_x,app_icon_y,app_icon_w,app_icon_h' ,'safe'),
        );
    }

    public function attributeLabels() {
        return array(
            'app_code' => '编号',
            'app_name'=> '应用名称',
            'app_type'=> '应用类型',
            'app_type_name'=> '应用类型',
            'app_item'=> '应用项目',
            'app_item_name'=> '应用项目',
            'app_icon'=> '图标',
            'app_icon_y' => '图片使用坐标Y轴值',
            'app_icon_x' => '图片使用坐标Y轴值',
            'app_icon_w' => '图片使用宽度',
            'app_icon_h' => '图片使用高度',
            'add_time'=> '添加时间',
            'app_introduce'=> '简介',
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
        $this->add_time = date('Y-m-d H:i:s');
        return true;
    }



}
