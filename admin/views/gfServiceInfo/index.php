<div class="box">
    <div class="box-title c">
        <h1>当前界面：财务》毛利结算设置</h1>
        <span class="back">
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
        </span>
    </div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create'),'添加'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-table">
            <table class="list">
                <thead>
                    <tr>
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('code');?></th>
                        <th><?php echo $model->getAttributeLabel('type');?></th>
                        <th><?php echo $model->getAttributeLabel('product_id');?></th>
                        <th><?php echo $model->getAttributeLabel('gf_gross');?></th>
                        <th><?php echo $model->getAttributeLabel('club_gross');?></th>
                        <th><?php echo $model->getAttributeLabel('content');?></th>
                        <th><?php echo $model->getAttributeLabel('admin_gfnick');?></th>
                        <th><?php echo $model->getAttributeLabel('user_name');?></th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $index = 1; foreach($arclist as $v){ 
                    ?>
                        <tr>
                            <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                            <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                            <td><?php echo $v->code; ?></td>
                            <td>
                                <?php 
                                    if(!empty($v->type)){
                                        $text='';
                                        foreach(explode(",",$v->type) as $t){
                                            $type=MallProductsTypeSname::model()->find('id='.$t);
                                            $text.=$type->sn_name.'-';
                                        }
                                        echo rtrim($text, '-'); 
                                    }
                                ?>
                            </td>
                            <td><?php echo $v->product_code.'<br>'.$v->product_name.'<br>'.$v->json_attr; ?></td>
                            <td><?php echo floatval($v->gf_gross).'%'; ?></td>
                            <td><?php echo floatval($v->club_gross).'%'; ?></td>
                            <td><?php echo $v->content; ?></td>
                            <td><?php echo $v->admin_gfnick; ?></td>
                            <td><?php echo $v->user_name; ?></td>
                            <td>
                                <?php echo show_command('审核',$this->createUrl('update', array('id'=>$v->id,'disabled'=>'disabled'))); ?>
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