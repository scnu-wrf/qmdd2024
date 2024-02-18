
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>录入属性列表</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gfPartnerMemberSet/index'); ?>');"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create', array('pid'=>$_REQUEST['pid'],'ptype'=>$_REQUEST['ptype']));?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
            <input style="display:none;" class="input-text" type="text" name="pid" value="<?php echo $_GET["pid"];?>">
            <input style="display:none;" class="input-text" type="text" name="ptype" value="<?php echo $_GET["ptype"];?>">
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
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('attr_name');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('attr_input_type');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('attr_unit');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('attr_values');?></th>
                        <th style='text-align: center;'><?php echo $model->getAttributeLabel('sort_order');?></th>
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
                        <td style='text-align: center;'><?php echo $v->attr_name; ?></td>
                        <td style='text-align: center;'><?php if($v->base_code!=null){ echo $v->base_code->F_NAME; } ?></td>
                        <td style='text-align: center;'><?php echo $v->attr_unit; ?></td>
                        <td style='text-align: center;'>
                            <?php
                                $number=GfPartnerMemberValues::model()->findAll('set_input_id='.$v->id);
                                if(!empty($number))foreach($number as $h){
                                    $agg=explode(',', $h->attr_values);
                                    foreach($agg as $k){
                                        echo $k.' ';
                                    }
                                }
                            ?>
                        </td>
                        <td style='text-align: center;'><?php echo $v->sort_order; ?></td>
                        <td style='text-align: center;'>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'pid'=>$_REQUEST['pid'],'ptype'=>$_REQUEST['ptype']));?>" title="编辑"><i class="fa fa-edit"></i></a>
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
