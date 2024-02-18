
<div class="box">
    <div class="box-title c">
        <h1>当前界面：培训/活动 》课程发布 》待审核列表</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($course_type,'id','type','course_type','onchange="changeData(this)"'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>类别：</span>
                    <?php echo downList($course_classify,'id','classify','course_classify','id="course_classify" style="min-width:94px;"'); ?>
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
                        <th><?php echo $model->getAttributeLabel('course_code');?></th>
                        <th><?php echo $model->getAttributeLabel('course_title');?></th>
                        <th><?php echo $model->getAttributeLabel('course_type2_id');?></th>
                        <th><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th>费用（元）</th>
                        <th>显示时间</th>
                        <th><?php echo $model->getAttributeLabel('is_online');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
<?php $index = 1;foreach($arclist as $v){?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->course_code; ?></td>
                        <td><?php echo $v->course_title; ?></td>
                        <td><?php echo $v->course_type2_name; ?></td>
                        <td><?php echo $v->project_name; ?></td>
                        <td><?php echo number_format($v->course_money,2); ?></td>
                        <td><?php echo $v->dispay_star_time.'<br>'.$v->dispay_end_time; ?></td>
                        <td><?php if(!is_null($v->online))echo $v->online->F_NAME; ?></td>
                        <td>
                            <?php echo show_command('详情',$this->createUrl('update', array('id'=>$v->id,'index'=>'submit','disabled'=>'disabled'))); ?>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancelUrl);" title="撤销">撤销</a>
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
    var cancelUrl = '<?php echo $this->createUrl('cancel', array('id'=>'ID','new'=>'state','del'=>721,'yes'=>'撤销成功','no'=>'撤销失败'));?>';
    
    function changeData(obj) {
        var show_id = $(obj).val();
        var content='<option value="">请选择</option>';
        $("#course_classify").html(content);
        $.ajax({
            type: 'post',
            url: '<?php echo $this->createUrl('getListData'); ?>',
            data: {id: show_id},
            dataType: 'json',
            success: function(data) {
                $.each(data,function(k,info){
                    content+='<option value="'+info.id+'">'+info.classify+'</option>'
                })
                $("#course_classify").html(content);
            }
        });
    }
</script>
