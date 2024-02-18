
<div class="box">
    <div class="box-title c">
        <h1>当前界面：商城》商品上架》<a class="nav-a">商品上架申请</a></h1>
        <span class="back"><a class="btn" href="javascript:;" onclick="we.reload();"><i class="fa fa-refresh"></i>刷新</a></span>
    </div><!--box-title end-->
    <div class="box-content">
    	<div class="box-header">
            <?php echo show_command('添加',$this->createUrl('create_supplier'),'新增方案'); ?>
            <?php echo show_command('批删除','','删除'); ?>
        </div><!--box-header end-->
        <div class="box-search">
            <form action="<?php echo Yii::app()->request->url;?>" method="get">
                <input type="hidden" name="r" value="<?php echo Yii::app()->request->getParam('r');?>">
                <input type="hidden" name="pricing" value="<?php echo Yii::app()->request->getParam('pricing');?>">
                <label style="margin-right:10px;">
                    	<span>状态：</span>
                		<?php echo downList($base_code,'f_id','F_NAME','state'); ?>
                </label>
                <label style="margin-right:10px;">
                    	<span>上下线状态：</span>
                    <select id="userstate" name="userstate">
                        <option value="">请选择</option>
                        <option value="649"<?php if(Yii::app()->request->getParam('userstate')!==null && Yii::app()->request->getParam('userstate')!==''  && Yii::app()->request->getParam('userstate')==649){?> selected<?php }?>>上线</option>
                        <option value="648"<?php if(Yii::app()->request->getParam('userstate')!==null && Yii::app()->request->getParam('userstate')!==''  && Yii::app()->request->getParam('userstate')==648){?> selected<?php }?>>下线</option>
                    </select>
                </label>
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
                    	<th class="check"><input id="j-checkall" class="input-check" type="checkbox"></th>
                        <th style='width:25px; text-align: center;'>序号</th>
                        <th width="10%"><?php echo $model->getAttributeLabel('event_code');?></th>
                        <th width="15%"><?php echo $model->getAttributeLabel('event_title');?></th>
                        <th><?php echo $model->getAttributeLabel('if_user_state');?></th>
                        <th>显示时间</th>
                        <th>销售时间</th>
                        <th><?php echo $model->getAttributeLabel('f_check');?></th>
                        <th style="width:70px;"><?php echo $model->getAttributeLabel('update_date');?></th>
                        <th style="text-align:center">操作</th>
                    </tr>
<?php $index = 1;
if(is_array($arclist)) foreach($arclist as $v){ ?>
                    <tr>
                    	<td class="check check-item"><input class="input-check" type="checkbox" value="<?php echo CHtml::encode($v->id); ?>"></td>
                        <td style='text-align: center;'><span class="num num-1"><?php echo ($pages->currentPage)*($pages->pageSize)+$index ?></span></td>
                        <td><?php echo $v->event_code; ?></td>
                        <td><?php echo $v->event_title; ?></td>
                        <td><?php if($v->if_user_state!=null){ $if_user_state=array(648=>'下线', 649=>'上线'); echo $if_user_state[$v->if_user_state]; } ?></td>
                        <td><?php echo $v->star_time; ?><br><?php echo $v->end_time; ?></td>
                        <td><?php echo $v->start_sale_time; ?><br><?php echo $v->down_time; ?></td>
                        <td><?php if($v->f_check!=null) echo $v->base_code->F_NAME; ?></td>
                        <td><?php echo $v->update_date; ?></td>
                        <td>
                            <?php if($v->f_check==721 || $v->f_check==373){?>
                        	<a class="btn" href="<?php echo $this->createUrl('update_supplier', array('id'=>$v->id));?>" title="编辑"><i class="fa fa-edit"></i></a>
                            <?php echo show_command('删除',$v->id); ?>
                            <?php } ?>
                            <?php if($v->f_check==371){?>
                            <a class="btn" href="<?php echo $this->createUrl('update_supplier_check', array('id'=>$v->id,'flag'=>'index'));?>" title="详情">查看</a>
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
