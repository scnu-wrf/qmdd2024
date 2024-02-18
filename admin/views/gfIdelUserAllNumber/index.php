
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>号码生成</h1></div><!--box-title end-->
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
                    <span>号码类型：</span>
                    <select name="f_vip">
                        <option value="">请选择</option>
						<option value="0"<?php if(Yii::app()->request->getParam('f_vip')=="0"){?> selected<?php };?>>普通号码</option>
						<option value="1"<?php if(Yii::app()->request->getParam('f_vip')=="1"){?> selected<?php };?>>VIP号码</option>
					</select>
                </label>
				<label style="margin-right:20px;">
                    <span>VIP级别：</span>
                    <select name="f_vlevel">
                        <option value="">请选择</option>
						<?php 
							$viplev_list=GfIdelUserNumberLevel::model()->findAll();
							foreach($viplev_list as $k=>$v){
								?>
								<option value="<?php echo $v["id"]?>"<?php if(Yii::app()->request->getParam('f_vlevel')==$v["id"]){?> selected<?php };?>><?php echo $v["level_name"]?></option>
								<?php
							}
						?>
					</select>
                </label>
				<label style="margin-right:20px;">
                    <span>是否注册：</span>
                    <select name="is_use">
                        <option value="">请选择</option>
						<option value="0"<?php if(Yii::app()->request->getParam('is_use')=="0"){?> selected<?php };?>>未注册</option>
						<option value="1"<?php if(Yii::app()->request->getParam('is_use')=="1"){?> selected<?php };?>>已注册</option>
					</select>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>" placeholder="请输入账号">
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
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('account');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('main_number');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('secondary_number');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('f_vip');?></th>
                        <!--<th style='text-align: center;'>操作</th>-->
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
                        <td style='text-align: center;'><?php echo $v->account; ?></td>
                        <td style='text-align: center;'><?php echo $v->main_number; ?></td>
                        <td style='text-align: center;'><?php echo $v->secondary_number; ?></td>
                        <td style='text-align: center;'><?php echo ($v->f_vip==1) ? '是' : '否'; ?></td>
                        <!--<td style='text-align: center;'>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

                        </td>-->
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
