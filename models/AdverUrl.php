<?php
class AdverUrl extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{adver_url}}';//广告关联类型表
    }
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
        'ADV_URL_CODE' => '编码',
        'ADV_URL_NAME' => '名称',
        'ADV_ID' => '位置ID',//,关联adver_name表ID
        'ADV_URL_CODE' => '类型编码',
        'ADV_URL_NAME' => '类型名称',
        'ADV_URL_TABLE' => '来源表',
        'ADV_URL_DATA' => '发布来源属性',
        'ADV_URL_DATA_WHERE' => '发布条件',
        'ADV_URL_WHERE' => '条件语句',//，使用advertiADVER_WHERE字段值替换 [:id]字符串
        'dispay' => '显示方式',//0关 1 显示
        'ADV_URL_FIELD' => '拉取属性',
        'ADV_URL_SHOW' =>'来源属性',
        );
    }

    public function getAll() {
        return $this->findAll('dispay=1');
    }

    // 返回json数据，键值为id值
    public function getAllJson() {
        $rs = $this->findAll('dispay=1');
        $arr =toIoArray($rs,'id,ADV_URL_CODE,ADV_URL_TABLE,ADV_URL_DATA');
        return CJSON::encode($arr);
    }

    // 获取单条数据，表名转换为模型返回
    public function getOne($id, $ismodel = true) {
        $rs = $this->find('id=' . $id);
        if ( !( (!$ismodel)||empty($rs) ) ) {
            $modelName = $rs->ADV_URL_TABLE;
            $arr = explode('_', $modelName);
            $s1 = '';
            foreach ($arr as $v) {
                $s1.=ucfirst($v);
            }
            $rs->ADV_URL_TABLE = $s1;
        } 
        return $rs;
    }

    protected function beforeSave() {
        parent::beforeSave();
        return true;
    }

}
