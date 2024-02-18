<?php
    if($_REQUEST['index']==1){
        $title='活动列表';
    }elseif($_REQUEST['index']==2){
        $title='历史列表';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》活动管理》<?= $title;?></h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="index" value="<?php echo Yii::app()->request->getParam('index');?>">
                <label style="margin-right:10px;">
                    <span>活动日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'project_id','project_name','project_id'); ?>
                </label>
                <label>
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" id="keywords" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/标题/发布单位">
                </label>
                <button id="submit_button" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('activity_code');?></th>
                        <th><?php echo $model->getAttributeLabel('activity_title');?></th>
                        <th>项目</th>
                        <th>活动内容</th>
                        <th>费用（元）</th>
                        <th>报名时间</th>
                        <th>活动时间</th>
                        <th>状态</th>
                        <th><?php echo $model->getAttributeLabel('activity_online');?></th>
                        <th><?php echo $model->getAttributeLabel('activity_club_name');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                            $pName = ActivityListData::model()->findAll('activity_id='.$v->id);
                            $tx='';
                            $nr='';
                            $min=0.00;
                            $max=0.00;
                            if(!empty($pName)){
                                $min=$pName[0]->activity_money;
                                $max=$pName[0]->activity_money;
                            }
                            foreach($pName as $i=>$h){
                                $tx.=$h->project_name.',';
                                $nr.=$h->activity_content.',';
                                if($min>$pName[$i]->activity_money){
                                    $min = $pName[$i]->activity_money;
                                }
                                if($max<$pName[$i]->activity_money){
                                    $max = $pName[$i]->activity_money;
                                }
                            }
                            $tx=rtrim($tx, ',');
                            $nr=rtrim($nr, ',');
                    ?>
                        <tr>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->activity_code; ?></td>
                            <td title="<?= $v->activity_title;?>"><span style="display:inline-block;max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;"><?php echo $v->activity_title; ?></span></td>
                            <td title="<?= $tx;?>">
                                <?php 
                                    echo '<span style="display:inline-block;max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$tx.'</span>';
                                ?>
                            </td>
                            <td title="<?= $nr;?>">
                                <?php 
                                    echo '<span style="display:inline-block;max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$nr.'</span>';
                                ?>
                            </td>
                            <td><?php echo number_format($min,2).'~'.number_format($max,2); ?></td>
                            <td><?php echo $v->dispay_star_time.'<br>'.$v->sign_up_date_end; ?></td>
                            <td><?php echo $v->activity_time.'<br>'.$v->activity_time_end; ?></td>
                            <td><?php $v->getStateName();?></td>
                            <td><?php if(!is_null($v->online))echo $v->online->F_NAME; ?></td>
                            <td><?php echo $v->activity_club_name; ?></td>
                            <td>
                                <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,'disabled'=>'disabled'))); ?>
                                <a class="btn" href="<?php echo $this->createUrl('activitySignList/index_data', array('title'=>$v->id,''));?>" title="报名">报名</a>
                                <?php echo show_command('删除','\''.$v->id.'\''); ?>
                            </td>
                        </tr>
                    <?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'activity_online','del'=>648,'yes'=>'下线成功','no'=>'下线失败'));?>';

    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
</script>