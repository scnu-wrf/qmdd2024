
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品发布》<a class="nav-a">非商城商品发布</a></h1>
        <span class="back"><a class="btn" href="<?php echo $this->createUrl('index');?>"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end--> 
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create_service', array('id'=>0)),'发布新商品'); ?>
            <button class="btn btn-blue" type="button" onclick="javascript:importfile()" >导入</button>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:20px;">
                    <span>类型：</span>
                    <?php echo downList($state,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                    <input style="width:200px;" class="input-text" type="text" name="keywords" placeholder="货号/型号/名称" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center; width:25px;">序号</th>
                        <th><?php echo $model->getAttributeLabel('product_ICO');?></th>
                        <th><?php echo $model->getAttributeLabel('supplier_code');?></th>
                        <th><?php echo $model->getAttributeLabel('name');?></th>
                        <th><?php echo $model->getAttributeLabel('json_attr');?></th>
                        <th><?php echo $model->getAttributeLabel('type');?></th>
                        <th><?php echo $model->getAttributeLabel('display');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('update');?></th>
                        <th>操作</th>
                    </tr>
<?php $index = 1; $basepath=BasePath::model()->getPath(115);
foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><a href="<?php echo  $basepath->F_WWWPATH.$v->product_ICO; ?>" target="_blank">
                        <img src="<?php echo  $basepath->F_WWWPATH.$v->product_ICO; ?>" style="max-height:50px; max-width:50px;">
                        </td>
                        <td><?php echo $v->supplier_code; ?></td>
                        <td><?php echo $v->name; ?></td>
                        <td><?php echo $v->json_attr; ?></td>
                        <td>
                        <?php if(!empty($v->type)){ 
                            $ptype=explode(',', $v->type);
                            if(!empty($ptype)) foreach($ptype as $t){
                                $types = MallProductsTypeSname::model()->find('tn_code="'.$t.'"');
                                if(!empty($types)) echo $types->sn_name.' ';   
                        }} ?>
                        </td>
                        <td><?php echo $v->display_name; ?></td>
                    
                        <td><?php echo $v->update; ?></td>
                        <td>
                            <?php if($v->display==721 || $v->display==373){ ?>
                        	<a class="btn" href="<?php echo $this->createUrl('update_service', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <a class="btn" href="javascript:;" onclick="we.dele('<?php echo $v->id;?>', deleteUrl);" title="删除"><i class="fa fa-trash-o"></i></a>
                        <?php } ?>
                            <?php if($v->display==371){ ?>
                            <a class="btn" href="<?php echo $this->createUrl('update_pass', array('id'=>$v->id,'flag'=>'index'));?>" title="详情">查看</a>
                            <a class="btn" href="javascript:;" onclick="we.cancel('<?php echo $v->id;?>', cancel);" title="撤销提交">撤销</a>
                        <?php } ?>
                        </td>
                    </tr>
<?php $index++; } ?>
                </table>
                 
        </div><!--box-table end-->
        <div class="box-page c"><?php $this->page($pages); ?></div>
    </div><!--box-content end-->
</div><!--box end-->
<script>
var deleteUrl = '<?php echo $this->createUrl('delete', array('id'=>'ID'));?>';
var cancel = '<?php echo $this->createUrl('cancelSubmit', array('id'=>'ID'));?>';

function importfile(){
        $.dialog.open('<?php echo $this->createUrl("upExcel");?>',{
            id:'sensitive',
            lock:true,
            opacity:0.3,
            title:'导入商品信息',
            width:'80%',
            height:'80%',
            close: function () {
                window.location.reload(true);
            }
        });
}
</script>
