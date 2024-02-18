<?php

    $f_items=ProjectList::model()->findAll  
                (array(
                    'condition' => 'project_type=1',
                    // 'order' => 'project_name ASC',
                ));

    $f_star=MemberCard::model()->findAll();
                
?>


<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>导购设置</h1></div><!--box-title end-->
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
                    <span>项目：</span>
                    <select id="project_id" name="project_id">
                        <option value="">请选择</option>
                        <option value="所有项目">所有项目</option>
                        <?php foreach ($f_items as $v) {?>
                            <option value="<?php echo $v->id;?>"<?php if(Yii::app()->request->getParam('project_id')!==null && Yii::app()->request->getParam('project_id')!==''  && Yii::app()->request->getParam('project_id')==$v->id){?> selected<?php }?>><?php echo $v->project_name;?></option>
                        <?php } ?>
                    </select>
                </label>


               <label style="margin-right:20px;">
                    <span>等级：</span>
                    <select id="club_star" name="club_star">
                        <option value="">请选择</option>
                        <option value="所有等级">所有等级</option>
                        <?php foreach ($f_star as $v) {?>
                            <option value="<?php echo $v->f_id;?>"<?php if(Yii::app()->request->getParam('club_star')!==null && Yii::app()->request->getParam('club_star')!==''  && Yii::app()->request->getParam('club_star')==$v->f_id){?> selected<?php }?>><?php echo $v->card_name;?></option>
                        <?php } ?>
                    </select>
                </label>



                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->

        <div class="box-table">
            <table class="list">

               <thead>
                    <tr >
                        <th rowspan="2" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th rowspan="2">序号</th>
                        <th rowspan="2"><?php echo $model->getAttributeLabel('project_id');?></th>
                        <th rowspan="2">单位星级</th>
                        <th colspan="1">实物商品综合类</th>
                        <th colspan="2">实物商品专业类</th>
                        <th colspan="1">数字综合类</th>
                        <th colspan="2">数字专业类</th>
                        <th rowspan="2">操作</th>
                    </tr>
                    <tr align="center">
                      <th >导购窗口数量</th>
                      <th>导购窗口数量</th>
                      <th >单体窗口件数</th>
                      <th>导购窗口数量</th>
                      <th >导购窗口数量</th>
                      <th >单个窗口件数</th>
                    </tr>
                </thead>
                <tbody>
                
 
                    <?php 
                    $i=1; 
                    $index = 1;
                    foreach($arclist as $v){ ?>
                    <tr align="center">
                        <td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php if($v->p_id!=null){ echo $v->p_id->project_name; } ?></td>
                        <td><?php echo $v->club_star_name; ?></td>
                        <td><?php echo $v->synthesize_num; ?></td>
                        <td><?php echo $v->profession_num; ?></td>
                        <td><?php echo $v->single_profession_num; ?></td>
                        <td><?php echo $v->digital_synthesize_num; ?></td>
                        <td><?php echo $v->digital_profession_num; ?></td>
                        <td><?php echo $v->digital_single_profession_num; ?></td>               
                        <td>
                            
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id,'p_id'=>$v->project_id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>

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