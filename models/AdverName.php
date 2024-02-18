<?php

class AdverName extends BaseModel {

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function tableName() {
        return '{{adver_name}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
            'mall_product_data' => array(self::BELONGS_TO, 'MallProductData', 'product_data_id'),
        );
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
            'adv_code' => '编码',
            'adv_name' => '名称',
            //'product_data_id' => '收费项目',
            'how_long_dispay' => '切换时间',//多长时间切换显示
            'dispay_time' => '显示时长',
            'dispay_num' => '最大数量',
			'pic_px' => '图片格式要求',
            'if_state' => '人工审核',//是否
        );
    }

    // 返回json数据，键值为id值
    public function getAllJson() {
        $arr = array();
        $adver = $this->findAll();
        foreach ($adver as $v) {
            if (strlen($v->adv_code) == 1) {
                $arr[$v->id]['name'] = $v->adv_name;
                $arr[$v->id]['subitem'] = array();
                foreach ($adver as $v2) {
                    if (strlen($v2->adv_code) > 1 && substr($v2->adv_code, 0, 1) == $v->adv_code) {
                        $arr[$v->id]['subitem'][$v2->id]['name'] = $v2->adv_name;
                    }
                }
            }
        }
        return CJSON::encode($arr);
    }

    // 返回json数据，键值为id值
    public function getByfid($fid) {
        $arr = array();
        $adver = $this->findAll();
        foreach ($adver as $v) {
            $s0=$v->adv_code;
            if (strlen($s0) == 1) {
                $arr[$v->id]['name'] = $v->adv_name;
                $rs = array();
                foreach ($adver as $v2) {
                    $s1=$v2->adv_code;
                    if (strlen($s1) > 1 && substr($s1, 0, 1) == $s0) {
                        $rs[$v2->id] = $v2;
                    }
                }
                $arr[$v->id]['subitem']=$rs;
            }
        }
        return $arr[$fid]['subitem'];
    }

    public function getOne($id) {
        return  $this->find('id=' . $id);
    }

    public function getParentAll() {
        $rs = $this->findAll();
        foreach ($rs as $k => $v) {
            if (strlen($v->adv_code) != 1) {
                unset($rs[$k]);
            }
        }
        return $rs;
    }

    protected function beforeSave() {
        parent::beforeSave();
        $s1=$this->dispay_num;    
        $this->dispay_num= (empty($s1)) ? 1 : $this->dispay_num;
        return true;
    }
	
	public function getPicpx() {
        $tmp= $this->findAll();
        return toIoArray($tmp,'id,adv_name,pic_px');
    }

}
