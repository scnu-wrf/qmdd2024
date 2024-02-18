<?php 
    class StudentInfo extends BaseModel {
        public function tableName() {
            return '{{student_info}}';
        }

        /**
         * 模型验证规则
         */
        public function rules() {
            return array(
                array('club_id,gf_user_id,sc_facult,sc_yeal,sc_code,sc_grade,sc_class', 'safe'),
            );
        }

        /**
         * 模型关联规则
         */
        public function relations() {
            return array(
                'club_name' => array(self::BELONGS_TO,'ClubList','club_id'),
                'gf_user' => array(self::BELONGS_TO,'userlist','gf_user_id'),
            );
        }

        /**
         * 属性标签
         */
        public function attributeLabels() {
            return array(
                'id' => 'ID',
                'club_id' => '社区单位',
                'gf_user_id' => 'GF账号',  // userlist表的id,关联userlist表id
                'sc_facult' => '院系',
                'sc_yeal' => '学年',
                'sc_studentID' => '学号',
                'sc_grade' => '年级',
                'sc_class' => '班级',
                'sc_code' => '邮政编码',
                'sc_address' => '通讯地址',

                'name' => '姓名',
            );
        }

        public function attributes(){
            return array(
                'sc_num' => '序号',
                'sc_facult' => '院系',
                'sc_yeal' => '学年',
                'sc_grade' => '年级',
                'sc_class' => '班级',
                'sc_studentID' => '学号',
                'name' => '姓名',
                'native' => '籍贯',
                'nation' => '民族',
                'sex' => '性别',
                'id_card' => '身份证号码',
                'phone' => '联系电话',
                'email' => '电子邮箱',
                'code' => '邮政编码',
                'address' => '通讯地址',
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

            }
            return true;
        }
    }