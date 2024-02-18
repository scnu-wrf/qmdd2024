<?php
class testOrderInfoController extends BaseController{//与模建立联系
    protected $model = '';
    public function init() {
        $this->model = substr(__CLASS__, 0, -10);
        parent::init();
     }

	public function actionDelete($id) {//删除功能
        parent::_clear($id,'','id');
     }

    public function actiongetOrderInfo($code,$name,$phone){
        $criteria=new CDbCriteria;
        $criteria->order='order_date DESC';
        $criteria->addCondition('rec_code='.$code);
        $criteria->addCondition('rec_name="'.$name.'"');
        $criteria->addCondition('rec_phone="'.$phone.'"');
        $info=testOrderInfo::model()->findAll($criteria);
        $data=array();
        $i=0;
        foreach($info as $each){
            $data[$i]['info']=$each;
            $data[$i]['detail']=testOrderDetail::model()->findAll('info_id='.$each->id.' and order_code="'.$each->order_code.'"');
            $i++;
        }
        $i=0;
        echo CJSON::encode($data);
    }

 }