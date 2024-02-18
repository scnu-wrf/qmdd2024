
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》培训发布 》发布审核 》取消/审核未通过列表</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>审核日期：</span>
                    <input style="width:100px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo $start_date;?>">
                    <span>-</span>
                    <input style="width:100px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo $end_date;?>">
                </label>
				<label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($train_type,'id','type','train_type','onchange="changeData(this)"'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>类别：</span>
                    <?php echo downList($train_classify,'id','classify','train_classify','id="train_classify" style="min-width:94px;"'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'project_id','project_name','project_id'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入编号/标题" >
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
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
                        <th><?php echo $model->getAttributeLabel('train_clubid');?></th>
                        <th>审核状态</th>
                        <th><?php echo $model->getAttributeLabel('audit_time');?></th>
                        <th><?php echo $model->getAttributeLabel('train_state_adminid');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
<?php $index = 1;foreach($arclist as $v){
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
                        <td><?php echo date('Y-m-d',strtotime($v->train_buy_start)).'<br>'.date('Y-m-d',strtotime($v->train_buy_end)); ?></td>
                        <td><?php echo $v->train_start.'<br>'.$v->train_end; ?></td>
                        <td><?php echo $v->train_clubname; ?></td>
                        <td><?php echo $v->train_state_name; ?></td>
                        <td><?php echo date('Y-m-d',strtotime($v->audit_time)); ?></td>
                        <td><?php echo $v->train_state_adminname; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id,'disabled'=>'disabled'))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>
                        </td>
                    </tr>
<?php $index++; } ?>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c"><?php $this->page($pages);?></div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    $end_time.on('click', function(){
         WdatePicker({startDate:'%y-%M-%D',dateFmt:'yyyy-MM-dd'});
    });
    
    function changeData(obj) {
        var show_id = $(obj).val();
        var content='<option value="">请选择</option>';
        $("#train_classify").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getListData'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'" ';
                    // if(query_content==info.id){
                    //     content+='selected = "selected"';
                    // }
                    content+='>'+info.classify+'</option>'
                })
                $("#train_classify").html(content);
            }
        });
    }
</script>
