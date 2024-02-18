<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>品牌列表</h1></div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>上架状态：</span>
                    <select id="online" name="online">
                        <option value="">请选择</option>
                        <option value="649"<?php if(Yii::app()->request->getParam('online')!==null && Yii::app()->request->getParam('online')!==''  && Yii::app()->request->getParam('online')==649){?> selected<?php }?>>上架</option>
                        <option value="648"<?php if(Yii::app()->request->getParam('online')!==null && Yii::app()->request->getParam('online')!==''  && Yii::app()->request->getParam('online')==648){?> selected<?php }?>>下架</option>
                    </select>
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
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th class="list-id"><?php echo $model->getAttributeLabel('brand_id');?></th>
                        <th><?php echo $model->getAttributeLabel('brand_no');?></th>
                        <th><?php echo $model->getAttributeLabel('brand_logo_pic');?></th>
                        <th><?php echo $model->getAttributeLabel('brand_title');?></th>
                        <th><?php echo $model->getAttributeLabel('brand_date');?></th>
                        <th><?php echo $model->getAttributeLabel('brand_date_begin');?></th>
                        <th><?php echo $model->getAttributeLabel('brand_date_end');?></th>
                        <th><?php echo $model->getAttributeLabel('brand_state');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                   <?php $basepath=BasePath::model()->getPath(167);?>
<?php if (is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->brand_id); ?>"></td>
                        <td><?php echo CHtml::link(CHtml::encode($v->brand_id), array('update', 'brand_id'=>$v->brand_id)); ?></td>
                        <td><?php echo CHtml::link($v->brand_no, array('update', 'id'=>$v->brand_id)); ?></td>
                        <td><?php if(!empty($v->brand_logo_pic)){?><a href="<?php echo $basepath->F_WWWPATH.$v->brand_logo_pic; ?>" target="_blank"><img src="<?php echo $basepath->F_WWWPATH.$v->brand_logo_pic; ?>" style="max-height:50px; max-width:50px;"></a><?php }?></td>
                        <td><?php echo $v->brand_title; ?></td>
                        <td><?php echo $v->brand_date; ?></td>
                        <td><?php echo $v->brand_date_begin; ?></td>
                        <td><?php echo $v->brand_date_end; ?></td>
                        <td><?php $brand_state=array(648=>'下架', 649=>'上架'); echo $brand_state[$v->brand_state]; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->brand_id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->brand_id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
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
var deleteUrl = '<?php echo $this->createUrl('delete', array('brand_id'=>'ID'));?>';
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