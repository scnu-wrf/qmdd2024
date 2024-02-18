 <?php
    
    $type_id=Yii::app()->request->getParam('type_id');

     $f_data=MallAttributeType::model()->findAll  
            (array(
                
                'condition' => 'enabled=1',
                'order' => 'cat_name DESC',
            ));
   
?> 

<div class="box">

    <div class="box-title c"><h1><i class="fa fa-table"></i>商品属性</h1>
<!--     <span class="back"><a class="btn" href="javascript:;" onclick="we.back();"><i class="fa fa-reply"></i>返回</a></span> --> 

        <a class="btn" href="<?php echo $this->createUrl('mallAttributeType/index');?>" title="返回属性类型列表">属性类型</a>    
    </div><!--box-title end-->

    <div class="box-content">

        <div class="box-header">


            <a class="btn" href="<?php echo $this->createUrl('create', array('type_id'=>$type_id));?>" ><i class="fa fa-plus"></i>添加</a>

            <a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a>

            <a style="display:none;" id="j-delete" class="btn" href="javascript:;" onclick="we.dele(we.checkval('.check-item input:checked'), deleteUrl);"><i class="fa fa-trash-o"></i>删除</a>
        </div><!--box-header end-->


        <div class="box-search">
             <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">

               <label style="margin-right:20px;">
                    <span>按商品类型显示：</span>
                    <select  name="type_id">
                        <option value="">请选择</option>
                        <option value="所有商品类型">所有商品类型</option>
                        <?php foreach ($f_data as $v) {?>
                           <option value="<?php echo $v->cat_id;?>"<?php if($type_id!==null && $type_id!==''  && $type_id==$v->cat_id){?> selected<?php }?>><?php echo $v->cat_name;?></option>
                        <?php } ?>
                    </select>
                </label>




                <button id="b_chaxun" class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->


        <div class="box-table">
            <table class="list "  id="m_table">
                <thead>
                    <tr align="center">
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th width="4%">序号</th>
                        <th width="30%"><?php echo $model->getAttributeLabel('attr_name');?></th>
                        <th width="20%">商品类型</th>
                        <th width="20%"><?php echo $model->getAttributeLabel('attr_values');?></th>
                        <th width="10%"><?php echo $model->getAttributeLabel('sort_order');?></th>
                        
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
                        <td><?php echo $v->attr_name; ?></td>
                        <td><?php if($v->m_id!=null){ echo $v->m_id->cat_name; } ?></td>
                       
                        <td><?php echo $v->attr_values; ?></td>
                        <td><?php echo $v->sort_order; ?></td>

                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('attr_id'=>$v->attr_id));?>" title="编辑"><i class="fa fa-edit"></i></a>

                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->attr_id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

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