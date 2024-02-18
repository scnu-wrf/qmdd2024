
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动》培训发布》发布培训</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加','javascript:;','添加','onclick="add_type()"'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
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
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
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
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))); ?>
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
    var data=<?php echo json_encode(toArray($train_type,'id,type'));?>
</script>
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';

    function add_type(){
        var add_html = 
            '<div id="add_format" style="width:500px;">'+
                '<form id="add_form" name="add_form">'+
                    '<table class="list" id="table_tag" style="width:100%;border: solid 1px #d9d9d9;">'+
                        '<tr>'+
                            '<td colspan="2" style="width:25px;padding: 5px;">培训类型&nbsp;&nbsp;</td>'+
                            '<td>'+
                                '<select id="train_type1_id">'+
                                '<option value="">请选择</option>';
                                $.each(data,function(k,info){
                                    add_html+='<option value="'+info.id+'">'+info.type+'</option>'
                                })
                                add_html+='</select>'+
                            '</td>'+
                        '</tr>'+
                    '</table>'+
                '</form>'+
            '</div>';
        if_data=0;
        $.dialog({
            id:'tianjia',
            lock:true,
            opacity:0.3,
            // height: '60%',
            // width:'80%',
            title:'选择类型',
            content:add_html,
            button:[
                {
                    name:'前往添加',
                    callback:function(){
                        if($("#train_type1_id").val()==''){
                            we.msg('minus', '请选择培训类型');
                            return false;
                        }
                        window.location.href="<?php echo $this->createUrl('create'); ?>&train_type1_id="+$("#train_type1_id").val();
                    },
					
                    focus:true
                },
                {
                    name:'取消',
                    callback:function(){
                        return true;
                    }
                }
            ]
        });
        $('.aui_main').css('height','auto');
    }
    
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
                    content+='<option value="'+info.id+'">'+info.classify+'</option>'
                })
                $("#train_classify").html(content);
            }
        });
    }
</script>
