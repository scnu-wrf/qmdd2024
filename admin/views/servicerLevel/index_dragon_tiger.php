
<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：会员 》龙虎会员管理 》龙虎会员等级设置</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div> <!--box-title end-->
    <div class="box-content"> 
        <div class="box-header"> 
            <a class="btn" href="<?php echo $this->createUrl('create_dragon_tiger');?>"><i class="fa fa-plus"></i>添加</a> 
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div>
    <!--box-header end--> 
    <div class="box-table">
      <table class="list" style="text-align:left;">
        <thead>
          <tr>
            <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
            <th>序号</th>
            <th colspan="2" style="text-align:center;"><?php echo $model->getAttributeLabel('member_type_id');?></th>
            <th><?php echo $model->getAttributeLabel('card_name');?></th>
            <th><?php echo $model->getAttributeLabel('card_score');?></th>
            <th><?php echo $model->getAttributeLabel('card_end_score');?></th>
            <th><?php echo $model->getAttributeLabel('card_xh');?></th>
            <th><?php echo $model->getAttributeLabel('card_level');?></th>
            <th>操作</th>
          </tr>
        </thead>
        <tbody>   
          <?php $index = 1;foreach($arclist as $v){?>
            <tr>
                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                <td><?php echo $v->member_type_name;?></td>
                <td><?php echo $v->member_second_name;?></td>
                <td><?php echo $v->card_name;?></td>
                <td><?php echo $v->card_score;?></td>
                <td><?php echo $v->card_end_score;?></td>
                <td ><?php echo $v->card_xh;?></td>
                <td ><?php echo $v->card_level;?></td>
                <td>
                    <?php echo show_command('修改',$this->createUrl('update_dragon_tiger', array('id'=>$v->id))); ?>
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