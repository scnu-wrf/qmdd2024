
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商品分类</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create', array('pid'=> NULL,'sn_name'=> NULL));?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="请输入分类名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <label style="margin-right:10px;">
                    <span>商品分类：</span>
                    <input style="width:200px;" class="input-text" type="text" placeholder="请输入分类编码" name="code" value="<?php echo Yii::app()->request->getParam('code');?>">  
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('tn_code');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('tn_image');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('sn_name');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('if_menu_dispay');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('if_list_dispay');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('if_apply_return');?></th>
                        <th style="text-align:center; width:70px;"><?php echo $model->getAttributeLabel('star_time');?></th>
                        <th style="text-align:center; width:70px;"><?php echo $model->getAttributeLabel('end_time');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
                </thead>
                <tbody>
                <?php $basepath=BasePath::model()->getPath(159);?>
<?php foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo $v->tn_code; ?></td>
                        <td><a href="<?php echo $basepath->F_WWWPATH.$v->tn_image; ?>" target="_blank"><img width="50" src="<?php echo $basepath->F_WWWPATH.$v->tn_image; ?>"></a></td>
                        <td><?php echo $v->sn_name; ?></td>
                        <td><?php if(!empty($v->if_menu_dispay)){ $if_menu_dispay=array(1=>'显示', 2=>'不显示'); echo $if_menu_dispay[$v->if_menu_dispay]; } ?></td>
                        <td><?php if(!empty($v->if_list_dispay)){ $if_list_dispay=array(1=>'显示', 2=>'不显示'); echo $if_list_dispay[$v->if_list_dispay]; } ?></td>
                        <td><?php if(!empty($v->if_apply_return)){ $if_apply_return=array(1=>'支持', 2=>'不支持'); echo $if_apply_return[$v->if_apply_return]; } ?></td>
                        <td><?php echo $v->star_time; ?></td>
                        <td><?php echo $v->end_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
<?php } ?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
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