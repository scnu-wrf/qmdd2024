<?php

class BeansHistory extends BaseModel {

    public $count1 = '';
    public $count2 = '';
    public $count3 = '';
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    public function tableName() {
        return '{{beans_history}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'clubname' => array(self::BELONGS_TO, 'ClubList', 'got_beans_clubid'),
            'gfuser' => array(self::BELONGS_TO, 'userlist', 'got_beans_gfid'),
            'gfcredit' => array(self::BELONGS_TO, 'GfCreditHistory', 'gf_credit_id'),
            'baseCode' => array(self::BELONGS_TO, 'BaseCode', 'object'),
        );
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
        'got_beans_code' => '账号',
        'got_beans_name' => '姓名/名称',
        'got_beans_reson' => '事由',
        'got_beans_num' => '得豆数量',
        'consume_beans_num' => '耗豆数量',
        'got_beans_clubid' => '单位',
		'uDate' => '更新时间',
        );
    }

    protected function beforeSave() {
        parent::beforeSave();

        return true;
    }

}
