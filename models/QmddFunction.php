<?php
class QmddFunction extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{qmdd_function}}';
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
        'area_id' => '功能展示区域',  // 如A01,A0101
        'function_icon' => '默认图标:k',  // 路径及命名查base_parh表
        'function_click_icon' => '选中图标',
        'function_title' => '功能名称:k',
        'android_hrer' => '安卓跳转地址',
        'ios_href' => '苹果跳转地址',
        'app_href' => 'app跳转地址',
        'web_href' => 'WEB跳转地址',
        'icon_size' => 'APP图标上传规格',  // （单位：像素），如10*10
        'function_describe' => '功能描述'
        );
      }
    protected function beforeSava() {
        parent::beforeSava();
        return true;
    }
    
}