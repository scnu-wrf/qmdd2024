<?php
    $mark = array(0=>'☆☆☆☆☆',1=>'★☆☆☆☆',2=>'★★☆☆☆',3=>'★★★☆☆',4=>'★★★★☆',5=>'★★★★★');
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》评价管理》<a class="nav-a">商城评价管理</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div>
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>评价时间：</span>
                    <input style="width:80px;" class="input-text" type="text" id="start" name="start" value="<?php echo $start; ?>">
                    <span>-</span>
                    <input style="width:80px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>">
                </label>
                <label style="margin-right:10px">
                    <span>关键字：</span>
                    <input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入订单号/评价人/商品名称">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
<?php 
    $o_type= QmddAchievemen::model()->findAll('f_type=361');
?>
                    <tr>
                        <th style="text-align: center; width:25px;">序号</th>
                        <th><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('order_num');?></th>
                        <th width="10%">商品信息</th>
                        <?php foreach($o_type as $t){ ?>
                            <th><?php echo $t->f_achid_name;?></th>
                        <?php } ?>
                        <th><?php echo $model->getAttributeLabel('evaluate_info');?></th>
                        <th><?php echo $model->getAttributeLabel('gf_zsxm');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('evaluate_time');?></th>
                        <th><?php echo $model->getAttributeLabel('club_evaluate_info');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $basepath=BasePath::model()->getPath(175);?>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if(!empty($v->club_list)) echo $v->club_list->club_name; ?></td>
                        <td><?php echo $v->order_num; ?></td>
                        <td><?php echo $v->product_title; ?>，<?php echo $v->json_attr; ?></td>
                        <?php foreach($o_type as $t1){ ?>
                        <?php $v1= QmddAchievemenData::model()->find('order_num="'.$v->order_num.'" and product_id='.$v->product_id.' and f_achievemenid='.$t1->f_id); ?>
                            <td><?php if(!empty($v1) && ($v1->f_mark1==0||$v1->f_mark1==1||$v1->f_mark1==2||$v1->f_mark1==3||$v1->f_mark1==4||$v1->f_mark1==5)) echo $mark[$v1->f_mark1]; ?></td>
                        <?php } ?>
                        <td><?php $str1=(strlen($v->evaluate_info)>16) ? substr($v->evaluate_info,0,15) . '...' : $v->evaluate_info;
                        echo $str1; ?></td>
                        <td><?php echo $v->gf_zsxm; ?></td>
                        <td><?php if(!empty($v->evaluate_time))echo $v->evaluate_time; ?></td>
                        <td><?php $str2=(strlen($v->club_evaluate_info)>16) ? substr($v->club_evaluate_info,0,15) . '...' : $v->club_evaluate_info;
                        echo $str2; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('product_gf_update', array('id'=>$v->f_id));?>" title="详情"><i class="fa fa-edit"></i></a>
                            <?php echo show_command('删除',$v->f_id); ?>
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
    var $time_start=$('#start');
    var $time_end=$('#end');
    var end_input=$dp.$('end');
    $time_start.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',onpicked:function(){end_input.click();}});
    });
    $time_end.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd',minDate:"#F{$dp.$D(\'start\')}"});
    });
</script>