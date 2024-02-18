
<div class="box">
    <div class="box-title c">
        <h1> <span>当前界面：战略伙伴 》战略伙伴设置 》战略伙伴类型设置</span> </h1>
        <span style="float:right;padding-right:15px;"> <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a> </span>
    </div> <!--box-title end-->
    <div class="box-content"> 
        <div class="box-header"> 
            <a class="btn" href="<?php echo $this->createUrl('create_zlhb');?>"><i class="fa fa-plus"></i>添加</a> 
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div>
    <!--box-header end--> 
    <div class="box-table">
      <table class="list" style="text-align:left;">
        <thead>
          <tr>
            <th width="20" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
            <th width="49" >序号</th>
            <th width="137"><?php echo $model->getAttributeLabel('member_type_code');?></th>
            <th width="140"><?php echo $model->getAttributeLabel('member_second_code');?></th>
            <th width="129"><?php echo $model->getAttributeLabel('if_project');?></th>
            <th width="81"><?php echo $model->getAttributeLabel('entry_way');?></th>
            <th width="103"><?php echo $model->getAttributeLabel('renew_time');?></th>
            <th width="103"><?php echo $model->getAttributeLabel('renew_notice_time');?></th>
            <th width="146">操作</th>
          </tr>
        </thead>
        <tbody>   
            <?php $index = 1;foreach($arclist as $v){?>
            <tr>
                <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->f_id); ?>"></td>
                <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                <td><?php echo $v->member_type_name;?></td>
                <td><?php echo $v->member_second_name;?></td>
                <td><?php echo $v->if_project_name;?></td>
                <td>
                    <?php 
                        $text='';
                        if(!empty($v->entry_way)){
                            $entry_ids = explode(',',$v->entry_way);
                            if(!empty($entry_ids))foreach($entry_ids as $s1){
                                $baseCode = BaseCode::model()->find('f_id='.$s1);
                                $text.=$baseCode->F_NAME.'、';
                            }
                            mb_internal_encoding("UTF-8");
                            $text=mb_substr($text, 0,-1);
                        }
                        echo $text;
                    ?>
                </td>
                <td ><?php echo $v->renew_time;?></td>
                <td ><?php echo $v->renew_notice_time;?></td>
                <td width="200px">
                    <?php echo show_command('修改',$this->createUrl('update_zlhb', array('id'=>$v->f_id))); ?>
                    <?php echo show_command('删除','\''.$v->f_id.'\''); ?>
                </td>
            </tr>
            <?php $index++; } ?>
            </tbody>
        </table>
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages);?></div>
    </div>
  <!--box-content end--> 
</div>
<!--box end--> 
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script> 
