<?php 
if (!isset($_REQUEST['club_news_id'])) {$_REQUEST['club_news_id']=0;}
$f_types=Basecode::model()->getCode(832);  
$f_items=Basecode::model()->getCode(835);  
?>
<div class="box">
    <div class="box-title c"><h1><i class="fa fa-table"></i>GFAPP列表</h1></div><!--box-title end-->
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
                        <input style="width:200px;" class="input-text" type="text" name="keywords" value="请输入应用名称/编号" onfocus="if (value =='请输入应用名称/编号'){value =''}"onblur="if (value ==''){value='请输入应用名称/编号'}" />

                </label>

               <label style="margin-right:20px;">
                    <span>按应用类型：</span>
                    <select id="type_name" name="type_name">
                        <option value="">请选择</option>
                        <option value="所有应用类型">所有应用类型</option>
                        <?php foreach ($f_types as $v) {?>
                            <option value="<?php echo $v->F_NAME;?>"><?php echo $v->F_NAME;?></option>
                        <?php } ?>
                    </select>
                </label>


               <label style="margin-right:20px;">
                    <span>按应用项目：</span>
                    <select id="item_name" name="item_name">
                        <option value="">请选择</option>
                        <option value="所有应用项目">所有应用项目</option>
                        <?php foreach ($f_items as $v) {?>
                            <option value="<?php echo $v->F_NAME;?>"><?php echo $v->F_NAME;?></option>
                        <?php } ?>
                    </select>
                </label>


                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->

        <div class="box-table">
            <table class="list">
                <thead>
                    <tr align="center">
                        <th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th>序号</th>
                        <th><?php echo $model->getAttributeLabel('app_code');?></th>
                        <th><?php echo $model->getAttributeLabel('app_name');?></th>
                        <th><?php echo $model->getAttributeLabel('app_type_name');?></th>
                        <th><?php echo $model->getAttributeLabel('app_item_name');?></th>
                        <th><?php echo $model->getAttributeLabel('add_time');?></th>
                        <th>操作</th>
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
                        <td><?php echo $v->app_code; ?></td>
                        <td><?php echo $v->app_name; ?></td>
                        <td><?php echo $v->app_type_name; ?></td>
                        <td><?php echo $v->app_item_name; ?></td>
                        <td><?php echo $v->add_time; ?></td>
                        <td>
                            <a class="btn" href="<?php echo $this->createUrl('update', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
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