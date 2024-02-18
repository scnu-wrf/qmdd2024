
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>问题管理</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加问题</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
			<a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
						<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'>标准问法</th>
                        <th style='text-align: center;'>标准答案</th>
                        <th style='text-align: center;'>业务类型</th>
                        <th style='text-align: center;'>有效期</th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
               
					<?php 
					$index = 1;
					foreach($arclist as $v){ 
					?>
					<?php 
						if(!empty($v->r_adminid)){
							$sql="select u.ZSXM as admin_name,q.admin_gfaccount,q.admin_gfnick,q.last_login from gf_user_1 u,qmdd_administrators q where q.id=".$v->r_adminid." and q.admin_gfid=u.GF_ID";
							$server=Yii::app()->db->createCommand($sql)->queryRow();
						}
					?>
                    <tr>
						<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->problem_title; ?></td>
                        <td style='text-align: center;'><?php echo $v->reply_content; ?></td>
                        <td style='text-align: center;'></td>
                        <td style='text-align: center;'></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>">编辑</a>
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