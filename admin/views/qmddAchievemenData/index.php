<?php
    $mark = array(1=>'★☆☆☆☆',2=>'★★☆☆☆',3=>'★★★☆☆',4=>'★★★★☆',5=>'★★★★★');
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>服务评价</h1></div>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px">
                    <span>关键字：</span>
                    <input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入服务流水号/评价人/服务名称">
                </label>
                <!-- <label style="margin-right:20px;">
                    <span>订单类型：</span>
                    <select id="order_type" name="order_type">
                        <option value="">请选择</option>
                        <?php //foreach($order_type_list as $v){?>
                        <option value="<?php //echo $v->f_id;?>"<?php //if(Yii::app()->request->getParam('order_type')==$v->f_id){?> selected<?php //}?>><?php //echo $v->F_NAME;?></option>
                        <?php //}?>
                    </select>
                </label> -->
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list" style="table-layout: fixed;">
                <thead>
<?php 
    $o_type= QmddAchievemen::model()->findAll('f_type=353');
?>
                    <tr>
                        <th style="text-align: center;">序号</th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_order_num');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('service_name');?></th>
                        <!-- <th style="text-align: center;">服务者评价</th>
                        <th style="text-align: center;">服务质量评价</th> -->
                        <?php foreach($o_type as $t){ ?>
                            <th style="text-align: center;"><?php echo $t->f_achid_name;?></th>
                        <?php } ?>
                        <th style="text-align: center;width: 300px;"><?php echo $model->getAttributeLabel('evaluate_info');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('evaluate_time');?></th>
                        <th style="text-align: center;"><?php echo $model->getAttributeLabel('gf_zsxm');?></th>
                        <th style="text-align: center;">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $basepath=BasePath::model()->getPath(175);?>
<?php 
$index = 1;
foreach($arclist as $v){
    if(!empty($v->gf_service_data_id))$eval_list= QmddAchievemenData::model()->findAll('gf_service_data_id='.$v->gf_service_data_id);
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style="text-align: center"><?php echo $v->service_order_num; ?></td>
                        <td style="text-align: center"><?php echo $v->service_name; ?></td>
                        <?php if(!empty($eval_list))foreach($eval_list as $v1){ ?>
                            <td style="text-align: center"><?php if($v1->f_mark1==1||$v1->f_mark1==2||$v1->f_mark1==3||$v1->f_mark1==4||$v1->f_mark1==5)echo $mark[$v1->f_mark1]; ?></td>
                        <?php } ?>
                        <td style="text-align: center;overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" title="<?php echo $v->evaluate_info; ?>"><?php echo $v->evaluate_info; ?></td>
                        <td style="text-align: center"><?php echo $v->evaluate_time; ?></td>
                        <td style="text-align: center"><?php echo $v->gf_zsxm; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->f_id));?>" title="详情"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
<?php $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>