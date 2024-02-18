
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>商品类型</h1></div><!--box-title end-->
    <div class="box-content">
        <div class="box-header">
            <a class="btn" href="<?php echo $this->createUrl('create');?>"><i class="fa fa-plus"></i>添加</a>
            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>
            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->


        <div class="box-table">
            <table class="list">
                <thead>
                    <tr align="center">
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>                   
                        <th width="30%"><?php echo $model->getAttributeLabel('cat_name');?></th>
                        <th width="20%"><?php echo $model->getAttributeLabel('attr_group');?></th>
                        <th width="12%"><?php echo '属性数';?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('enabled');?></th>
                        
                        <th width="20%">操作</th>
                    </tr>
                </thead>
                <tbody>


                    <?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    
                    <tr align="center">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->cat_id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->cat_name; ?></td>
                        <td><?php echo $v->attr_group; ?></td>
                        <td><?php 
                            $n=MallAttributeInputSet::model()->count("cat_id=:cat_id",array(":cat_id"=>$v->cat_id)); 
                            echo $n; 
                            ?></td>
                        <td align="center"><?php
                              if ($v->enabled==1) {
                                echo "<span style='color:green;font-weight:bold'>√</span>";
                              } else {
                                echo "<span style='color:red;font-weight:bold'>X</span>";
                                
                              }
                            ?>
                        </td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('mallAttributeInputSet/index',array('type_id' => $v->cat_id,));?>" title="属性列表">属性列表</a>     
                            <a class="btn" href="<?php echo $this->createUrl('update', array('cat_id'=>$v->cat_id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->cat_id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

                        </td>
                    </tr>

                    <?php $i++; $index++;} ?>
                </tbody>
            </table>
        </div><!--box-table end-->                






        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
</script>