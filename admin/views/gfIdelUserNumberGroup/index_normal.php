
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>普通号码列表</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
			<a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
				<label style="margin-right:20px;">
                    <span>是否分类：</span>
                    <select name="is_category">
                        <option value="">请选择</option>
						<option value="648"<?php if(Yii::app()->request->getParam('is_category')=="648"){?> selected<?php };?>>待分类</option>
						<option value="649"<?php if(Yii::app()->request->getParam('is_category')=="649"){?> selected<?php };?>>已分类</option>
					</select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号" oninput="value=value.replace(/[^\d]/g,'')">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th style='text-align: center;'>序号</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('number_length');?></th>
                        <th style='text-align: center;'>号码区间</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('nomal_count');?></th>
                        <th style='text-align: center;'>已注册数量</th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('create_time');?></th>
                        <th style='text-align: center;'>操作</th>
                    </tr>
                </thead>
                <tbody>
               
					<?php 
					$index = 1;
					foreach($arclist as $v){ 
					?>
                    <tr>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td style='text-align: center;'><?php echo $v->number_length; ?></td>
                        <td style='text-align: center;'><?php echo $v->number_range_start; ?>-<?php echo $v->number_range_end; ?></td>
                        <td style='text-align: center;'><?php echo $v->nomal_count; ?></td>
                        <td style='text-align: center;'><?php echo (($v->is_category)==649?(GfIdelUserAllNumber::model()->count('group_id='.$v->id .' and f_vip=0 and is_use=1')):"待分类"); ?></td>
                        <td style='text-align: center;'><?php echo $v->create_time; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('detail_normal', array('id'=>$v->id));?>">详情</a>
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
