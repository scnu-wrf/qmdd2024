<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>省份列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
                <a class="btn" href="<?php echo $this->createUrl('create',array('pid'=>$_REQUEST['pid'],'level'=>$_REQUEST['level'],'country_code'=>$_REQUEST['country_code'],'country_id'=>$_REQUEST['country_id']));?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
            <a style="float:right;"  class="btn" href="<?php echo $this->createUrl('area/index');?>" title="国家列表">国家列表</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pid" value="<?php echo $_REQUEST['pid'];?>">
                <input type="hidden" name="level" value="<?php echo $_REQUEST['level'];?>">
                <input type="hidden" name="country_code" value="<?php echo $_REQUEST['country_code'];?>">
                <input type="hidden" name="country_id" value="<?php echo $_REQUEST['country_id'];?>">
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
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th >序号</th>
                        <th><?php echo $model->getAttributeLabel('CODE');?></th>
                        <th><?php echo $model->getAttributeLabel('country_code');?></th>
                        <th><?php echo $model->getAttributeLabel('region_name_e');?></th>
                        <th><?php echo $model->getAttributeLabel('region_name_c');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                
<?php 
$index = 1;
$country_code = !empty($_GET["country_code"])?$_GET["country_code"]:null;
foreach($arclist as $v){ 
    if($country_code == $v->country_code){
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->CODE; ?></td>
                        <td><?php echo $v->country_code; ?></td>
                        <td><?php echo $v->region_name_e; ?></td>
                        <td><?php echo $v->region_name_c;?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('index',array('pid'=>$v->id,'level' => $v->level+1,'country_code' =>$v->country_code,'country_id'=>$_REQUEST['country_id']));?>" title="下级省份">地区列表</a>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

                        </td>
                    </tr>
<?php $index++; } }?>
                </tbody>
            </table>
        </div><!--box-table end-->
        
        <div class="box-page c">
        <?php
        
            $this->page($pages);
        
        ?>
        </div>
        
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
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