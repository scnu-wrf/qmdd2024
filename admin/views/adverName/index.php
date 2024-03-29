<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>广告位置列表</h1></div><!--box-title end-->
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
                        <th class="list-id"><?php echo $model->getAttributeLabel('id');?></th>
                        <th><?php echo $model->getAttributeLabel('adv_code');?></th>
                        <th><?php echo $model->getAttributeLabel('adv_name');?></th>
                        <th><?php echo $model->getAttributeLabel('how_long_dispay');?></th>
                        <th><?php echo $model->getAttributeLabel('dispay_time');?></th>
                        <th><?php echo $model->getAttributeLabel('dispay_num');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php foreach($arclist as $v){ ?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><?php echo CHtml::link(CHtml::encode($v->id), array('update', 'id'=>$v->id)); ?></td>
                        <td><?php echo $v->adv_code; ?></td>
                        <td><?php echo CHtml::link($v->adv_name, array('update', 'id'=>$v->id)); ?></td>
                        <!--td>此处少了PHP头标签，保留代码需要用时再添加 if(!empty($v->mall_product_data) && !empty($v->mall_product_data->mall_products)){ echo $v->mall_product_data->mall_products->name.'-'.$v->mall_product_data->json_attr; }?></td-->
                        <td><?php echo $v->how_long_dispay; ?></td>
                        <td><?php echo $v->dispay_time; ?></td>
                        <td><?php echo $v->dispay_num; ?></td>
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