<?php

class DirectShoppers extends BaseModel {

   public $project_list = "";

    public function tableName() {
        return '{{direct_shoppers}}';
    }

    /**
     * 模型验证规则
     */
    public function rules() {
        return array(
            array('project_list', 'required', 'message' => '{attribute} 不能为空'),
            array('club_star', 'required', 'message' => '{attribute} 不能为空'),
            array('synthesize_num,profession_num,single_profession_num,digital_synthesize_num,digital_profession_num,digital_single_profession_num,shopping_days', 'numerical', 'integerOnly' => true),
      

            array('project_id,club_star,club_star_name,synthesize_num,profession_num,single_profession_num,digital_synthesize_num,digital_profession_num,digital_single_profession_num,shopping_days' ,'safe'),
        );
    }


    public function attributeLabels() {
        return array(

            'project_id'=>'项目',
            'project_list'=>'项目',
            'club_star'=>'单位星级',
            'club_star_name'=>'等级名称',
            'synthesize_num'=>'实物商品综合类导购窗口数量',//'实物综合商品导购窗口数量',
            'profession_num'=>'实物商品专业类导购窗口数量',//'实物专业商品导购窗口数量',
            'single_profession_num'=>'实物商品专业类单个窗口件数',//'实物单件专业商品导购件数',
            'digital_synthesize_num'=>'数字综合类导购窗口数量',//'数字综合商品导购窗口数量',
            'digital_profession_num'=>'数字专业类导购窗口数量',//'数字专业商品导购窗口数量',
            'digital_single_profession_num'=>'数字专业类单个窗口件数',//'数字单件专业商品导购件数',
            'shopping_days'=>'可导购天数',

        );
    }


    /**
     * 模型关联规则
     */
    public function relations() {
        return array(

           'p_id' => array(self::BELONGS_TO, 'ProjectList', array('project_id' => 'id')),

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

        return true;
    }



}
