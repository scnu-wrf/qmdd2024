<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>会员列表</h1></div><!--box-title end-->
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
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('card_code');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('mamber_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('card_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('up_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('if_project');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
					<?php 
                    $index = 1;
                    foreach($arclist as $v){ 
                    ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->f_id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->card_code; ?></td>
                        <td style='text-align: center;'><?php echo $v->mamber_type_name; ?></td>
                        <td style='text-align: center;'><?php echo $v->card_name; ?></td>
                        <td style='text-align: center;'><?php $up_type=array(648=>'X',649=>'√');echo $up_type[$v->up_type]; ?></td>
                        <td style='text-align: center;'><?php $if_project=array(648=>'X', 649=>'√'); echo $if_project[$v->if_project]; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->f_id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->f_id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

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
