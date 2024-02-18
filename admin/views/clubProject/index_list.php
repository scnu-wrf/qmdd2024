<?php //var_dump($_REQUEST);?>
<div class="box">
    <div class="box-title c">
    <h1><i class="fa fa-table"></i>新增项目申请</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="state" value="<?php echo Yii::app()->request->getParam('state');?>">
                <input type="hidden" name="edit_state" value="<?php echo Yii::app()->request->getParam('edit_state');?>">
				<label style="margin-right:20px;">
                    <span>项目：</span>
                    <?php echo downList($project_list,'id','project_name','project_id'); ?>
                </label>
				<label style="margin-right:20px;">
                    <span>类别：</span>
                    <?php echo downList($partnership_type,'f_id','F_NAME','partnership_type'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>申请日期：</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                    	<th style="text-align:center;">序号</th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('club_name');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('p_code');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('partnership_type');?></th>
                        <th style="text-align:center;"><?php echo $model->getAttributeLabel('add_time');?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $basepath=BasePath::model()->getPath(123);?>
					<?php $index = 1;foreach($arclist as $v){ ?>
                    <tr> 	       
                    	<td><span class="num num-1"><?php echo $index; ?></td>
                        <td><?php echo $v->project_name;?></td>
                        <td><?php echo $v->club_name;?></td>
                        <td><?php echo $v->p_code;?></td>
                        <td><?php echo $v->partnership_name;?></td>
                        <td><?php echo substr($v->add_time,0,10); ?></td>
                    </tr>
					<?php $index++; } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID')); ?>';
</script>
<script>
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
    $start_time.on('click', function(){
        var end_input=$dp.$('end_date')
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,onpicked:function(){end_input.click();},maxDate:'#F{$dp.$D(\'end_date\')}'});
    });
    $end_time.on('click', function(){
        WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:false,minDate:'#F{$dp.$D(\'start_date\')}'});
    });
});
</script>