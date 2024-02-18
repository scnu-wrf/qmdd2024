
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>保险管理</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:20px;">
                    <span>保险类型：</span>
                    <select name="Insurance_type">
                        <option value="">请选择</option>
                        <?php foreach($Insurance_type as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('Insurance_type')==$v->id){?> selected<?php }?>><?php echo $v->sn_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:10px;">
                    <span>体检时间</span>
                    <input style="width:120px;" class="input-text" type="text" id="start_date" name="start_date" value="<?php echo Yii::app()->request->getParam('start_date');?>">
                    <span>-</span>
                    <input style="width:120px;" class="input-text" type="text" id="end_date" name="end_date" value="<?php echo Yii::app()->request->getParam('end_date');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('policy_code');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('gf_account');?>/<?php echo $model->getAttributeLabel('gf_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('policy_number');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('insurance_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('insurance_date_star');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('insurance_date_end');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('state');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
               
<?php 
$index = 1;
foreach($arclist as $v){ 
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->policy_code; ?></td>
                        <td><?php echo $v->gf_account; ?>/<?php echo $v->gf_name; ?></td>
                        <td><?php echo $v->policy_number; ?></td>
                        <td><?php echo $v->insurance_type_name; ?></td>
                        <td><?php echo $v->insurance_date_star; ?></td>
                        <td><?php echo $v->insurance_date_end; ?></td>
                        <td><?php echo $v->state_name; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

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
$(function(){
    var $start_time=$('#start_date');
    var $end_time=$('#end_date');
	$start_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss'});});
$end_time.on('click', function(){
WdatePicker({startDate:'%y-%M-%D 00:00:00',dateFmt:'yyyy-MM-dd HH:mm:ss '});});

});
</script>
