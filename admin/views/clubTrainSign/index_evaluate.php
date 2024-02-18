<?php
    $mark = array(1=>'★☆☆☆☆',2=>'★★☆☆☆',3=>'★★★☆☆',4=>'★★★★☆',5=>'★★★★★');
    $club_f_mark = array(1=>'★☆☆☆☆',2=>'★★☆☆☆',3=>'★★★☆☆',4=>'★★★★☆',5=>'★★★★★');
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训评价 》评价列表</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div>
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>起始时间：</span>
                    <input style="width:120px;" class="input-text" type="text" id="star" name="star" value="<?php echo $star; ?>" placeholder="评价时间">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end" name="end" value="<?php echo $end; ?>" placeholder="评价时间">
                </label>
                <label style="margin-right:10px">
                    <span>关键字：</span>
                    <input type="text" style="width:200px;" class="input-text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入服务流水号/评价人">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list" style="table-layout: fixed;">
                <thead>
<?php 
    $o_type= QmddAchievemen::model()->findAll('f_type=354 order by f_code ASC');
?>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('service_order_num');?></th>
                        <th>培训标题</th>
                        <th>培训内容</th>
                        <?php foreach($o_type as $t){ ?>
                            <th><?php echo $t->f_achid_name;?></th>
                        <?php } ?>
                        <th style="width: 300px;"><?php echo $model->getAttributeLabel('evaluate_info');?></th>
                        <th><?php echo $model->getAttributeLabel('gf_zsxm');?></th>
                        <th><?php echo $model->getAttributeLabel('evaluate_time');?></th>
                        <th>单位回复</th>
                        <th><?php echo $model->getAttributeLabel('club_f_mark');?></th>
                        <th>操作</th>
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
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->service_order_num; ?></td>
                        <td><?php echo $v->service_name; ?></td>
                        <td><?php echo $v->service_data_name; ?></td>
                        <?php if(!empty($eval_list))foreach($eval_list as $v1){ ?>
                            <td><?php if($v1->f_mark1==1||$v1->f_mark1==2||$v1->f_mark1==3||$v1->f_mark1==4||$v1->f_mark1==5)echo $mark[$v1->f_mark1]; ?></td>
                        <?php } ?>
                        <td style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" title="<?php echo $v->evaluate_info; ?>"><?php echo $v->evaluate_info; ?></td>
                        <td><?php echo $v->gf_account.'/'.$v->gf_zsxm; ?></td>
                        <td>
                            <?php 
                                $left = substr($v->evaluate_time,0,10);
                                $right = substr($v->evaluate_time,11);
                                echo $left.'<br>'.$right;
                            ?>
                        </td>
                        <td style="overflow: hidden;white-space: nowrap;text-overflow: ellipsis;" title="<?php echo $v->club_evaluate_info; ?>"><?php echo $v->club_evaluate_info; ?></td>
                        <td><?php if($v1->club_f_mark>=1&&$v1->club_f_mark<=5)echo $club_f_mark[$v1->club_f_mark]; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('evaluate_details', array('id'=>$v->f_id))); ?>
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