<?php
    class GiftType extends BaseModel {

    public function tableName() {
            return '{{gift_type}}';
    }
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
        'id' => 'ID',
        'code' => '编码:k',
        'name' => '名称:k',
        'interact_type' => '互动方式',
        'interact_type_name' => '互动方式',
        'is_use' => '是否使用',
        'add_time' => '添加时间',
        );
    }


    protected function beforeSave() {
           parent::beforeSave();
            if($this->isNewRecord){
                $this->add_time = date('Y-m-d H:i:s');
            }
            if(!empty($this->interact_type)){
                $interact = BaseCode::model()->find('f_id='.$this->interact_type);
                if(!empty($interact)){
                    $this->interact_type_name = $interact->F_NAME;
                }
            }
            else{
                $this->interact_type_name = '';
            }
            return true;
        }
    }