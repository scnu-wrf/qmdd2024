<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table">文章分类列表</i></h1></div>
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'),deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="news_type" value="<?php echo Yii::app()->request->getParam('news_type');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input type="checkbox" id="j-checkall" class="input-check"></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('cat_name');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('cat_type');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('cat_desc');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('sort_order');?></th>
                        <th style="text-align:center"><?php echo $model->getAttributeLabel('show_in_nav');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
                </thead>
                <tbody>
<?php 
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td class="check"><input type="checkbox" class="input-check" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center"><?php echo $v->cat_name; ?></td>
                        <td style="text-align:center"><?php echo $v->cat_type; ?></td>
                        <td style="text-align:center"><?php echo $v->cat_desc; ?></td>
                        <td style="text-align:center"><?php echo $v->sort_order; ?></td>
                        <td style="text-align:center"><?php echo $v->base_code->F_NAME; ?></td>
                        <td style="text-align:center">
                            <a class="btn" href="<?php echo $this->createUrl('index',array('type'=>$v->cat_type+1,'pid'=>$v->id));?>" title="子分类">子分类</a>
                            <a class="btn" href="<?php echo $this->createUrl('update',array('id'=>$v->id,'type'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i>编辑</a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>',deleteUrl);" title="删除"><i class="fa fa-trash-o"></i>编辑</a>
                        </td>
                    </tr>
<?php $index++;}?>
                </tbody>
            </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
    var deleteUrl = '<?php echo $this->createUrl('delete',array('id=>ID'));?>';
</script>