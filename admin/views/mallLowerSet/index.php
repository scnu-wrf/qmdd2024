
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品下架》<a class="nav-a">商品下架申请</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create',array('p_id'=>0)),'添加下架'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <label style="margin-right:10px;">
                    <span>关键字：</span>
                     <input style="width:200px;" class="input-text"  placeholder="请输入方案编码/标题" type="text" name="keywords" value="<?php echo Yii::app()->request->getParam('keywords');?>">
                </label>
                <button class="btn btn-blue" type="submit">查询</button>
            </form>
        </div><!--box-search end-->
        <div class="box-table">
        	<table class="list">
                	<tr class="table-title">
                        <th style="text-align:center;" class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style="text-align:center;width:25px;">序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('event_code');?></th>
                        <th width="15%"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th width="15%">下架商品</th>
                        <th><?php echo $model->getAttributeLabel('down_time');?></th>
                        <th><?php echo $model->getAttributeLabel('data_sourcer_bz');?></th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th><?php echo $model->getAttributeLabel('update_date');?></th>
                        <th>操作</th>
                    </tr>
<?php $index=1; foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style="text-align:center;"><span class="num num-1"><?php echo $index; ?></span></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td>
                    <?php $sale=MallPriceSetDetails::model()->findAll('set_id='.$v->id);
                    $sale_num=count($sale);
                    $sale_text='';
                    if($sale_num>3){
                        for($i=0;$i<3;$i++){
                        $sale_text.=$sale[$i]['product_name'].'<br>';
                        }
                        $sale_text.='...';
                    } else {
                        for($i=0;$i<$sale_num;$i++){
                        $sale_text.=$sale[$i]['product_name'].'<br>';
                        }
                    }
                            echo $sale_text; ?></td>
                        <td><?php echo $v->down_time; ?></td>
                        <td><?php echo $v->data_sourcer_bz; ?></td>
                        <td><?php echo $v->f_check_name; ?></td>
                        <td><?php echo $v->update_date; ?></td>
                        <td>
                            <?php if($v->f_check==721 || $v->f_check==373){
                                echo show_command('修改',$this->createUrl('update', array('id'=>$v->id))).' ';
                                echo show_command('删除',$v->id); 
                             } ?>
                            <?php if($v->f_check==371){?>
                            <a class="btn" href="<?php echo $this->createUrl('update_check', array('id'=>$v->id,'flag'=>'index'));?>" title="详情">查看</a>
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
</script>
