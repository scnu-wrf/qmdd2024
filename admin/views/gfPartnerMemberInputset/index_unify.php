
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>成员入会固定模板设置</h1><span class="back"><a class="btn" href="javascript:;" onclick="we.back('<?php echo $this->createUrl('gfPartnerMemberSet/index'); ?>');"><i class="fa fa-reply"></i>返回</a></span></div><!--box-title end-->
    <div class="box-content">
        <div class="box-detail-tab" style="margin-top:10px;">
            <ul class="c">
                <li class="<?=$_REQUEST['type']==403?'current':'';?>"><a href="<?php echo $this->createUrl('index_unify',array('type'=>403));?>">个人</a></li>
                <li class="<?=$_REQUEST['type']==404?'current':'';?>"><a href="<?php echo $this->createUrl('index_unify',array('type'=>404));?>">单位</a></li>
            </ul>
        </div>
        <div class="box-header">
            <?=show_command('添加',$this->createUrl('create_unify',array('type'=>$_REQUEST['type'])),'添加')?>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->
        <!-- <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get"> -->
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <!-- <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" value="<?php //echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button> -->
            <!-- </form>
        </div>box-search end -->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <!-- <th>序号</th> -->
                        <th><?php echo $model->getAttributeLabel('type');?></th>
                        <th><?php echo $model->getAttributeLabel('attr_name');?></th>
                        <th><?php echo $model->getAttributeLabel('attr_input_type');?></th>
                        <th><?php echo $model->getAttributeLabel('attr_unit');?></th>
                        <th><?php echo $model->getAttributeLabel('attr_values');?></th>
                        <th><?php echo $model->getAttributeLabel('sort_order');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
<?php
$index = 1;
foreach($arclist as $v){
?>
                    <tr>
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <!-- <td><span class="num num-1"><?php //echo $index ?></span></td> -->
                        <td><?php echo $v->units->F_NAME; ?></td>
                        <td><?php echo $v->attr_name; ?></td>
                        <td><?php if($v->base_code!=null){ echo $v->base_code->F_NAME; } ?></td>
                        <td><?php echo $v->attr_unit; ?></td>
                        <td>
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
                        <td><?php echo $v->sort_order; ?></td>
                        <td>
                            <?php echo show_command('修改',$this->createUrl('update_unify', array('id'=>$v->id))); ?>
                            <?php echo show_command('删除','\''.$v->id.'\''); ?>

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
