
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>客服组设置</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
			<a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
			<a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('group_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('problem_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('group_member');?></th>
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
                        <td style='text-align: center;'><?php echo $v->group_name; ?></td>
                        <td style='text-align: left;width:50%;'>
						<?php $ProblemType=GfCustomerProblemType::model()->findAll("find_in_set(id,'".$v->problem_type."')"); ?>
						<?php foreach($ProblemType as $m=>$n){?>
							<span style="margin: 0 5px;display: inline-block;"><?php echo $n->name;?></span>
						<?php }?>
						</td>
                        <td style='text-align: center;'><?php echo $v->group_member; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>">组成员</a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);">删除</a>
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
