<?php 
  if(empty($model->dispay_type)){ $model->dispay_type=0; }
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>功能自定义列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入功能名称">
                </label>
                <label style="margin-right:20px;">
                    <span>按区域：</span>
                    <select name="function_area_id">
                        <option value="">请选择</option>
                        <?php foreach($function_area_id as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('function_area_id')!=null && Yii::app()->request->getParam('function_area_id')==$v->id){?> selected<?php }?>><?php echo $v->area_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <label style="margin-right:20px;">
                    <span>使用单位：</span>
                    <select name="club_id">
                        <option value="">请选择</option>
                        <?php foreach($club_id as $v){?>
                        <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('club_id')!=null && Yii::app()->request->getParam('club_id')==$v->id){?> selected<?php }?>><?php echo $v->club_name;?></option>
                        <?php }?>
                    </select>
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('set_code');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('function_area_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('function_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('club_id');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('dispay_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('if_user');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('dispay_star_time');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('dispay_end_time');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php $basepath=BasePath::model()->getPath(176);?>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><?php echo $v->set_code; ?></td>
                        <td style='text-align: center;'><?php echo $v->qmdd_function_area->area_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->qmdd_function->function_describe; ?></td>
                        <td style='text-align: center;'><?php if($v->club_list!='')echo $v->club_list->club_name; ?></td>
                        <!--<td style='text-align: center;'><?php if($v->base_code_dispay_type!=null){ echo $v->base_code_dispay_type->F_NAME; } ?></td>-->
                        <td style='text-align: center;'>
                            <?php if(!empty($v->dispay_type)){
                                $types = BaseCode::model()->findAll('f_id in('.$v->dispay_type.')');
								foreach($types as $names){ 
									echo $names->F_NAME.' ';
                                }
							} ?>
                        </td>
                        <td style='text-align: center;'><?php if($v->if_user==null) echo $v->if_user; else if('base_code_if_user'!=null) echo $v->base_code_if_user->F_NAME; ?></td>
                        <td style='text-align: center;'><?php echo $v->dispay_star_time; ?></td>
                        <td style='text-align: center;'><?php if($v->dispay_end_time=='0000-00-00 00:00:00') {echo $v->dispay_end_time=='';}else echo $v->dispay_end_time; ?></td>
                        <td style='text-align: center;'>
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
