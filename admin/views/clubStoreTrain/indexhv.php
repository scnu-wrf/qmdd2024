<?php
    if($_REQUEST['index']==1){
        $title='培训列表';
    }elseif($_REQUEST['index']==2){
        $title='历史列表';
    }
?>
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训管理 》<?= $title;?></h1>
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
                    <span>培训日期：</span>
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
                        <th><?php echo $model->getAttributeLabel('train_code');?></th>
                        <th><?php echo $model->getAttributeLabel('train_title');?></th>
                        <th><?php echo $model->getAttributeLabel('train_type1_id');?></th>
                        <th><?php echo $model->getAttributeLabel('train_type2_id');?></th>
                        <th><?php echo $model->getAttributeLabel('train_project_id');?></th>
                        <th>培训内容</th>
                        <th>费用（元）</th>
                        <th>报名时间</th>
                        <th>培训时间</th>
                        <th><?php echo $model->getAttributeLabel('if_train_live');?></th>
                        <th><?php echo $model->getAttributeLabel('train_clubid');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                            $t_data = ClubTrainData::model()->findAll('train_id='.$v->id);
                            $lb='';$xm='';$nr='';$min=0.00;$max=0.00;
                            if(!empty($t_data)){
                                $min=$t_data[0]->train_money;
                                $max=$t_data[0]->train_money;
                            }
                            foreach($t_data as $i=>$h){
                                if($i<=2){
                                    $ending='';
                                    if(count($t_data)>3&&$i==2){
                                        $ending='...';
                                    }
                                    $lb.=$h->type_name.'<br>'.$ending;
                                    $xm.=$h->project_name.'<br>'.$ending;
                                    $nr.=$h->train_content.'<br>'.$ending;
                                }
                                if($min>$t_data[$i]->train_money){
                                    $min = $t_data[$i]->train_money;
                                }
                                if($max<$t_data[$i]->train_money){
                                    $max = $t_data[$i]->train_money;
                                }
                            }
                            $lb=rtrim($lb, ',');
                            $xm=rtrim($xm, ',');
                            $nr=rtrim($nr, ',');
                    ?>
                    <tr>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->train_code; ?></td>
                        <td><?php echo $v->train_title; ?></td>
                        <td><?php echo $v->train_type1_id_name; ?></td>
                        <td style="max-width:150px;" title="<?= $lb;?>">
                            <?php 
                                echo '<span style="display:inline-block;max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$lb.'</span>';
                            ?>
                        </td>
                        <td style="max-width:150px;" title="<?= $xm;?>">
                            <?php 
                                echo '<span style="display:inline-block;max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$xm.'</span>';
                            ?>
                        </td>
                        <td style="max-width:150px;" title="<?= $nr;?>">
                            <?php 
                                echo '<span style="display:inline-block;max-width: 150px;overflow: hidden;text-overflow: ellipsis;white-space: nowrap;">'.$nr.'</span>';
                            ?>
                        </td>
                        <td><?php echo number_format($min,2).'~'.number_format($max,2); ?></td>
                        <td><?php echo $v->train_buy_start.'<br>'.$v->train_buy_end; ?></td>
                        <td><?php echo $v->train_start.'<br>'.$v->train_end; ?></td>
                        <td><?php if(!is_null($v->online))echo $v->online->F_NAME; ?></td>
                        <td><?php echo $v->train_clubname; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,'disabled'=>'disabled'))); ?>
                            <?php if($_REQUEST['index']==1){?>
                                <a class="btn" href="javascript:;" onclick="we.down('<?php echo $v->id;?>', cancelUrl);" title="下线">下线</a>
                            <?php }?>
                            <a class="btn" href="<?php echo $this->createUrl('clubTrainSign/index_data', array('title'=>$v->id,''));?>" title="报名">报名</a>
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