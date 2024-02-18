<?php

class brandlist extends BaseModel {

    public $project_list = '';

    public function tableName() {
        return '{{mall_brand_street}}';
    }

    /**
     * 模型关联规则
     */
    public function relations() {
        return array(
		'mall_brand_project' => array(self::HAS_MANY, 'MallBrandProject', 'brand_id'),
		'qmdd_administrators' => array(self::BELONGS_TO, 'QmddAdministrators', 'f_user_id'),
            
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
            'project_list' => '项目',
            'brand_id' => 'ID',
            'brand_no' => '编号',
            'brand_logo_pic' => '品牌LOGO',
			'brand_date' => '提交日期',
            'brand_title' => '品牌名称',
            'brand_date_begin' => '上架时间',
            'brand_date_end' => '下架时间',
            'brand_state' => '上架状态',
            'brand_content' => '品牌描述',
        );
    }


    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    protected function beforeSave() {
        parent::beforeSave();
		
		 // 图片处理，判断是否已上传到临时文件夹
        $tempPath = ROOT_PATH . '/uploads/temp/';
        $datePath = 'mall' . '/' . 'brand' . '/';
        $pic = $this->brand_logo_pic;
        $basepath = BasePath::model()->getPath(116);
        $savepath = $basepath->F_PATH;
        if ($basepath != null) {
            if (!empty($pic) && file_exists($tempPath . $pic) && !file_exists($savepath . $datePath . $pic)) {
                if (!is_dir($savepath . $datePath)) {
                    mk_dir($savepath . $datePath);
                }
                rename($tempPath . $pic, $savepath . $datePath . $pic);
                $this->brand_logo_pic = $datePath . $pic;
            } 
        }

        if ($this->isNewRecord) {
            if (empty($this->brand_no)) {
                // 生成编号
				$brand_no = '';
                $brand_no.=date('Y');
				$brand_no.=date('m');
				$brand_no.=date('d');
				$brand_no_start = $brand_no . '0000';
				$count = $this->count('brand_no>' . $brand_no_start);
				if ($count>0) {
					$no = intval($this->max(brand_id));
				}
				$code = substr('0000' . strval($count + 1), -4);
				$brand_no.=$code;
                $this->brand_no = $brand_no;
            }
			$this->brand_date = date('Y-m-d');
        }
        $this->f_user_id = Yii::app()->session['admin_id'];
        $this->f_user_name = Yii::app()->session['gfnick'];
        $this->f_userdate = date('Y-m-d h:i:s');

//        if (Yii::app()->session['club_id'] != 1) {
//            unset($this->is_dispay);
//            unset($this->state);
//        }
        return true;
    }

}
