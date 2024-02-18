
<div class="box">
    <a class="btn" href="javascript:;" onclick="we.reload();" style="vertical-align: middle;float: right; margin-right: 10px;"><i class="fa fa-refresh"></i>刷新</a>
    <div class="box-title c"><h1>当前界面：会员 》会员设置 》龙虎理论考题设置</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加类型</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
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
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('member_type_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('project_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('grade_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('questions_528type_num');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('questions_529type_num');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('questions_530type_num');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('udate');?></th>
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
                        <td style='text-align: center;'><?php echo $v->member_type_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->project_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->grade_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->questions_528type_num; ?></td>
                        <td style='text-align: center;'><?php echo $v->questions_529type_num; ?></td>
                        <td style='text-align: center;'><?php echo $v->questions_530type_num; ?></td>
                        <td style='text-align: center;'><?php echo $v->add_time; ?></td>
                        <td style='text-align: center;'><?php echo $v->udate; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('dragonTigerAnswer/index',array('pid' => $v->id ));?>" title="录入属性列表">题目列表</a>
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
</script>
